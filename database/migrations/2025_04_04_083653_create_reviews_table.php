<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {//v
        Schema::create('reviews', function (Blueprint $table) {
            $table->id(); // المفتاح الأساسي
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // ربط التقييم بالمستخدم
            // يمكن ربط التقييم بالمطعم أو الطلب (أحدهما أو كليهما)
            $table->foreignId('restaurant_id')->nullable()->constrained('restaurants')->onDelete('set null');
            $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('set null');
            $table->tinyInteger('rating'); // التقييم من 1 إلى 5
            $table->text('comment')->nullable(); // تعليق المستخدم
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};
