<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Auth;
use App\Models\M_Empresa\Empresa;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        
        if($request->user()){
          //redis
          
          $permisosusuario = cache()->tags('permisos')->get('usuario_'.$request->user()->id);  
          if ($permisosusuario == null ) {
            $perobj = $request->user()->getAllPermissions();
            $permisosarray = array();
            foreach($perobj as $permisos){
              array_push($permisosarray, $permisos->name);
            }
            cache()->tags('permisos')->put('usuario_'.$request->user()->id, $permisosarray);
            $permisosusuario = cache()->tags('permisos')->get('usuario_'.$request->user()->id);
          }
          $nombreempresa = cache()->tags('empresa')->get('nombre'); 
          if ($nombreempresa == null ) {
            $empresa = Empresa::first('nombre');
            cache()->tags('empresa')->put('nombre', $empresa);
          }
          cache()->tags('empresa')->get('nombre');
          $nombreempresa = cache()->tags('empresa')->get('nombre');
  
          $imagenempresa = cache()->tags('empresa')->get('imagen'); 
          if ($imagenempresa == null ) {
            $empresa2 = Empresa::first('imagen_empresa');
            cache()->tags('empresa')->put('imagen', $empresa2);
          }
          cache()->tags('empresa')->get('imagen');
          $imagenempresa = cache()->tags('empresa')->get('imagen');
              
          return array_merge(parent::share($request), [
            'permisos' => $permisosusuario,
            'user' => $request->user()->only('id', 'name', 'username', 'activo', 'email', 'fotografia'),
            'nombreempresa' => $nombreempresa,
            'imagenempresa' =>  $imagenempresa,
            'flash' => [
              'mensaje' => fn () => $request->session()->get('mensaje')
            ],
          ]);
          
        }
        else{
          return array_merge(parent::share($request), [
            
          ]);
        }
    }
}
