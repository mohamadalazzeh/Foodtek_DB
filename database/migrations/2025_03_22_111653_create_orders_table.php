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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // المستخدم الذي أنشأ الطلب
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade'); // المطعم الذي سيتم الطلب منه
            $table->decimal('total_price', 10, 2); // السعر الإجمالي
            $table->enum('status', ['pending', 'delivered', 'canceled'])->default('pending'); // حالة الطلب
            $table->timestamps();
        });
        //
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');

        //
    }
};
