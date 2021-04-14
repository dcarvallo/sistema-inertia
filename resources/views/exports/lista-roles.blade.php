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
    <h4 class="text-center">Roles</h4>
    <table  class="min-w-full divide-y divide-gray-200 table table-bordered container striped my-2">
      <thead class="bg-gray-800 text-white">
        <tr >
          <th class="text-center">Nro</th>
          <th class="text-center">Nombre</th>
          <th class="text-center">Descripción</th>
          <th class="text-center">Categoría</th>
        </tr>
      </thead>
      <tbody>
        @foreach($datos as $rol)
        <tr>
          <td class="text-center">{{$loop->index + 1}}</td>
          <td>{{$rol->name}}</td>
          <td>{{$rol->description}}</td>
          <td>{{$rol->category}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
</body>
</html>
