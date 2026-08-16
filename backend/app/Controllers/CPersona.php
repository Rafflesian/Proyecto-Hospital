<?php

namespace App\Controllers;

use App\Models\Persona as PersonaModel;
use App\Entities\Persona as PersonaEntity;

use CodeIgniter\RESTful\ResourceController;
use Exception;

class CPersona extends ResourceController
{
    protected PersonaModel $pPersona;
    protected PersonaEntity $ePersona;

    public function __construct()
    {
        $this->pPersona = new PersonaModel();
        $this->ePersona = new PersonaEntity();
    }

    public function get_persona(int $id)
    {
        if(!is_numeric($id))
            return $this->respond(null, 404);

        $persona = $this->pPersona->find($id);

        if(empty($persona))
            return $this->respond(null, 404);

        return $this->respond($persona, 200);
    }

    public function get_personas()
    {
        $personas = $this->pPersona->findAll();
        return $this->respond($personas, 201);
    }

    public function insert_persona()
    {
        $data = $this->request->getJSON(true);
        $error = "";
        $db = \Config\Database::connect();

        try
        {
            $db->transBegin();
            $this->ePersona = $this->ePersona->clean($this->request->getMethod(), $data, $error);

            if($this->ePersona == null)
                throw new \Exception('Error al procesar datos ('. $error . ')');
            
            $this->pPersona->insert($this->ePersona);
            $persona_id = $this->pPersona->getInsertID();

            if($db->transStatus() === FALSE)
            {
                $error = $db->error()['message'];   
                throw new Exception('Error en la transacción ('. $error . ')');
            }

            $db->transCommit();

            return $this->respond([
                'success' => true,
                'data' => [
                    $this->pPersona,
                ]
            ], 201);
        }
        catch(\Throwable $e)
        {
            $db->transRollback();

            return $this->respond([
                'success' => false,
                'message' => $error != '' ? $error : 'Error en proceso de ingreso, intenta más tarde',
                'data_sent' => $data,
                'debug_object' => $this->ePersona,
                'debug_message' => $e->getMessage(),
                'debug_sql' => $this->pPersona->db->error(),
                'model_errors' => $this->pPersona->errors()
            ], 500);
        }
    }

    public function update_persona()
    {
        $data = $this->request->getJSON(true);
        $error = "";
        $db = \Config\Database::connect();

        try
        {
            $db->transBegin();
            $persona_id = $data['id'];
            
            // Persona
            $this->ePersona = $this->ePersona->clean($this->request->getMethod(), $data, $error);

            if($this->ePersona == null)
                throw new \Exception('Error al procesar datos ('. $error . ')');

            if(!$this->pPersona->update($persona_id, $this->ePersona))
                throw new \Exception('Error al actualizar persona');

            $db->transCommit();

            return $this->respond([
                'success' => true
            ], 201);
        }
        catch(\Throwable $e)
        {
            $db->transRollback();

            return $this->respond([
                'success' => false,
                'message' => $error != '' ? $error : 'Error en proceso de ingreso, intenta más tarde',
                'data_sent' => $data,
                'debug_object' => $this->ePersona,
                'debug_message' => $e->getMessage(),
                'debug_sql' => $this->pPersona->db->error(),
                'model_errors' => $this->pPersona->errors()
            ], 500);
        }
    }
}
?>