<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:150'],
        ]);

        Subscriber::updateOrCreate(
            ['email' => strtolower($data['email'])],
            ['is_active' => true]
        );

        return back()->with('success', 'You are subscribed. We will send you club news and match updates.');
    }
}
