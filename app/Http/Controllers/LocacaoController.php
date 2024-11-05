<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLocacaoRequest;
use App\Http\Requests\UpdateLocacaoRequest;
use App\Models\Locacao;
use App\Repositories\LocacaoRepository;


class LocacaoController extends Controller
{
    public function __construct(Locacao $locacao){
        $this->locacao = $locacao;
    }

    public function index(Request $request)
    {
        $locacaoRepository = new LocacaoRepository($this->locacao);

        if($request->has('filtro')){
            $locacaoRepository->filtro($request->filtro);
        }

        if($request->has('atributos')){
            $locacaoRepository->selectAtributes($request->atributos);
        }

        return response()->json($locacaoRepository->getResultado(), 200);
    }

    public function create()
    {
        //
    }

    public function store(StoreLocacaoRequest $request)
    {
        $request->validate($this->locacao->rules());

        $locacao = $this->locacao->create([
            'cliente_id'=> $request->cliente_id,
            'carro_id' => $request->carro_id,
            'data_inicio_periodo' => $request->data_inicio_periodo,
            'data_final_previsto_periodo' => $request->data_final_previsto_periodo,
            'data_final_realizado_periodo' => $request->data_final_realizado_periodo,
            'valor_diaria' => $request->valor_diaria,
            'km_inicial' => $request->km_inicial,
            'km_final' => $request->km_final
        ]);

        return response()->json($locacao, 201);
    }

    public function show(int $id)
    {
        $locacao = $this->locacao->with('modelo')->find($id);
        if($locacao === null){
            return response()->json(['erro' => 'Recurso pesquisiado não existe'], 404);
        }
        return response()->json($locacao, 200);
    }

    public function edit(Locacao $locacao)
    {
        //
    }

    public function update(UpdateLocacaoRequest $request, int $id)
    {
        $locacao = $this->locacao->find($id);

        if($locacao === null){
            return response()->json(['erro' => 'Impossivel realizar a atualização. O recurso solicitado não existe'], 404);
        }

        if($request->method() === 'PATCH'){
           
            $regrasDinamicas = array();
            foreach($locacao->rules() as $input => $regra) {

                if(array_key_exists($input, $request->all())){
                    $regrasDinamicas[$input] = $regra;           
                }
            }            
            $request->validate($regrasDinamicas);
        } else {
            $request->validate($locacao->rules());
        }
    

        
        $locacao->fill($request->all());
        $locacao->save();

        return response()->json($locacao, 200);
    }

    public function destroy(Locacao $locacao)
    {
        $locacao = $this->locacao->find($id);

        if($locacao === null){
            return response()->json(['erro' => 'Impossivel realizar a exclusão. O recurso solicitado não existe'], 404);
        }        

        $locacao->delete();

        return response()->json(['msg' => 'A locação foi removida com sucesso!'], 200);
    }
}
