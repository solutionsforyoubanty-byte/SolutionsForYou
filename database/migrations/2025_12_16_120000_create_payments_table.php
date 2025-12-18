<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();
            $table->string('razorpay_order_id')->nullable();
            $table->string('razorpay_payment_id')->nullable();
            $table->string('razorpay_signature')->nullable();
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->enum('plan_type', ['basic', 'standard', 'premium']);
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('INR');
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone')->nullable();
            $table->enum('status', ['pending', 'paid', 'failed'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->json('notes')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index('razorpay_order_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
