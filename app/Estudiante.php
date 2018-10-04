<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    //protected $table = 'estudiantes';
    //protected $primaryKey = 'id';
    protected $fillable = ['codigoEstudiante','nombres','apellidos','email','condicion'];
}
