<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobApplication extends Model
{
    protected $fillable = [
        'user_id',
        'job_title',
        'job_description',
        'resume_text',
        'cover_letter',
        'keyword_gaps',
        'bullet_suggestions',
        'interview_questions',
    ];

    protected $casts = [
        'keyword_gaps' => 'array',
        'bullet_suggestions' => 'array',
        'interview_questions' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}