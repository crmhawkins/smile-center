<?php

use Illuminate\Database\Migrations\Migration;
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
       // Insertar datos en la tabla
       DB::table('estados_pacientes')->insert([
        ['id' => 1, 'estado' => 'Lead', 'created_at' => now(), 'updated_at' => now()],
        ['id' => 2, 'estado' => 'Rechazado', 'created_at' => now(), 'updated_at' => now()],
        ['id' => 3, 'estado' => 'Cliente', 'created_at' => now(), 'updated_at' => now()],
    ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('estados_pacientes')->whereIn('id', [1, 2, 3, 4, 5])->delete();
    }
};
