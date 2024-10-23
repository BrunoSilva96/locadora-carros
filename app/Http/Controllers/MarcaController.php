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

        return $marcas;
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {   
        //$marca = Marca::create($request->all());
        $marca = $this->marca->create($request->all());

        return $marca;
    }

    public function show($id)
    {
        $marca = $this->marca->find($id);
        if($marca === null){
            return ['erro' => 'Recurso pesquisiado não existe'];
        }
        return $marca;
    }

    public function edit(Marca $marca)
    {
      
    }

    public function update(Request $request, $id)
    {
        //$marca->update($request->all());

        $marca = $this->marca->find($id);

        if($marca === null){
            return ['erro' => 'Impossivel realizar a atualização. O recurso solicitado não existe'];
        }

        $marca->update($request->all());
        return $marca;
    }

    public function destroy($id)
    {
        $marca = $this->marca->find($id);

        if($marca === null){
            return ['erro' => 'Impossivel realizar a exclusão. O recurso solicitado não existe'];
        }

        $marca->delete();

        return ['msg' => 'A amrca foi removida com sucesso!'];
    }
}
