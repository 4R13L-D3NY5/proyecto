<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
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
            $pacientes = Paciente::orderBy('id', 'desc')->paginate(2);
        }
        else{
            $pacientes = Paciente::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(2);
        }
        

        return [
            'pagination' => [
                'total'        => $pacientes->total(),
                'current_page' => $pacientes->currentPage(),
                'per_page'     => $pacientes->perPage(),
                'last_page'    => $pacientes->lastPage(),
                'from'         => $pacientes->firstItem(),
                'to'           => $pacientes->lastItem(),
            ],
            'pacientes' => $pacientes
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
        $pacientes = Paciente::all();
        $ultimo = $pacientes->last();
        $paciente = new Paciente();
        $paciente->nombres = $request->nombres;
        $paciente->apellidos = $request->apellidos;
        $paciente->edad = Carbon::parse($request->fechaNacimiento)->age;
        $paciente->telefono = $request->telefono;
        $paciente->apoderado = $request->apoderado;
        $paciente->fechaNacimiento = $request->fechaNacimiento;
        $paciente->nro = $ultimo->nro + 1;
        $paciente->condicion = '1';
        $paciente->save();
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
        $paciente = Paciente::findOrFail($request->id);
        $paciente->nombres = $request->nombres;
        $paciente->apellidos = $request->apellidos;
        $paciente->edad = $request->edad;
        $paciente->telefono = $request->telefono;
        $paciente->apoderado = $request->apoderado;
        $paciente->fechaNacimiento = $request->fechaNacimiento;
        $paciente->condicion = '1';
        $paciente->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $paciente = Paciente::findOrFail($request->id);
        $paciente->condicion = '0';
        $paciente->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $paciente = Paciente::findOrFail($request->id);
        $paciente->condicion = '1';
        $paciente->save();
    }

    public function edad(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        $paciente = Paciente::findOrFail(1);
        $edad = Carbon::parse($paciente->fechaNacimiento)->age; 
        echo $edad;   
    }
}
