<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $hidden = ['idCategory', 'idMarca']; // Esto oculta los campos al serializar


    public function category(){
        return $this->belongsTo(Categoria::class, 'idCategory');
    }

    public function marca(){
        return $this->belongsTo(Marca::class, 'idMarca');
    }
}
