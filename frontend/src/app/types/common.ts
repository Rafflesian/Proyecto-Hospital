

export const GRUPOS_SANGRE = {
  A_POSITIVO: 'A+',
  A_NEGATIVO: 'A-',
  B_POSITIVO: 'B+',
  B_NEGATIVO: 'B-',
  AB_POSITIVO: 'AB+',
  AB_NEGATIVO: 'AB-',
  O_POSITIVO: 'O+',
  O_NEGATIVO: 'O-'
} as const;
export type Grupo_Sangre = typeof GRUPOS_SANGRE[keyof typeof GRUPOS_SANGRE];
export const GRUPOS_SANGRE_VALUES = Object.values(GRUPOS_SANGRE);

export const TIPO_DOCUMENTO = {
    DOC_RUN: 'RUN',
    DOC_RUN_TEMP: 'RUN Provisorio',
    DOC_PASSPORT: 'Pasaporte',
    DOC_EXTERNAL: 'Documento Extranjero',
    DOC_TEMP: 'Documento Provisorio',
} as const;
export type Tipo_Documento = typeof TIPO_DOCUMENTO[keyof typeof TIPO_DOCUMENTO];
export const TIPO_DOCUMENTO_VALUES = Object.values(TIPO_DOCUMENTO);

export type Gender = 'Masculino' | 'Femenino' | 'Otro';
export type Citizenship = 'Chileno' | 'Otro';

export type Persona = 
{
    id?: number;
    tipo_documento: Tipo_Documento;
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