<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carro extends Model
{
    use HasFactory;

    protected $fillable = ['modelo_id', 'placa', 'disponivel', 'km'];

    public function rules(){
        return [
            'marca_id'      => 'exists:modelos,id',
            'placa'         => 'required',
            'diaponivel'    => 'required',//pode colocar mis tipos de extensão de arquivo
            'km'            => 'required',//(1,2,3,4,5)
        ];
    }

    public function modelo (){
        return $this->belongsTo('App\Models\Modelo');
    }
}
