<?php

namespace App\Http\Controllers;

use App\Models\Producto;
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

    public function createStock(Request $request)
    {
        $data = $request->validate([
            'idProducto' => 'required',
            'Nstock' => 'required',
            'Color' => 'required',
        ]);

        //dd($request);

        $stock = new Stock();
        $stock->idProducto = $data['idProducto'];
        $stock->Nstock = $data['Nstock'];
        $stock->Color = $data['Color'];
        $stock->TallaCamisa = $request->TallaCamisa ?: null;
        $stock->TallaZapato = $request->TallaZapato ?: null;
        $stock->save();

        return redirect()->route('screen.stocks');
        //return response()->json(['status'=>'success', 'message'=>'Creado Stock']);
    }

    public function updateStock(Request $request, $id)
    {
        $data = $request->validate([
            'Nstock' => 'required',
        ]);

        $stock = Stock::findOrFail($id);
        $stock->Nstock = $data['Nstock'];

        $stock->save();

        return redirect()->route('screen.stocks');
    }

    public function deleteStock($id)
    {
        $stock = Stock::findOrFail($id);

        $stock->delete();

        return redirect()->route('screen.stocks');
    }

    public function getScreenStocks()
    {


        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder a esta página.');
        }

        $stocks = Stock::with('producto.category')->get();
        $productos = Producto::all();
        $stockC = Stock::getEnumValues('stocks', 'TallaCamisa');
        $stockZ = Stock::getEnumValues('stocks', 'TallaZapato');
        $stockCo = Stock::getEnumValues('stocks', 'Color');

        return view('stocks.stock', compact('stocks', 'productos', 'stockC', 'stockZ', 'stockCo'));
        //return response()->json($stocks);
    }
}
