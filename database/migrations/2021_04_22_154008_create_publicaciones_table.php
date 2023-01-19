<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publicaciones', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('Titulo')->nullable();
            $table->string('Descripcion')->nullable();
            $table->date('Fecha')->nullable();
            $table->string('File')->nullable();
            $table->string('Enlace')->nullable();
            $table->string('Tipo')->nullable();
            $table->integer('Admin_id')->unsigned();
            $table->timestamps();
            $table->foreign('Admin_id')->references('id')->on('administrativos')->onDelete('cascade')->onUpdate('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('publicaciones');
    }
}
