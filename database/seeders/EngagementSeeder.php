<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\ContactMessage;
use App\Models\Donation;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class EngagementSeeder extends Seeder
{
    public function run(): void
    {
        $messages = [
            [
                'name' => 'Aline Mukamana',
                'email' => 'aline.mukamana@example.com',
                'phone' => '+250 788 123 456',
                'subject' => 'My daughter would like to join the U16 girls',
                'message' => 'Good afternoon. My daughter is 14 years old and would like to start rugby. Could you tell me when the U16 girls train and what she needs to bring to her first session? Thank you.',
                'is_read' => false,
                'created_at' => now()->subHours(6),
            ],
            [
                'name' => 'Patrick Nkurunziza',
                'email' => 'patrick.nk@example.com',
                'phone' => '+250 782 664 210',
                'subject' => 'Partnership enquiry',
                'message' => 'Hello, we are a local business interested in supporting youth sport in Kigali. Could you share more information about partnership opportunities with 1000 Hills Rugby?',
                'is_read' => false,
                'created_at' => now()->subDays(1),
            ],
            [
                'name' => 'Grace Uwera',
                'email' => 'grace.uwera@example.com',
                'phone' => null,
                'subject' => 'Volunteering at events',
                'message' => 'I would love to volunteer at your next community event. I have experience in event coordination and first aid. Please let me know how I can help.',
                'is_read' => true,
                'created_at' => now()->subDays(4),
            ],
            [
                'name' => 'Eric Habimana',
                'email' => 'eric.habimana@example.com',
                'phone' => '+250 787 554 118',
                'subject' => 'Match tickets for Saturday',
                'message' => 'Good morning. Are tickets available for this Saturday\'s match at Don Bosco Gatenga? What time do gates open?',
                'is_read' => true,
                'created_at' => now()->subDays(8),
            ],
        ];

        foreach ($messages as $message) {
            ContactMessage::updateOrCreate(
                ['email' => $message['email'], 'subject' => $message['subject']],
                $message
            );
        }

        $donations = [
            [
                'reference' => '1HR-DON-1001',
                'name' => 'Anonymous Supporter',
                'email' => 'supporter1@example.com',
                'phone' => '+250 788 000 111',
                'amount' => 150000,
                'currency' => 'RWF',
                'purpose' => 'Academy equipment',
                'message' => 'Keep up the great work with the young players.',
                'status' => 'COMPLETED',
                'payment_status' => 'COMPLETED',
                'payment_method' => 'MTN Mobile Money',
                'confirmation_code' => 'MPESA-88421',
                'paid_at' => now()->subDays(2),
            ],
            [
                'reference' => '1HR-DON-1002',
                'name' => 'Claudine Uwase',
                'email' => 'claudine.uwase@example.com',
                'phone' => '+250 782 333 444',
                'amount' => 50000,
                'currency' => 'RWF',
                'purpose' => 'Education support',
                'message' => 'For school materials for the players.',
                'status' => 'COMPLETED',
                'payment_status' => 'COMPLETED',
                'payment_method' => 'Airtel Money',
                'confirmation_code' => 'AIRTEL-55210',
                'paid_at' => now()->subDays(6),
            ],
            [
                'reference' => '1HR-DON-1003',
                'name' => 'Kigali Rugby Friends',
                'email' => 'friends@example.com',
                'phone' => null,
                'amount' => 500000,
                'currency' => 'RWF',
                'purpose' => 'General club fund',
                'message' => 'A contribution from our supporters group.',
                'status' => 'PENDING',
                'payment_status' => 'PENDING',
                'payment_method' => 'Bank transfer',
            ],
            [
                'reference' => '1HR-DON-1004',
                'name' => 'David Mugisha',
                'email' => 'david.mugisha@example.com',
                'phone' => '+250 789 777 888',
                'amount' => 20000,
                'currency' => 'RWF',
                'purpose' => 'Community programmes',
                'message' => 'Small contribution, big support.',
                'status' => 'COMPLETED',
                'payment_status' => 'COMPLETED',
                'payment_method' => 'MTN Mobile Money',
                'confirmation_code' => 'MPESA-99102',
                'paid_at' => now()->subDays(12),
            ],
            [
                'reference' => '1HR-DON-1005',
                'name' => 'Test Donor',
                'email' => 'test.donor@example.com',
                'phone' => null,
                'amount' => 10000,
                'currency' => 'RWF',
                'purpose' => 'General club fund',
                'status' => 'FAILED',
                'payment_status' => 'FAILED',
                'payment_method' => 'Card',
                'message' => 'Payment could not be completed.',
            ],
        ];

        foreach ($donations as $donation) {
            Donation::updateOrCreate(
                ['reference' => $donation['reference']],
                $donation + [
                    'original_amount' => $donation['amount'],
                    'original_currency' => 'RWF',
                    'fx_rate_to_rwf' => 1,
                ]
            );
        }

        $subscribers = [
            'aline.mukamana@example.com',
            'patrick.nk@example.com',
            'grace.uwera@example.com',
            'eric.habimana@example.com',
            'claudine.uwase@example.com',
            'david.mugisha@example.com',
            'friends@example.com',
        ];

        foreach ($subscribers as $email) {
            Subscriber::updateOrCreate(['email' => $email], ['is_active' => true]);
        }

        $admin = User::where('role', 'admin')->first();
        $editor = User::where('role', 'editor')->first();

        $activity = [
            ['user' => $admin, 'action' => 'created', 'subject_type' => 'App\\Models\\Article', 'subject_id' => 1, 'description' => 'Published article: Excite News For SHALOM Our Safeguarding Officer', 'created_at' => now()->subDays(1)],
            ['user' => $admin, 'action' => 'updated', 'subject_type' => 'App\\Models\\Fixture', 'subject_id' => 1, 'description' => 'Updated fixture: 1000 Hills Rugby vs Lions De Fer', 'created_at' => now()->subDays(2)],
            ['user' => $editor, 'action' => 'created', 'subject_type' => 'App\\Models\\Event', 'subject_id' => 1, 'description' => 'Created event: Umuganda Fun Rugby', 'created_at' => now()->subDays(3)],
            ['user' => $admin, 'action' => 'updated', 'subject_type' => 'App\\Models\\Setting', 'subject_id' => null, 'description' => 'Updated site branding settings', 'created_at' => now()->subDays(5)],
            ['user' => $editor, 'action' => 'created', 'subject_type' => 'App\\Models\\Player', 'subject_id' => 1, 'description' => 'Added player: Gasore Alain Valentin', 'created_at' => now()->subDays(7)],
            ['user' => $admin, 'action' => 'created', 'subject_type' => 'App\\Models\\Sponsor', 'subject_id' => 1, 'description' => 'Added partner: RQT', 'created_at' => now()->subDays(9)],
            ['user' => $admin, 'action' => 'login', 'subject_type' => null, 'subject_id' => null, 'description' => 'Signed in to the admin panel', 'created_at' => now()->subDays(11)],
        ];

        foreach ($activity as $entry) {
            ActivityLog::create([
                'user_id' => $entry['user']?->id,
                'action' => $entry['action'],
                'subject_type' => $entry['subject_type'],
                'subject_id' => $entry['subject_id'],
                'description' => $entry['description'],
                'ip_address' => '127.0.0.1',
                'created_at' => $entry['created_at'],
                'updated_at' => $entry['created_at'],
            ]);
        }
    }
}
