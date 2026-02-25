<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('branch_id')->constrained(); // فرع المستخدم وقت إنشاء السلة
            $table->string('session_id')->nullable(); // للزوار (لكن نظامنا B2B يتطلب تسجيل)
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('tax', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->integer('items_count')->default(0);
            $table->timestamp('expires_at')->nullable(); // انتهاء صلاحية السلة
            $table->timestamps();
            
            // كل مستخدم له سلة واحدة نشطة فقط
            $table->unique(['user_id']); // user_id فريد => سلة واحدة لكل مستخدم
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};