<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{

    public function getProductos()
    {
        $productos = Producto::with(['category', 'marca', 'talla', 'color'])->get();

        
        // Mapeamos los productos para cambiar la estructura
        /*
        $productosResponse = $productos->map(function ($producto) {
            return [
                'id' => $producto->id,
                'nom' => $producto->nom,
                'desc' => $producto->desc,
                'stock' => $producto->stock,
                'preu' => $producto->preu,
                'img' => $producto->img,
                'created_at' => $producto->created_at,
                'updated_at' => $producto->updated_at,
                'category' => $producto->category->nom ?? 'No disponible', // Usar 'No disponible' si no hay categoría
                'marca' => $producto->marca->nom ?? 'No disponible',       // Usar 'No disponible' si no hay marca
                'talla' => $producto->talla->medida ?? 'No disponible',     // Usar 'No disponible' si no hay talla
                'color' => $producto->color->nom ?? 'No disponible',        // Usar 'No disponible' si no hay color
            ];
        });*/

        return response()->json($productos);
    }

    public function createProducto(Request $request, $id)
    {

        $data = $request->validate([
            'nom' => 'required',
            'desc' => 'required',
            'stock' => 'required',
            'preu' => 'required',
            'img' => 'required',
            'talla' => 'required',
            'color' => 'required',
            'idCategory' => 'required'
        ]);

        $producto = new Producto();
        $producto->nom = $request->nom;
        $producto->desc = $request->desc;
        $producto->stock = $request->stock;
        $producto->preu = $request->preu;
        $producto->img = $request->img;
        $producto->talla = $request->talla;
        $producto->color = $request->color;
        $producto->idCategory = $request->idCategory; // o $id

        $producto->save();

        return response()->json(['status' => 'success', 'message' => 'Producto creado correctamente']);
    }

    public function updateProducto(Request $request, $id)
    {

        $data = $request->validate([
            'nom' => 'required',
            'desc' => 'required',
            'stock' => 'required',
            'preu' => 'required',
            'img' => 'required',
            'talla' => 'required',
            'color' => 'required',
            'idCategory' => 'required'
        ]);

        $producto = Producto::findOrFail($request->idCategory); //o $id
        $producto->nom = $request->nom;
        $producto->desc = $request->desc;
        $producto->stock = $request->stock;
        $producto->preu = $request->preu;
        $producto->img = $request->img;
        $producto->talla = $request->talla;
        $producto->color = $request->color;
        $producto->idCategory = $request->idCategory; // o $id

        $producto->save();

        return response()->json(['status' => 'success', 'message' => 'Producto creado correctamente']);
    }

    public function deleteProducto($id)
    {

        $producto = Producto::findOrFail($id);
        $producto->delete();

    }

}
