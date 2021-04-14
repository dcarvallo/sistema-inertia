<?php

namespace App\Http\Controllers\C_Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DatosExport;
use App\Models\Bitacora;
use DB;
use Auth;
use Inertia\Inertia;

class RoleController extends Controller
{
    
    public function index()
    {
      if(!Auth::user()->can('Navegar-roles') || Auth::user()->hasRole('Inactivo')) abort(403);
      $titulo = 'Roles';
      $breadcrumb = array(
        ['nombre' => 'Roles', 'enlace' => '#'],
      );
      return Inertia::render('Admin/Roles/Index', compact('titulo', 'breadcrumb'));
    }

    public function obtenerroles(Request $request)
    {
      if(!Auth::user()->can('Navegar-roles') || Auth::user()->hasRole('Inactivo') || !$request->ajax()) abort(403);

      $columns = ['name', 'description', 'category', 'ver', 'editar', 'eliminar'];

      $length = $request->input('length');
      $column = $request->input('column');
      $dir = $request->input('dir');
      $searchValue = $request->input('search');
      $searchColumn = $request->input('searchColumn');

      $query = Role::select('id', 'name', 'description','category')->whereNotIn('name',['Inactivo','Super Admin'])->orderBy($columns[$column], $dir);
      
      if ($searchValue) {
        $query->where(function($query) use ($searchValue, $searchColumn) {
          $query->where($searchColumn, 'like', '%' . $searchValue . '%');
        });
      }

      $roles = $query->paginate($length);
      return ['data' => $roles, 'draw' => $request->input('draw')];
    }

    public function create()
    {
      if(!Auth::user()->can('Crear-roles') || Auth::user()->hasRole('Inactivo')) abort(403);

      $permisos2 = Permission::all()->whereNotIn('category', ['Admin'])->groupBy('category');

      $categorias = Role::select('category')->whereNotIn('category', ['Admin'])->groupBy('category')->pluck('category')->toArray();
      $titulo = 'Roles';
      $breadcrumb = array(
        ['nombre' => 'Roles', 'enlace' => '/roles'],
        ['nombre' => 'Crear', 'enlace' => '#'],
      );
      return Inertia::render('Admin/Roles/Crear', compact('categorias', 'permisos2', 'titulo', 'breadcrumb'));
    }

    public function store(Request $request)
    {
      if(!Auth::user()->can('Crear-roles') || Auth::user()->hasRole('Inactivo') || !$request->ajax()) abort(403);

      $this->validate($request, [
      'name' => 'required|string|unique:roles',
      'description' => 'required|string',
      'category' => 'required|string',
      ]);
      try {
        $rol = new Role();
        $rol->name = $request->name;
        $rol->guard_name = 'web';
        $rol->description = $request->description;
        $rol->category = $request->category;
        
        $rol->save();
        
        
        if($request->permisos)
        {
          $array = explode(",", $request->permisos);
          $rol->syncPermissions($array);
          cache()->tags('permisos')->flush();
        }
        
        $bitacora = new Bitacora();
        $bitacora->mensaje = 'Se creó el rol '.$rol->name;
        $bitacora->registro_id = $rol->id;
        $bitacora->user_id = Auth::user()->id;
        $bitacora->save();

        $toast = array(
          'title'   => 'Rol creado: ',
          'message' => $request->name,
          'background' => '#e1f6d0',
          'type' => 'success'
        );
        
        return back()->with('mensaje', $toast);
        
      } catch (\Throwable $th) {
        $toast = array(
          'title'   => 'Rol no creado: ',
          'message' => $rol->name,
          'type'    => 'error',
          'background' => '#edc3c3'
        );
        return back()->with('mensaje', $toast);
      }

    }

    public function show(Role $role)
    {
      if(!Auth::user()->can('Ver-roles') || Auth::user()->hasRole('Inactivo')) abort(403);
      if($role->id == 1 || $role->id == 2) return back();
      $permisos = $role->permissions;
      $titulo = 'Roles';
      $breadcrumb = array(
        ['nombre' => 'Roles', 'enlace' => '/roles'],
        ['nombre' => 'Ver', 'enlace' => '#'],
      );
      return Inertia::render('Admin/Roles/Ver', compact('role', 'permisos', 'titulo', 'breadcrumb'));   
    }

