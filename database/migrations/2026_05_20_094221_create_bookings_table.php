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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            //Đơn này của Ai và Đặt xe nào 
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('car_id')->constrained()->onDelete('cascade');
            
            // Thông tin ngày tháng
            $table->date('start_date');
            $table->date('end_date');
            
            // Tổng tiền và Trạng thái đơn hàng
            $table->integer('total_price');
            $table->string('status')->default('pending'); // pending, confirmed , cancelled
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
