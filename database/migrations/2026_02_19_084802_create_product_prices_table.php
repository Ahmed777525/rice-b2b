<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            
            // الأسعار
            $table->decimal('price', 10, 2); // سعر البيع
            $table->decimal('cost', 10, 2); // التكلفة (للمحاسبة)
            $table->decimal('wholesale_price', 10, 2)->nullable(); // سعر الجملة
            $table->integer('wholesale_min_quantity')->default(0); // أقل كمية لسعر الجملة
            
            // صلاحية السعر
            $table->date('price_valid_from')->nullable();
            $table->date('price_valid_to')->nullable();
            
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // منع تكرار نفس المنتج لنفس الفرع
            $table->unique(['product_id', 'branch_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_prices');
    }
};