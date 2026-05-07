<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // FIX: Migration كانت فارغة — زيدنا التعديل الحقيقي
    public function up(): void
    {
        Schema::table('softwares', function (Blueprint $table) {
            $table->string('header')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('softwares', function (Blueprint $table) {
            $table->string('header')->nullable(false)->change();
        });
    }
};
