<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Sotorage;
use App\Models\Modelo;
use Illuminate\Http\Request;

class ModeloController extends Controller
{
    public function __construct(Modelo $modelo){
        $this->modelo = $modelo;
    }

    public function index(Request $request)
    {

        $modelos = array();

        if($request->has('atributos_maarca')) {
            $atributos_marca = $request->atributos_marca;
            $modelos = $this->modelo->with('marca: id,'.$atributos_marca);
        } else {
            $modelos = $this->modelo->with('marca');
        }

        if($request->has('filtro')){
            $filtros = explode(';', $request->filtro);
            foreach($filtros as $key => $condicoes){
                $c = explode(':', $condicoes);
                $modelos = $modelos->where($c[0], $c[1], $c[2]);
            }
        }

        if($request->has('atributos')){
            $atributos = $request->atributos;
            $modelos = $modelos->selectRaw($atributos)->with('marca: id,'.$atributos_marca)->get();
        } else {
            $modelos = $modelos->modelo->get();
        }

        //$this->modelo->with('marca')->get()

        return response()->json($modelos, 200);
        //all() -> criando um obj de consulta + get() = collection
        //get() -> modificar a consulta -> collection
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate($this->modelo->rules());

        $imagem = $request->file('imagem');
        $imagem_urn = $imagem->store('imagens/modelos', 'public');

        $modelo = $this->modelo->create([
            'marca_id'      => $request->marca_id,
            'nome'          => $request->nome,
            'imagem'        => $imagem_urn,
            'numero_portas' => $request->numero_portas,
            'lugares'       => $request->lugares,
            'air_bag'       => $request->air_bag,
            'abs'           => $request->abs
        ]);

        return response()->json($modelo, 201);
    }

    public function show($id)
    {
        $modelo = $this->modelo->with('marca')->find($id);
        if($modelo === null) {
            return response()->json(['erro' => 'Recurso pesquisiado não existe'], 404);
        }

        return response()->json($modelo, 200);
    }

    public function edit(Modelo $modelo)
    {
        //
    }

    public function update(Request $request, Modelo $modelo)
    {
        if($modelo === null){
            return response()->json(['erro' => 'Impossivel realizar a atualização. O recurso solicitado não existe'], 404);
        }

        if($request->method() === 'PATCH'){
           
            $regrasDinamicas = array();
            //percorrendo todas as regras definidas no Model
            foreach($modelo->rules() as $input => $regra) {

                //coletar apeans as regras aplicáveis aos parÂmetros parciais da requiisiição
                if(array_key_exists($input, $request->all())){
                    $regrasDinamicas[$input] = $regra;           
                }
            }            
            
            $request->validate($regrasDinamicas);
        } else {
            $request->validate($modelo->rules());
        }

        if($request->file('imagem')){
            Storage::disk('public')->delete($modelo->imagem);//disco que escolheu para persistir os dados Local/Public/s3
        }


        $imagem = $request->file('imagem');
        $imagem_urn = $imagem->store('imagens/modelos', 'public');
        
        $modelo->fill($request->all());
        $modelo->imagem = $imagem_urn;
        $modelo->save();

        return response()->json($modelo, 200);
    }

    public function destroy($id)
    {
        $modelo = $this->modelo->find($id);

        if($modelo == null) {
            return response()->json(['erro' => 'Impossivel realizar a exclusão. O recurso solicitado não existe'], 404);
        }

        Storage::disk('public')->delete($modelo->imagem);

        $modelo->delete();

        return response()->json(['msg' => 'A modelo foi removida com sucesso!'], 200);
    }
}
