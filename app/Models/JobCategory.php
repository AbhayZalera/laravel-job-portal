<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobCategory extends Model
{
    use HasFactory;
    use Sluggable;
    protected $fillable = ['name', 'icon', 'show_at_popular', 'show_at_featured'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    function jobs(): HasMany
    {
        return $this->hasMany(Job::class, 'job_category_id');
    }
}
