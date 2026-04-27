<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('disaster_impacts', function (Blueprint $table) {
            $table->decimal('luas_wilayah_ha', 10, 2)->default(0)->after('jumlah_pengungsi');
            $table->bigInteger('kerugian_materil')->default(0)->after('luas_wilayah_ha');
            $table->string('bukti_surat_bpbd')->nullable()->after('kerugian_materil');
        });
    }

    public function down(): void
    {
        Schema::table('disaster_impacts', function (Blueprint $table) {
            $table->dropColumn(['luas_wilayah_ha', 'kerugian_materil', 'bukti_surat_bpbd']);
        });
    }
};