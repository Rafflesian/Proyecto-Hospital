

export type Grupo_Sangre = 'A+' | 'A-' | 'B+' | 'B-' | 'AB+' | 'AB-' | 'O+' | 'O-';
export type Gender = 'Masculino' | 'Femenino' | 'Otro';
export type Citizenship = 'Chileno' | 'Otro';

export type Persona = 
{
    id?: number;
    tipo_documento: 'RUN' | 'RUN Provisorio' | 'Pasaporte' | 'Documento Extranjero' | 'Documento Provisorio';
    nro_documento: string;
    email?: string;
    telefono?: string;
    nombre: string;
    apellido_paterno: string;
    apellido_materno: string;
    direccion: string;
    nacionalidad: Citizenship;
    sexo: Gender;
    g_sangre: Grupo_Sangre;
}