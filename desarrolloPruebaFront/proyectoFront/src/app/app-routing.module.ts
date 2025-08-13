import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { HomeComponent } from './components/home/home.component';
import { ClientComponent } from './components/clients/client/client.component';
import { ProductoComponent } from './components/products/producto/producto.component';
import { ListClientsComponent } from './components/clients/list-clients/list-clients.component';
import { ListProductsComponent } from './components/products/list-products/list-products.component';


//Definir las rutas de la aplicación
const routes: Routes = [
  {path:'', redirectTo:'home', pathMatch:'full'}, /// Configuración de redirección desde la URL raíz
  {path:'home', component: HomeComponent },
  {path:'client', component:ClientComponent }, // Ruta para el componente Client
  {path:'producto', component:ProductoComponent }, // Ruta para el componente Producto
  {path:'list-client', component: ListClientsComponent }, // Ruta para listar clientes
  {path:'list-product', component: ListProductsComponent } // Ruta para listar productos
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
