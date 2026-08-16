<?php 

namespace App\Enums;

enum IdentifierTypes: string
{
    case ID_RUN         = 'RUN';
    case ID_RUN_TEMP    = 'RUN Provisorio';
    case ID_PASAPORTE   = 'Pasaporte';
    case ID_DNI         = 'Documento Extranjero';
    case ID_NIP         = 'Documento Provisiorio';   
}

?>