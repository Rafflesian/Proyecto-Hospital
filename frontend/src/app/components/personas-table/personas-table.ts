import { Component, inject, Input, OnInit, signal } from '@angular/core';
import { type Persona } from "@dtypes/common";
import { PersonaService } from '@services/persona';

@Component({
  selector: 'app-personas-table',
  imports: [],
  standalone: true,
  templateUrl: './personas-table.html',
  styleUrl: './personas-table.css',
})
export class PersonasTable implements OnInit
{
  private personaService = inject(PersonaService);
  personas = signal<Persona[]>([]);

  ngOnInit(): void {
    this.load();

    console.log("loaded");
  }

  private load(): void
  {
    this.personaService.getPersonas().subscribe({
      next: (response_personas) => {
        this.personas.set(response_personas);
        console.log(response_personas);
      },
      error: (error) => {
        console.error('Error al obtener personas: ', error);
      }
    });
  }
}
