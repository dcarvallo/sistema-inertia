<?php

namespace App\Http\Controllers\C_Empresa;

use App\Http\Controllers\Controller;
use App\Models\M_Empresa\Empresa;
use App\Models\M_Empresa\Ubicacion;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DatosExport;
use App\Models\Bitacora;
use DB;
use Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class UbicacionController extends Controller
{

    public function index()
    {
      if(!Auth::user()->can('Navegar-ubicaciones') || Auth::user()->hasRole('Inactivo')) abort(403);
      $titulo = 'Ubicaciones';
      $breadcrumb = array(
        ['nombre' => 'Ubicaciones', 'enlace' => '#'],
      );
      return Inertia::render('Empresa/ubicacion/Index', compact('titulo','breadcrumb'));
    }

    public function obtenerubicaciones(Request $request)
    {
      if(!Auth::user()->can('Navegar-ubicaciones') || Auth::user()->hasRole('Inactivo') || !$request->ajax()) abort(403);

      try {
      
        $columns = ['nombre', 'descripcion', 'locacion'];

        $length = $request->input('length');
        $column = $request->input('column');
        $dir = $request->input('dir');
        $searchValue = $request->input('search');
        $searchColumn = $request->input('searchColumn');

        $query = Ubicacion::select('id', 'nombre', 'descripcion', 'locacion', 'empresa_id')->with('Empresa')->orderBy($columns[$column], $dir);

        if ($searchValue) {
            $query->where(function($query) use ($searchValue, $searchColumn) {
                $query->where($searchColumn, 'like', '%' . $searchValue . '%');
            });
        }

        $ubicaciones = $query->paginate($length);
        return ['data' => $ubicaciones, 'draw' => $request->input('draw')];
         
      } catch (\Throwable $th) {
        //throw $th;
      }
    }

    public function create()
    {
      if(!Auth::user()->can('Crear-ubicaciones') || Auth::user()->hasRole('Inactivo')) abort(403);
      $titulo = 'Ubicaciones';
      $breadcrumb = array(
        ['nombre' => 'Ubicaciones', 'enlace' => '/ubicaciones'],
        ['nombre' => 'Crear', 'enlace' => '#'],
      );
      return Inertia::render('Empresa/ubicacion/Crear', compact('titulo', 'breadcrumb'));
    }

    public function store(Request $request)
    {
      if(!Auth::user()->can('Crear-ubicaciones') || Auth::user()->hasRole('Inactivo')) abort(403);

      $this->validate($request, [
          'nombre' => 'required|string',
          'descripcion' => 'required|string',
          'locacion' => 'required|string'
      ]);
      try {
        $empresa = Empresa::first('id');
        
        if($empresa != null)
        {   
          $ubicacion = new Ubicacion();
          $ubicacion->nombre = $request->nombre;
          $ubicacion->descripcion = $request->descripcion;
          $ubicacion->locacion = $request->locacion;
          $ubicacion->empresa_id = $empresa->id;
          $ubicacion->save();

          $bitacora = new Bitacora();
          $bitacora->mensaje = 'Se creó la ubicación '.$ubicacion->nombre;
          $bitacora->registro_id = $ubicacion->id;
          $bitacora->user_id = Auth::user()->id;
          $bitacora->save();
          
          $toast = array(
            'title'   => 'Ubicación creada: ',
            'message' => $ubicacion->nombre,
            'background' => '#e1f6d0',
            'type' => 'success'
          );
  
          return back()->with('mensaje', $toast);
        }
        else
        {
          $toast = array(
            'title'   => 'error',
            'message' => 'No existe empresa creada',
            'type'    => 'error',
            'background' => '#edc3c3'
          );
          return back()->with('mensaje', $toast);
        }
      } catch (\Throwable $th) {
        $toast = array(
          'title'   => 'Error',
          'message' => $th,
          'type'    => 'error',
          'background' => '#edc3c3'
        );
        return back()->with('mensaje', $toast);
      }

    }

    public function show(Ubicacion $ubicacion)
    {
      if(!Auth::user()->can('Ver-ubicaciones') || Auth::user()->hasRole('Inactivo')) abort(403);
      $titulo = 'Ubicaciones';
      $breadcrumb = array(
        ['nombre' => 'Ubicaciones', 'enlace' => '/ubicaciones'],
        ['nombre' => 'Ver', 'enlace' => '#'],
      );
      return Inertia::render('Empresa/ubicacion/Ver', compact('ubicacion', 'titulo', 'breadcrumb'));
    }

    public function edit(Ubicacion $ubicacion)
    {
      if(!Auth::user()->can('Editar-ubicaciones') || Auth::user()->hasRole('Inactivo')) abort(403);
      $titulo = 'Ubicaciones';
      $breadcrumb = array(
        ['nombre' => 'Ubicaciones', 'enlace' => '/ubicaciones'],
        ['nombre' => 'Editar', 'enlace' => '#'],
      );
      return Inertia::render('Empresa/ubicacion/Editar', compact('ubicacion', 'titulo', 'breadcrumb'));
    }

    public function update(Request $request, Ubicacion $ubicacion)
    {
      if(!Auth::user()->can('Editar-ubicaciones') || Auth::user()->hasRole('Inactivo') ) abort(403);

      $this->validate($request, [
        'nombre' => 'required|string',
        'descripcion' => 'required|string',
        'locacion' => 'required|string'
      ]);
      try {
        $ubicacion->nombre = $request->nombre;
        $ubicacion->descripcion = $request->descripcion;
        $ubicacion->locacion = $request->locacion;
        $ubicacion->save();

        $bitacora = new Bitacora();
        $bitacora->mensaje = 'Se editó la ubicación '.$ubicacion->nombre;
        $bitacora->registro_id = $ubicacion->id;
        $bitacora->user_id = Auth::user()->id;
        $bitacora->save();
        
        $toast = array(
          'title'   => 'Información actualizada',
          'message' => '',
          'background' => '#e1f6d0',
          'type' => 'success'
      );

      return back()->with('mensaje', $toast);
       
      } catch (\Throwable $th) {
        $toast = array(
          'title'   => 'Error: ',
          'message' => 'Error inesperado, contacte al administrador, ',
          'type'    => 'error',
          'background' => '#edc3c3'
      );

      return back()->with('mensaje', $toast);
      }
    }

    public function destroy(Request $request, Ubicacion $ubicacion)
    {
      if(!Auth::user()->can('Eliminar-ubicaciones') || Auth::user()->hasRole('Inactivo')) abort(403);
      
      if($ubicacion->departamentos()->count())
      {
        $toast = array(
          'title'   => 'Error: ',
          'message' => 'No se puede quitar, ubicacion tiene departamentos dependientes',
          'type'    => 'error',
          'background' => '#edc3c3'
        );
        return back()->with('mensaje', $toast);
      }

      $ubicacion->delete();

      $bitacora = new Bitacora();
      $bitacora->mensaje = 'Se eliminó la ubicación '.$ubicacion->nombre;
      $bitacora->registro_id = $ubicacion->id;
      $bitacora->user_id = Auth::user()->id;
      $bitacora->save();

      $toast = array(
        'background' => '#e1f6d0',
        'type' => 'success',
        'title'   => 'Ubicación eliminada: ',
        'message' => '',
      );
      return back()->with('mensaje', $toast);
    }

    public function exportar(Request $request){
    
      if(!Auth::user()->can('Exportar-ubicaciones') || Auth::user()->hasRole('Inactivo')) abort(403);

      $this->validate($request, [
        'datobusqueda' => "string|nullable",
        'busquedacolumna' => "in:nombre,descripcion,locacion,empresa_id",
        'exportar' => 'in:pdf,excel'
      ]);

      if($request->datobusqueda)
      $datos = Ubicacion::select('id','nombre','descripcion','locacion','empresa_id')->where($request->busquedacolumna, 'like', '%' . $request->datobusqueda . '%')->orderBy($request->busquedacolumna)->with('empresa')->get();
      else
      $datos = Ubicacion::select('id','nombre','descripcion','locacion','empresa_id')->with('empresa')->get();
      
      $vista = (string) "exports.lista-ubicaciones";

      if($request->exportar == "pdf")
        return PDF::loadView($vista, compact('datos'))->download('exportado.pdf'); 
      
      if($request->exportar == "excel")
        return Excel::download(new DatosExport($vista,$datos), 'exportado.xlsx');
    }
}
