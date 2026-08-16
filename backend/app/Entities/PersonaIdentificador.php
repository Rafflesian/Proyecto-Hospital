<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

use App\Enums\IdentifierTypes;

class PersonaIdentificador extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    public function validate_run(string $rut): bool
    {
        $rut = strtoupper(str_replace(['.', '-'], '', trim($rut)));

        if (!preg_match('/^\d{7,8}[\dK]$/', $rut)) {
            return false;
        }

        $dv = substr($rut, -1);
        $numero = substr($rut, 0, -1);

        $suma = 0;
        $multiplicador = 2;

        for ($i = strlen($numero) - 1; $i >= 0; $i--) {
            $suma += (int)$numero[$i] * $multiplicador;

            $multiplicador++;

            if ($multiplicador > 7) {
                $multiplicador = 2;
            }
        }

        $resto = $suma % 11;
        $resultado = 11 - $resto;

        $dvCalculado = match ($resultado) {
            11 => '0',
            10 => 'K',
            default => (string)$resultado,
        };

        return $dv === $dvCalculado;
    }

    public function clean(string $method, array $input, ?string &$error): ?self
    {
        switch($method)
        {
            case 'PUT':
            {
                if(!empty($input['id']))
                {
                    $error = "El identificador de persona tiene una ID declarada";
                    return null;
                }

                break;
            }
            case 'PATCH':
            {
                if(empty($input['id']) || !is_numeric($input['id']))
                {
                    $error = "El identificador de persona no tiene un ID válido";
                    return null;
                }

                break;
            }
            case 'DELETE':
            {
                if(empty($input['id']) || !is_numeric($input['id']))
                {
                    $error = "El identificador de persona no tiene un ID válido";
                    return null;
                }

                $this->attributes['id'] = $input['id'];
                return $this;
            }
            default:
            {
                $error = "Identificador: El método " . $method . " no tiene procesamiento";
                return null;
            }
        }

        // Validación identificador
        $id_type = IdentifierTypes::tryFrom($input['tipo']);

        switch($id_type)
        {
            case IdentifierTypes::ID_RUN:
            case IdentifierTypes::ID_RUN_TEMP:
            {
                if(!$this->validate_run($input['tipo']))
                {
                    $error = 'El RUT \'' . $id_type . '\' no se puede procesar aún';
                    return null;
                }

                break;
            }
            default:
            {
                if($id_type == null)
                    $error = 'Identificador inválido \'' . $input['tipo'] . '\'';
                else
                    $error = 'El identificador \'' . $id_type . '\' no se puede procesar aún';

                return null;
            }
        }

        // Asignación
        foreach($input as $key => $value)
            $this->attributes[$key] = $value;

        return $this;
    }
}
