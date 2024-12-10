<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Empresas;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    public function listTodosCompromisos(Request $request){
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

    public function cambiarEstadoCompromiso(Request $request){
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

    public function datosDashboard(){
       
        $primerDiaSemana = now()->startOfWeek();
        $ultimoDiaSemana = now()->endOfWeek(); 

        $compromisos1 = DB::table('compromiso_empresa')
            ->whereBetween('fecha_presentacion', [$primerDiaSemana, $ultimoDiaSemana])
            ->count();

        $compromisos2 = DB::table('compromiso_empresa')
            ->whereBetween('fecha_vencimiento', [$primerDiaSemana, $ultimoDiaSemana])
            ->count();

        
        $compromisos = $compromisos1 + $compromisos2;
        
        return response()->json(
            [
                'compromisos_semana' => $compromisos
            ]    
        )
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    }

    public function avanceContable(Request $request){
       
        $anio = $request->input('anio');

        $empresas = DB::table('empresas')
        ->where('estado', 'ACTIVO')
        ->get();

        foreach ($empresas as $key) {
            $key->conceptos = DB::table('conceptos_asignados')
            ->join('conceptos_pago', 'conceptos_asignados.id_concepto_pago', 'conceptos_pago.id')
            ->whereYear('fecha_inicio', $anio)
            ->where('id_empresa', $key->id)
            ->select('conceptos_asignados.*', 'conceptos_pago.nombre_concepto')
            ->get();

            $pagados = 0;
            $total = 0;

            foreach ($key->conceptos as $key2) {
                $key2->pagos = DB::table('pagos_pendientes')
                ->where('id_concepto_asignado', $key2->id)
                ->get();

                if (count($key2->pagos) > 0) {
                    $primerPago = $key2->pagos[0];
                    $ultimoPago = $key2->pagos[count($key2->pagos) - 1];
                    $primerMes = (int) explode('-', $primerPago->fecha_pago)[1];
                    $ultimoMes = (int) explode('-', $ultimoPago->fecha_pago)[1];
                }

                $key2->primer_mes = $primerMes;
                $key2->ultimo_mes = $ultimoMes;

                foreach ($key2->pagos as $key3) {
                    if($key3->estado == 'pagado'){
                        $key3->abrev = "PAG";
                        $key3->clase = "pagado";
                        $pagados += 1;
                    }else{
                        if($key3->estado == "N/A"){
                            $key3->abrev = "N/A";
                            $key3->clase = "na";
                            $pagados += 1;
                        }else{
                            $key3->abrev = "PEN";
                            $key3->clase = "pendiente";
                        }
                    }
                    $total+=1;
                }
            }

            if($total == 0){
                $porcentaje = 0;
            }else{
                $porcentaje = round(($pagados / $total) * 100, 2);
            }
           

            $key->conceptos_pagados = $pagados;
            $key->porcentaje = $porcentaje;
            $key->total_conceptos = $total;
        }

        
        
        return response()->json(
            $empresas    
        )
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    }

}
