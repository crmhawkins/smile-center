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
        Schema::create('newsletters_manual', function (Blueprint $table) {
            $table->id();
            $table->text('pacientes_array_id')->nullable();
            $table->integer('category')->nullable();
            $table->dateTime('date_sent')->nullable();

            $table->text('first_title_newsletter')->nullable();
            $table->text('banner_path')->nullable();
            $table->text('banner_description')->nullable();
            $table->text('second_title_newsletter')->nullable();


            $table->text('images_promo')->nullable();
            $table->text('urls')->nullable();
            // $table->text('promo1_path')->nullable();
            // $table->text('promo2_path')->nullable();
            // $table->text('promo3_path')->nullable();
            // $table->text('promo4_path')->nullable();
            // $table->text('promo5_path')->nullable();
            // $table->text('promo6_path')->nullable();


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
        Schema::dropIfExists('newsletters_manual');
    }
};
