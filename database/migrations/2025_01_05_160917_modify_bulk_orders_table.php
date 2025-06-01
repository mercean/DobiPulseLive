<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyBulkOrdersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop the old table if it exists
        Schema::dropIfExists('bulk_orders');

        // Create the bulk_orders table with the necessary fields
        Schema::create('bulk_orders', function (Blueprint $table) {
            $table->id();
            $table->string('cloth_type');
            $table->decimal('load_kg', 8, 2);
            $table->date('load_arrival_date');
            $table->time('load_arrival_time');
            $table->date('pickup_date');
            $table->time('pickup_time');
            $table->string('status')->default('pending'); // Default status is pending
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bulk_orders');
    }
}
