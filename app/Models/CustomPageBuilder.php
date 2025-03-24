<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomPageBuilder extends Model
{
    use HasFactory, Sluggable;
    protected $fillable = [
        'page_name',
        'content'
    ];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'page_name'
            ]
        ];
    }
}
