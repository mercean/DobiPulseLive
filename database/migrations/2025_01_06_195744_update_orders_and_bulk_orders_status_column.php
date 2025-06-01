<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Modify the orders table
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->change();
        });
    
        // Modify the bulk_orders table
        Schema::table('bulk_orders', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->change();
        });
    }
    
    public function down()
    {
        // Reverse the modification
        Schema::table('orders', function (Blueprint $table) {
            $table->string('status')->change();
        });
    
        Schema::table('bulk_orders', function (Blueprint $table) {
            $table->string('status')->change();
        });
    }
    
};
