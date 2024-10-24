<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $hidden = ['idCategory', 'idMarca', 'idColor', 'idTalla']; // Esto oculta los campos al serializar


    public function category(){
        return $this->belongsTo(Categoria::class, 'idCategory');
    }

    public function marca(){
        return $this->belongsTo(Marca::class, 'idMarca');
    }

    public function talla(){
        return $this->belongsTo(Talla::class, 'idTalla');
    }

    public function color(){
        return $this->belongsTo(Color::class, 'idColor');
    }
}
