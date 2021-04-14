<?php

namespace App\Models\M_Empresa;

use App\Models\M_Empresa\Cargo;
use App\Models\M_Empresa\Departamento;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
  use SoftDeletes;
  
  public function cargos()
  {
      return $this->hasMany(Cargo::class);
  }

  public function departamento()
  {
      return $this->belongsTo(Departamento::class);
  }
}
