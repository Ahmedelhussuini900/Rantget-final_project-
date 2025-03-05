<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'id_identify',
        'fullname',
        'email',
        'password',
        'age',
        'phone',
        'image',
        'role',
        'id_identify_image',
        'is_admin' // ✅ تأكدي أنه موجود في قاعدة البيانات
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean', // ✅ تأكدي أن is_admin يتم التعامل معه كبوليان
    ];

    /**
     * التحقق مما إذا كان المستخدم هو الـ Super Admin
     */
    public function isSuperAdmin()
    {
        return $this->is_admin && $this->email === 'admin@gmail.com';
    }

    /**
     * التحقق مما إذا كان المستخدم Admin
     */
    public function isAdmin()
    {
        return $this->is_admin; // ✅ سيعمل الآن بدون مشاكل
    }

    /**
     * علاقة Many-to-Many مع Property
     */
    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class, 'property_user')->withTimestamps();
    }
}
