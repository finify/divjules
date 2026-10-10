<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Course;
use Illuminate\Support\Str;

new
#[Layout('components.layouts.home')]
class extends Component {
    public Course $course;

    public function mount(Course $course): void
    {
        abort_unless($course->is_active, 404);
        $this->course = $course->load(['university', 'courseCategory']);
    }

    public function rendering($view): void
    {
        $c = $this->course;
        $u = $c->university;
        $view->layoutData([
            'title' => $c->name,
            'metaTitle' => "{$c->name} at {$u->name} | Divjules",
            'metaDescription' => Str::limit(strip_tags($c->description ?: "{$c->name} at {$u->name}, {$u->country}. {$c->duration}, " . ucfirst($c->level) . '. Apply with free guidance from Divjules.'), 160),
            'metaImage' => $u->cover_url,
            'breadcrumbs' => [['Courses', route('home.courses')], [$c->name, route('courses.show', $c->slug)]],
            'schema' => [array_filter([
                '@type' => 'Course',
                'name' => $c->name,
                'description' => Str::limit(strip_tags($c->description ?: $c->name), 500),
                'url' => route('courses.show', $c->slug),
                'educationalLevel' => ucfirst($c->level),
                'timeRequired' => $c->duration,
                'provider' => array_filter(['@type' => 'CollegeOrUniversity', 'name' => $u->name, 'sameAs' => $u->website, 'url' => route('universities.show', $u->slug)]),
            ])],
        ]);
    }

    public function with(): array
    {
        return [
            'moreAtUni' => Course::active()->with(['university', 'courseCategory'])
                ->where('university_id', $this->course->university_id)->whereKeyNot($this->course->id)->ordered()->limit(3)->get(),
            'similar' => Course::active()->with(['university', 'courseCategory'])
                ->where('course_category_id', $this->course->course_category_id)->where('level', $this->course->level)
                ->where('university_id', '!=', $this->course->university_id)->inRandomOrder()->limit(3)->get(),
        ];
    }
}; ?>

@php
    $c = $course; $u = $c->university;
    $levelLabel = ['undergraduate' => 'Undergraduate', 'postgraduate' => 'Postgraduate', 'diploma' => 'Diploma', 'certificate' => 'Graduate certificate'][$c->level] ?? ucfirst($c->level);
    $facts = array_filter([
        ['fa-layer-group', 'Level', $levelLabel],
        ['fa-clock', 'Duration', $c->duration],
        ['fa-person-chalkboard', 'Study mode', $c->mode_of_study ?: 'Full-time'],
        ['fa-wallet', 'Tuition', $c->tuition_fee ? $c->formatted_tuition_fee : 'Ask a counsellor'],
        $c->intake_start ? ['fa-calendar', 'Next intake', $c->intake_start->format('F Y')] : null,
        ['fa-location-dot', 'Location', ($u->city ? $u->city . ', ' : '') . $u->country],
    ]);
@endphp

