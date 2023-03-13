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
        Schema::create('request_spatials', function (Blueprint $table) {
            $table->id();
            $table->string('spatial_id')->default("New");
            $table->string('name')->default("No name yet");
            $table->string('description')->default("No described yet");
            $table->string('latlong')->default("No set yet");
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
        Schema::dropIfExists('request_spatials');
    }
};
