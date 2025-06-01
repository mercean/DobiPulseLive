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
    Schema::table('bulk_orders', function (Blueprint $table) {
        $table->decimal('price', 8, 2)->default(0)->after('status');
    });
}

public function down(): void
{
    Schema::table('bulk_orders', function (Blueprint $table) {
        $table->dropColumn('price');
    });
}

};
