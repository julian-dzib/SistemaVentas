import { Injectable } from '@angular/core';
import { BaseServiceService } from './base-service.service';
import { HttpClient } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class ClientServiceService {

  constructor(
    private baseService: BaseServiceService,
    private httpClient: HttpClient
  ) { }


  //Metodo para crear un cliente
  createClient(clientData: any):Observable<any> {
    const url = `${this.baseService.API_URL}/clients`;
    return this.httpClient.post(url, clientData).pipe(
      catchError((error: any) => {
        return throwError(error);
      })
    );
  }


  //Metodo para obtener todos los clientes de mi bd
  getClient(){
    return this.httpClient.get(`${this.baseService.API_URL}/clients`)
  }

  //Metodo para eliminar un cliente
  deleteClient(id: number): Observable<any> {
    const url = `${this.baseService.API_URL}/clients/${id}`;
    return this.httpClient.delete(url).pipe(
      catchError((error: any) => {
        return throwError(error);
      })
    );
  }
}
