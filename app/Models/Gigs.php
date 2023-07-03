<?php

namespace App\Models;

use Illuminate\Database\Eloquent\BroadcastableModelEventOccurred;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Paket;
use App\Models\Category;
use App\Models\Store;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gigs extends Model
{
    use HasFactory;


    public function pakets(): HasMany
    {
        return $this->hasMany(Paket::class, 'id_gigs', 'id');
    }


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'id_category', 'id');
    }


    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'id_store', 'id');
    }
}