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
        Schema::table('certificates', function (Blueprint $table) {
            $table->foreignId('user_event_id')->nullable()->constrained('user_events')->restrictOnDelete()->cascadeOnUpdate()->default(null);
            $table->foreignId('user_course_id')->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropColumns('user_event_id');
        Schema::table('certificates', function (Blueprint $table) {
            $table->foreignId('user_course_id')->constrained()->change();
        });
    }
};
