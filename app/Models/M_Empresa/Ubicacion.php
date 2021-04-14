<?php

namespace App\Models\M_Empresa;

use Illuminate\Database\Eloquent\Model;
use App\Models\M_Empresa\Empresa;
use App\Models\M_Empresa\Departamento;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ubicacion extends Model
{

  use SoftDeletes;

  protected $table = 'ubicaciones';

  protected $fillable = [
    'nombre', 'descripcion', 'locacion'
  ];

  public function empresa()
  {
      return $this->belongsTo(Empresa::class);
  }

  public function departamentos()
  {
      return $this->hasMany(Departamento::class);
  }
}
