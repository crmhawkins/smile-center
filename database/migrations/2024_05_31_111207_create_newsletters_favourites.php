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
        Schema::create('newsletters_favourites', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('user_id')->nullable()->unsigned();
            $table->bigInteger('newsletter_id')->nullable()->unsigned();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('newsletter_id')->references('id')->on('newsletters');

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
        Schema::dropIfExists('newsletters_favourites');
    }
};
