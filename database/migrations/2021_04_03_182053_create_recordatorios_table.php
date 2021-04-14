<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordatoriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recordatorios', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->string('descripcion');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->unsignedSmallInteger('session');
            $table->char('color', 10)->default('#1ABC9C');
            $table->char('textColor', 10)->default('#ffffff');
            $table->unsignedBigInteger('user_id');

            $table->foreign('user_id')->references('id')->on("users");
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
        Schema::dropIfExists('recordatorios');
    }
}
