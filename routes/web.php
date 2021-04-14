<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
  if(Auth::check())
    return Inertia::location('/');
  else
    return Inertia::render('Auth/Login');
});

Route::middleware(['auth:sanctum', 'verified', 'preventbackhistory'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::middleware(['auth', 'preventbackhistory'])->group(function () {

	Broadcast::routes();
  //general
  Route::get('contactos', 'C_Usuario\UserController@contactos');
  Route::get('notimetodo', 'C_Usuario\UserController@notimetodo');

});