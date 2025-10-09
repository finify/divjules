<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contacts = [
            [
                'key' => 'email',
                'label' => 'Email Address',
                'value' => 'info@divjules.com',
                'icon' => 'heroicon-o-envelope',
                'type' => 'email',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'key' => 'phone',
                'label' => 'Phone Number',
                'value' => '+1 (555) 123-4567',
                'icon' => 'heroicon-o-phone',
                'type' => 'phone',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'key' => 'whatsapp',
                'label' => 'WhatsApp',
                'value' => '+1 (555) 123-4567',
                'icon' => 'heroicon-o-chat-bubble-left-right',
                'type' => 'phone',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'key' => 'address',
                'label' => 'Office Address',
                'value' => "123 Education Lane\nCity, State 12345\nCountry",
                'icon' => 'heroicon-o-map-pin',
                'type' => 'address',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'key' => 'website',
                'label' => 'Website',
                'value' => 'https://divjules.com',
                'icon' => 'heroicon-o-globe-alt',
                'type' => 'url',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'key' => 'support_email',
                'label' => 'Support Email',
                'value' => 'support@divjules.com',
                'icon' => 'heroicon-o-envelope',
                'type' => 'email',
                'order' => 6,
                'is_active' => true,
            ],
            [
                'key' => 'business_hours',
                'label' => 'Business Hours',
                'value' => 'Monday - Friday: 9:00 AM - 5:00 PM',
                'icon' => 'heroicon-o-clock',
                'type' => 'text',
                'order' => 7,
                'is_active' => true,
            ],
        ];

        foreach ($contacts as $contact) {
            \App\Models\ContactDetail::updateOrCreate(
                ['key' => $contact['key']],
                $contact
            );
        }
    }
}
