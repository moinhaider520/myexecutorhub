<?php

namespace App\Http\Controllers;

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
        ]);

        // Send email (optional)
        Mail::to('hello@executorhub.co.uk')->send(new \App\Mail\PartnerMail($validatedData));

        // Redirect with success message
        return redirect()->back()->with('success', 'Thank you for your interest in partnering with us. We will get back to you soon!');
    }
}
