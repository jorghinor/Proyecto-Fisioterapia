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
        Schema::table('functional_assessments', function (Blueprint $table) {
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->date('assessment_date');
            $table->text('notes')->nullable();
            $table->integer('barthel_index')->nullable();
            $table->integer('lawton_brody_scale')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('functional_assessments', function (Blueprint $table) {
            $table->dropForeign(['patient_id']);
            $table->dropColumn(['patient_id', 'assessment_date', 'notes', 'barthel_index', 'lawton_brody_scale']);
        });
    }
};