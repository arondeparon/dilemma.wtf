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
        Schema::create('dilemmas', function (Blueprint $table) {
            $table->id();
            $table->string('first_dilemma');
            $table->string('second_dilemma');
            $table->string('hash')->index();
            $table->integer('first_dilemma_votes')->default(0);
            $table->integer('second_dilemma_votes')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dilemmas');
    }
};
