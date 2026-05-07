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
        Schema::create('order_list', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable(); // FIX: unsignedBigInteger بدل unsignedInteger
            $table->unsignedBigInteger('user_id');              // FIX: unsignedBigInteger
            $table->unsignedBigInteger('prod_id');              // FIX: unsignedBigInteger
            $table->string('prod_category');
            $table->integer('volume')->default(1);
            $table->timestamps();

            // FIX: إضافة index + foreign key على user_id و order_id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('set null');
            // prod_id ما كنزيدوهش foreign key لأنه polymorphic (hardware/software/...)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_list');
    }
};
