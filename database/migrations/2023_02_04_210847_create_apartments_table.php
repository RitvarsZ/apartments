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
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->string('link')->unique();
            $table->string('image_thumbnail')->nullable();
            $table->string('title');
            $table->dateTime('published_at');
            $table->string('city');
            $table->string('district');
            $table->string('street');
            $table->integer('rooms');
            $table->string('floor');
            $table->integer('m2');
            $table->float('price', 8, 2);
            $table->string('price_unit')->nullable();
            $table->float('price_per_m2', 8, 2);
            $table->string('series')->nullable();
            $table->float('latitude', 10, 7);
            $table->float('longitude', 10, 7);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apartments');
    }
};
