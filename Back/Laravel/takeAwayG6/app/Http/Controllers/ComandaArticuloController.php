<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ComandaArticulo;
use App\Models\Stock;

class ComandaArticuloController extends Controller
{
    public function createComandaArt(Request $request)
    {

        $data = $request->validate([
            '*.idProducto' => 'required',
            '*.idComanda' => 'required',
            '*.idStock' => 'required',
            '*.talla' => 'required',
            '*.color' => 'required',
            '*.quantitat' => 'required',
            '*.preu' => 'required',
        ]);

        // Group quantities by idStock
        $stockUpdates = [];

        foreach ($data as $jsonItem) {
            $comandaArt = new ComandaArticulo();
            $comandaArt->idProducto = $jsonItem['idProducto'];
            $comandaArt->idComanda = $jsonItem['idComanda'];
            $comandaArt->talla = $jsonItem['talla'];
            $comandaArt->color = $jsonItem['color'];
            $comandaArt->quantitat = $jsonItem['quantitat'];
            $comandaArt->preu = $jsonItem['preu'];
            $comandaArt->save();
        }

        foreach ($data as $jsonItem) {
            $stocks = Stock::findOrFail($jsonItem['idStock']);

            $cant = $jsonItem['quantitat'];

            $resultado = $stocks->Nstock - $cant;

            $stocks->Nstock = $resultado;

            $stocks->save();
        }

        return response()->json(['status' => 'success', 'message' => 'Articulos metidos en la comanda exitosamente']);
    }

    public function updateComandaArt()
    {

    }

}
