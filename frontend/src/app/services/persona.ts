import { Injectable, inject } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import type { Persona } from '@dtypes/common';

import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class PersonaService {

  private http = inject(HttpClient);

  private readonly API_URL = environment.apiUrl + '/api/personas';

  getPersonas(): Observable<Persona[]> {
    return this.http.get<Persona[]>(this.API_URL);
  }

  getPersona(id: number): Observable<Persona> {
    return this.http.get<Persona>(`${this.API_URL}/${id}`);
  }

  crearPersona(data: Persona): Observable<Persona>
  {
    return this.http.put<Persona>(`${this.API_URL}`, data);
  }

  updatePersona(data: Persona): Observable<Persona>
  {
    return this.http.patch<Persona>(`${this.API_URL}`, data);
  }
}