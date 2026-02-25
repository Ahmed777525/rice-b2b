<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            
            // الكميات
            $table->integer('quantity')->default(0);
            $table->integer('reserved_quantity')->default(0); // كمية محجوزة (في سلة المشتريات)
            $table->integer('available_quantity')->storedAs('quantity - reserved_quantity'); // MySQL generated column
            $table->integer('reorder_level')->default(10); // حد إعادة الطلب
            $table->integer('max_stock_level')->nullable(); // الحد الأقصى للمخزون
            
            // معلومات التخزين
            $table->string('location_in_warehouse')->nullable(); // موقع التخزين في المستودع
            $table->date('last_stock_take')->nullable(); // تاريخ آخر جرد
            
            $table->timestamps();
            
            // منع تكرار نفس المنتج لنفس الفرع
            $table->unique(['product_id', 'branch_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};