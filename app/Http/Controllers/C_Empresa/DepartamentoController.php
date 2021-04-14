<?php

namespace App\Http\Controllers\C_Empresa;

use App\Http\Controllers\Controller;
use App\Models\M_Empresa\Departamento;
use App\Models\M_Empresa\Ubicacion;
use App\Models\M_Empresa\Cargo;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DatosExport;
use App\Models\Bitacora;
use Auth;
use Inertia\Inertia;

class DepartamentoController extends Controller
{

    public function index()
    {
      if(!Auth::user()->can('Navegar-departamentos') || Auth::user()->hasRole('Inactivo')) abort(403);
      $titulo = 'Departamentos';
      $breadcrumb = array(
        ['nombre' => 'Departamentos', 'enlace' => '#'],
      );
      return Inertia::render('Empresa/departamento/Index', compact('titulo', 'breadcrumb'));
    }

    public function obtenerdepartamentos(Request $request)
    {
      if(!Auth::user()->can('Navegar-departamentos') || Auth::user()->hasRole('Inactivo') || !$request->ajax()) abort(403);

      try {
      
        $columns = ['nombre', 'descripcion', 'encargado', 'ubicacion_id', 'ver','editar', 'eliminar'];

        $length = $request->input('length');
        $column = $request->input('column');
        $dir = $request->input('dir');
        $searchValue = $request->input('search');
        $searchColumn = $request->input('searchColumn');

        $query = Departamento::select('id', 'nombre', 'descripcion', 'encargado', 'ubicacion_id')->with('ubicacion')->orderBy($columns[$column], $dir);

        if ($searchValue) {
            $query->where(function($query) use ($searchValue, $searchColumn) {
                $query->where($searchColumn, 'like', '%' . $searchValue . '%');
            });
        }

        $departamentos = $query->paginate($length);
        return ['data' => $departamentos, 'draw' => $request->input('draw')];
         
      } catch (\Throwable $th) {
        //throw $th;
      }
    }

    public function create()
    {
      if(!Auth::user()->can('Crear-departamentos') || Auth::user()->hasRole('Inactivo')) abort(403);

      $cargos = Cargo::select('nombre')->get()->toArray();
      $ubicaciones = Ubicacion::select('id', 'nombre')->get()->toArray();
      $titulo = 'Departamentos';
      $breadcrumb = array(
        ['nombre' => 'Departamentos', 'enlace' => '/departamentos'],
        ['nombre' => 'Crear', 'enlace' => '#'],
      );
      return Inertia::render('Empresa/departamento/Crear', compact('ubicaciones', 'cargos', 'titulo', 'breadcrumb'));
    }

