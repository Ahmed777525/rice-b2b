<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number', 'user_id', 'branch_id',
        'user_name', 'user_email', 'user_phone',
        'company_name', 'commercial_register',
        'shipping_address', 'shipping_city', 'shipping_phone',
        'status', 'payment_status', 'payment_method',
        'subtotal', 'tax', 'shipping_cost', 'discount', 'total',
        'approved_at', 'shipped_at', 'completed_at',
        'cancelled_at', 'cancellation_reason',
        'notes', 'admin_notes'
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'shipped_at' => 'datetime',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    /**
     * العلاقات
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * توليد رقم طلب فريد
     */
    public static function generateOrderNumber(): string
    {
        $year = date('Y');
        $month = date('m');
        
        // الحصول على آخر رقم طلب لهذا الشهر
        $lastOrder = self::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id', 'desc')
            ->first();
        
        if ($lastOrder) {
            $lastNumber = intval(substr($lastOrder->order_number, -5));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return sprintf('ORD-%s%s-%05d', $year, $month, $newNumber);
    }

    /**
     * هل يمكن إلغاء الطلب؟
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'approved']);
    }

    /**
     * هل يمكن الموافقة على الطلب؟
     */
    public function canBeApproved(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * تحديث حالة الطلب
     */
    public function updateStatus(string $status, ?string $reason = null): bool
    {
        $oldStatus = $this->status;
        $this->status = $status;
        
        switch ($status) {
            case 'approved':
                $this->approved_at = now();
                break;
            case 'shipped':
                $this->shipped_at = now();
                break;
            case 'completed':
                $this->completed_at = now();
                break;
            case 'cancelled':
            case 'rejected':
                $this->cancelled_at = now();
                $this->cancellation_reason = $reason;
                break;
        }
        
        return $this->save();
    }
}