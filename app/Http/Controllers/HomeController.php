<?php

namespace App\Http\Controllers;

use App\Models\Exam;

class HomeController extends Controller
{
    public function index()
    {
        $featuredExams = Exam::where('is_active', true)
            ->orderBy('order')
            ->take(6)
            ->get();
        
        $navExams = Exam::where('is_active', true)->orderBy('order')->get();
        
        return view('home', compact('featuredExams', 'navExams'));
    }
}