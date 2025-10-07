<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\School;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schools = [
            [
                'name' => 'University of Oxford',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/ff/Oxford-University-Circlet.svg/200px-Oxford-University-Circlet.svg.png',
                'country' => 'United Kingdom',
                'website_url' => 'https://www.ox.ac.uk',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'University of Cambridge',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/8b/University_of_Cambridge_logo.svg/200px-University_of_Cambridge_logo.svg.png',
                'country' => 'United Kingdom',
                'website_url' => 'https://www.cam.ac.uk',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Imperial College London',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/8c/Imperial_College_London_coat_of_arms.svg/200px-Imperial_College_London_coat_of_arms.svg.png',
                'country' => 'United Kingdom',
                'website_url' => 'https://www.imperial.ac.uk',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'London School of Economics',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f6/LSE_logo.svg/200px-LSE_logo.svg.png',
                'country' => 'United Kingdom',
                'website_url' => 'https://www.lse.ac.uk',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'University College London',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/43/University_College_London_logo.svg/200px-University_College_London_logo.svg.png',
                'country' => 'United Kingdom',
                'website_url' => 'https://www.ucl.ac.uk',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'University of Edinburgh',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b7/University_of_Edinburgh_ceremonial_roundel.svg/200px-University_of_Edinburgh_ceremonial_roundel.svg.png',
                'country' => 'United Kingdom',
                'website_url' => 'https://www.ed.ac.uk',
                'order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($schools as $school) {
            School::create($school);
        }
    }
}
