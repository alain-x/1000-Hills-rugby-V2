<?php

namespace App\Http\Controllers;

use App\Models\StoredImage;

class MediaController extends Controller
{
    public function show(StoredImage $image)
    {
        $binary = base64_decode($image->data, true);

        if ($binary === false) {
            abort(404);
        }

        return response($binary, 200, [
            'Content-Type' => $image->mime ?: 'application/octet-stream',
            'Content-Length' => (string) strlen($binary),
            'Cache-Control' => 'public, max-age=31536000',
        ]);
    }
};
