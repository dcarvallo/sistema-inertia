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
<h4 class="text-center">Cargos</h4>
    <table  class="table table-bordered table-striped table-sm">
      <thead class="bg-secondary text-white">
        <tr >
          <th class="text-center">Nro</th>
          <th class="text-center">Nombre</th>
          <th class="text-center">Descripción</th>
          <th class="text-center">Área</th>
        </tr>
      </thead>
      <tbody>
        @foreach($datos as $cargo)
        <tr>
          <td class="text-center">{{$loop->index + 1}}</td>
          <td>{{$cargo->nombre}}</td>
          <td>{{$cargo->descripcion}}</td>
          <td>{{$cargo->area->nombre}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
</body>
</html>
