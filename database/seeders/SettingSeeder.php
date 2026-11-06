<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::flush();

        $settings = [
            // General
            ['site_name', '1000 Hills Rugby', 'string', 'general'],
            ['tagline', 'Empowering Communities Through Sport', 'string', 'general'],
            ['founded_year', '2014', 'string', 'general'],
            ['site_email', 'info@1000hillsrugby.rw', 'string', 'general'],
            ['contact_email', 'info@1000hillsrugby.rw', 'string', 'general'],
            ['site_phone', '+250 788 261 386', 'string', 'general'],
            ['site_phone_alt', null, 'string', 'general'],

            // Branding
            ['site_logo', 'images/1000-hills-logo.png', 'image', 'branding'],
            ['hero_image', 'uploads/1740072895_fans.JPG', 'image', 'branding'],
            ['og_image', 'uploads/1740072895_fans.JPG', 'image', 'branding'],

            // Homepage
            ['hero_title', 'Welcome to where we belong', 'string', 'home'],
            ['hero_subtitle', '1000 Hills Rugby was born in 2014 at Don Bosco Gatenga with a bold vision: to harness the power of rugby as a unifying force.', 'string', 'home'],
            ['hero_cta_label', 'Learn more', 'string', 'home'],
            ['hero_cta_url', '/about', 'string', 'home'],
            ['about_short', 'At 1000 Hills Rugby, we provide top-tier coaching and skill development. Join the journey of excellence, where teamwork, discipline, and sportsmanship are at the core of everything we do. We are committed to shaping future leaders both on and off the field.', 'string', 'home'],

            // Contact
            ['contact_image', 'images/contact-home-page.jpg', 'image', 'contact'],
            ['site_address', 'KK 591 St, Kigali, Rwanda', 'string', 'contact'],
            ['map_embed', null, 'string', 'contact'],

            // Social
            ['facebook_url', 'https://www.facebook.com/1000HillsRugby', 'string', 'social'],
            ['twitter_url', 'https://x.com/1000HillsRugby', 'string', 'social'],
            ['instagram_url', null, 'string', 'social'],
            ['youtube_url', null, 'string', 'social'],
            ['linkedin_url', null, 'string', 'social'],
            ['tiktok_url', null, 'string', 'social'],

            // Donations
            ['donation_intro', 'Your donation helps fund training, equipment, education support, and safe spaces for youth rugby.', 'string', 'donations'],
            ['donation_bank_name', null, 'string', 'donations'],
            ['donation_account_name', null, 'string', 'donations'],
            ['donation_account_number', null, 'string', 'donations'],
            ['donation_mobile_money', null, 'string', 'donations'],

            // SEO & footer
            ['meta_title', '1000 Hills Rugby | Rugby for life in Kigali, Rwanda', 'string', 'seo'],
            ['meta_description', 'Official website of 1000 Hills Rugby, a community rugby club in Kigali, Rwanda, developing players and communities on and off the field.', 'string', 'seo'],
            ['google_analytics_id', null, 'string', 'seo'],
            ['footer_text', '1000 Hills Rugby is a community rugby club in Kigali, Rwanda. Since 2014, we have used rugby to build discipline, confidence and opportunity for young people.', 'string', 'footer'],
        ];

        foreach ($settings as [$key, $value, $type, $group]) {
            Setting::put($key, $value, $type, $group);
        }

        Setting::flush();
    }
}
