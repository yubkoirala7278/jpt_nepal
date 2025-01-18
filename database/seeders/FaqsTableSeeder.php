<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaqsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faqs = [
            [
                'slug' => 'how-to-use-app',
                'question' => 'How do I use this app?',
                'answer' => 'To use this app, simply sign up, log in, and start navigating through the features.',
            ],
            [
                'slug' => 'reset-password',
                'question' => 'How can I reset my password?',
                'answer' => 'To reset your password, click on "Forgot Password" at the login screen and follow the instructions.',
            ],
            [
                'slug' => 'account-settings',
                'question' => 'How can I update my account settings?',
                'answer' => 'Go to your profile page, then select "Account Settings" to update your personal information.',
            ],
            [
                'slug' => 'contact-support',
                'question' => 'How do I contact support?',
                'answer' => 'You can reach support by visiting the "Contact Us" page and submitting a query.',
            ],
        ];

        // Insert the FAQs into the database
        DB::table('faqs')->insert($faqs);
    }
}
