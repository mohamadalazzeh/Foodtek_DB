<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {//v
        Schema::create('addresses', function (Blueprint $table) {
            $table->id(); // المفتاح الأساسي
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // ربط العنوان بالمستخدم
            $table->string('address_line1'); // العنوان الأساسي
            $table->string('city');
            $table->string('state')->nullable();
            $table->string('phone');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
};
