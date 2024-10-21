<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ComandaArticulo;

class ComandaArticuloController extends Controller
{
    public function createComandaArt(Request $request, $id){

        $data = $request->validate([
            'idProducto'=> 'required',
            'talla'=> 'required',
            'color'=> 'required',
            'quantitat'=> 'required',
            'preu'=> 'required',
        ]);

        $comandaArt = new ComandaArticulo();
        $comandaArt->idPrducto = $request->idPrducto;
        $comandaArt->talla = $request->talla;
        $comandaArt->color = $request->color;
        $comandaArt->quantitat = $request->quantitat;
        $comandaArt->preu = $request->preu;

        $comandaArt->save();

        return response()->json(['status'=>'success', 'message' => 'Producto creado correctamente']);
    }

    public function updateComandaArt(){
        
    }

}
