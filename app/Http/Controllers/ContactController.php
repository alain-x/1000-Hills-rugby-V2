<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function create()
    {
        return view('public.contact');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:40'],
            'subject' => ['nullable', 'string', 'max:150'],
            'message' => ['required', 'string', 'max:5000'],
            'website' => ['nullable', 'max:0'], // honeypot
        ], [], [
            'message' => 'message',
        ]);

        unset($data['website']);

        $message = ContactMessage::create([
            ...$data,
            'ip_address' => $request->ip(),
        ]);

        $recipient = setting('contact_email', setting('site_email', config('mail.from.address')));

        if ($recipient) {
            try {
                Mail::raw(
                    "New website enquiry\n\n".
                    "Name: {$message->name}\n".
                    "Email: {$message->email}\n".
                    "Phone: ".($message->phone ?: '—')."\n".
                    "Subject: ".($message->subject ?: 'Website enquiry')."\n\n".
                    $message->message,
                    fn ($mail) => $mail->to($recipient)->subject('Website enquiry: '.($message->subject ?: $message->name))
                );
            } catch (\Throwable $e) {
                Log::warning('Contact notification could not be sent: '.$e->getMessage());
            }
        }

        return back()->with('success', 'Thank you for reaching out. A member of the club team will respond shortly.');
    }
}
