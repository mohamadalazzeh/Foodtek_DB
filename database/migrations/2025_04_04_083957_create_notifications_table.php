<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id(); // المفتاح الأساسي
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // ربط الإشعار بالمستخدم
            $table->string('title'); // عنوان الإشعار
            $table->text('message'); // نص الإشعار
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};
