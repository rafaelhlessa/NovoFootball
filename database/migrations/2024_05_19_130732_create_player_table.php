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
        Schema::create('player', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position');
            $table->integer('strength');
            $table->integer('goals');
            $table->integer('red_cards')->nullable();
            $table->integer('price');
            $table->integer('salary');
            $table->boolean('star');
            $table->foreignId('team_id')->references('id')->on('teams');
            $table->timestamps();


//            $table->foreignId('team_id')->references('id')->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player');
    }
};
