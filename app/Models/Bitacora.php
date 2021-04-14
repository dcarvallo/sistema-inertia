<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    protected $fillable = ['mensaje', 'registro_id', 'user_id'];
}
