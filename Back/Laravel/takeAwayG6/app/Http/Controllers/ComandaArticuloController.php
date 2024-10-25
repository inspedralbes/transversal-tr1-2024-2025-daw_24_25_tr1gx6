<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ComandaArticulo;

class ComandaArticuloController extends Controller
{
    public function createComandaArt(Request $request){

        $data = $request->validate([
            '*.idProducto'=> 'required',
            '*.idComanda' => 'required',
            '*.talla'=> 'required',
            '*.color'=> 'required',
            '*.quantitat'=> 'required',
            '*.preu'=> 'required',
        ]);

        foreach($data as $jsonItem){
            $comandaArt = new ComandaArticulo();
            $comandaArt->idProducto = $jsonItem['idProducto'];
            $comandaArt->idComanda = $jsonItem['idComanda'];
            $comandaArt->talla = $jsonItem['talla'];
            $comandaArt->color = $jsonItem['color'];
            $comandaArt->quantitat = $jsonItem['quantitat'];
            $comandaArt->preu = $jsonItem['preu'];
            $comandaArt->save();
        }

        return response()->json(['status'=>'success', 'message' => 'Articulos metidos en la comanda exitosamente']);
    }

    public function updateComandaArt(){
        
    }

}
