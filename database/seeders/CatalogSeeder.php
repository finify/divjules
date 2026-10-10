<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\School;
use App\Models\University;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Adds a starter catalogue of universities, courses and partner schools.
 *
 * Safe to run on every deploy: it only creates records that don't exist yet
 * (matched by slug / name) and never overwrites anything edited in the admin.
 * A marker file stops it re-creating records an admin has deliberately deleted.
 */
class CatalogSeeder extends Seeder
{
    private const MARKER = 'catalog-seeded-v1';

    public function run(): void
    {
        if (Storage::disk('local')->exists(self::MARKER)) {
            $this->command?->info('Catalog already seeded — skipping.');
            return;
        }

        $categories = $this->categories();

        foreach ($this->universities() as $order => $u) {
            [$name, $country, $city, $type, $website, $description, $features, $courses] = $u;

            $university = University::firstOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'country' => $country,
                    'city' => $city,
                    'type' => $type,
                    'website' => $website,
                    'description' => $description,
                    'features' => $features,
                    'order' => 100 + $order,
                    'is_active' => true,
                    'is_featured' => $order < 6,
                ]
            );

            School::firstOrCreate(
                ['name' => $name],
                ['country' => $country, 'website_url' => $website, 'order' => 100 + $order, 'is_active' => true]
            );

