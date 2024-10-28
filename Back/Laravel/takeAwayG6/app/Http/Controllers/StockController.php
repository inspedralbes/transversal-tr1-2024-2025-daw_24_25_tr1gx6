<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;

class StockController extends Controller
{
    public function getProducteID(Request $request)
    {
        // Imprimir el idProducto y detener la ejecución
        $stock = Stock::where("idProducto", $request->idProducto)->get();

        return response()->json($stock);
    }

    public function updateStock(Request $request)
    {
        $stock = Stock::find($request->idProducto);
        $cant = $request->cantidad;
        $resultado = $stock->Nstock - $cant;
        $stock->Nstock = $resultado;
        $stock->save();
        return response()->json(['status' => 'succes', 'Numero' => $stock->Nstock]);
    }
}
