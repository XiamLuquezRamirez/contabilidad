<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Usuario extends Model
{
    public static function login($request)
    {
        $usuario = DB::connection("mysql")->select("select * from users where login_usuario ='" . $request['usuario'] . "' AND estado='ACTIVO'");

        if (!empty($usuario)) {
            $usuario = $usuario[0];

            if (\Hash::check($request['pasw'], $usuario->pasword_usuario)) {
                auth()->loginUsingId($usuario->id);
                return $usuario;
            }
        }
        return false;
    }
}
