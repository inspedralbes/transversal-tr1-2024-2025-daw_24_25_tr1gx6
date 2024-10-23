<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ComandaArticulo;

class ComandaArticuloController extends Controller
{
    public function createComandaArt(Request $request){

        $data = $request->validate([
            'json.*.idProducto'=> 'required',
            'json.*.talla'=> 'required',
            'json.*.color'=> 'required',
            'json.*.quantitat'=> 'required',
            'json.*.preu'=> 'required',
        ]);

        foreach($data['json'] as $comandaArt){
            $comandaArt = new ComandaArticulo();
            $comandaArt->idPrducto = $json['idPrducto'];
            $comandaArt->talla = $json['talla'];
            $comandaArt->color = $json['color'];
            $comandaArt->quantitat = $json['quantitat'];
            $comandaArt->preu = $json['preu'];
            $comandaArt->save();
        }

        return response()->json(['status'=>'success', 'message' => 'Comanda aritulo creada']);
    }

    public function updateComandaArt(){
        
    }

}
