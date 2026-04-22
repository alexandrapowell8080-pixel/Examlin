<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Subject;
use App\Models\Test;
use App\Models\Question;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function category($exam_slug)
    {
        $exam = Exam::where('slug', $exam_slug)
            ->where('is_active', true)
            ->firstOrFail();
        
        $subjects = $exam->subjects()
            ->with(['tests' => fn($q) => $q->where('is_active', true)->orderBy('order')])
            ->orderBy('order')
            ->get();
        
        $navExams = Exam::where('is_active', true)->orderBy('order')->get();
        
        return view('exam.category', compact('exam', 'subjects', 'navExams'));
    }

    public function quiz($exam_slug, $subject_slug, $test_slug, Request $request)
    {
        $exam = Exam::where('slug', $exam_slug)->where('is_active', true)->firstOrFail();
        $subject = $exam->subjects()->where('slug', $subject_slug)->firstOrFail();
        $test = $subject->tests()->where('slug', $test_slug)->where('is_active', true)->firstOrFail();
        
        $questions = $test->questions()
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        if ($questions->isEmpty()) {
            abort(404, 'No questions found for this test');
        }

        $currentOrder = $request->query('q', 1);
        $currentQuestion = $questions->firstWhere('order', $currentOrder) ?? $questions->first();
        $showRationale = $request->query('answered', false);

        $questionOrders = $questions->pluck('order')->toArray();
        $currentIndex = array_search($currentQuestion->order, $questionOrders);
        $previousOrder = $questionOrders[$currentIndex - 1] ?? null;
        $nextOrder = $questionOrders[$currentIndex + 1] ?? null;

        $navExams = Exam::where('is_active', true)->orderBy('order')->take(5)->get();
        $relatedExams = Exam::where('id', '!=', $exam->id)
            ->where('is_active', true)
            ->inRandomOrder()
            ->take(3)
            ->get();

        $progress = session("quiz_progress_{$test->id}", []);
        $answeredCount = $progress['answered_count'] ?? 0;
        $correctCount = $progress['correct_count'] ?? 0;

        if ($showRationale) {
            $selectedChoice = $request->query('choice');
            
            // Fixed: Use array access instead of nullsafe operator
            $choice = collect($currentQuestion->choices)->firstWhere('letter', $selectedChoice);
            $isCorrect = $choice['is_correct'] ?? false;
            
            if ($isCorrect) {
                $correctCount++;
            }
            $answeredCount++;
            
            session()->put("quiz_progress_{$test->id}", [
                'current_order' => $currentQuestion->order,
                'answered_count' => $answeredCount,
                'correct_count' => $correctCount,
            ]);
        }

        return view('exam.question', compact(
            'exam',
            'subject',
            'test',
            'questions',
            'currentQuestion',
            'showRationale',
            'previousOrder',
            'nextOrder',
            'navExams',
            'relatedExams',
            'answeredCount',
            'correctCount'
        ));
    }

    public function results($exam_slug, $subject_slug, $test_slug)
    {
        $exam = Exam::where('slug', $exam_slug)->where('is_active', true)->firstOrFail();
        $subject = $exam->subjects()->where('slug', $subject_slug)->firstOrFail();
        $test = $subject->tests()->where('slug', $test_slug)->where('is_active', true)->firstOrFail();
        
        $progress = session("quiz_progress_{$test->id}", []);
        $score = $progress['correct_count'] ?? 0;
        $total = $test->question_count ?? 5;
        $percentage = $total > 0 ? round(($score / $total) * 100) : 0;
        
        $highScore = session("high_score_{$test->id}", 0);
        $newHighScore = false;
        
        if ($percentage > $highScore) {
            $newHighScore = true;
            session()->put("high_score_{$test->id}", $percentage);
        }
        
        $navExams = Exam::where('is_active', true)->orderBy('order')->take(5)->get();
        
        return view('exam.results', compact(
            'exam',
            'subject',
            'test',
            'score',
            'total',
            'percentage',
            'highScore',
            'newHighScore',
            'navExams'
        ));
    }
}