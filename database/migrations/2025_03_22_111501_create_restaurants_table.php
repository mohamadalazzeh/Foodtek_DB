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
        Schema::create('restaurants',function(Blueprint $table){
$table->id();
$table->string('name');//اسم المطعم
$table->text('location');//الموقع
$table->string('phone')->unique();//رقم الهاتف
        });
        //
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurants');
        //
    }
};