<div>
    <section style="--hero-img: url('{{ $u->cover_url }}')" class="page-hero pt-36 md:pt-44 pb-16 md:pb-24 px-4">
        <div class="max-w-7xl mx-auto text-white">
            <nav class="text-sm text-white/60 mb-8" aria-label="Breadcrumb">
                <a href="{{ route('home.index') }}" class="hover:text-white">Home</a>
                <i class="fas fa-chevron-right text-[10px] mx-2"></i>
                <a href="{{ route('home.courses') }}" class="hover:text-white">Courses</a>
                <i class="fas fa-chevron-right text-[10px] mx-2"></i>
                <span class="text-white/90">{{ $c->name }}</span>
            </nav>
            <div class="flex flex-wrap gap-2 mb-5">
                <span class="uni-chip"><i class="fas fa-{{ $c->courseCategory->icon ?? 'graduation-cap' }}"></i>{{ $c->courseCategory->name ?? 'Course' }}</span>
                <span class="uni-chip">{{ $levelLabel }}</span>
            </div>
            <h1 class="!text-left !mx-0 max-w-4xl" style="font-size: clamp(2.2rem, 5vw, 4rem);">{{ $c->name }}</h1>
            <p class="!mx-0 mt-4 text-white/75 text-lg">
                at <a href="{{ route('universities.show', $u->slug) }}" class="text-white underline decoration-sky-400/60 underline-offset-4 hover:decoration-sky-300">{{ $u->name }}</a>
                · {{ $u->city ? $u->city . ', ' : '' }}{{ $u->country }}
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('home.apply') }}" class="btn btn-light" data-magnetic>Apply for this course <i class="fas fa-arrow-right text-xs btn-arrow"></i></a>
                <a href="{{ route('home.contact') }}" class="btn btn-outline-light">Ask a counsellor</a>
            </div>
        </div>
    </section>

    {{-- key facts strip overlapping the hero --}}
    <section class="relative z-20 -mt-10 px-4" data-no-auto>
        <dl class="max-w-7xl mx-auto surface rounded-3xl grid grid-cols-2 md:grid-cols-3 {{ count($facts) === 6 ? 'lg:grid-cols-6' : 'lg:grid-cols-5' }} overflow-hidden" style="box-shadow: var(--shadow-lg)">
            @foreach ($facts as [$icon, $label, $value])
                <div class="p-5 border-line {{ ! $loop->last ? 'lg:border-r' : '' }} border-b lg:border-b-0">
                    <dt class="text-xs uppercase tracking-wider text-muted"><i class="fas {{ $icon }} text-accent mr-1.5"></i>{{ $label }}</dt>
                    <dd class="mt-1.5 font-semibold text-ink">{{ $value }}</dd>
                </div>
            @endforeach
        </dl>
    </section>

    <section class="py-16 md:py-24 px-4" data-no-auto>
        <div class="max-w-7xl mx-auto grid lg:grid-cols-12 gap-10">
            <div class="lg:col-span-8 space-y-14">
                <div data-reveal>
                    <span class="eyebrow">Overview</span>
                    <h2 class="h-display text-3xl md:text-4xl mt-4">About this course</h2>
                    <div class="mt-5 text-lg text-muted leading-relaxed prose-content">{!! nl2br(e(strip_tags($c->description ?: "{$c->name} at {$u->name}."))) !!}</div>
                </div>

                @if (! empty($c->entry_requirements))
                    <div data-reveal>
                        <h2 class="h-display text-2xl md:text-3xl">Entry requirements</h2>
                        <ul class="mt-6 space-y-3">
                            @foreach ($c->entry_requirements as $req)
                                <li class="flex gap-3 surface rounded-2xl px-5 py-4 !shadow-none">
                                    <i class="fas fa-circle-check text-accent mt-1"></i><span class="text-ink">{{ is_array($req) ? ($req['requirement'] ?? reset($req)) : $req }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <p class="mt-4 text-sm text-muted">Requirements vary by applicant and change over time — a counsellor will confirm what applies to you.</p>
                    </div>
                @endif

                @if (! empty($c->career_prospects))
                    <div data-reveal>
                        <h2 class="h-display text-2xl md:text-3xl">Career prospects</h2>
                        <div class="mt-6 flex flex-wrap gap-2">
                            @foreach ($c->career_prospects as $career)
                                <span class="chip !cursor-default"><i class="fas fa-briefcase text-accent text-xs"></i>{{ is_array($career) ? ($career['career'] ?? reset($career)) : $career }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <aside class="lg:col-span-4">
                <div class="lg:sticky lg:top-28 space-y-5">
                    <div data-reveal><x-university-card :university="$u" /></div>
                    <div class="card brand-band !bg-[#1a1a4e] !border-transparent text-white" data-reveal>
                        <h3 class="text-xl font-semibold">Ready to apply?</h3>
                        <p class="mt-2 text-white/70 text-sm">We'll review your documents, help with your personal statement and guide you through the student visa — at no cost.</p>
                        <a href="{{ route('home.apply') }}" class="btn btn-light w-full mt-5">Start your application</a>
                        <a href="{{ route('home.contact') }}" class="btn btn-outline-light w-full mt-3">Book a free consultation</a>
                    </div>
                </div>
            </aside>
        </div>
    </section>

    @foreach ([['More courses at ' . $u->name, $moreAtUni], ['Similar courses elsewhere', $similar]] as [$heading, $list])
        @if ($list->count())
            <section class="py-20 px-4 {{ $loop->first ? 'bg-page-alt' : '' }}" data-no-auto>
                <div class="max-w-7xl mx-auto">
                    <h2 class="h-display text-3xl md:text-4xl mb-8" data-reveal>{{ $heading }}</h2>
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($list as $item)
                            <div data-reveal><x-course-card :course="$item" /></div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    @endforeach
</div>
