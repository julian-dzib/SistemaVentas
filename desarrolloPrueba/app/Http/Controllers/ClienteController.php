<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    //Seccion de clientes, 
    // donde se pueda dar de alta create, 
    // baja destroy 
    // modificar los clientes update
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
    public function create(Request $request)
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
            'RAZON_SOCIAL' => 'required|string',
            'RFC' => 'required|string',
        ]);
        //Capturar el error en caso de que no se registre correctamente
        try {
            //Crear una instancia de mi modelo
            $client= new Cliente();

            $client->RAZON_SOCIAL = $request->input('RAZON_SOCIAL');
            $client->RFC = $request->input('RFC');

            //Guardar el regitro en la bd
            $client->save();

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'No se pudo crear el cliente' .$e->getMessage()
            ], 500);
        }

        //return Cliente::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //Buscar un cliente por su ID
        //Traer el elemento especifico 
        $cliente = Cliente::where('IDCLIENTE', $id)->first();

        if (!$cliente) {
            return response()->json([
                'error' => 'Cliente no encontrado'
            ], 404);
        }

        return response()->json([
            'message' => 'Cliente Econtrado',
            'data' => $cliente
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
    public function update(Request $request, $id)
    {
        //
        try {
            //Buscar el cliente 
            $cliente=Cliente::find($id);

            //Validar nuestros campos
            $request->validate(
        [
                'RAZON_SOCIAL' => 'required|string',
                'RFC' => 'required|string',
                ]
            );

            $cliente->RAZON_SOCIAL = $request->input('RAZON_SOCIAL');
            $cliente->RFC = $request->input('RFC');

            //Actualizamos nuestro registro
            $cliente->save();
        
        } catch (\Exception $e) {
            return response()->json([
                'error'=> 'Ocurrio un error al actualizar el cliente' .$e->getMessage()
            ], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        try{
            //Buscar el cliente 
            $cliente=Cliente::find($id);
            if(!$cliente) {
                return response()->json([
                    'error'=> 'No se pudo eliminar el cliente'
                ],404);
            }
            $cliente->delete();
            return response()->json([
                'message' => 'Se ha eliminado el Cliente'
            ],200);
        }catch (\Exception $e) {
            return response()->json([
                'error'=> 'Ocurrio un error al eliminar el cliente'
            ] ,500);
        };
    }
}
