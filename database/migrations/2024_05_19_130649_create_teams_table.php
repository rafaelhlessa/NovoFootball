<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('capacity');
            $table->foreignId('championship_id');
            $table->boolean('loan')->nullable();
            $table->foreignId('manager_id')->nullable();
            $table->integer('morale')->default(10);
            $table->integer('money')->default(1000000);
            $table->timestamps();


            $table->foreign('championship_id')->references('id')->on('championship');
            $table->foreign('manager_id')->references('id')->on('manager');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
