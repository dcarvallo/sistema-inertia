<?php

namespace App\Http\Controllers\C_Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\M_Empresa\Empresa;
use App\Models\Bitacora;
use Intervention\Image\ImageManagerStatic as Image;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use File;
use Inertia\Inertia;

class EmpresaController extends Controller
{
  
    public function index()
    {
      if(!Auth::user()->can('Navegar-empresas') || Auth::user()->hasRole('Inactivo')) abort(403);

      $empresa = Empresa::first();
      $titulo = 'Empresa';
      $breadcrumb = array(
        ['nombre' => 'Empresa', 'enlace' => '#'],
      );
      return Inertia::render('Empresa/general/Index', compact('empresa','titulo', 'breadcrumb'));
      
    }

    public function create()
    {
      if(!Auth::user()->can('Crear-empresas') || Auth::user()->hasRole('Inactivo')) abort(403);
      $titulo = 'Empresa';
      $breadcrumb = array(
        ['nombre' => 'Empresa', 'enlace' => '/empresas'],
        ['nombre' => 'Crear', 'enlace' => '#'],
      );
      return Inertia::render('Empresa/general/Crear', compact('titulo', 'breadcrumb'));
      
    }

    public function store(Request $request)
    {
      if(!Auth::user()->can('Crear-empresas') || Auth::user()->hasRole('Inactivo')) abort(403);

      $this->validate($request, [
          'nombre' => 'required|string',
          'descripcion' => 'required|string',
          'rubro' => 'required|string',
          'nit' => 'required|integer',
          'propietario' => 'required|string',
          'email' => 'email|string|nullable',
          'direccion' => 'required|string',
          'fecha_creacion' => 'required',
      ]);

      $empresa = new Empresa();
      $empresa->nombre = $request->nombre;
      $empresa->descripcion = $request->descripcion;
      $empresa->rubro = $request->rubro;
      $empresa->nit = $request->nit;
      $empresa->propietario = $request->propietario;
      $empresa->mision = $request->mision;
      $empresa->vision = $request->vision;
      $empresa->direccion = $request->direccion;
      $empresa->telefono = $request->telefono;
      $empresa->email = $request->email;
      if($request->imagen_empresa)
      {
        //laravel intervention

        $ext = $request->imagen_empresa->getClientOriginalExtension();
        $fileName = str_random().'.'.$ext;
        //original
        $request->imagen_empresa->storeAs('archivos/empresa/', $fileName);
        //modificado
        $imagenmod = Image::make($request->imagen_empresa)->fit(300, 300);
        Storage::put('archivos/empresa/'.$fileName, $imagenmod->encode() );
        $empresa->imagen_empresa = 'archivos/empresa/'.$fileName;

      }
      $empresa->fecha_creacion = $request->fecha_creacion;
      
      $empresa->save();

      $bitacora = new Bitacora();
      $bitacora->mensaje = 'Se creó la empresa '.$empresa->nombre;
      $bitacora->registro_id = $empresa->id;
      $bitacora->user_id = Auth::user()->id;
      $bitacora->save();

      $toast = array(
        'title'   => 'Empresa creada: ',
        'message' => $empresa->nombre,
        'background' => '#e1f6d0',
        'type' => 'success'
      );

      return back()->with('mensaje', $toast);
    }

    public function show(Empresa $empresa)
    {
      
      if(!Auth::user()->can('Ver-empresas') || Auth::user()->hasRole('Inactivo')) abort(403);


    }

    public function edit(Empresa $empresa)
    {
      if(!Auth::user()->can('Editar-empresas') || Auth::user()->hasRole('Inactivo')) abort(403);
      $titulo = 'Empresa';
      $breadcrumb = array(
        ['nombre' => 'Empresa', 'enlace' => '/empresas'],
        ['nombre' => 'Editar', 'enlace' => '#'],
      );
      return Inertia::render('Empresa/general/Editar', compact('empresa', 'titulo', 'breadcrumb'));
      
    }

    public function update(Request $request, Empresa $empresa)
    {
      if(!Auth::user()->can('Editar-empresas') || Auth::user()->hasRole('Inactivo')) abort(403);

      $this->validate($request, [
          'nombre' => 'required|string',
          'descripcion' => 'required|string',
          'rubro' => 'required|string',
          'nit' => 'required|integer',
          'propietario' => 'required|string',
          'email' => 'email|string|nullable',
          'direccion' => 'required|string',
          'fecha_creacion' => 'required',
      ]);

      $empresa->nombre = $request->nombre;
      $empresa->descripcion = $request->descripcion;
      $empresa->rubro = $request->rubro;
      $empresa->nit = $request->nit;
      $empresa->propietario = $request->propietario;
      $empresa->mision = $request->mision;
      $empresa->vision = $request->vision;
      $empresa->direccion = $request->direccion;
      $empresa->telefono = $request->telefono;
      $empresa->email = $request->email;
      
      if ($request->imagen_empresa) {
        //laravel intervention

        $ext = $request->imagen_empresa->getClientOriginalExtension();
        $fileName = $request->nombre .'-'. Str::random(5) . '.' . $ext;
        //original
        $request->imagen_empresa->storeAs('archivos/empresa/','original-'. $fileName);
        //modificado
        $imagenmod = Image::make($request->imagen_empresa)->fit(300, 300);
        Storage::put('archivos/empresa/' . $fileName, $imagenmod->encode());

        $empresa->imagen_empresa = 'archivos/empresa/' . $fileName;
      } 
      $empresa->fecha_creacion = $request->fecha_creacion;
      
      $empresa->save();

      $bitacora = new Bitacora();
      $bitacora->mensaje = 'Se editó la empresa '.$empresa->nombre;
      $bitacora->registro_id = $empresa->id;
      $bitacora->user_id = Auth::user()->id;
      $bitacora->save();

      cache()->flush('datos-empresa');

      $toast = array(
        'title'   => 'Información modificada: ',
        'message' => $empresa->nombre,
        'background' => '#e1f6d0',
        'type' => 'success'
      );

      return back()->with('mensaje', $toast);
    }

    public function destroy(Empresa $empresa)
    {
      if(!Auth::user()->can('Eliminar-empresas') || Auth::user()->hasRole('Inactivo')) abort(403);
      
    }
}
