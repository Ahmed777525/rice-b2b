<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'company_name',
        'commercial_register',
        'tax_number',
        'phone',
        'branch_id',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * العلاقة مع الفرع
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * العلاقة مع الطلبات
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * التحقق من دور المستخدم
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * التحقق إذا كان المستخدم Admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * التحقق إذا كان المستخدم Branch Manager
     */
    public function isBranchManager(): bool
    {
        return $this->role === 'branch_manager';
    }

    /**
     * التحقق إذا كان المستخدم Trader
     */
    public function isTrader(): bool
    {
        return $this->role === 'trader';
    }
}