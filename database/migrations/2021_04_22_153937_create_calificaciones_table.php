<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateCalificacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calificaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('Avance1')->nullable();
            $table->integer('Teoria1')->nullable();
            $table->integer('Teorica1')->nullable();
            $table->integer('Interpretacion1')->nullable();
            $table->integer('Tecnica1')->nullable();
            $table->integer('Presentacion1')->nullable();
            $table->integer('Expresion1')->nullable();
            $table->integer('Practica1')->nullable();
            $table->integer('Primero')->nullable();
            $table->integer('Avance2')->nullable();
            $table->integer('Teoria2')->nullable();
            $table->integer('Teorica2')->nullable();
            $table->integer('Interpretacion2')->nullable();
            $table->integer('Tecnica2')->nullable();
            $table->integer('Presentacion2')->nullable();
            $table->integer('Expresion2')->nullable();
            $table->integer('Practica2')->nullable();
            $table->integer('Segundo')->nullable();
            $table->integer('Avance3')->nullable();
            $table->integer('Teoria3')->nullable();
            $table->integer('Teorica3')->nullable();
            $table->integer('Interpretacion3')->nullable();
            $table->integer('Tecnica3')->nullable();
            $table->integer('Presentacion3')->nullable();
            $table->integer('Expresion3')->nullable();
            $table->integer('Practica3')->nullable();
            $table->integer('Tercero')->nullable();
            $table->integer('Avance4')->nullable();
            $table->integer('Teoria4')->nullable();
            $table->integer('Teorica4')->nullable();
            $table->integer('Interpretacion4')->nullable();
            $table->integer('Tecnica4')->nullable();
            $table->integer('Presentacion4')->nullable();
            $table->integer('Expresion4')->nullable();
            $table->integer('Practica4')->nullable();
            $table->integer('Cuarto')->nullable();
            $table->integer('Promedio')->nullable();
            $table->integer('estudiante_id')->unsigned();
            $table->integer('curso_id')->unsigned();
            $table->integer('anio_id')->unsigned();
            $table->timestamps();
            $table->foreign('estudiante_id')->references('id')->on('estudiantes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('curso_id')->references('id')->on('cursos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('anio_id')->references('id')->on('anios')->onDelete('cascade')->onUpdate('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calificaciones');
    }
}
