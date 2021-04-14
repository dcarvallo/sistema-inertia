<?php

namespace App\Models\M_Empresa;

use App\Models\M_Empresa\Area;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cargo extends Model
{
  use SoftDeletes;

  public function area()
  {
      return $this->belongsTo(Area::class);
  }
}
