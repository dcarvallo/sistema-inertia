<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="{{public_path('css/app.css')}}">

  <title>Exportado</title>
</head>
<body>
    <h4 class="text-center">Ubicaciones</h4>
    <table  class="table table-bordered table-striped table-sm">
      <thead class="bg-secondary text-white">
        <tr >
          <th class="text-center">Nro</th>
          <th class="text-center">Nombre</th>
          <th class="text-center">Descripción</th>
          <th class="text-center">Locación</th>
          <th class="text-center">Empresa</th>
        </tr>
      </thead>
      <tbody>
        @foreach($datos as $ubicacion)
        <tr>
          <td class="text-center">{{$loop->index + 1}}</td>
          <td>{{$ubicacion->nombre}}</td>
          <td>{{$ubicacion->descripcion}}</td>
          <td>{{$ubicacion->locacion}}</td>
          <td>{{$ubicacion->empresa->nombre}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
</body>
</html>
