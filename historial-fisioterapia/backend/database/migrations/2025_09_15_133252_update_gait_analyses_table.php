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
        Schema::table('gait_analyses', function (Blueprint $table) {
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->date('analysis_date');
            $table->string('video_url')->nullable();
            $table->text('observations')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gait_analyses', function (Blueprint $table) {
            $table->dropForeign(['patient_id']);
            $table->dropColumn(['patient_id', 'analysis_date', 'video_url', 'observations']);
        });
    }
};