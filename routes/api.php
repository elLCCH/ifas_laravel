<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// use App\Mail\RegistroCompletadoExitosamente;
// use Illuminate\Support\Facades\Mail;
// use Illuminate\Support\Facades\Storage;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*HORARIO */
Route::resource('Horario', 'App\Http\Controllers\HorariosController');
Route::post('updateHorario/{id}', 'App\Http\Controllers\HorariosController@updateHorario');
/*AÑO*/
Route::get('DeterminarInstituto', 'App\Http\Controllers\AnioController@DeterminarInstituto');
Route::get('ObtenerLogo', 'App\Http\Controllers\AnioController@ObtenerLogo');
Route::get('indexAll', 'App\Http\Controllers\AnioController@indexAll');
Route::resource('Anio', 'App\Http\Controllers\AnioController');
/*CURSO*/
Route::resource('curso', 'App\Http\Controllers\CursoController');
Route::post('cursoUnique', 'App\Http\Controllers\CursoController@CargarCursosUnique');
Route::post('ListaEstudiantes', 'App\Http\Controllers\CursoController@ListaEstudiantes');
Route::get('BuscarNivelCurso/{idCurso}', 'App\Http\Controllers\CursoController@BuscarNivelCurso');
Route::post('MateriasxEstudianteAnio', 'App\Http\Controllers\CursoController@MateriasxEstudianteAnio');
Route::post('MateriasxAnioMallaNivelCurso', 'App\Http\Controllers\CursoController@MateriasxAnioMallaNivelCurso');
Route::post('MateriasxAnioNivel', 'App\Http\Controllers\CursoController@MateriasxAnioNivel');
Route::post('MateriasxAnioMalla', 'App\Http\Controllers\CursoController@MateriasxAnioMalla');
Route::post('ListaAgrupacionMateriasXCursos/{idAdmin}', 'App\Http\Controllers\CursoController@ListaAgrupacionMateriasXCursos');
Route::get('CargarSiglaUnique', 'App\Http\Controllers\CursoController@CargarSiglaUnique');
Route::post('ModificarBimestres', 'App\Http\Controllers\CursoController@ModificarBimestres');
Route::get('CursosUniqueSigla', 'App\Http\Controllers\CursoController@CursosUniqueSigla');
Route::get('CargarMalla', 'App\Http\Controllers\CursoController@CargarMalla');
Route::post('ClonarGestion', 'App\Http\Controllers\CursoController@ClonarGestion');
Route::post('RespaldarSiglas', 'App\Http\Controllers\CursoController@RespaldarSiglas');
Route::delete('cursoYPrerreq/{idCurso}', 'App\Http\Controllers\CursoController@cursoYPrerreq');
/*CALIFICACIONES*/
Route::resource('calificacion', 'App\Http\Controllers\CalificacionesController');
Route::post('EncontrarNivelCurso/{idEst}', 'App\Http\Controllers\CalificacionesController@EncontrarNivelCurso');
Route::post('EliminarEstudianteDelCurso', 'App\Http\Controllers\CalificacionesController@EliminarEstudianteDelCurso');
Route::get('ListarXCursoCalif/{idCurso}', 'App\Http\Controllers\CalificacionesController@ListarXCursoCalif');
Route::post('ListarForCentralizadorFinal', 'App\Http\Controllers\CalificacionesController@ListarForCentralizadorFinal');
Route::post('ListarForHeaderFinal', 'App\Http\Controllers\CalificacionesController@ListarForHeaderFinal');
Route::post('ObtenerFechaRetiro', 'App\Http\Controllers\CalificacionesController@ObtenerFechaRetiro');
Route::post('VerificarSegundaInstancia', 'App\Http\Controllers\CalificacionesController@VerificarSegundaInstancia');
Route::get('ListarEstadisticasCentralizadorFinal', 'App\Http\Controllers\CalificacionesController@ListarEstadisticasCentralizadorFinal');

/*ESTUDIANTES*/
Route::resource('Estudiante', 'App\Http\Controllers\EstudiantesController');
Route::post('EstudianteUpdate/{admin}', 'App\Http\Controllers\EstudiantesController@actualizar');
Route::get('EstudianteCuadro', 'App\Http\Controllers\EstudiantesController@EstudianteCuadro');
Route::post('AbrirPDF', 'App\Http\Controllers\EstudiantesController@AbrirPDF');
Route::post('EliminarInactivos', 'App\Http\Controllers\EstudiantesController@EliminarInactivos');
Route::post('EstudianteAUTH', 'App\Http\Controllers\EstudiantesController@autentificar');
Route::get('ObtenerNombreCompleto/{idEst}', 'App\Http\Controllers\EstudiantesController@ObtenerNombreCompleto');
Route::post('OrdenarLista', 'App\Http\Controllers\EstudiantesController@OrdenarLista');
Route::get('indexSelection/{idest}', 'App\Http\Controllers\EstudiantesController@indexSelection');
Route::post('DetectarCantidadEstudiantesInscritos', 'App\Http\Controllers\EstudiantesController@DetectarCantidadEstudiantesInscritos');
Route::post('VerificarCursoParalelo', 'App\Http\Controllers\EstudiantesController@VerificarCursoParalelo');
Route::get('EstadisticasAsigEstudiantes/{idAnio}', 'App\Http\Controllers\EstudiantesController@EstadisticasAsigEstudiantes');
/*ADMINISTRATIVOS_CURSOS*/
Route::resource('AdminCursos', 'App\Http\Controllers\AdministrativosCursosController');
Route::post('EliminarAdminCursos', 'App\Http\Controllers\AdministrativosCursosController@EliminarAdminCursos');
Route::post('PruebaExistencia', 'App\Http\Controllers\AdministrativosCursosController@PruebaExistencia');
/*ADMINISTRATIVOS*/
Route::resource('Administrativo', 'App\Http\Controllers\AdministrativosController');
Route::post('AdministrativoAUTH', 'App\Http\Controllers\AdministrativosController@autentificar');
Route::get('DiferenciadorIndex', 'App\Http\Controllers\AdministrativosController@DiferenciadorIndex');
Route::post('EncontrarDocenteEspecialidad/{admin}', 'App\Http\Controllers\AdministrativosController@EncontrarDocenteEspecialidad');
Route::post('AdministrativoUpdate/{admin}', 'App\Http\Controllers\AdministrativosController@actualizar');
/*PUBLICACIONES*/
Route::resource('Publicacion', 'App\Http\Controllers\PublicacionesController');
Route::post('PublicacionUpdate/{admin}', 'App\Http\Controllers\PublicacionesController@actualizar');

