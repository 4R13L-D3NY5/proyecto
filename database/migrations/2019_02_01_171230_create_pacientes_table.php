<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePacientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombres',50);
            $table->string('apellidos',50);
            $table->integer('edad');
            $table->string('telefono',50)->nullable();
            $table->string('apoderado',100)->nullable();
            $table->date('fechaNacimiento')->nullable();
            $table->integer('nro');
            $table->boolean('estado')->default('1');
            $table->boolean('condicion')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pacientes');
    }
}
