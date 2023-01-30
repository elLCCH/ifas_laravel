<?php

namespace App\Http\Controllers;

use App\Models\Administrativos;
use App\Models\Calificaciones;
use App\Models\Curso;
use App\Models\Estudiantes;
use App\Models\Administrativos_Cursos;
use App\Models\Prerrequisitos;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $Curso = Curso::all();


        $Malla = $request->query('Malla');
        $Anio_id = $request->query('Anio_id');
        $data = Curso::whereRaw('Anio_id=?',$Anio_id)->whereRaw('Malla=?',$Malla)->orderBy('NivelCurso','desc')->get();
        return $data;
    }
    public function ClonarGestion(Request $request)
    {

        // $Malla = $request->input('Malla'); //MALLA A CLONAR
        $Anio_id = $request->query('Anio_id'); //GESTION A CLONAR
        $New_Anio_id = $request->query('New_Anio_id'); //NUEVA GESTION //4

        $Anio_idinput = $request->input('Anio_id'); //GESTION A CLONAR
        $New_Anio_idinput = $request->input('New_Anio_id'); //NUEVA GESTION //4

        //CLONANDO MATERIAS PARA NUEVA GESTION
        // DB::select("INSERT INTO `cursos` SELECT 0, NombreCurso ,NivelCurso, Sigla, Tipo,BiTriEstado,Horas,Malla,created_at,updated_at,$New_Anio_idinput FROM cursos WHERE Anio_id=$Anio_idinput");
        // SELECT * from cursos where Anio_id=
        $dataMateriass= curso::where('Anio_id','=',$Anio_idinput)->get();
        // $dataMateriass = DB::select("select * from cursos where Anio_id=$Anio_idinput");

        // foreach ($dataMateriass as $c ) {
        //     $curso = new curso();
        //     $curso->NombreCurso= $c->NombreCurso;
        //     $curso->NivelCurso= $c->NivelCurso;
        //     $curso->Sigla= $c->Sigla;
        //     $curso->Tipo= $c->Tipo;
        //     $curso->BiTriEstado= 'NINGUN BIMESTRE';
        //     $curso->Horas= $c->Horas;
        //     $curso->Malla= $c->Malla;
        //     $curso->Anio_id= $New_Anio_idinput;
        //     $curso->save();
        // }


        //clonar prerrequisitos
        $PrerreqAnteriorGestion = Prerrequisitos::where('Anio_id','=',$Anio_idinput)->get();
        // $Lista[]=array();
        foreach ($PrerreqAnteriorGestion as $r) {
            $ObtenerMateriaPrimariaAntes = DB::select("select * from cursos where id=$r->id_materia_p");
            $ObtenerMateriasSecundariasAntes = DB::select("select * from cursos where id=$r->id_materia_s");

            $Primaria = $ObtenerMateriaPrimariaAntes[0]->Sigla;
            $Secundaria = $ObtenerMateriasSecundariasAntes[0]->Sigla;

            $ObtenerMateriaPrimaria = DB::select("select * from cursos where Sigla='$Primaria' and Anio_id=$New_Anio_idinput");
            $ObtenerMateriasSecundarias = DB::select("select * from cursos where Sigla='$Secundaria' and Anio_id=$New_Anio_idinput");

            // $Lista[]=$ObtenerMateriaPrimaria;
            $PrimariaNew = $ObtenerMateriaPrimaria[0]->id;
            $SecundariaNew = $ObtenerMateriasSecundarias[0]->id;


            $Prerreq = new Prerrequisitos();
            $Prerreq->id_materia_p= $PrimariaNew;
            $Prerreq->id_materia_s= $SecundariaNew;
            $Prerreq->Anio_id= $New_Anio_idinput;
            $Prerreq->save();
        //     // DB::select("INSERT INTO `prerrequisitos` value (0, $PrimariaNew,$SecundariaNew,null,null,4)");
        }

        // return 'CLONACION EXITOSA';
        return $ObtenerMateriasSecundarias;

    }
    public function CursosUniqueSigla()
    {
        $dataUnique=DB::select("SELECT DISTINCT Sigla, NombreCurso FROM cursos ORDER BY Sigla");
        $Lista = array();
        foreach ($dataUnique as $C) {
            $data = Curso::where('Sigla','=', $C->Sigla)->first();
            $Lista[] = $data;
        }
        return $Lista;
    }
    public function MateriasxAnioMallaNivelCurso(Request $request)
    {
        //USADO PARA CARGAR TODAS LAS MATEREIAS DE UN ANIO MALLA NIVEL // USADO PARA ASIGNAR MATERIAS A LOS ESTUDIANTES
        $Malla = $request->input('Malla');
        $Anio_id = $request->input('Anio_id');
        $NivelCurso = $request->input('NivelCurso');

        $materias = DB::select("SELECT cursos.id,`cursos`.`Sigla` as 'cod_prin',cursos.Anio_id,cursos.NivelCurso as 'CursoP',cursos.Malla,cursos.NombreCurso as 'mat_prin',
        cursos.id as 'id_materia_p',prerrequisitos.id_materia_s,(select c.Sigla from cursos c where c.id=prerrequisitos.id_materia_s) as 'cod_sec'
                FROM `cursos`
                    LEFT JOIN `prerrequisitos` ON `prerrequisitos`.`id_materia_p` = `cursos`.`id` where cursos.Anio_id=$Anio_id and cursos.Malla='$Malla' and cursos.NivelCurso = '$NivelCurso'");
        $SiTienePrerreq = true;
        foreach ($materias as $k) {
            if ($k->cod_sec==null) {
                $SiTienePrerreq = false;
            }
        }
        if ($SiTienePrerreq ==false) {
            $materias = DB::select("SELECT cursos.id,`cursos`.`Sigla` as 'cod_prin',cursos.Anio_id,cursos.NivelCurso as 'CursoP',cursos.Malla,cursos.NombreCurso as 'mat_prin',
            cursos.id as 'id_materia_p',(SELECT p.id_materia_s as 'id_materia_s2' from prerrequisitos p where p.id_materia_p =  (select c.id from cursos c where c.Sigla=cursos.Sigla and c.NivelCurso NOT LIKE 'SEGUNDO BASICO B' and c.Anio_id=$Anio_id LIMIT 1)LIMIT 1) AS 'id_materia_sec',(select c.Sigla from cursos c where c.id=id_materia_sec) as 'cod_sec'
                    FROM `cursos`
                        LEFT JOIN `prerrequisitos` ON `prerrequisitos`.`id_materia_p` = `cursos`.`id` where cursos.Anio_id=$Anio_id and cursos.Malla='$Malla' and cursos.NivelCurso = '$NivelCurso';
            ");
        }
        return $materias;
    }
    public function MateriasxAnioMalla(Request $request)
    {
        //USADO PARA CARGAR TODAS LAS MATEREIAS DE UN ANIO MALLA NIVEL // USADO PARA ASIGNAR MATERIAS A LOS ESTUDIANTES
        $Malla = $request->input('Malla');
        $Anio_id = $request->input('Anio_id');


        $materias = DB::select("SELECT cursos.id,`cursos`.`Sigla` as 'cod_prin',cursos.Anio_id,cursos.NivelCurso as 'CursoP',cursos.Malla,cursos.NombreCurso as 'mat_prin',
        cursos.id as 'id_materia_p',prerrequisitos.id_materia_s,(select c.Sigla from cursos c where c.id=prerrequisitos.id_materia_s) as 'cod_sec'
                FROM `cursos`
                    LEFT JOIN `prerrequisitos` ON `prerrequisitos`.`id_materia_p` = `cursos`.`id` where cursos.Anio_id=$Anio_id and cursos.Malla='$Malla' ");
        $SiTienePrerreq = true;
        foreach ($materias as $k) {
            if ($k->cod_sec==null) {
                $SiTienePrerreq = false;
            }
        }
        if ($SiTienePrerreq ==false) {
            $materias = DB::select("SELECT cursos.id,`cursos`.`Sigla` as 'cod_prin',cursos.Anio_id,cursos.NivelCurso as 'CursoP',cursos.Malla,cursos.NombreCurso as 'mat_prin',
            cursos.id as 'id_materia_p',(SELECT p.id_materia_s as 'id_materia_s2' from prerrequisitos p where p.id_materia_p =  (select c.id from cursos c where c.Sigla=cursos.Sigla and c.NivelCurso NOT LIKE 'SEGUNDO BASICO B' and c.Anio_id=$Anio_id LIMIT 1)LIMIT 1) AS 'id_materia_sec',(select c.Sigla from cursos c where c.id=id_materia_sec) as 'cod_sec'
                    FROM `cursos`
                        LEFT JOIN `prerrequisitos` ON `prerrequisitos`.`id_materia_p` = `cursos`.`id` where cursos.Anio_id=$Anio_id and cursos.Malla='$Malla';
            ");
        }
        return $materias;
    }
    public function ListaAgrupacionMateriasXCursos(Request $request, $id)
    {

        $Malla = $request->input('Malla');
        $Anio_id = $request->input('Anio_id');
        // $tipo = $request->query('tipo');
        // $curso = Curso::whereRaw('NivelCurso=?',$tipo)->orderBy('NombreCurso','desc')->get();
        // return $curso;

        // $adminID = $request->input('admin_id');
        $adminID = $id;
        // $curso = Curso::query()->orderBy('NivelCurso', 'ASC')->get(); //ACA SELECCIONA TODOS LOS CURSOS DE LA TABLA PARA LAS MANIOBRAS

        //PERO YANO LO NECESITAMOS YA Q TENEMOS QUE HACERLO POR GESTION
        $curso =Curso::where('Anio_id',$Anio_id)->where('Malla',$Malla)->orderBy('NivelCurso','desc')->get();
        // return $curso;

        try {
            foreach ($curso as $C) {
                // $EstudiantesData = Estudiantes::where('id','=', $C->estudiante_id)->first();
                $NewCurso = Curso::where('id','=',$C->id)->first();

                $verificacion = Administrativos_Cursos::where('Admin_id','=', $adminID)->where('Curso_id','=',$C->id)->first();
                if ($verificacion != "" || $verificacion !=null) {
                    //ESTE DOCENTE TIENE PUESTO EL CURSO ENTONCES ACTIVADO
                    $NewCurso['Existencia'] = 'ACTIVADO';

                    $NewCurso['idAdmin'] = '';
                    $NewCurso['Ap_Paterno'] = '';
                    $NewCurso['Ap_Materno'] = '';
                    $NewCurso['Nombre'] = '';
                } else {
                    //ESTE DONCENTE NO TIENE ACTIVADO ESTE CURSO, X LO TANTO VERIFICAR SI OTROS DOCENTES SI LO TIENEN
                    $AllAdmin = Administrativos::query()->get();
                    foreach ($AllAdmin as $admin) {
                        $verificacionOtrosAdmins = Administrativos_Cursos::where('Admin_id','=', $admin->id)->where('Curso_id','=',$C->id)->first();
                        if ($verificacionOtrosAdmins != "" || $verificacionOtrosAdmins !=null) {
                            //EL ADMINISTRADOR X YA TIENE ACTIVADO ESTE CURSO
                            $NewCurso['Existencia'] = 'ACTIVO';
                            $NewCurso['idAdmin'] = $admin->id;
                            $NewCurso['Ap_Paterno'] = $admin->Ap_Paterno;
                            $NewCurso['Ap_Materno'] = $admin->Ap_Materno;
                            $NewCurso['Nombre'] = $admin->Nombre;
                            break;
                        }
                        else{
                            $NewCurso['Existencia'] = 'INACTIVO';
                            $NewCurso['idAdmin'] = '';
                            $NewCurso['Ap_Paterno'] = '';
                            $NewCurso['Ap_Materno'] = '';
                            $NewCurso['Nombre'] = '';
                        }
                    }


                }
                $Lista[] = $NewCurso;
            }

            return $Lista;
        } catch (\Throwable $e) {
            // return $request;
            report($e);
            return false;
        }

    }
    public function ListaEstudiantes(Request $request)
    {
        try {
            //obtengo la fila del curso deseado pero solo por su Id  del curso
            $CursoData = Curso::where('NivelCurso','=', $request->NivelCurso)->first();
            //obtener la lista de los estudiantes pero solo por su estudiante_id ...
            //DIGAMOS UN ESTUDIANTE ESTA EN SEGUNDO MEDIO ENTONCES HABRA 5 DEL MISMO YA Q EL CURSO TIENE 5 MATERIAS
            $CalificacionesData = Calificaciones::where('curso_id','=', $CursoData->id)->get();
            //ELIMINAR VALORES DUPLICADOS POR estudiante_id
            $CalificacionesData = $CalificacionesData->unique('estudiante_id');
            $Lista = array();
            foreach ($CalificacionesData as $C) {
                $EstudiantesData = Estudiantes::where('id','=', $C->estudiante_id)->first();
                $Lista[] = $EstudiantesData;
            }
            return $Lista;
        } catch (Exception $e) {
            return 'EL CURSO NO TIENE ESTUDIANTES';
        }



    }
    public function BuscarNivelCurso($id)
    {

        // $requestData = $request->all();
        // $CursoData = Curso::firstOrFail($id);
        $CursoData = Curso::where('id','=', $id)->first();
        $NivelCursoObtenido = $CursoData->NivelCurso;
        return $NivelCursoObtenido;
    }
    public function CargarCursosUnique(Request $request)
    {
        // $Curso = Curso::all();
        // $Cursos = $Curso->unique('NivelCurso');

        $Malla = $request->input('Malla');
        $Anio_id = $request->input('Anio_id');
        $data = Curso::where('Anio_id',$Anio_id)->where('Malla',$Malla)->distinct()->orderBy('NivelCurso','desc')->get(['NivelCurso']);

        // $Cursos = Curso::distinct()->get(['NivelCurso']);
        return $data;
    }
    public function CargarMalla()
    {
        $data = Curso::distinct()->get(['Malla']);
        return $data;
    }
    public function ModificarBimestres(Request $request)
    {
        $Bimestre = $request->BiTriEstado;
        $Malla = $request->Malla;
        DB::select("update cursos set BiTriEstado = '$Bimestre' where Malla='$Malla'");
    }
    public function CargarSiglaUnique()
    {
        $Cursos = Curso::distinct()->get(['Sigla']);
        return $Cursos;
    }
    public function MateriasxEstudianteAnio(Request $request)
    {
        //CARGAR MATERIAS DE UN ESTUDIANTE DE UNA GESTION
        // $Nivel="SUPERIORRRR";
        $Estudiante_id = $request->input('Estudiante_id');
        $Anio_id = $request->input('Anio_id');
        $data = DB::select("SELECT `calificaciones`.`id`,calificaciones.anio_id,calificaciones.curso_id,calificaciones.estudiante_id,calificaciones.Promedio, anios.Anio, cursos.NombreCurso,cursos.NivelCurso,cursos.Sigla,cursos.Malla
        FROM `calificaciones`
            LEFT JOIN `estudiantes` ON `calificaciones`.`estudiante_id` = `estudiantes`.`id`
            LEFT JOIN `cursos` ON calificaciones.curso_id = `cursos`.`id`
            LEFT JOIN `anios` ON `calificaciones`.`anio_id` = `anios`.`id` where estudiantes.id=$Estudiante_id and anios.id=$Anio_id");
        // $curso = Curso::where('NivelCurso','=',$Nivel)->get();
                //  Curso::where('id','=',$id)->update($requestData);

        return $data;
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

        Curso::insert($requestData);

        return 'curso creado';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function show(Curso $curso)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function edit(Curso $curso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $requestData = $request->all();

        Curso::where('id','=',$id)->update($requestData);

        return $requestData;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Curso::destroy($id);
        return 'curso eliminado';
        // return redirect('curso')->with('flash_message', 'Curso deleted!');
    }

}
