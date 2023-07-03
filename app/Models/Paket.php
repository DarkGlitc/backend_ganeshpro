<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Gigs;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paket extends Model
{
    use HasFactory;


    public function gigs(): BelongsTo
    {
        return $this->belongsTo(Gigs::class, 'id_gigs', 'id');
    }
}