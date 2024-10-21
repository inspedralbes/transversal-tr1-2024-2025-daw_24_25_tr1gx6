<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function CreateCategory(Request $request){
        $data = $request->validate(
            ['nom'=>'required']
        );

        $category = new Categoria();
        $category -> nom = $request->nom;

        $category->save();

        return response()->json(['status'=>'success', 'message'=>'Categoria creada exitosamente']);
    }

    public function UpdateCategory(Request $request, $id){
        $data = $request->validate(
            ['nom'=>'required']
        );

        $category = Categoria::findOrFail($id);
        $category->nom = $request->nom;
        $category->save();

        return response()->json(['status'=>'success', 'message' => 'Categoria actualizada']);
    }

    public function DeleteCategory($id){
        $category = Categoria::findOrFail($id);

        $category->delete();

        return response()->json(['status' => 'success', 'message'=>'Categoria eliminada']);
    }

}
