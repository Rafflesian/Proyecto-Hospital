<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

use App\Enums\Citizenship;
use App\Enums\BloodType;
use App\Enums\Gender;
use App\Enums\IdentifierTypes;

class Persona extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    public function clean(string $method, array $input, ?string &$error): ?self
    {
        switch($method)
        {
            case 'PUT':
            {
                if(!empty($input['id']))
                {
                    $error = "La persona a crear tiene una ID declarada";
                    return null;
                }

                break;
            }
            case 'PATCH':
            {
                if(empty($input['id']) || !is_numeric($input['id']))
                {
                    $error = "La persona no tiene un ID válido";
                    return null;
                }

                break;
            }
            case 'DELETE':
            {
                if(empty($input['id']) || !is_numeric($input['id']))
                {
                    $error = "La persona no tiene un ID válido";
                    return null;
                }

                $this->attributes['id'] = $input['id'];
                return $this;
            }
            default:
            {
                $error = "Persona: El método " . $method . " no tiene procesamiento";
                return null;
            }
        }

        // Forceo de mayus
        $input['nombres'] = trim($input['nombres'] ?? null);

        if(empty($input['nombres']))
        {
            $error = 'Nombre vacío';
            return null;
        }

        $input['nombres'] = mb_convert_case(mb_strtolower($input['nombres'], 'UTF-8'), MB_CASE_TITLE, 'UTF-8');

        // 
        $input['apellido_paterno'] = trim($input['apellido_paterno'] ?? null);

        if(empty($input['apellido_paterno']))
        {
            $error = 'Apellido Paterno vacío';
            return null;
        }

        $input['apellido_paterno'] = ucfirst($input['apellido_paterno']);

        // 
        $input['apellido_materno'] = trim($input['apellido_materno'] ?? null);

        if(empty($input['apellido_materno']))
        {
            $error = 'Apellido Materno vacío';
            return null;
        }

        $input['apellido_materno'] = ucfirst($input['apellido_materno']);

        //
        $input['direccion'] = trim($input['direccion'] ?? null);

        if(empty($input['direccion']))
        {
            $error = 'Dirección vacía';
            return null;
        }

        if(Citizenship::tryFrom($input['nacionalidad']) == null)
        {
            $error = 'Nacionalidad errónea para registro';
            return null;   
        }

        if(Gender::tryFrom($input['sexo']) == null)
        {
            $error = 'Genéro no admitido para registro';
            return null;
        }

        if(BloodType::tryFrom($input['g_sangre']) == null)
        {
            $error = 'Tipo de sangre \'' . $input['g_sangre'] . '\' desconocido';
            return null;
        }

        // Validación identificador
        $id_type = IdentifierTypes::tryFrom($input['tipo_documento']);

        switch($id_type)
        {
            case IdentifierTypes::ID_RUN:
            case IdentifierTypes::ID_RUN_TEMP:
            {
                if(!$this->validate_run($input['nro_documento']))
                {
                    $error = 'El RUT \'' . $id_type . '\' no se puede procesar aún';
                    return null;
                }

                break;
            }
            default:
            {
                if($id_type == null)
                    $error = 'Identificador inválido \'' . $input['nro_documento'] . '\'';
                else
                    $error = 'El identificador \'' . $id_type . '\' no se puede procesar aún';

                return null;
            }
        }

        // Opcional
        $input['email'] = trim($input['email'] ?? null);

        // Asignación
        foreach($input as $key => $value)
            $this->attributes[$key] = $value;
        
        return $this;
    }

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
}
