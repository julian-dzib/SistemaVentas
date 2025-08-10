<?php

namespace App\Http\Controllers;
use App\Models\Cliente;
use Illuminate\Http\Request;
/**
 * @OA\Info(
 *             title="Api Clientes",
 *             version="1.0",
 *             description="Listado de clientes, donde se pueda dar de alta, baja y modificar los clientes"
 * )
 *
 * @OA\Server(url="http://127.0.0.1:8000")
 */
class ClienteController extends Controller
{
    /**
     * Listado de todos los clientes
     * @OA\Get (
     *     path="/api/clients",
     *     tags={"Cliente"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de clientes obtenida correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(
     *              property="message",
     *                 type="array",
     *                 property="data",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="IDCLIENTE",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="RAZON_SOCIAL",
     *                         type="string",
     *                         example="Fernando Julian Puc Dzib modificado"
     *                     ),
     *                     @OA\Property(
     *                         property="RFC",
     *                         type="string",
     *                         example="PEGM001224XXX"
     *                     ),
     *                     @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         example="2023-02-23T00:09:16.000000Z"
     *                     ),
     *                     @OA\Property(
     *                         property="updated_at",
     *                         type="string",
     *                         example="2023-02-23T12:33:45.000000Z"
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        //
        $cliente = Cliente::all();
        return response()->json([
            'message' => 'Lista de Clientes',
            'data' => $cliente
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //

    }

    /**
     * Registrar un nuevo cliente
     * @OA\Post (
     *     path="/api/clients",
     *     tags={"Cliente"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="RAZON_SOCIAL", type="string", example="Fernando Julian Puc Dzib"),
     *             @OA\Property(property="RFC", type="string", example="PEGM001224XXX")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cliente creado correctamente",
     *         @OA\JsonContent(
     *           @OA\Property(
     *                property="message",
     *                type="string",
     *                example="Cliente creado"
     *           ),
     *           @OA\Property(
     *              property="data",
     *              type="object",
     *                  @OA\Property(property="IDCLIENTE", type="number", example=1),
     *                  @OA\Property(property="RAZON_SOCIAL", type="string", example="Fernando Julian Puc Dzib"),
     *                  @OA\Property(property="RFC", type="string", example="PEGM001224XXX"),
     *                  @OA\Property(property="created_at", type="string", example="2023-02-23T00:09:16.000000Z"),
     *                  @OA\Property(property="updated_at", type="string", example="2023-02-23T12:33:45.000000Z")
     *          )
     *         )
     *     ),
     *      @OA\Response(
     *          response=500,
     *          description="No se pudo crear el cliente",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="No se pudo crear el cliente")
     *          )
     *      )
     * )
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
            $client = new Cliente();

            $client->RAZON_SOCIAL = $request->input('RAZON_SOCIAL');
            $client->RFC = $request->input('RFC');

            //Guardar el regitro en la bd
            $client->save();

            return response()->json([
                'message' => 'Cliente creado',
                'data' => $client
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'No se pudo crear el cliente'
            ], 500);
        }

        //return Cliente::create($request->all());
    }

    /**
     * Mostrar la información de un cliente
     * @OA\Get (
     *     path="/api/clientes/{id}",
     *     tags={"Cliente"},
     *     @OA\Parameter(
     *         in="path",
     *         name="IDCLIENTE",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cliente Econtrado",
     *         @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Cliente Econtrado"),
     *              @OA\Property(
     *                 property="data",
     *                 type="object",
     *                      @OA\Property(property="IDCLIENTE", type="number", example=1),
     *                      @OA\Property(property="RAZON_SOCIAL", type="string", example="Fernando Julian Puc Dzib"),
     *                      @OA\Property(property="RFC", type="string", example="PEGM001224XXX"),
     *                      @OA\Property(property="created_at", type="string", example="2023-02-23T00:09:16.000000Z"),
     *                      @OA\Property(property="updated_at", type="string", example="2023-02-23T12:33:45.000000Z")
     *             )
     *          )
     *     ),
     *      @OA\Response(
     *          response=404,
     *          description="Cliente no encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Cliente no encontrado"),
     *          )
     *      )
     * )
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
     * Actualizar la información de un cliente
     * @OA\Put(
     *   path="/api/clients/{id}",
     *   tags={"Cliente"},
     *     @OA\Parameter(
     *      in="path",
     *      name="IDCLIENTE",
     *      required=true,
     *      @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *        @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *               @OA\Property(
     *                  type="object",
     *                 @OA\Property(
     *                     property="RAZON_SOCIAL",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                    property="RFC",
     *                    type="string",
     *                 )
     *              ),
     *              example={
     *                "RAZON_SOCIAL": "Fernando Julian Puc Dzib modificado",
     *                "RFC": "PEGM001224XXX"
     *              }
     *           )
     *       )
     *     ),
     *     @OA\Response(
     *        response=200,
     *        description="Cliente actualizado correctamente",
     *        @OA\JsonContent(
     *           @OA\Property(property="message", type="string", example="Cliente actualizado correctamente")
     *        )
     *     ),
     *     @OA\Response(
     *       response=500,
     *       description="Cliente no encontrado",
     *      @OA\JsonContent(
     *          @OA\Property(property="error", type="string", example="Ocurrio un error al actualizar el cliente")
     *     )
     *    )
     * )
     */
    public function update(Request $request, $id)
    {
        //
        try {
            //Buscar el cliente
            $cliente = Cliente::find($id);

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
                'error' => 'Ocurrio un error al actualizar el cliente'
            ], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     * @OA\Delete (
     *     path="/api/clients/{id}",
     *     tags={"Cliente"},
     *     @OA\Parameter(
     *         in="path",
     *         name="IDCLIENTE",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Se ha eliminado el Cliente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Se ha eliminado el Cliente")
     *         )
     *     ),
     *      @OA\Response(
     *          response=404,
     *          description="No se pudo eliminar el cliente",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="No se pudo eliminar el cliente")
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        //
        try {
            //Buscar el cliente
            $cliente = Cliente::find($id);
            if (!$cliente) {
                return response()->json([
                    'error' => 'No se pudo eliminar el cliente'
                ], 404);
            }
            $cliente->delete();
            return response()->json([
                'message' => 'Se ha eliminado el Cliente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ocurrio un error al eliminar el cliente'
            ], 500);
        }
        ;
    }
}
