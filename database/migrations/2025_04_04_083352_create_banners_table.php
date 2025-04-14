<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {//v
        Schema::create('banners', function (Blueprint $table) {
            $table->id(); // المفتاح الأساسي
            $table->text('description')->nullable(); // وصف الإعلان
            $table->string('image'); // رابط صورة الإعلان
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('banners');
    }
};

