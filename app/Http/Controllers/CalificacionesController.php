<?php

namespace App\Http\Controllers;

use App\Models\Calificaciones;
use App\Models\Curso;
use App\Models\Estudiantes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use uns;

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
    public function ObtenerFechaRetiro(Request $request)
    {
        $RequestData=$request->all();
        $data = array();
        foreach ($RequestData as $c) {
            $idEst= $c['id'];  //PARA INTERACTUAR CON SU id HACER ASI
            $datasql = DB::select("SELECT administrativos.id as Admin_id,administrativos.Foto,administrativos.Ap_Paterno,
            administrativos.Ap_Materno,administrativos.Nombre,calificaciones.PruebaRecuperacion,calificaciones.Primero,calificaciones.Segundo,
            calificaciones.Tercero,calificaciones.Cuarto,calificaciones.PromEvT,calificaciones.PromEvP,
            calificaciones.Primero,calificaciones.Segundo,calificaciones.Tercero,calificaciones.Cuarto,calificaciones.Promedio,
            calificaciones.Teorica1,calificaciones.Teorica2,calificaciones.Teorica3,calificaciones.Teorica4,
            calificaciones.Practica1,calificaciones.Practica2,calificaciones.Practica3,calificaciones.Practica4,
            calificaciones.curso_id as Curso_id, calificaciones.estudiante_id,cursos.NombreCurso, cursos.NivelCurso,cursos.Tipo,
            cursos.Sigla,cursos.BiTriEstado FROM calificaciones LEFT JOIN estudiantes ON calificaciones.estudiante_id = estudiantes.id LEFT JOIN
            cursos ON calificaciones.curso_id = cursos.id  LEFT JOIN administrativos__cursos ON cursos.id = administrativos__cursos.Curso_id LEFT JOIN
             administrativos ON administrativos__cursos.Admin_id= administrativos.id where estudiante_id = $idEst");

            $forSegundo=0;
            $forTercero=0;
            $forCuarto=0;

            foreach ($datasql as $matEstsCalif) {
                if ($matEstsCalif->Promedio==0) {
                    if (($matEstsCalif->Teorica2+$matEstsCalif->Practica2)==0) {
                        $forSegundo++;
                    }
                    if(($matEstsCalif->Teorica3+$matEstsCalif->Practica3)==0){
                        $forTercero++;
                    }
                    if(($matEstsCalif->Teorica4+$matEstsCalif->Practica4)==0){
                        $forCuarto++;
                    }
                }
            }
            $fecha = '';
            if ($forSegundo!=0) {
                $fecha = '02/06/2022';
            } else {
                if ($forTercero!=0) {
                    $fecha = '01/08/2022';
                } else {
                    if ($forCuarto!=0) {
                        $fecha = '03/10/2022';
                    }
                }
            }

            $data[] = (string)$fecha;
        }
        $data=json_encode($data); //CONVIRTIENDO EN JSON PARA QUE NO DE ERRORES
        return $data;    //TAMBN SE PUEDE SUMANDO $RequestData[n]['id']
    }
    public function ListarForHeaderFinal(Request $request)
    {
        $course = $request->input('course');
        $datasql = DB::select("SELECT *,SUBSTRING(Sigla,5,7) as SiglaNum from cursos where NivelCurso='$course' order by SiglaNum asc");


        $ArrayMats = array();
        $ArraySiglaP = array();
        $ArrayHoras = array();
        $ArrayMatsS = array();
        $ArraySiglaS = array();
        $contador=0;

        $Mats=array();
        $SiglaP=array();
        $Horas=array();
        $MatsS=array();
        $SiglaS=array();

        $data = array();
        foreach ($datasql as $cdata) {

            // $materiaid = $cdata->id; //SI FUNCIONABA; PERO CUANDO SE TRATABA DE PARALELO B, NO DETECTABA PRERREQUISITO A CAUSA DE LOS PK
            $materiaid = $cdata->Sigla;
            $ArrayMats[] = $cdata->NombreCurso;
            $ArraySiglaP[] = $cdata->Sigla;
            $ArrayHoras[] = $cdata->Horas;
            $textMats='';
            $textSiglas='';
            //SI FUNCIONABA; PERO CUANDO SE TRATABA DE PARALELO B, NO DETECTABA PRERREQUISITO A CAUSA DE LOS PK
            // $prerreqs = DB::select("select p.id,p.id_materia_p,p.id_materia_s,
            // m.NombreCurso as 'mat_prin',m.Sigla as 'cod_prin', m.Horas,m.NombreCurso,m.NivelCurso,
            // m2.NombreCurso as 'materia_sec',m2.Sigla as 'cod_sec'
            // from prerrequisitos p LEFT JOIN
            // cursos m ON m.id=p.id_materia_p LEFT JOIN
            // cursos m2 ON m2.id=p.id_materia_s
            // WHERE m.id=$materiaid");
            $prerreqs = DB::select("select p.id,p.id_materia_p,p.id_materia_s,
            m.NombreCurso as 'mat_prin',m.Sigla as 'cod_prin', m.Horas,m.NombreCurso,m.NivelCurso,
            m2.NombreCurso as 'materia_sec',m2.Sigla as 'cod_sec'
            from prerrequisitos p LEFT JOIN
            cursos m ON m.id=p.id_materia_p LEFT JOIN
            cursos m2 ON m2.id=p.id_materia_s
            WHERE m.Sigla='$materiaid'");
            foreach ($prerreqs as $p) {
                $textMats=$p->materia_sec.'/'.$textMats;
                $textSiglas=$p->cod_sec.'/'.$textSiglas;
            }
            $ArrayMatsS[]=rtrim($textMats,'/');;
            $ArraySiglaS[]=rtrim($textSiglas,'/');
            $contador = $contador+1;
        }
        $cantidadMaterias = $contador;
        for ($i=0; $i < $cantidadMaterias; $i++) {
            array_push($Mats,$ArrayMats[$i]); //PARA MATERIA PRINCIPAL
            array_push($SiglaP,$ArraySiglaP[$i]); //SIGLA PRINCIPAL
            array_push($Horas,$ArrayHoras[$i]); //PARA HORAS
            array_push($MatsS,$ArrayMatsS[$i]); //PARA PRERREQUISITOS
            array_push($SiglaS,$ArraySiglaS[$i]);
        }
        //$gg=json_encode($gg); //CONVIRTIENDO EN JSON PARA QUE NO DE ERRORES

        // $data[0] = [$ArrayMatsS[0],$ArrayMatsS[1],$ArrayMatsS[2],$ArrayMatsS[3]];
        // $data[1] = [$ArraySiglaS[0],$ArraySiglaS[1],$ArraySiglaS[2],$ArraySiglaS[3]];
        // $data[2] = [$ArrayHoras[0],$ArrayHoras[1],$ArrayHoras[2],$ArrayHoras[3]];
        // $data[3] = [$ArraySiglaP[0],$ArraySiglaP[1],$ArraySiglaP[2],$ArraySiglaP[3]];
        // $data[4] = [$ArrayMats[0],$ArrayMats[1],$ArrayMats[2],$ArrayMats[3]];



        // $data[0] = $MatsS;
        // $data[1] = $SiglaS;
        // $data[2] = $Horas;
        // $data[3] = $SiglaP;
        // $data[4] = $Mats;
        $data[0] = $MatsS;
        // $data[1] = $SiglaS;
        $data[1] = $Horas;
        $data[2] = $SiglaP;
        $data[3] = $Mats;
        return $data;
    }

    public function ListarForHeaderFinal1(Request $request)
    {
        //FUNCIONA PERO SOLO CUANDO ES 1 SIGLA NOMAS COMO PRERREQUISITO
        // $data = Curso::where('NombreCurso','=',)
        $datasql = DB::select("select p.id,p.id_materia_p,p.id_materia_s,
        m.NombreCurso as 'mat_prin',m.Sigla as 'cod_prin', m.Horas,m.NombreCurso,m.NivelCurso,
        m2.NombreCurso as 'materia_sec',m2.Sigla as 'cod_sec'
        from prerrequisitos p LEFT JOIN
        cursos m ON m.id=p.id_materia_p LEFT JOIN
        cursos m2 ON m2.id=p.id_materia_s
        WHERE `m`.`NivelCurso`='PRIMERO SUPERIOR A'");

        $ArrayMats = array();
        $ArraySiglaP = array();
        $ArrayHoras = array();
        $ArrayMatsS = array();
        $ArraySiglaS = array();
        $contador=0;

        $Mats=array();
        $SiglaP=array();
        $Horas=array();
        $MatsS=array();
        $SiglaS=array();

        $data = array();
        foreach ($datasql as $cdata) {
            $ArrayMats[] = $cdata->mat_prin;
            $ArraySiglaP[] = $cdata->cod_prin;
            $ArrayHoras[] = $cdata->Horas;
            $ArrayMatsS[] = $cdata->materia_sec;
            $ArraySiglaS[] = $cdata->cod_sec;
            $contador = $contador+1;
        }
        $cantidadMaterias = $contador;
        for ($i=0; $i < $cantidadMaterias; $i++) {
            array_push($Mats,$ArrayMats[$i]);
            array_push($SiglaP,$ArraySiglaP[$i]);
            array_push($Horas,$ArrayHoras[$i]);
            array_push($MatsS,$ArrayMatsS[$i]);
            array_push($SiglaS,$ArraySiglaS[$i]);
        }
        //$gg=json_encode($gg); //CONVIRTIENDO EN JSON PARA QUE NO DE ERRORES

        // $data[0] = [$ArrayMatsS[0],$ArrayMatsS[1],$ArrayMatsS[2],$ArrayMatsS[3]];
        // $data[1] = [$ArraySiglaS[0],$ArraySiglaS[1],$ArraySiglaS[2],$ArraySiglaS[3]];
        // $data[2] = [$ArrayHoras[0],$ArrayHoras[1],$ArrayHoras[2],$ArrayHoras[3]];
        // $data[3] = [$ArraySiglaP[0],$ArraySiglaP[1],$ArraySiglaP[2],$ArraySiglaP[3]];
        // $data[4] = [$ArrayMats[0],$ArrayMats[1],$ArrayMats[2],$ArrayMats[3]];



        $data[0] = $MatsS;
        $data[1] = $SiglaS;
        $data[2] = $Horas;
        $data[3] = $SiglaP;
        $data[4] = $Mats;


        return $data;
    }
    public function ListarEstadisticasCentralizadorFinal() //lista estadisticas de todos en uno
    {
        // $array = array();
        // $Lista[] = $array;

        $data = array();

        // array_push($competition_all, $newCompete);

        $_calif = new CalificacionesController();
        $Cursos = Curso::distinct()->get(['NivelCurso']);
        $gg = 0;
        foreach ($Cursos as $c) {
            $varCurso = $c->NivelCurso;

            $CentralizadorFinalData = $_calif->ListarEstadisticasForCentralizadorFinal($varCurso);
            //CANT RETIRADOS, APROBADOS, REPROBADOS

            //CONVIERTE UN ARRAY EN OBJETO
            // $ForTittles =(object)$CentralizadorFinalData; //metodo 1
            $ForTittles = json_decode(json_encode($CentralizadorFinalData), true); //metodo 3 //SI O SI TRUE Y ADEMAS SIRVE PARA Q NO DE ERROR
            //AHORA SI PODEMOS SELECCIONAR EL VALOR DE UNA FILA ENTERA CON [0] SIN TENER ERRORES

            $Generalaprobados = 0;
            $Generalreprobados = 0;
            $Generalretirados=0;
            // obtener names de columnas
            if ($gg==0) {
                $TitlesColums=array_keys($ForTittles[0]); //OBTENER TITULOS DE COLUMNAS
                // $dd = json_decode(json_encode($CentralizadorFinalData), true);
                $dd=$ForTittles;
                $aprobados = 0;
                $reprobados = 0;
                $retirados=0;

                //ITERACION ESTUDIANTE X ESTUDIANTE

                foreach ($dd as $e ) {
                    //CONTAR PARA ESTADISTICAS
                    for ($cont=6; $cont <count($TitlesColums); $cont++) {
                        // VERIFICANDO MATERIA POR MATERIAS
                        $title = $TitlesColums[$cont]; //ACA TENEMOS EL NOMBRE DE LA COLUMNA
                        if ($e[$title]!=0) {
                            if ($e[$title]<61) {
                            $reprobados++;
                            } else {
                            $aprobados++;
                            }
                        }
                        else{
                            $retirados++;
                            $reprobados++;
                        }


                    }

                    // if ($retirados==(count($TitlesColums)-6)) {
                    //     //PRUEBA DEL RETIRADO => TODO CERO o CANTIDAD DE CEROS = cantMaterias
                    //     //RETIRADO
                    //     $e['Observacion'] = 'RETIRADO';
                    // } else {
                    //     if ($aprobados==(count($TitlesColums)-6)) {
                    //     $e['Observacion'] = 'APROBÓ';
                    //     } else {
                    //     if (strpos($varCurso, 'SUPERIOR') !== false) { //SI EN EL TXT DE NIVEL HAY UNA PALABRA QUE TENGA SUPERIOR HACER
                    //         //PRUEBA DEL REPROBADO / APROBADO, SUPERIOR => REPRUEBA MAX 2 IGUAL APRUEBA PERO DEBE LLEVAR SOLO ESAS 2 MATERIAS
                    //         //SI TIENE MAS DE 2 MATERIAS REPROBADAS PIERDE EL AÑO
                    //         if($reprobados>2)
                    //         {
                    //         //REPROBADO - SUPERIOR
                    //         $e['Observacion'] = 'REPROBADO';
                    //         }else{
                    //         //APROBADO- SUPERIOR
                    //         $e['Observacion'] = 'APROBÓ C/ ARRASTRE';
                    //         }
                    //     } else {
                    //         //PRUEBA DEL REPROBADO / APROBADO, NIVEL CAPACITACION => REPRUEBA SOLO 1 Y PIERDE TODO
                    //         //SI TIENE 1 MATERIA REPROBADAS PIERDE EL AÑO
                    //         if($reprobados>0)
                    //         {
                    //         //REPROBADO - CAPACITACION
                    //         $e['Observacion'] = 'REPROBADO';
                    //         }else{
                    //         //APROBADO- CAPACITACION
                    //         $e['Observacion'] = 'APROBÓ';
                    //         }
                    //     }
                    //     }
                    // }
                }




            }
            $gg++;


            // foreach ($CentralizadorFinalData as $d ) {
            //     $obs=$d->Observacion;
            //     if ($obs=='RETIRADO') {
            //         $retirados++;
            //     }else if($obs=='REPROBADO'){
            //         $reprobados++;
            //     }else{
            //         $aprobados++;
            //     }
            // }


            // $data[] = ['CURSO'=>$varCurso,'APROBADOS'=>$aprobados,'REPROBADOS'=>$reprobados,'RETIRADOS'=>$retirados];
            $data[]=$CentralizadorFinalData;
        }
        return $reprobados;
    }

    public function ListarEstadisticasForCentralizadorFinal(String $course) //lista estadisticas por curso
    {
        $curso = $course;
        //CONSEGUIR ID DE CURSO POR NIVEL DE CURSO
        $Cursodata= DB::select("SELECT *,SUBSTRING(Sigla,5,7) as SiglaNum from cursos where NivelCurso='$curso' order by SiglaNum asc");
        //GUARDANDO ID DEL PRIMER CURSO DE LA PRIMERA FILA
        $idCurso = $Cursodata[0]->id;


        //ARMAR LISTA DE CURSOS PARA ENVIAR COMO LISTA DE MATERIAS
        $concatmat = array();
        foreach ($Cursodata as $cdata) {

            $varCurso = $cdata->id;
            $dataCurso = DB::select("select NombreCurso,Sigla from cursos where id=$varCurso");
            // dataVariable =  DB::select("delete from NombreTabla where PrimaryKey='Simbolo Dolarid'");
            $concatmat[] = $dataCurso[0]->NombreCurso;
        }


        // $concatmat = collect($concatmat)->sortBy('Sigla')->reverse()->toArray();
        $concatmat=json_encode($concatmat); //CONVIRTIENDO EN JSON PARA QUE NO DE ERRORES
        $materias=$concatmat;


        // return $materias;


        //CONSEGUIR LISTAR TODOS LOS ESTUDIANTES DE UN CURSO POR SU ID DE CURSO (SELECCIONANDO SOLO SI ID del estudiante)
        $dataEsts = DB::select("SELECT `calificaciones`.estudiante_id FROM `calificaciones` LEFT JOIN
        `estudiantes` ON `calificaciones`.`estudiante_id` = `estudiantes`.`id` LEFT JOIN
        `administrativos` ON `estudiantes`.`Admin_id` = `administrativos`.`id`
        WHERE calificaciones.curso_id = $idCurso ORDER BY estudiantes.Ap_Paterno , estudiantes.Ap_Materno, estudiantes.Nombre");



        //PROCEDER A CONSTRUIR LA DATA CENTRALIZADOR FINAL

        $data = array();
                foreach ($dataEsts as $est) {
                    // $CentralizadorData = Estudiantes::where('id','=', $C->estudiante_id)->first();
                    $CentralizadorData=DB::select("CALL getCentralizadorFinal('$materias',$est->estudiante_id,'$curso')"); // PARA LLAMAR PROCEDURES
                    $data[] = $CentralizadorData[0];
                }
        return $data;
    }
    public function VerificarSegundaInstancia(Request $request)
    {
        $dataRequest = $request->all();
        $idCurso= $dataRequest['curso_id'];
        // OBTENER DATOS DE CURSO MEDIANTE ID
        $cursoData= DB::select("SELECT * from cursos where id='$idCurso'");
        // $curso = 'PRIMERO SUPERIOR A';
        // $MateriaActual='TEORIA DEL SONIDO';
        // $Nivel = 'TECNICO SUPERIOR';

        $curso = $cursoData[0]->NivelCurso;
        $MateriaActual=$cursoData[0]->NombreCurso;
        if (strpos($curso, 'SUPERIOR') !== false) {
            $Nivel = 'TECNICO SUPERIOR';
        }else{
            $Nivel = 'CAPACITACION';
        }

        // $CentralizadorFinalData = $_calif->ListarForCentralizadorFinal($NivelCurso);

        //CONSEGUIR ID DE CURSO POR NIVEL DE CURSO
        $Cursodata= DB::select("SELECT *,SUBSTRING(Sigla,5,7) as SiglaNum from cursos where NivelCurso='$curso' order by SiglaNum asc");
        //GUARDANDO ID DEL PRIMER CURSO DE LA PRIMERA FILA
        $idCurso = $Cursodata[0]->id;


        $concatmat = array();
        foreach ($Cursodata as $cdata) {

            $varCurso = $cdata->id;
            $dataCurso = DB::select("select NombreCurso,Sigla from cursos where id=$varCurso");
            // dataVariable =  DB::select("delete from NombreTabla where PrimaryKey='Simbolo Dolarid'");
            $concatmat[] = $dataCurso[0]->NombreCurso;
        }

        $materiasEncontradas=json_encode($concatmat); //CONVIRTIENDO EN JSON PARA QUE NO DE ERRORES
        $materias=$materiasEncontradas;

        //OBTENER INFO DE ESTUDIANTE DE SUS CALIFICACIONES DE TODAS SUS MATERIAS
        $dataCentralizador = DB::select("CALL getCentralizadorFinal('$materias',$request->estudiante_id,'$curso')"); // PARA LLAMAR PROCEDURES

        //VERIFICAR CALIFICACIONES
        $contadorReprobados=0;
        $contadorRetirados=0;
        $contadorAprobados=0;
        $contadorSegundaInstancia=0;
        $contadorInvalidos=0; //CANTIDAD DE MATERIAS Q NO CUMPLEN CON LA NOTA DE 40
        $CursosInvalidos = array();
        foreach ($Cursodata as $a) {
            $nomMateria= $a->NombreCurso;
            $calif=(int)($dataCentralizador[0]->$nomMateria);
            if ($calif == 0) {
                $contadorRetirados++;
            }
            else
            {
                if ($calif<61) {
                    $contadorReprobados++;
                    if ($calif>39) {
                        $contadorSegundaInstancia++;
                    }else if($calif<40){
                        $contadorInvalidos++;
                        $CursosInvalidos[]=$nomMateria;
                    }
                }else{
                    $contadorAprobados++;
                }
            }
        }
        $RealizaraSegundaInstancia=true;
        if ($contadorReprobados>3) { //SI SON MAS DE 3 MATERIAS REPROBADAS NO PUEDE DAR 2DA INSTANCIA
            $RealizaraSegundaInstancia=false;
        }
        else{

            //$contadorSegundaInstancia //CANTIDAD DE MATERIAS VALIDAS PARA SEGUNDA INSTANCIA


            switch ($Nivel) {
                case 'TECNICO SUPERIOR':
                    if ($contadorSegundaInstancia<4) { //SOLO SE ADMITEN HASTA 3 MATERIAS COMO 2DA INSTANCIA
                            $RealizaraSegundaInstancia=true;
                    }
                    break;
                case 'CAPACITACION':
                    if($contadorRetirados!=0){
                        $RealizaraSegundaInstancia=false;
                    }else if ($contadorInvalidos!=0) {
                        $RealizaraSegundaInstancia=false;
                    }else{
                        $RealizaraSegundaInstancia=true;
                    }
                    break;
                default:
                    # code...
                    break;
            }


        }

        //VERIFICACION EXTRA - SI LA MATERIA ACTUAL COINCIDE CON LA MATERIA INVALIDA POR LO TANTO FALSEAR
        for ($i=0; $i < $contadorInvalidos; $i++) {
            if ($CursosInvalidos[$i]==$MateriaActual) {
                $RealizaraSegundaInstancia=false;
            }
        }


        return $RealizaraSegundaInstancia;
        // return $contadorSegundaInstancia;

    }
    public function ListarForCentralizadorFinal(Request $request) //CENTRALIZADOR FINAL FINISH
    {
        // $data = DB::select("SELECT estudiantes.Ap_Paterno, estudiantes.Ap_Materno, estudiantes.Nombre, estudiantes.CI  ,calificaciones.PruebaRecuperacion,calificaciones.curso_id as Curso_id, calificaciones.estudiante_id,cursos.NombreCurso,cursos.Horas, cursos.NivelCurso,cursos.Tipo,cursos.Sigla,cursos.BiTriEstado
        // FROM calificaciones LEFT JOIN
        // estudiantes ON calificaciones.estudiante_id = estudiantes.id LEFT JOIN
        // cursos ON calificaciones.curso_id = cursos.id
        // where cursos.NivelCurso='PRIMERO SUPERIOR A' ORDER BY estudiantes.Ap_Paterno,estudiantes.Ap_Materno,estudiantes.Nombre, estudiante_id, cursos.Sigla");


    //     $FF="SELECT estudiantes.Ap_Paterno, estudiantes.Ap_Materno, estudiantes.Nombre, estudiantes.CI, calificaciones.Promedio,
    //     (CASE WHEN cursos.NombreCurso='APRECIACION MUSICAL' THEN calificaciones.Promedio ELSE 0 END) as 'APRECIACION MUSICAL',
    //      (CASE WHEN cursos.NombreCurso='ARMONIA I' THEN calificaciones.Promedio ELSE 0 END) as 'ARMONIA I',
    //       (CASE WHEN cursos.NombreCurso='INSTRUMENTO COMPLEMENTARIO I' THEN calificaciones.Promedio ELSE 0 END) as 'INSTRUMENTO COMPLEMENTARIO I',
    //    (CASE WHEN cursos.NombreCurso='INSTRUMENTO DE ESPECIALIDAD I' THEN calificaciones.Promedio ELSE 0 END) as 'INSTRUMENTO DE ESPECIALIDAD I',
    //    (CASE WHEN cursos.NombreCurso='LENGUAJES MUSICALES SUPERIOR' THEN calificaciones.Promedio ELSE 0 END) as 'LENGUAJES MUSICALES SUPERIOR',
    //    (CASE WHEN cursos.NombreCurso='PRACTICA DE CONJUNTOS I' THEN calificaciones.Promedio ELSE 0 END) as 'PRACTICA DE CONJUNTOS I',
    //    (CASE WHEN cursos.NombreCurso='TEORIA DEL SONIDO' THEN calificaciones.Promedio ELSE 0 END) as 'TEORIA DEL SONIDO'
    //    FROM estudiantes LEFT JOIN
    //    calificaciones ON estudiantes.id = calificaciones.estudiante_id LEFT JOIN
    //    -- estudiantes ON calificaciones.estudiante_id = estudiantes.id LEFT JOIN
    //    cursos ON calificaciones.curso_id = cursos.id
    //    where cursos.NivelCurso='PRIMERO SUPERIOR A' ORDER BY estudiantes.Ap_Paterno,estudiantes.Ap_Materno,estudiantes.Nombre, estudiante_id, cursos.Sigla";

    // $data=DB::select("SELECT example(751,'PRIMERO SUPERIOR A');");   //para llamar a funciones

    $curso = $request->input('NivelCurso');
    //CONSEGUIR ID DE CURSO POR NIVEL DE CURSO
    $Cursodata= DB::select("SELECT *,SUBSTRING(Sigla,5,7) as SiglaNum from cursos where NivelCurso='$curso' order by SiglaNum asc");
    //GUARDANDO ID DEL PRIMER CURSO DE LA PRIMERA FILA
    $idCurso = $Cursodata[0]->id;


    //ARMAR LISTA DE CURSOS PARA ENVIAR COMO LISTA DE MATERIAS
    // $inicio = '['; $fin ='"]';
    // $concatmat = '';
    // //(1) FUNCIONA PERO VARIA MUCHO O SE DESORDENA CON LOS """" ASI Q MEJOR ENVIAR UN CONJUNTO DE DATOS
    // foreach ($Cursodata as $c) {
    //     $concatmat='"'.$concatmat.'"'.','.'"'.$c->NombreCurso.''; //(1)
    // }
    // $concatmat = $inicio.$concatmat.$fin; //UNIENDO TODO
    // //ESTO CORRIGE ERRORES PERO AL CORREGIR SE VUELVE COMO UN CONJUNTO DE DATOS NORMAL COMO SI FUESE JSON, SIRVE (1)
    // $concatmat = preg_replace('/""""""""",/m',"", $concatmat);
    // $materias=$concatmat;
    $concatmat = array();
    foreach ($Cursodata as $cdata) {

        $varCurso = $cdata->id;
        $dataCurso = DB::select("select NombreCurso,Sigla from cursos where id=$varCurso");
        // dataVariable =  DB::select("delete from NombreTabla where PrimaryKey='Simbolo Dolarid'");
        $concatmat[] = $dataCurso[0]->NombreCurso;
    }


    // $concatmat = collect($concatmat)->sortBy('Sigla')->reverse()->toArray();
    $concatmat=json_encode($concatmat); //CONVIRTIENDO EN JSON PARA QUE NO DE ERRORES
    $materias=$concatmat;


    // return $materias;


    //CONSEGUIR LISTAR TODOS LOS ESTUDIANTES DE UN CURSO POR SU ID DE CURSO (SELECCIONANDO SOLO SI ID del estudiante)
    $dataEsts = DB::select("SELECT `calificaciones`.estudiante_id FROM `calificaciones` LEFT JOIN
    `estudiantes` ON `calificaciones`.`estudiante_id` = `estudiantes`.`id` LEFT JOIN
    `administrativos` ON `estudiantes`.`Admin_id` = `administrativos`.`id`
    WHERE calificaciones.curso_id = $idCurso ORDER BY estudiantes.Ap_Paterno , estudiantes.Ap_Materno, estudiantes.Nombre");



    //PROCEDER A CONSTRUIR LA DATA CENTRALIZADOR FINAL
    // $data=DB::select("SET numList = ARRAY[1,2,3,4,5,6]; CALL example1(751,'PRIMERO SUPERIOR A')"); // PARA LLAMAR PROCEDURES
    // $curso = $request->input('NivelCurso');
    // $materias="";
    // $materias= '["APRECIACION MUSICAL","ARMONIA I","INSTRUMENTO COMPLEMENTARIO I","INSTRUMENTO DE ESPECIALIDAD I","LENGUAJES MUSICALES SUPERIOR",
    // "PRACTICA DE CONJUNTOS I","TEORIA DEL SONIDO"]';
    // $data=DB::select("CALL getCentralizadorFinal('$materias',735,'$curso')"); // PARA LLAMAR PROCEDURES
    //$data = "CALL getCentralizadorFinal('$txt',751,'$curso');";

    $data = array(); //ES CON SEXO
            foreach ($dataEsts as $est) {
                // $CentralizadorData = Estudiantes::where('id','=', $C->estudiante_id)->first();
                $CentralizadorData=DB::select("CALL getCentralizadorFinal('$materias',$est->estudiante_id,'$curso')"); // PARA LLAMAR PROCEDURES
                $data[] = $CentralizadorData[0];
            }
    $data2 = array(); //ES CON SEXO
    foreach ($dataEsts as $est) {
        // $CentralizadorData = Estudiantes::where('id','=', $C->estudiante_id)->first();
        $CentralizadorData=DB::select("CALL getCentralizadorFinalSinSexo('$materias',$est->estudiante_id,'$curso')"); // PARA LLAMAR PROCEDURES
        $data2[] = $CentralizadorData[0];
    }
    return response()->json(["lista1" =>$data,"lista2" =>$data2,], 200);

#region SE LOGRO GRACIAS A
//ESTE FUE DE AYUDA PARA LOGRARLO
// DELIMITER ;
// DELIMITER $$
// CREATE OR REPLACE PROCEDURE GetFruits(IN fruitArray VARCHAR(255), idEst INT, cursoname VARCHAR)
// BEGIN
//   SET @sql = CONCAT('SELECT * FROM Fruits WHERE Name IN (', fruitArray, ')');
//   PREPARE stmt FROM @sql;
//   EXECUTE stmt;
//   DEALLOCATE PREPARE stmt;
// END
// $$

// TAMBIEN ESTE
// DELIMITER ;
// DELIMITER $$
// CREATE OR REPLACE PROCEDURE GetCentralizador(IN dataArray VARCHAR(255),idEst INT, nombreCurso VARCHAR(100))
// BEGIN
// 	SET @ini = 'SELECT estudiantes.Ap_Paterno, estudiantes.Ap_Materno, estudiantes.Nombre, estudiantes.CI,estudiantes.id,';
//     SET @fin = CONCAT('FROM estudiantes LEFT JOIN calificaciones ON estudiantes.id = calificaciones.estudiante_id LEFT JOIN cursos ON calificaciones.curso_id = cursos.id where cursos.NivelCurso=',nombreCurso,' ORDER BY estudiantes.Ap_Paterno,estudiantes.Ap_Materno,estudiantes.Nombre, estudiante_id, cursos.Sigla;');

//   SET @str='';
//   SET @cont = 0;
//   loop_label: LOOP
//     IF @cont > 7 THEN
//       LEAVE loop_label;
//     END IF;
//     SET @str = CONCAT(@str,'SUM(CASE WHEN cursos.NombreCurso=',dataArray(1),' AND estudiantes.id = ',idEst,' THEN calificaciones.Promedio ELSE 0 END) as "',dataArray,'",');
//     SET @cont = @cont + 1;
//     ITERATE loop_label;
//   END LOOP;
//   SET @sql = CONCAT(@ini,@str,@fin);
//   PREPARE stmt FROM @sql;
//   EXECUTE stmt;
//   DEALLOCATE PREPARE stmt;
// END
// $$

// CONSULTA DEL PROCEDURE FINAL FUCIONAL PERO CON DATOS FIJOS
// DELIMITER ;
// DELIMITER $$
// CREATE OR REPLACE PROCEDURE getCentralizadorFinal(idEst INT, nombreCurso VARCHAR(100))
// BEGIN

//   DECLARE _result varchar(10000) DEFAULT '';
//   DECLARE _counter INT DEFAULT 0;
//   DECLARE _value varchar(50);

//   SET @ini = 'SELECT estudiantes.Ap_Paterno, estudiantes.Ap_Materno, estudiantes.Nombre, estudiantes.CI,estudiantes.id,';
//   SET @fin = CONCAT('FROM estudiantes LEFT JOIN calificaciones ON estudiantes.id = calificaciones.estudiante_id LEFT JOIN cursos ON calificaciones.curso_id = cursos.id where cursos.NivelCurso="',nombreCurso,'" ORDER BY estudiantes.Ap_Paterno,estudiantes.Ap_Materno,estudiantes.Nombre, estudiante_id, cursos.Sigla;');

//   SET @myjson = '["APRECIACION MUSICAL","ARMONIA I","INSTRUMENTO COMPLEMENTARIO I","INSTRUMENTO DE ESPECIALIDAD I","LENGUAJES MUSICALES SUPERIOR",
//                 "PRACTICA DE CONJUNTOS I","TEORIA DEL SONIDO"]';

//   WHILE _counter < JSON_LENGTH(@myjson)-1 DO
//     -- do whatever, e.g. add-up strings...
//     -- SET _result = CONCAT(_result, _counter, '-', JSON_VALUE(@myjson, CONCAT('$[',_counter,']')), '#');
// 	 SET _result = CONCAT(_result,'SUM(CASE WHEN cursos.NombreCurso="',JSON_VALUE(@myjson, CONCAT('$[',_counter,']')),'" AND estudiantes.id = ',idEst,' THEN calificaciones.Promedio ELSE 0 END) as "',JSON_VALUE(@myjson, CONCAT('$[',_counter,']')),'",');
//     SET _counter = _counter + 1;
//   END WHILE;

//   -- ULTIMA ITERACION PARA EVITAR ERROR DEL FROM
// 	SET _result = CONCAT(_result,'SUM(CASE WHEN cursos.NombreCurso="',JSON_VALUE(@myjson, CONCAT('$[',_counter,']')),'" AND estudiantes.id = ',idEst,' THEN calificaciones.Promedio ELSE 0 END) as "',JSON_VALUE(@myjson, CONCAT('$[',_counter,']')),'" ');
//     -- SET @sql = CONCAT(@ini,_result,@fin);
//     -- RETURN @sql;
//     SET @sql = CONCAT(@ini,_result,@fin);
//   PREPARE stmt FROM @sql;
//   EXECUTE stmt;
//   DEALLOCATE PREPARE stmt;
// END
// $$

// CALL example1(751,'PRIMERO SUPERIOR A');


#endregion SE LOGRO GRACIAS A

    #region ESTO ES LO LOGRADO FINISH , SIRVE PERO ESTA SIN LA CORRECION DE 2DA INSTANCIA
    // -- PROCEDURE FINALIZADO ESTE ES EL Q SE USA... ES CON DATOS DIANMICOS
    // DELIMITER ;
    // DELIMITER $$
    // CREATE OR REPLACE PROCEDURE getCentralizadorFinal(dataArray VARCHAR(500),idEst INT, nombreCurso VARCHAR(100))
    // BEGIN

    //   DECLARE _result varchar(10000) DEFAULT '';
    //   DECLARE _counter INT DEFAULT 0;
    //   DECLARE _value varchar(50);

    //   SET @ini = 'SELECT estudiantes.Ap_Paterno, estudiantes.Ap_Materno, estudiantes.Nombre, estudiantes.CI,estudiantes.id,estudiantes.Especialidad,';
    //   SET @fin = CONCAT('FROM estudiantes LEFT JOIN calificaciones ON estudiantes.id = calificaciones.estudiante_id LEFT JOIN cursos ON calificaciones.curso_id = cursos.id where cursos.NivelCurso="',nombreCurso,'" AND estudiantes.id="',idEst,'" ORDER BY estudiantes.Ap_Paterno,estudiantes.Ap_Materno,estudiantes.Nombre, estudiante_id, cursos.Sigla;');

    //   -- SET @myjson = '["APRECIACION MUSICAL","ARMONIA I","INSTRUMENTO COMPLEMENTARIO I","INSTRUMENTO DE ESPECIALIDAD I","LENGUAJES MUSICALES SUPERIOR", "PRACTICA DE CONJUNTOS I","TEORIA DEL SONIDO"]';
    //       SET @myjson = dataArray;

    //   WHILE _counter < JSON_LENGTH(@myjson)-1 DO
    //     -- do whatever, e.g. add-up strings...
    //     -- SET _result = CONCAT(_result, _counter, '-', JSON_VALUE(@myjson, CONCAT('$[',_counter,']')), '#');
    // 	 SET _result = CONCAT(_result,'SUM(CASE WHEN cursos.NombreCurso="',JSON_VALUE(@myjson, CONCAT('$[',_counter,']')),'" AND estudiantes.id = ',idEst,' THEN calificaciones.Promedio ELSE 0 END) as "',JSON_VALUE(@myjson, CONCAT('$[',_counter,']')),'",');
    //     SET _counter = _counter + 1;
    //   END WHILE;

    //   -- ULTIMA ITERACION PARA EVITAR ERROR DEL FROM
    // 	SET _result = CONCAT(_result,'SUM(CASE WHEN cursos.NombreCurso="',JSON_VALUE(@myjson, CONCAT('$[',_counter,']')),'" AND estudiantes.id = ',idEst,' THEN calificaciones.Promedio ELSE 0 END) as "',JSON_VALUE(@myjson, CONCAT('$[',_counter,']')),'" ');
    //     -- SET @sql = CONCAT(@ini,_result,@fin);
    //     -- RETURN @sql;
    //     SET @sql = CONCAT(@ini,_result,@fin);
    //   PREPARE stmt FROM @sql;
    //   EXECUTE stmt;
    //   DEALLOCATE PREPARE stmt;
    // END
    // $$

    // ACA ESTA PARA EJECUTAR
    // SET @data = '["APRECIACION MUSICAL","ARMONIA I","INSTRUMENTO COMPLEMENTARIO I","INSTRUMENTO DE ESPECIALIDAD I","LENGUAJES MUSICALES SUPERIOR",
    //                 "PRACTICA DE CONJUNTOS I","TEORIA DEL SONIDO"]';
    // CALL getCentralizadorFinal(@data,751,'PRIMERO SUPERIOR A');
    #endregion esto es lo logrado



    //ESTE ES EL FINISH ORIGINAL 100 POR CIENTO NO FAKE //SE CORRIGIO LA PARTE Q EN EL CENTRALIZADOR FINAL NO HACIA CASO A LAS 2das INSTANCIAS
    // -- PROCEDURE FINALIZADO ESTE ES EL Q SE USA... ES CON DATOS DIANMICOS
    // DELIMITER ;
    // DELIMITER $$
    // CREATE OR REPLACE PROCEDURE getCentralizadorFinal(dataArray VARCHAR(500),idEst INT, nombreCurso VARCHAR(100))
    // BEGIN

    //   DECLARE _result varchar(10000) DEFAULT '';
    //   DECLARE _counter INT DEFAULT 0;
    //   DECLARE _value varchar(50);

    //   SET @ini = 'SELECT estudiantes.Ap_Paterno, estudiantes.Ap_Materno, estudiantes.Nombre, estudiantes.CI,estudiantes.id,estudiantes.Especialidad,';
    //   SET @fin = CONCAT('FROM estudiantes LEFT JOIN calificaciones ON estudiantes.id = calificaciones.estudiante_id LEFT JOIN cursos ON calificaciones.curso_id = cursos.id where cursos.NivelCurso="',nombreCurso,'" AND estudiantes.id="',idEst,'" ORDER BY estudiantes.Ap_Paterno,estudiantes.Ap_Materno,estudiantes.Nombre, estudiante_id, cursos.Sigla;');

    //   -- SET @myjson = '["APRECIACION MUSICAL","ARMONIA I","INSTRUMENTO COMPLEMENTARIO I","INSTRUMENTO DE ESPECIALIDAD I","LENGUAJES MUSICALES SUPERIOR", "PRACTICA DE CONJUNTOS I","TEORIA DEL SONIDO"]';
    //       SET @myjson = dataArray;

    //   WHILE _counter < JSON_LENGTH(@myjson)-1 DO
    //     -- do whatever, e.g. add-up strings...
    //     -- SET _result = CONCAT(_result, _counter, '-', JSON_VALUE(@myjson, CONCAT('$[',_counter,']')), '#');
    // 	 SET _result = CONCAT(_result,'SUM(CASE WHEN cursos.NombreCurso="',JSON_VALUE(@myjson, CONCAT('$[',_counter,']')),'" AND estudiantes.id = ',idEst,' THEN

    //                           (IF (calificaciones.PruebaRecuperacion IS NULL,calificaciones.Promedio ,calificaciones.PruebaRecuperacion ))
    //                           ELSE 0 END) as "',JSON_VALUE(@myjson, CONCAT('$[',_counter,']')),'",');
    //     SET _counter = _counter + 1;
    //   END WHILE;

    //   -- ULTIMA ITERACION PARA EVITAR ERROR DEL FROM
    // 	SET _result = CONCAT(_result,'SUM(CASE WHEN cursos.NombreCurso="',JSON_VALUE(@myjson, CONCAT('$[',_counter,']')),'" AND estudiantes.id = ',idEst,' THEN
    //                          (IF (calificaciones.PruebaRecuperacion IS NULL,calificaciones.Promedio ,calificaciones.PruebaRecuperacion ))
    //                          ELSE 0 END) as "',JSON_VALUE(@myjson, CONCAT('$[',_counter,']')),'" ');
    //     -- SET @sql = CONCAT(@ini,_result,@fin);
    //     -- RETURN @sql;
    //     SET @sql = CONCAT(@ini,_result,@fin);
    //   PREPARE stmt FROM @sql;
    //   EXECUTE stmt;
    //   DEALLOCATE PREPARE stmt;
    // END
    // $$

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
