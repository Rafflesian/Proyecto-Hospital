<?php

namespace App\Controllers;

use App\Models\Informe;
use CodeIgniter\RESTful\ResourceController;
use Exception;

class CInforme extends ResourceController
{
    protected Informe $pInforme;

    public function __construct()
    {
        $this->pInforme = new Informe();
    }

    public function insert_informe()
    {
        $data = $this->request->getJSON(true);
        $error = "";
        $db = \Config\Database::connect();

        try
        {
            $db->transBegin();
            $this->pInforme = $this->pInforme->clean($this->request->getMethod(), $data['informe'], $error);

            if($this->pInforme == null)
                throw new Exception($error);

            $this->pInforme->insert($this->pInforme->attributes);
            $informe_id = $this->pInforme->id;

            if ($db->transStatus() === false)
                throw new Exception($error);

            $db->transCommit();

            return $this->respond([
                'success' => true,
                'data' => [
                    'id' => $informe_id,
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