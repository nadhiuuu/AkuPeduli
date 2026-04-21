<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campaigner_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();            
            
            // Data Kontak & OTP
            $table->string('no_wa')->nullable();
            $table->timestamp('wa_verified_at')->nullable();
            $table->string('email_campaigner')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            
            // Data Identitas Dokumen
            $table->string('nik')->unique()->nullable();
            $table->string('foto_ktp')->nullable();
            $table->string('foto_selfie_ktp')->nullable();
            
            // Status Verifikasi Admin (Untuk KTP & Bank)
            $table->enum('status_verifikasi', [
                'menunggu', 
                'disetujui', 
                'ditolak'
            ])->default('menunggu');
            $table->text('alasan_penolakan')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaigner_profiles');
    }
};