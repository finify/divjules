<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VideoTestimonial;

class VideoTestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'student_name' => 'Sarah Johnson',
                'course' => 'MSc Computer Science',
                'university' => 'UCL',
                'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'rating' => 5,
                'quote' => 'An incredible journey from application to acceptance!',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'student_name' => 'Michael Chen',
                'course' => 'MBA',
                'university' => 'Cambridge University',
                'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'rating' => 5,
                'quote' => 'Professional guidance that made all the difference!',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'student_name' => 'Priya Patel',
                'course' => 'BSc Engineering',
                'university' => 'Imperial College',
                'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'rating' => 5,
                'quote' => 'They supported me every step of the way!',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'student_name' => 'David Okonkwo',
                'course' => 'MSc Data Science',
                'university' => 'Oxford',
                'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'rating' => 5,
                'quote' => 'Dream university, thanks to Divjules team!',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'student_name' => 'Emma Williams',
                'course' => 'LLB Law',
                'university' => 'LSE',
                'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'rating' => 5,
                'quote' => 'Outstanding service and support throughout!',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'student_name' => 'James Rodriguez',
                'course' => 'MSc Finance',
                'university' => 'Edinburgh',
                'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'rating' => 5,
                'quote' => 'Best decision to work with Divjules!',
                'order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            VideoTestimonial::create($testimonial);
        }
    }
}
