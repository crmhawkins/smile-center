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
        DB::table('estado_presupuestos')->whereIn('id', [1, 2, 3, 4, 5])->delete();
        DB::table('estado_presupuestos')->insert([
            ['id' => 1, 'estado' => 'VALORACIÓN DOCTORES', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'estado' => 'ELABORACIÓN PRESUPUESTO', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'estado' => 'PRESUPUESTO ENTREGADO', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'estado' => 'PRESUPUESTO OK', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'estado' => 'FINANCIACIÓN EN ESTUDIO', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'estado' => 'PRESUPUESTO RECHAZADO', 'created_at' => now(), 'updated_at' => now()],
            ]);
    }


    public function down()
    {
        DB::table('estado_presupuestos')->whereIn('id', [1, 2, 3, 4, 5, 6])->delete();
                DB::table('estado_presupuestos')->insert([
                   ['id' => 1, 'estado' => 'Pendiente', 'created_at' => now(), 'updated_at' => now()],
                   ['id' => 2, 'estado' => 'Aceptado', 'created_at' => now(), 'updated_at' => now()],
                   ['id' => 3, 'estado' => 'Cancelado', 'created_at' => now(), 'updated_at' => now()],
                   ['id' => 4, 'estado' => 'Completado', 'created_at' => now(), 'updated_at' => now()],
                   ['id' => 5, 'estado' => 'Facturado', 'created_at' => now(), 'updated_at' => now()],
               ]);
    }
};
