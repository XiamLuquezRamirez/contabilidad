<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\UsuariosController;


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
Route::post('/verificar-nit', [EmpresaController::class, 'verificarNIT']);
Route::post('/empresa/guardar', [EmpresaController::class, 'guardarEmpresa'])->name('form.guardarEmpresa');
Route::post('/empresa/cargarEmpresas', [EmpresaController::class, 'cargarEmpresas'])->name('empresa.cargarEmpresas');
Route::post('/empresa/infoEmpresa', [EmpresaController::class, 'infoEmpresa'])->name('empresa.infoEmpresa');
Route::post('/empresa/eliminar', [EmpresaController::class, 'eliminarEmpresa'])->name('empresa.eliminar');

///GESTIONAR COMPROMISOS
Route::get('/Compromisos', function () {
    return view('Compromisos');
});

Route::post('/compromiso/cargarCompromisos', [EmpresaController::class, 'cargarCompromisos'])->name('empresa.cargarCompromisos');
Route::post('/compromiso/guardar', [EmpresaController::class, 'guardarCompromiso'])->name('form.guardarCompromiso');
Route::post('/compromiso/infoCompromiso', [EmpresaController::class, 'infoCompromiso'])->name('compromiso.infoCompromiso');
Route::post('/compromiso/eliminar', [EmpresaController::class, 'eliminarCompromiso'])->name('compromiso.eliminar');

Route::get('/compromiso/listCompromiso', [EmpresaController::class, 'listCompromiso'])->name('compromiso.listCompromiso');
Route::post('/compromiso/guardarAsigCompromiso', [EmpresaController::class, 'guardarAsigCompromiso'])->name('form.guardarAsigCompromiso');
Route::post('/compromiso/cargarAsigCompromiso', [EmpresaController::class, 'cargarAsigCompromiso'])->name('compromiso.cargarAsigCompromiso');
Route::post('/compromiso/infoAsigCompromiso', [EmpresaController::class, 'infoAsigCompromiso'])->name('compromiso.infoAsigCompromiso');

