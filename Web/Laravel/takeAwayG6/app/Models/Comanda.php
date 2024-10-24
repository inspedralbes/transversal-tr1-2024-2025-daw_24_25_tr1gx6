<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comanda extends Model
{
    //protected $hidden = ['idUser'];

    public function comandaArticulo() {
        return $this->hasMany(ComandaArticulo::class, 'idComanda');
    }
    /*
    public function user(){
        return $this->hasMany(User::class, 'id');
    }*/
}
