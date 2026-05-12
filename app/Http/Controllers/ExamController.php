<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ExamName;
use App\Models\Question;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function category($exam_slug)
    {
        $category = Category::where('slug', $exam_slug)
            ->with(['exams.examNames' => function ($q) {
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

        $questions = $examName->questions()->orderBy('id')->get();

        if ($questions->isEmpty()) {
            abort(404, 'No questions found for this test');
        }

        $questionIds = $questions->pluck('id')->toArray();

        $sessionKey = "quiz_current_question_{$examName->id}";
        $currentQuestionId = session($sessionKey);

        if (! $currentQuestionId || ! in_array($currentQuestionId, $questionIds)) {
            $currentQuestionId = $questionIds[0];
            session([$sessionKey => $currentQuestionId]);
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

        $progressKey = "quiz_progress_{$examName->id}";
        $progress = session($progressKey, [
            'answered_count' => 0,
            'correct_count' => 0,
        ]);

        $answeredCount = $progress['answered_count'];
        $correctCount = $progress['correct_count'];

        $selectedChoice = $request->query('choice');
        $answerSessionKey = "quiz_answered_{$examName->id}_{$currentQuestion->id}";
        $alreadyCounted = session()->has($answerSessionKey);

        $isAnswered = $selectedChoice !== null || $alreadyCounted;
        $isCorrect = false;

        if ($selectedChoice !== null && ! $alreadyCounted) {
            $isCorrect = ($selectedChoice === $currentQuestion->correctAnswer);

            session()->put($answerSessionKey, true);

            $answeredCount++;
            if ($isCorrect) {
                $correctCount++;
            }

            session()->put($progressKey, [
                'answered_count' => $answeredCount,
                'correct_count' => $correctCount,
            ]);
        }

        $highScoreKey = "quiz_highscore_{$examName->id}";
        $highScore = session($highScoreKey, 87);

        return view('exam.question', compact(
            'category',
            'exam',
            'examName',
            'questions',
            'currentQuestion',
            'isAnswered',
            'isCorrect',
            'selectedChoice',
            'alreadyCounted',
            'previousId',
            'nextId',
            'navExams',
            'relatedExams',
            'answeredCount',
            'correctCount',
            'highScore'
        ));
    }

    public function navigate(Request $request)
    {
        $examNameId = $request->input('exam_name_id');
        $direction = $request->input('direction');

        $examName = ExamName::findOrFail($examNameId);
        $questions = $examName->questions()->orderBy('id')->pluck('id')->toArray();

        $sessionKey = "quiz_current_question_{$examNameId}";
        $currentId = session($sessionKey);
        $currentIndex = array_search($currentId, $questions);

        $newId = null;

        if ($direction === 'next') {
            if (isset($questions[$currentIndex + 1])) {
                $newId = $questions[$currentIndex + 1];
            } else {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'redirect' => route('quiz.results', [
                            'exam_slug' => $examName->exam->category->slug,
                            'subject_slug' => $examName->exam->slug,
                            'test_slug' => $examName->slug,
                        ]),
                    ]);
                }

                return redirect()->route('quiz.results', [
                    'exam_slug' => $examName->exam->category->slug,
                    'subject_slug' => $examName->exam->slug,
                    'test_slug' => $examName->slug,
                ]);
            }
        } elseif ($direction === 'previous') {
            if (isset($questions[$currentIndex - 1])) {
                $newId = $questions[$currentIndex - 1];
            }
        }

        if ($newId) {
            session([$sessionKey => $newId]);
        }

        if ($request->ajax() || $request->wantsJson()) {
            $currentQuestion = $examName->questions()->find($newId);
            $questionIds = $examName->questions()->orderBy('id')->pluck('id')->toArray();
            $questionNumber = array_search($newId, $questionIds) + 1;
            $totalQuestions = count($questionIds);

            $progress = session("quiz_progress_{$examNameId}", [
                'answered_count' => 0,
                'correct_count' => 0,
            ]);

            return response()->json([
                'success' => true,
                'question_number' => $questionNumber,
                'total_questions' => $totalQuestions,
                'question_id' => $currentQuestion->id,
                'question_text' => $currentQuestion->question,
                'correct_answer' => $currentQuestion->correctAnswer,
                'choices' => $currentQuestion->choices,
                'already_counted' => session()->has("quiz_answered_{$examNameId}_{$newId}"),
                'answered_count' => $progress['answered_count'],
                'correct_count' => $progress['correct_count'],
                'has_previous' => isset($questionIds[array_search($newId, $questionIds) - 1]),
                'has_next' => isset($questionIds[array_search($newId, $questionIds) + 1]),
                'is_last' => $questionNumber === $totalQuestions,
                'results_url' => route('quiz.results', [
                    'exam_slug' => $examName->exam->category->slug,
                    'subject_slug' => $examName->exam->slug,
                    'test_slug' => $examName->slug,
                ]),
            ]);
        }

        return redirect()->route('quiz.show', [
            'exam_slug' => $examName->exam->category->slug,
            'subject_slug' => $examName->exam->slug,
            'test_slug' => $examName->slug,
        ]);
    }

    public function updateProgress(Request $request)
    {
        $examNameId = $request->input('exam_name_id');
        $questionId = $request->input('question_id');
        $isCorrect = $request->input('is_correct');
        $answeredCount = $request->input('answered_count');
        $correctCount = $request->input('correct_count');

        session()->put("quiz_answered_{$examNameId}_{$questionId}", true);
        session()->put("quiz_progress_{$examNameId}", [
            'answered_count' => $answeredCount,
            'correct_count' => $correctCount,
        ]);

        return response()->json(['success' => true]);
    }

    public function results($exam_slug, $subject_slug, $test_slug)
    {
        $category = Category::where('slug', $exam_slug)->firstOrFail();
        $exam = $category->exams()->where('slug', $subject_slug)->firstOrFail();
        $examName = $exam->examNames()->where('slug', $test_slug)->firstOrFail();

        $progressKey = "quiz_progress_{$examName->id}";
        $progress = session($progressKey, [
            'answered_count' => 0,
            'correct_count' => 0,
        ]);

        $score = $progress['correct_count'] ?? 0;
        $total = $examName->questions()->count();
        $percentage = $total > 0 ? round(($score / $total) * 100) : 0;

        $highScoreKey = "quiz_highscore_{$examName->id}";
        $highScore = session($highScoreKey, 0);
        $newHighScore = false;

        if ($percentage > $highScore) {
            $newHighScore = true;
            session()->put($highScoreKey, $percentage);
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

    public function reset(Request $request, $exam_slug, $subject_slug, $test_slug)
    {
        $category = Category::where('slug', $exam_slug)->firstOrFail();
        $exam = $category->exams()->where('slug', $subject_slug)->firstOrFail();
        $examName = $exam->examNames()->where('slug', $test_slug)->firstOrFail();

        session()->forget("quiz_progress_{$examName->id}");
        session()->forget("quiz_current_question_{$examName->id}");
        session()->forget("quiz_highscore_{$examName->id}");

        $questions = $examName->questions()->pluck('id');
        foreach ($questions as $qid) {
            session()->forget("quiz_answered_{$examName->id}_{$qid}");
        }

        return redirect()->route('quiz.show', [
            'exam_slug' => $exam_slug,
            'subject_slug' => $subject_slug,
            'test_slug' => $test_slug,
        ]);
    }

    public function questionNext(Request $request)
    {
        $request->validate([
            'exam_name_id' => 'required',
            'question_id' => 'required',
        ]);

        $question = Question::where('exam_name_id', $request->exam_name_id)->where('id', '>', $request->question_id)->first();

        return response()->json([
            'question' => $question,
        ]);
    }
}
