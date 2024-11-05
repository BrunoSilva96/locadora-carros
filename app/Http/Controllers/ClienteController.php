<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Models\Cliente;
use App\Repositories\ClienteRepository;


class ClienteController extends Controller
{

    public function __construct(Cliente $cliente){
        $this->cliente = $cliente;
    }

    public function index(Request $request)
    {
        $clienteRepository = new ClienteRepository($this->cliente);

        if($request->has('filtro')){
            $clienteRepository->filtro($request->filtro);
        }

        if($request->has('atributos')){
            $clienteRepository->selectAtributes($request->atributos);
        }

        return response()->json($clienteRepository->getResultado(), 200);
    }

    public function store(StoreClienteRequest $request)
    {
        $request->validate($this->cliente->rules());

        $cliente = $this->cliente->create([
            'nome'  => $request->nome,
        ]);

        return response()->json($cliente, 201);
    }

    public function show(int $id)
    {
        $cliente = $this->cliente->find($id);
        if($cliente === null){
            return response()->json(['erro' => 'Recurso pesquisiado não existe'], 404);
        }
        return response()->json($cliente, 200);
    }

    public function update(UpdateClienteRequest $request, int $id)
    {
        $cliente = $this->cliente->find($id);

        if($cliente === null){
            return response()->json(['erro' => 'Impossivel realizar a atualização. O recurso solicitado não existe'], 404);
        }

        if($request->method() === 'PATCH'){
           
            $regrasDinamicas = array();
            foreach($cliente->rules() as $input => $regra) {

                if(array_key_exists($input, $request->all())){
                    $regrasDinamicas[$input] = $regra;           
                }
            }            
            $request->validate($regrasDinamicas);
        } else {
            $request->validate($cliente->rules());
        }
    

        
        $cliente->fill($request->all());
        $cliente->save();

        return response()->json($cliente, 200);
    }

    public function destroy(int $id)
    {
        $cliente = $this->cliente->find($id);

        if($cliente === null){
            return response()->json(['erro' => 'Impossivel realizar a exclusão. O recurso solicitado não existe'], 404);
        }        

        $cliente->delete();

        return response()->json(['msg' => 'O cliente foi removida com sucesso!'], 200);
    }
}
