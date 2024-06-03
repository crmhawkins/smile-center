<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->string('apellido')->nullable();
            $table->string('email')->nullable();
            $table->string('telefono')->nullable();
            $table->string('codigoPostal')->nullable();
            $table->string('direccion')->nullable();
            $table->string('poblacion')->nullable();
            $table->string('provincia')->nullable();
            $table->integer('estado_id')->nullable();
            $table->bigInteger('referido_id')->nullable();
            $table->bigInteger('empresa_id')->nullable();
            $table->bigInteger('aseguradora_id')->nullable();
            $table->string('origen')->nullable();
            $table->tinyInteger('newsletter')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
};
