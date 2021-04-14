<?php

namespace App\Http\Controllers\C_Admin;

use App\Events\NuevaNotificacion;
use App\Notifications\NotificacionGeneral;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Inertia\Inertia;

class AdminController extends Controller
{

    public function index()
    {
      if(!Auth::user()->can('Navegar-admin') || Auth::user()->hasRole('Inactivo')) abort(403);

      $chart = (new LarapexChart)->areaChart()
      ->setTitle('Ventas en 2020.')
      ->setSubtitle('Ventas fisicas vs Ventas digitales.')
      ->addData('Ventas fisicas', [40, 93, 35, 42, 18, 82])
      ->addData('Ventas digitales', [70, 29, 77, 28, 55, 45])
      ->setXAxis(['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'])
      ->toVue();

      $chart2 = (new LarapexChart)->horizontalBarChart()
      ->setTitle('Ubicacion 1 vs Ubicacion 2.')
      ->setSubtitle('Clientes atendidos.')
      ->setColors(['#FFC107', '#D32F2F'])
      ->addData('Ubicacion 1', [6, 9, 3, 4, 10, 8])
      ->addData('Ubicacion 2', [7, 3, 8, 2, 6, 4])
      ->setXAxis(['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'])
      ->toVue();
      
      return Inertia::render('Admin/Index', compact('chart', 'chart2'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function gestionararchivos()
    {
      if(!Auth::user()->can('permisos', 'Administrador-archivos') || Auth::user()->hasRole('Inactivo')) abort(403);

      return view('/filemanager');
    }

    public function notificaciongeneral(Request $request)
    {
      if(!Auth::user()->can('Navegar-admin') || Auth::user()->hasRole('Inactivo')) abort(403);
      
        $this->validate($request, [
          'mensaje' => 'required|string',
        ]);
      // try {
        //solo mensaje en tiempo real
        // broadcast(new NuevaNotificacion($request->mensaje));

        //notificacion al mismo usuario
        // Auth::user()->notify(new NotificacionGeneral($request->mensaje));

        //notificacion a todos menos a si mismo
          User::all()->except(Auth::user()->id)->each(function(User $user) use($request){
            $user->notify(new NotificacionGeneral($request->mensaje));
          });
        
        // Auth::user()->notifications()->delete();

        $toast = array(
          'title'   => 'Notificacion',
          'message' => 'Notificacion enviada a los usuarios',
          'background' => '#e1f6d0',
          'type' => 'success'
        );
      // } catch (\Throwable $th) {
      //   $toast = array(
      //     'title'   => 'Error al enviar mensaje: ',
      //     'message' => $th,
      //     'type'    => 'error',
      //     'background' => '#edc3c3'
      //   );
      // }
      
      return $toast;
    }
}
