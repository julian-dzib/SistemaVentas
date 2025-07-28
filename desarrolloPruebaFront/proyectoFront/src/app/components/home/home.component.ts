import { Component, OnInit } from '@angular/core';
import { ClientServiceService } from 'src/app/services/client-service.service';
import { ProductServiceService } from 'src/app/services/product-service.service';
import { SaleServiceService } from 'src/app/services/sale-service.service';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {

  //Definir un alert con Bootstrap
  alertMenssage: string = '';
  alertType: string = '';
  alertVisible: boolean = false;

  //Realizar mi metodo
  menssage(message: string, type: string){
    this.alertMenssage=message;
    this.alertType= type,
    this.alertVisible= true;
    //Cerrarlo
    setTimeout(()=> this.alertVisible=false,2000);
  }



  idClienteInput: number = 0;
  cliente: any = null;

  idMaterialInput: string = '';
  cantidadInput: number = 1;

  producto: any = null;
  materiales: any[] = [];

  subtotal: number = 0;
  iva: number = 0;
  total: number = 0;

  constructor(
    private clientService: ClientServiceService,
    private productService: ProductServiceService,
    private saleService: SaleServiceService
  ) {}
  ngOnInit(): void {
    throw new Error('Method not implemented.');
  }

  buscarCliente() {
    this.clientService.getClientById(this.idClienteInput).subscribe(
      res => {
        this.cliente = res.data;
        this.menssage('Cliente Agregado', 'success')
      },
      err => {
        this.menssage('Cliente no encontrado', 'danger')
        console.error('Cliente no encontrado');
      }
    );
  }

  buscarProducto() {
    this.productService.getProductById(this.idMaterialInput).subscribe(
      res => {
        //this.menssage('Producto e')
        this.producto = res.data;
      },
      err => {
        this.menssage('Material no encontrado', 'danger')
        console.error('Material no encontrado');
      }
    );
  }

  agregarMaterial() {
    if (!this.producto || !this.producto.IDMATERIAL || !this.cantidadInput || this.cantidadInput <= 0) {
      this.menssage('No se encontró material para agregar, agregue al menos 1', 'danger')
      return;
    }
    const precio = parseFloat(this.producto.PRECIO1);
    const cantidad = this.cantidadInput;
    const totalParcial = precio * cantidad;

    this.materiales.push({
      IDMATERIAL: this.producto.IDMATERIAL,
      DESCRIPCION: this.producto.DESCRIPCION,
      UNIDADMEDIDA: this.producto.UNIDADMEDIDA,
      PRECIO1: precio,
      CANTIDAD: cantidad
    });

    this.subtotal += totalParcial;
    this.total = this.subtotal + this.iva;
    this.menssage('Material Agregado', 'success')

    // Limpiar producto y entradas
    this.producto = null;
    this.idMaterialInput = '';
    this.cantidadInput = 1;
  }

  actualizarIVA(valor: number) {
    this.iva = this.subtotal * (valor / 100);
    this.total = (this.subtotal + this.iva);
  }

  guardarVenta() {
    if (!this.cliente || this.materiales.length === 0) {
      this.menssage('No deje campos vacios, porfavor agregue un Cliente y al menos 1 Material', 'danger')

    }
    const venta = {
      IDCLIENTE: this.cliente.IDCLIENTE,
      SUBTOTAL: this.subtotal,
      IVA: this.iva,
      TOTAL: this.total,
      materiales: this.materiales
    };

    this.saleService.createSale(venta).subscribe(
      res => {
        this.menssage('Venta generada', 'success')
        this.limpiarFormulario();
      },
      err => {
        console.error('Error al guardar la venta', err);
      }
    );
  }

  limpiarFormulario() {
    this.idClienteInput = 0;
    this.cliente = null;
    this.idMaterialInput = '';
    this.producto = null;
    this.cantidadInput = 1;
    this.materiales = [];
    this.subtotal = 0;
    this.iva = 0;
    this.total = 0;
  }
}
