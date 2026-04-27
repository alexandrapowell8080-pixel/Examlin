<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExamController;

Route::get('/', function () {
    return view('index');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/{exam_slug}', [ExamController::class, 'category'])
    ->where('exam_slug', '[a-z0-9-]+')
    ->name('exam.category');

Route::get('/{exam_slug}/{subject_slug}/{test_slug}', [ExamController::class, 'quiz'])
    ->where([
        'exam_slug' => '[a-z0-9-]+',
        'subject_slug' => '[a-z0-9-]+',
        'test_slug' => '[a-z0-9-]+'
    ])
    ->name('quiz.show');

Route::post('/quiz/navigate', [ExamController::class, 'navigate'])->name('quiz.navigate');

Route::post('/quiz/update-progress', [ExamController::class, 'updateProgress'])->name('quiz.updateProgress');
Route::post('/question-next',[ExamController::class, 'questionNext']);
Route::get('/{exam_slug}/{subject_slug}/{test_slug}/results', [ExamController::class, 'results'])
    ->where([
        'exam_slug' => '[a-z0-9-]+',
        'subject_slug' => '[a-z0-9-]+',
        'test_slug' => '[a-z0-9-]+'
    ])
    ->name('quiz.results');

Route::get('/{exam_slug}/{subject_slug}/{test_slug}/reset', [ExamController::class, 'reset'])
    ->where([
        'exam_slug' => '[a-z0-9-]+',
        'subject_slug' => '[a-z0-9-]+',
        'test_slug' => '[a-z0-9-]+'
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