<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marca;

class MarcaController extends Controller
{
    public function getMarcas(){
        $marcas = Marca::all();
        return response()->json([$marcas]);
    }
}
