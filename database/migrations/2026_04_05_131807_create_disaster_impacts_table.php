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
        Schema::create('disaster_impacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('kecamatan');
            $table->string('desa');
            $table->integer('jumlah_korban')->default(0);
            $table->integer('jumlah_pengungsi')->default(0);
            $table->enum('tingkat_keparahan', [
                '1 - sangat ringan', 
                '2 - ringan', 
                '3 - sedang', 
                '4 - parah', 
                '5 - sangat parah'
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disaster_impacts');
    }
};
