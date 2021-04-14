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
    <h4 class="text-center">{{$titulo}}</h4>
    <table  class="min-w-full divide-y divide-gray-200 table table-bordered container striped my-2">
      <thead class="bg-gray-800 text-white">
        <tr >
          @foreach($columnas as $col)
          <th class="text-center font-bold">{{$col}}</th>
          @endforeach
        </tr>
      </thead>
      <tbody>
        @foreach($datos as $dato)
        <tr>
          
          @foreach($columnas as $col)
            <td>{{ $dato[$col] }}</td>
          @endforeach
          
        </tr>
        @endforeach
      </tbody>
    </table>
</body>
</html>
