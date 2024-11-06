<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AutorizacionController extends Controller
{
    public function login(Request $request)
    {
        $credenciales = $request->validate([
            "email" => ["required", "email"],
            "password" => "required",
        ]);

        //dd($credenciales);

        if (Auth::attempt($credenciales)) {
            $request->session()->regenerate();
            $user = Auth::user();

            $token = $user->createToken('auth-token')->plainTextToken;
            session(['auth-token', $token]);

            //dd($token);

            return redirect()->route('screen.home')->with('auth-token', $token);

        }
        /*
                $user = User::where('email', $credenciales['email'])->first();

                if ($user && Hash::check($credenciales['password'], $user->password)) {
                    // Crear un token de autenticación o realizar otras acciones si es necesario
                    $token = $user->createToken('auth-token')->plainTextToken;
                    session(['auth-token', $token]);
                    // Regenerar la sesión si es necesario
                    $request->session()->regenerate();

                    return response()->json(['status' => 'success', 'message' => 'Usuario encontrado', 'login' => true]);
                }*/

        return back()->withErrors(['email' => 'Correo o contraseña no son correctas'])->onlyInput('email');
        //return response()->json(['status' => 'success', 'message' => 'Usuario no encontrado', 'login' => false]);
    }

    public function register(Request $request)
    {

        $credenciales = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->rol = 'admin';

        $user->save();
        // Log the user in
        Auth::login($user);

        $token = $user->createToken('auth-token')->plainTextToken;
        session(['auth-token', $token]);

        //$request->session()->regenerate();

        //return redirect()->route('category.index');
        return response()->json(['status' => 'success', 'message' => 'Usuario registrado', 'register' => true]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->intended('/');
    }

    public function screenlogin()
    {
        if (auth()->check()) {
            return redirect()->route('screen.home');
        }
        return view('login.login'); // Asegúrate de que la vista de login esté configurada correctamente
    }

    public function getscreenHome()
    {

        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder a esta página.');
        }

        return view('home.home'); // Asegúrate de que la vista de login esté configurada correctamente
    }
}
