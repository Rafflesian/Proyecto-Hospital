import { Component, inject, OnInit, signal } from '@angular/core';
import { FormControl, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { ActivatedRoute, Router, RouterLink } from '@angular/router';
import { PersonaService } from '@app/services/persona';
import { InformeService } from '@app/services/informe';

import { Informe, Persona, CASE_STATUS_VALUES, Case_Status } from '@dtypes/common';

@Component({
  selector: 'app-personas-informe',
  imports: [ReactiveFormsModule, RouterLink],
  templateUrl: './personas-informe.html',
  styleUrl: './personas-informe.css',
})
export class PersonasInforme implements OnInit
{
  private personaService = inject(PersonaService);
  private informeService = inject(InformeService);
  private route = inject(ActivatedRoute);
  private router = inject(Router);

  informe = signal<Informe | null>(null);
  persona = signal<Persona | null>(null);

  form = new FormGroup({
    id: new FormControl<number | null>(null),
    id_paciente: new FormControl<number | null>(null),
    id_emisor: new FormControl<number | null>(null),
    title: new FormControl<string>('', Validators.required),
    motivo: new FormControl<string>('', Validators.required),
    hallazgos: new FormControl<string>('', Validators.required),
    diagnosis: new FormControl<string>('', Validators.required),
    tratamiento: new FormControl<string>('', Validators.required),
    recomendaciones: new FormControl<string>('', Validators.required),
    observaciones: new FormControl<string>('', Validators.required),
    status: new FormControl<Case_Status>(CASE_STATUS_VALUES[0])
  })

  informe_id = signal<number | null>(null);
  persona_id = signal<number | null>(null);

  process_status = signal(CASE_STATUS_VALUES);
  
  ngOnInit(): void {
    const id = this.route.snapshot.paramMap.get('informe_id');
    const persona_id = this.route.snapshot.paramMap.get('persona_id');

    if(id !== null)
    {
      this.informe_id.set(Number(id));

      this.form.controls.id.setValue(this.informe_id(), { emitEvent: false });
      this.load_informe(this.informe_id() as number);
      return;
    }

    // Load persona then
    if(persona_id !== null)
    {
      this.persona_id.set(Number(persona_id));
      this.load_persona(this.persona_id() as number);
    }
  }

  private load_informe(informe_id: number)
  {
    this.informeService.getInforme(Number(informe_id)).subscribe({
      next: (informe_result) => {
        
        console.log(informe_result);
        this.informe.set(informe_result);

        this.form.patchValue({
          id: informe_result.id,
          id_paciente: informe_result.id_paciente,
          id_emisor: informe_result.id_emisor,
          title: informe_result.title,
          motivo: informe_result.motivo,
          hallazgos: informe_result.hallazgos,
          diagnosis: informe_result.diagnosis,
          tratamiento: informe_result.tratamiento,
          recomendaciones: informe_result.recomendaciones,
          observaciones: informe_result.observaciones,
          status: informe_result.status
        });

        this.persona_id.set(informe_result.id_paciente);

        // @ts-ignore
        this.persona.set({ nombres: informe_result.nombres });
      },
      error: (error) =>
      {
        console.error('Error al obtener persona:', error);
        this.router.navigate(['/personas']);
      }
    });
  }

  private load_persona(persona_id: number)
  {
    this.personaService.getPersona(persona_id).subscribe({
      next: (persona_result) => {
        this.persona.set(persona_result);

        this.form.patchValue({
          id_paciente: persona_result.id as number,
          id_emisor: persona_result.id as number
        });
      },
      error: (error) =>
      {
        console.error('Error al obtener persona:', error);
        this.router.navigate(['/personas']);
      }
    });
  }

  send_informe()
  {
    if (this.form.invalid)
    {
      this.form.markAllAsTouched();
      alert("Rellena los campos necesarios")
      return;
    }

    const input_data = this.form.getRawValue() as Informe;

    console.log("Send")
    this.send_data(input_data);
  }

  private send_data(data: Informe)
  {
    if(this.informe_id() != null)
    { 
      if(data.id != this.informe_id())
        return;

      this.informeService.updateInforme(data).subscribe({
        next: (informe) => {
          console.log('Informe actualizado: ', informe);
        },
        error: (error) => {
          console.log('Error al actualizar paciente: ', error);
        }
      });
    }
    else
    {
      this.informeService.crearInforme(data).subscribe({
        next: (informe) => {

          if(informe.success)
          {
            console.log('Informe creado: ', informe);
            this.informe_id.set(informe.data.id as number);

            alert("Informe creado");
          }
        },
        error: (error) =>
        {
          alert("Error al crear informe");
          console.log('Error al crear informe: ', error);
        }
      });
    }
  }
}
