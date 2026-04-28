<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->string('status_v2')->default('pending')->after('end_date');
            $table->foreignId('reviewed_by')->nullable()->after('status_v2')->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable()->after('reviewed_by');
            $table->text('rejection_reason')->nullable()->after('reviewed_at');
            $table->timestamp('submitted_for_review_at')->nullable()->after('rejection_reason');
        });

        DB::table('campaigns')->update([
            'status_v2' => DB::raw("
                CASE status
                    WHEN 'aktif' THEN 'active'
                    WHEN 'nonaktif' THEN 'pending'
                    WHEN 'selesai' THEN 'completed'
                    ELSE 'pending'
                END
            "),
            'submitted_for_review_at' => DB::raw('created_at'),
        ]);

        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('campaigns', function (Blueprint $table) {
            $table->renameColumn('status_v2', 'status');
        });
    }

    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->enum('status_legacy', ['aktif', 'nonaktif', 'selesai'])->default('aktif')->after('end_date');
        });

        DB::table('campaigns')->update([
            'status_legacy' => DB::raw("
                CASE status
                    WHEN 'active' THEN 'aktif'
                    WHEN 'completed' THEN 'selesai'
                    ELSE 'nonaktif'
                END
            "),
        ]);

        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropForeign(['reviewed_by']);
            $table->dropColumn([
                'status',
                'reviewed_by',
                'reviewed_at',
                'rejection_reason',
                'submitted_for_review_at',
            ]);
        });

        Schema::table('campaigns', function (Blueprint $table) {
            $table->renameColumn('status_legacy', 'status');
        });
    }
};
