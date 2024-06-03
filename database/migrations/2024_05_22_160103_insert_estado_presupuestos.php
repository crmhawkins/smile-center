<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('estado_presupuestos', function (Blueprint $table) {
            //
        });

         // Insertar datos en la tabla
         DB::table('estado_presupuestos')->insert([
            ['id' => 1, 'estado' => 'Pendiente', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'estado' => 'Aceptado', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'estado' => 'Cancelado', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'estado' => 'Completado', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'estado' => 'Facturado', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('estado_presupuestos', function (Blueprint $table) {
            //
        });
        DB::table('estado_presupuestos')->whereIn('id', [1, 2, 3, 4, 5])->delete();

    }
};
