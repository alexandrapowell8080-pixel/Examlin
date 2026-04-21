<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ExamController;

Route::get('/', [HomeController::class, 'index'])->name('home');

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