<?php

namespace App\Models\M_Empresa;
use App\Models\M_Empresa\Ubicacion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresa extends Model
{
  use SoftDeletes;

  public function ubicaciones()
  {
      return $this->hasMany(Ubicacion::class);
  }
}