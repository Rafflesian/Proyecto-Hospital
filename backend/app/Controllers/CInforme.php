<?php

namespace App\Controllers;

use App\Models\Informe as InformeModel;
use App\Models\Persona as PersonaModel;
use App\Entities\Informe as InformeEntity;

use CodeIgniter\RESTful\ResourceController;
use Exception;

class CInforme extends ResourceController
{
    protected InformeModel $pInforme;
    protected PersonaModel $pPersona;
    protected InformeEntity $eInforme;

    public function __construct()
    {
        $this->pInforme = new InformeModel();
        $this->pPersona = new PersonaModel();
        $this->eInforme = new InformeEntity();
    }

    public function get_informe(int $informe_id)
    {
        if(!is_numeric($informe_id))
            return $this->respond(null, 404);

        $informe = $this->pInforme->select(['informes.*', 'personas.nombres'])
        ->join('personas', 'personas.id = informes.id_paciente')->where('informes.id', $informe_id)->first();

        if(empty($informe))
            return $this->respond(null, 404);

        return $this->respond($informe, 200);
    }

    public function get_informe_persona(int $persona_id)
    {
        if(!is_numeric($persona_id))
            return $this->respond(null, 404);

        $persona = $this->pPersona->find($persona_id);

        if(empty($persona))
            return $this->respond(null, 404);

        $informes = $this->pInforme->where('id_paciente', $persona_id)->findAll();
        return $this->respond($informes, 200);
    }

    public function insert_informe()
    {
        $data = $this->request->getJSON(true);
        $error = "";
        $db = \Config\Database::connect();

        try
        {
            $db->transBegin();
            $this->eInforme = $this->eInforme->clean($this->request->getMethod(), $data, $error);

            if($this->eInforme == null)
                throw new \Exception('Error al procesar datos ('. $error . ')');

            $this->pInforme->insert($this->eInforme);
            $informe_id = $this->pInforme->getInsertID();

            if ($db->transStatus() === FALSE)
            {
                $error = $db->error()['message'];
                throw new Exception('Error en la transacción ('. $error . ')');
            }
            
            $data['id'] = $informe_id;
            $db->transCommit();

            return $this->respond([
                'success' => true,
                'data' => $data,
            ], 201);
        }
        catch(\Throwable $e)
        {
            $db->transRollback();

            return $this->respond([
                'success' => false,
                'message' => $error != '' ? $error : 'Error en proceso de ingreso, intenta más tarde',
                'data_sent' => $data,
                'debug_object' => $this->eInforme,
                'debug_message' => $e->getMessage(),
                'model_errors' => $this->pInforme->errors()
            ], 500);
        }
    }

    public function update_informe()
    {
        $data = $this->request->getJSON(true);
        $error = "";
        $db = \Config\Database::connect();

        try
        {
            $db->transBegin();
            $informe_id = $data['id'];
            $this->eInforme = $this->eInforme->clean($this->request->getMethod(), $data, $error);

            if($this->eInforme == null)
                throw new \Exception('Error al procesar datos ('. $error . ')');
            
            if(!$this->pInforme->update($informe_id, $this->eInforme))
                throw new \Exception('Error al actualizar informe');

            $db->transCommit();

            return $this->respond([
                'success' => true,
                'data' => $data
            ], 201);
        }
        catch(\Throwable $e)
        {
            $db->transRollback();

            return $this->respond([
                'success' => false,
                'message' => $error != '' ? $error : 'Error en proceso de ingreso, intenta más tarde',
                'data_sent' => $data,
                'debug_object' => $this->eInforme,
                'debug_message' => $e->getMessage(),
                'model_errors' => $this->pInforme->errors()
            ], 500);
        }
    }
}

?>