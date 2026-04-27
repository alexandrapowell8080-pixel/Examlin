<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\QuestionController;

Route::get('/', function () {
    return view('index');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/questions/{slug}', [QuestionController::class, 'show'])
    ->where('slug', '[a-zA-Z0-9\-_]+')
    ->name('question.show');

Route::post('/api/question-next', [QuestionController::class, 'next'])
    ->name('question.next');

Route::get('/{exam_slug}', [ExamController::class, 'category'])
    ->where('exam_slug', '[a-zA-Z0-9\-_]+')
    ->name('exam.category');

Route::get('/{exam_slug}/{subject_slug}/{test_slug}', [ExamController::class, 'quiz'])
    ->where([
        'exam_slug' => '[a-zA-Z0-9\-_]+',
        'subject_slug' => '[a-zA-Z0-9\-_]+',
        'test_slug' => '[a-zA-Z0-9\-_]+'
    ])
    ->name('quiz.show');

Route::post('/quiz/navigate', [ExamController::class, 'navigate'])->name('quiz.navigate');

Route::post('/quiz/update-progress', [ExamController::class, 'updateProgress'])->name('quiz.updateProgress');

Route::post('/exam/question-next', [ExamController::class, 'questionNext'])->name('exam.questionNext');

Route::get('/{exam_slug}/{subject_slug}/{test_slug}/results', [ExamController::class, 'results'])
    ->where([
        'exam_slug' => '[a-zA-Z0-9\-_]+',
        'subject_slug' => '[a-zA-Z0-9\-_]+',
        'test_slug' => '[a-zA-Z0-9\-_]+'
    ])
    ->name('quiz.results');

Route::get('/{exam_slug}/{subject_slug}/{test_slug}/reset', [ExamController::class, 'reset'])
    ->where([
        'exam_slug' => '[a-zA-Z0-9\-_]+',
        'subject_slug' => '[a-zA-Z0-9\-_]+',
        'test_slug' => '[a-zA-Z0-9\-_]+'
    ])
    ->name('quiz.reset');

Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now(),
        'app' => config('app.name'),
        'env' => config('app.env'),
    ]);
});

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});