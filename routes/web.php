<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ExamController;


Route::get('/course/{exam_slug}', [ExamController::class, 'category'])
    ->where('exam_slug', '[a-z0-9-]+')
    ->name('exam.category');

Route::get('/quiz/{exam_slug}/{subject_slug}/{test_slug}', [ExamController::class, 'quiz'])
    ->where([
        'exam_slug' => '[a-z0-9-]+',
        'subject_slug' => '[a-z0-9-]+',
        'test_slug' => '[a-z0-9-]+'
    ])
    ->name('quiz.show');

Route::get('/quiz/{exam_slug}/{subject_slug}/{test_slug}/results', [ExamController::class, 'results'])
    ->where([
        'exam_slug' => '[a-z0-9-]+',
        'subject_slug' => '[a-z0-9-]+',
        'test_slug' => '[a-z0-9-]+'
    ])
    ->name('quiz.results');

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