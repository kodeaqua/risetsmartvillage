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
        Schema::create('spatials', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('No name yet');
            $table->string('description')->default('No described yet');
            $table->foreignId('category_id')->default(1)->nullable();
            $table->foreignId('area_id')->default(1)->nullable();
            $table->string('address')->default('No set yet');
            $table->decimal('latitude', $precision = 8, $scale = 5)->nullable();
            $table->decimal('longitude', $precision = 8, $scale = 5)->nullable();
            $table->boolean('is_deleted')->default(false);
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
        Schema::dropIfExists('spatials');
    }
};
