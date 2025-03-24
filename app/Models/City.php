<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'state_id', 'county_id', 'created_at', 'updated_at'];

    //state
    function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    //country
    function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
