<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Support\Activity;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        return view('admin.settings.edit');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'site_name' => ['required', 'string', 'max:120'],
            'tagline' => ['nullable', 'string', 'max:200'],
            'founded_year' => ['nullable', 'integer', 'min:1900', 'max:2100'],
            'site_email' => ['nullable', 'email', 'max:150'],
            'contact_email' => ['nullable', 'email', 'max:150'],
            'site_phone' => ['nullable', 'string', 'max:50'],
            'site_phone_alt' => ['nullable', 'string', 'max:50'],
            'site_address' => ['nullable', 'string', 'max:255'],
            'map_embed' => ['nullable', 'string'],
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'twitter_url' => ['nullable', 'url', 'max:255'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'youtube_url' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'tiktok_url' => ['nullable', 'url', 'max:255'],
            'meta_title' => ['nullable', 'string', 'max:200'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'google_analytics_id' => ['nullable', 'string', 'max:40'],
            'footer_text' => ['nullable', 'string', 'max:1000'],
            'hero_title' => ['nullable', 'string', 'max:200'],
            'hero_subtitle' => ['nullable', 'string', 'max:500'],
            'hero_cta_label' => ['nullable', 'string', 'max:80'],
            'hero_cta_url' => ['nullable', 'string', 'max:255'],
            'about_short' => ['nullable', 'string', 'max:1000'],
            'donation_intro' => ['nullable', 'string', 'max:1000'],
            'donation_bank_name' => ['nullable', 'string', 'max:150'],
            'donation_account_name' => ['nullable', 'string', 'max:150'],
            'donation_account_number' => ['nullable', 'string', 'max:80'],
            'donation_mobile_money' => ['nullable', 'string', 'max:150'],
            'site_logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif,svg', 'max:4096'],
            'hero_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:8192'],
            'og_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:8192'],
        ]);

        $textKeys = [
            'site_name', 'tagline', 'founded_year', 'site_email', 'contact_email', 'site_phone',
            'site_phone_alt', 'site_address', 'map_embed', 'facebook_url', 'twitter_url',
            'instagram_url', 'youtube_url', 'linkedin_url', 'tiktok_url', 'meta_title',
            'meta_description', 'google_analytics_id', 'footer_text', 'hero_title', 'hero_subtitle',
            'hero_cta_label', 'hero_cta_url', 'about_short', 'donation_intro', 'donation_bank_name',
            'donation_account_name', 'donation_account_number', 'donation_mobile_money',
        ];

        foreach ($textKeys as $key) {
            if (array_key_exists($key, $data)) {
                Setting::put($key, $data[$key], 'string', $this->groupFor($key));
            }
        }

        foreach (['site_logo', 'hero_image', 'og_image'] as $imageKey) {
            if ($request->hasFile($imageKey)) {
                $path = upload_media($request->file($imageKey), 'settings', setting($imageKey));
                Setting::put($imageKey, $path, 'image', 'branding');
            }
        }

        Setting::flush();
        Activity::log('updated', null, 'Updated website settings');

        return redirect()->route('admin.settings.edit')->with('success', 'Website settings saved.');
    }

    public function activity()
    {
        $logs = \App\Models\ActivityLog::with('user')->latest()->paginate(30);

        return view('admin.activity.index', compact('logs'));
    }

    private function groupFor(string $key): string
    {
        return match (true) {
            str_starts_with($key, 'hero_'), in_array($key, ['about_short']) => 'home',
            str_starts_with($key, 'donation_') => 'donations',
            in_array($key, ['map_embed', 'site_address', 'site_phone', 'site_phone_alt', 'site_email', 'contact_email']) => 'contact',
            str_ends_with($key, '_url') => 'social',
            in_array($key, ['meta_title', 'meta_description', 'google_analytics_id']) => 'seo',
            in_array($key, ['footer_text']) => 'footer',
            default => 'general',
        };
    }
}
