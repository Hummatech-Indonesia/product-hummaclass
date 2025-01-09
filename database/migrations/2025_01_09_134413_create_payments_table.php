<?php

use App\Enums\InvoiceStatusEnum;
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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('invoice_id')->unique();
            $table->integer('fee_amount');
            $table->integer('amount');
            $table->timestamp('expiry_date');
            $table->integer('paid_amount');
            $table->string('payment_channel');
            $table->string('payment_method');
            $table->enum('invoice_status', [InvoiceStatusEnum::PENDING->value, InvoiceStatusEnum::PAID->value, InvoiceStatusEnum::FAILED->value, InvoiceStatusEnum::EXPIRED->value, InvoiceStatusEnum::UNPAID->value])->default(InvoiceStatusEnum::PENDING->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_industry_classes');
    }
};
