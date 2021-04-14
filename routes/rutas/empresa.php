<?php

use Illuminate\Support\Facades\Route;
Route::middleware(['auth', 'preventbackhistory'])->group(function () {

	//empresa
	Route::post('empresas/store', 'C_Empresa\EmpresaController@store')->name('empresas.store');

	Route::get('empresas', 'C_Empresa\EmpresaController@index')->name('empresas.index');

	Route::get('empresas/create', 'C_Empresa\EmpresaController@create')->name('empresas.create');

	Route::put('empresas/{empresa}', 'C_Empresa\EmpresaController@update')->name('empresas.update');

	Route::get('empresas/{empresa}', 'C_Empresa\EmpresaController@show')->name('empresas.show');

	Route::delete('empresas/{empresa}', 'C_Empresa\EmpresaController@destroy')->name('empresas.destroy');

	Route::get('empresas/{empresa}/edit', 'C_Empresa\EmpresaController@edit')->name('empresas.edit');

    //Ubicacion
    
  Route::get('obtenerubicaciones', 'C_Empresa\UbicacionController@obtenerubicaciones');

	Route::post('ubicaciones/store', 'C_Empresa\UbicacionController@store')->name('ubicaciones.store');

	Route::get('ubicaciones', 'C_Empresa\UbicacionController@index')->name('ubicaciones.index');

	Route::get('ubicaciones/create', 'C_Empresa\UbicacionController@create')->name('ubicaciones.create');

	Route::put('ubicaciones/{ubicacion}', 'C_Empresa\UbicacionController@update')->name('ubicaciones.update');

	Route::get('ubicaciones/{ubicacion}', 'C_Empresa\UbicacionController@show')->name('ubicaciones.show');

	Route::delete('ubicaciones/{ubicacion}', 'C_Empresa\UbicacionController@destroy')->name('ubicaciones.destroy');

	Route::get('ubicaciones/{ubicacion}/edit', 'C_Empresa\UbicacionController@edit')->name('ubicaciones.edit');

  Route::post('exportar-ubicaciones', 'C_Empresa\UbicacionController@exportar')->name('ubicacion.exportar');
    
  //Departamento
  Route::get('obtenerdepartamentos', 'C_Empresa\DepartamentoController@obtenerdepartamentos');

  Route::post('departamentos/store', 'C_Empresa\DepartamentoController@store')->name('departamentos.store');

  Route::get('departamentos', 'C_Empresa\DepartamentoController@index')->name('departamentos.index');

  Route::get('departamentos/create', 'C_Empresa\DepartamentoController@create')->name('departamentos.create');

  Route::put('departamentos/{departamento}', 'C_Empresa\DepartamentoController@update')->name('departamentos.update');

  Route::get('departamentos/{departamento}', 'C_Empresa\DepartamentoController@show')->name('departamentos.show');

  Route::delete('departamentos/{departamento}', 'C_Empresa\DepartamentoController@destroy')->name('departamentos.destroy');

  Route::get('departamentos/{departamento}/edit', 'C_Empresa\DepartamentoController@edit')->name('departamentos.edit');

  Route::post('exportar-departamentos', 'C_Empresa\DepartamentoController@exportar')->name('departamentos.exportar');

  //Area
  Route::get('obtenerareas', 'C_Empresa\AreaController@obtenerareas');

	Route::post('areas/store', 'C_Empresa\AreaController@store')->name('areas.store');

	Route::get('areas', 'C_Empresa\AreaController@index')->name('areas.index');

	Route::get('areas/create', 'C_Empresa\AreaController@create')->name('areas.create');

	Route::put('areas/{area}', 'C_Empresa\AreaController@update')->name('areas.update');

	Route::get('areas/{area}', 'C_Empresa\AreaController@show')->name('areas.show');

	Route::delete('areas/{area}', 'C_Empresa\AreaController@destroy')->name('areas.destroy');

	Route::get('areas/{area}/edit', 'C_Empresa\AreaController@edit')->name('areas.edit');

  Route::post('exportar-areas', 'C_Empresa\AreaController@exportar')->name('areas.exportar');

  //Cargo
  Route::get('obtenercargos', 'C_Empresa\CargoController@obtenercargos');

	Route::post('cargos/store', 'C_Empresa\CargoController@store')->name('cargos.store');

	Route::get('cargos', 'C_Empresa\CargoController@index')->name('cargos.index');

	Route::get('cargos/create', 'C_Empresa\CargoController@create')->name('cargos.create');

	Route::put('cargos/{cargo}', 'C_Empresa\CargoController@update')->name('cargos.update');

	Route::get('cargos/{cargo}', 'C_Empresa\CargoController@show')->name('cargos.show');

	Route::delete('cargos/{cargo}', 'C_Empresa\CargoController@destroy')->name('cargos.destroy');

	Route::get('cargos/{cargo}/edit', 'C_Empresa\CargoController@edit')->name('cargos.edit');

  Route::post('exportar-cargos', 'C_Empresa\CargoController@exportar')->name('cargos.exportar');

});