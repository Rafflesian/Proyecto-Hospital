<?php 

namespace App\Enums;

enum StatusTypes: string
{
    case STATUS_IN_PROCESS = 'En Proceso';
    case STATUS_FINISHED = 'Finalizado';
    case STATUS_CANCELLED = 'Cancelado';
}

?>