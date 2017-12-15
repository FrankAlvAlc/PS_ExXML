<?php

Route::get('/', function () {
    return view('login');
});

Route::post('Login','Usuarios_Login_Controller@Login');
Route::get('Login','Usuarios_Login_Controller@index');

Route::get('Menu','Menu_Principal_Controller@index');


Route::get('CFDI/Renombrar','CFDI_Controller@index');
Route::post('CFDI/Cargar','CFDI_Controller@Cargar_Archivos');
Route::post('/Cargar','CFDI_Controller@Cargar_Archivos');

Route::get('Usuarios/Crear','Usuarios_Controller@index');
Route::post('Usuarios/BColaborador','Usuarios_Controller@BColaborador');
Route::post('Usuarios/DatosColab','Usuarios_Controller@DatosColab');
Route::post('Usuarios/CrearNuevo','Usuarios_Controller@CrearNuevo');
