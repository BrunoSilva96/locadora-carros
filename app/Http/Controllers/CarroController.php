<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarroRequest;
use App\Http\Requests\UpdateCarroRequest;
use App\Models\Carro;
use App\Repositories\CarroRepository;

class CarroController extends Controller
{
    public function __construct(Carro $carro){
        $this->carro = $carro;
    }

    public function index(Request $request)
    {
        $carroRepository = new CarroRepository($this->carro);

        if($request->has('atributos_modelo')) {
            $atributos_modelo = 'modelo: id,'.$request->atributos_modelo;
            $carroRepository->selectAtributosRegistrosRelacionados($atributos_modelo);
        } else {
            $carros = $this->marca->with('modelos');
            $carroRepository->selectAtributosRegistrosRelacionados('modelos');
        }

        if($request->has('filtro')){
            $carroRepository->filtro($request->filtro);
        }

        if($request->has('atributos')){
            $carroRepository->selectAtributes($request->atributos);
        }

        return response()->json($carroRepository->getResultado(), 200);
    }

    public function create()
    {
        //
    }

    public function store(StoreCarroRequest $request)
    {
        $request->validate($this->carro->rules());

        $carro = $this->carro->create([
            'modelo_id'  => $request->modelo_id,
            'placa'      => $request->placa,
            'disponivel' => $request->disponivel,
            'km'         => $request->km

        ]);

        return response()->json($carro, 201);
    }

    public function show(int $id)
    {
        $carro = $this->carro->with('modelo')->find($id);
        if($carro === null){
            return response()->json(['erro' => 'Recurso pesquisiado não existe'], 404);
        }
        return response()->json($carro, 200);
    }

    public function edit(Carro $carro)
    {
        //
    }

    public function update(Request $request, int $id)
    {
        $carro = $this->carro->find($id);

        if($carro === null){
            return response()->json(['erro' => 'Impossivel realizar a atualização. O recurso solicitado não existe'], 404);
        }

        if($request->method() === 'PATCH'){
           
            $regrasDinamicas = array();
            foreach($carro->rules() as $input => $regra) {

                if(array_key_exists($input, $request->all())){
                    $regrasDinamicas[$input] = $regra;           
                }
            }            
            $request->validate($regrasDinamicas);
        } else {
            $request->validate($carro->rules());
        }
    

        
        $carro->fill($request->all());
        $carro->save();

        return response()->json($carro, 200);
    }

    public function destroy(int $id)
    {
        $carro = $this->carro->find($id);

        if($carro === null){
            return response()->json(['erro' => 'Impossivel realizar a exclusão. O recurso solicitado não existe'], 404);
        }        

        $carro->delete();

        return response()->json(['msg' => 'O carro foi removida com sucesso!'], 200);
    }
}
