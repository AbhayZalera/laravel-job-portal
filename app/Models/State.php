<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class State extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'name', 'county_id', 'created_at', 'updated_at'];

    function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
