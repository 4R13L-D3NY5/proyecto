<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\Estudiante;

class EstudianteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $estudiantes = Estudiante::orderBy('id', 'desc')->paginate(2);
        }
        else{
            $estudiantes = Estudiante::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(2);
        }
        

        return [
            'pagination' => [
                'total'        => $estudiantes->total(),
                'current_page' => $estudiantes->currentPage(),
                'per_page'     => $estudiantes->perPage(),
                'last_page'    => $estudiantes->lastPage(),
                'from'         => $estudiantes->firstItem(),
                'to'           => $estudiantes->lastItem(),
            ],
            'estudiantes' => $estudiantes
        ];
    }   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $estudiante = new Estudiante();
        $estudiante->codigoEstudiante = $request->codigoEstudiante;
        $estudiante->nombres = $request->nombres;
        $estudiante->apellidos = $request->apellidos;
        $estudiante->email = $request->email;
        $estudiante->condicion = '1';
        $estudiante->save();
    }
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $estudiante = Estudiante::findOrFail($request->id);
        $estudiante->codigoEstudiante = $request->codigoEstudiante;
        $estudiante->nombres = $request->nombres;
        $estudiante->apellidos = $request->apellidos;
        $estudiante->email = $request->email;
        $estudiante->condicion = '1';
        $estudiante->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $estudiante = Estudiante::findOrFail($request->id);
        $estudiante->condicion = '0';
        $estudiante->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $estudiante = Estudiante::findOrFail($request->id);
        $estudiante->condicion = '1';
        $estudiante->save();
    }

    
}
