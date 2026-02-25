<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_ar');
            $table->string('name_en');
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->string('barcode')->nullable();
            $table->text('description');
            $table->text('description_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('restrict');
            
            // مواصفات المنتج
            $table->string('unit')->default('kg'); // كيلو، جرام، كيس
            $table->decimal('unit_weight', 8, 2)->nullable(); // وزن الوحدة
            $table->integer('min_order_quantity')->default(1);
            $table->integer('max_order_quantity')->nullable();
            
            // الصور
            $table->string('main_image')->nullable();
            $table->json('gallery_images')->nullable();
            
            // حالة المنتج
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_taxable')->default(true);
            $table->decimal('tax_rate', 5, 2)->default(15.00); // نسبة الضريبة (15% في السعودية)
            
            $table->timestamps();
            $table->softDeletes(); // لعدم حذف المنتجات نهائياً
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};