import { Component, OnInit } from '@angular/core';
import { ClientServiceService } from 'src/app/services/client-service.service';

@Component({
  selector: 'app-list-clients',
  templateUrl: './list-clients.component.html',
  styleUrls: ['./list-clients.component.scss']
})
export class ListClientsComponent implements OnInit {

  list: any[] = [];

  constructor(
    private clientService: ClientServiceService,

  ) { }

  ngOnInit(): void {
    this.getAllClients();
  }

  //Traer la lista de los clientes
  getAllClients() {
    this.clientService.getClient().subscribe(
      (response: any) => {
        this.list = response.data;
      },
      (error) => {
      }
    );
  }

  //Eliminar un cliente
  deleteClient(id: number) {
    this.clientService.deleteClient(id).subscribe(
      (response) => {
        //Hay que volver a cargar la lista de clientes después de eliminar uno
        this.getAllClients();
      },
      (error) => {
      }
    );
  }

}
