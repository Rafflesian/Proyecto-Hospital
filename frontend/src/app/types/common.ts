

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

export const GENDER = {
    GENDER_MALE: 'Masculino',
    GENDER_FEMALE: 'Femenino',
    GENDER_OTHER: 'Otro'
} as const;
export type Gender = typeof GENDER[keyof typeof GENDER];
export const GENDER_VALUES = Object.values(GENDER);

export const CITIZENSHIP = {
    CTZ_LOCAL: 'Chileno',
    CTZ_OTHER: 'Otro'
} as const;
export type Citizenship = typeof CITIZENSHIP[keyof typeof CITIZENSHIP];
export const CITIZENSHIP_VALUES = Object.values(CITIZENSHIP);

export const CASE_STATUS = {
    CASE_STATUS_IN_PROGRESS: 'En Proceso',
    CASE_STATUS_FINISHED: 'Finalizado',
    CASE_STATUS_CANCELLED: 'Cancelado'
} as const;
export type Case_Status = typeof CASE_STATUS[keyof typeof CASE_STATUS];
export const CASE_STATUS_VALUES = Object.values(CASE_STATUS);

export type ResultPut<T> = 
{
    success: boolean,
    data: T;
}

export type Persona = 
{
    id?: number;
    tipo_documento: Tipo_Documento;
    nro_documento: string;
    email?: string;
    telefono?: string;
    nombres: string;
    apellido_paterno: string;
    apellido_materno: string;
    direccion: string;
    nacionalidad: Citizenship;
    sexo: Gender;
    g_sangre: Grupo_Sangre;
}

export type Result_Persona = ResultPut<Persona>;

export type Informe = 
{
    id?: number;
    id_paciente: number;
    id_emisor: number;
    title: string;
    motivo: string;
    hallazgos: string;
    diagnosis: string;
    tratamiento: string;
    recomendaciones: string;
    observaciones: string;
    status: Case_Status;
}
export type Result_Informe = ResultPut<Informe>;