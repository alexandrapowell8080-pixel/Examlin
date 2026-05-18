<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class ContactController extends Controller
{
    /**
     * Show the contact form.
     */
    public function show()
    {
        return view('contact');
    }

    /**
     * Handle the contact form submission.
     */
    public function submit(Request $request)
    {
        // 1. Basic Form Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'g-recaptcha-response' => 'required|string',
        ]);

        // 2. Google reCAPTCHA v3 Validation
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_V3_SECRET'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip()
        ]);

        $recaptchaResult = $response->json();

        if (!$recaptchaResult['success'] || $recaptchaResult['score'] < 0.5) {
            Log::warning('Bot detected via reCAPTCHA on Contact Form.', ['ip' => $request->ip(), 'score' => $recaptchaResult['score'] ?? 'N/A']);
            return back()->withErrors(['captcha' => 'Security verification failed. Please try again.'])->withInput();
        }

        // 3. Process the Contact Request (Send the Email)
        Mail::to('support@examlin.com')->send(new ContactFormMail($request->all()));

        // 4. Return Success Response
        return back()->with('success', 'Thank you for reaching out! We have received your message and will get back to you shortly.');
    }
}