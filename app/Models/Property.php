<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Contracts;
use App\Models\User;

use Illuminate\Notifications\Notifiable;


class Property extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
    'title',
    'description',
    'image',
    'location',
    'price',
    'status',


    ];


    // public function users(): BelongsToMany
    // {
    //     return $this->belongsToMany(User::class, 'property_user');
    // }

    public function contracts()
    {
        return $this->hasMany(Contract::class, 'property_id');
    }

    // public function properties()
    // {
    //     return $this->hasMany(Property::class);
    // }
    public function users()
    {
        return $this->belongsToMany(User::class, 'property_user')->withPivot('role');
    }
    public function landlords()
    {
        return $this->belongsToMany(User::class, 'property_user', 'property_id', 'user_id')
            ->where('role', 'landlord'); // تأكد أن المستخدمين ملاك فقط
    }
    // public function landlords()
    // {
    //     return $this->belongsToMany(User::class, 'property_user', 'property_id', 'user_id');
    // }


    public function tenants()
    {
        return $this->belongsToMany(User::class, 'property_user', 'property_id', 'user_id')
        ->where('role', 'tenant'); // تأكد أن المستخدمين ملاك فقط
}


}

