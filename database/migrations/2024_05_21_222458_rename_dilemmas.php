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
        Schema::table('dilemmas', function (Blueprint $table) {
            $table->unsignedBigInteger('first_dilemma_id')->nullable()->after('first_dilemma');
            $table->unsignedBigInteger('second_dilemma_id')->nullable()->after('second_dilemma');
        });
        Schema::rename('dilemmas', 'decisions');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('decisions', 'dilemmas');
        Schema::table('dilemmas', function (Blueprint $table) {
            $table->dropColumn('first_dilemma_id');
            $table->dropColumn('second_dilemma_id');
        });
    }
};
