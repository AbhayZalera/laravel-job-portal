<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory, Sluggable, SoftDeletes;

    protected $fillable = [
        'title',
        'company_id',
        'job_category_id',
        'vacancies',
        'deadline',
        'country_id',
        'state_id',
        'city_id',
        'address',
        'salary_mode',
        'min_salary',
        'max_salary',
        'custom_salary',
        'salary_type_id',
        'job_experience_id',
        'job_role_id',
        'education_id',
        'job_type_id',
        'apply_on',
        'featured',
        'highlight',
        'description',
        'status',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    function jobType(): BelongsTo
    {
        return $this->belongsTo(JobType::class, 'job_type_id', 'id');
    }

    function jobRole(): BelongsTo
    {
        return $this->belongsTo(JobRole::class, 'job_role_id', 'id');
    }

    function salaryType(): BelongsTo
    {
        return $this->belongsTo(SalaryType::class, 'salary_type_id', 'id');
    }

    function category(): BelongsTo
    {
        return $this->belongsTo(JobCategory::class, 'job_category_id', 'id');
    }

    function tags(): HasMany
    {
        return $this->hasMany(JobTag::class, 'job_id', 'id');
    }
    function benefits(): HasMany
    {
        return $this->hasMany(JobBenifits::class, 'job_id', 'id');
    }

    function skills(): HasMany
    {
        return $this->hasMany(JobSkills::class, 'job_id', 'id');
    }
    function jobExperience(): BelongsTo
    {
        return $this->belongsTo(JobExperience::class, 'job_experience_id', 'id');
    }
    function jobEduction(): BelongsTo
    {
        return $this->belongsTo(Education::class, 'education_id', 'id');
    }

    function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
    function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }
    function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    function application(): HasMany
    {
        return $this->hasMany(AppliedJob::class, 'job_id', 'id');
    }
}
