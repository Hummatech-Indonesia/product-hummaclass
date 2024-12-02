<?php

use App\Enums\ChallengeSubmitEnum;
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
        Schema::create('challenge_submits', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('student_id')->constrained();
            $table->foreignUuid('challenge_id')->constrained();
            $table->text('image')->nullable();
            $table->text('link')->nullable();
            $table->text('file')->nullable();
            $table->bigInteger('point')->nullable();
            $table->enum('status', [ChallengeSubmitEnum::CONFIRMED->value, ChallengeSubmitEnum::NOT_CONFIRMED->value])->default(ChallengeSubmitEnum::NOT_CONFIRMED->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('challenge_submits');
    }
};
