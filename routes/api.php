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
/*CURSO*/
Route::resource('curso', 'App\Http\Controllers\CursoController');
Route::get('cursoUnique', 'App\Http\Controllers\CursoController@CargarCursosUnique');
Route::post('ListaEstudiantes', 'App\Http\Controllers\CursoController@ListaEstudiantes');
Route::get('BuscarNivelCurso/{idCurso}', 'App\Http\Controllers\CursoController@BuscarNivelCurso');
Route::get('CursosPorNivel/{Nivel}', 'App\Http\Controllers\CursoController@CargarCursosPorNivel');
Route::get('ListaAgrupacionMateriasXCursos/{idAdmin}', 'App\Http\Controllers\CursoController@ListaAgrupacionMateriasXCursos');
Route::get('CargarSiglaUnique', 'App\Http\Controllers\CursoController@CargarSiglaUnique');
Route::post('ModificarBimestres', 'App\Http\Controllers\CursoController@ModificarBimestres');
Route::get('CursosUniqueSigla', 'App\Http\Controllers\CursoController@CursosUniqueSigla');
/*CALIFICACIONES*/
Route::resource('calificacion', 'App\Http\Controllers\CalificacionesController');
Route::post('EncontrarNivelCurso/{idEst}', 'App\Http\Controllers\CalificacionesController@EncontrarNivelCurso');
Route::delete('EliminarEstudianteDelCurso/{idEst}', 'App\Http\Controllers\CalificacionesController@EliminarEstudianteDelCurso');
Route::get('ListarXCursoCalif/{idCurso}', 'App\Http\Controllers\CalificacionesController@ListarXCursoCalif');
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

/*PRERREQUISITOS*/
Route::resource('Prerrequisito', 'App\Http\Controllers\PrerrequisitosController');

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
Route::get('ListarCursosApi', 'App\Http\Controllers\ApisController@ListarCursosApi');
Route::get('ListarInstrumentosApi', 'App\Http\Controllers\ApisController@ListarInstrumentosApi');
Route::get('ListarInstrumentosModernosApi', 'App\Http\Controllers\ApisController@ListarInstrumentosModernosApi');
Route::get('ListarMensionesModernasApi', 'App\Http\Controllers\ApisController@ListarMensionesModernasApi');
Route::get('ListarMensionesApi', 'App\Http\Controllers\ApisController@ListarMensionesApi');
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


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

