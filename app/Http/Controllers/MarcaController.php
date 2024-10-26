<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Sotrage;
use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{

    public function __construct(Marca $marca){
        $this->marca = $marca;
    }

    public function index()
    {
        //$marcas = Marca::all();
        $marcas = $this->marca->all();

        return response()->json($marcas, 200);
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {   
        //$marca = Marca::create($request->all());
        $request->validate($this->marca->rules(), $this->marca->feedback());

        $imagem = $request->file('imagem');
        $imagem_urn = $imagem->store('imagens', 'public');

        $marca = $this->marca->create([
            'nome' => $request->nome,
            'imagem' => $imagem_urn
        ]);
        
        return response()->json($marca, 201);
    }

    public function show($id)
    {
        $marca = $this->marca->find($id);
        if($marca === null){
            return response()->json(['erro' => 'Recurso pesquisiado não existe'], 404);
        }
        return response()->json($marca, 200);
    }

    public function edit(Marca $marca)
    {
      
    }

    public function update(Request $request, $id)
    {
        //$marca->update($request->all());
        //PUT e PATCH não trabalham com imagem, então confugurar no form-data um chamado Key->_method Value-> PATCH ou PUT
        //Verbo no insominia tem que ser o post, seguindo o padrão acima
        $marca = $this->marca->find($id);

        if($marca === null){
            return response()->json(['erro' => 'Impossivel realizar a atualização. O recurso solicitado não existe'], 404);
        }

        if($request->method() === 'PATCH'){
           
            $regrasDinamicas = array();
            //percorrendo todas as regras definidas no Model
            foreach($marca->rules() as $input => $regra) {

                //coletar apeans as regras aplicáveis aos parÂmetros parciais da requiisiição
                if(array_key_exists($input, $request->all())){
                    $regrasDinamicas[$input] = $regra;           
                }
            }            
            
            $request->validate($regrasDinamicas, $marca->feedback());
        } else {
            $request->validate($marca->rules(), $marca->feedback());
        }

        //remove o arquivo antigo, caso um arquivo novo tenha sido enviado no request
        if($request->file('imagem')){
            Storage::disk('public')->delete($marca->imagem);//disco que escolheu para persistir os dados Local/Public/s3
        }

        $imagem = $request->file('imagem');
        $imagem_urn = $imagem->store('imagens', 'public');
        
        $marca->update([
            'nome' => $request->nome,
            'imagem' => $imagem_urn
        ]);

        return response()->json($marca, 200);
    }

    public function destroy($id)
    {
        $marca = $this->marca->find($id);

        if($marca === null){
            return response()->json(['erro' => 'Impossivel realizar a exclusão. O recurso solicitado não existe'], 404);
        }

        if($request->file('imagem')){
            Storage::disk('public')->delete($marca->imagem);//disco que escolheu para persistir os dados Local/Public/s3
        }

        $marca->delete();

        return response()->json(['msg' => 'A amrca foi removida com sucesso!'], 200);
    }
}
