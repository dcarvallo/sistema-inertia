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
    <h4 class="text-center">Usuarios</h4>
    <table  class="table table-bordered table-striped table-sm">
      <thead class="bg-secondary text-white">
        <tr >
          <th class="text-center">Nro</th>
          <th class="text-center">Nombre Completo</th>
          <th class="text-center">Nombre de Usuario</th>
          <th class="text-center">Email</th>
          <th class="text-center">Activo</th>
          <th class="text-center">Rol</th>
        </tr>
      </thead>
      <tbody>
        @foreach($datos as $usuario)
        <tr>
          <td class="text-center">{{$loop->index + 1}}</td>
          <td>{{$usuario->name}}</td>
          <td>{{$usuario->username}}</td>
          <td>{{$usuario->email}}</td>
          <td class="text-center">{{$usuario->activo ? 'Si':'No'}}</td>
          <td>
            @if($usuario->roles)
            <ul style="padding-left: 15px">
              @foreach($usuario->roles as $rol)
              <li>
                {{$rol->name}}
              </li>
              @endforeach
            </ul>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
</body>
</html>
