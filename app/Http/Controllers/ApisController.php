<?php

namespace App\Http\Controllers;
use App\Models\Administrativos;
use App\Models\Administrativos_Cursos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Else_;

class ApisController extends Controller
{
    public function DisponibilidadInscripciones()
    {
        //PAGINA DE INSCRIPCIONES GENERAL
        return false;
    }
    public function DisponibilidadInscripcionesNuevos()
    {
        //PAGINA DE INSCRIPCIONES PARA LOS QUE QUIEREN DAR EXAMEN DE ADMISION
        return false;
    }
    public function VideoApi()
    {
        //LISTA DE CURSOS
        // CAPACITACION Y SUPERIOR
        $data = Array (
            "0" => Array ("vidio" => "https://www.facebook.com/plugins/video.php?height=314&href=https%3A%2F%2Fwww.facebook.com%2FIFAMariaLuisa%2Fvideos%2F1038375650338333%2F&show_text=false&width=560&t=0",),
        );
        return $data;

    }
    public function ListarCursosPostulantesApi()
    {
        //LISTA DE CURSOS
        // CAPACITACION Y SUPERIOR
        $data = Array (
            "0" => Array ("NivelCurso" => "NIVEL SUPERIOR (Diploma de Bachiller)",) ,
            "1" => Array ("NivelCurso" => "NIVEL INTERMEDIO (15 a 17 años)",),
            "2" => Array ("NivelCurso" => "NIVEL BASICO (12 a 14 años)",),
            "3" => Array ("NivelCurso" => "NIVEL INICIACION (9 a 11 años)",)
        );
        return $data;

    }
    public function ListarAbreviacionDptosApi()
    {
        //LISTA DE CURSOS
        // CAPACITACION Y SUPERIOR
        $data = Array (
            "0" => Array ("Dpto" => "OR",) ,
            "1" => Array ("Dpto" => "LP",),
            "2" => Array ("Dpto" => "SC",),
            "3" => Array ("Dpto" => "PT",),
            "4" => Array ("Dpto" => "CH",),
            "5" => Array ("Dpto" => "CBBA",),
        );
        return $data;

    }
    public function ListarCursosApi()
    {
        //LISTA DE CURSOS
        $data = Array (
            "0" => Array ("NivelCurso" => "PRIMERO SUPERIOR","Para" => "NUEVOS o ANTIGUOS"),
            "1" => Array ("NivelCurso" => "SEGUNDO SUPERIOR","Para" => "ANTIGUOS"),
            "2" => Array ("NivelCurso" => "TERCERO SUPERIOR","Para" => "ANTIGUOS"),
            "3" => Array ("NivelCurso" => "PRIMERO INTERMEDIO","Para" => "NUEVOS o ANTIGUOS"),
            "4" => Array ("NivelCurso" => "SEGUNDO INTERMEDIO","Para" => "ANTIGUOS"),
            "5" => Array ("NivelCurso" => "TERCERO INTERMEDIO","Para" => "ANTIGUOS"),
            "6" => Array ("NivelCurso" => "PRIMERO BASICO","Para" => "NUEVOS o ANTIGUOS"),
            "7" => Array ("NivelCurso" => "SEGUNDO BASICO","Para" => "ANTIGUOS"),
            "8" => Array ("NivelCurso" => "TERCERO BASICO","Para" => "ANTIGUOS"),
            "9" => Array ("NivelCurso" => "PRIMERO INICIACION","Para" => "NUEVOS"),
            "10" => Array ("NivelCurso" => "SEGUNDO INICIACION","Para" => "ANTIGUOS"),
            "11" => Array ("NivelCurso" => "TERCERO INICIACION","Para" => "ANTIGUOS")
        );
        return $data;

    }

