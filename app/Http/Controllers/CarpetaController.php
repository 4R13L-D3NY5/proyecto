<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\Paciente;

class PacienteController extends Controller
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
            $carpetas = Paciente::orderBy('id', 'desc')->paginate(2);
        }
        else{
            $carpetas = Paciente::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(2);
        }
        

        return [
            'pagination' => [
                'total'        => $carpetas->total(),
                'current_page' => $carpetas->currentPage(),
                'per_page'     => $carpetas->perPage(),
                'last_page'    => $carpetas->lastPage(),
                'from'         => $carpetas->firstItem(),
                'to'           => $carpetas->lastItem(),
            ],
            'carpetas' => $carpetas
        ];
    }   

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     if (!$request->ajax()) return redirect('/');
    //     $estudiante = new Paciente();
    //     $estudiante->codigoPaciente = $request->codigoPaciente;
    //     $estudiante->nombres = $request->nombres;
    //     $estudiante->apellidos = $request->apellidos;
    //     $estudiante->email = $request->email;
    //     $estudiante->condicion = '1';
    //     $estudiante->save();
    // }
  

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request)
    // {
    //     if (!$request->ajax()) return redirect('/');
    //     $estudiante = Paciente::findOrFail($request->id);
    //     $estudiante->codigoPaciente = $request->codigoPaciente;
    //     $estudiante->nombres = $request->nombres;
    //     $estudiante->apellidos = $request->apellidos;
    //     $estudiante->email = $request->email;
    //     $estudiante->condicion = '1';
    //     $estudiante->save();
    // }

    // public function desactivar(Request $request)
    // {
    //     if (!$request->ajax()) return redirect('/');
    //     $estudiante = Paciente::findOrFail($request->id);
    //     $estudiante->condicion = '0';
    //     $estudiante->save();
    // }

    // public function activar(Request $request)
    // {
    //     if (!$request->ajax()) return redirect('/');
    //     $estudiante = Paciente::findOrFail($request->id);
    //     $estudiante->condicion = '1';
    //     $estudiante->save();
    // }

    // public function seleccionarcarpetas(Request $request)
    // {
    //     if (!$request->ajax()) return redirect('/');
    //     $carpetas = Paciente::where('condicion','=','1')->get();
    //     return ['carpetas' => $carpetas];
    // }
    
}
