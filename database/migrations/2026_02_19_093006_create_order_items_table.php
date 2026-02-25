<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained();
            
            // معلومات المنتج وقت الطلب
            $table->string('product_name');
            $table->string('product_sku');
            $table->string('product_unit');
            
            // الكميات والأسعار
            $table->integer('quantity');
            $table->decimal('unit_price', 12, 2);
            $table->decimal('wholesale_price', 12, 2)->nullable();
            $table->boolean('is_wholesale')->default(false);
            $table->decimal('subtotal', 12, 2);
            $table->decimal('tax', 12, 2);
            $table->decimal('total', 12, 2);
            
            // لقطة من المنتج (لحفظ البيانات كاملة)
            $table->json('product_snapshot');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};