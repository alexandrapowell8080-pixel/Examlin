<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    protected $fillable = [
        'exam_name_id', 'extract', 'question', 'choiceA', 'choiceB', 'choiceC',
        'choiceD', 'choiceE', 'choiceF', 'choiceG', 'correctAnswer', 'rationale',
        'image', 'qtype', 'heading', 'resource_url', 'added_by'
    ];
    public $timestamps = false; 

    protected $casts = [
        'exam_name_id' => 'integer',
    ];

    public function examName(): BelongsTo
    {
        return $this->belongsTo(ExamName::class, 'exam_name_id');
    }

    public function getChoicesAttribute(): array
    {
        $choices = [];
        foreach (range('A', 'G') as $letter) {
            $value = $this->{"choice{$letter}"};
            if (!empty($value)) {
                $choices[] = [
                    'letter' => $letter,
                    'text' => $value,
                    'is_correct' => ($letter === $this->correctAnswer)
                ];
            }
        }
        return $choices;
    }
    public function getRationaleHeadingAttribute(): ?string
    {
        return $this->heading;
    }

    public function getRationaleContentAttribute(): ?string
    {
        return $this->rationale;
    }

    public function getQuestionTextAttribute(): string
    {
        return $this->question;
    }
}