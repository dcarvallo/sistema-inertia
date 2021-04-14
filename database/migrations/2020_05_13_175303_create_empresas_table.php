<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 200);
            $table->text('descripcion');
            $table->string('rubro', 255);
            $table->bigInteger('nit')->nullable();
            $table->string('propietario', 255);
            $table->text('mision')->nullable();
            $table->text('vision')->nullable();
            $table->string('direccion', 200)->nullable();
            $table->string('telefono', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('imagen_empresa', 200)->nullable();
            $table->date('fecha_creacion');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresas');
    }
}
