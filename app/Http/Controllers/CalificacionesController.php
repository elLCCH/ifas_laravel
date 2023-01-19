<?php

namespace App\Http\Controllers;

use App\Models\Calificaciones;
use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalificacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $Curso = Calificaciones::all();
        
        return $Curso;
    }
    public function ListarXCursoCalif($id)
    {
        //
        $Curso = Calificaciones::where('curso_id','=',$id)->get();
        
        return $Curso;
    }
    public function EncontrarNivelCurso(Request $request,$id)
    {
        
        //VARIABLES DE SESSION
        // session(['idCarroCompra' => '15320']); //GUARDAR
        // $valor_almacenado = session('idCarroCompra'); //OBTENER

        //VARIABLES DE SESSION PERO EN MODO ANGULAR
        // sessionStorage.setItem('Nombre', 'Miguel Antonio') //GUARDAR
        // sessionStorage.Apellido = 'Márquez Montoya' //GUARDAR
        //OBTENER
        // let firstName = sessionStorage.getItem('Nombre'),
        // lastName  = sessionStorage.Apellido
        
        
        //SELECT `cursos`.*, estudiantes.Ap_Paterno, estudiantes.Ap_Materno, estudiantes.Nombre FROM `cursos`	LEFT JOIN `calificaciones` ON `calificaciones`.`curso_id` = `cursos`.`id` LEFT JOIN `estudiantes` ON `calificaciones`.`estudiante_id` = `estudiantes`.`id` WHERE estudiantes.id = 83
        $CursoData = DB::select("SELECT `cursos`.`NivelCurso`,estudiantes.id,anios.id,anios.Anio FROM `cursos` LEFT JOIN `calificaciones` ON `calificaciones`.`curso_id` = `cursos`.`id` LEFT JOIN `estudiantes` ON `calificaciones`.`estudiante_id` = `estudiantes`.`id` LEFT JOIN `anios` ON `calificaciones`.`anio_id` = `anios`.`id` WHERE estudiantes.id = $id AND anios.Anio=2022 LIMIT 1");
        $NivelCursoObtenido = $CursoData;
        
        
        
        // $CalificacionesData = Calificaciones::where('estudiante_id','=', $id)->first();
        // $idCursoObtenido = $CalificacionesData->curso_id;
        // $CursoData = Curso::where('id','=', $idCursoObtenido)->first();
        // $NivelCursoObtenido = $CursoData->NivelCurso;
        // return $id;
        // session(['SessionNivel' => $NivelCursoObtenido]);
        return $NivelCursoObtenido;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestData = $request->all();
        Calificaciones::insert($requestData);
        return $requestData;
        // return 'calificacion creado';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Calificaciones  $calificaciones
     * @return \Illuminate\Http\Response
     */
    public function show(Calificaciones $calificaciones)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Calificaciones  $calificaciones
     * @return \Illuminate\Http\Response
     */
    public function edit(Calificaciones $calificaciones)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Calificaciones  $calificaciones
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $requestData = $request->all();
        
        Calificaciones::where('id','=',$id)->update($requestData);    
        
        return $requestData;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Calificaciones  $calificaciones
     * @return \Illuminate\Http\Response
     */
    public function destroy(Calificaciones $calificaciones)
    {
        //
    }
    public function EliminarEstudianteDelCurso($idEst)
    {
        Calificaciones::where('estudiante_id','=',$idEst)->delete();
        return 'Eliminacion del Estudiante Curso Correcto';
    }
}
