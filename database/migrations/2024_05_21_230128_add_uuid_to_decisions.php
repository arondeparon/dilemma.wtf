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
        //        Schema::table('decisions', function (Blueprint $table) {
        //            $table->uuid()->after('id')->unique()->nullable();
        //        });

        // Generate UUIDs for existing records
        DB::table('decisions')->get()->each(function ($decision) {
            DB::table('decisions')->where('id', $decision->id)->update(['uuid' => Str::uuid()]);
        });

        Schema::table('decisions', function (Blueprint $table) {
            $table->uuid()->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('decisions', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
