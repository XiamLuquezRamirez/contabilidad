<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\ApiController;


Route::get('/', function () {
    return view('Login');
})->name('login');


///INICIO DE SESIÓN
Route::post('/Login', [UsuariosController::class,'Login']);
Route::get('/Inicio', [UsuariosController::class,'Inicio'])->name('inicio');
Route::get('/Logout', [UsuariosController::class,'Logout']);

// GESTIONAR EMPRESA
Route::get('/Empresas', function () {
    return view('Empresas');
});
Route::post('/empresa/verificar-nit', [EmpresaController::class, 'verificarNIT'])->name('empresa.verificar-nit');
Route::post('/empresa/verificarConceptoEmpresa', [EmpresaController::class, 'verificarConceptoEmpresa'])->name('empresa.verificarConceptoEmpresa');
Route::post('/empresa/guardar', [EmpresaController::class, 'guardarEmpresa'])->name('form.guardarEmpresa');
Route::post('/empresa/cargarEmpresas', [EmpresaController::class, 'cargarEmpresas'])->name('empresa.cargarEmpresas');
Route::post('/empresa/infoEmpresa', [EmpresaController::class, 'infoEmpresa'])->name('empresa.infoEmpresa');
Route::post('/empresa/eliminar', [EmpresaController::class, 'eliminarEmpresa'])->name('empresa.eliminar');

///GESTIONAR COMPROMISOS
Route::get('/Compromisos', function () {
    return view('Compromisos');
});

Route::post('/compromiso/cargarCompromisos', [EmpresaController::class, 'cargarCompromisos'])->name('compromiso.cargarCompromisos');
Route::post('/compromiso/guardar', [EmpresaController::class, 'guardarCompromiso'])->name('form.guardarCompromiso');
Route::post('/compromiso/infoCompromiso', [EmpresaController::class, 'infoCompromiso'])->name('compromiso.infoCompromiso');
Route::post('/compromiso/eliminar', [EmpresaController::class, 'eliminarCompromiso'])->name('compromiso.eliminar');

Route::get('/compromiso/listCompromiso', [EmpresaController::class, 'listCompromiso'])->name('compromiso.listCompromiso');
Route::post('/compromiso/guardarAsigCompromiso', [EmpresaController::class, 'guardarAsigCompromiso'])->name('form.guardarAsigCompromiso');
Route::post('/compromiso/cargarAsigCompromiso', [EmpresaController::class, 'cargarAsigCompromiso'])->name('compromiso.cargarAsigCompromiso');
Route::post('/compromiso/infoAsigCompromiso', [EmpresaController::class, 'infoAsigCompromiso'])->name('compromiso.infoAsigCompromiso');
Route::post('/compromiso/eliminarAsignacionCompromiso', [EmpresaController::class, 'eliminarAsignacionCompromiso'])->name('compromiso.eliminarAsignacionCompromiso');

/// GESTION DE CONCEPTOS DE PAGOS
Route::get('/Conceptos', function () {
    return view('Conceptos');
});
Route::post('/conceptos/cargarConceptos', [EmpresaController::class, 'cargarConceptos'])->name('conceptos.cargarConceptos');
Route::post('/conceptos/guardar', [EmpresaController::class, 'guardarConcepto'])->name('form.guardarConcepto');
Route::post('/conceptos/infoConceptos', [EmpresaController::class, 'infoConceptos'])->name('conceptos.infoConceptos');
Route::post('/conceptos/eliminar', [EmpresaController::class, 'eliminarConcepto'])->name('conceptos.eliminar');
Route::get('/conceptos/listConcepto', [EmpresaController::class, 'listConcepto'])->name('conceptos.listConcepto');
Route::post('/conceptos/guardarAsigConcepto', [EmpresaController::class, 'guardarAsigConcepto'])->name('form.guardarAsigConcepto');
Route::post('/conceptos/cargarAsigConcepto', [EmpresaController::class, 'cargarAsigConcepto'])->name('conceptos.cargarAsigConcepto');
Route::post('/conceptos/infoAsigConceptos', [EmpresaController::class, 'infoAsigConceptos'])->name('conceptos.infoAsigConceptos');
Route::post('/conceptos/eliminarAsignacionConcepto', [EmpresaController::class, 'eliminarAsignacionConcepto'])->name('conceptos.eliminarAsignacionConcepto');

Route::post('/conceptos/pagosConceptos', [EmpresaController::class, 'pagosConceptos'])->name('conceptos.pagosConceptos');
Route::post('/conceptos/actualizarEstado', [EmpresaController::class, 'actualizarEstado'])->name('conceptos.actualizarEstado');


/// GESTIONAR USUARIOS
Route::get('/Usuarios', function () {
    return view('Usuarios');
});
Route::post('/usuario/cargarUsuarios', [UsuariosController::class, 'cargarUsuarios'])->name('usuario.cargarUsuarios');
Route::post('/usuario/verificar-usuario', [UsuariosController::class, 'verificarUsuario'])->name('usuario.verificar-usuario');
Route::post('/usuario/guardar', [UsuariosController::class, 'guardarUsuario'])->name('form.guardarUsusario');
Route::post('/usuario/infoUsuarios', [UsuariosController::class, 'infoUsuarios'])->name('usuario.infoUsuarios');
Route::post('/usuario/eliminar', [EmpresaController::class, 'eliminarUsuario'])->name('usuario.eliminar');


Route::get('/compromiso-avance/datosDashboard', [ApiController::class, 'datosDashboard'])->name('compromiso.datosDashboard');
Route::get('/compromiso/listTodosCompromisos', [ApiController::class, 'listTodosCompromisos'])->name('compromiso.listTodosCompromisos');
Route::post('/compromiso/cambiarEstadoCompromiso', [ApiController::class, 'cambiarEstadoCompromiso'])->name('compromiso.cambiarEstadoCompromiso');
Route::get('/avance/avanceContable', [ApiController::class, 'avanceContable'])->name('avance.avanceContable');
Route::get('/avance/cambiar-estado-pago', [ApiController::class, 'cambiarEstadoPago'])->name('avance.cambiarEstadoPago');
Route::get('/compromiso-avance/notificaciones', [ApiController::class, 'notificaciones'])->name('compromiso.notificaciones');
Route::post('/notas/guardar-nota', [ApiController::class, 'guardarNota'])->name('notas.guardarNota');
Route::get('/notas/listar-notas', [ApiController::class, 'listarNotas'])->name('notas.listarNotas');
Route::post('/notas/editar-nota', [ApiController::class, 'editarNota'])->name('notas.editarNota');