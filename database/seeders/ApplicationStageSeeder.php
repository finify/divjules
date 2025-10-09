<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicationStageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stages = [
            [
                'name' => 'Application Received',
                'description' => 'Your application has been received and is awaiting review.',
                'color' => '#3b82f6',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Under Review',
                'description' => 'Your application is currently being reviewed by our admissions team.',
                'color' => '#f59e0b',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Documents Verification',
                'description' => 'We are verifying the documents you submitted with your application.',
                'color' => '#8b5cf6',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Interview Scheduled',
                'description' => 'An interview has been scheduled. You will receive details via email.',
                'color' => '#06b6d4',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Decision Pending',
                'description' => 'Your application is in the final stages. A decision will be made soon.',
                'color' => '#6366f1',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Accepted',
                'description' => 'Congratulations! Your application has been accepted.',
                'color' => '#10b981',
                'order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'Rejected',
                'description' => 'Unfortunately, your application was not successful at this time.',
                'color' => '#ef4444',
                'order' => 7,
                'is_active' => true,
            ],
            [
                'name' => 'Waitlisted',
                'description' => 'Your application has been placed on the waitlist.',
                'color' => '#f97316',
                'order' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($stages as $stage) {
            \App\Models\ApplicationStage::create($stage);
        }
    }
}
