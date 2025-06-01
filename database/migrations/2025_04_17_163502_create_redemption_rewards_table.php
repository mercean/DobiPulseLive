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
        Schema::create('redemption_rewards', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('icon')->default('🎁');
            $table->integer('points_required');
            $table->enum('type', ['percent', 'fixed', 'product']); // ✅ fixed enum
            $table->string('reward_value'); // e.g., 10 (percent), 4 (RM), FreeWash
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('redemption_rewards');
    }
};
