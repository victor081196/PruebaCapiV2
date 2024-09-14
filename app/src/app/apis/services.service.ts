import { HttpClient, HttpParams } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ServicesService {

  private apiUrl = 'http://127.0.0.1:8000/api';  // URL de tu API Laravel

  constructor(private http: HttpClient) { }

  getContactos(): Observable<any> {
    return this.http.get<any>(`${this.apiUrl}/contactos`);
  }
  createContactForm(data: any): Observable<any> {
    return this.http.post<any>(this.apiUrl + '/contactos/create', data);
  }
  createDatosForm(data: any): Observable<any> {
    return this.http.post<any>(this.apiUrl + '/contactos/datos/create', data);
  }
  getContactById(id: number): Observable<any> {
    return this.http.get<any>(`${this.apiUrl}/contactos/get/${id}`);
  }
  deleteContact(data: any): Observable<any> {
    return this.http.post<any>(this.apiUrl + '/contactos/delete', data);
  }
  buscarContactos(query: string): Observable<any[]> {
    const params = new HttpParams().set('q', query);
    return this.http.get<any[]>(this.apiUrl + '/contactos/search', { params });
  }
}
