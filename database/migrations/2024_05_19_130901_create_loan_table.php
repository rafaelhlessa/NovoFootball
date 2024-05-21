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
        Schema::create('loan', function (Blueprint $table) {
            $table->id();
//            create a columns percentage, loan_amount, loan_duration, value_loan, team_id
            $table->integer('percentage');
            $table->integer('loan_amount');
            $table->integer('loan_duration');
            $table->integer('value_loan');
            $table->foreignId('team_id')->references('id')->on('teams');
            $table->timestamps();



        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan');
    }
};
