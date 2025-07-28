import { Component, OnInit } from '@angular/core';
import { ProductServiceService } from 'src/app/services/product-service.service';

@Component({
  selector: 'app-producto',
  templateUrl: './producto.component.html',
  styleUrls: ['./producto.component.scss']
})
export class ProductoComponent implements OnInit {
  newProducto: any = {
    'IDMATERIAL': '',
    'DESCRIPCION': '',
    'UNIDADMEDIDA': '',
    'PRECIO1': 0,
  }
  constructor(
     //Importar mi servicio de productos
    private productService : ProductServiceService
  ) { }

  ngOnInit(): void {
  }

  //Crear Producto/Craar Cliente
  createProduct() {
    this.productService.createProduct(this.newProducto).subscribe(
      (response) => {
        this.vaciarForm();
        console.log('Producto creado:', response);
      },
      (error) => {
        console.error('Error al crear el Producto:', error);
      }
    );
  }


  vaciarForm() {
    this.newProducto = {
      'IDMATERIAL': '',
      'DESCRIPCION': '',
      'UNIDADMEDIDA': '',
      'PRECIO1': 0,
    };
  }
}
