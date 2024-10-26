<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $fillable = ['nome', 'imagem'];

    public function rules(){
        return [
            'nome'=> 'required|unique:marcas,nome,'.$this->id.'|min:3',
            'imagem' => 'required|file|mimes:png'//pode colocar mis tipos de extensão de arquivo
        ];
    }
    public function feedback(){
        return [
            'required'=> 'O campo :attribute é obrigatorio.',
            'imagem.mimes' => 'O arquivo deve ser uma imagem do tipo PNG.',
            'nome.unique' => 'O nome da marca já existe',
            'nome.min' => 'O nome deve conter no minimo 3 letras.'
        ];
    }
    use HasFactory;
}
