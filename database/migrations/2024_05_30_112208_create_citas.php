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
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('presupuesto_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('paciente_id')->nullable();
            $table->date('fecha')->nullable();
            $table->time('hora')->nullable();
            $table->tinyInteger('asistencia')->nullable();
            $table->string('observacion')->nullable();
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
        Schema::dropIfExists('citas');
    }
};
