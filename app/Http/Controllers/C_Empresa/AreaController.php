<?php

namespace App\Http\Controllers\C_Empresa;

use App\Http\Controllers\Controller;
use App\Models\M_Empresa\Departamento;
use App\Models\M_Empresa\Area;
use App\Models\M_Empresa\Cargo;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DatosExport;
use App\Models\Bitacora;
use Auth;
use Inertia\Inertia;

class AreaController extends Controller
{

    public function index()
    {
      if(!Auth::user()->can('Navegar-areas') || Auth::user()->hasRole('Inactivo')) abort(403);
      $titulo = 'Áreas';
      $breadcrumb = array(
        ['nombre' => 'Áreas', 'enlace' => '#'],
      );
      return Inertia::render('Empresa/area/Index', compact('titulo', 'breadcrumb'));
    }

    public function obtenerareas(Request $request)
    {
      if(!Auth::user()->can('Navegar-areas') || Auth::user()->hasRole('Inactivo') || !$request->ajax()) abort(403);

      try {
      
        $columns = ['nombre', 'descripcion', 'encargado', 'departamento_id'];

        $length = $request->input('length');
        $column = $request->input('column');
        $dir = $request->input('dir');
        $searchValue = $request->input('search');
        $searchColumn = $request->input('searchColumn');
        
        $query = Area::select('id', 'nombre', 'descripcion', 'encargado', 'departamento_id')->with('departamento')->orderBy($columns[$column], $dir);

        if ($searchValue) {
          $query->where(function($query) use ($searchValue, $searchColumn) {
            $query->where($searchColumn, 'like', '%' . $searchValue . '%');
          });
        }

        $areas = $query->paginate($length);
        return ['data' => $areas, 'draw' => $request->input('draw')];
         
      } catch (\Throwable $th) {
        return $th;
      }
    }

    public function create()
    {
      if(!Auth::user()->can('Crear-areas') || Auth::user()->hasRole('Inactivo')) abort(403);

      $cargos = Cargo::select('nombre')->get()->toArray();
      $departamentos = Departamento::select('id', 'nombre')->get()->toArray();
      $titulo = 'Áreas';
      $breadcrumb = array(
        ['nombre' => 'Áreas', 'enlace' => '/areas'],
        ['nombre' => 'Crear', 'enlace' => '#'],
      );
      return Inertia::render('Empresa/area/Crear', compact('departamentos', 'cargos', 'titulo', 'breadcrumb'));
    }

    public function store(Request $request)
    {
      if(!Auth::user()->can('Crear-areas') || Auth::user()->hasRole('Inactivo') || !$request->ajax()) abort(403);

        $this->validate($request, [
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
            'encargado' => 'string|nullable',
            'departamento_id' => 'required'
        ]);
        try {

          $area = new Area();
          $area->nombre = $request->nombre;
          $area->descripcion = $request->descripcion;
          $area->encargado = $request->encargado;
          $area->departamento_id = $request->departamento_id;
          $area->save();
          
          $toast = array(
            'title'   => 'Area creada: ',
            'message' => $area->nombre,
            'background' => '#e1f6d0',
            'type' => 'success'
          );

          $bitacora = new Bitacora();
          $bitacora->mensaje = 'Se creó el área '.$area->nombre;
          $bitacora->registro_id = $area->id;
          $bitacora->user_id = Auth::user()->id;
          $bitacora->save();

          return back()->with('mensaje', $toast);
          
        } catch (\Throwable $th) {

          $toast = array(
            'title'   => 'Error',
            'messages' => '',
            'type'    => 'error',
            'background' => '#edc3c3'
          );

          return back()->with('mensaje', $toast);
        }

    }

    public function show(Area $area)
    {
      if(!Auth::user()->can('Ver-areas') || Auth::user()->hasRole('Inactivo')) abort(403);
      $area->load('departamento');
      $titulo = 'Áreas';
      $breadcrumb = array(
        ['nombre' => 'Áreas', 'enlace' => '/areas'],
        ['nombre' => 'Ver', 'enlace' => '#'],
      );
      return Inertia::render('Empresa/area/Ver', compact('area', 'titulo', 'breadcrumb'));
    }

