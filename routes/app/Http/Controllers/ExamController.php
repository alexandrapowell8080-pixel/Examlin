<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class ExamController extends Controller
{
   
    public function category($exam_slug)
    {
        $category = Category::where('slug', $exam_slug)
            ->with(['exams.examNames' => function($q) {
                $q->orderBy('id'); 
            }])
            ->firstOrFail();
        
        $navExams = Category::with('classification')->orderBy('id')->get();
        
        return view('exam.category', compact('category', 'navExams'));
    }

    public function quiz($exam_slug, $subject_slug, $test_slug, Request $request)
    {
        $category = Category::where('slug', $exam_slug)->firstOrFail();
        $exam = $category->exams()->where('slug', $subject_slug)->firstOrFail();
        $examName = $exam->examNames()->where('slug', $test_slug)->firstOrFail();
        
        $questions = $examName->questions()
            ->orderBy('id') 
            ->get();

        if ($questions->isEmpty()) {
            abort(404, 'No questions found for this test');
        }

        $questionIds = $questions->pluck('id')->toArray();
        
        $currentQuestionId = session("quiz_current_question_{$examName->id}");
        
        if (!$currentQuestionId || !in_array($currentQuestionId, $questionIds)) {
            $currentQuestionId = $questionIds[0];
            session(["quiz_current_question_{$examName->id}" => $currentQuestionId]);
        }
        
        $currentQuestion = $questions->firstWhere('id', $currentQuestionId);
        
        $currentIndex = array_search($currentQuestion->id, $questionIds);
        $previousId = $questionIds[$currentIndex - 1] ?? null;
        $nextId = $questionIds[$currentIndex + 1] ?? null;

        $navExams = Category::orderBy('id')->take(5)->get();
        $relatedExams = Category::where('id', '!=', $category->id)
            ->inRandomOrder()
            ->take(3)
            ->get();

        $progress = session("quiz_progress_{$examName->id}", []);
        $answeredCount = $progress['answered_count'] ?? 0;
        $correctCount = $progress['correct_count'] ?? 0;

        $selectedChoice = $request->query('choice');
        $isAnswered = $request->query('answered', false) && $selectedChoice;
        
        if ($isAnswered) {
            $isCorrect = ($selectedChoice === $currentQuestion->correctAnswer);
            
            if (!session()->has("quiz_answered_{$examName->id}_{$currentQuestion->id}")) {
                session()->put("quiz_answered_{$examName->id}_{$currentQuestion->id}", true);
                $answeredCount++;
                if ($isCorrect) {
                    $correctCount++;
                }
                session()->put("quiz_progress_{$examName->id}", [
                    'answered_count' => $answeredCount,
                    'correct_count' => $correctCount,
                ]);
            }
        }

        return view('exam.question', compact(
            'category',
            'exam',
            'examName',
            'questions',
            'currentQuestion',
            'isAnswered',
            'selectedChoice',
            'previousId',
            'nextId',
            'navExams',
            'relatedExams',
            'answeredCount',
            'correctCount'
        ));
    }

    public function navigate(Request $request)
    {
        $examNameId = $request->input('exam_name_id');
        $direction = $request->input('direction');
        
        $examName = \App\Models\ExamName::findOrFail($examNameId);
        $questions = $examName->questions()->orderBy('id')->pluck('id')->toArray();
        
        $currentId = session("quiz_current_question_{$examNameId}");
        $currentIndex = array_search($currentId, $questions);
        
        if ($direction === 'next' && isset($questions[$currentIndex + 1])) {
            $newId = $questions[$currentIndex + 1];
        } elseif ($direction === 'previous' && isset($questions[$currentIndex - 1])) {
            $newId = $questions[$currentIndex - 1];
        } else {
            return redirect()->route('quiz.results', [
                'exam_slug' => $examName->exam->category->slug,
                'subject_slug' => $examName->exam->slug,
                'test_slug' => $examName->slug,
            ]);
        }
        
        session(["quiz_current_question_{$examNameId}" => $newId]);
        
        return redirect()->route('quiz.show', [
            'exam_slug' => $examName->exam->category->slug,
            'subject_slug' => $examName->exam->slug,
            'test_slug' => $examName->slug,
        ]);
    }

    public function results($exam_slug, $subject_slug, $test_slug)
    {
        $category = Category::where('slug', $exam_slug)->firstOrFail();
        $exam = $category->exams()->where('slug', $subject_slug)->firstOrFail();
        $examName = $exam->examNames()->where('slug', $test_slug)->firstOrFail();
        
        $progress = session("quiz_progress_{$examName->id}", []);
        $score = $progress['correct_count'] ?? 0;
        $total = $examName->questions()->count();
        $percentage = $total > 0 ? round(($score / $total) * 100) : 0;
        
        $highScore = session("high_score_{$examName->id}", 0);
        $newHighScore = false;
        
        if ($percentage > $highScore) {
            $newHighScore = true;
            session()->put("high_score_{$examName->id}", $percentage);
        }
        
        $navExams = Category::orderBy('id')->take(5)->get();
        
        return view('exam.results', compact(
            'category',
            'exam',
            'examName',
            'score',
            'total',
            'percentage',
            'highScore',
            'newHighScore',
            'navExams'
        ));
    }
    public function updateProgress(Request $request)
    {
        $examNameId = $request->input('exam_name_id');
        $questionId = $request->input('question_id');
        
        session()->put("quiz_answered_{$examNameId}_{$questionId}", true);
        session()->put("quiz_progress_{$examNameId}", [
            'answered_count' => $request->input('answered_count'),
            'correct_count' => $request->input('correct_count'),
        ]);

        return response()->json(['status' => 'success']);
    }
}