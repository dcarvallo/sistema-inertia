<?php

namespace App\Http\Controllers\C_Usuario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Http\Requests\Usuarios\StoreUsuario;
use App\Http\Requests\Usuarios\ResetPassword;
use App\Http\Requests\Usuarios\UpdateUsuario;
use Intervention\Image\ImageManagerStatic as Image;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DatosExport;
use App\Models\Bitacora;
use Storage;
use Session;
use Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;
class UserController extends Controller
{

  public function index()
  {
    if (!Auth::user()->can('Navegar-usuarios') || Auth::user()->hasRole('Inactivo')) abort(403);
    // $usuarios = User::orderBy('name', 'asc')->with('roles')->get();
    $titulo = 'Usuarios';
    $breadcrumb = array(['nombre' => 'Usuarios', 'enlace' => '#']);

    return Inertia::render('Admin/Usuarios/Index', compact('titulo', 'breadcrumb'));
  }

  public function obtenerusuarios(Request $request)
  {
    if (!Auth::user()->can('Navegar-usuarios') || Auth::user()->hasRole('Inactivo') || !$request->ajax() ) abort(403);
    
    $columns = ['name', 'username', 'email', 'activo'];

    $length = $request->input('length');
    $column = $request->input('column');
    $dir = $request->input('dir');
    $searchValue = $request->input('search');
    $searchColumn = $request->input('searchColumn');

    $query = User::select('id', 'name', 'username', 'email', 'activo')->with('roles')->orderBy($columns[$column], $dir);

    if ($searchValue) {
        $query->where(function ($query) use ($searchValue, $searchColumn) {
          $query->where($searchColumn, 'like', '%' . $searchValue . '%');
        }); 
    }

    $usuarios = $query->paginate($length);
    return ['data' => $usuarios, 'draw' => $request->input('draw')];
  }

  public function create()
  {
    if (!Auth::user()->can('Crear-usuarios') || Auth::user()->hasRole('Inactivo')) abort(403);

    $roles = Role::all()->groupBy('category')->toArray();
    unset($roles['Inactivo']);
    unset($roles['Admin']);
    $titulo = 'Usuarios';
    $breadcrumb = array(
      ['nombre' => 'Usuarios', 'enlace' => '/users'],
      ['nombre' => 'Crear', 'enlace' => '#'],
    );
    // ksort($roles);

    return Inertia::render('Admin/Usuarios/Crear', compact('roles', 'titulo', 'breadcrumb'));
  }

  public function store(StoreUsuario $request)
  {
    if (!Auth::user()->can('Crear-usuarios') || Auth::user()->hasRole('Inactivo')  || !$request->ajax()) abort(403);

    try {
      $usuario = new User();
      $usuario->nombres = $request->nombres;
      $usuario->apellidos = $request->apellidos;
      $usuario->name = $request->nombres . ' ' . $request->apellidos;
      $usuario->username = $request->username;
      $usuario->email = $request->email;
      $usuario->activo = $request->activo;
      $usuario->password = Hash::make($request->password);
      
      if ($request->imagen) {
        //laravel intervention

        $ext = $request->imagen->getClientOriginalExtension();
        $fileName = $usuario->username .'-'. Str::random(5) . '.' . $ext;
        //original
        $request->imagen->storeAs('usuarios/originales', $fileName);
        //modificado
        $imagenmod = Image::make($request->imagen)->fit(300, 300);
        Storage::put('usuarios/thumbnail/' . $fileName, $imagenmod->encode());

        $usuario->fotografia = 'usuarios/thumbnail/' . $fileName;
      } else {
        $usuario->fotografia = 'usuariodef/avatar.png';
      }

      $usuario->save();

      if ($usuario->activo == 0) {
        $usuario->assignRole('Inactivo');
      } else
        $usuario->removeRole('Inactivo');

      if ($request->roles) {
        $array = explode(",", $request->roles);
        $usuario->syncRoles($array);
        cache()->tags('permisos')->flush();
      }

      $bitacora = new Bitacora();
      $bitacora->mensaje = 'Se creó el usuario'. $usuario->username;
      $bitacora->registro_id = $usuario->id;
      $bitacora->user_id = Auth::user()->id;
      $bitacora->save();

      $toast = array(
        'title'   => 'Usuario creado: ',
        'message' => $request->username,
        'background' => '#e1f6d0',
        'type' => 'success'
      );

      return back()->with('mensaje', $toast);
    } catch (\Illuminate\Database\QueryException $e) {
      $toast = array(
        'title'   => 'Usuario no creado: ',
        'message' => $usuario->username,
        'type'    => 'error',
        'background' => '#edc3c3'
      );
      return back()->with('mensaje', $toast);
    }
  }

