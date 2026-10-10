<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};
use App\Models\School;
use App\Models\VideoTestimonial;
use App\Models\Testimonial;

new
#[Layout('components.layouts.home')]
#[Title('Home')]
class extends Component {
    public function with(): array
    {
        return [
            'schools' => School::active()->ordered()->get(),
            'videoTestimonials' => VideoTestimonial::active()->ordered()->get(),
            'testimonials' => Testimonial::approved()->ordered()->limit(6)->get(),
        ];
    }
}; ?>

@php
    $destinations = [
        'uk' => ['United Kingdom', 'Jan · May · Sep', 'Business, Nursing, Computing, Law', 'One-year master’s degrees and world-famous universities.'],
        'canada' => ['Canada', 'Jan · May · Sep', 'Engineering, IT, Health, Business', 'Co-op programmes that blend study with paid work.'],
        'usa' => ['United States', 'Jan · Aug', 'STEM, Business, Data Science', 'Flexible majors and a huge choice of campuses.'],
        'australia' => ['Australia', 'Feb · Jul', 'Nursing, Engineering, Hospitality', 'High quality of life and practical, career-led courses.'],
        'germany' => ['Germany', 'Apr · Oct', 'Engineering, Computer Science', 'Low or no tuition at many public universities.'],
        'ireland' => ['Ireland', 'Jan · Sep', 'Tech, Pharma, Finance', 'English-speaking hub for Europe’s tech giants.'],
        'dubai' => ['Dubai', 'Jan · Sep', 'Business, Hospitality, Media', 'International branch campuses close to home.'],
    ];

    $faculties = [
        ['fa-briefcase', 'Business & Management', 'MBA, Finance, Marketing'],
        ['fa-laptop-code', 'Computing & IT', 'Computer Science, Data Science, Cyber Security'],
        ['fa-gears', 'Engineering', 'Mechanical, Civil, Electrical'],
        ['fa-heart-pulse', 'Health Sciences', 'Medicine, Nursing, Pharmacy'],
        ['fa-scale-balanced', 'Law', 'LLB, Corporate Law, International Law'],
        ['fa-palette', 'Arts & Humanities', 'Design, Media, Languages'],
        ['fa-flask', 'Science', 'Physics, Chemistry, Biology'],
        ['fa-graduation-cap', 'Education', 'Teaching, Training, Development'],
    ];

    $journey = [
        ['fa-comments', 'Free consultation', 'Talk through your goals, budget and grades with an expert counsellor.'],
        ['fa-building-columns', 'University selection', 'Shortlist courses and partner institutions that fit you.'],
        ['fa-file-signature', 'Application support', 'Statements, documents and submissions — handled with you.'],
        ['fa-plane-departure', 'Visa & departure', 'Visa guidance and a pre-departure briefing before you fly.'],
    ];
@endphp

