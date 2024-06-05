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
        Schema::create('newsletters', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('paciente_id')->nullable()->unsigned();
            $table->bigInteger('newsletter_id')->nullable()->unsigned();
            $table->text('campaign')->nullable();
            $table->text('email')->nullable();
            $table->boolean('sent')->default(0);
            $table->boolean('open')->default(0);

            $table->foreign('paciente_id')->references('id')->on('pacientes');

            $table->dateTime('date_sent')->nullable();
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
        Schema::dropIfExists('newsletters');
    }
};
