<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class Activity
{
    public static function log(string $action, ?Model $subject = null, ?string $description = null): void
    {
        try {
            \App\Models\ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'subject_type' => $subject ? $subject::class : null,
                'subject_id' => $subject?->getKey(),
                'description' => $description,
                'ip_address' => Request::ip(),
            ]);
        } catch (\Throwable) {
            // Logging must never break a request.
        }
    }
}
