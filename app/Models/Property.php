<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Contracts;

class Property extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'image','location', 'price', 'status'];

    /**
     * Define Many-to-Many Relationship with Users
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'property_user')->withTimestamps();
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contracts::class);
    }

}
