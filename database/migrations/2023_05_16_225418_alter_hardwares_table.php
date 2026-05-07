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
        Schema::table('hardwares', function (Blueprint $table) {
            $table->unsignedFloat('price')->default(00.00)->after('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hardwares', function (Blueprint $table) {
            $table->dropColumn('price');
        });
    }
};
