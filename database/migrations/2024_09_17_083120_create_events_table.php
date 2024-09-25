<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('image')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->text('description');
            $table->text('location');
            $table->integer('capacity');
            $table->integer('price');
            $table->date('start_date');
            $table->boolean('has_certificate')->default(true);
            $table->boolean('is_online')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
