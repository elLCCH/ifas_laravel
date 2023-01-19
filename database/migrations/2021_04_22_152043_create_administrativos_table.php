<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdministrativosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administrativos', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('Foto')->nullable();
            $table->string('Ap_Paterno')->nullable();
            $table->string('Ap_Materno')->nullable();
            $table->string('Nombre')->nullable();
            $table->string('Sexo')->nullable();
            $table->date('FechNac')->nullable();
            $table->string('CI')->nullable();
            $table->string('Password')->nullable();
            $table->string('Tipo')->nullable();
            $table->string('Estado')->nullable();
            //$table->integer('curso_id')->unsigned();
            $table->timestamps();
            //$table->foreign('curso_id')->references('id')->on('cursos')->onDelete('cascade')->onUpdate('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('administrativos');
    }
}