  public function show($id)
  {
    if (!Auth::user()->can('Ver-usuarios') || Auth::user()->hasRole('Inactivo')) abort(403);

    $roles = Role::all()->groupBy('category')->toArray();
    unset($roles['Inactivo']);
    unset($roles['Admin']);
    $usuario = User::find($id);
    $rolesusuario = $usuario->roles;
    $titulo = 'Usuarios';
    $breadcrumb = array(
      ['nombre' => 'Usuarios', 'enlace' => '/users'],
      ['nombre' => 'Ver', 'enlace' => '#'],
    );
    return Inertia::render('Admin/Usuarios/Ver', compact('usuario', 'rolesusuario', 'titulo', 'breadcrumb'));
  }

  public function edit($id)
  {
    if (!Auth::user()->can('Editar-usuarios') || Auth::user()->hasRole('Inactivo')) abort(403);

    $roles = Role::all()->groupBy('category')->toArray();
    unset($roles['Inactivo']);
    unset($roles['Admin']);
    $usuario = User::find($id);
    $rolesusuario = $usuario->roles;
    $titulo = 'Usuarios';
    $breadcrumb = array(
      ['nombre' => 'Usuarios', 'enlace' => '/users'],
      ['nombre' => 'Editar', 'enlace' => '#'],
    );
    return Inertia::render('Admin/Usuarios/Editar', compact('usuario', 'rolesusuario', 'roles', 'titulo', 'breadcrumb'));
  }

  public function update(Request $request, $id)
  {

    if (!Auth::user()->can('Editar-usuarios') || Auth::user()->hasRole('Inactivo') || !$request->ajax()) abort(403);
    try {
      $usuario = User::find($id);
      $usuario->nombres = $request->data["nombres"];
      $usuario->apellidos = $request->data["apellidos"];
      $usuario->username = $request->data["username"];
      $usuario->name = $request->data["nombres"] . ' ' . $request->data["apellidos"];
      
      
      if ($request->data["activo"] == 0) {
        $usuario->assignRole('Inactivo');
      } else
      $usuario->removeRole('Inactivo');
      
      // dd(  $request->data['imagen']);
      $usuario->activo = $request->data["activo"];
      cache()->tags('permisos')->flush();
      
      if (isset($request->data["imagen"])) {
        
        $ext = $request->data["imagen"]->getClientOriginalExtension();
        // dd($ext);
        $fileName = $usuario->username .'-'. Str::random(5) . '.' . $ext;
        //original
        $request->data["imagen"]->storeAs('usuarios/originales', $fileName);
        //modificado
        $imagenmod = Image::make($request->data["imagen"])->fit(300, 300);
        Storage::put('usuarios/thumbnail/' . $fileName, $imagenmod->encode());
        
        $usuario->fotografia = 'usuarios/thumbnail/' . $fileName;
      }
      $usuario->save();
      
      $bitacora = new Bitacora();
      $bitacora->mensaje = 'Se editó el usuario '. $usuario->username;
      $bitacora->registro_id = $usuario->id;
      $bitacora->user_id = Auth::user()->id;
      $bitacora->save();

      $toast = array(
        'title'   => 'Usuario modificado: ',
        'message' => $usuario->username,
        'background' => '#e1f6d0',
        'type' => 'success'
      );
      return back()->with('mensaje', $toast);
    } catch (\Throwable $th) {
      dd($th);
      $toast = array(
        'title'   => 'Usuario no modificado: ',
        'message' => 'error',
        'type'    => 'error',
        'background' => '#edc3c3'
      );
      return back()->with('mensaje', $toast);
    }
  }

