import { Component, OnInit } from '@angular/core';
import { ProductServiceService } from 'src/app/services/product-service.service';

@Component({
  selector: 'app-list-products',
  templateUrl: './list-products.component.html',
  styleUrls: ['./list-products.component.scss']
})
export class ListProductsComponent implements OnInit {
  list: any[] = [];


  constructor(
        private ProductServiceService: ProductServiceService,

  ) { }

  ngOnInit(): void {
    this.getAllProducts();
  }


 //Traer la lista de los clientes
  getAllProducts() {
    this.ProductServiceService.getProduct().subscribe(
      (response: any) => {
        this.list = response.data;
      },
      (error) => {
      }
    );
  }

  //Eliminar un cliente
  deleteProduct(id: string) {
    this.ProductServiceService.deleteProduct(id).subscribe(
      (response) => {
        //Hay que volver a cargar la lista de clientes después de eliminar uno
        this.getAllProducts();
      },
      (error) => {
      }
    );
  }

}

