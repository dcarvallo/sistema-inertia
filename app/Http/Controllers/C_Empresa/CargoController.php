<?php

namespace App\Http\Controllers\C_Empresa;

use App\Http\Controllers\Controller;
use App\Models\M_Empresa\Area;
use App\Models\M_Empresa\Cargo;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DatosExport;
use App\Models\Bitacora;
use Auth;
use Inertia\Inertia;

class CargoController extends Controller
{

    public function index()
    {
      if(!Auth::user()->can('Navegar-cargos') || Auth::user()->hasRole('Inactivo')) abort(403);
      $titulo = 'Cargos';
      $breadcrumb = array(
        ['nombre' => 'Cargos', 'enlace' => '#'],
      );
      return Inertia::render('Empresa/cargo/Index', compact('titulo', 'breadcrumb'));
    }

    public function obtenercargos(Request $request)
    {
      if(!Auth::user()->can('Navegar-cargos') || Auth::user()->hasRole('Inactivo') || !$request->ajax()) abort(403);

      try {
      
        $columns = ['nombre', 'descripcion', 'area_id', 'ver','editar', 'eliminar'];

        $length = $request->input('length');
        $column = $request->input('column');
        $dir = $request->input('dir');
        $searchValue = $request->input('search');
        $searchColumn = $request->input('searchColumn');
        
        $query = Cargo::select('id', 'nombre', 'descripcion', 'area_id')->with('Area')->orderBy($columns[$column], $dir);

        if ($searchValue) {
          $query->where(function($query) use ($searchValue, $searchColumn) {
            $query->where($searchColumn, 'like', '%' . $searchValue . '%');
          });
        }
        if ($searchValue && $searchColumn == 'area_id') {
          $query = Cargo::select('cargos.id', 'cargos.nombre', 'cargos.descripcion', 'cargos.area_id','areas.nombre as nombre');
            $query->where(function($query) use ($searchValue) {
            $query->join('areas', 'areas.id', '=', 'cargos.area_id')
                  ->where('areas.nombre', 'like', '%' . $searchValue . '%');
          });
        }
        if($searchColumn == 'area_id'){
          $cargos = $query->get();
        }
        else
        $cargos = $query->paginate($length);
        return ['data' => $cargos, 'draw' => $request->input('draw')];
         
      } catch (\Throwable $th) {
        return $th;
      }
    }

    public function create()
    {
      if(!Auth::user()->can('Crear-cargos') || Auth::user()->hasRole('Inactivo')) abort(403);

      $areas = Area::all('id', 'nombre');
      $cargos = Cargo::all('id', 'nombre');
      $titulo = 'Cargos';
      $breadcrumb = array(
        ['nombre' => 'Cargos', 'enlace' => '/cargos'],
        ['nombre' => 'Crear', 'enlace' => '#'],
      );
      return Inertia::render('Empresa/cargo/Crear', compact('areas', 'cargos', 'titulo', 'breadcrumb'));
    }

    public function store(Request $request)
    {
      if(!Auth::user()->can('Crear-cargos') || Auth::user()->hasRole('Inactivo') || !$request->ajax()) abort(403);

      $this->validate($request, [
          'nombre' => 'required|string',
          'descripcion' => 'required|string',
          'nivel' => 'required|integer',
          'tipo' => 'required|string',
          'dependiente' => 'required|integer',
          'area_id' => 'required',
      ]);
      try {
        
        $cargo = new Cargo();
        $cargo->nombre = $request->nombre;
        $cargo->descripcion = $request->descripcion;
        $cargo->dependiente = $request->dependiente;
        $cargo->nivel = $request->nivel;
        $cargo->tipo = $request->tipo;
        $cargo->area_id = $request->area_id;
        $cargo->save();

        $bitacora = new Bitacora();
        $bitacora->mensaje = 'Se creó el cargo '.$cargo->nombre;
        $bitacora->registro_id = $cargo->id;
        $bitacora->user_id = Auth::user()->id;
        $bitacora->save();
        
        $toast = array(
          'title'   => 'Cargo creado: ',
          'message' => $cargo->nombre,
          'background' => '#e1f6d0',
          'type' => 'success'
        );

        return back()->with('mensaje', $toast);
        
      } catch (\Throwable $th) {
          $toast = array(
            'title'   => 'Error',
            'message' => '',
            'type'    => 'error',
            'background' => '#edc3c3'
          );
          return back()->with('mensaje', $toast);
      }

    }

