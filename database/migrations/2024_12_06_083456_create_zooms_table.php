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
        Schema::create('zooms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('slug');
            $table->foreignUuid('school_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignUuid('classroom_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignUuid('user_id')->constrained()->cascadeOnUpdate()->cascadeOnUpdate();
            $table->string('link');
            $table->dateTime('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zooms');
    }
};
