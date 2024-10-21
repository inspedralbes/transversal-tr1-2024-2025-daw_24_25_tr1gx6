<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
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

        // $token = $user->createToken('auth-token')->plainTextToken;
        // session(['auth-token', $token]);

        // Log the user in
        //Auth::login($user);

        return response()->json(['status' => 'success', 'message'=>'Usuario creado correctamente']);
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