    public function ListarMensionesApi()
    {

        $data = Array (
            "0" => Array ("Mension" => "INSTRUMENTISTA",),
            // // NUEVA MALLA
            // "1" => Array ("Mension" => "CANTO LIRICO",),
            // "2" => Array ("Mension" => "DIRECCION",),
            // "3" => Array ("Mension" => "COMPOSICION",)

        );
        return $data;
    }
    public function ListarMensionesModernasApi()
    {

        $data = Array (
            // "0" => Array ("Mension" => "INSTRUMENTISTA",)
        );
        return $data;
    }
    public function ListarHorariosCapacitacionApi()
    {
        $data = Array (
            "0" => Array ("Turno" => "MAÑANA","Hora" => "(8:30hrs a 11:00hrs)"),
            "1" => Array ("Turno" => "TARDE","Hora" => "(17:00hrs a 19:40hrs)"),
            //"2" => Array ("Turno" => "NOCHE","Hora" => "ANTIGUOS")
        );
        return $data;
    }
    public function ListarAreasOCarrerasONivel()
    {
        //EN VEZ DE AREA LE PONDREMOS Carrera
        $data = Array (
            "0" => Array ("Carrera" => "CLASICA","Denominacion" => "NINGUNA","Malla"=>"ANTIGUA"),
            //NUEVA MALLA 2023
            "1" => Array ("Carrera" => "MÚSICA CLÁSICA/ACADÉMICA","Denominacion" => " EN MÚSICA CLÁSICA/ACADÉMICA","Malla"=>"NUEVA"),
            "2" => Array ("Carrera" => "CANTO LÍRICO","Denominacion" => "CANTO LÍRICO","Malla"=>"NUEVA"),
            "3" => Array ("Carrera" => "MÚSICA MODERNA","Denominacion" => " EN MÚSICA MODERNA","Malla"=>"NUEVA"),
            "4" => Array ("Carrera" => "CANTO LÍRICO","Denominacion" => " EN MÚSICA BOLIVIANA","Malla"=>"NUEVA"),
            //para capacitacion NUEVA MALLA
            "5" => Array ("Carrera" => "INICIACIÓN EN MÚSICA CLÁSICA/ACADÉMICA","Denominacion" => "NINGUNA","Malla"=>"NUEVA - CAPACITACION"),
            "6" => Array ("Carrera" => "BÁSICO EN MÚSICA CLÁSICA/ACADÉMICA","Denominacion" => "NINGUNA","Malla"=>"NUEVA - CAPACITACION"),
            "7" => Array ("Carrera" => "INTERMEDIO EN MÚSICA CLÁSICA/ACADÉMICA","Denominacion" => "NINGUNA","Malla"=>"NUEVA - CAPACITACION"),

        );
        return $data;
    }
    public function ListarHorariosSuperiorApi()
    {
        $data = Array (
            "0" => Array ("Turno" => "MAÑANA","Hora" => "(8:00hrs a 13:00hrs)"),
            "1" => Array ("Turno" => "TARDE","Hora" => "(14:00hrs a 18:30hrs)"),
            "2" => Array ("Turno" => "NOCHE","Hora" => "(18:00hrs a 22:30hrs")
        );
        return $data;
    }
    public function ListarInstrumentosApi()
    {

        $data = Array (
            "0" => Array ("InstEspecialidad" => "PIANO CLASICO","Estado"=>"ACTIVO"),
            "1" => Array ("InstEspecialidad" => "GUITARRA CLASICA","Estado"=>"ACTIVO"),
            "2" => Array ("InstEspecialidad" => "VIOLIN","Estado"=>"ACTIVO"),
            "3" => Array ("InstEspecialidad" => "VIOLA","Estado"=>"ACTIVO"),
            "4" => Array ("InstEspecialidad" => "VIOLONCHELO","Estado"=>"ACTIVO"),
            "5" => Array ("InstEspecialidad" => "CONTRABAJO","Estado"=>"ACTIVO"),
            "6" => Array ("InstEspecialidad" => "CLARINETE","Estado"=>"ACTIVO"),
            "7" => Array ("InstEspecialidad" => "SAXOFON CLASICO","Estado"=>"ACTIVO"),
            "8" => Array ("InstEspecialidad" => "TROMPETA","Estado"=>"ACTIVO"),
            "9" => Array ("InstEspecialidad" => "TROMBON","Estado"=>"ACTIVO"),
           "10" => Array ("InstEspecialidad" => "ACORDEON","Estado"=>"ACTIVO"),

        );
        return $data;
    }

