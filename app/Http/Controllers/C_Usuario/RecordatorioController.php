<?php

namespace App\Http\Controllers\C_Usuario;

use App\Http\Controllers\Controller;
use App\Models\Recordatorio;
use App\Models\Bitacora;
use Illuminate\Http\Request;
use Auth;
use Inertia\Inertia;

class RecordatorioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if (Auth::user()->hasRole('Inactivo')) abort(403);

      $recordatorios = Recordatorio::where('user_id', Auth::user()->id)->get();
      $titulo = 'Calendario';
      $breadcrumb = array(
        ['nombre' => 'Calendario', 'enlace' => '#'],
      );
      return Inertia::render('Usuario/Calendario', compact('titulo', 'breadcrumb', 'recordatorios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      if(Auth::user()->hasRole('Inactivo') || !$request->ajax()) abort(403);
      
      $this->validate($request, [
        'title' => 'required|string',
        'descripcion' => 'required|string',
        'start' => 'date|required',
        'end' => 'required',
        'duracion' => 'required'
        ]);
      try {
          // logger($request->end->format('Y-m-d H:m');
        $recordatorio = new Recordatorio();
        $recordatorio->title = $request->title;
        $recordatorio->descripcion = $request->descripcion;
        $recordatorio->start = $request->start;
        $recordatorio->end = $request->end;
        $recordatorio->session = $request->duracion;
        $recordatorio->user_id = Auth::user()->id;
        $recordatorio->save();

        $bitacora = new Bitacora();
        $bitacora->mensaje = 'Se creó el recordatorio '.$recordatorio->title;
        $bitacora->registro_id = $recordatorio->id;
        $bitacora->user_id = Auth::user()->id;
        $bitacora->save();
        
        $toast = array(
          'title'   => 'Recordatorio creado: ',
          'message' => $recordatorio->title,
          'type' => 'success'
        );

        return back()->with('mensaje', $toast);
        
      } catch (\Throwable $th) {
        logger($th);
          $toast = array(
            'title'   => 'Error',
            'message' => $th,
            'type'    => 'error',
          );
          return back()->with('mensaje', $toast);
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recordatorio  $recordatorio
     * @return \Illuminate\Http\Response
     */
    public function show(Recordatorio $recordatorio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Recordatorio  $recordatorio
     * @return \Illuminate\Http\Response
     */
    public function edit(Recordatorio $recordatorio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Recordatorio  $recordatorio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recordatorio $recordatorio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recordatorio  $recordatorio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recordatorio $recordatorio)
    {
        //
    }
}
