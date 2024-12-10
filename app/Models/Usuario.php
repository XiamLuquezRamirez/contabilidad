<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Exception;

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

    public static function listUsuarios()
    {
        return DB::connection('mysql')->table('users')
            ->where('estado', 'ACTIVO')
            ->get();
    }

    public static function Guardar($request)
    {
        try {

            if ($request['accRegistro'] == 'guardar') {
                $respuesta = DB::connection('mysql')->table('users')->insertGetId([
                    'nombre_usuario' => $request['nombre'],
                    'login_usuario' => $request['usuario'],
                    'pasword_usuario' => bcrypt($request['pasw']),
                    'estado' => 'ACTIVO'
                ]);
            } else {
                
                $updateData = [
                    'nombre_usuario' => $request['nombre'],
                    'login_usuario' => $request['usuario'],
                ];
                
                // Solo actualiza la contraseña si se proporcionó
                if (!empty($request['pasw'])) { // Verifica si la contraseña está presente
                    $updateData['pasword_usuario'] = bcrypt($request['pasw']);
                }
                
                // Actualiza los datos del usuario en la tabla 'users'
                $respuesta = DB::connection('mysql')->table('users')
                    ->where('id', $request['idRegistro'])
                    ->update($updateData);
                
                // No sobrescribas `$respuesta`, utiliza una variable diferente si necesitas el ID
                $respuesta = $request['idRegistro'];
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al procesar el formulario: ' . $e->getMessage(),
            ], 500);
        }
        return  $respuesta;
    }

}
