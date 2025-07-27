<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Documento;
use App\Models\Documento_Renglon;
class VentaController extends Controller
{

    /*
    Seccion de ventas donde se pueda generar una venta, Una venta debe estar formada por el cliente y uno o mas materiales, la secuencia del proceso:
		a) Localizar a un cliente (Se debe validar que el cliente exista en la base de datos), y mostrar la informacion de RFC y RAZON SOCIAL.
		b) Localizar y agregar un material, proporcionando la cantidad que se desea vender. (Se debe poder agregar uno o varios materiales)
		c) Guardar la venta, afectando los registro correspondientes de [documento] y [documentorenglon].

    */
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try {
        /*Valicaciones de entrada
            -Necesito usar al cliente, el que va pedir
            -Pedir Uno o mas materiales para agregar*/
        $request->validate([
            //El cliente existe -            
            'IDCLIENTE' => 'required|integer|exists:clientes,IDCLIENTE',            
            //El material existe - 
            'materiales.*.IDMATERIAL' => 'required|string|exists:productos,IDMATERIAL',
            //Minimo que sea un 1 material
            'materiales.*.CANTIDAD' => 'required|integer|min:1',

            //Demas campos
            //Subtotal
            'SUBTOTAL'=> 'required|numeric',
            //Iva
            'IVA'=>'required|numeric',
            //Total
            'TOTAL'=>'required|numeric'
        ]);

        //Iniciar la transaccion
        DB::beginTransaction();
        //Buscar al cliente y devolver RFC Y RAZON SOCIAL
        $cliente = Cliente::with('documentos')->where('IDCLIENTE', $request->IDCLIENTE)->first();
        $rfc = $cliente->RFC;
        $razonSocial = $cliente->RAZON_SOCIAL;
        
        //Crear el documento de la venta
        $documento = $cliente->documentos()->create([
            'SUBTOTAL' => $request->SUBTOTAL,
            'IVA' => $request->IVA,
            'TOTAL' => $request->TOTAL,
        ]);

        //Crear los renglones
        foreach ($request->materiales as $index) {
            $producto = Producto::where('IDMATERIAL', $index['IDMATERIAL'])->first();

            if (!$producto) {
                DB::rollBack();
                return response()->json([
                    'error' => "Producto con IDMATERIAL '{$index['IDMATERIAL']}' no encontrado."
                ], 404);
            }

            $documento->renglons()->create([
                'IDMATERIAL' => $producto->IDMATERIAL,
                'UNIDAD_MEDIDA' => $producto->UNIDADMEDIDA,
                'CANTIDAD' => $index['CANTIDAD'],
                'PRECIO1' => $producto->PRECIO1
            ]);
        }

        DB::commit();
        return response()->json([
            'message' => 'La Venta se registro correctamente',
            'cliente' => [
                'RFC' => $rfc,
                'RAZON_SOCIAL' => $razonSocial
            ]
        ]);

        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Error al registrar la venta: ' . $e->getMessage()
            ], 500);

        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