            foreach ($courses as $i => [$courseName, $categorySlug, $level, $duration, $mode]) {
                $category = $categories[$categorySlug] ?? null;
                if (! $category) {
                    continue;
                }

                Course::firstOrCreate(
                    ['slug' => Str::slug($courseName . ' ' . $university->slug)],
                    [
                        'university_id' => $university->id,
                        'course_category_id' => $category->id,
                        'name' => $courseName,
                        'description' => $this->courseDescription($courseName, $university->name, $city, $country, $level, $duration),
                        'level' => $level,
                        'duration' => $duration,
                        'currency' => $this->currency($country),
                        'mode_of_study' => $mode,
                        'entry_requirements' => $this->requirements($level),
                        'career_prospects' => $this->careers($categorySlug),
                        'order' => $i,
                        'is_active' => true,
                        'is_featured' => $i === 0 && $order < 8,
                    ]
                );
            }
        }

        Storage::disk('local')->put(self::MARKER, now()->toIso8601String());
    }

    /** @return array<string, CourseCategory> */
    private function categories(): array
    {
        $defs = [
            'business-management' => ['Business & Management', 'MBA, Finance, Marketing, Entrepreneurship', 'briefcase', '#3b82f6'],
            'computing-it' => ['Computing & IT', 'Computer Science, Data Science, AI, Software Engineering', 'laptop-code', '#10b981'],
            'engineering' => ['Engineering', 'Mechanical, Civil, Electrical, Chemical Engineering', 'cogs', '#f97316'],
            'health-sciences' => ['Health Sciences', 'Medicine, Nursing, Pharmacy, Public Health', 'heartbeat', '#ef4444'],
            'law' => ['Law', 'LLB, Corporate Law, International Law', 'balance-scale', '#0369a1'],
            'arts-humanities' => ['Arts & Humanities', 'Design, Media, Languages', 'palette', '#ec4899'],
            'science' => ['Science', 'Physics, Chemistry, Biology', 'flask', '#eab308'],
            'education' => ['Education', 'Teaching, Training, Development', 'graduation-cap', '#1a1a4e'],
        ];

        $out = [];
        $order = 1;
        foreach ($defs as $slug => [$name, $desc, $icon, $color]) {
            $out[$slug] = CourseCategory::where('slug', $slug)->orWhere('name', $name)->first()
                ?? CourseCategory::create(['name' => $name, 'slug' => $slug, 'description' => $desc, 'icon' => $icon, 'color' => $color, 'order' => $order, 'is_active' => true]);
            $order++;
        }

        return $out;
    }

    private function currency(string $country): string
    {
        return match ($country) {
            'United Kingdom' => 'GBP',
            'Canada' => 'CAD',
            'Australia' => 'AUD',
            'Germany', 'Ireland' => 'EUR',
            'United Arab Emirates' => 'AED',
            default => 'USD',
        };
    }

    private function courseDescription(string $course, string $uni, string $city, string $country, string $level, string $duration): string
    {
        $levelText = match ($level) {
            'postgraduate' => 'postgraduate programme',
            'diploma' => 'diploma programme',
            'certificate' => 'graduate certificate',
            default => 'undergraduate degree',
        };

        return "{$course} at {$uni} is a {$duration} {$levelText} taught in {$city}, {$country}. "
            . 'It combines core theory with practical, career-focused learning, and Divjules counsellors can guide you through '
            . 'course selection, your application, scholarships and the student visa process.';
    }

    private function requirements(string $level): array
    {
        return match ($level) {
            'postgraduate' => [
                "A recognised bachelor's degree (typically second class or equivalent)",
                'IELTS Academic 6.5 overall (or equivalent English test)',
                'Personal statement and academic references',
                'Updated CV — relevant work experience is an advantage',
            ],
            'certificate' => [
                'A completed diploma or degree in a related field',
                'IELTS Academic 6.5 overall (or equivalent)',
                'Official transcripts',
            ],
            'diploma' => [
                'Senior secondary school certificate (WAEC/NECO or equivalent)',
                'IELTS Academic 6.0 overall (or equivalent)',
                'Official transcripts',
            ],
            default => [
                'Senior secondary school certificate (WAEC/NECO or equivalent) with credits in relevant subjects',
                'IELTS Academic 6.0 overall (or equivalent English test)',
                'Personal statement and one academic reference',
            ],
        };
    }

    private function careers(string $category): array
    {
        return match ($category) {
            'business-management' => ['Business Analyst', 'Project Manager', 'Marketing Manager', 'Financial Analyst'],
            'computing-it' => ['Software Developer', 'Data Analyst', 'Cyber Security Analyst', 'Cloud Engineer'],
            'engineering' => ['Mechanical Engineer', 'Civil Engineer', 'Project Engineer', 'Design Engineer'],
            'health-sciences' => ['Registered Nurse', 'Public Health Officer', 'Healthcare Manager', 'Clinical Researcher'],
            'law' => ['Legal Adviser', 'Solicitor (with further training)', 'Compliance Officer', 'Policy Analyst'],
            'arts-humanities' => ['Graphic Designer', 'Content Strategist', 'Media Producer', 'UX Designer'],
            'science' => ['Laboratory Scientist', 'Research Assistant', 'Environmental Consultant', 'Quality Analyst'],
            default => ['Teacher', 'Education Officer', 'Learning Designer', 'Training Coordinator'],
        };
    }

    /**
     * [name, country, city, type, website, description, features, courses[]]
     * course: [name, category slug, level, duration, mode]
     */
    private function universities(): array
    {
        $ft = 'Full-time';

        $ukPg = fn (array $extra = []) => array_merge([
            ['MSc Data Science', 'computing-it', 'postgraduate', '1 year', $ft],
            ['MBA Master of Business Administration', 'business-management', 'postgraduate', '1 year', $ft],
            ['MSc Public Health', 'health-sciences', 'postgraduate', '1 year', $ft],
        ], $extra);

        return [
            // ---------------- United Kingdom ----------------
            ['Coventry University', 'United Kingdom', 'Coventry', 'public', 'https://www.coventry.ac.uk',
                'A modern, career-focused university in the heart of England, known for industry links, applied teaching and a large international student community.',
                ['Industry-linked courses', 'Large international community', 'January & September intakes', 'Modern city-centre campus'],
                $ukPg([['MSc Project Management', 'business-management', 'postgraduate', '1 year', $ft], ['BEng (Hons) Mechanical Engineering', 'engineering', 'undergraduate', '3 years', $ft]])],
            ['University of Hertfordshire', 'United Kingdom', 'Hatfield', 'public', 'https://www.herts.ac.uk',
                'A business-facing university just north of London with strong programmes in computing, engineering, health and business.',
                ['30 minutes from London', 'Strong employability record', 'Placement year options'],
                $ukPg([['MSc Cyber Security', 'computing-it', 'postgraduate', '1 year', $ft]])],
            ['University of Greenwich', 'United Kingdom', 'London', 'public', 'https://www.gre.ac.uk',
                'A London university with a historic riverside campus at Maritime Greenwich and a diverse, international student body.',
                ['Historic London campus', 'Diverse student body', 'Business, computing & health strengths'],
                [['MSc International Business', 'business-management', 'postgraduate', '1 year', $ft], ['MSc Computer Science', 'computing-it', 'postgraduate', '1 year', $ft], ['LLM International Law', 'law', 'postgraduate', '1 year', $ft]]],
            ['University of Sunderland', 'United Kingdom', 'Sunderland', 'public', 'https://www.sunderland.ac.uk',
                'A friendly university in North East England with a London campus, offering practical degrees in health, business and technology.',
                ['Affordable cost of living', 'London campus option', 'Practical, applied teaching'],
                [['MSc Nursing Studies', 'health-sciences', 'postgraduate', '1 year', $ft], ['MBA Master of Business Administration', 'business-management', 'postgraduate', '1 year', $ft], ['BSc (Hons) Pharmacology', 'science', 'undergraduate', '3 years', $ft]]],
            ['Teesside University', 'United Kingdom', 'Middlesbrough', 'public', 'https://www.tees.ac.uk',
                'A university known for digital, engineering and health courses, with a compact modern campus and low living costs.',
                ['Low living costs', 'Digital & games excellence', 'Compact modern campus'],
                [['MSc Computer Science', 'computing-it', 'postgraduate', '1 year', $ft], ['MSc Project Management', 'business-management', 'postgraduate', '1 year', $ft], ['MSc Civil Engineering', 'engineering', 'postgraduate', '1 year', $ft]]],
            ['Northumbria University', 'United Kingdom', 'Newcastle upon Tyne', 'research', 'https://www.northumbria.ac.uk',
                'A research-active university in vibrant Newcastle, with a strong reputation in business, law, design and computing.',
                ['Vibrant student city', 'Strong graduate outcomes', 'Design & law strengths'],
                [['MSc Business with Data Analytics', 'business-management', 'postgraduate', '1 year', $ft], ['LLM International Commercial Law', 'law', 'postgraduate', '1 year', $ft], ['BA (Hons) Graphic Design', 'arts-humanities', 'undergraduate', '3 years', $ft]]],
            ['De Montfort University', 'United Kingdom', 'Leicester', 'public', 'https://www.dmu.ac.uk',
                'A city-centre university in Leicester offering creative, business, health and engineering programmes.',
                ['City-centre campus', 'Creative industries focus', 'Supportive international office'],
                [['MSc Data Analytics', 'computing-it', 'postgraduate', '1 year', $ft], ['BA (Hons) Business Management', 'business-management', 'undergraduate', '3 years', $ft], ['MSc Pharmaceutical Sciences', 'science', 'postgraduate', '1 year', $ft]]],
            ['University of Leicester', 'United Kingdom', 'Leicester', 'research', 'https://le.ac.uk',
                'A research-intensive university with well-regarded programmes in medicine, law, science and management.',
                ['Research-intensive', 'Renowned for science & law', 'Campus-style university'],
                [['MSc Advanced Computer Science', 'computing-it', 'postgraduate', '1 year', $ft], ['LLB Law', 'law', 'undergraduate', '3 years', $ft], ['MSc Finance', 'business-management', 'postgraduate', '1 year', $ft]]],
            ['University of Kent', 'United Kingdom', 'Canterbury', 'research', 'https://www.kent.ac.uk',
                "Known as the UK's European university, Kent offers research-led teaching on a green campus overlooking historic Canterbury.",
                ['Green parkland campus', 'Research-led teaching', 'Close to London & Europe'],
                [['MSc Computer Science', 'computing-it', 'postgraduate', '1 year', $ft], ['MA International Relations', 'arts-humanities', 'postgraduate', '1 year', $ft], ['MSc Management', 'business-management', 'postgraduate', '1 year', $ft]]],
            ['Ulster University', 'United Kingdom', 'Belfast', 'public', 'https://www.ulster.ac.uk',
                'A university in Northern Ireland with a striking city-centre campus in Belfast and strong links to industry.',
                ['New Belfast city campus', 'Industry partnerships', 'Affordable living'],
                [['MSc Data Science', 'computing-it', 'postgraduate', '1 year', $ft], ['MSc Engineering Management', 'engineering', 'postgraduate', '1 year', $ft], ['MSc Public Health', 'health-sciences', 'postgraduate', '1 year', $ft]]],
            ['University of East London', 'United Kingdom', 'London', 'public', 'https://www.uel.ac.uk',
                'A careers-led London university with campuses in Docklands and Stratford, close to the Olympic Park.',
                ['London Docklands campus', 'Careers-led approach', 'Strong sport & health faculties'],
                [['MSc Information Technology', 'computing-it', 'postgraduate', '1 year', $ft], ['MSc Health Management', 'health-sciences', 'postgraduate', '1 year', $ft], ['MA Education', 'education', 'postgraduate', '1 year', $ft]]],

            // ---------------- Canada ----------------
            ['Seneca Polytechnic', 'Canada', 'Toronto', 'public', 'https://www.senecapolytechnic.ca',
                "One of Canada's largest polytechnics, offering career-ready diplomas, degrees and graduate certificates across the Greater Toronto Area.",
                ['Co-op & work placements', 'Graduate certificates', 'Multiple Toronto campuses'],
                [['Computer Programming and Analysis', 'computing-it', 'diploma', '3 years', $ft], ['Project Management (Graduate Certificate)', 'business-management', 'certificate', '1 year', $ft], ['Practical Nursing', 'health-sciences', 'diploma', '2 years', $ft]]],
            ['Humber Polytechnic', 'Canada', 'Toronto', 'public', 'https://humber.ca',
                'A leading polytechnic in Toronto known for hands-on learning, industry partnerships and strong graduate employment.',
                ['Hands-on learning', 'Industry partnerships', 'Two Toronto campuses'],
                [['Business Administration', 'business-management', 'diploma', '3 years', $ft], ['Cybersecurity (Graduate Certificate)', 'computing-it', 'certificate', '1 year', $ft], ['Early Childhood Education', 'education', 'diploma', '2 years', $ft]]],
            ['Conestoga College', 'Canada', 'Kitchener', 'public', 'https://www.conestogac.on.ca',
                "A polytechnic in Ontario's tech corridor, popular with international students for applied business, IT and engineering programmes.",
                ["Ontario's tech corridor", 'Applied programmes', 'Co-op options'],
                [['Information Technology Project Management', 'computing-it', 'certificate', '1 year', $ft], ['Global Business Management', 'business-management', 'certificate', '1 year', $ft], ['Mechanical Engineering Technology', 'engineering', 'diploma', '3 years', $ft]]],
            ['Fanshawe College', 'Canada', 'London, Ontario', 'public', 'https://www.fanshawec.ca',
                'One of the largest colleges in Canada, offering career-focused programmes in business, health, technology and the arts.',
                ['Large, supportive campus', 'Affordable city', 'Career-focused programmes'],
                [['Computer Systems Technician', 'computing-it', 'diploma', '2 years', $ft], ['Human Resources Management (Graduate Certificate)', 'business-management', 'certificate', '1 year', $ft], ['Pharmacy Technician', 'health-sciences', 'diploma', '2 years', $ft]]],
            ['University of Windsor', 'Canada', 'Windsor', 'public', 'https://www.uwindsor.ca',
                "A comprehensive university on the Canada–US border, well known for engineering, computer science and business.",
                ['Engineering strengths', 'Border city location', 'Graduate research options'],
                [['Master of Engineering (MEng) Electrical and Computer', 'engineering', 'postgraduate', '2 years', $ft], ['Master of Applied Computing', 'computing-it', 'postgraduate', '2 years', $ft], ['Bachelor of Commerce', 'business-management', 'undergraduate', '4 years', $ft]]],
            ['Toronto Metropolitan University', 'Canada', 'Toronto', 'public', 'https://www.torontomu.ca',
                'A downtown Toronto university known for career-ready programmes, innovation zones and close ties to industry.',
                ['Downtown Toronto', 'Innovation & startup zones', 'Career-ready degrees'],
                [['Bachelor of Commerce (Business Technology Management)', 'business-management', 'undergraduate', '4 years', $ft], ['Bachelor of Science in Nursing', 'health-sciences', 'undergraduate', '4 years', $ft], ['Master of Engineering (Civil)', 'engineering', 'postgraduate', '1 year', $ft]]],

            // ---------------- United States ----------------
            ['Arizona State University', 'United States', 'Tempe', 'research', 'https://www.asu.edu',
                'A large public research university known for innovation, engineering and business, with campuses across the Phoenix area.',
                ['Large research university', 'Innovation-focused', 'Sunny Phoenix area'],
                [['MS Computer Science', 'computing-it', 'postgraduate', '2 years', $ft], ['BS Mechanical Engineering', 'engineering', 'undergraduate', '4 years', $ft], ['MS Business Analytics', 'business-management', 'postgraduate', '1 year', $ft]]],
            ['University of South Florida', 'United States', 'Tampa', 'research', 'https://www.usf.edu',
                'A public research university in Tampa with strong programmes in health, engineering, business and data science.',
                ['Public research university', 'Health & STEM strengths', 'Florida Gulf Coast'],
                [['MS Data Science', 'computing-it', 'postgraduate', '2 years', $ft], ['Master of Public Health', 'health-sciences', 'postgraduate', '2 years', $ft], ['BS Civil Engineering', 'engineering', 'undergraduate', '4 years', $ft]]],
            ['Pace University', 'United States', 'New York', 'private', 'https://www.pace.edu',
                'A private university in Lower Manhattan offering business, computing, law and health programmes with access to New York employers.',
                ['Lower Manhattan campus', 'New York internships', 'Business & tech focus'],
                [['MBA Master of Business Administration', 'business-management', 'postgraduate', '2 years', $ft], ['MS Information Systems', 'computing-it', 'postgraduate', '2 years', $ft], ['BBA Finance', 'business-management', 'undergraduate', '4 years', $ft]]],

            // ---------------- Australia ----------------
            ['Deakin University', 'Australia', 'Melbourne', 'public', 'https://www.deakin.edu.au',
                'A modern Australian university with campuses in Melbourne and Geelong, recognised for student satisfaction and industry-ready courses.',
                ['High student satisfaction', 'Melbourne & Geelong campuses', 'Work-integrated learning'],
                [['Master of Information Technology', 'computing-it', 'postgraduate', '2 years', $ft], ['Bachelor of Nursing', 'health-sciences', 'undergraduate', '3 years', $ft], ['Master of Business Administration', 'business-management', 'postgraduate', '2 years', $ft]]],
            ['Griffith University', 'Australia', 'Gold Coast', 'public', 'https://www.griffith.edu.au',
                'A leading Queensland university with campuses on the Gold Coast and in Brisbane, strong in health, business and engineering.',
                ['Gold Coast & Brisbane', 'Health & hospitality strengths', 'Industry placements'],
                [['Master of Public Health', 'health-sciences', 'postgraduate', '2 years', $ft], ['Master of Engineering', 'engineering', 'postgraduate', '2 years', $ft], ['Bachelor of Hotel Management', 'business-management', 'undergraduate', '3 years', $ft]]],
            ['Macquarie University', 'Australia', 'Sydney', 'research', 'https://www.mq.edu.au',
                "A research university in Sydney's tech and business hub, known for business, IT, accounting and linguistics.",
                ["Sydney's innovation district", 'Research university', 'Strong business school'],
                [['Master of Professional Accounting', 'business-management', 'postgraduate', '2 years', $ft], ['Master of Data Science', 'computing-it', 'postgraduate', '2 years', $ft], ['Bachelor of Laws', 'law', 'undergraduate', '4 years', $ft]]],
            ['Western Sydney University', 'Australia', 'Sydney', 'public', 'https://www.westernsydney.edu.au',
                'A multi-campus university across Greater Western Sydney, offering practical degrees in health, education, IT and business.',
                ['Multi-campus Sydney', 'Health & education focus', 'Practical degrees'],
                [['Bachelor of Nursing', 'health-sciences', 'undergraduate', '3 years', $ft], ['Master of Teaching (Secondary)', 'education', 'postgraduate', '2 years', $ft], ['Master of Information and Communications Technology', 'computing-it', 'postgraduate', '2 years', $ft]]],

            // ---------------- Germany ----------------
            ['IU International University of Applied Sciences', 'Germany', 'Berlin', 'private', 'https://www.iu.org',
                "Germany's largest university by enrolment, offering English-taught business, IT and engineering degrees with flexible start dates.",
                ['English-taught degrees', 'Flexible start dates', 'Campuses across Germany'],
                [['MSc Computer Science', 'computing-it', 'postgraduate', '2 years', $ft], ['MBA International Management', 'business-management', 'postgraduate', '1 year', $ft], ['BSc Data Science', 'computing-it', 'undergraduate', '3 years', $ft]]],
            ['Berlin School of Business and Innovation', 'Germany', 'Berlin', 'private', 'https://www.berlinsbi.com',
                'A private business school in central Berlin offering English-taught business, data and digital programmes.',
                ['Central Berlin location', 'English-taught', 'Business & digital focus'],
                [['MSc Data Analytics', 'computing-it', 'postgraduate', '1 year', $ft], ['MA Innovation and Entrepreneurship', 'business-management', 'postgraduate', '1 year', $ft]]],
            ['SRH University', 'Germany', 'Berlin', 'private', 'https://www.srh-university.de',
                'A private university known for its practice-oriented CORE teaching model and English-taught programmes in Berlin and Heidelberg.',
                ['Practice-oriented teaching', 'Small class sizes', 'English-taught masters'],
                [['MSc Computer Science', 'computing-it', 'postgraduate', '2 years', $ft], ['MBA International Business', 'business-management', 'postgraduate', '1 year', $ft], ['MEng Mechanical Engineering', 'engineering', 'postgraduate', '2 years', $ft]]],

            // ---------------- Ireland ----------------
            ['Dublin Business School', 'Ireland', 'Dublin', 'private', 'https://www.dbs.ie',
                "Ireland's largest independent third-level institution, in Dublin city centre, offering business, IT and psychology programmes.",
                ['Dublin city centre', 'Business & IT focus', 'Career-oriented'],
                [['MSc Data Analytics', 'computing-it', 'postgraduate', '1 year', $ft], ['MBA Master of Business Administration', 'business-management', 'postgraduate', '1 year', $ft]]],
            ['Griffith College', 'Ireland', 'Dublin', 'private', 'https://www.griffith.ie',
                'An independent college in Dublin with programmes in business, computing, law and design.',
                ['Dublin campus', 'Law, computing & design', 'Small classes'],
                [['MSc Computing', 'computing-it', 'postgraduate', '1 year', $ft], ['LLM International Law', 'law', 'postgraduate', '1 year', $ft]]],
            ['University of Limerick', 'Ireland', 'Limerick', 'public', 'https://www.ul.ie',
                'A public university on a riverside campus, known for engineering, science and its cooperative education programme.',
                ['Riverside campus', 'Co-operative education', 'Engineering & science strengths'],
                [['MEng Mechanical Engineering', 'engineering', 'postgraduate', '1 year', $ft], ['MSc Software Engineering', 'computing-it', 'postgraduate', '1 year', $ft], ['MSc Nursing', 'health-sciences', 'postgraduate', '1 year', $ft]]],

            // ---------------- United Arab Emirates ----------------
            ['Middlesex University Dubai', 'United Arab Emirates', 'Dubai', 'private', 'https://www.mdx.ac.ae',
                "The Dubai campus of the UK's Middlesex University, offering UK-awarded degrees in Dubai Knowledge Park.",
                ['UK-awarded degrees', 'Dubai Knowledge Park', 'Close to home'],
                [['MBA Master of Business Administration', 'business-management', 'postgraduate', '1 year', $ft], ['BSc (Hons) Computer Science', 'computing-it', 'undergraduate', '3 years', $ft], ['BA (Hons) Media and Communication', 'arts-humanities', 'undergraduate', '3 years', $ft]]],
            ['Heriot-Watt University Dubai', 'United Arab Emirates', 'Dubai', 'private', 'https://www.hw.ac.uk/dubai',
                "The Dubai campus of Edinburgh's Heriot-Watt University, strong in engineering, business and computing.",
                ['Scottish-awarded degrees', 'Dubai Knowledge Park', 'Engineering & business'],
                [['MSc Engineering Management', 'engineering', 'postgraduate', '1 year', $ft], ['MSc International Business Management', 'business-management', 'postgraduate', '1 year', $ft], ['BSc (Hons) Computer Science', 'computing-it', 'undergraduate', '4 years', $ft]]],
            ['University of Wollongong in Dubai', 'United Arab Emirates', 'Dubai', 'private', 'https://www.uowdubai.ac.ae',
                "The Dubai campus of Australia's University of Wollongong, offering business, IT and engineering degrees.",
                ['Australian-awarded degrees', 'Dubai Knowledge Park', 'Business & IT focus'],
                [['Master of Business Administration', 'business-management', 'postgraduate', '18 months', $ft], ['Bachelor of Computer Science', 'computing-it', 'undergraduate', '3 years', $ft]]],
        ];
    }
}
