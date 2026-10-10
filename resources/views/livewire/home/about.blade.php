<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};
use App\Models\TeamMember;
use Illuminate\Support\Facades\Storage;

new
#[Layout('components.layouts.home')]
#[Title('About Us')]
class extends Component {
    public $teamMembers = [];

    public function mount(): void
    {
        $this->teamMembers = TeamMember::active()->ordered()->get();
    }
}; ?>

@php
    $values = [
        ['fa-handshake', 'Integrity', 'We maintain the highest standards of honesty and transparency in all our interactions with students and partners.', 'consultation'],
        ['fa-star', 'Excellence', 'We strive for excellence in every aspect of our service delivery and continuously improve our offerings.', 'graduate-gown'],
        ['fa-users', 'Student-centric', 'Every decision we make prioritises the best interests and success of our students.', 'students-friends'],
        ['fa-lightbulb', 'Innovation', 'We embrace new technologies and methods to enhance the student experience and service quality.', 'students-laptop'],
        ['fa-globe', 'Global perspective', 'We foster cultural understanding and prepare students for success in an interconnected world.', 'dest-uk'],
        ['fa-heart', 'Commitment', 'We are dedicated to supporting our students throughout their entire educational journey.', 'cap-toss'],
    ];
    $services = [
        ['fa-comments', 'Free consultation', 'An honest conversation about your goals, grades and budget.'],
        ['fa-building-columns', 'University selection', 'A shortlist of courses and universities that genuinely fit you.'],
        ['fa-file-signature', 'Application support', 'Personal statements, documents and submissions, done right.'],
        ['fa-passport', 'Visa assistance', 'Document preparation, application review and interview prep.'],
        ['fa-plane-departure', 'Pre-departure briefing', 'Accommodation, travel and what to expect when you land.'],
    ];
@endphp

