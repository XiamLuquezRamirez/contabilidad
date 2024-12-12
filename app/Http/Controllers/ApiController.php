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
        ->where("empresas.estado", "ACTIVO")
        ->where("compromisos.estado", "ACTIVO")
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
            ->where("conceptos_pago.estado", "ACTIVO")
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
                    $primerMes = (int) explode('-', $primerPago->fecha_pago)[1] - 1;
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

                    $key3->mes_pago = (int) explode('-', $key3->fecha_pago)[1] - 1;
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

    public function cambiarEstadoPago(Request $request){
        $id_pago = $request->input('id_pago');
        $estado = $request->input('estado');

        $editado = DB::table('pagos_pendientes')
        ->where('id', $id_pago)
        ->update(
            [
                "estado" => $estado
            ]
        );

        if ($editado > 0) {
            $respuesta = [
                'success' => 1,
                'message' => 'El pago fue actualizado correctamente.'
            ];
        } else {
            $respuesta = [
                'success' => 0,
                'message' => 'No se encontró el pago o no se realizó ningún cambio.'
            ];
        }

        return response()->json($respuesta)
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    }

    public function datosDashboard(Request $request){
       
        $anio = $request->input('anio');
        $fecha_inicio = "$anio-01-01";
        $fecha_fin = ($anio < date('Y')) ? "$anio-12-31" : (($anio > date('Y')) ? "$anio-12-31" : now()->format('Y-m-d'));
    

        // compromisos de la semana
        $primerDiaSemana = now()->startOfWeek();
        $ultimoDiaSemana = now()->endOfWeek(); 

        $compromisos1 = DB::table('compromiso_empresa')
        ->join('empresas', 'compromiso_empresa.empresa', 'empresas.id')        
        ->join('compromisos', 'compromiso_empresa.compromiso', 'compromisos.id')
        ->whereBetween('fecha_presentacion', [$primerDiaSemana, $ultimoDiaSemana])
        ->where("empresas.estado", "ACTIVO")
        ->where("compromisos.estado", "ACTIVO")
        ->count();

        $compromisos2 = DB::table('compromiso_empresa')
        ->join('empresas', 'compromiso_empresa.empresa', 'empresas.id')        
        ->join('compromisos', 'compromiso_empresa.compromiso', 'compromisos.id')
        ->whereBetween('fecha_vencimiento', [$primerDiaSemana, $ultimoDiaSemana])
        ->where("empresas.estado", "ACTIVO")
        ->where("compromisos.estado", "ACTIVO")
        ->count();
        
        $compromisos = $compromisos1 + $compromisos2;
        
        // compromisos vencidos
        $fecha_presentacion_vencida = DB::table('compromiso_empresa')
        ->join('empresas', 'compromiso_empresa.empresa', 'empresas.id')
        ->join('compromisos', 'compromiso_empresa.compromiso', 'compromisos.id')
        ->whereBetween('fecha_presentacion', [$fecha_inicio, $fecha_fin])
        ->whereIn('estado_pres', ['pendiente', 'vencida'])
        ->where("empresas.estado", "ACTIVO")
        ->where("compromisos.estado", "ACTIVO")
        ->select(
            'compromiso_empresa.*',
            'empresas.nombre as nombre_empresa',
            'compromisos.descripcion as compromiso_descripcion'
        )
        ->orderBy('fecha_presentacion', 'ASC')
        ->get();
    
        $fecha_vencimiento_vencida = DB::table('compromiso_empresa')
        ->join('empresas', 'compromiso_empresa.empresa', 'empresas.id')
        ->join('compromisos', 'compromiso_empresa.compromiso', 'compromisos.id')
        ->whereBetween('fecha_vencimiento', [$fecha_inicio, $fecha_fin])
        ->whereIn('estado_venc', ['pendiente', 'vencida'])
        ->where("empresas.estado", "ACTIVO")
        ->where("compromisos.estado", "ACTIVO")
        ->select(
            'compromiso_empresa.*',
            'empresas.nombre as nombre_empresa',
            'compromisos.descripcion as compromiso_descripcion'
        )
        ->orderBy('fecha_vencimiento', 'ASC')
        ->get();

        //pagos vencidos
        $pagos_pendientes = DB::table('pagos_pendientes')
        ->join('conceptos_asignados', 'conceptos_asignados.id', 'pagos_pendientes.id_concepto_asignado')
        ->join('conceptos_pago', 'conceptos_pago.id', 'conceptos_asignados.id_concepto_pago')
        ->join('empresas', 'empresas.id', 'conceptos_asignados.id_empresa')
        ->where('pagos_pendientes.estado', 'pendiente')
        ->whereBetween('fecha_pago', [$fecha_inicio, $fecha_fin])
        ->where("empresas.estado", "ACTIVO")
        ->where("conceptos_pago.estado", "ACTIVO")
        ->select('pagos_pendientes.*', 'conceptos_pago.nombre_concepto', 'empresas.nombre')
        ->orderBy('fecha_pago', 'ASC')
        ->get();

        $total_pagos = DB::table('pagos_pendientes')
        ->whereBetween('fecha_pago', [$fecha_inicio, $fecha_fin])
        ->count();

        if($total_pagos == 0){
            $porcentaje_pagos_pendientes = 0;
        }else{
            $porcentaje_pagos_pendientes = round((100 - (count($pagos_pendientes) / $total_pagos) * 100), 2);
        }
        
        $pagos_pendientes  = [
            'lista_pagos_pendientes' => $pagos_pendientes,
            'porcentaje_pagos_pendientes' => $porcentaje_pagos_pendientes,
            'total_pagos' => $total_pagos,
            'total_pagos_pendientes' => count($pagos_pendientes)
        ];

        return response()->json(
            [
                'fecha_presentacion_vencida' => $fecha_presentacion_vencida,
                'fecha_vencimiento_vencida' => $fecha_vencimiento_vencida,
                'compromisos_semana' => $compromisos,
                'pagos' => $pagos_pendientes
            ]    
        )
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    }

    public function notificaciones(Request $request){
       
        $fecha_actual = date('Y-m-d');
        // compromisos vencidos
        $fecha_presentacion_vencida = DB::table('compromiso_empresa')
        ->join('empresas', 'compromiso_empresa.empresa', '=', 'empresas.id')
        ->join('compromisos', 'compromiso_empresa.compromiso', '=', 'compromisos.id')
        ->whereIn('estado_pres', ['pendiente', 'vencida'])
        ->where("empresas.estado", "ACTIVO")
        ->where("compromisos.estado", "ACTIVO")
        ->select(
            'compromiso_empresa.*',
            'empresas.nombre as nombre_empresa',
            'compromisos.descripcion as compromiso_descripcion'
        )
        ->orderBy('fecha_presentacion', 'ASC')
        ->get();
    
        $fecha_vencimiento_vencida = DB::table('compromiso_empresa')
        ->join('empresas', 'compromiso_empresa.empresa', '=', 'empresas.id')
        ->join('compromisos', 'compromiso_empresa.compromiso', '=', 'compromisos.id')
        ->whereIn('estado_venc', ['pendiente', 'vencida'])
        ->where("empresas.estado", "ACTIVO")
        ->where("compromisos.estado", "ACTIVO")
        ->select(
            'compromiso_empresa.*',
            'empresas.nombre as nombre_empresa',
            'compromisos.descripcion as compromiso_descripcion'
        )
        ->orderBy('fecha_vencimiento', 'ASC')
        ->get();

        $compromisos_vencidos = [];

        // Recorrer $fecha_presentacion_vencida
        foreach ($fecha_presentacion_vencida as $item) {
            $dias_diferencia = (strtotime($item->fecha_presentacion) - strtotime($fecha_actual)) / 86400;
            if ($dias_diferencia < 0) {
                $item->dias_diferencia = (-1) * $dias_diferencia;
                $item->desc_not = "Fecha de presentación vencida hace ".(-1 * $dias_diferencia)." dias.";
                $compromisos_vencidos[] = $item;
            }else{
                if ($dias_diferencia == 0) {
                    $item->dias_diferencia = (-1) * $dias_diferencia;
                    $item->desc_not = "Fecha de presentación vence hoy.";
                    $compromisos_vencidos[] = $item;
                }else{
                    if ($dias_diferencia <= $item->dias_anticipacion_pre) {
                        $item->dias_diferencia = (-1) * $dias_diferencia;
                        $item->desc_not = "Fecha de presentación  proxima a vencer, faltan ".($dias_diferencia)." dias.";
                        $compromisos_vencidos[] = $item;
                    }
                }
            }

            $item->tipo_ven = 'pres';
            $item->clase = "noti_obligaciones";
        }

        // Recorrer $fecha_vencimiento_vencida
        foreach ($fecha_vencimiento_vencida as $item) {
            $dias_diferencia = (strtotime($item->fecha_vencimiento) - strtotime($fecha_actual)) / 86400;
            if ($dias_diferencia < 0) {
                $item->dias_diferencia = (-1) * $dias_diferencia;
                $item->desc_not = "Fecha de vencimiento vencida hace ".(-1 * $dias_diferencia)." dias.";
                $compromisos_vencidos[] = $item;
            }else{
                if ($dias_diferencia == 0) {
                    $item->dias_diferencia = (-1) * $dias_diferencia;
                    $item->desc_not = "Fecha de vencimiento vence hoy.";
                    $compromisos_vencidos[] = $item;
                }else{
                    if ($dias_diferencia <= $item->dias_anticipacion_ven) {
                        $item->dias_diferencia = (-1) * $dias_diferencia;
                        $item->desc_not = "Fecha de vencimiento proxima a vencer, faltan ".($dias_diferencia)." dias.";
                        $compromisos_vencidos[] = $item;
                    }
                }
                
            }

            $item->tipo_ven = "ven";
            $item->clase = "noti_obligaciones";
        }

        $compromisos_ordenados = collect($compromisos_vencidos)->sortByDesc('dias_diferencia')->values()->toArray();

        //pagos vencidos
        $pagos_vencidos_c = DB::table('pagos_pendientes')
        ->join('conceptos_asignados', 'conceptos_asignados.id', 'pagos_pendientes.id_concepto_asignado')
        ->join('conceptos_pago', 'conceptos_pago.id', 'conceptos_asignados.id_concepto_pago')
        ->join('empresas', 'empresas.id', 'conceptos_asignados.id_empresa')
        ->where('pagos_pendientes.estado', 'pendiente')
        ->where("empresas.estado", "ACTIVO")
        ->where("conceptos_pago.estado", "ACTIVO")
        ->where('fecha_pago', '<=', $fecha_actual)
        ->select('pagos_pendientes.*', 'conceptos_pago.nombre_concepto', 'empresas.nombre', 'conceptos_asignados.dias_anticipacion')
        ->orderBy('fecha_pago', 'ASC')
        ->get();

         // Recorrer $fecha_vencimiento_vencida
         foreach ($pagos_vencidos_c as $item) {
            $dias_diferencia = (strtotime($item->fecha_pago) - strtotime($fecha_actual)) / 86400;
            if ($dias_diferencia < 0) {
                $item->dias_diferencia = (-1) * $dias_diferencia;
                $item->desc_not = "Fecha de pago vencida hace ".(-1 * $dias_diferencia)." dias.";
                $pagos_vencidos[] = $item;
            }else{
                if ($dias_diferencia == 0) {
                    $item->dias_diferencia = (-1) * $dias_diferencia;
                    $item->desc_not = "Fecha de pago vence hoy.";
                    $pagos_vencidos[] = $item;
                }else{
                    if ($dias_diferencia <= $item->dias_anticipacion) {
                        $item->dias_diferencia = (-1) * $dias_diferencia;
                        $item->desc_not = "Fecha de pago proxima a vencer, faltan ".($dias_diferencia)." dias.";
                        $pagos_vencidos[] = $item;
                    }
                }
            }

            $item->clase = "noti_avance";
            $item->mes_pago = (int) explode('-', $item->fecha_pago)[1] - 1;
        }

        $pagos_ordenados = collect($pagos_vencidos)->sortByDesc('dias_diferencia')->values()->toArray();

        return response()->json(
            [
                'compromisos_vencidos' => $compromisos_ordenados,
                'pagos_vencidos' => $pagos_ordenados,
                'numero_notificaciones' => count($compromisos_ordenados) + count($pagos_ordenados)
            ]    
        )
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    }

}
