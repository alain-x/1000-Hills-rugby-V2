<?php

use App\Support\ImageStringStore;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('images:store-as-strings {--keep-files : Leave the image files on disk after copying them}', function () {
    app(ImageStringStore::class)->importPublicImages($this, (bool) $this->option('keep-files'));
})->purpose('Save image files as base64 strings in the database');
