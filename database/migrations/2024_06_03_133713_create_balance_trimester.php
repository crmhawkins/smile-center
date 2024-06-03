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
        Schema::create('balance_trimester', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->text('trimester')->nullable();
            $table->text('month')->nullable();
            $table->text('year')->nullable();
            $table->float('quantity',10,2)->nullable();

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
        Schema::dropIfExists('balance_trimester');
    }
};
