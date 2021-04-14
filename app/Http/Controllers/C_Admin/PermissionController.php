<?php

namespace App\Http\Controllers\C_Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use App\Models\Bitacora;
use DB;
use Auth;
use Inertia\Inertia;

class PermissionController extends Controller
{
    public function index()
    {
      if(!Auth::user()->can('Navegar-permisos') || Auth::user()->hasRole('Inactivo')) abort(403);
      $titulo = 'Permisos';
      $breadcrumb = array(
        ['nombre' => 'Permisos', 'enlace' => '#'],
      );
      return Inertia::render('Admin/Permisos/Index', compact('titulo', 'breadcrumb'));
    }

    public function obtenerpermisos(Request $request)
    {
      if(!Auth::user()->can('Navegar-permisos') || Auth::user()->hasRole('Inactivo')|| !$request->ajax()) abort(403);
      logger($request);
      $columns = ['category','name','description'];

      $length = $request->input('length');
      $column = $request->input('column');
      $dir = $request->input('dir');
      $searchValue = $request->input('search');
      $searchColumn = $request->input('searchColumn');

      $query = Permission::select('id', 'name','description','category')->orderBy($columns[$column], $dir);

      if ($searchValue) {
        $query->where(function($query) use ($searchValue, $searchColumn) {
          $query->where($searchColumn, 'like', '%' . $searchValue . '%');
        });
      }

      $permisos = $query->paginate($length);
      
      return ['data' => $permisos, 'draw' => $request->input('draw')];
    }

    public function create()
    {
      if(!Auth::user()->can('Crear-permisos') || Auth::user()->hasRole('Inactivo')) abort(403);

      $permisos = Permission::orderBy('name', 'asc')->get();
      $titulo = 'Permisos';
      $breadcrumb = array(
        ['nombre' => 'Permisos', 'enlace' => '/permisos'],
        ['nombre' => 'Crear', 'enlace' => '#'],
      );
      return view('admin.permisos.create', compact('permisos', 'titulo', 'breadcrumb'));;
    }

    public function store(Request $request)
    {
      if(!Auth::user()->can('Crear-permisos') || Auth::user()->hasRole('Inactivo') || !$request->ajax()) abort(403);

      $this->validate($request, [
        'name' => 'required|string',
        'description' => 'required|string',
        'category' => 'required|string',
        ]);
        try {
          $permiso = new Permission();
          $permiso->name = $request->name;
          $permiso->guard_name = 'web';
          $permiso->description = $request->description;
          $permiso->category = $request->category;
         
          $permiso->save();

          $bitacora = new Bitacora();
          $bitacora->mensaje = 'Se creó el permiso '.$permiso->name;
          $bitacora->registro_id = $permiso->id;
          $bitacora->user_id = Auth::user()->id;
          $bitacora->save();

          $toast = array(
            'title'   => 'permiso creado: ',
            'message' => $request->name,
            'background' => '#e1f6d0',
            'type'    => 'success'
          );
          
          return back()->with('mensaje', $toast);
          
        } catch (\Throwable $th) {
          $toast = array(
            'title'   => 'permiso no creado: ',
            'message' => $permiso->name,
            'type'    => 'error',
            'background' => '#edc3c3'
          );
          return back()->with('mensaje', $toast);
        }

    }

    public function show($id)
    {
      if(!Auth::user()->can('Ver-permisos') || Auth::user()->hasRole('Inactivo')) abort(403);

      $permiso = Permission::find($id);
      $titulo = 'Permisos';
      $breadcrumb = array(
        ['nombre' => 'Permisos', 'enlace' => '/permisos'],
        ['nombre' => 'Ver', 'enlace' => '#'],
      );
      return view('admin.permisos.show', compact('permiso', 'titulo', 'breadcrumb'));
    }

    // public function edit($id)
    // {
      // if(!Auth::user()->can('Editar-permisos') || Auth::user()->hasRole('Inactivo')) abort(403);
      
    //   $permiso = Permission::find($id);
    //   return view('admin.permisos.edit', compact('permiso'));
    // }

    // public function update(Request $request, $id)
    // {
      // if(!Auth::user()->can('Editar-permisos') || Auth::user()->hasRole('Inactivo')) abort(403);

    //   $this->validate($request, [
    //     'name' => 'required|string',
    //     'description' => 'required|string',
    //     'category' => 'required|string',
    //   ]);
    //   try {
    //     $permiso = Permission::find($id);
    //     $permiso->name = $request->name;
    //     $permiso->description = $request->description;
    //     $permiso->category = $request->category;
        
    //     $permiso->save();

          // $bitacora = new Bitacora();
          // $bitacora->mensaje = 'Se editó el permiso '.$permiso->name;
          // $bitacora->registro_id = $permiso->id;
          // $bitacora->user_id = Auth::user()->id;
          // $bitacora->save();
        
    //     $toast = array(
    //       'title'   => 'permiso modificado: ',
    //       'message' => $request->name,
    // 'background' => '#e1f6d0',
    //       'type'    => 'success'
    //     );
        
    //     return [$permiso,$toast];
        
    //   // } catch (\Throwable $th) {
    //   } catch (\Illuminate\Database\QueryException $e) {

    //     $toast = array(
    //       'title'   => 'permiso no modificado: ',
    //       'message' => $e->errorInfo,
    //       'type'    => 'error'
            // 'background' => '#edc3c3'
    //     );
    //     return [$request,$toast,$e->errorInfo];
    //   }

    // }
    
    // public function destroy($id)
    // {
      // if(!Auth::user()->can('Eliminar-permisos') || Auth::user()->hasRole('Inactivo')) abort(403);

    //   $permiso = Permission::find($id);
    //     $permiso->delete();
          // $bitacora = new Bitacora();
          // $bitacora->mensaje = 'Se eliminó el permiso '.$permiso->name;
          // $bitacora->registro_id = $permiso->id;
          // $bitacora->user_id = Auth::user()->id;
          // $bitacora->save();
    //     $toast = array(
    //       'title'   => 'permiso eliminado: ',
    //       'message' => '',
      // 'background' => '#e1f6d0',
    //       'type'    => 'success'
    //     );
    //     return $toast;
    // }
}
