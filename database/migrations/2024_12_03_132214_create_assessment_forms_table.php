<?php

use App\Enums\ClassEnum;
use App\Enums\TypeAssesmentEnum;
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
        Schema::create('assessment_forms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('class_level', array_map(fn($enum) => $enum->value, ClassEnum::cases()));
            $table->foreignUuid('division_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('indicator');
            $table->enum('type', [TypeAssesmentEnum::ATTITUDE->value, TypeAssesmentEnum::SKILL->value]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_forms');
    }
};