<div>
    {{-- ============================== HERO ============================== --}}
    <section class="hero-home relative overflow-hidden pt-28 lg:pt-20 min-h-[100dvh] flex items-center" data-home-hero data-no-auto>
        <div class="absolute inset-0 grid-fade opacity-70 pointer-events-none" aria-hidden="true"></div>

        <div class="container-x relative w-full grid lg:grid-cols-12 gap-10 lg:gap-6 items-center">
            <div class="lg:col-span-6 relative z-10" data-hero-copy>
                <span class="eyebrow" data-hero-in>Education consultancy · Study abroad</span>

                <h1 class="h-display mt-6 text-[2.6rem] sm:text-6xl xl:text-[4.6rem]">
                    <span class="block" data-split data-delay="0.15">Your gateway to quality education</span>
                    <span class="block mt-1" data-hero-in>
                        <span class="text-muted font-normal">in</span>
                        <span class="word-swap text-accent" data-word-swap aria-live="polite">
                            @foreach ($destinations as $d)
                                <span>{{ $d[0] }}.</span>
                            @endforeach
                        </span>
                    </span>
                </h1>

                <p class="mt-7 text-lg text-muted leading-relaxed max-w-[52ch]" data-hero-in>
                    Expert guidance for your academic journey — from picking the right course to landing on campus. We connect you with top universities worldwide.
                </p>

                <div class="mt-9 flex flex-col sm:flex-row gap-3" data-hero-in>
                    <a href="/apply" class="btn btn-primary" data-magnetic>Get started <i class="fas fa-arrow-right text-xs btn-arrow"></i></a>
                    <a href="/contact" class="btn btn-ghost" data-magnetic><i class="fas fa-calendar-check text-sm"></i> Book free consultation</a>
                </div>

                <div class="mt-10 flex items-center gap-5" data-hero-in>
                    <div class="flex -space-x-3">
                        @foreach (['A', 'C', 'T', 'O'] as $i => $letter)
                            <span class="grid place-items-center w-10 h-10 rounded-full text-sm font-semibold text-white ring-2 ring-[var(--bg)]" style="background: {{ ['#1a1a4e', '#0369a1', '#0ea5e9', '#334155'][$i] }}">{{ $letter }}</span>
                        @endforeach
                    </div>
                    <p class="text-sm text-muted leading-snug"><strong class="text-ink">10,000+ students</strong> placed across<br class="hidden sm:block"> 150+ partner universities</p>
                </div>
            </div>

            {{-- 3D globe + destination explorer --}}
            <div class="lg:col-span-6 relative">
                <div class="relative h-[400px] sm:h-[520px] lg:h-[660px] -mx-4 lg:mx-0">
                    <div id="hero-globe" class="three-stage is-interactive" data-three="globe" aria-label="Interactive globe showing study destinations"></div>

                    <div class="absolute left-4 right-4 lg:left-auto lg:right-0 bottom-2 lg:bottom-16 lg:w-80 z-10" data-hero-in>
                        <div class="surface rounded-2xl p-5 backdrop-blur-md" style="background: color-mix(in srgb, var(--surface) 82%, transparent);">
                            <div data-dest-card="default">
                                <p class="font-mono text-[11px] uppercase tracking-[0.18em] text-muted">Explore destinations</p>
                                <p class="mt-2 font-semibold text-ink">Pick a country to fly there.</p>
                                <p class="mt-1 text-sm text-muted">Drag the globe to spin it. Every arc starts in Lagos.</p>
                            </div>
                            @foreach ($destinations as $key => [$name, $intakes, $popular, $blurb])
                                <div data-dest-card="{{ $key }}" hidden>
                                    <span class="font-mono text-[11px] uppercase tracking-wider text-accent">Intakes · {{ $intakes }}</span>
                                    <p class="mt-1 font-semibold text-ink text-lg">{{ $name }}</p>
                                    <p class="mt-1.5 text-sm text-muted">{{ $blurb }}</p>
                                    <p class="mt-3 text-xs text-muted"><span class="text-ink font-medium">Popular:</span> {{ $popular }}</p>
                                    <a href="/universities" class="mt-3 inline-flex items-center gap-1.5 text-sm font-medium text-accent hover:gap-2.5 transition-all">See universities <i class="fas fa-arrow-right text-[10px]"></i></a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="mt-4 flex flex-wrap gap-2 justify-center lg:justify-start relative z-10" data-hero-in role="group" aria-label="Study destinations">
                    @foreach ($destinations as $key => $d)
                        <button type="button" class="chip" data-dest="{{ $key }}" aria-pressed="false">{{ $d[0] }}</button>
                    @endforeach
                </div>
            </div>
        </div>

        <a href="#stats" class="hidden lg:flex absolute bottom-8 left-1/2 -translate-x-1/2 flex-col items-center gap-2 text-xs font-mono uppercase tracking-[0.2em] text-muted hover:text-accent transition" data-hero-in>
            Scroll
            <span class="block w-px h-10 bg-[var(--line)] relative overflow-hidden"><span class="absolute inset-x-0 top-0 h-4 bg-[var(--accent)] animate-[scrollcue_1.8s_ease-in-out_infinite]"></span></span>
        </a>
        <style>@keyframes scrollcue { 0% { transform: translateY(-100%) } 100% { transform: translateY(250%) } }</style>
    </section>

    {{-- ============================== DESTINATION TICKER ============================== --}}
    <section class="py-8 border-y border-line bg-page-alt overflow-hidden" data-no-auto>
        <div class="marquee-mask" data-marquee data-marquee-speed="45">
            <div class="marquee items-center">
                @foreach (array_merge(array_values($destinations), array_values($destinations), array_values($destinations), array_values($destinations)) as $d)
                    <span class="flex items-center gap-12 text-3xl md:text-5xl font-semibold tracking-tight text-ink whitespace-nowrap">
                        {{ $d[0] }} <i class="fas fa-graduation-cap text-xl md:text-2xl text-accent"></i>
                    </span>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================== STATS ============================== --}}
    <section id="stats" class="py-20 lg:py-28 px-4" data-no-auto>
        <div class="max-w-7xl mx-auto grid grid-cols-2 lg:grid-cols-4 gap-px rounded-3xl overflow-hidden border border-line bg-[var(--line)]">
            @foreach ([[150, '+', 'Partner universities'], [15, '+', 'Countries'], [10000, '+', 'Students placed'], [500, '+', 'Expert counsellors']] as [$n, $s, $label])
                <div class="bg-[var(--surface)] p-7 md:p-10 group relative overflow-hidden" data-reveal data-spotlight>
                    <div class="text-4xl md:text-6xl font-semibold tracking-tight text-ink tabular-nums" data-count="{{ $n }}" data-suffix="{{ $s }}">{{ number_format($n) }}{{ $s }}</div>
                    <div class="mt-3 text-sm md:text-base text-muted flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-[var(--accent)] group-hover:scale-150 transition-transform"></span>{{ $label }}
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ============================== WHY DIVJULES (bento) ============================== --}}
    <section class="pb-24 lg:pb-32 px-4" data-no-auto>
        <div class="max-w-7xl mx-auto">
            <div class="grid lg:grid-cols-12 gap-6 items-end mb-12">
                <div class="lg:col-span-7">
                    <span class="eyebrow" data-reveal>Why Divjules</span>
                    <h2 class="h-display text-4xl md:text-6xl mt-5" data-reveal>Support at every step,<br><span class="text-accent">from shortlist to campus.</span></h2>
                </div>
                <p class="lg:col-span-5 text-lg text-muted leading-relaxed" data-reveal>We provide comprehensive support throughout your educational journey, from selection to enrollment and beyond.</p>
            </div>

            <div class="grid md:grid-cols-6 gap-5" data-why-stack>
                <div class="card md:col-span-4 md:row-span-2 overflow-hidden min-h-[420px] flex flex-col justify-end" data-tilt="4" data-spotlight>
                    <div class="three-stage" data-three="floaters" data-preset="side" aria-hidden="true"></div>
                    <div class="relative z-10 max-w-md">
                        <div class="icon-tile mb-5"><i class="fas fa-user-graduate"></i></div>
                        <h3 class="text-2xl md:text-3xl font-semibold tracking-tight text-ink">Expert guidance</h3>
                        <p class="mt-3 text-muted leading-relaxed">Our certified counsellors provide personalised advice to help you choose the right university and course. <span class="text-ink">Tap the objects</span> — they spin.</p>
                    </div>
                </div>
                <div class="card md:col-span-2" data-tilt data-spotlight>
                    <div class="icon-tile mb-5"><i class="fas fa-earth-africa"></i></div>
                    <h3 class="text-xl font-semibold text-ink">Global network</h3>
                    <p class="mt-2 text-muted">Access to 150+ partner institutions across multiple countries for diverse opportunities.</p>
                </div>
                <div class="card md:col-span-2" data-tilt data-spotlight>
                    <div class="icon-tile mb-5"><i class="fas fa-hand-holding-heart"></i></div>
                    <h3 class="text-xl font-semibold text-ink">End-to-end support</h3>
                    <p class="mt-2 text-muted">From application to visa assistance and pre-departure briefing, we’re with you every step.</p>
                </div>
                <a href="/application/track" class="card md:col-span-3 group flex items-center justify-between gap-6" data-tilt data-spotlight>
                    <div>
                        <p class="font-mono text-[11px] uppercase tracking-[0.18em] text-muted">Already applied?</p>
                        <p class="mt-2 text-xl font-semibold text-ink">Track your application</p>
                    </div>
                    <span class="grid place-items-center w-12 h-12 rounded-full border border-line text-accent group-hover:bg-[var(--accent)] group-hover:text-white group-hover:border-transparent transition"><i class="fas fa-arrow-right -rotate-45 group-hover:rotate-0 transition-transform duration-300"></i></span>
                </a>
                <a href="/contact" class="card brand-band md:col-span-3 group flex items-center justify-between gap-6 !bg-[#1a1a4e] !border-transparent text-white" data-tilt data-spotlight>
                    <div>
                        <p class="font-mono text-[11px] uppercase tracking-[0.18em] text-white/50">It’s free</p>
                        <p class="mt-2 text-xl font-semibold">Book a consultation</p>
                    </div>
                    <span class="grid place-items-center w-12 h-12 rounded-full bg-white text-[#1a1a4e] group-hover:scale-110 transition-transform"><i class="fas fa-calendar-check"></i></span>
                </a>
            </div>
        </div>
    </section>

    {{-- ============================== FACULTIES (pinned horizontal scroll) ============================== --}}
    <section class="bg-page-alt py-24 lg:py-0 lg:h-[100dvh] lg:flex lg:flex-col lg:justify-center overflow-hidden" data-hscroll data-no-auto>
        <div class="container-x w-full flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-10 lg:mb-14">
            <div>
                <span class="eyebrow" data-reveal>Popular faculties</span>
                <h2 class="h-display text-4xl md:text-6xl mt-5" data-reveal>Find the field<br>that fits you.</h2>
            </div>
            <div class="lg:w-80" data-reveal>
                <p class="text-muted">Explore our most sought-after academic programmes. Keep scrolling to browse.</p>
                <div class="hidden lg:block mt-5 h-[3px] rounded-full bg-[var(--line)] overflow-hidden"><div class="h-full bg-[var(--accent)] origin-left scale-x-0" data-hscroll-bar></div></div>
            </div>
        </div>

        <div class="w-full overflow-x-auto lg:overflow-visible snap-x snap-mandatory scrollbar-hide">
            <div class="h-scroll-track px-4 sm:px-6 lg:px-[max(2rem,calc((100vw-80rem)/2+2rem))] pb-2">
                @foreach ($faculties as $i => [$icon, $title, $sub])
                    <a href="/courses" class="faculty-card card snap-start group flex flex-col justify-between min-h-[320px] lg:min-h-[380px] overflow-hidden" data-spotlight>
                        <i class="fas {{ $icon }} absolute -right-6 top-1/2 -translate-y-1/2 text-[9rem] text-accent opacity-[0.06] group-hover:opacity-[0.12] group-hover:-rotate-6 group-hover:scale-110 transition duration-500 pointer-events-none" aria-hidden="true"></i>
                        <div class="flex items-start justify-between">
                            <div class="icon-tile w-14 h-14 text-xl group-hover:bg-[var(--accent)] group-hover:text-white transition-colors duration-300"><i class="fas {{ $icon }}"></i></div>
                            <span class="font-mono text-sm text-muted">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div>
                            <h3 class="text-2xl font-semibold tracking-tight text-ink">{{ $title }}</h3>
                            <p class="mt-2 text-muted">{{ $sub }}</p>
                            <span class="mt-6 inline-flex items-center gap-2 text-sm font-medium text-accent">Explore courses <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i></span>
                        </div>
                    </a>
                @endforeach
                <a href="/courses" class="faculty-card snap-start rounded-3xl grid place-items-center min-h-[320px] lg:min-h-[380px] border-2 border-dashed border-line text-center group hover:border-[var(--accent)] transition-colors">
                    <div>
                        <span class="grid place-items-center w-16 h-16 mx-auto rounded-full bg-[var(--accent)] text-white text-xl group-hover:scale-110 transition-transform"><i class="fas fa-arrow-right"></i></span>
                        <p class="mt-4 font-semibold text-ink text-lg">All courses</p>
                    </div>
                </a>
            </div>
        </div>
    </section>

    {{-- ============================== PARTNER SCHOOLS ============================== --}}
    <section class="py-24 lg:py-32 overflow-hidden" data-no-auto>
        <div class="container-x text-center mb-14">
            <span class="eyebrow" data-reveal>Partners</span>
            <h2 class="h-display text-4xl md:text-6xl mt-5" data-reveal>Schools we work with</h2>
            <p class="mt-5 text-lg text-muted" data-reveal>Partner universities and institutions across the globe. Hover to pause, drag to browse.</p>
        </div>

        <div class="relative marquee-mask cursor-grab active:cursor-grabbing select-none" data-marquee data-marquee-speed="35" style="touch-action: pan-y">
            <div class="marquee !gap-5 items-center py-4">
                @php $loopSchools = $schools->count() ? $schools->concat($schools)->concat($schools)->concat($schools) : collect(); @endphp
                @forelse ($loopSchools as $school)
                    <div class="uni-logo-card shrink-0 rounded-2xl p-5 h-40 w-60 flex flex-col items-center justify-center gap-3">
                        @if ($school->logo_url)
                            <img src="/storage/{{ $school->logo_url }}" alt="{{ $school->name }}" class="h-16 w-auto max-w-[160px] object-contain pointer-events-none" loading="lazy" draggable="false">
                        @endif
                        <div class="text-sm font-semibold text-ink text-center line-clamp-2">{{ $school->name }}</div>
                    </div>
                @empty
                    @foreach (array_merge(array_values($destinations), array_values($destinations)) as $d)
                        <div class="uni-logo-card shrink-0 rounded-2xl p-5 h-40 w-60 flex flex-col items-center justify-center gap-3">
                            <i class="fas fa-building-columns text-3xl text-accent"></i>
                            <div class="text-sm font-semibold text-ink">Universities in {{ $d[0] }}</div>
                        </div>
                    @endforeach
                @endforelse
            </div>
            <button type="button" data-marquee-nudge="1" class="theme-toggle !absolute left-4 top-1/2 -translate-y-1/2 z-10 !bg-[var(--surface)] hidden md:grid" aria-label="Scroll partners left"><i class="fas fa-chevron-left"></i></button>
            <button type="button" data-marquee-nudge="-1" class="theme-toggle !absolute right-4 top-1/2 -translate-y-1/2 z-10 !bg-[var(--surface)] hidden md:grid" aria-label="Scroll partners right"><i class="fas fa-chevron-right"></i></button>
        </div>

        <div class="text-center mt-12" data-reveal>
            <a href="/universities" class="btn btn-primary" data-magnetic>View all universities <i class="fas fa-arrow-right text-xs btn-arrow"></i></a>
        </div>
    </section>

    {{-- ============================== JOURNEY ============================== --}}
    <section class="py-24 lg:py-32 px-4 bg-page-alt" data-no-auto>
        <div class="max-w-7xl mx-auto">
            <div class="text-center max-w-2xl mx-auto mb-16 lg:mb-24">
                <span class="eyebrow" data-reveal>How it works</span>
                <h2 class="h-display text-4xl md:text-6xl mt-5" data-reveal>Your journey with us</h2>
                <p class="mt-5 text-lg text-muted" data-reveal>Simple steps to kickstart your academic career.</p>
            </div>

            <div class="relative" data-journey>
                {{-- track + fill (horizontal on desktop, vertical on mobile) --}}
                <div class="absolute bg-[var(--line)] rounded-full left-7 top-0 bottom-0 w-[3px] lg:left-[12.5%] lg:right-[12.5%] lg:top-7 lg:bottom-auto lg:w-auto lg:h-[3px]"></div>
                <div class="absolute bg-[var(--accent)] rounded-full left-7 top-0 bottom-0 w-[3px] origin-top scale-y-0 lg:left-[12.5%] lg:right-[12.5%] lg:top-7 lg:bottom-auto lg:w-auto lg:h-[3px] lg:origin-left lg:scale-y-100 lg:scale-x-0" data-journey-fill></div>

                <ol class="relative grid lg:grid-cols-4 gap-12 lg:gap-6">
                    @foreach ($journey as $i => [$icon, $title, $text])
                        <li class="journey-step flex lg:flex-col lg:items-center lg:text-center gap-6" data-active="false" data-reveal>
                            <div class="journey-dot shrink-0 grid place-items-center w-14 h-14 rounded-full border-2 border-line bg-[var(--surface)] text-accent text-lg relative z-10">
                                <i class="fas {{ $icon }}"></i>
                            </div>
                            <div class="pt-1 lg:pt-2">
                                <p class="font-mono text-xs text-muted">Step {{ $i + 1 }}</p>
                                <h3 class="mt-1.5 text-xl font-semibold text-ink">{{ $title }}</h3>
                                <p class="mt-2 text-muted lg:max-w-[28ch] lg:mx-auto">{{ $text }}</p>
                            </div>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </section>

    {{-- ============================== VIDEO TESTIMONIALS ============================== --}}
    @if ($videoTestimonials->count() > 0)
        @php $chunkedTestimonials = $videoTestimonials->chunk(3); @endphp
        <section class="py-24 lg:py-32 px-4 overflow-hidden" data-no-auto>
            <div class="max-w-7xl mx-auto">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-14">
                    <div>
                        <span class="eyebrow" data-reveal>In their words</span>
                        <h2 class="h-display text-4xl md:text-6xl mt-5" data-reveal>Student video stories</h2>
                    </div>
                    <p class="text-lg text-muted max-w-md" data-reveal>Watch success stories from students who achieved their dreams with Divjules.</p>
                </div>

                <div class="hidden md:block">
                    <div class="testimonial-slider relative">
                        @foreach ($chunkedTestimonials as $slideIndex => $chunk)
                            <div class="testimonial-slide {{ $slideIndex === 0 ? 'active' : '' }}">
                                <div class="grid md:grid-cols-3 gap-6">
                                    @foreach ($chunk as $testimonial)
                                        <button type="button" class="group text-left" onclick="openVideoModal('{{ $testimonial->youtube_embed_url }}')" data-reveal>
                                            <div class="relative overflow-hidden rounded-3xl aspect-[4/5]">
                                                <img src="{{ $testimonial->display_thumbnail }}" alt="{{ $testimonial->student_name }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105">
                                                <div class="absolute inset-0 bg-gradient-to-t from-[#0f0f2e] via-[#0f0f2e]/20 to-transparent"></div>
                                                <span class="absolute top-5 right-5 grid place-items-center w-14 h-14 rounded-full bg-white/90 text-[#1a1a4e] backdrop-blur group-hover:scale-110 group-hover:bg-white transition-transform duration-300"><i class="fas fa-play ml-0.5"></i></span>
                                                <div class="absolute bottom-0 inset-x-0 p-6 text-white">
                                                    <div class="flex text-amber-400 text-xs gap-0.5 mb-2">@for ($i = 0; $i < $testimonial->rating; $i++)<i class="fas fa-star"></i>@endfor</div>
                                                    <h4 class="font-semibold text-xl">{{ $testimonial->student_name }}</h4>
                                                    <p class="text-sm text-white/70">{{ $testimonial->course }}, {{ $testimonial->university }}</p>
                                                </div>
                                            </div>
                                            @if ($testimonial->quote)
                                                <p class="mt-4 text-muted text-sm leading-relaxed">“{{ $testimonial->quote }}”</p>
                                            @endif
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                        @if ($chunkedTestimonials->count() > 1)
                            <div class="flex items-center justify-center gap-4 mt-10">
                                <button onclick="changeSlide(-1)" class="theme-toggle" aria-label="Previous"><i class="fas fa-chevron-left"></i></button>
                                <div class="flex gap-2">
                                    @foreach ($chunkedTestimonials as $dotIndex => $chunk)
                                        <button onclick="setSlide({{ $dotIndex }})" class="slider-dot w-2.5 h-2.5 rounded-full transition-colors {{ $dotIndex === 0 ? 'bg-sky-700' : 'bg-gray-300' }}" aria-label="Slide {{ $dotIndex + 1 }}"></button>
                                    @endforeach
                                </div>
                                <button onclick="changeSlide(1)" class="theme-toggle" aria-label="Next"><i class="fas fa-chevron-right"></i></button>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="md:hidden -mx-4">
                    <div class="flex overflow-x-auto gap-4 px-4 pb-4 snap-x snap-mandatory scrollbar-hide">
                        @foreach ($videoTestimonials as $testimonial)
                            <button type="button" class="flex-none w-[80%] snap-center text-left" onclick="openVideoModal('{{ $testimonial->youtube_embed_url }}')">
                                <div class="relative overflow-hidden rounded-3xl aspect-[4/5]">
                                    <img src="{{ $testimonial->display_thumbnail }}" alt="{{ $testimonial->student_name }}" class="absolute inset-0 w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-[#0f0f2e] to-transparent"></div>
                                    <span class="absolute top-4 right-4 grid place-items-center w-12 h-12 rounded-full bg-white/90 text-[#1a1a4e]"><i class="fas fa-play ml-0.5"></i></span>
                                    <div class="absolute bottom-0 inset-x-0 p-5 text-white">
                                        <h4 class="font-semibold text-lg">{{ $testimonial->student_name }}</h4>
                                        <p class="text-sm text-white/70">{{ $testimonial->course }}, {{ $testimonial->university }}</p>
                                    </div>
                                </div>
                            </button>
                        @endforeach
                    </div>
                    <p class="text-center mt-4 text-muted text-sm"><i class="fas fa-hand-pointer mr-2"></i>Swipe for more stories</p>
                </div>
            </div>
        </section>
    @endif

    <div id="videoModal" class="video-modal">
        <div class="video-modal-content">
            <span class="video-close" onclick="closeVideoModal()">&times;</span>
            <div class="relative rounded-2xl overflow-hidden" style="padding-bottom: 56.25%; height: 0;">
                <iframe id="videoFrame" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
    </div>

    {{-- ============================== REVIEWS ============================== --}}
    <section class="py-24 lg:py-32 px-4 bg-page-alt" data-no-auto>
        <div class="max-w-7xl mx-auto">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <span class="eyebrow" data-reveal>Reviews</span>
                <h2 class="h-display text-4xl md:text-6xl mt-5" data-reveal>What our students say</h2>
                <p class="mt-5 text-lg text-muted" data-reveal>Real experiences from students who trusted us with their future.</p>
            </div>

            @if ($testimonials->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5 mb-12">
                    @foreach ($testimonials as $testimonial)
                        <figure class="card flex flex-col" data-reveal data-tilt="3" data-spotlight>
                            <i class="fas fa-quote-left text-2xl text-accent opacity-60"></i>
                            <blockquote class="mt-4 text-ink-2 leading-relaxed flex-1" style="color: var(--ink-2)">“{{ $testimonial->review }}”</blockquote>
                            <figcaption class="mt-6 pt-6 border-t border-line flex items-center gap-4">
                                @if ($testimonial->photo)
                                    <img src="{{ $testimonial->photo_url }}" alt="{{ $testimonial->student_name }}" class="w-12 h-12 rounded-full object-cover">
                                @else
                                    <span class="grid place-items-center w-12 h-12 rounded-full bg-[var(--accent-soft)] text-accent font-semibold">{{ substr($testimonial->student_name, 0, 1) }}</span>
                                @endif
                                <div class="min-w-0">
                                    <p class="font-semibold text-ink truncate">{{ $testimonial->student_name }}</p>
                                    <p class="text-sm text-muted truncate">{{ $testimonial->university }}@if ($testimonial->course) · {{ $testimonial->course }}@endif</p>
                                </div>
                                <div class="ml-auto flex text-amber-400 text-xs gap-0.5 shrink-0">
                                    @for ($i = 0; $i < 5; $i++)<i class="{{ $i < $testimonial->rating ? 'fas' : 'far' }} fa-star"></i>@endfor
                                </div>
                            </figcaption>
                        </figure>
                    @endforeach
                </div>
            @else
                <div class="card max-w-lg mx-auto text-center py-12 mb-12" data-reveal>
                    <span class="icon-tile w-16 h-16 mx-auto text-2xl"><i class="fas fa-comments"></i></span>
                    <h3 class="mt-6 text-2xl font-semibold text-ink">No reviews yet</h3>
                    <p class="mt-2 text-muted">Be the first to share your experience with Divjules!</p>
                </div>
            @endif

            <div class="flex flex-col sm:flex-row gap-3 justify-center" data-reveal>
                <a href="{{ route('home.reviews') }}" class="btn btn-ghost" data-magnetic><i class="fas fa-comments text-sm"></i> See all reviews</a>
                <a href="{{ route('home.submit-review') }}" class="btn btn-primary" data-magnetic><i class="fas fa-pen text-sm"></i> Share your experience</a>
            </div>
        </div>
    </section>

    {{-- ============================== CTA ============================== --}}
    <section class="brand-band relative overflow-hidden py-32 lg:py-44 px-4 text-white" data-cta-zoom data-no-auto
        style="background: radial-gradient(60% 80% at 80% 0%, rgba(3,105,161,.55), transparent 60%), linear-gradient(160deg, #1a1a4e, #0f0f2e);">
        <div class="three-stage" data-three="floaters" data-preset="cta" aria-hidden="true"></div>
        <div class="relative z-10 max-w-4xl mx-auto text-center">
            <span class="eyebrow !text-sky-300" data-reveal>Let’s begin</span>
            <h2 class="mt-6 text-5xl md:text-7xl font-semibold tracking-tight leading-[1.02]" data-split>Ready to start your journey?</h2>
            <p class="mt-6 text-lg md:text-xl text-sky-100/80" data-reveal>Book a free consultation with our expert counsellors today.</p>
            <div class="mt-10 flex flex-col sm:flex-row gap-3 justify-center" data-reveal>
                <a href="/contact" class="btn btn-light" data-magnetic><i class="fas fa-calendar-check text-sm"></i> Book free consultation</a>
                <a href="/apply" class="btn btn-outline-light" data-magnetic><i class="fas fa-paper-plane text-sm"></i> Apply now</a>
            </div>

            <div class="mt-20 grid grid-cols-3 gap-6 max-w-2xl mx-auto border-t border-white/10 pt-10">
                @foreach ([[98, '%', 'Success rate'], [10000, '+', 'Students placed'], [150, '+', 'Universities']] as [$n, $s, $label])
                    <div data-reveal>
                        <div class="text-3xl md:text-5xl font-semibold tabular-nums" data-count="{{ $n }}" data-suffix="{{ $s }}">{{ number_format($n) }}{{ $s }}</div>
                        <div class="mt-2 text-xs md:text-sm text-sky-200/70">{{ $label }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
