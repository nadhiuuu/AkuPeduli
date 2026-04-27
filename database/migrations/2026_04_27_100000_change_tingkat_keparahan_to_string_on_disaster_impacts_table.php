<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('disaster_impacts', function (Blueprint $table) {
            $table->string('tingkat_keparahan')->default('pending_ai')->change();
        });

        DB::table('disaster_impacts')
            ->whereNull('tingkat_keparahan')
            ->update(['tingkat_keparahan' => 'pending_ai']);
    }

    public function down(): void
    {
        DB::table('disaster_impacts')
            ->where('tingkat_keparahan', 'pending_ai')
            ->update(['tingkat_keparahan' => '1 - sangat ringan']);

        Schema::table('disaster_impacts', function (Blueprint $table) {
            $table->enum('tingkat_keparahan', [
                '1 - sangat ringan',
                '2 - ringan',
                '3 - sedang',
                '4 - parah',
                '5 - sangat parah',
            ])->change();
        });
    }
};
