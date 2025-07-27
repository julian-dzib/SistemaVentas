<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cliente;
use App\Models\Producto;
class ReporteController extends Controller
{
    //Generar los reportes 
    /*
    Realizar un reporte con una sola consulta SQL que muestre un concentrado de las ventas por producto, 
    el reporte debe contener, 
    IDMATERIAL, DESCRIPCION, 
    TOTAL DE PIEZAS VENDIDAS, 
    SUBTOTAL. (El reporte debe mostrar un formato entendible y amigable)
    */
    public function VentasPorProducto()
    {
        $data = DB::select(
            "
            SELECT
                pro.IDMATERIAL,
                pro.DESCRIPCION,
                SUM(reng.CANTIDAD) AS TOTAL_PIEZAS,
                SUM(reng.CANTIDAD * reng.PRECIO1) AS SUBTOTAL
            FROM documentos_renglons reng
            JOIN productos pro ON reng.IDMATERIAL = pro.IDMATERIAL
            GROUP BY pro.IDMATERIAL, pro.DESCRIPCION
            ORDER BY TOTAL_PIEZAS DESC
            "
        );
        return response()->json($data);
    }


    /*
    Relizar un reporte con una sola consulta SQL que mueste el total de ventas por Clientes, el reporte debe contener IDCLIENTE, RFC, RAZON_SOCIAL, SUBTOTAL, IVA, TOTAL. (El reporte debe mostrar un formato entendible y amigable)
    */
    public function VentasPorClientes(Request $request)
    {
        $data = DB::select(
            "
        SELECT
            cli.IDCLIENTE,
            cli.RFC,
            cli.RAZON_SOCIAL,
            SUM(reng.CANTIDAD * reng.PRECIO1) AS SUBTOTAL,
            SUM(reng.CANTIDAD * reng.PRECIO1 * 0.16) AS IVA,
            SUM(reng.CANTIDAD * reng.PRECIO1 * 1.16) AS TOTAL
        FROM documentos_renglons reng
        JOIN documentos d ON reng.IDCODIGO = d.IDCODIGO
        JOIN clientes cli ON d.IDCLIENTE = cli.IDCLIENTE
        GROUP BY cli.IDCLIENTE, cli.RFC, cli.RAZON_SOCIAL
        ORDER BY TOTAL DESC

        "
        );

        return response()->json($data);
    }
}