  public function destroy(Request $request, $id)
  {
    if (!Auth::user()->can('Eliminar-usuarios') || Auth::user()->hasRole('Inactivo') || !$request->ajax()) abort(403);

    $usuario = User::find($id);
    $usuario->delete();

    $bitacora = new Bitacora();
    $bitacora->mensaje = 'Se eliminó el usuario '. $usuario->username;
    $bitacora->registro_id = $usuario->id;
    $bitacora->user_id = Auth::user()->id;
    $bitacora->save();

    $toast = array(
      'title'   => 'usuario quitado. ',
      'message' => '',
      'background' => '#e1f6d0',
      'type' => 'success'
    );
    return back()->with('mensaje', $toast);
  }

  public function updatepass(Request $request, $id)
  {
    if (!Auth::user()->can('Editar-usuarios') || Auth::user()->hasRole('Inactivo') || !$request->ajax()) abort(403);

    $this->validate($request, [
      'password' => 'required|string|min:8'
    ]);

    try {
      $usuario = User::find($id);
      if ($request->password) {
        $usuario->password = Hash::make($request->password);
      }

      $usuario->save();

      $bitacora = new Bitacora();
      $bitacora->mensaje = 'Se actualizó contraseña';
      $bitacora->registro_id = $usuario->id;
      $bitacora->user_id = Auth::user()->id;
      $bitacora->save();

      $toast = array(
        'title'   => 'Usuario modificado: ',
        'message' => $usuario->username,
        'background' => '#e1f6d0',
        'type' => 'success'
      );
      return back()->with('mensaje', $toast);
    } catch (\Throwable $th) {
      $toast = array(
        'title'   => 'Usuario no modificado: ',
        'message' => 'error',
        'type'    => 'error',
        'background' => '#edc3c3'
      );
      return back()->with('mensaje', $toast);
    }
  }

  public function updateemail(Request $request, $id)
  {
    if (!Auth::user()->can('Editar-usuarios') || Auth::user()->hasRole('Inactivo') || !$request->ajax()) abort(403);

    $this->validate($request, [
      'email' => 'email|unique:users',
    ]);

    try {
      $usuario = User::find($id);
      if ($request->email) {
        $usuario->email = $request->email;
      }

      $usuario->save();

      $bitacora = new Bitacora();
      $bitacora->mensaje = 'Se editó el email';
      $bitacora->registro_id = $usuario->id;
      $bitacora->user_id = Auth::user()->id;
      $bitacora->save();

      $toast = array(
        'title'   => 'Email modificado: ',
        'message' => $usuario->email,
        'background' => '#e1f6d0',
        'type' => 'success'
      );
      return back()->with('mensaje', $toast);
    } catch (\Throwable $th) {
      $toast = array(
        'title'   => 'Usuario no modificado: ',
        'message' => 'error',
        'type'    => 'error',
        'background' => '#edc3c3'
      );
      return back()->with('mensaje', $toast);
    }
  }

  public function updaterol(Request $request, $id)
  {
    if (!Auth::user()->can('Editar-usuarios') || Auth::user()->hasRole('Inactivo') || !$request->ajax()) abort(403);
    try {
      $usuario = User::find($id);
      
      if ($request->roles != 'null') {
        if ($request->roles == "Super Admin") {
          $toast = array(
            'title'   => 'roles modificados para: ',
            'message' => $usuario->username,
            'type'    => 'error'
          );
          return back()->with('mensaje', $toast);
        }
        if ($request->roles == "Inactivo") {
          $usuario->syncRoles("Inactivo");
          $toast2 = array(
            'title'   => 'roles modificados para: ',
            'message' => $usuario->username,
            'background' => '#e1f6d0',
            'type' => 'success'
          );
          
        } else {
          // $arrayderoles = explode(",", $request->roles);
          // logger($request->roles);
          $usuario->syncRoles($request->roles);
          
          $toast2 = array(
            'title'   => 'roles modificados para: ',
            'message' => $usuario->username,
            'background' => '#e1f6d0',
            'type' => 'success'
          );
        }
      } else {
        $usuario->syncRoles();
        $toast = array(
          'title'   => 'roles modificados para: ',
          'message' => $usuario->username,
          'background' => '#e1f6d0',
            'type' => 'success' 
        );
      }

      cache()->tags('permisos')->flush();
      $toast = array(
        'title'   => 'roles modificados para: ',
        'message' => $usuario->username,
        'background' => '#e1f6d0',
          'type' => 'success' 
      );

      $bitacora = new Bitacora();
      $bitacora->mensaje = 'Se editó rol';
      $bitacora->registro_id = $usuario->id;
      $bitacora->user_id = Auth::user()->id;
      $bitacora->save();

      return back()->with('mensaje', $toast);
    } catch (\Throwable $th) {
      $toast = array(
        'title'   => 'Usuario no modificado ',
        'message' => '',
        'type'    => 'error',
        'background' => '#edc3c3'
      );
      return back()->with('mensaje', $toast);
    }
  }

