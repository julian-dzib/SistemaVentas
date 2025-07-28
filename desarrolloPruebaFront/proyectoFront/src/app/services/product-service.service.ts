import { Injectable } from '@angular/core';
import { BaseServiceService } from './base-service.service';
import { HttpClient } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class ProductServiceService {

  constructor(
    private baseService: BaseServiceService,
    private httpClient: HttpClient
  ) { }


    //Metodo para crear un producto
    createProduct(clientData: any):Observable<any> {
      const url = `${this.baseService.API_URL}/products`;
      return this.httpClient.post(url, clientData).pipe(
        catchError((error: any) => {
          return throwError(error);
        })
      );
    }


    //Metodo para obtener todos los productos de mi bd
    getProduct(){
      return this.httpClient.get(`${this.baseService.API_URL}/products`)
    }

    //Metodo para eliminar un producto
    deleteProduct(id: string): Observable<any> {
      const url = `${this.baseService.API_URL}/products/${id}`;
      return this.httpClient.delete(url).pipe(
        catchError((error: any) => {
          return throwError(error);
        })
      );
    }


}
