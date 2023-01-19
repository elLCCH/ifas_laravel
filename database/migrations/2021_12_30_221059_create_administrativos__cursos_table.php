<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdministrativosCursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administrativos__cursos', function (Blueprint $table) {
            $table->increments('id');
            // $table->integer('Anio')->nullable();
            // $table->string('Rector')->nullable();
            // $table->string('DirAcademico')->nullable();
            
            $table->integer('Admin_id')->unsigned();
            $table->integer('Curso_id')->unsigned();
            $table->timestamps();
            $table->foreign('Admin_id')->references('id')->on('administrativos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('Curso_id')->references('id')->on('cursos')->onDelete('cascade')->onUpdate('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('administrativos__cursos');
    }
}