    public function store(Request $request)
    {
      if(!Auth::user()->can('Crear-departamentos') || Auth::user()->hasRole('Inactivo') || !$request->ajax()) abort(403);

      $this->validate($request, [
          'nombre' => 'required|string',
          'descripcion' => 'required|string',
          'encargado' => 'string',
          'ubicacion_id' => 'required'
      ]);
      try {
        
        $departamento = new Departamento();
        $departamento->nombre = $request->nombre;
        $departamento->descripcion = $request->descripcion;
        $departamento->encargado = $request->encargado;
        $departamento->ubicacion_id = $request->ubicacion_id;
        $departamento->save();

        $bitacora = new Bitacora();
        $bitacora->mensaje = 'Se creó el departamento '.$departamento->nombre;
        $bitacora->registro_id = $departamento->id;
        $bitacora->user_id = Auth::user()->id;
        $bitacora->save();
        
        $toast = array(
          'title'   => 'Departamento creado: ',
          'message' => $departamento->nombre,
          'background' => '#e1f6d0',
          'type' => 'success'
        );

        return back()->with('mensaje', $toast);
        
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

    public function show(Departamento $departamento)
    {
      if(!Auth::user()->can('Ver-departamentos') || Auth::user()->hasRole('Inactivo')) abort(403);
      $departamento->load('ubicacion');
      $titulo = 'Departamentos';
      $breadcrumb = array(
        ['nombre' => 'Departamentos', 'enlace' => '/departamentos'],
        ['nombre' => 'Ver', 'enlace' => '#'],
      );
      return Inertia::render('Empresa/departamento/Ver', compact('departamento', 'titulo', 'breadcrumb'));
    }

    public function edit(Departamento $departamento)
    {
      if(!Auth::user()->can('Editar-departamentos') || Auth::user()->hasRole('Inactivo')) abort(403);

      $cargos = Cargo::select('nombre')->get()->toArray();
      $ubicaciones = Ubicacion::select('id', 'nombre')->get()->toArray();
      $titulo = 'Departamentos';
      $breadcrumb = array(
        ['nombre' => 'Departamentos', 'enlace' => '/departamentos'],
        ['nombre' => 'Editar', 'enlace' => '#'],
      );
      return Inertia::render('Empresa/departamento/Editar', compact('departamento','cargos', 'ubicaciones', 'titulo', 'breadcrumb'));
    }

    public function update(Request $request, Departamento $departamento)
    {
      if(!Auth::user()->can('Editar-departamentos') || Auth::user()->hasRole('Inactivo') || !$request->ajax()) abort(403);
      $this->validate($request, [
        'nombre' => 'required|string',
        'descripcion' => 'required|string',
        'ubicacion_id' => 'required'
        ]);
      try {
        $departamento->nombre = $request->nombre;
        $departamento->descripcion = $request->descripcion;
        $departamento->encargado = $request->encargado;
        $departamento->ubicacion_id = $request->ubicacion_id;
        $departamento->save();
        
        $bitacora = new Bitacora();
        $bitacora->mensaje = 'Se editó el departamento '.$departamento->nombre;
        $bitacora->registro_id = $departamento->id;
        $bitacora->user_id = Auth::user()->id;
        $bitacora->save();

        $toast = array(
            'title'   => 'Departamento modificado: ',
            'message' => $departamento->nombre,
            'background' => '#e1f6d0',
            'type' => 'success'
        );

        return back()->with('mensaje', $toast);
       
      } catch (\Throwable $th) {
        $toast = array(
          'title'   => 'Error: ',
          'message' => 'Error inesperado, contacte al administrdor',
          'type'    => 'error',
          'background' => '#edc3c3'
      );

      return back()->with('mensaje', $toast);
      }
    }

    public function destroy(Request $request, Departamento $departamento)
    {
      if(!Auth::user()->can('Eliminar-departamentos') || Auth::user()->hasRole('Inactivo') || !$request->ajax()) abort(403);
      
      if($departamento->areas()->count())
      {
        $toast = array(
          'title'   => 'Error: ',
          'message' => 'No se puede quitar, departamento tiene areas dependientes',
          'type'    => 'error',
          'background' => '#edc3c3'
        );
        return back()->with('mensaje', $toast);
      }
      $departamento->delete();

      $bitacora = new Bitacora();
      $bitacora->mensaje = 'Se eliminó el departamento '.$departamento->nombre;
      $bitacora->registro_id = $departamento->id;
      $bitacora->user_id = Auth::user()->id;
      $bitacora->save();

      $toast = array(
        'background' => '#e1f6d0',
        'type' => 'success',
        'title'   => 'Departamento eliminado: ',
        'message' => '',
      );
      return back()->with('mensaje', $toast);
    }

    public function exportar(Request $request){
    
      if(!Auth::user()->can('Exportar-departamentos') || Auth::user()->hasRole('Inactivo')) abort(403);

      $this->validate($request, [
        'datobusqueda' => "string|nullable",
        'busquedacolumna' => "in:nombre,descripcion,encargado,ubicacion_id",
        'exportar' => 'in:pdf,excel'
      ]);

      if($request->datobusqueda)
        $datos = Departamento::select('id','nombre','descripcion','encargado','ubicacion_id')->where($request->busquedacolumna, 'like', '%' . $request->datobusqueda . '%')->orderBy($request->busquedacolumna)->with('ubicacion')->get();
      else
        $datos = Departamento::select('id','nombre','descripcion','encargado','ubicacion_id')->with('ubicacion')->get();
      
      $vista = (string) "exports.lista-departamentos";

      if($request->exportar == "pdf")
        return PDF::loadView($vista, compact('datos'))->download('exportado.pdf');

      if($request->exportar == "excel")
        return Excel::download(new DatosExport($vista,$datos), 'exportado.xlsx');
    }
}
