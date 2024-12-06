<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Exception;


class Empresas extends Model
{
    public static function Guardar($request)
    {
        try {

            if ($request['accRegistro'] == 'guardar') {
                $respuesta = DB::connection('mysql')->table('empresas')->insertGetId([
                    'nombre' => $request['nombre']  ?? '',
                    'nit' => $request['nit'] ?? '',
                    'representante' => $request['representante'] ?? '',
                    'tipo_ident_representante' => $request['tipo_ident_representante'] ?? '',
                    'ident_representante' => $request['ident_representante'] ?? '',
                    'email' => $request['email'] ?? '',
                    'estado' => 'ACTIVO'
                ]);
            } else {
                $respuesta = DB::connection('mysql')->table('empresas')
                    ->where('id', $request['idRegistro'])  // Identificar el registro a actualizar
                    ->update([
                        'nombre' => $request['nombre']  ?? '',
                        'nit' => $request['nit'] ?? '',
                        'representante' => $request['representante'] ?? '',
                        'tipo_ident_representante' => $request['tipo_ident_representante'] ?? '',
                        'ident_representante' => $request['ident_representante'] ?? '',
                        'email' => $request['email'] ?? ''
                    ]);

                $respuesta = $request['idRegistro'];
            }
        } catch (Exception $e) {
            // Manejo del error
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al procesar el formulario: ' . $e->getMessage(),
            ], 500);
        }
        return  $respuesta;
    }

    public static function guardarAsigConcepto($request)
    {
        try {

            if ($request['accRegistroAsigConcepto'] == 'guardar') {
                $respuesta = DB::connection('mysql')->table('conceptos_asignados')->insertGetId([
                    'id_empresa' => $request['idEmpresaConcepto']  ?? '',
                    'id_concepto_pago' => $request['concepto'] ?? '',
                    'fecha_inicio' => $request['fechaInicio'] ?? '',
                    'frecuencia_pago' => $request['frecuencia'] ?? '',
                    'dias_anticipacion' => $request['diasNotificacion'] ?? '',
                    'observacion' => $request['observacionConcepto'] ?? ''
                ]);
            } else {
                $respuesta = DB::connection('mysql')->table('conceptos_asignados')
                    ->where('id', $request['idRegistroConcepto'])  // Identificar el registro a actualizar
                    ->update([
                        'id_empresa' => $request['idEmpresaConcepto']  ?? '',
                        'id_concepto_pago' => $request['concepto'] ?? '',
                        'fecha_inicio' => $request['fechaInicio'] ?? '',
                        'frecuencia_pago' => $request['frecuencia'] ?? '',
                        'dias_anticipacion' => $request['diasNotificacion'] ?? '',
                        'observacion' => $request['observacionConcepto'] ?? ''
                    ]);

                $respuesta = $request['idRegistroConcepto'];

                $compromiso = DB::connection('mysql')
                    ->table('pagos_pendientes')
                    ->where('id_concepto_asignado', $request['idRegistroConcepto'])
                    ->delete();
            }
        } catch (Exception $e) {
            // Manejo del error
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al procesar el formulario: ' . $e->getMessage(),
            ], 500);
        }
        return  $respuesta;
    }

    public static function guardarAsigCompromiso($request)
    {
        try {

            if ($request['accRegistroAsig'] == 'guardar') {
                $respuesta = DB::connection('mysql')->table('compromiso_empresa')->insertGetId([
                    'empresa' => $request['idEmpresa']  ?? '',
                    'compromiso' => $request['compromiso'] ?? '',
                    'fecha_presentacion' => $request['fechaPresentacion'] ?? '',
                    'dias_anticipacion_pre' => $request['diasNotificacionPres'] ?? '',
                    'fecha_vencimiento' => $request['fechaVencimiento'] ?? '',
                    'dias_anticipacion_ven' => $request['diasNotificacionVenc'] ?? '',
                    'observacion' => $request['observacion'] ?? '',
                    'estado_pres' => $request['estadoPres'] ?? '',
                    'estado_venc' => $request['estadoVenc'] ?? ''
                ]);
            } else {
                $respuesta = DB::connection('mysql')->table('compromiso_empresa')
                    ->where('id', $request['idRegistroAsig'])  // Identificar el registro a actualizar
                    ->update([
                        'compromiso' => $request['compromiso'] ?? '',
                        'fecha_presentacion' => $request['fechaPresentacion'] ?? '',
                        'dias_anticipacion_pre' => $request['diasNotificacionPres'] ?? '',
                        'fecha_vencimiento' => $request['fechaVencimiento'] ?? '',
                        'dias_anticipacion_ven' => $request['diasNotificacionVenc'] ?? '',
                        'observacion' => $request['observacion'] ?? '',
                        'estado_pres' => $request['estadoPres'] ?? '',
                        'estado_venc' => $request['estadoVenc'] ?? ''
                    ]);

                $respuesta = $request['idRegistroAsig'];
            }
        } catch (Exception $e) {
            // Manejo del error
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al procesar el formulario: ' . $e->getMessage(),
            ], 500);
        }
        return  $respuesta;
    }

    public static function listCompromiso()
    {
        return DB::connection('mysql')->table('compromisos')
            ->where('estado', 'ACTIVO')
            ->get();
    }

    public static function listConceptos()
    {
        return DB::connection('mysql')->table('conceptos_pago')
            ->where('estado', 'ACTIVO')
            ->get();
    }

    public static function guardarCompromiso($request)
    {
        try {

            if ($request['accRegistro'] == 'guardar') {
                $respuesta = DB::connection('mysql')->table('compromisos')->insertGetId([
                    'descripcion' => $request['descripcion']  ?? '',
                    'observacion' => $request['observacion'] ?? '',
                    'tipo_compromiso' => $request['tipoCompromiso'] ?? '',
                    'periocidad' => $request['periodicidad'] ?? '',
                    'estado' => 'ACTIVO'
                ]);
            } else {
                $respuesta = DB::connection('mysql')->table('compromisos')
                    ->where('id', $request['idRegistro'])  // Identificar el registro a actualizar
                    ->update([
                        'descripcion' => $request['descripcion']  ?? '',
                        'observacion' => $request['observacion'] ?? '',
                        'tipo_compromiso' => $request['tipoCompromiso'] ?? '',
                        'periocidad' => $request['periodicidad'] ?? '',
                    ]);

                $respuesta = $request['idRegistro'];
            }
        } catch (Exception $e) {
            // Manejo del error
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al procesar el formulario: ' . $e->getMessage(),
            ], 500);
        }
        return  $respuesta;
    }

    public static function guardarConcepto($request)
    {
        try {

            if ($request['accRegistro'] == 'guardar') {

                $respuesta = DB::connection('mysql')->table('conceptos_pago')->insertGetId([
                    'nombre_concepto' => $request['concepto']  ?? '',
                    'observacion' => $request['observacion'] ?? '',
                    'estado' => 'ACTIVO'
                ]);
            } else {
                $respuesta = DB::connection('mysql')->table('conceptos_pago')
                    ->where('id', $request['idRegistro'])  // Identificar el registro a actualizar
                    ->update([
                        'nombre_concepto' => $request['concepto']  ?? '',
                        'observacion' => $request['observacion'] ?? '',
                    ]);

                $respuesta = $request['idRegistro'];
            }
        } catch (Exception $e) {
            // Manejo del error
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al procesar el formulario: ' . $e->getMessage(),
            ], 500);
        }


        return  $respuesta;
    }


    public static function listEmpresas()
    {
        return DB::connection('mysql')->table('empresas')
            ->where('estado', 'ACTIVO')
            ->get();
    }
    public static function listAsigCompromiso($idEmpresa)
    {
        $compromisos = DB::connection('mysql')->table('compromiso_empresa')
            ->leftJoin('compromisos', 'compromiso_empresa.compromiso', '=', 'compromisos.id') // Relación entre las tablas
            ->where('compromiso_empresa.empresa', $idEmpresa)
            ->select(
                'compromiso_empresa.id',
                'compromiso_empresa.estado_pres',
                'compromiso_empresa.estado_venc',
                DB::raw('DATE_FORMAT(compromiso_empresa.fecha_presentacion, "%d/%m/%Y") as fecha_presentacion'),
                DB::raw('DATE_FORMAT(compromiso_empresa.fecha_vencimiento, "%d/%m/%Y") as fecha_vencimiento'),
                'compromisos.descripcion as descripcion'
            ) // Selecciona campos específicos
            ->get();

        return $compromisos;
    }

    public static function listAsigConcepto($idEmpresa)
    {
        $compromisos = DB::connection('mysql')->table('conceptos_asignados')
            ->leftJoin('conceptos_pago', 'conceptos_asignados.id_concepto_pago', '=', 'conceptos_pago.id') // Relación entre las tablas
            ->where('conceptos_asignados.id_empresa', $idEmpresa)
            ->select(
                'conceptos_asignados.id',
                'conceptos_asignados.frecuencia_pago',
                DB::raw('DATE_FORMAT(conceptos_asignados.fecha_inicio, "%d/%m/%Y") as fecha_inicio'),
                'conceptos_pago.nombre_concepto as concepto'
            ) // Selecciona campos específicos
            ->get();

        return $compromisos;
    }

    public static function listCompromisos()
    {
        return DB::connection('mysql')->table('compromisos')
            ->where('estado', 'ACTIVO')
            ->get();
    }
}
