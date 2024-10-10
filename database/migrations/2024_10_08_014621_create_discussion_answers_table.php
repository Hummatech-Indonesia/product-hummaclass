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
        Schema::create('discussion_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('discussion_answer_id')->nullable()->constrained();
            $table->foreignId('discussion_id')->constrained();
            $table->foreignUuid('user_id')->constrained();
            $table->text('answer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discussion_answers');
    }
};
