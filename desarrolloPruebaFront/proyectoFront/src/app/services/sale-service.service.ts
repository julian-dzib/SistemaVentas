// src/app/services/sale-service.service.ts
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { BaseServiceService } from './base-service.service';
import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class SaleServiceService {

  constructor(
    private httpClient: HttpClient,
    private baseService: BaseServiceService
  ) { }

  createSale(saleData: any): Observable<any> {
    const url = `${this.baseService.API_URL}/sales`;
    return this.httpClient.post(url, saleData).pipe(
      catchError((error: any) => throwError(error))
    );
  }
}
