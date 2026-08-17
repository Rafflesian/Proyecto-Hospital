import { Component, inject, OnInit, signal } from '@angular/core';
import { PersonaService } from '@services/persona';
import { RouterLink, ActivatedRoute, Router } from "@angular/router";
import { FormControl, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';

import { CITIZENSHIP_VALUES, type Grupo_Sangre, GRUPOS_SANGRE_VALUES, type Tipo_Documento, TIPO_DOCUMENTO_VALUES } from "@dtypes/common";
import { type Citizenship, type Gender, GENDER_VALUES, type Persona } from "@dtypes/common";

@Component({
  selector: 'app-personas-form',
  standalone: true,
  imports: [ReactiveFormsModule, RouterLink],
  templateUrl: './personas-form.html',
  styleUrl: './personas-form.css',
})
export class PersonasForm implements OnInit
{
  private personaService = inject(PersonaService);
  private route = inject(ActivatedRoute);
  private router = inject(Router);

  persona = signal<Persona | null>(null);
  form = new FormGroup({
    id: new FormControl<number | null>(null),
    tipo_documento: new FormControl<Tipo_Documento | null>(null, Validators.required),
    nro_documento: new FormControl<string | null>(null, Validators.required),
    nombres: new FormControl<string | null>(null, Validators.required),
    telefono: new FormControl<string | null>(null, Validators.required),
    email: new FormControl<string | null>(null),
    apellido_paterno: new FormControl<string | null>(null, Validators.required),
    apellido_materno: new FormControl<string | null>(null, Validators.required),
    direccion: new FormControl<string | null>(null, Validators.required),
    g_sangre: new FormControl<Grupo_Sangre | null>(null, Validators.required),
    sexo: new FormControl<Gender | null>(null, Validators.required),
    nacionalidad: new FormControl<Citizenship | null>(null, Validators.required)
  });

  persona_id = signal<number | null>(null);
  grupo_sangre = signal(GRUPOS_SANGRE_VALUES);
  tipo_documento = signal(TIPO_DOCUMENTO_VALUES);
  gender = signal(GENDER_VALUES);
  citizenship = signal(CITIZENSHIP_VALUES);

  ngOnInit(): void
  {
    const id = this.route.snapshot.paramMap.get('id');

    if(id !== null)
    {
      this.persona_id.set(Number(id));
      this.form.controls.id.setValue(this.persona_id(), { emitEvent: false });
    }

    this.form.controls.sexo.setValue(GENDER_VALUES[0], { emitEvent: false });
    this.form.controls.nacionalidad.setValue(CITIZENSHIP_VALUES[0], { emitEvent: false });
    this.form.controls.g_sangre.setValue(GRUPOS_SANGRE_VALUES[0], { emitEvent: false });
    this.form.controls.tipo_documento.setValue(TIPO_DOCUMENTO_VALUES[0], { emitEvent: false });

    this.form.controls.nro_documento.valueChanges.subscribe(value => {
      const clean = this.format_rut(value ?? '');

      this.form.controls.nro_documento.setValue(clean, {
        emitEvent: false
      });
    });

    this.form.controls.telefono.valueChanges.subscribe(value => {
      const clean = this.format_phone(value ?? '');
      this.form.controls.telefono.setValue(clean, { emitEvent: false });
    });

    if(id !== null)
      this.load(Number(id));
  }

  private format_rut(value: string): string
  {
    let rut = value
    .replace(/[^0-9kK]/g, '')
    .toUpperCase();

    if (rut.length < 2)
      return rut;

    const dv = rut.slice(-1);
    let cuerpo = rut.slice(0, -1);

    cuerpo = cuerpo.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

    return `${cuerpo}-${dv}`;
  }

  private format_phone(value: string): string
  {
    return value
    .replace(/[^\d+]/g, '')
    .replace(/(?!^)\+/g, '');
  }

  private format_default(value: string): string
  {
    value = value.trimEnd();
    return value;
  }

  send_form()
  {
    if (this.form.invalid)
    {
      this.form.markAllAsTouched();
      alert("Rellena los campos necesarios")
      return;
    }

    const input_data = this.form.getRawValue() as Persona;
    this.send_data(input_data);
  }

  private load(id: number): void
  {
    this.personaService.getPersona(Number(id)).subscribe({
      next: (persona_result) => {
        
        this.persona.set(persona_result);

        this.form.patchValue({
          id: persona_result.id,
          nro_documento: persona_result.nro_documento,
          tipo_documento: persona_result.tipo_documento,
          nombres: persona_result.nombres,
          apellido_paterno: persona_result.apellido_paterno,
          apellido_materno: persona_result.apellido_materno,
          email: persona_result.email,
          telefono: persona_result.telefono,
          direccion: persona_result.direccion,
          g_sangre: persona_result.g_sangre,
          sexo: persona_result.sexo,
          nacionalidad: persona_result.nacionalidad
        });

      },
      error: (error) =>{
        console.error('Error al obtener persona:', error);
        this.router.navigate(['/personas']);
      }
    });
  }

  private send_data(data: Persona): void
  {
    if(this.persona_id() != null)
    {
      this.personaService.updatePersona(data).subscribe({
        next: (persona) => {
          console.log('Paciente actualizado: ', persona);
        },
        error: (error) => {
          console.log('Error al actualizar paciente: ', error);
        }
      });
    }
    else
    {
      this.personaService.crearPersona(data).subscribe({
        next: (persona_result) => {
          if(persona_result.success)
          {
            console.log('Persona creada: ', persona_result);
            this.persona_id.set(persona_result.data.id as number);
            this.persona.set(persona_result.data);
          }
        },
        error: (error) => {
          console.log('Error al crear persona: ', error);
        }
      });
    }
  }
}