    public function ListarInstrumentosModernosApi()
    {

        $data = Array (
            // "0" => Array ("InstEspecialidad" => "CANTO MODERNO",),
            // "1" => Array ("InstEspecialidad" => "BAJO ELECTRICO",),
            // "2" => Array ("InstEspecialidad" => "GUITARRA ACUSTICA MODERNA",),
            // "3" => Array ("InstEspecialidad" => "PIANO MODERNO",),
            // "4" => Array ("InstEspecialidad" => "SAXOFON MODERNO",)
        );
        return $data;
    }
    public function ListarCategoriasApi()
    {

        $data = Array (

            "0" => Array ("Category" => "NUEVO",),
            "1" => Array ("Category" => "ANTIGUO",)
            // "0" => Array ("Category" => "POSTULANTE",),//SERIA PARA AQUELLAS PERSONAS Q DARAN EXAMEN DE ADMISION
            // "1" => Array ("Category" => "OTROS",), //SERIA PARA AQUELLOS TALLERES
            // "2" => Array ("Category" => "NUEVO",),
            // "3" => Array ("Category" => "ANTIGUO",),
            // "4" => Array ("Category" => "NUEVO (resagado)",),
            // "5" => Array ("Category" => "ANTIGUO (resagado)",)
        );
        return $data;
    }
    public function ConsultarApi(Request $request)
    {
        $data = DB::select($request->consultasql);
        return $data;
    }
    public function ConsultarApiCursosEst(Request $request)
    {
        //ESTE CODIGO ES PARA HACER UNA VALIDACION TOTAL AL AÑADIR DOCENTE A UN CURSO
        $DataAdmin = Administrativos::where('id','=', 5)->get();
        $data = DB::select($request->consultasql);
            foreach ($data as $d) {
                // $Newdata = $d;
                $curso_admin = Administrativos_Cursos::where('Curso_id','=',$d->curso_id)->first();
                if ($curso_admin != "" || $curso_admin !=null) {
                    //SI EXISTE
                    $Newdata['Ap_Paterno_est'] = $d->Ap_Paterno;
                    $Newdata['Ap_Materno_est'] = $d->Ap_Materno;
                    $Newdata['Ap_Nombre_est'] = $d->Nombre;
                    $Newdata['curso_id'] = $d->curso_id;
                    $Newdata['estudiante_id'] = $d->estudiante_id;
                    $Newdata['NombreCurso'] = $d->NombreCurso;
                    $Newdata['NivelCurso'] = $d->NivelCurso;
                    $Newdata['Tipo'] = $d->Tipo;
                    $Newdata['Primero'] = $d->Primero;
                    $Newdata['Segundo'] = $d->Segundo;
                    $Newdata['Tercero'] = $d->Tercero;
                    $Newdata['Cuarto'] = $d->Cuarto;
                    $Newdata['Promedio'] = $d->Promedio;
                    $admin = Administrativos::where('id','=',$curso_admin->Admin_id)->first();
                    $Newdata['Foto'] = $admin->Foto;
                    $Newdata['Ap_Paterno'] = $admin->Ap_Paterno;
                    $Newdata['Ap_Materno'] = $admin->Ap_Materno;
                    $Newdata['Nombre'] = $admin->Nombre;
                }
                else {
                    //NO EXISTE
                    $Newdata['Ap_Paterno_est'] = '';
                    $Newdata['Ap_Materno_est'] = '';
                    $Newdata['Nombre_est'] = '';
                    $Newdata['curso_id'] = '';
                    $Newdata['estudiante_id'] = '';
                    $Newdata['NombreCurso'] = '';
                    $Newdata['NivelCurso'] = '';
                    $Newdata['Tipo'] = '';
                    $Newdata['Primero'] = '';
                    $Newdata['Segundo'] = '';
                    $Newdata['Tercero'] = '';
                    $Newdata['Cuarto'] = '';
                    $Newdata['Promedio'] = '';


                    //DATOS DEL DOCENTE
                    $Newdata['Foto'] = "";
                    $Newdata['Ap_Paterno'] = "";
                    $Newdata['Ap_Materno'] = "";
                    $Newdata['Nombre'] = "";

                }
                $Lista[] = $Newdata;
            }

        return $Lista;
    }
    public function ConsultarApiUniqueCI(Request $request)
    {

        // //obtengo la fila del curso deseado pero solo por su Id  del curso
        //     $CursoData = Curso::where('NivelCurso','=', $request->NivelCurso)->first();
        //     //obtener la lista de los estudiantes pero solo por su estudiante_id ...
        //     //DIGAMOS UN ESTUDIANTE ESTA EN SEGUNDO MEDIO ENTONCES HABRA 5 DEL MISMO YA Q EL CURSO TIENE 5 MATERIAS
        //     $CalificacionesData = Calificaciones::where('curso_id','=', $CursoData->id)->get();
        //     //ELIMINAR VALORES DUPLICADOS POR estudiante_id
        //     $CalificacionesData = $CalificacionesData->unique('estudiante_id');
        //     $Lista = array();
        //     foreach ($CalificacionesData as $C) {
        //         $EstudiantesData = Estudiantes::where('id','=', $C->estudiante_id)->first();
        //         $Lista[] = $EstudiantesData;
        //     }
        // //     return $Lista;
        // $dataEst = (DB::select($request->consultasql))->unique(estudiante_id);

        // return $dataEst;
    }
}
