<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamName extends Model
{
    protected $table = 'exam_names';
    protected $fillable = ['exam_id', 'name', 'slug'];
    public $timestamps = false;

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'exam_name_id');
    }
}