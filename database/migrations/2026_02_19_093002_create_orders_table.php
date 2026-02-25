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
            $table->string('order_number')->unique(); // رقم الطلب (مثل ORD-2024-00001)
            $table->foreignId('user_id')->constrained();
            $table->foreignId('branch_id')->constrained();
            
            // معلومات المستخدم وقت الطلب
            $table->string('user_name');
            $table->string('user_email');
            $table->string('user_phone');
            $table->string('company_name');
            $table->string('commercial_register')->nullable();
            
            // معلومات العنوان
            $table->string('shipping_address');
            $table->string('shipping_city')->nullable();
            $table->string('shipping_phone')->nullable();
            
            // معلومات الطلب
            $table->enum('status', [
                'pending',           // في انتظار المراجعة
                'approved',          // تمت الموافقة
                'processing',        // قيد التجهيز
                'shipped',           // تم الشحن
                'completed',         // مكتمل
                'cancelled',         // ملغي
                'rejected'           // مرفوض
            ])->default('pending');
            
            $table->enum('payment_status', [
                'pending',           // في انتظار الدفع
                'paid',              // تم الدفع
                'failed',            // فشل الدفع
                'refunded'           // تم الاسترداد
            ])->default('pending');
            
            $table->enum('payment_method', [
                'bank_transfer',
                'visa',
                'mada',
                'paypal'
            ])->nullable();
            
            // المبالغ
            $table->decimal('subtotal', 12, 2);
            $table->decimal('tax', 12, 2);
            $table->decimal('shipping_cost', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('total', 12, 2);
            
            // تواريخ مهمة
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->text('cancellation_reason')->nullable();
            
            // ملاحظات
            $table->text('notes')->nullable();
            $table->text('admin_notes')->nullable();
            
            $table->timestamps();
            
            // Indexes للبحث السريع
            $table->index('status');
            $table->index('payment_status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};