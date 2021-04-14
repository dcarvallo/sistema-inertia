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
    <h4 class="text-center">Departamentos</h4>
    <table  class="table table-bordered table-striped table-sm">
      <thead class="bg-secondary text-white">
        <tr >
          <th class="text-center">Nro</th>
          <th class="text-center">Nombre</th>
          <th class="text-center">Descripción</th>
          <th class="text-center">Encargado</th>
          <th class="text-center">Ubicación</th>
        </tr>
      </thead>
      <tbody>
        
        @foreach($datos as $departamento)
        <tr>
          <td class="text-center">{{ $loop->index + 1 }}</td>
          <td>{{$departamento->nombre}}</td>
          <td>{{$departamento->descripcion}}</td>
          <td>{{$departamento->encargado}}</td>
          <td>{{$departamento->ubicacion->nombre}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
</body>
</html>