<div>
    <section style="--hero-img: url('/homeassets/img/site/study-group.webp')" class="page-hero pt-40 md:pt-52 pb-28 md:pb-40 px-4">
        <div class="max-w-5xl mx-auto text-center text-white">
            <span class="eyebrow !text-sky-300 justify-center">About Divjules</span>
            <h1 class="mt-5">We help students go further.</h1>
            <p class="mt-5 text-xl">Empowering students to achieve their global education dreams.</p>
        </div>
    </section>

    {{-- Story --}}
    <section class="py-24 lg:py-36 px-4" data-no-auto>
        <div class="max-w-7xl mx-auto grid lg:grid-cols-12 gap-12 lg:gap-16 items-start">
            <div class="lg:col-span-7">
                <span class="eyebrow" data-reveal>Our story</span>
                <p class="mt-6 text-3xl md:text-[2.6rem] leading-[1.2] font-semibold tracking-tight text-ink" data-text-fill>
                    Founded with a vision to make international education accessible to students worldwide, Divjules has been at the forefront of educational consulting for over a decade.
                </p>
                <div class="mt-10 grid md:grid-cols-2 gap-8 text-lg text-muted leading-relaxed">
                    <p data-reveal>We understand that choosing the right university and course is one of the most important decisions in a student's life. That's why we're committed to providing personalised, expert guidance every step of the way.</p>
                    <p data-reveal>With a global network of partner institutions and a team of experienced counsellors, we've helped thousands of students transform their educational aspirations into reality.</p>
                </div>
            </div>
            <div class="lg:col-span-5 relative h-[460px] md:h-[560px]">
                <figure class="absolute top-0 right-0 w-[78%] h-[68%] rounded-[28px] overflow-hidden shadow-[var(--shadow-lg)]" data-clip-reveal data-speed="-0.25">
                    <img src="/homeassets/img/site/study-group.webp" alt="Students studying together" class="w-full h-full object-cover">
                </figure>
                <figure class="absolute bottom-0 left-0 w-[58%] h-[50%] rounded-[28px] overflow-hidden shadow-[var(--shadow-lg)] ring-8 ring-[var(--bg)]" data-clip-reveal="left" data-speed="0.3">
                    <img src="/homeassets/img/site/graduate-gown.webp" alt="A graduate in cap and gown" class="w-full h-full object-cover">
                </figure>
                <div class="collage-badge flex !left-auto right-2 bottom-[38%]" data-speed="0.6">
                    <span class="grid place-items-center w-10 h-10 rounded-full bg-[var(--accent)] text-white"><i class="fas fa-earth-africa"></i></span>
                    <div><p class="text-sm font-semibold text-ink leading-tight">15+ countries</p><p class="text-xs text-muted">one team guiding you</p></div>
                </div>
            </div>
        </div>
    </section>

    {{-- Numbers --}}
    <section class="px-4" data-no-auto>
        <div class="max-w-7xl mx-auto brand-band rounded-[2rem] text-white grid grid-cols-2 lg:grid-cols-4 overflow-hidden"
            style="background: radial-gradient(60% 100% at 100% 0%, rgba(3,105,161,.5), transparent 70%), linear-gradient(135deg, #1a1a4e, #0f0f2e);">
            @foreach ([[150, '+', 'Partner universities'], [15, '+', 'Countries'], [10000, '+', 'Students placed'], [500, '+', 'Expert counsellors']] as [$n, $sfx, $label])
                <div class="p-8 md:p-12 border-white/10 {{ $loop->index % 2 === 0 ? 'border-r' : '' }} {{ $loop->index < 2 ? 'border-b lg:border-b-0' : '' }} lg:border-r last:border-r-0" data-reveal>
                    <p class="text-4xl md:text-6xl font-semibold tracking-tight tabular-nums" data-count="{{ $n }}" data-suffix="{{ $sfx }}">{{ number_format($n) }}{{ $sfx }}</p>
                    <p class="mt-2 text-sm md:text-base text-sky-200/70">{{ $label }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Mission & vision --}}
    <section class="py-24 lg:py-36 px-4" data-no-auto>
        <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-6">
            @foreach ([['fa-bullseye', 'Our mission', 'To provide comprehensive, personalised educational consulting services that empower students to make informed decisions about their academic future and achieve their full potential in a global context.', 'consultation'], ['fa-eye', 'Our vision', "To be the world's most trusted education consultancy, recognised for our commitment to student success, innovation in educational services, and creating pathways to quality education for students from all backgrounds.", 'graduates-caps']] as [$icon, $title, $text, $img])
                <article class="relative min-h-[460px] rounded-[2rem] overflow-hidden flex flex-col justify-end p-8 md:p-10 text-white" data-clip-reveal>
                    <img src="/homeassets/img/site/{{ $img }}.webp" alt="" class="absolute inset-0 w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0f0f2e] via-[#0f0f2e]/70 to-[#0f0f2e]/10"></div>
                    <div class="relative">
                        <span class="grid place-items-center w-12 h-12 rounded-2xl bg-white/15 backdrop-blur"><i class="fas {{ $icon }}"></i></span>
                        <h2 class="mt-5 text-3xl md:text-4xl font-semibold tracking-tight">{{ $title }}</h2>
                        <p class="mt-4 text-white/80 text-lg leading-relaxed">{{ $text }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    {{-- Values: sticky stacking cards --}}
    <section class="pb-24 lg:pb-36 px-4" data-no-auto>
        <div class="max-w-7xl mx-auto grid lg:grid-cols-12 gap-10">
            <div class="lg:col-span-4">
                <div class="lg:sticky lg:top-32">
                    <span class="eyebrow" data-reveal>Our values</span>
                    <h2 class="h-display text-4xl md:text-6xl mt-5" data-reveal>The principles behind every decision.</h2>
                    <p class="mt-5 text-lg text-muted" data-reveal>Six commitments that shape how we work with every student.</p>
                </div>
            </div>
            <div class="lg:col-span-8 space-y-6" data-stack>
                @foreach ($values as $i => [$icon, $title, $text, $img])
                    <article class="stack-card sticky card !p-0 overflow-hidden grid sm:grid-cols-5 origin-top" style="top: calc(7rem + {{ $i * 14 }}px)">
                        <div class="sm:col-span-3 p-7 md:p-10 flex flex-col justify-between min-h-[260px]">
                            <div class="flex items-center justify-between">
                                <span class="icon-tile"><i class="fas {{ $icon }}"></i></span>
                                <span class="font-mono text-sm text-muted">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }} / {{ str_pad(count($values), 2, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <div class="mt-8">
                                <h3 class="text-2xl md:text-3xl font-semibold tracking-tight text-ink">{{ $title }}</h3>
                                <p class="mt-3 text-muted leading-relaxed">{{ $text }}</p>
                            </div>
                        </div>
                        <div class="hidden sm:block sm:col-span-2 relative"><img src="/homeassets/img/site/{{ $img }}.webp" alt="" class="absolute inset-0 w-full h-full object-cover" loading="lazy"></div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- What we do --}}
    <section class="py-24 lg:py-32 px-4 bg-page-alt" data-no-auto>
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
                <div>
                    <span class="eyebrow" data-reveal>What we do</span>
                    <h2 class="h-display text-4xl md:text-6xl mt-5" data-reveal>From first chat<br>to first lecture.</h2>
                </div>
                <a href="{{ route('home.contact') }}" class="btn btn-primary" data-reveal data-magnetic>Book a free consultation <i class="fas fa-arrow-right text-xs btn-arrow"></i></a>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-4">
                @foreach ($services as $i => [$icon, $title, $text])
                    <div class="card !p-6 group" data-reveal data-tilt="4" data-spotlight>
                        <span class="font-mono text-xs text-muted">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <span class="icon-tile mt-4 group-hover:bg-[var(--accent)] group-hover:text-white transition-colors"><i class="fas {{ $icon }}"></i></span>
                        <h3 class="mt-5 font-semibold text-ink text-lg">{{ $title }}</h3>
                        <p class="mt-2 text-sm text-muted leading-relaxed">{{ $text }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Team --}}
    @if ($teamMembers->isNotEmpty())
        <section class="py-24 lg:py-32 px-4" data-no-auto>
            <div class="max-w-7xl mx-auto">
                <div class="text-center max-w-2xl mx-auto mb-14">
                    <span class="eyebrow" data-reveal>Our team</span>
                    <h2 class="h-display text-4xl md:text-6xl mt-5" data-reveal>Meet our leadership</h2>
                    <p class="mt-5 text-lg text-muted" data-reveal>Experienced professionals dedicated to your success.</p>
                </div>
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($teamMembers as $member)
                        <article class="group" data-reveal>
                            <div class="relative aspect-[4/5] rounded-[1.75rem] overflow-hidden bg-[var(--surface-2)]">
                                @if ($member->photo)
                                    <img src="{{ Storage::url($member->photo) }}" alt="{{ $member->name }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-[1.2s] ease-[cubic-bezier(.23,1,.32,1)] group-hover:scale-105" loading="lazy">
                                @else
                                    <span class="absolute inset-0 grid place-items-center text-6xl font-semibold text-accent">{{ Str::upper(Str::substr($member->name, 0, 1)) }}</span>
                                @endif
                                <div class="absolute inset-x-3 bottom-3 flex gap-2 opacity-0 translate-y-2 group-hover:opacity-100 group-hover:translate-y-0 transition duration-500">
                                    @if ($member->linkedin_url)<a href="{{ $member->linkedin_url }}" target="_blank" rel="noopener" class="grid place-items-center w-10 h-10 rounded-full bg-white text-[#1a1a4e]" aria-label="{{ $member->name }} on LinkedIn"><i class="fab fa-linkedin-in"></i></a>@endif
                                    @if ($member->twitter_url)<a href="{{ $member->twitter_url }}" target="_blank" rel="noopener" class="grid place-items-center w-10 h-10 rounded-full bg-white text-[#1a1a4e]" aria-label="{{ $member->name }} on X"><i class="fab fa-x-twitter"></i></a>@endif
                                </div>
                            </div>
                            <h3 class="mt-4 text-lg font-semibold text-ink">{{ $member->name }}</h3>
                            <p class="text-sm text-accent font-medium">{{ $member->role }}</p>
                            @if ($member->bio)<p class="mt-2 text-sm text-muted line-clamp-3">{{ $member->bio }}</p>@endif
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Accreditations --}}
    <section class="py-20 px-4 {{ $teamMembers->isNotEmpty() ? 'bg-page-alt' : '' }}" data-no-auto>
        <div class="max-w-7xl mx-auto">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="eyebrow" data-reveal>Recognition</span>
                <h2 class="h-display text-3xl md:text-5xl mt-5" data-reveal>Accreditations &amp; partnerships</h2>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ([['fa-certificate', 'British Council', 'Certified Education Agent'], ['fa-award', 'ICEF', 'Agency Member'], ['fa-medal', 'NAFSA', 'Professional Member'], ['fa-shield-halved', 'UCAS', 'Registered Centre']] as [$icon, $name, $role])
                    <div class="card text-center !p-7" data-reveal data-spotlight>
                        <span class="icon-tile w-14 h-14 mx-auto text-xl"><i class="fas {{ $icon }}"></i></span>
                        <h3 class="mt-4 font-semibold text-ink">{{ $name }}</h3>
                        <p class="mt-1 text-sm text-muted">{{ $role }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section style="--hero-img: url('/homeassets/img/site/graduates-caps.webp')" class="page-hero brand-band py-28 md:py-36 px-4">
        <div class="max-w-4xl mx-auto text-center text-white">
            <h2 class="text-4xl md:text-6xl font-semibold tracking-tight" data-split>Ready to start your journey?</h2>
            <p class="mt-5 text-xl text-white/75">Join thousands of students who trusted us with their education.</p>
            <div class="mt-10 flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('home.contact') }}" class="btn btn-light" data-magnetic>Contact us today</a>
                <a href="{{ route('home.apply') }}" class="btn btn-outline-light" data-magnetic>Start application</a>
            </div>
        </div>
    </section>
</div>
