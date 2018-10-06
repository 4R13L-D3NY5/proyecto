<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    //
    protected $fillable = ['nombres','apellidos','edad','telefono','apoderado','fechaNacimiento'];
}