  public function contactos()
  {
    if (Auth::user()->hasRole('Inactivo')) abort(403);
    $usuarios = User::paginate(9);
    $titulo = 'Contactos';
    $breadcrumb = array(
      ['nombre' => 'Contactos', 'enlace' => '#'],
    );
    return view('rrhh.contactos', compact('usuarios', 'titulo', 'breadcrumb'));
  }

  public function importardatousuario(Request $request, $id)
  {

    if (!Auth::user()->can('Editar-usuarios')) {
      abort(403);
    }
    try {
      $usuario = User::find($id);
      $usuario->activo = 1;
      $usuario->save();

    } catch (\Throwable $th) {
      //throw $th;
    }
  }

  public function perfilusuario()
  {
    if (Auth::user()->hasRole('Inactivo')) abort(403);
    $titulo = 'Perfil';
    $breadcrumb = array(
      ['nombre' => 'Perfil', 'enlace' => '#']
    );
    return Inertia::render('Usuario/perfilComponent', compact('titulo', 'breadcrumb'));
  }

  public function showResetForm()
  {
    if (Auth::user()->hasRole('Inactivo')) abort(403);
    $titulo = 'Cambio contraseña';
    $breadcrumb = array(
      ['nombre' => 'Perfil', 'enlace' => '/perfil'],
      ['nombre' => 'Cambio contraseña', 'enlace' => '#'],
    );
    return Inertia::render('Auth/ResetPassword', compact('titulo', 'breadcrumb'));
  }

  public function reset(ResetPassword $request)
  {
    if (Auth::user()->hasRole('Inactivo') || !$request->ajax()) abort(403);

    $user = User::find(Auth::user()->id);

    $user->password = Hash::make($request->nuevo);

    $user->save();

    $msg = 'Contraseña cambiada';

    Session::flash('resetpass', $msg);

    return redirect('perfil');
  }

  public function exportar(Request $request){

    if (!Auth::user()->can('Exportar-usuarios') || Auth::user()->hasRole('Inactivo') ) abort(403);
    
    $this->validate($request, [
      'datobusqueda' => "string|nullable",
      'busquedacolumna' => "in:username,name,email,activo",
      'exportar' => 'in:pdf,excel'
    ]);
 
    if($request->datobusqueda)
      $datos = User::select('id', 'name','username','email','activo')->where($request->busquedacolumna, 'like', '%' . $request->datobusqueda . '%')->orderBy($request->busquedacolumna)->with('roles')->get();
    else
      $datos = User::select('id', 'name','username','email','activo')->with('roles')->get();
    
    if($request->exportar == "pdf")
      return PDF::loadView('exports.lista-usuarios', compact('datos'))->download('exportado.pdf');

    if($request->exportar == "excel")
    {
      $vista = (string) "exports.lista-usuarios";
      return Excel::download(new DatosExport($vista,$datos), 'exportado.xlsx');
    }

  }

  public function notimetodo(Request $request){
    if(Auth::user()){

      if (Auth::user()->hasRole('Inactivo')) abort(403);
      
      return Auth::user()->notifications;
    }
  }

  

}
