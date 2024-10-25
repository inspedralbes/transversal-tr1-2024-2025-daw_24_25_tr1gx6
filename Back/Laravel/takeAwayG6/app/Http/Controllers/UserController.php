<?php

namespace App\Http\Controllers;

use Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{

    public function loginUser(Request $request) {
        
        $credenciales = $request->validate([
            "email" => ["required", "email"],
            "password" => "required",
        ]);

        $user = User::where('email', $credenciales['email'])->first();

        if ($user && Hash::check($credenciales['password'], $user->password)) {

            return response()->json(['status' => 'success', 'message' => 'Usuario encontrado', 'login' => true]);
        }

        //return back()->withErrors(['email'=> 'Correo o contraseña no son correctas'])->onlyInput('email');
        return response()->json(['status' => 'success', 'message' => 'Usuario no encontrado', 'login' => false]);
    }

    public function createUser(Request $request){
        $data = $request->validate([
            'name'=> 'required',
            'email'=> ['required', 'email'],
            'password'=> 'required',
            'rol'=> 'required'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->rol = $request->rol;

        $user->save();

        return response()->json(['status' => 'success', 'message' => 'Usuario creado', 'register' => true]);
    }

    public function updateUser(Request $request){
        $data = $request->validate([
            'name'=> 'required',
            'email'=> ['required', 'email'],
            'password'=> 'required',
            'rol'=> 'required'
        ]);

        $user = User::findOrFail(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->rol = $request->rol;

        $user->save();

        return response()->json(['status'=>'success', 'message'=>'Usuario actualizado']);
    }

    public function deleteUser(){
        
        $user = User::findOrFail(Auth::user()->id);

        $user->delete();
    }

}
