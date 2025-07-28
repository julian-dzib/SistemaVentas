import { Injectable } from '@angular/core';
import { BaseServiceService } from './base-service.service';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class ReportServiceService {

  constructor(
    private baseService: BaseServiceService,
    private httpClient: HttpClient
  ) { }

  //Metodo para generar el reporte
  //Por Clientes
  reportClients(){
    return this.httpClient.get(`${this.baseService.API_URL}/reports/client`);
  }

  //Por Productos
  reportProduct(){
    return this.httpClient.get(`${this.baseService.API_URL}/reports/products`);
  }
}
