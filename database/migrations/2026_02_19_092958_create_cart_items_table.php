<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('unit_price', 12, 2); // السعر وقت الإضافة
            $table->decimal('wholesale_price', 12, 2)->nullable(); // سعر الجملة إن وجد
            $table->boolean('is_wholesale')->default(false); // هل تم تطبيق سعر الجملة
            $table->decimal('subtotal', 12, 2); // quantity * unit_price
            $table->decimal('tax', 12, 2); // الضريبة على هذا المنتج
            $table->decimal('total', 12, 2); // subtotal + tax
            
            // معلومات إضافية عن المنتج وقت الإضافة
            $table->json('product_snapshot')->nullable(); // حفظ بيانات المنتج وقتها
            
            $table->timestamps();
            
            // منع تكرار نفس المنتج في نفس السلة
            $table->unique(['cart_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};