/*AREA EVENTOS*/
Route::resource('AreaEventos', 'App\Http\Controllers\AreaeventosController');
/*PRERREQUISITOS*/
Route::resource('Prerrequisito', 'App\Http\Controllers\PrerrequisitosController');
Route::post('indexListarxGestion', 'App\Http\Controllers\PrerrequisitosController@indexListarxGestion');
/*EVENTOS*/
Route::resource('Evento', 'App\Http\Controllers\EventosController');
Route::get('EventoActivo', 'App\Http\Controllers\EventosController@EventoActivo');
Route::post('updateEvento/{idEven}', 'App\Http\Controllers\EventosController@updateEvento');
/*INS EVENTOS*/
Route::resource('InsEvento', 'App\Http\Controllers\InsEventosController');
Route::post('updateInsEvento/{idIns}', 'App\Http\Controllers\InsEventosController@updateInsEvento');
// ENVIAR MAIL
Route::post('EnviarConfirmacion', 'App\Http\Controllers\EmailsController@Mails');
// Route::post('EnviarConfirmacion', function () {
//     $Correo = new RegistroCompletadoExitosamente;
//     // localStorage.getItem("CorreoSend");
//     Mail::to('luischoque.98oruro@gmail.com')->send($Correo);
//     // Mail::to($correo)->send($MensajeCorreo);
//     return 'MENSAJE ENVIADOS';
// });

//LISTAS DE APIs - APIS CONTROLLER
Route::get('ListarInstrumentosModernosApi', 'App\Http\Controllers\ApisController@ListarInstrumentosModernosApi');
Route::get('ListarMensionesModernasApi', 'App\Http\Controllers\ApisController@ListarMensionesModernasApi');
Route::get('ListarCursosPostulantesApi', 'App\Http\Controllers\ApisController@ListarCursosPostulantesApi');
Route::get('ListarCategoriasApi', 'App\Http\Controllers\ApisController@ListarCategoriasApi');
Route::get('DisponibilidadInscripciones', 'App\Http\Controllers\ApisController@DisponibilidadInscripciones');
Route::get('DisponibilidadInscripcionesNuevos', 'App\Http\Controllers\ApisController@DisponibilidadInscripcionesNuevos');
Route::get('VideoApi', 'App\Http\Controllers\ApisController@VideoApi');
Route::post('ConsultarApi', 'App\Http\Controllers\ApisController@ConsultarApi');
Route::post('ConsultarApiUniqueCI', 'App\Http\Controllers\ApisController@ConsultarApiUniqueCI');
Route::get('ListarHorariosSuperiorApi', 'App\Http\Controllers\ApisController@ListarHorariosSuperiorApi');
Route::get('ListarHorariosCapacitacionApi', 'App\Http\Controllers\ApisController@ListarHorariosCapacitacionApi');
Route::post('ConsultarApiCursosEst', 'App\Http\Controllers\ApisController@ConsultarApiCursosEst');
Route::get('ListarAbreviacionDptosApi', 'App\Http\Controllers\ApisController@ListarAbreviacionDptosApi');

// NUEVA GESTION
Route::get('ListarTipoMateriaApi', 'App\Http\Controllers\ApisController@ListarTipoMateriaApi');
Route::get('ListarCursosApi', 'App\Http\Controllers\ApisController@ListarCursosApi');
Route::get('ListarAreasApi', 'App\Http\Controllers\ApisController@ListarAreasApi');
Route::get('ListarProgramasApi', 'App\Http\Controllers\ApisController@ListarProgramasApi');
Route::get('ListarCarrerasApi', 'App\Http\Controllers\ApisController@ListarCarrerasApi');
Route::get('ListarMensionesApi', 'App\Http\Controllers\ApisController@ListarMensionesApi');
Route::get('ListarInstrumentosApi', 'App\Http\Controllers\ApisController@ListarInstrumentosApi');
Route::get('ListarNiveles', 'App\Http\Controllers\ApisController@ListarNiveles');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

