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
        Schema::table('muscle_evaluations', function (Blueprint $table) {
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->string('muscle');
            $table->integer('strength');
            $table->date('evaluation_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('muscle_evaluations', function (Blueprint $table) {
            $table->dropForeign(['patient_id']);
            $table->dropColumn(['patient_id', 'muscle', 'strength', 'evaluation_date']);
        });
    }
};