    public function show(Cargo $cargo)
    {
      if(!Auth::user()->can('Ver-cargos') || Auth::user()->hasRole('Inactivo')) abort(403);
      $dependiente = Cargo::where('id', $cargo->dependiente)->first('nombre');
      $cargo->load('area');
      $titulo = 'Cargos';
      $breadcrumb = array(
        ['nombre' => 'Cargos', 'enlace' => '/cargos'],
        ['nombre' => 'Ver', 'enlace' => '#'],
      );
      return Inertia::render('Empresa/cargo/Ver', compact('cargo', 'dependiente', 'titulo', 'breadcrumb'));
    }

    public function edit(Cargo $cargo)
    {
      if(!Auth::user()->can('Editar-cargos') || Auth::user()->hasRole('Inactivo')) abort(403);
      
      $areas = Area::select('id', 'nombre')->get()->toArray();
      $cargos = Cargo::all('id', 'nombre');
      $titulo = 'Cargos';
      $breadcrumb = array(
        ['nombre' => 'Cargos', 'enlace' => '/cargos'],
        ['nombre' => 'Editar', 'enlace' => '#'],
      );
      return Inertia::render('Empresa/cargo/Editar', compact('cargo', 'areas', 'cargos', 'titulo', 'breadcrumb'));
    }

    public function update(Request $request, Cargo $cargo)
    {
      if(!Auth::user()->can('Editar-cargos') || Auth::user()->hasRole('Inactivo') || !$request->ajax()) abort(403);

      $this->validate($request, [
        'nombre' => 'required|string',
        'descripcion' => 'required|string',
        'nivel' => 'required|integer',
        'tipo' => 'required|string',
        'dependiente' => 'required|integer',
        'area_id' => 'required'
        ]);
        
      try {
        $cargo->nombre = $request->nombre;
        $cargo->descripcion = $request->descripcion;
        $cargo->dependiente = $request->dependiente;
        $cargo->nivel = $request->nivel;
        $cargo->tipo = $request->tipo;
        $cargo->area_id = $request->area_id;
        $cargo->save();

        $bitacora = new Bitacora();
        $bitacora->mensaje = 'Se editó el cargo '.$cargo->nombre;
        $bitacora->registro_id = $cargo->id;
        $bitacora->user_id = Auth::user()->id;
        $bitacora->save();
        
        $toast = array(
            'title'   => 'Cargo modificado: ',
            'message' => $cargo->nombre,
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

    public function destroy(Request $request, Cargo $cargo)
    {
      if(!Auth::user()->can('Eliminar-cargos') || Auth::user()->hasRole('Inactivo') || !$request->ajax()) abort(403);
      
      // if($cargo->empleado()->count())
      // {
      //   $toast = array(
      //     'title'   => 'Error: ',
      //     'message' => 'No se puede quitar, cargo tiene empleados dependientes',
      //     'type'    => 'error',
      //     'background' => '#edc3c3'
      //   );
      //   return back()->with('mensaje', $toast);
      // }
      $cargo->delete();

      $bitacora = new Bitacora();
      $bitacora->mensaje = 'Se eliminó el cargo '.$cargo->nombre;
      $bitacora->registro_id = $cargo->id;
      $bitacora->user_id = Auth::user()->id;
      $bitacora->save();

      $toast = array(
        'background' => '#e1f6d0',
        'type' => 'success',
        'title'   => 'Cargo eliminado: ',
        'message' => '',
      );
      return back()->with('mensaje', $toast);
    }

    public function exportar(Request $request){
    
      if(!Auth::user()->can('Exportar-cargos') || Auth::user()->hasRole('Inactivo')) abort(403);

      $this->validate($request, [
        'datobusqueda' => "string|nullable",
        'busquedacolumna' => "in:nombre,descripcion,area_id",
        'exportar' => 'in:pdf,excel'
      ]);

      if($request->datobusqueda)
        $datos = Cargo::select('id','nombre','descripcion','area_id')->where($request->busquedacolumna, 'like', '%' . $request->datobusqueda . '%')->orderBy($request->busquedacolumna)->with('area')->get();
      else
        $datos = Cargo::select('id','nombre','descripcion','area_id')->with('area')->get();
      
      $vista = (string) "exports.lista-cargos";

      if($request->exportar == "pdf")
        return PDF::loadView($vista, compact('datos'))->download('exportado.pdf');
  
      if($request->exportar == "excel")
        return Excel::download(new DatosExport($vista,$datos), 'exportado.xlsx');
        
    }
}
