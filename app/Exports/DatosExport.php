<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DatosExport implements FromView
{
  use Exportable;

  private $datos;
  private $vista;
    
  public function __construct($vista, $datos)
  {
    $this->datos = $datos;
    $this->vista = (string)$vista;
  }

  public function view(): View
    {
    return view($this->vista, [
        'datos' => $this->datos
    ]);
  }
}
