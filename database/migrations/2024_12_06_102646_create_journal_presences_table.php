<?php

use App\Enums\PresenceEnum;
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
        Schema::create('journal_presences', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('journal_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignUuid('student_classroom_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->enum('status', [PresenceEnum::PRESENT->value, PresenceEnum::ALPHA->value, PresenceEnum::PERMIT->value, PresenceEnum::SICK->value])->default(PresenceEnum::ALPHA->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journal_presences');
    }
};
