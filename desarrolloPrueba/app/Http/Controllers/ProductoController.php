<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
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
         //Validar, que sea necesario y su tipo
        $request->validate([
            'IDMATERIAL'=> 'required|string',
            'DESCRIPCION' => 'required|string',
            'UNIDADMEDIDA' => 'required|string',
            'PRECIO1' => 'required|numeric',
        ]);
        //Capturar el error en caso de que no se registre correctamente
        try {
            //Crear una instancia de mi modelo
            $producto= new Producto();
            $producto->IDMATERIAL = $request->input('IDMATERIAL');
            $producto->DESCRIPCION = $request->input('DESCRIPCION');
            $producto->UNIDADMEDIDA = $request->input('UNIDADMEDIDA');
            $producto->PRECIO1 = $request->input('PRECIO1');

            //Guardar el regitro en la bd
            $producto->save();

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'No se pudo crear el producto' .$e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $producto = Producto::where('IDMATERIAL', $id)->first();

        if (!$producto) {
            return response()->json([
                'error' => 'Producto no encontrado'
            ], 404);
        }

        return response()->json([
            'message' => 'Producto encontrado',
            'data' => $producto
        ]);
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
        try {
            //Buscar el producto
            $producto=Producto::find($id);

            //Validar nuestros campos
            $request->validate(
        [
                //'IDMATERIAL' => 'required|string',
                'DESCRIPCION' => 'required|string',
                'UNIDADMEDIDA' => 'required|string',
                'PRECIO1' => 'required|numeric',
                ]
            );
            $producto->IDMATERIAL = $request->input('IDMATERIAL');
            $producto->DESCRIPCION = $request->input('DESCRIPCION');
            $producto->UNIDADMEDIDA = $request->input('UNIDADMEDIDA');
            $producto->PRECIO1 = $request->input('PRECIO1');

            //Actualizamos nuestro registro
            $producto->save();
        
        } catch (\Exception $e) {
            return response()->json([
                'error'=> 'Ocurrio un error al actualizar el producto' .$e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try{
            //Buscar el producto
            $producto=Producto::find($id);
            if(!$producto) {
                return response()->json([
                    'error'=> 'No se pudo eliminar el Producto'
                ],404);
            }
            $producto->delete();
            return response()->json([
                'message' => 'Se ha eliminado el Producto'
            ],200);
        }catch (\Exception $e) {
            return response()->json([
                'error'=> 'Ocurrio un error al eliminar el Producto'
            ] ,500);
        };
    }
}
