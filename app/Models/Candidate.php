<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Candidate extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'user_id',
        'image',
        'cv',
        'full_name',
        'title',
        'experience_id',
        'website',
        'birth_date',
        'gender',
        'marital_status',
        'profession_id',
        'status',
        'bio',
        'country',
        'state',
        'city',
        'address',
        'phone_one',
        'phone_two',
        'email'
    ];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'full_name'
            ]
        ];
    }

    function skills(): HasMany
    {
        return $this->hasMany(CandidateSkill::class, 'candidate_id', 'id');
    }
    function languages(): HasMany
    {
        return $this->hasMany(CandidateLanguage::class, 'candidate_id', 'id');
    }

    function countries(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country', 'id');
    }
    function states(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state', 'id');
    }
    function cities(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city', 'id');
    }

    function experience(): BelongsTo
    {
        return $this->belongsTo(Experience::class, 'experience_id', 'id');
    }
    function experiences(): HasMany
    {
        return $this->hasMany(CandidateExperience::class, 'candidate_id', 'id')->orderBy('id', 'DESC');
    }

    function educations(): HasMany
    {
        return $this->hasMany(CandidateEducation::class, 'candidate_id', 'id')->orderBy('id', 'DESC');
    }

    function professions(): BelongsTo
    {
        return $this->belongsTo(Profession::class, 'profession_id', 'id');
    }
}
