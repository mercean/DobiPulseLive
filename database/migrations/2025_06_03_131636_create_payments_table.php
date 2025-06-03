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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete(); // One-to-one or just the first of multi
            $table->string('payment_intent_id')->unique(); // Stripe PaymentIntent ID
            $table->decimal('amount', 8, 2); // MYR currency, 999,999.99 max
            $table->string('status'); // e.g. 'succeeded', 'pending', 'failed'
            $table->string('method')->nullable(); // e.g. 'card', 'grabpay'
            $table->string('currency', 10)->default('myr');
            $table->json('metadata')->nullable(); // Optional: Store order_ids for multi or coupon codes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
