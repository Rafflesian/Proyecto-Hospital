<?php

namespace App\Controllers;

use App\Models\Persona;
use CodeIgniter\RESTful\ResourceController;
use Exception;

class CPersona extends ResourceController
{
    protected Persona $pPersona;

    public function __construct()
    {
        $this->pPersona = new Persona();
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

            // Persona
            $this->pPersona = $this->pPersona->clean($this->request->getMethod(), $data['persona'], $error);

            if($this->pPersona == null)
                throw new \Exception($error);
            
            $this->pPersona->insert($this->pPersona->attributes);
            $persona_id = $this->pPersona->insert_id();

            if($db->transStatus() === FALSE)
                throw new Exception('Error en la transacción');

            $db->transCommit();

            return $this->respond([
                'success' => true,
                'data' => [
                    'id' => $persona_id,
                ]
            ], 201);
        }
        catch(\Throwable $e)
        {
            $db->transRollback();

            return $this->respond([
                'success' => false,
                'message' => $error ?? 'Error en datos de ingreso, intenta más tarde',
                'debug_message' => $e->getMessage()
            ], 500);
        }
    }
}
?>