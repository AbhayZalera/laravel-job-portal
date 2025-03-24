<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name', 'created_at', 'updated_at'];

    function companies()
    {
        return $this->hasMany(Company::class, 'country', 'id');
    }
}
