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
        Schema::create('servicios_presupuestos', function (Blueprint $table) {
            $table->id();
            $table->integer('presupuesto_id');
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->double('precio');
            $table->integer('iva')->nullable();
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
        Schema::dropIfExists('servicios_presupuestos');
    }
};
