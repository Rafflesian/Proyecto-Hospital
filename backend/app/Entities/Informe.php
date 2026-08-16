<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

use App\Enums\StatusTypes;

class Informe extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    public function clean(string $method, array $input, string &$error): ?self
    {
        switch($method)
        {
            case 'PUT':
            {
                if(!empty($input['id']))
                {
                    $error = "El informe tiene un identificador";
                    return null;
                }
                
                break;
            }
            case 'PATCH':
            {
                if(empty($input['id']) || !is_numeric($input['id']))
                {
                    $error = "El identificador de informe no tiene un ID válido";
                    return null;
                }

                break;
            }
            case 'DELETE':
            {
                if(empty($input['id']) || !is_numeric($input['id']))
                {
                    $error = "El identificador de informe no tiene un ID válido";
                    return null;
                }

                $this->attributes['id'] = $input['id'];
                return $this;
            }
            default:
            {
                $error = "Informe: El método " . $method . " no tiene procesamiento";
                return null;
            }
        }

        $input['id_paciente'] = (int) $input['id_paciente'];

        if(empty($input['id_paciente']) || !is_numeric($input['id_paciente']))
        {
            $error = 'El ID de paciente en el informe es inválido';
            return null;
        }

        $input['id_emisor'] = (int) $input['id_emisor'];

        if(empty($input['id_emisor']) || !is_numeric($input['id_emisor']))
        {
            $error = 'El ID de emisor en el informe es inválido';
            return null;
        }

        $input['title'] = trim($input['title'] ?? null);

        if(empty($input['title']))
        {
            $error = 'El título de informe está vacío';
            return null;
        }

        $input['motivo'] = trim($input['motivo'] ?? null);

        if(empty($input['motivo']))
        {
            $error = 'El motivo de informe está vacío';
            return null;
        }

        $input['hallazgos'] = trim($input['hallazgos'] ?? null);

        if(empty($input['hallazgos']))
        {
            $error = 'El hallazgos del informe está vacío';
            return null;
        }

        $input['diagnosis'] = trim($input['diagnosis'] ?? null);

        if(empty($input['diagnosis']))
        {
            $error = 'El diagnosis del informe está vacío';
            return null;
        }

        $input['tratamiento'] = trim($input['tratamiento'] ?? null);

        if(empty($input['tratamiento']))
        {
            $error = 'El tratamiento del informe está vacío';
            return null;
        }

        $input['recomendaciones'] = trim($input['recomendaciones'] ?? null);

        if(empty($input['recomendaciones']))
        {
            $error = 'Las recomendaciones del informe está vacío';
            return null;
        }

        $input['observaciones'] = trim($input['observaciones'] ?? null);

        if(empty($input['observaciones']))
        {
            $error = 'Las observaciones del informe está vacío';
            return null;
        }

        if(StatusTypes::tryFrom($input['status']) == null)
        {
            $error = sprintf('El estado del informe \'%s\' es inválido', $input['status']);
            return null;
        }

        // Parseo
        foreach($input as $key => $value)
            $this->attributes[$key] = $value;

        return $this;
    } 
}
