<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comanda extends Model
{
    //protected $hidden = ['idUser'];

    use HasFactory;

    public function comandaArticulo()
    {
        return $this->hasMany(ComandaArticulo::class, 'idComanda');
    }
    /*
    public function user(){
        return $this->hasMany(User::class, 'id');
    }*/
}
