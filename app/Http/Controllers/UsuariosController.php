<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function guardarUsuario(Request $request)
    {

        if (Auth::check()) {
            $data = $request->all();

            $usuario = Usuario::Guardar($data);
            if ($usuario) {
                return response()->json(
                    [
                        'success' => true
                    ]
                );
            }
        } else {
            return redirect("/")->with("error", "Su Sesión ha Terminado");
        }
    }

    
    public function infoUsuarios()
    {
        if (Auth::check()) {
            $idUsuario = request()->get('idUsuario');
            // Verificar si el usuario ya está registrado
            $compromiso = DB::table('users')
                ->where('id', $idUsuario)
                ->first();

            return response()->json($compromiso);
        } else {
            return redirect("/")->with("error", "Su Sesión ha Terminado");
        }
    }

    
    public function verificarUsuario(Request $request)
    {
        if (Auth::check()) {
            $usuario = $request->input('usuario');
            $usuarioOriginal = $request->input('usuarioOriginal');

            if ($usuario === $usuarioOriginal) {
                return response()->json(true); // El usuario es válido porque no ha cambiado
            }

            $empresaExistente = DB::table('users')
                ->where('login_usuario', $usuario)
                ->exists();

            return response()->json(!$empresaExistente);
        } else {
            return redirect("/")->with("error", "Su Sesión ha Terminado");
        }
    }

    public function Logout()
    {
        Auth::logout();
        return redirect("/")->with("error", "Su Sesión ha Terminado");
    }

    public function cargarUsuarios()
    {
        $empresas = Usuario::listUsuarios();
        return response()->json($empresas);
    }


}
