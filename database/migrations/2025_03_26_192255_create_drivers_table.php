<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade'); // المطعم المرتبط
            $table->string('full_name'); // اسم السائق
            $table->string('phone')->unique(); // رقم الهاتف
            $table->string('vehicle_type'); // نوع المركبة
            $table->enum('status', ['available', 'on_delivery', 'inactive'])->default('available'); // حالة السائق
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('drivers');
    }
};