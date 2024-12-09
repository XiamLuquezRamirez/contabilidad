<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Empresas;

class EmpresaController extends Controller
{
    public function verificarIdentPaciente(Request $request)
    {
        if (Auth::check()) {
            $identificacion = $request->input('nit');
            $idEmpresa = $request->input('id'); // Capturar el id del paciente si es una edición

            // Verificar si la identificación existe y pertenece a otro paciente
            $pacienteExistente = DB::table('empresas')
                ->where('nit', $identificacion)
                ->when($idEmpresa, function ($query) use ($idEmpresa) {
                    // Ignorar el registro actual si es una edición
                    $query->where('id', '!=', $idEmpresa);
                })
                ->exists();

            return response()->json(!$pacienteExistente); // Devuelve true si NO existe duplicado, false si ya está registrado
        } else {
            return redirect("/")->with("error", "Su Sesión ha Terminado");
        }
    }

    public function listCompromiso()
    {

        $compromiso = Empresas::listCompromiso();
        return response()->json($compromiso);
    }

    public function listConcepto()
    {
        $conceptos = Empresas::listConceptos();
        return response()->json($conceptos);
    }

    public function cargarEmpresas()
    {
        $empresas = Empresas::listEmpresas();
        return response()->json($empresas);
    }
    public function cargarAsigCompromiso(Request $request)
    {
        $idEmpresa = $request->input('idEmpresa');
        $empresas = Empresas::listAsigCompromiso($idEmpresa);
        return response()->json($empresas);
    }

    public function cargarAsigConcepto(Request $request)
    {
        $idEmpresa = $request->input('idEmpresa');
        $empresas = Empresas::listAsigConcepto($idEmpresa);
        return response()->json($empresas);
    }

    public function cargarCompromisos()
    {
        $empresas = Empresas::listCompromisos();
        return response()->json($empresas);
    }

    public function cargarConceptos()
    {
        $empresas = Empresas::listConceptos();
        return response()->json($empresas);
    }

    public function guardarEmpresa(Request $request)
    {
        if (Auth::check()) {
            $data = $request->all();
            if (!Auth::check()) {
                return response()->json([
                    'estado' => 'error',
                    'mensaje' => 'Su sesión ha terminado.',
                ], 401); // Código de error 401: No autorizado
            }

            $respuesta = Empresas::guardar($data);

            // Verificar el resultado y preparar la respuesta
            if ($respuesta) {
                $estado = true;
            } else {
                $estado = false;
            }

            // Retornar la respuesta en formato JSON
            return response()->json([
                'success' => $estado,
                'id' => $respuesta,
                'message' => 'Datos guardados'
            ]);
        } else {
            return redirect("/")->with("error", "Su Sesión ha Terminado");
        }
    }
    public function guardarAsigCompromiso(Request $request)
    {
        if (Auth::check()) {
            $data = $request->all();
            if (!Auth::check()) {
                return response()->json([
                    'estado' => 'error',
                    'mensaje' => 'Su sesión ha terminado.',
                ], 401); // Código de error 401: No autorizado
            }

            $respuesta = Empresas::guardarAsigCompromiso($data);

            // Verificar el resultado y preparar la respuesta
            if ($respuesta) {
                $estado = true;
            } else {
                $estado = false;
            }

            // Retornar la respuesta en formato JSON
            return response()->json([
                'success' => $estado,
                'id' => $respuesta,
                'message' => 'Datos guardados'
            ]);
        } else {
            return redirect("/")->with("error", "Su Sesión ha Terminado");
        }
    }

