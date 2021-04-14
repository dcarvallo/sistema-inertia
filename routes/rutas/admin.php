<?php

use Illuminate\Support\Facades\Route;

//admin
Route::middleware(['auth', 'preventbackhistory'])->group(function () {
	
  Route::get('admin', 'C_Admin\AdminController@index')->name('admin.index');

	Route::get('filemanager', 'C_Admin\AdminController@gestionararchivos')->name('admin.archivos');
	
	//Roles
	Route::post('roles/store', 'C_Admin\RoleController@store')->name('roles.store');

	Route::get('roles', 'C_Admin\RoleController@index')->name('roles.index');

	Route::get('roles/create', 'C_Admin\RoleController@create')->name('roles.create');

	Route::put('roles/{role}', 'C_Admin\RoleController@update')->name('roles.update');

	Route::get('roles/{role}', 'C_Admin\RoleController@show')->name('roles.show');

	Route::delete('roles/{role}', 'C_Admin\RoleController@destroy')->name('roles.destroy');

	Route::get('roles/{role}/edit', 'C_Admin\RoleController@edit')->name('roles.edit');
    
  Route::get('obtenerroles', 'C_Admin\RoleController@obtenerroles');

  Route::post('exportar-roles', 'C_Admin\RoleController@exportar')->name('roles.exportar');

  Route::post('mensajegeneral', 'C_Admin\AdminController@notificaciongeneral')->name('mensajegeneral');

  //Permissions
  
  Route::post('permisos/store', 'C_Admin\PermissionController@store')->name('permisos.store');

	Route::get('permisos', 'C_Admin\PermissionController@index')->name('permisos.index');

	Route::get('permisos/create', 'C_Admin\PermissionController@create')->name('permisos.create');

	Route::put('permisos/{permission}', 'C_Admin\PermissionController@update')->name('permisos.update');

	Route::get('permisos/{permission}', 'C_Admin\PermissionController@show')->name('permisos.show');

	Route::delete('permisos/{permission}', 'C_Admin\PermissionController@destroy')->name('permisos.destroy');

	Route::get('permisos/{permission}/edit', 'C_Admin\PermissionController@edit')->name('permisos.edit');
    
  Route::get('obtenerpermisos', 'C_Admin\PermissionController@obtenerpermisos');


});