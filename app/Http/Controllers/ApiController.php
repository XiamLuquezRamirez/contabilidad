<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Empresas;

class ApiController extends Controller
{
    public function listTodosCompromisos(Request $request)
    {
        $compromisos = DB::table('compromiso_empresa')
        ->join('empresas', 'compromiso_empresa.empresa', 'empresas.id')
        ->join('compromisos', 'compromiso_empresa.compromiso', 'compromisos.id')
        ->select('compromiso_empresa.*', 'empresas.nombre', 'compromisos.descripcion AS desc_compromiso', 'compromisos.periocidad AS periodicidad')
        ->get();

        return response()->json($compromisos)
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    }

    public function cambiarEstadoCompromiso(Request $request)
    {
        $datosRecibidos = $request->all();

        $tipo = $datosRecibidos["tipo"];
        $id_compromiso = $datosRecibidos["data"]["id"];
        $estado_pres = $datosRecibidos["data"]["estado_pres"];
        $estado_venc = $datosRecibidos["data"]["estado_venc"];

        if($tipo == "pres"){
            $editar_data = [
                'estado_pres' => $estado_pres
            ];
        }else{
            $editar_data = [
                'estado_venc' => $estado_venc
            ];
        }

        $filasAfectadas = DB::table('compromiso_empresa')
        ->where('id', $id_compromiso)
        ->update($editar_data);

        if ($filasAfectadas > 0) {
            $data = [
                'success' => 1,
                'message' => 'Estado del compromiso actualizado correctamente',
                'affected_rows' => $filasAfectadas
            ];
        } else {
            $data = [
                'success' => 0,
                'message' => 'No se encontró el compromiso o no se realizaron cambios',
                'affected_rows' => $filasAfectadas
            ];
        }

        return response()->json($data)
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type');
    }

}
