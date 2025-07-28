import { ClientServiceService } from './../../../services/client-service.service';
import { Component, OnInit } from '@angular/core';
import { HomeComponent } from '../../home/home.component';
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
    private ClientServiceService: ClientServiceService,
  ) { }

  //Variables para mi alert con Bootstrap
  alertMenssage: string = '';
  alertType: string = '';
  alertVisible: boolean = false;

  ngOnInit(): void {
  }

  //.................................................
  //Craar Cliente
  createClient() {
    this.ClientServiceService.createClient(this.newClient).subscribe(
      (response) => {
        this.vaciarForm();
        this.menssage('Cliente creado','success');
        //console.log('Cliente creado exitosamente:', response);
      },
      (error) => {
        this.menssage('Error al crear al Cliente','danger');
        //console.error('Error al crear el cliente:', error);
      }
    );
  }

  vaciarForm() {
    this.newClient = {
      'RFC': '',
      'RAZON_SOCIAL': '',
    };
  }

  //.................................................
  //Realizar mi metodo
  menssage(message: string, type: string){
    this.alertMenssage=message;
    this.alertType= type,
    this.alertVisible= true;
    //Cerrarlo
    setTimeout(()=> this.alertVisible=false,2000);
  }

}
