<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marca;

class MarcaController extends Controller
{
    public function getMarcas()
    {
        $marcas = Marca::all();
        return response()->json([$marcas]);
    }

    public function getScreenMarca()
    {

        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder a esta página.');
        }

        $marcas = Marca::all();
        return view('marcas.marca', compact('marcas'));
    }

    public function createMarca(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required',
            'imagen' => 'required'
        ]);

        $marca = new Marca();
        $marca->nom = $data['nom'];
        $marca->imagen = $data['imagen'];
        $marca->save();

        return redirect()->back()->with('success', 'Marca creada exitosamente');
    }

    public function updateMarca(Request $request, $id)
    {
        $data = $request->validate([
            'nom' => 'required',
            'imagen' => 'required'
        ]);

        $marca = Marca::findOrFail($id);

        $marca->nom = $data['nom'];
        $marca->imagen = $data['imagen'];
        $marca->save();

        return redirect()->back()->with('success', 'Usuario Registrado exitosamente');

    }

    public function deleteMarca($id)
    {
        $marca = Marca::findOrFail($id);
        $marca->delete();
        
        return redirect()->back()->with('success', 'Usuario Registrado exitosamente');

    }
}
