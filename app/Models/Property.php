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
    
    
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'property_user');
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

}
