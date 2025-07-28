import { ClientServiceService } from './../../../services/client-service.service';
import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-client',
  templateUrl: './client.component.html',
  styleUrls: ['./client.component.scss']
})
export class ClientComponent implements OnInit {

  newClient: any = {
    'RFC': '',
    'RAZON_SOCIAL': '',
  }

  constructor(
    private ClientServiceService: ClientServiceService
  ) { }

  ngOnInit(): void {
  }


  //Craar Cliente
  createClient() {
    this.ClientServiceService.createClient(this.newClient).subscribe(
      (response) => {
        this.vaciarForm();
        console.log('Cliente creado exitosamente:', response);
      },
      (error) => {
        console.error('Error al crear el cliente:', error);
      }
    );
  }

  vaciarForm() {
    this.newClient = {
      'RFC': '',
      'RAZON_SOCIAL': '',
    };
  }
}
