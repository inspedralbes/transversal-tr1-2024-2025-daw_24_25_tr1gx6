<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Talla;
use App\Models\Color;

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

    public function getScreenProducto()
    {
        $productos = Producto::with(relations: ['category', 'marca', 'talla', 'color'])->get();
        $categorias = Categoria::all();
        $marcas = Marca::all();
        $tallas = Talla::all();
        $colores = Color::all();

        return view('productos.producto', compact('productos', 'categorias', 'marcas', 'tallas', 'colores'));
    }

    public function createProducto(Request $request)
    {

        $data = $request->validate([
            'nom' => 'required',
            'desc' => 'required',
            'stock' => 'required',
            'preu' => 'required',
            'img' => 'required',
            'idCategory' => 'required',
            'idMarca' => 'required',
            'idColor' => 'required',
            'idTalla' => 'required'
        ]);

        $producto = new Producto();
        $producto->nom = $request->nom;
        $producto->desc = $request->desc;
        $producto->stock = $request->stock;
        $producto->preu = $request->preu;
        $producto->img = $request->img;
        $producto->valoracion = 0;
        $producto->idCategory = $request->idCategory; // o $id
        $producto->idMarca = $request->idMarca; // o $id
        $producto->idColor = $request->idColor; // o $id
        $producto->idTalla = $request->idTalla; // o $id

        $producto->save();

        //return response()->json(['status'=>'success', 'message'=>'Producto Creado']);
        return redirect()->route(route: 'screen.productos');
    }

    public function updateProducto(Request $request, $id)
    {

        $data = $request->validate([
            'nom' => 'required',
            'desc' => 'required',
            'stock' => 'required',
            'preu' => 'required',
            'img' => 'required',
            'idCategory' => 'required',
            'idMarca' => 'required',
            'idColor' => 'required',
            'idTalla' => 'required'
        ]);

        $producto = Producto::findOrFail($id); //o $id
        $producto->nom = $request->nom;
        $producto->desc = $request->desc;
        $producto->stock = $request->stock;
        $producto->preu = $request->preu;
        $producto->img = $request->img;
        $producto->valoracion = 0;
        $producto->idCategory = $request->idCategory; // o $id
        $producto->idMarca = $request->idMarca; // o $id
        $producto->idColor = $request->idColor; // o $id
        $producto->idTalla = $request->idTalla; // o $id

        $producto->save();

        //return response()->json(['status' => 'success', 'message' => 'Producto creado correctamente']);
        return redirect()->route(route: 'screen.productos');

    }

    public function deleteProducto($id)
    {

        $producto = Producto::findOrFail($id);
        $producto->delete();

    }

}
