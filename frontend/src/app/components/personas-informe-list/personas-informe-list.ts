import { Component, inject, OnInit, signal } from '@angular/core';
import { ActivatedRoute, RouterLink } from '@angular/router';
import { InformeService } from '@app/services/informe';
import { Informe } from '@dtypes/common';


@Component({
  selector: 'app-personas-informe-list',
  imports: [RouterLink],
  templateUrl: './personas-informe-list.html',
  styleUrl: './personas-informe-list.css',
})
export class PersonasInformeList implements OnInit
{
  private informeService = inject(InformeService);
  private route = inject(ActivatedRoute);

  persona_id = signal<number | null>(null);
  informe_list = signal<Informe[]>([]);

  ngOnInit(): void
  {
    const id = this.route.snapshot.paramMap.get('id');

    if(id !== null)
    {
      this.persona_id.set(Number(id));
      this.load(this.persona_id() as number);
      return;
    }
  }

  private load(persona_id: number)
  {
    this.informeService.getInformesPersona(persona_id).subscribe({
      next: (value) =>
      {
        this.informe_list.set(value);
      },
      error: (error) => 
      {
        console.log(`Error al obtener informes: ${error}`);
      }
    })
  }
}
