<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function show($slug)
    {
        $question = Question::where('slug', $slug)->firstOrFail();

        $relatedExams = Exam::inRandomOrder()->take(5)->get();

        $relatedQuestions = Question::where('id', '!=', $question->id)
            ->where('exam_name_id', $question->exam_name_id)
            ->inRandomOrder()
            ->take(5)
            ->get();

        if ($relatedQuestions->count() < 5) {
            $remaining = 5 - $relatedQuestions->count();
            $moreQuestions = Question::where('id', '!=', $question->id)
                ->whereNotIn('id', $relatedQuestions->pluck('id'))
                ->inRandomOrder()
                ->take($remaining)
                ->get();
            $relatedQuestions = $relatedQuestions->concat($moreQuestions);
        }

        $choices = [];
        $letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
        foreach ($letters as $letter) {
            $text = $question->{"choice{$letter}"};
            if (! empty(trim($text))) {
                $choices[] = [
                    'letter' => $letter,
                    'text' => $text,
                    'is_correct' => (strtoupper($letter) === strtoupper($question->correctAnswer)),
                ];
            }
        }

        $pageTitle = ($question->exam_name_id ? 'Practice Question' : 'Question').' | Examlin';
        $pageDesc = strip_tags(substr($question->question, 0, 160)).'...';
        $canonical = $question->resource_url ?: route('question.show', $question->slug);

        return view('question.index', compact(
            'question',
            'choices',
            'relatedExams',
            'relatedQuestions',
            'pageTitle',
            'pageDesc',
            'canonical'
        ));
    }

    public function next(Request $request)
    {
        $currentId = $request->input('question_id');

        if (! $currentId) {
            return response()->json(['error' => 'Missing question_id'], 400);
        }

        $nextQuestion = Question::where('id', '!=', $currentId)
            ->inRandomOrder()
            ->first();

        if (! $nextQuestion) {
            return response()->json(['error' => 'No more questions'], 404);
        }

        $choices = [];
        $letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
        foreach ($letters as $letter) {
            $text = $nextQuestion->{"choice{$letter}"};
            if (! empty(trim($text))) {
                $choices[] = [
                    'letter' => $letter,
                    'text' => $text,
                    'is_correct' => (strtoupper($letter) === strtoupper($nextQuestion->correctAnswer)),
                ];
            }
        }

        return response()->json([
            'success' => true,
            'question' => [
                'id' => $nextQuestion->id,
                'slug' => $nextQuestion->slug,
                'resource_url' => $nextQuestion->resource_url,
                'question_text' => $nextQuestion->question,
                'extract' => $nextQuestion->extract,
                'image' => $nextQuestion->image,
                'rationale' => $nextQuestion->rationale,
                'correctAnswer' => $nextQuestion->correctAnswer,
                'choices' => $choices,
            ],
        ]);
    }
}
