<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstudiantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Foto')->nullable();
            $table->string('Ap_Paterno')->nullable();
            $table->string('Ap_Materno')->nullable();
            $table->string('Nombre')->nullable();
            $table->string('Sexo')->nullable();
            $table->date('FechNac')->nullable();
            $table->integer('Edad')->nullable();
            $table->string('CI')->nullable();
            $table->string('Nombre_Padre')->nullable();
            $table->string('OcupacionP')->nullable();
            $table->integer('NumCelP')->nullable();
            $table->string('Nombre_Madre')->nullable();
            $table->string('OcupacionM')->nullable();
            $table->integer('NumCelM')->nullable();
            $table->string('Direccion')->nullable();
            $table->integer('Telefono')->nullable();
            $table->integer('Celular')->nullable();
            $table->string('NColegio')->nullable();
            $table->string('TipoColegio')->nullable();
            $table->string('CGrado')->nullable();
            $table->string('CNivel')->nullable();
            $table->string('Especialidad')->nullable();
            $table->string('Correo')->nullable();
            $table->string('Password')->nullable();
            $table->string('Estado')->nullable();
            $table->string('Matricula')->nullable();
            $table->string('Carrera')->nullable();
            $table->string('Categoria')->nullable();
            $table->string('Turno')->nullable();
            $table->string('Correo_Institucional')->nullable();
            $table->string('Curso_Solicitado')->nullable();
            $table->string('Mension')->nullable(); //new
            $table->string('Area')->nullable(); //new

            $table->string('Certificado')->nullable();
            $table->string('DocColUni')->nullable();
            $table->string('CIDoc')->nullable();
            $table->string('Boleta')->nullable();
            
            
            $table->integer('Admin_id')->nullable()->unsigned();
            $table->timestamps();
            $table->foreign('Admin_id')->references('id')->on('administrativos')->onUpdate('cascade');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estudiantes');
    }
}
