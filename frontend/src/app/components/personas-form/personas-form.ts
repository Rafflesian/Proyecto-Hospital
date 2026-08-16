import { Component, inject, OnInit, signal } from '@angular/core';
import { type Persona } from "@dtypes/common";
import { PersonaService } from '@services/persona';
import { RouterLink, ActivatedRoute } from "@angular/router";
import { FormControl, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { type Grupo_Sangre, GRUPOS_SANGRE_VALUES, type Tipo_Documento, TIPO_DOCUMENTO_VALUES } from "@dtypes/common";

@Component({
  selector: 'app-personas-form',
  imports: [],
  templateUrl: './personas-form.html',
  styleUrl: './personas-form.css',
})
export class PersonasForm implements OnInit
{
  private personaService = inject(PersonaService);
  private route = inject(ActivatedRoute);

  persona = signal<Persona | null>(null);
  form = new FormGroup({
    tipo_documento: new FormControl<Tipo_Documento | null>(null),
    nro_documento: new FormControl<string | null>(null),
    nombre: new FormControl<string | null>(null),
    apellido_paterno: new FormControl<string | null>(null),
    apellido_materno: new FormControl<string | null>(null),
    email: new FormControl<string | null>(null),
    grupo_sangre: new FormControl<Grupo_Sangre | null>(null),
  });

  is_edit = signal(false);
  grupo_sangre = signal(GRUPOS_SANGRE_VALUES);
  tipo_documento = signal(TIPO_DOCUMENTO_VALUES);

  ngOnInit(): void {
    const id = this.route.snapshot.paramMap.get('id');
    this.is_edit.set(id !== null);

    if(id !== null)
      this.load(Number(id));
  }

  private load(id: number): void
  {
    this.personaService.getPersona(Number(id)).subscribe({
      next: (persona_result) => {
        this.persona.set(persona_result);
      },
      error: (error) => {
        console.error('Error al obtener persona:', error);
      }
    });
  }
}
