<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function createProducto(Request $request, $id){

        $data = $request->validate([
            'nom'=> 'required',
            'desc'=> 'required',
            'stock'=> 'required',
            'preu'=> 'required',
            'img'=> 'required',
            'talla'=> 'required',
            'color'=>'required',
            'idCategory'=>'required'
        ]);

        $producto = new Producto();
        $producto->nom = $request->nom;
        $producto->desc = $request->desc;
        $producto->stock = $request->stock;
        $producto->preu = $request->preu;
        $producto->img = $request->img;
        $producto->talla = $request->talla;
        $producto->color=$request->color;
        $producto->idCategory=$request->idCategory; // o $id

        $producto->save();

        return response()->json(['status'=>'success', 'message' => 'Producto creado correctamente']);
    }

    public function updateProducto(Request $request, $id){

        $data = $request->validate([
            'nom'=> 'required',
            'desc'=> 'required',
            'stock'=> 'required',
            'preu'=> 'required',
            'img'=> 'required',
            'talla'=> 'required',
            'color'=>'required',
            'idCategory'=>'required'
        ]);

        $producto = Producto::findOrFail($request->idCategory); //o $id
        $producto->nom = $request->nom;
        $producto->desc = $request->desc;
        $producto->stock = $request->stock;
        $producto->preu = $request->preu;
        $producto->img = $request->img;
        $producto->talla = $request->talla;
        $producto->color=$request->color;
        $producto->idCategory=$request->idCategory; // o $id

        $producto->save();

        return response()->json(['status'=>'success', 'message' => 'Producto creado correctamente']);
    }

    public function deleteProducto($id){
        
        $producto = Producto::findOrFail($id);
        $producto->delete();

    }
}
