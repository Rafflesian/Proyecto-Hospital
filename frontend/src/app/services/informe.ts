import { Injectable, inject } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import type { Persona, Informe, Result_Informe } from '@dtypes/common';

import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class InformeService
{
  private http = inject(HttpClient);
  private readonly API_URL = environment.apiUrl + '/api/informes';
  
  getInformesPersona(persona_id: number): Observable<Informe[]> {
    return this.http.get<Informe[]>(`${this.API_URL}/persona/${persona_id}`);
  }

  getInforme(id: number): Observable<Informe> {
    return this.http.get<Informe>(`${this.API_URL}/${id}`);
  }

  crearInforme(data: Informe): Observable<Result_Informe>
  {
    return this.http.put<Result_Informe>(`${this.API_URL}`, data);
  }

  updateInforme(data: Informe): Observable<Informe> {
    return this.http.patch<Informe>(`${this.API_URL}/`, data);
  }
}