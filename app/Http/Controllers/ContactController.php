<?php

namespace App\Http\Controllers;

use Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function Contactform(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
            'subject' => 'required|string',
            'g-recaptcha-response' => [
                'required',
                function ($attribute, $value, $fail) {
                    $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                        'secret' => config('services.recaptcha.secret_key'),
                        'response' => $value,
                    ]);

                    if (!$response->json('success')) {
                        $fail('Captcha validation failed.');
                    }
                }
            ],
        ]);

        // Send email (optional)
        Mail::to('hello@executorhub.co.uk')->send(new \App\Mail\ContactMail($validatedData));

        // Redirect with success message
        return redirect()->back()->with('success', 'Thank you for contacting us. We will get back to you soon!');
    }

    public function PartnerWithUs(Request $request)
    {
        $validatedData = $request->validate([
            'business_name' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'contact_email' => 'required|email',
            'contact_number' => 'required|string|max:20',
            'g-recaptcha-response' => [
                'required',
                function ($attribute, $value, $fail) {
                    $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                        'secret' => config('services.recaptcha.secret_key'),
                        'response' => $value,
                    ]);

                    if (!$response->json('success')) {
                        $fail('Captcha validation failed.');
                    }
                }
            ],
        ]);

        // Send email (optional)
        Mail::to('hello@executorhub.co.uk')->send(new \App\Mail\PartnerMail($validatedData));
        Mail::to($validatedData['contact_email'])->send(new \App\Mail\PartnerMailWelcome($validatedData));
        // Redirect with success message
        return redirect()->back()->with('success', 'Thank you for your interest in partnering with us. We will get back to you soon!');
    }
}
