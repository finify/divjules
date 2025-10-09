<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CourseCategory;

class CourseCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Business & Management',
                'slug' => 'business-management',
                'description' => 'MBA, Finance, Marketing, Entrepreneurship',
                'icon' => 'briefcase',
                'color' => '#3b82f6', // blue
                'order' => 1,
            ],
            [
                'name' => 'Computing & IT',
                'slug' => 'computing-it',
                'description' => 'Computer Science, Data Science, AI, Software Engineering',
                'icon' => 'laptop-code',
                'color' => '#10b981', // green
                'order' => 2,
            ],
            [
                'name' => 'Engineering',
                'slug' => 'engineering',
                'description' => 'Mechanical, Civil, Electrical, Chemical Engineering',
                'icon' => 'cogs',
                'color' => '#f97316', // orange
                'order' => 3,
            ],
            [
                'name' => 'Health Sciences',
                'slug' => 'health-sciences',
                'description' => 'Medicine, Nursing, Pharmacy, Public Health',
                'icon' => 'heartbeat',
                'color' => '#ef4444', // red
                'order' => 4,
            ],
            [
                'name' => 'Law',
                'slug' => 'law',
                'description' => 'LLB, Corporate Law, International Law',
                'icon' => 'balance-scale',
                'color' => '#9333ea', // purple
                'order' => 5,
            ],
            [
                'name' => 'Arts & Humanities',
                'slug' => 'arts-humanities',
                'description' => 'Design, Media, Languages, History',
                'icon' => 'palette',
                'color' => '#ec4899', // pink
                'order' => 6,
            ],
            [
                'name' => 'Science',
                'slug' => 'science',
                'description' => 'Physics, Chemistry, Biology, Mathematics',
                'icon' => 'flask',
                'color' => '#eab308', // yellow
                'order' => 7,
            ],
            [
                'name' => 'Education',
                'slug' => 'education',
                'description' => 'Teaching, Training, Development',
                'icon' => 'graduation-cap',
                'color' => '#6366f1', // indigo
                'order' => 8,
            ],
        ];

        foreach ($categories as $category) {
            CourseCategory::create($category);
        }
    }
}