    public function guardarAsigConcepto(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'estado' => 'error',
                'mensaje' => 'Su sesión ha terminado.',
            ], 401); // Código de error 401: No autorizado
        }

        $data = $request->all();
        $respuesta = Empresas::guardarAsigConcepto($data);

        if ($respuesta) {
            // Recuperar el concepto asignado recién creado
            $conceptos = DB::table('conceptos_asignados')
                ->where('id', $respuesta)
                ->first();


            // Validar que el concepto existe
            if (!$conceptos) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró el concepto asignado.',
                ]);
            }

            // Validar fecha de inicio
            if (empty($conceptos->fecha_inicio)) {
                return response()->json([
                    'success' => false,
                    'message' => 'La fecha de inicio no está definida.',
                ]);
            }


            try {
                $fechaInicio = new \DateTime($conceptos->fecha_inicio);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Formato de fecha inválido: ' . $e->getMessage(),
                ]);
            }


            $frecuencia = $conceptos->frecuencia_pago;
            $fechaActual = new \DateTime();
            $finDeAnio = (new \DateTime())->setDate($fechaInicio->format('Y'), 12, 31);

            $fechaOriginal = new \DateTime($conceptos->fecha_inicio);
            $diaOriginal = $fechaInicio->format('d');
            $frecuencia = match ($frecuencia) {
                'Mensual' => 1,
                'Bimestral' => 2,
                'Trimestral' => 3,
                'Cuatrimestral' => 4,
                'Semestral' => 6,
                'Anual' => 12,
                default => throw new \Exception('Frecuencia no válida'),
            };
            $meses_sumar = 0;

    
            while ($fechaInicio <= $finDeAnio) {
                DB::table('pagos_pendientes')->insert([
                    'id_concepto_asignado' => $conceptos->id,
                    'fecha_pago' => $fechaInicio->format('Y-m-d'),
                    'estado' => 'pendiente',
                ]);

                $meses_sumar = $meses_sumar + $frecuencia;
                $fechaInicio = $this->incrementarFecha(clone $fechaOriginal, $meses_sumar, $diaOriginal);
            }

            return response()->json([
                'success' => true,
                'id' => $respuesta,
                'message' => 'Datos guardados y pagos pendientes generados.',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Error al guardar los datos.',
        ]);
    }

    private function incrementarFecha($fecha, $meses_sumar, $diaOriginal)
    {
        $fecha1 = $fecha;
        $fecha->modify("+$meses_sumar months");
        if ($fecha->format('d') != $diaOriginal) {
            $fecha->modify('last day of previous month');
        }
        return $fecha;
    }

    public function guardarCompromiso(Request $request)
    {
        if (Auth::check()) {
            $data = $request->all();
            if (!Auth::check()) {
                return response()->json([
                    'estado' => 'error',
                    'mensaje' => 'Su sesión ha terminado.',
                ], 401); // Código de error 401: No autorizado
            }

            $respuesta = Empresas::guardarCompromiso($data);

            // Verificar el resultado y preparar la respuesta
            if ($respuesta) {
                $estado = true;
            } else {
                $estado = false;
            }

            // Retornar la respuesta en formato JSON
            return response()->json([
                'success' => $estado,
                'id' => $respuesta,
                'message' => 'Datos guardados'
            ]);
        } else {
            return redirect("/")->with("error", "Su Sesión ha Terminado");
        }
    }

    public function guardarConcepto(Request $request)
    {
        if (Auth::check()) {
            $data = $request->all();
            if (!Auth::check()) {
                return response()->json([
                    'estado' => 'error',
                    'mensaje' => 'Su sesión ha terminado.',
                ], 401); // Código de error 401: No autorizado
            }

            $respuesta = Empresas::guardarConcepto($data);


            // Verificar el resultado y preparar la respuesta
            if ($respuesta) {
                $estado = true;
            } else {
                $estado = false;
            }

            // Retornar la respuesta en formato JSON
            return response()->json([
                'success' => $estado,
                'id' => $respuesta,
                'message' => 'Datos guardados'
            ]);
        } else {
            return redirect("/")->with("error", "Su Sesión ha Terminado");
        }
    }



    public function verificarNIT(Request $request)
    {
        if (Auth::check()) {
            $nit = $request->input('nit');
            $nitOriginal = $request->input('nitOriginal');

            if ($nit === $nitOriginal) {
                return response()->json(true); // El usuario es válido porque no ha cambiado
            }

            $empresaExistente = DB::table('empresas')
                ->where('nit', $nit)
                ->exists();

            return response()->json(!$empresaExistente);
        } else {
            return redirect("/")->with("error", "Su Sesión ha Terminado");
        }
    }

    public function verificarConceptoEmpresa(Request $request)
    {
        if (Auth::check()) {
            $concepto = $request->input('concepto');
            $conceptoOriginal = $request->input('conceptoOriginal');
            $idEmpresaConcepto = $request->input('idEmpresaConcepto');

            if ($concepto === $conceptoOriginal) {
                return response()->json(true); // El usuario es válido porque no ha cambiado
            }

            $empresaExistente = DB::table('conceptos_asignados')
                ->where('id_concepto_pago', $concepto)
                ->where('id_empresa', $idEmpresaConcepto)
                ->exists();

            return response()->json(!$empresaExistente);
        } else {
            return redirect("/")->with("error", "Su Sesión ha Terminado");
        }
    }

    public function infoEmpresa()
    {
        if (Auth::check()) {
            $empresa = request()->get('idEmpresa');
            // Verificar si el usuario ya está registrado
            $empresa = DB::table('empresas')
                ->where('id', $empresa)
                ->first();

            return response()->json($empresa);
        } else {
            return redirect("/")->with("error", "Su Sesión ha Terminado");
        }
    }

    public function infoAsigConceptos()
    {
        if (Auth::check()) {
            $idConcepto = request()->get('idConcepto');
            // Verificar si el usuario ya está registrado
            $conceptos = DB::table('conceptos_asignados')
                ->where('id', $idConcepto)
                ->first();

            return response()->json($conceptos);
        } else {
            return redirect("/")->with("error", "Su Sesión ha Terminado");
        }
    }

    public function pagosConceptos()
    {
        if (Auth::check()) {
            $idConcepto = request()->get('idConcepto');
            // Verificar si el usuario ya está registrado



            $conceptos = DB::table('pagos_pendientes')
                ->leftJoin('conceptos_asignados', 'conceptos_asignados.id', '=', 'pagos_pendientes.id_concepto_asignado') // Relación entre las tablas

                ->where('id_concepto_asignado', $idConcepto)
                ->select("pagos_pendientes.id", "pagos_pendientes.fecha_pago", "conceptos_asignados.frecuencia_pago", "pagos_pendientes.estado")
                ->get();


            return response()->json($conceptos);
        } else {
            return redirect("/")->with("error", "Su Sesión ha Terminado");
        }
    }

    public function actualizarEstado(Request $request)
    {
        $idPago = $request->input('idPago');
        $estado = $request->input('estado');

        DB::table('pagos_pendientes')
            ->where('id', $idPago)
            ->update(['estado' => $estado]);

        return response()->json(['message' => 'Estado actualizado correctamente']);
    }


    public function infoAsigCompromiso()
    {
        if (Auth::check()) {
            $idComp = request()->get('idComp');
            // Verificar si el usuario ya está registrado
            $compromiso = DB::table('compromiso_empresa')
                ->where('id', $idComp)
                ->first();

            return response()->json($compromiso);
        } else {
            return redirect("/")->with("error", "Su Sesión ha Terminado");
        }
    }

    public function infoConceptos()
    {
        if (Auth::check()) {
            $idConcepto = request()->get('idConcepto');
            // Verificar si el usuario ya está registrado
            $compromiso = DB::table('conceptos_pago')
                ->where('id', $idConcepto)
                ->first();

            return response()->json($compromiso);
        } else {
            return redirect("/")->with("error", "Su Sesión ha Terminado");
        }
    }

    public function infoCompromiso()
    {
        if (Auth::check()) {
            $compromiso = request()->get('idCompromiso');
            // Verificar si el usuario ya está registrado
            $empresa = DB::table('compromisos')
                ->where('id', $compromiso)
                ->first();

            return response()->json($empresa);
        } else {
            return redirect("/")->with("error", "Su Sesión ha Terminado");
        }
    }

    public function eliminarEmpresa()
    {
        try {
            $idReg = request()->input('idReg');
            if (!$idReg) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'ID de la empresa no proporcionada'
                    ],
                    400
                );
            }

            $empresa = DB::connection('mysql')
                ->table('empresas')
                ->where('id', $idReg)
                ->update([
                    'estado' => 'ELIMINADO',
                ]);


            if ($empresa) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Empresa eliminada correctamente'
                    ]
                );
            } else {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'No se encontró la empresa o no se pudo eliminar'
                    ],
                    404
                );
            }
        } catch (\Exception $e) {
            // Manejar cualquier error o excepción
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Ocurrió un error al intentar eliminar la empresa',
                    'error' => $e->getMessage()
                ],
                500
            );
        }
    }

    public function eliminarCompromiso()
    {
        try {
            $idReg = request()->input('idReg');
            if (!$idReg) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'ID del compromiso no proporcionado'
                    ],
                    400
                );
            }


            $compromiso = DB::connection('mysql')
                ->table('compromisos')
                ->where('id', $idReg)
                ->update([
                    'estado' => 'ELIMINADO',
                ]);


            if ($compromiso) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Compromiso eliminado correctamente'
                    ]
                );
            } else {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'No se encontró el compromiso o no se pudo eliminar'
                    ],
                    404
                );
            }
        } catch (\Exception $e) {
            // Manejar cualquier error o excepción
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Ocurrió un error al intentar eliminar el compromiso',
                    'error' => $e->getMessage()
                ],
                500
            );
        }
    }

    public function eliminarConcepto()
    {
        try {
            $idReg = request()->input('idReg');
            if (!$idReg) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'ID del concepto no proporcionado'
                    ],
                    400
                );
            }


            $compromiso = DB::connection('mysql')
                ->table('conceptos_pago')
                ->where('id', $idReg)
                ->update([
                    'estado' => 'ELIMINADO',
                ]);


            if ($compromiso) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Concepto eliminado correctamente'
                    ]
                );
            } else {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'No se encontró el concepto o no se pudo eliminar'
                    ],
                    404
                );
            }
        } catch (\Exception $e) {
            // Manejar cualquier error o excepción
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Ocurrió un error al intentar eliminar el concepto',
                    'error' => $e->getMessage()
                ],
                500
            );
        }
    }

    public function eliminarAsignacionCompromiso()
    {


        try {
            $idReg = request()->input('idReg');
            if (!$idReg) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'ID del compromiso asignado no proporcionado'
                    ],
                    400
                );
            }


            $compromiso = DB::connection('mysql')
                ->table('compromiso_empresa')
                ->where('id', $idReg)
                ->delete();

            if ($compromiso) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Compromiso asignado eliminado correctamente'
                    ]
                );
            } else {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'No se encontró el compromiso asignado o no se pudo eliminar'
                    ],
                    404
                );
            }
        } catch (\Exception $e) {
            // Manejar cualquier error o excepción
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Ocurrió un error al intentar eliminar el compromiso asignado',
                    'error' => $e->getMessage()
                ],
                500
            );
        }
    }
    public function eliminarAsignacionConcepto()
    {


        try {
            $idReg = request()->input('idReg');
            if (!$idReg) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'ID del concepto asignado no proporcionado'
                    ],
                    400
                );
            }


            $compromiso = DB::connection('mysql')
                ->table('conceptos_asignados')
                ->where('id', $idReg)
                ->delete();

            $compromisoPagos = DB::connection('mysql')
                ->table('pagos_pendientes')
                ->where('id_concepto_asignado', $idReg)
                ->delete();

            if ($compromiso) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Concepto asignado eliminado correctamente'
                    ]
                );
            } else {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'No se encontró el concepto asignado o no se pudo eliminar'
                    ],
                    404
                );
            }
        } catch (\Exception $e) {
            // Manejar cualquier error o excepción
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Ocurrió un error al intentar eliminar el concepto asignado',
                    'error' => $e->getMessage()
                ],
                500
            );
        }
    }
}
