<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comanda;

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
    public function comanda()
    {
        return view('comandas.comanda');
    }
    // Traer todas las comandas
    public function getComandas()
    {
        $comanda = Comanda::all();
        return response()->json(['status' => 'success', 'comandas' => $comanda]);
    }

    public function updateEstadoComanda(Request $request, $id)
    {
        $data = $request->validate(['estat' => 'required|in:Preparando,En Almacen,En Reparto,Finalizado']);

        $comanda = Comanda::findOrFail($id);
        $comanda->estat = $data['estat'];
        $comanda->save();

        return response()->json(['status' => 'success', 'message' => 'Estado de la comanda actualizado']);
    }

    public function eliminarComanda($id)
    {
        $comanda = Comanda::findOrFail($id); // Esto lanzará un 404 si no se encuentra
        $comanda->delete(); // Elimina la comanda

        return response()->json(['status' => 'success', 'message' => 'Comanda eliminada']);
    }
}
