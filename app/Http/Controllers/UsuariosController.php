<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;

class UsuariosController extends Controller
{
    public function Login()
    {
   
        $respuesta = Usuario::login(request()->all());
       
        if ($respuesta) {
            return redirect('Inicio');
        } else {
            $error = "Usuario ó Contraseña Inconrrecta";
            return redirect('/')->with('error', $error);
        }
    }
    
    public function Inicio()
    {
        if (Auth::check()) {
            return view('Inicio');
        } else {
            return redirect("/")->with("error", "Su Sesión ha Terminado");
        }
    }

    public function Logout()
    {
        Auth::logout();
        return redirect("/")->with("error", "Su Sesión ha Terminado");
    }

    
}
