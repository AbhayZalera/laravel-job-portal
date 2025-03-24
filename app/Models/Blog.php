<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Blog extends Model
{
    use HasFactory, Sluggable;
    protected $fillable = [
        'image',
        'author_id',
        'title',
        'description',
        'status',
        'featured'
    ];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    function author(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'author_id', 'id');
    }
}
