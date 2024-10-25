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

        return response()->json(['status' => 'success', 'message' => 'Comanda creada exitosamente', 'IdComanda'=>$comanda->id]);

    }

    public function pedidoUser(Request $request)
    {
        $data = $request->validate([
            'idUser' => 'required'
        ]);

        $comanda = Comanda::with('comandaArticulo')->where('idUser', $request->idUser)->get();

        return response()->json(['status' => 'success', 'comandaUser' => $comanda]);
    }
}
