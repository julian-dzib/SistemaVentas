# Desarrollo
# Backend
## Descripción
Gestor de productos

## Tecnologías
- PHP
- Laravel 12
- MySQL
- Apache

## Requerimientos
Pasos utilizar el proyecto necesitas tener instado:
- Mysql 8.0
- Php   8.3
- Composer  2.8.
- Apache 24
- Phpmyadmin 5.3
- Laravel 12

## Conexion a la BD
- DB_CONNECTION=mysql
- DB_HOST=127.0.0.1
- DB_PORT=3306
- DB_DATABASE=empresa
- DB_USERNAME=root
- DB_PASSWORD=sistemas

## Pruebas - Considerar que no exista el registro (id)
### Producto (Ejemplo)
- Crear   
    http://127.0.0.1:8000/api/products
    
    {
        "IDMATERIAL": "MAT0001",
        "DESCRIPCION": "Cemento gris 100kg",
        "UNIDADMEDIDA": "KG",
        "PRECIO1": 200
    }

- Devolver por id
    http://127.0.0.1:8000/api/products/MAT0001

- Actualizar
    http://127.0.0.1:8000/api/products/MAT0001

    {
        "IDMATERIAL": "MAT0001",
        "DESCRIPCION": "Cemento gris 100kg modificado",
        "UNIDADMEDIDA": "KG",
        "PRECIO1": 200
    }

- Eliminar
    http://127.0.0.1:8000/api/products/MAT0001

### Cliente (Ejemplo)
- Crear   

    http://127.0.0.1:8000/api/clients
    
    {
        "RAZON_SOCIAL": "Fernando Julian Puc Dzib",
        "RFC": "PEGM001224XXX "
    }

- Devolver por id
    http://127.0.0.1:8000/api/clients/3

- Actualizar
    http://127.0.0.1:8000/api/clients/3

    {
        "RAZON_SOCIAL": "Fernando Julian Puc Dzib modificado",
        "RFC": "PEGM001224XXX "
    }

- Eliminar
    http://127.0.0.1:8000/api/clients/3

### Venta (Ejemplo)
- Crear   
    http://127.0.0.1:8000/api/sales
       
        - El Cliente debe existir

        - El Producto debe existir

        - Debes agregar min 1 Producto
         
        - Devolver el RFC Y RZS

    {
    "IDCLIENTE": 3,
    "SUBTOTAL": 100,
    "IVA": 16,
    "TOTAL": 216,
    "materiales": [
        {
        "IDMATERIAL": "MAT0001",
        "DESCRIPCION": "Cemento gris 50kg",
        "UNIDADMEDIDA": "KG",
        "PRECIO1": 200,
        "CANTIDAD": 2
        },
        {
        "IDMATERIAL": "MAT0001",
        "DESCRIPCION": "Arena fina m3",
        "UNIDADMEDIDA": "M3",
        "PRECIO1": 300,
        "CANTIDAD": 3
        }
    ]
    }

### Reportes (Ejemplo)
- VentasPorProducto
    http://127.0.0.1:8000/api/reports/product
    
- VentasPorClientes
    http://127.0.0.1:8000/api/reports/client
    
## Estructura del proyecto
```bash
├─ app/
├─ routes/
├─ .env
```
# Frontend

## Descripción
Gestor de productos

## Tecnologías
- Angular
- Typscrip
- Bootstrap 


## Requerimientos
- Angular CLI: 12
- Node: 16.20.2
- Composer version 2.8.10
- npm install jspdf html2canvas
- npm install bootstrap
