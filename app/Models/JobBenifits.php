<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobBenifits extends Model
{
    use HasFactory;
    protected $fillable = ['job_id', 'benifit_id'];

    function benefit(): BelongsTo
    {
        return $this->belongsTo(Benifits::class, 'benifit_id', 'id');
    }
}