    public function edit($id)
    {
      if(!Auth::user()->can('Editar-roles') || Auth::user()->hasRole('Inactivo')) abort(403);

      $rol = Role::find($id);
      if($rol->id == 1 || $rol->id == 2) return back();

      $permisos2 = Permission::all()->whereNotIn('category', ['Admin'])->groupBy('category');

      $permisosseleccionados= $rol->permissions; 

      $categorias = Role::select('category')->whereNotIn('category', ['Admin'])->groupBy('category')->pluck('category')->toArray();
      $titulo = 'Roles';
      $breadcrumb = array(
        ['nombre' => 'Roles', 'enlace' => '/roles'],
        ['nombre' => 'Crear', 'enlace' => '#'],
      );
      return Inertia::render('Admin/Roles/Editar', compact('rol', 'permisos2' , 'categorias', 'permisosseleccionados', 'titulo', 'breadcrumb'));
    }

    public function update(Request $request, $id)
    {
      if(!Auth::user()->can('Editar-roles') || Auth::user()->hasRole('Inactivo') || !$request->ajax()) abort(403);

      $this->validate($request, [
        'name' => 'required|string',
        'description' => 'required|string',
        'category' => 'required|string',
        ]);
        try {
          $rol = Role::find($id);
          if($rol->id == 1 || $rol->id == 2) return back();
          $rol->name = $request->name;
          $rol->description = $request->description;
          $rol->category = $request->category;
          
          $rol->save();
          
          if($request->permisos)
          {
            $array = explode(",", $request->permisos);
            $rol->syncPermissions($array);
            cache()->tags('permisos')->flush();
          }
          
          $bitacora = new Bitacora();
          $bitacora->mensaje = 'Se editó el rol '.$rol->name;
          $bitacora->registro_id = $rol->id;
          $bitacora->user_id = Auth::user()->id;
          $bitacora->save();

          $toast = array(
            'title'   => 'Rol modificado: ',
            'message' => $request->name,
            'background' => '#e1f6d0',
            'type' => 'success'
          );
          
          return back()->with('mensaje', $toast);
          
        } catch (\Throwable $th) {
          $toast = array(
            'title'   => 'Rol no modificado: ',
            'message' => $rol->name,
            'type'    => 'error',
          'background' => '#edc3c3'
          );
          return back()->with('mensaje', $toast);
        }

    }

    public function destroy(Request $request,$id)
    {
      if(!Auth::user()->can('Eliminar-roles') || Auth::user()->hasRole('Inactivo') || !$request->ajax()) abort(403);
      
      try {

        $rol = Role::find($id);
        if($rol->id == 1 || $rol->id == 2) return back();

        $rol->delete();

        $bitacora = new Bitacora();
        $bitacora->mensaje = 'Se eliminó el rol '.$rol->name;
        $bitacora->registro_id = $rol->id;
        $bitacora->user_id = Auth::user()->id;
        $bitacora->save();

        $toast = array(
          'title'   => 'Rol eliminado: ',
          'message' => '',
          'background' => '#e1f6d0',
          'type' => 'success'
        );
        return back()->with('mensaje', $toast);
      } catch (\Throwable $th) {
        $toast = array(
          'title'   => 'Error al eliminar: ',
          'message' => '',
          'background' => '#edc3c3',
          'type' => 'error'
        );
        return back()->with('mensaje', $toast);
      }
    }

    public function exportar(Request $request){
    
      if(!Auth::user()->can('Exportar-roles') || Auth::user()->hasRole('Inactivo')) abort(403);
      
      $this->validate($request, [
        'datobusqueda' => "string|nullable",
        'busquedacolumna' => "in:username,name,email,activo",
        'exportar' => 'in:pdf,excel'
      ]);

      if($request->datobusqueda)
        $datos = Role::select('name','description','category')->where($request->busquedacolumna, 'like', '%' . $request->datobusqueda . '%')->orderBy($request->busquedacolumna)->get();
      else
        $datos = Role::select('name','description','category')->get();
      
      $vista = (string) "exports.lista-roles";

      if($request->exportar == "pdf")
        return PDF::loadView($vista, compact('datos'))->download('exportado.pdf');
        
      if($request->exportar == "excel")
        return Excel::download(new DatosExport($vista,$datos), 'exportado.xlsx');
  
    }
}
