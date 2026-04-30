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
            $table->unsignedInteger('jumlah_terdampak')->default(0)->after('jumlah_korban');
            $table->unsignedInteger('rumah_rusak')->default(0)->after('jumlah_terdampak');
            $table->boolean('fasilitas_vital_lumpuh')->default(false)->after('rumah_rusak');
        });

        DB::table('disaster_impacts')->update([
            'jumlah_terdampak' => DB::raw('COALESCE(jumlah_pengungsi, 0)'),
        ]);

        DB::table('disaster_impacts')
            ->orderBy('id')
            ->get()
            ->each(function ($impact): void {
                $jumlahKorban = max(0, (int) $impact->jumlah_korban);
                $jumlahTerdampak = max(0, (int) $impact->jumlah_terdampak);
                $rumahRusak = max(0, (int) $impact->rumah_rusak);

                $eligible = $jumlahKorban >= 1 || $jumlahTerdampak >= 50 || $rumahRusak >= 5;

                $status = 'insiden_lokal';

                if ($eligible) {
                    $status = 'siaga';
                }

                if (
                    $jumlahKorban > 10 ||
                    $jumlahTerdampak > 500 ||
                    $rumahRusak > 50 ||
                    (bool) $impact->fasilitas_vital_lumpuh
                ) {
                    $status = 'kritis';
                } elseif (
                    ($jumlahKorban >= 1 && $jumlahKorban <= 10) ||
                    ($jumlahTerdampak >= 50 && $jumlahTerdampak <= 500) ||
                    ($rumahRusak >= 5 && $rumahRusak <= 50)
                ) {
                    $status = 'menengah';
                }

                DB::table('disaster_impacts')
                    ->where('id', $impact->id)
                    ->update(['tingkat_keparahan' => $status]);
            });

        Schema::table('disaster_impacts', function (Blueprint $table) {
            $table->dropColumn(['jumlah_pengungsi', 'luas_wilayah_ha']);
        });

        Schema::table('disaster_impacts', function (Blueprint $table) {
            $table->string('tingkat_keparahan')->default('insiden_lokal')->change();
        });
    }

    public function down(): void
    {
        Schema::table('disaster_impacts', function (Blueprint $table) {
            $table->unsignedInteger('jumlah_pengungsi')->default(0)->after('jumlah_korban');
            $table->decimal('luas_wilayah_ha', 10, 2)->default(0)->after('jumlah_pengungsi');
        });

        DB::table('disaster_impacts')->update([
            'jumlah_pengungsi' => DB::raw('COALESCE(jumlah_terdampak, 0)'),
        ]);

        Schema::table('disaster_impacts', function (Blueprint $table) {
            $table->dropColumn(['jumlah_terdampak', 'rumah_rusak', 'fasilitas_vital_lumpuh']);
        });

        DB::table('disaster_impacts')
            ->whereIn('tingkat_keparahan', ['insiden_lokal', 'siaga', 'menengah', 'kritis'])
            ->update(['tingkat_keparahan' => '1 - sangat ringan']);

        Schema::table('disaster_impacts', function (Blueprint $table) {
            $table->string('tingkat_keparahan')->default('1 - sangat ringan')->change();
        });
    }
};
