<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Show the contact form.
     */
    public function show()
    {
        // Show different views based on authentication status
        if (Auth::check()) {
            return view('contact');
        } else {
            return view('contact-public');
        }
    }

    /**
     * Handle the contact form submission.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        // Here you would typically send an email or store the message
        // For now, we'll just return a success message

        // Example of sending email (uncomment when email is configured):
        /*
        Mail::send('emails.contact', [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'messageBody' => $request->message,
        ], function ($message) use ($request) {
            $message->to('your-email@example.com')
                    ->subject('Contact Form: ' . $request->subject)
                    ->replyTo($request->email, $request->name);
        });
        */

        return back()->with('success', 'Thank you for your message! We\'ll get back to you soon.');
    }
}
