<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comanda;
use Illuminate\Support\Facades\Log;
use App\Models\ComandaArticulo;

class ComandasController extends Controller
{
    public function createComanda(Request $request)
    {
        $data = $request->validate([
            'idUser' => 'required',
            'estat' => 'required',
            'total' => 'required',
        ]);

        $comanda = new Comanda();
        $comanda->idUser = $request->idUser;
        $comanda->estat = $request->estat;
        $comanda->total = $request->total;

        $comanda->save();

        return response()->json(['status' => 'success', 'message' => 'Comanda creada exitosamente', 'IdComanda' => $comanda->id]);
    }

    public function pedidoUser(Request $request)
    {
        $data = $request->validate([
            'idUser' => 'required'
        ]);

        $comanda = Comanda::with('comandaArticulo')->where('idUser', $request->idUser)->get();

        return response()->json(['status' => 'success', 'comandaUser' => $comanda]);
    }

    // Vista de comandas de CRUD
    public function getScreenComanda()
    {
        if(!auth()->check()){
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder a esta página.');
        }
        
        return view('comandas.comanda');
    }
    // Traer todas las comandas
    public function getComandas()
    {
        $comanda = Comanda::all();
        return response()->json(['status' => 'success', 'comandas' => $comanda]);
    }

    public function updateEstadoComanda(Request $request, $id) {
        try {
            $comanda = Comanda::findOrFail($id);
            $comanda->estat = $request->estat;
            $comanda->save();
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error("Error en updateEstadoComanda: " . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Error al actualizar el estado de la comanda'], 500);
        }
    }
    
    

    public function eliminarComanda($id)
    {
        try {
            $comanda = Comanda::findOrFail($id);

            // Primero eliminamos los artículos relacionados
            $comanda->comandaArticulo()->delete();

            // Luego eliminamos la comanda
            $comanda->delete();

            return response()->json(['status' => 'success', 'message' => 'Comanda eliminada']);
        } catch (\Exception $e) {
            Log::error("Error al eliminar la comanda:" . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Error al eliminar la comanda'], 500);
        }
    }
}
