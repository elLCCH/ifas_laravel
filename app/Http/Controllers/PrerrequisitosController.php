<?php

namespace App\Http\Controllers;

use App\Models\Prerrequisitos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrerrequisitosController extends Controller
{/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

        $Prerrequisitos =  DB::select("select p.id,p.id_materia_p,p.id_materia_s,
        m.NombreCurso as 'mat_prin',m.Sigla as 'cod_prin',
        m2.NombreCurso as 'materia_sec',m2.Sigla as 'cod_sec'
        from prerrequisitos p LEFT JOIN
        cursos m ON m.id=p.id_materia_p LEFT JOIN
        cursos m2 ON m2.id=p.id_materia_s");
        return $Prerrequisitos;

    }

        public function store(Request $request)
        {
            $data = $request->all();
            Prerrequisitos::insert($data);
            return response()->json(["mensaje" => "Prerrequisitos Registrado Correctamente"], 200);
        }

        public function show($id)
        {
            $data = Prerrequisitos::where('id','=',$id)->firstOrFail();
            return response()->json($data, 200);
        }

        public function update(Request $request, $id)
        {
            $data = $request->all();
            Prerrequisitos::where('id','=',$id)->update($data);
            return response()->json(["mensaje" => "Prerrequisitos Modificado Correctamente"], 200);
        }
        public function destroy($id)

        {
            $data =  DB::select("delete from Prerrequisitos where id='$id'");
            return response()->json(["mensaje" => "Prerrequisitos Eliminado Correctamente"], 200);
        }



}
