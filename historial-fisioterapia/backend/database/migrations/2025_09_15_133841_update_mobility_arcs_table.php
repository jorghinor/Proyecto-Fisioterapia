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
        Schema::table('mobility_arcs', function (Blueprint $table) {
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->string('joint');
            $table->integer('flexion')->nullable();
            $table->integer('extension')->nullable();
            $table->integer('abduction')->nullable();
            $table->integer('adduction')->nullable();
            $table->integer('internal_rotation')->nullable();
            $table->integer('external_rotation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mobility_arcs', function (Blueprint $table) {
            $table->dropForeign(['patient_id']);
            $table->dropColumn(['patient_id', 'joint', 'flexion', 'extension', 'abduction', 'adduction', 'internal_rotation', 'external_rotation']);
        });
    }
};