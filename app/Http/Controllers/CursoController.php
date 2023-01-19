<?php

namespace App\Http\Controllers;

use App\Models\Administrativos;
use App\Models\Calificaciones;
use App\Models\Curso;
use App\Models\Estudiantes;
use App\Models\Administrativos_Cursos;
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
        $Curso = Curso::all();
        return $Curso;
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
    public function ListaAgrupacionMateriasXCursos(Request $request, $id)
    {
        // $tipo = $request->query('tipo');
        // $curso = Curso::whereRaw('NivelCurso=?',$tipo)->orderBy('NombreCurso','desc')->get();
        // return $curso;

        // $adminID = $request->input('admin_id');
        $adminID = $id;
        $curso = Curso::query()->orderBy('NivelCurso', 'ASC')->get();


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
    public function CargarCursosUnique()
    {
        // $Curso = Curso::all();
        // $Cursos = $Curso->unique('NivelCurso');
        $Cursos = Curso::distinct()->get(['NivelCurso']);
        return $Cursos;
    }
    public function ModificarBimestres(Request $request)
    {
        $Bimestre = $request->BiTriEstado;
        DB::select("update cursos set BiTriEstado = '$Bimestre'");
    }
    public function CargarSiglaUnique()
    {
        $Cursos = Curso::distinct()->get(['Sigla']);
        return $Cursos;
    }
    public function CargarCursosPorNivel(Request $request, $Nivel)
    {
        // $Nivel="SUPERIORRRR";
        $curso = Curso::where('NivelCurso','=',$Nivel)->get();
                //  Curso::where('id','=',$id)->update($requestData);

        return $curso;
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
        //
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
