<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dilemmas', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->integer('rank')->default(0);
            $table->string('title')->index();
        });

        $decisions = DB::table('decisions')
            ->select(['id', 'first_dilemma', 'second_dilemma'])
            ->get();

        $uniqueDilemmas = $decisions->pluck('first_dilemma')
            ->merge($decisions->pluck('second_dilemma'))
            ->unique()
            ->values();

        foreach ($uniqueDilemmas as $dilemma) {
            $id = DB::table('dilemmas')->insertGetId([
                'uuid' => Str::uuid(),
                'title' => $dilemma,
            ]);
            DB::table('decisions')
                ->where('first_dilemma', $dilemma)
                ->update([
                    'first_dilemma_id' => $id,
                ]);
            DB::table('decisions')
                ->where('second_dilemma', $dilemma)
                ->update([
                    'second_dilemma_id' => $id,
                ]);
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dilemmas');
    }
};
