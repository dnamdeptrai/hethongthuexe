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
    Schema::create('cars', function (Blueprint $table) {
        $table->id();
        $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Liên kết với bảng loại xe
        $table->string('name'); // Tên xe
        $table->string('brand'); // Hãng xe
        $table->string('image')->nullable(); // Ảnh xe
        $table->string('transmission'); // Loại số
        $table->string('fuel_type'); // Loại nhiên liệu
        $table->integer('seats'); // Số ghế ngồi
        $table->decimal('price_per_day', 12, 2); // Giá thuê theo ngày
        $table->string('status')->default('available'); // Trạng thái
        $table->timestamps(); 
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
