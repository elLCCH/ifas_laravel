<?php

namespace App\Http\Controllers;

use App\Models\Estudiantes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\Else_;

class EstudiantesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data = DB::select('select id, Ap_Paterno,Ap_Materno , Nombre,Foto , CI, Estado, Categoria from estudiantes order by id desc');
        // return $data;

        $estudiante = Estudiantes::orderBy('id', 'DESC')->get();
        return $estudiante;
        
    }
    public function indexSelection($id)
    {
        $est = Estudiantes::where('id','=', $id)->first();
        return $est;
    }
    public function EstudianteCuadro($id)
    {
        $EstCuadro = DB::table('Estudiantes')
        ->join('Calificaciones', 'Estudiantes.id', '=', 'Calificaciones.estudiante_id')
        ->join('Cursos', 'Calificaciones.curso_id', '=', 'Cursos.id')
        ->where('Calificaciones.id','=',$id)
        ->get();

       
        return $EstCuadro->NivelCurso;
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
    public function ObtenerNombreCompleto($id)
    {
        $estudiante = Estudiantes::where('id','=', $id)->first();
        $NombreCompleto = $estudiante->Ap_Paterno. ' ' .$estudiante->Ap_Materno. ' ' .$estudiante->Nombre;
        return $NombreCompleto;
    }
    public function OrdenarLista(Request $request)
    {
        return $request->Datos;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $requestData = $request->all();
        // if ($request->hasFile('Foto')) {
        //     $requestData['Foto'] = $request->file('Foto')
        //     ->store('uploads', 'public');
        // }

        // Estudiantes::insert($requestData);


        if($request->hasFile('Foto')){
            $file = $request->file('Foto');
            $namefile = time().$file->getClientOriginalName();
            $file->move(public_path().'/estudiantes/',$namefile);
        }
        if($request->hasFile('Certificado')){
            $fileCertificado = $request->file('Certificado');
            $namefileCertificado = time().$fileCertificado->getClientOriginalName();
            $fileCertificado->move(public_path().'/CertificadosNacDocumentos/',$namefileCertificado);
        }
        if($request->hasFile('DocColUni')){
            $fileDocColUni = $request->file('DocColUni');
            $namefileDocColUni = time().$fileDocColUni->getClientOriginalName();
            $fileDocColUni->move(public_path().'/DocColUniDocumentos/',$namefileDocColUni);
        }
        if($request->hasFile('CIDoc')){
            $fileCIDoc = $request->file('CIDoc');
            $namefileCIDoc = time().$fileCIDoc->getClientOriginalName();
            $fileCIDoc->move(public_path().'/CIDocumentos/',$namefileCIDoc);
        }
        if($request->hasFile('Boleta')){
            $fileBoleta = $request->file('Boleta');
            $namefileBoleta = time().$fileBoleta->getClientOriginalName();
            $fileBoleta->move(public_path().'/BoletaDocumentos/',$namefileBoleta);
        }
        
        $estudiante = new Estudiantes();
        if($request->hasFile('Foto')){$estudiante->Foto = 'estudiantes/'.$namefile;} else{$estudiante->Foto = '';}
        $estudiante->Ap_Paterno= $request->input('Ap_Paterno');
        $estudiante->Ap_Materno= $request->input('Ap_Materno');
        $estudiante->Nombre= $request->input('Nombre');
        $estudiante->Sexo= $request->input('Sexo');
        $estudiante->FechNac= $request->input('FechNac');
        $estudiante->Edad= $request->input('Edad');
        $estudiante->CI= $request->input('CI');
        $estudiante->Nombre_Padre= $request->input('Nombre_Padre');
        $estudiante->OcupacionP= $request->input('OcupacionP');
        $estudiante->NumCelP= $request->input('NumCelP');
        $estudiante->Nombre_Madre= $request->input('Nombre_Madre');
        $estudiante->OcupacionM= $request->input('OcupacionM');
        $estudiante->NumCelM= $request->input('NumCelM');
        $estudiante->Direccion= $request->input('Direccion');
        $estudiante->Telefono= $request->input('Telefono');
        $estudiante->Celular= $request->input('Celular');
        $estudiante->NColegio= $request->input('NColegio');
        $estudiante->TipoColegio= $request->input('TipoColegio');
        $estudiante->CGrado= $request->input('CGrado');
        $estudiante->CNivel= $request->input('CNivel');
        $estudiante->Especialidad= $request->input('Especialidad');
        $estudiante->Correo= $request->input('Correo');
        
        $estudiante->Password= Hash::make($request->input('Password')) ;
        $estudiante->Matricula= $request->input('Matricula');
        $estudiante->Observacion= $request->input('Observacion');
        $estudiante->Estado= $request->input('Estado');
        $estudiante->Carrera= $request->input('Carrera');
        $estudiante->Categoria= $request->input('Categoria');
        $estudiante->Turno= $request->input('Turno');
        $estudiante->Correo_Institucional= $request->input('Correo_Institucional');
        $estudiante->Curso_Solicitado= $request->input('Curso_Solicitado');
        $estudiante->Mension= $request->input('Mension'); //new
        $estudiante->Area= $request->input('Area'); //new
        $estudiante->Admin_id= $request->input('Admin_id');
        $estudiante->created_at= '2022-02-18'; //ESTO ES LO QUE HACE PARA QUE SEA LA FECHA LIMITE
        
        if($request->hasFile('Certificado')){$estudiante->Certificado = 'CertificadosNacDocumentos/'.$namefileCertificado;} else{$estudiante->Certificado = '';}
        if($request->hasFile('DocColUni')){$estudiante->DocColUni = 'DocColUniDocumentos/'.$namefileDocColUni;} else{$estudiante->DocColUni = '';}
        if($request->hasFile('CIDoc')){$estudiante->CIDoc = 'CIDocumentos/'.$namefileCIDoc;} else{$estudiante->CIDoc = '';}
        if($request->hasFile('Boleta')){$estudiante->Boleta = 'BoletaDocumentos/'.$namefileBoleta;} else{$estudiante->Boleta = '';}
        $estudiante->save();
        // return 'Estudiante Guardado';
        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Estudiantes  $estudiantes
     * @return \Illuminate\Http\Response
     */
    public function show(Estudiantes $estudiantes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Estudiantes  $estudiantes
     * @return \Illuminate\Http\Response
     */
    public function edit(Estudiantes $estudiantes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Estudiantes  $estudiantes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        //PARA SABER LAS UBICACIONES COPIE EL CODIGO DEL STORE
        // if($request->hasFile('Foto')){$estudiante->Foto = 'estudiantes/'.$namefile;} else{$estudiante->Foto = '';}
        // if($request->hasFile('Certificado')){$estudiante->Certificado = 'CertificadosNacDocumentos/'.$namefileCertificado;} else{$estudiante->Certificado = '';}
        // if($request->hasFile('DocColUni')){$estudiante->DocColUni = 'DocColUniDocumentos/'.$namefileDocColUni;} else{$estudiante->DocColUni = '';}
        // if($request->hasFile('CIDoc')){$estudiante->CIDoc = 'CIDocumentos/'.$namefileCIDoc;} else{$estudiante->CIDoc = '';}


        $requestData = $request->all();
        if ($request->hasFile('Foto')) 
        {
            // ELIMINANDO ANTIGUA FOTO
            $estudiante =Estudiantes::findOrFail($id);
            File::delete(public_path().'/'.$estudiante->Foto);
            //REALIZANDO CARGA DE LA NUEVA FOTO
            $file = $request->file('Foto');
            $namefile = time().$file->getClientOriginalName();
            $file->move(public_path().'/estudiantes/',$namefile);
            $requestData['Foto'] = 'estudiantes/'.$namefile;
            // return 'paso';
        }
        if ($request->hasFile('Certificado')) 
        {
            // ELIMINANDO ANTIGUA Certificado
            $estudiante =Estudiantes::findOrFail($id);
            File::delete(public_path().'/'.$estudiante->Certificado);
            //REALIZANDO CARGA DE LA NUEVA Certificado
            $file = $request->file('Certificado');
            $namefile = time().$file->getClientOriginalName();
            $file->move(public_path().'/CertificadosNacDocumentos/',$namefile);
            $requestData['Certificado'] = 'CertificadosNacDocumentos/'.$namefile;
            // return 'paso';
        }
        if ($request->hasFile('DocColUni')) 
        {
            // ELIMINANDO ANTIGUA DocColUni
            $estudiante =Estudiantes::findOrFail($id);
            File::delete(public_path().'/'.$estudiante->DocColUni);
            //REALIZANDO CARGA DE LA NUEVA DocColUni
            $file = $request->file('DocColUni');
            $namefile = time().$file->getClientOriginalName();
            $file->move(public_path().'/DocColUniDocumentos/',$namefile);
            $requestData['DocColUni'] = 'DocColUniDocumentos/'.$namefile;
            // return 'paso';
        }
        if ($request->hasFile('CIDoc')) 
        {
            // ELIMINANDO ANTIGUA CIDoc
            $estudiante =Estudiantes::findOrFail($id);
            File::delete(public_path().'/'.$estudiante->CIDoc);
            //REALIZANDO CARGA DE LA NUEVA CIDoc
            $file = $request->file('CIDoc');
            $namefile = time().$file->getClientOriginalName();
            $file->move(public_path().'/CIDocumentos/',$namefile);
            $requestData['CIDoc'] = 'CIDocumentos/'.$namefile;
            // return 'paso';
        }
        
        if ($request->hasFile('Boleta')) 
        {
            // ELIMINANDO ANTIGUA Boleta
            $estudiante =Estudiantes::findOrFail($id);
            File::delete(public_path().'/'.$estudiante->Boleta);
            //REALIZANDO CARGA DE LA NUEVA Boleta
            $file = $request->file('Boleta');
            $namefile = time().$file->getClientOriginalName();
            $file->move(public_path().'/BoletaDocumentos/',$namefile);
            $requestData['Boleta'] = 'BoletaDocumentos/'.$namefile;
            // return 'paso';
        }
        Estudiantes::where('id','=',$id)->update($requestData);

        return 'Datos Estudiante Modificados';
        // return $requestData;
    }
    public function AbrirPDF(Request $request)
    {
        return $request->UrlPDF;
    }
    public function actualizar(Request $request, $id)
    {
        
        $requestData = $request->all();
        $estudiante =Estudiantes::findOrFail($id);
        if ($request->hasFile('Foto')) 
        {
            // ELIMINANDO ANTIGUA FOTO
            
            File::delete(public_path().'/'.$estudiante->Foto);
            //REALIZANDO CARGA DE LA NUEVA FOTO
            $file = $request->file('Foto');
            $namefile = time().$file->getClientOriginalName();
            $file->move(public_path().'/estudiantes/',$namefile);
            
            // return 'paso';
        }
        // $requestData['Foto'] = 'estudiantes/'.$namefile;
        
        if ($request->hasFile('Foto')) 
        {//SI TIENE FOTO ENTONCES EN Foto poner sus cosas
            $requestData['Foto'] = 'estudiantes/'.$namefile;
        }
        else
        {//SINO TIENE FOTO Y AUN ASI QUIERE ACTUALIZAR
            $requestData['Foto'] = $estudiante->Foto;
        }

        if ($request->hasFile('Certificado')) 
        {
            // ELIMINANDO ANTIGUA Certificado
            $estudiante =Estudiantes::findOrFail($id);
            File::delete(public_path().'/'.$estudiante->Certificado);
            //REALIZANDO CARGA DE LA NUEVA Certificado
            $file = $request->file('Certificado');
            $namefile = time().$file->getClientOriginalName();
            $file->move(public_path().'/CertificadosNacDocumentos/',$namefile);
            $requestData['Certificado'] = 'CertificadosNacDocumentos/'.$namefile;
            // return 'paso';
        }
        if ($request->hasFile('Certificado')) 
        {//SI TIENE Certificado ENTONCES EN Certificado poner sus cosas
            $requestData['Certificado'] = 'CertificadosNacDocumentos/'.$namefile;
        }
        else
        {//SINO TIENE Certificado Y AUN ASI QUIERE ACTUALIZAR
            $requestData['Certificado'] = $estudiante->Certificado;
        }


        if ($request->hasFile('DocColUni')) 
        {
            // ELIMINANDO ANTIGUA DocColUni
            $estudiante =Estudiantes::findOrFail($id);
            File::delete(public_path().'/'.$estudiante->DocColUni);
            //REALIZANDO CARGA DE LA NUEVA DocColUni
            $file = $request->file('DocColUni');
            $namefile = time().$file->getClientOriginalName();
            $file->move(public_path().'/DocColUniDocumentos/',$namefile);
            $requestData['DocColUni'] = 'DocColUniDocumentos/'.$namefile;
            // return 'paso';
        }
        if ($request->hasFile('DocColUni')) 
        {//SI TIENE DocColUniDocumentos ENTONCES EN DocColUniDocumentos poner sus cosas
            $requestData['DocColUni'] = 'DocColUniDocumentos/'.$namefile;
        }
        else
        {//SINO TIENE DocColUniDocumentos Y AUN ASI QUIERE ACTUALIZAR
            $requestData['DocColUni'] = $estudiante->DocColUni;
        }



        if ($request->hasFile('CIDoc')) 
        {
            // ELIMINANDO ANTIGUA CIDoc
            $estudiante =Estudiantes::findOrFail($id);
            File::delete(public_path().'/'.$estudiante->CIDoc);
            //REALIZANDO CARGA DE LA NUEVA CIDoc
            $file = $request->file('CIDoc');
            $namefile = time().$file->getClientOriginalName();
            $file->move(public_path().'/CIDocumentos/',$namefile);
            $requestData['CIDoc'] = 'CIDocumentos/'.$namefile;
            // return 'paso';
        }
        if ($request->hasFile('CIDoc')) 
        {//SI TIENE FOTO ENTONCES EN Foto poner sus cosas
            $requestData['CIDoc'] = 'CIDocumentos/'.$namefile;
        }
        else
        {//SINO TIENE FOTO Y AUN ASI QUIERE ACTUALIZAR
            $requestData['CIDoc'] = $estudiante->CIDoc;
        }

        if ($request->hasFile('Boleta')) 
        {
            // ELIMINANDO ANTIGUA Boleta
            $estudiante =Estudiantes::findOrFail($id);
            File::delete(public_path().'/'.$estudiante->Boleta);
            //REALIZANDO CARGA DE LA NUEVA Boleta
            $file = $request->file('Boleta');
            $namefile = time().$file->getClientOriginalName();
            $file->move(public_path().'/BoletaDocumentos/',$namefile);
            $requestData['Boleta'] = 'BoletaDocumentos/'.$namefile;
            // return 'paso';
        }
        if ($request->hasFile('Boleta')) 
        {//SI TIENE FOTO ENTONCES EN Foto poner sus cosas
            $requestData['Boleta'] = 'BoletaDocumentos/'.$namefile;
        }
        else
        {//SINO TIENE FOTO Y AUN ASI QUIERE ACTUALIZAR
            $requestData['Boleta'] = $estudiante->Boleta;
        }
        //SI NO ES TIPO HASH CREAR NUEVO HASH
        if (Hash::needsRehash($request->Password))
        {
            $requestData['Password'] = Hash::make($request->Password);
        }
        if ($request->Admin_id == 'null') {
            $requestData['Admin_id']=null;
        }
        Estudiantes::where('id','=',$id)->update($requestData);
        return 'Datos Estudiante Modificados';
        // return $request;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Estudiantes  $estudiantes
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        // ELIMINANDO ANTIGUA FOTO
        $estudiante =Estudiantes::findOrFail($id);
        if(File::delete(public_path().'/'.$estudiante->Foto) and File::delete(public_path().'/'.$estudiante->Certificado) and File::delete(public_path().'/'.$estudiante->DocColUni) and File::delete(public_path().'/'.$estudiante->CIDoc) and File::delete(public_path().'/'.$estudiante->Boleta ))
        {
            Estudiantes::destroy($id);    
            return 'eliminado';
        }
        else {
            Estudiantes::destroy($id);   
            return 'no fue eliminado';
        }
        return 'gg';






        // $file = $estudiante->file('Foto');
        // $namefile = time().$file->getClientOriginalName();
        // if ($estudiante->hasFile('Foto'))
        // {
        //     $file->delete(public_path().'/estudiantes/',$namefile);
        // } 
            
        
        // Estudiantes::destroy($id);
        // return 'Estudiante Eliminado';
        
    }
    public function autentificar(Request $request)
    {
       

        //FINISH
        $CI = $request->input('CI');
        $pass = $request->input('Password');
        $est = Estudiantes::where('CI','=', $CI)->first();
        

        if (Hash::check($pass, $est->Password)) {
            
            return $est;
        }
        else
        {
            // return $admin;
            return 'NOLOG';
            
        }
    }
    public function EliminarInactivos(Request $request)
    {
       

        
        //SELECCIONANDO LA LISTA DE TODOS LOS INACTIVOS
        $estudiante = Estudiantes::where('Estado','=','INACTIVO')->where('Categoria', '!=', 'POSTULANTE')->get();
        // RECORRIENDO TODOS LOS DATOS SELECCIONADOS
        foreach ($estudiante as $a)
        {
            // return $a->id;
            // ELIMINANDO ANTIGUA FOTO
            if(File::delete(public_path().'/'.$a->Foto) and File::delete(public_path().'/'.$a->Certificado) and File::delete(public_path().'/'.$a->DocColUni) and File::delete(public_path().'/'.$a->CIDoc) and File::delete(public_path().'/'.$a->Boleta ))
            {
                Estudiantes::destroy($a->id);    
            }
            else
            {
                Estudiantes::destroy($a->id);    
            }
            
        }

        return 'SE ELIMINARON A TODOS LOS INACTIVOS';

    

    }
}
