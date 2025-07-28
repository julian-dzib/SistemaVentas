import { Component, OnInit } from '@angular/core';
import { ClientServiceService } from 'src/app/services/client-service.service';
import { ProductServiceService } from 'src/app/services/product-service.service';
import { SaleServiceService } from 'src/app/services/sale-service.service';
import { ReportServiceService } from 'src/app/services/report-service.service';
import jsPDF from 'jspdf';
import html2canvas from 'html2canvas';
import autoTable from 'jspdf-autotable';
@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {
  //Variables para mi alert con Bootstrap
  alertMenssage: string = '';
  alertType: string = '';
  alertVisible: boolean = false;

  //Variables para las ventas
  idClienteInput: number = 0;
  cliente: any = null;

  idMaterialInput: string = '';
  cantidadInput: number = 1;

  producto: any = null;
  materiales: any[] = [];

  subtotal: number = 0;
  iva: number = 0;
  total: number = 0;

  //Variables para los report
  reportClient: any[] = [];
  reportProduct: any[] = [];


  constructor(
    private reportService: ReportServiceService,
    private clientService: ClientServiceService,
    private productService: ProductServiceService,
    private saleService: SaleServiceService,

  ) { }
  ngOnInit(): void {
    throw new Error('Method not implemented.');
  }
  //.................................................................
  //Proceso de Venta
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

  //..................................................................
  //Metodo para mostrar un alert
  menssage(message: string, type: string) {
    this.alertMenssage = message;
    this.alertType = type,
      this.alertVisible = true;
    //Cerrarlo
    setTimeout(() => this.alertVisible = false, 2000);
  }

  //..................................................................
  //Metodo para generar el reporte por clientes
  dataClient() {
    this.reportService.reportClients().subscribe((data: any) => {
      const doc = new jsPDF();
      doc.text('Reporte por Clientes', 14, 8);
      autoTable(doc, {
        head: [['IDCLIENTE', 'RFC', 'RAZÓN SOCIAL', 'SUBTOTAL', 'IVA', 'TOTAL']],
        body: data.map((item: any) => [
          item.IDCLIENTE,
          item.RFC,
          item.RAZON_SOCIAL,
          item.SUBTOTAL,
          item.IVA,
          item.TOTAL
        ]),
        startY: 22
      });

      doc.save('ReporteCliente.pdf');
    });
  }


  //Metodo para generar el reporte por productos
  dataProduct() {
    this.reportService.reportProduct().subscribe((data: any) => {
      const doc = new jsPDF();

      doc.text('Reporte por Productos', 14, 8);

      autoTable(doc, {
        head: [['IDMATERIAL', 'DESCRIPCION', 'TOTAL_PIEZAS', 'SUBTOTAL']],
        body: data.map((item: any) => [
          item.IDMATERIAL,
          item.DESCRIPCION,
          item.TOTAL_PIEZAS,
          item.SUBTOTAL,
        ]),
        startY: 22
      });

      doc.save('ReporteProducto.pdf');
    });
  }

}
