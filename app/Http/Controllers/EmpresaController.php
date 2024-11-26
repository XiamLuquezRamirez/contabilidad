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
    public function cargarCompromisos()
    {
        $empresas = Empresas::listCompromisos();
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

    public function infoAsigCompromiso()
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
                        'message' => 'ID de la empresa no proporcionada'
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
}
