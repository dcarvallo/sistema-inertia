<?php

namespace App\Models\M_Empresa;

use App\Models\M_Empresa\Ubicacion;
use App\Models\M_Empresa\Cargo;
use App\Models\M_Empresa\Area;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departamento extends Model
{
  use SoftDeletes;
  
  public function ubicacion()
  {
      return $this->belongsTo(Ubicacion::class);
  }

  public function areas()
  {
      return $this->hasMany(Area::class);
  }
}