    public function edit(Area $area)
    {
      if(!Auth::user()->can('Editar-areas') || Auth::user()->hasRole('Inactivo')) abort(403);

      $cargos = Cargo::select('nombre')->get()->toArray();
      $departamentos = Departamento::select('id', 'nombre')->get()->toArray();
      $titulo = 'Áreas';
      $breadcrumb = array(
        ['nombre' => 'Áreas', 'enlace' => '/areas'],
        ['nombre' => 'Editar', 'enlace' => '#'],
      );
      return Inertia::render('Empresa/area/Editar', compact('area','cargos', 'departamentos', 'titulo', 'breadcrumb'));
    }

    public function update(Request $request, Area $area)
    {
      if(!Auth::user()->can('Editar-areas') || Auth::user()->hasRole('Inactivo') || !$request->ajax()) abort(403);

      $this->validate($request, [
        'nombre' => 'required|string',
        'descripcion' => 'required|string',
        'encargado' => 'string|nullable',
        'departamento_id' => 'required'
        ]);
        
      try {
        $area->nombre = $request->nombre;
        $area->descripcion = $request->descripcion;
        $area->encargado = $request->encargado;
        $area->departamento_id = $request->departamento_id;
        $area->save();

        $bitacora = new Bitacora();
        $bitacora->mensaje = 'Se editó el área '.$area->nombre;
        $bitacora->registro_id = $area->id;
        $bitacora->user_id = Auth::user()->id;
        $bitacora->save();
        
        $toast = array(
            'title'   => 'Área modificada: ',
            'message' => $area->nombre,
            'background' => '#e1f6d0',
            'type' => 'success'
        );

        return back()->with('mensaje', $toast);
       
      } catch (\Throwable $th) {
        $toast = array(
          'title'   => 'Error: ',
          'message' => 'Error inesperado, contacte al administrdor, ',
          'type'    => 'error',
          'background' => '#edc3c3'
      );

      return back()->with('mensaje', $toast);
      }
    }

    public function destroy(Request $request, Area $area)
    {
      if(!Auth::user()->can('Eliminar-areas') || Auth::user()->hasRole('Inactivo')|| !$request->ajax()) abort(403);
      
      if($area->cargos()->count())
      {
        $toast = array(
          'title'   => 'Error: ',
          'message' => 'No se puede quitar, area tiene cargos dependientes',
          'type'    => 'error',
          'background' => '#edc3c3'
        );
        return back()->with('mensaje', $toast);
      }
      $area->delete();

      $bitacora = new Bitacora();
      $bitacora->mensaje = 'Se eliminó el área '.$area->nombre;
      $bitacora->registro_id = $area->id;
      $bitacora->user_id = Auth::user()->id;
      $bitacora->save();

      $toast = array(
        'background' => '#e1f6d0',
        'type' => 'success',
        'title'   => 'Area eliminada: ',
        'message' => '',
      );
      return back()->with('mensaje', $toast);
    }

    public function exportar(Request $request){
    
      if(!Auth::user()->can('Exportar-areas') || Auth::user()->hasRole('Inactivo')) abort(403);

      $this->validate($request, [
        'datobusqueda' => "string|nullable",
        'busquedacolumna' => "in:nombre,descripcion,encargado,departamento_id",
        'exportar' => 'in:pdf,excel'
      ]);

      if($request->datobusqueda)
        $datos = Area::select('id', 'nombre','descripcion','encargado','departamento_id')->where($request->busquedacolumna, 'like', '%' . $request->datobusqueda . '%')->orderBy($request->busquedacolumna)->with('departamento')->get();
      else
        $datos = Area::select('id', 'nombre','descripcion','encargado','departamento_id')->with('departamento')->get();
      
      $vista = (string) "exports.lista-areas";

      if($request->exportar == "pdf")
        return PDF::loadView($vista, compact('datos'))->download('exportado.pdf');
  
      if($request->exportar == "excel")
        return Excel::download(new DatosExport($vista,$datos), 'exportado.xlsx');
    }
}
