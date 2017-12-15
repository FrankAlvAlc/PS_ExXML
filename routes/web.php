<?php

Route::get('/', function () {
    return view('login');
});

Route::post('Login','Usuarios_Login_Controller@Login');

Route::get('Login','Usuarios_Login_Controller@index');

Route::get('LogOut','Usuarios_Login_Controller@LogOut');

Route::get('Menu','Menu_Principal_Controller@index');

Route::get('CFDI/Extraer','CFDI_Controller@index');

Route::post('CFDI/Cargar','CFDI_Controller@Cargar_Archivos');

Route::get('CFDI/Cargar',function(){
  return redirect('CFDI/Extraer');
});

Route::post('/Cargar','CFDI_Controller@Cargar_Archivos');


Route::resource('excel','ExcelController');
