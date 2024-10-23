<?php

namespace App\Http\Controllers;

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
        $marca = $this->marca->create($request->all());

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

        $marca = $this->marca->find($id);

        if($marca === null){
            return response()->json(['erro' => 'Impossivel realizar a atualização. O recurso solicitado não existe'], 404);
        }

        $marca->update($request->all());
        return response()->json($marca, 200);
    }

    public function destroy($id)
    {
        $marca = $this->marca->find($id);

        if($marca === null){
            return response()->json(['erro' => 'Impossivel realizar a exclusão. O recurso solicitado não existe'], 404);
        }

        $marca->delete();

        return response()->json(['msg' => 'A amrca foi removida com sucesso!'], 200);
    }
}
