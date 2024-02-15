<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('shop_id');
            $table->string('phone', 50)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('delivery_address', 500)->nullable();
            $table->unsignedSmallInteger('table_tend_number')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
