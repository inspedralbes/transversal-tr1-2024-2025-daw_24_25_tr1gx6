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

        if (Auth::attempt($credenciales)) {
            $request->session()->regenerate();
            $user = Auth::user();

            $token = $user->createToken('auth-token')->plainTextToken;
            //session(['auth-token', $token]);

            //dd($token);

            return redirect()->json(['status'=> 'success', 'token', $token]);

        }

        //return back()->withErrors(['email'=> 'Correo o contraseña no son correctas'])->onlyInput('email');
        return response()->json(['status' => 'error', 'message' => 'Usuario no encontrado']);
    }

    public function getUsers(){

        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder a esta página.');
        }

        $users = User::all();
        $rols = User::getEnumValues('users', 'rol');

        return view('users.user', compact('users', 'rols'));
    }
    
    public function createUser(Request $request){
        $data = $request->validate([
            'name'=> 'required',
            'email'=> ['required', 'email'],
            'password'=> 'required',
            'rol'=> 'required'
        ]);

        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = $data['password'];
        $user->rol = $data['rol'];

        $user->save();

        return redirect()->back()->with('success', 'Usuario Registrado exitosamente');
    }

    public function updateUser(Request $request, $id){
        $data = $request->validate([
            'name'=> 'required',
            'email'=> ['required', 'email'],
            'password'=> 'required',
            'rol'=> 'required'
        ]);

        $user = User::findOrFail($id);
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = $data['password'];
        $user->rol = $data['rol'];

        $user->save();

        return redirect()->back()->with('success', 'Usuario actualizado exitosamente');
    }

    public function deleteUser($id) {
        $user = User::findOrFail($id); 
        $user->delete(); 
        return redirect()->back()->with('success', 'Usuario eliminado exitosamente');
    }

}
