<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    protected $fillable = [
        'test_id', 
        'order', 
        'question_text', 
        'choices',              
        'rationale_heading', 
        'rationale_content', 
        'is_active'
    ];

    protected $casts = [
        'choices' => 'array',   
        'is_active' => 'boolean',
    ];

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }
}