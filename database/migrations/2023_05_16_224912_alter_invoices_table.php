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
        Schema::table('invoices', function (Blueprint $table) {
            $table->unsignedFloat('discount_percentage')->default(0.0)->after('order_id');
            $table->unsignedFloat('fees')->after('discount_percentage');
            $table->string('payment_status')->default('not paid')->after('total_price');
            $table->timestamp('payment_date')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('discount_percentage');
            $table->dropColumn('fees');
            $table->dropColumn('payment_status');
        });
    }
};
