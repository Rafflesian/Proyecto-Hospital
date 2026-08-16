<?php 

namespace App\Enums;

enum Gender: string
{
    case GENDER_MALE = "Masculino";
    case GENDER_FEMALE = "Femenino";
    case GENDER_OTHER = "Otro";
}

?>