<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\University;
use Illuminate\Support\Str;

new
#[Layout('components.layouts.home')]
class extends Component {
    public University $university;

    public function mount(University $university): void
    {
        abort_unless($university->is_active, 404);
        $this->university = $university->loadCount(['courses' => fn ($q) => $q->active()]);
    }

    public function rendering($view): void
    {
        $u = $this->university;
        $place = trim(($u->city ? $u->city . ', ' : '') . $u->country);
        $view->layoutData([
            'title' => $u->name,
            'metaTitle' => "{$u->name} — Courses, Admission & Fees | Divjules",
            'metaDescription' => $u->description
                ? "Study at {$u->name} in {$place}. {$u->description}"
                : "Study at {$u->name} in {$place}. Explore courses and apply with free guidance from Divjules.",
            'metaImage' => $u->cover_url,
            'breadcrumbs' => [['Universities', route('home.universities')], [$u->name, route('universities.show', $u->slug)]],
            'schema' => [array_filter([
                '@type' => 'CollegeOrUniversity',
                'name' => $u->name,
                'url' => $u->website ?: route('universities.show', $u->slug),
                'description' => $u->description,
                'image' => $u->cover_url,
                'logo' => $u->logo_url,
                'address' => ['@type' => 'PostalAddress', 'addressLocality' => $u->city, 'addressCountry' => $u->country],
            ])],
        ]);
    }

    public function with(): array
    {
        return [
            'courses' => $this->university->courses()->active()->with('courseCategory')->ordered()->get(),
            'related' => University::active()->where('country', $this->university->country)
                ->whereKeyNot($this->university->id)->withCount('courses')->ordered()->limit(3)->get(),
        ];
    }
}; ?>

@php $u = $university; @endphp

<div>
    <section style="--hero-img: url('{{ $u->cover_url }}')" class="page-hero pt-36 md:pt-44 pb-16 md:pb-24 px-4">
        <div class="max-w-7xl mx-auto text-white">
            <nav class="text-sm text-white/60 mb-8" aria-label="Breadcrumb">
                <a href="{{ route('home.index') }}" class="hover:text-white">Home</a>
                <i class="fas fa-chevron-right text-[10px] mx-2"></i>
                <a href="{{ route('home.universities') }}" class="hover:text-white">Universities</a>
                <i class="fas fa-chevron-right text-[10px] mx-2"></i>
                <span class="text-white/90">{{ $u->name }}</span>
            </nav>
            <div class="flex flex-col md:flex-row md:items-end gap-6">
                <span class="uni-logo is-lg">
                    @if ($u->logo_url)<img src="{{ $u->logo_url }}" alt="{{ $u->name }} logo">@else{{ $u->initials }}@endif
                </span>
                <div class="flex-1">
                    <h1 class="!text-left !mx-0" style="font-size: clamp(2.2rem, 5vw, 4rem);">{{ $u->name }}</h1>
                    <p class="!mx-0 mt-3 flex flex-wrap items-center gap-x-5 gap-y-2 text-white/75">
                        <span><i class="fas fa-location-dot mr-2 text-sky-300"></i>{{ $u->city ? $u->city . ', ' : '' }}{{ $u->country }}</span>
                        <span><i class="fas fa-building-columns mr-2 text-sky-300"></i>{{ ucfirst($u->type) }} university</span>
                        <span><i class="fas fa-book-open mr-2 text-sky-300"></i>{{ $u->courses_count }} {{ Str::plural('course', $u->courses_count) }}</span>
                    </p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('home.apply', ['university' => $u->id]) }}" class="btn btn-light" data-magnetic>Apply now <i class="fas fa-arrow-right text-xs btn-arrow"></i></a>
                    <a href="{{ route('home.contact') }}" class="btn btn-outline-light">Ask a counsellor</a>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 md:py-24 px-4" data-no-auto>
        <div class="max-w-7xl mx-auto grid lg:grid-cols-12 gap-10">
            <div class="lg:col-span-8 space-y-14">
                <div data-reveal>
                    <span class="eyebrow">Overview</span>
                    <h2 class="h-display text-3xl md:text-4xl mt-4">About {{ $u->name }}</h2>
                    <div class="mt-5 text-lg text-muted leading-relaxed space-y-4">
                        <p>{{ $u->description ?: "{$u->name} welcomes international students in {$u->country}. Speak to a Divjules counsellor to find the right course and entry route for you." }}</p>
                    </div>
                    @if (! empty($u->features))
                        <ul class="mt-8 grid sm:grid-cols-2 gap-3">
                            @foreach ($u->features as $feature)
                                <li class="flex items-start gap-3 surface rounded-2xl px-4 py-3 !shadow-none">
                                    <i class="fas fa-circle-check text-accent mt-1"></i><span class="text-ink">{{ is_array($feature) ? ($feature['feature'] ?? reset($feature)) : $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div>
                    <div class="flex items-end justify-between gap-4 mb-6" data-reveal>
                        <div>
                            <span class="eyebrow">Programmes</span>
                            <h2 class="h-display text-3xl md:text-4xl mt-4">Courses at {{ $u->name }}</h2>
                        </div>
                        <a href="{{ route('home.courses', ['university' => $u->id]) }}" class="text-sm font-medium text-accent hidden sm:inline-flex items-center gap-1.5">All courses <i class="fas fa-arrow-right text-xs"></i></a>
                    </div>
                    @if ($courses->count())
                        <div class="grid sm:grid-cols-2 gap-5">
                            @foreach ($courses as $course)
                                <div class="card-in" style="--i: {{ $loop->index }}"><x-course-card :course="$course" :show-university="false" /></div>
                            @endforeach
                        </div>
                    @else
                        <div class="card text-center py-10" data-reveal>
                            <p class="text-muted">Course listings for this university are coming soon. Ask a counsellor for the full list.</p>
                        </div>
                    @endif
                </div>
            </div>

            <aside class="lg:col-span-4">
                <div class="lg:sticky lg:top-28 space-y-5">
                    <div class="card" data-reveal>
                        <h3 class="font-semibold text-ink">Quick facts</h3>
                        <dl class="mt-4 divide-y divide-[var(--line)] text-sm">
                            <div class="flex justify-between py-3"><dt class="text-muted">Country</dt><dd class="text-ink font-medium">{{ $u->country }}</dd></div>
                            @if ($u->city)<div class="flex justify-between py-3"><dt class="text-muted">City</dt><dd class="text-ink font-medium">{{ $u->city }}</dd></div>@endif
                            <div class="flex justify-between py-3"><dt class="text-muted">Type</dt><dd class="text-ink font-medium">{{ ucfirst($u->type) }}</dd></div>
                            @if ($u->ranking)<div class="flex justify-between py-3"><dt class="text-muted">World ranking</dt><dd class="text-ink font-medium">#{{ $u->ranking }}</dd></div>@endif
                            <div class="flex justify-between py-3"><dt class="text-muted">Courses listed</dt><dd class="text-ink font-medium">{{ $u->courses_count }}</dd></div>
                        </dl>
                        @if ($u->website)
                            <a href="{{ $u->website }}" target="_blank" rel="noopener" class="btn btn-ghost w-full mt-4">Official website <i class="fas fa-arrow-up-right-from-square text-xs"></i></a>
                        @endif
                    </div>
                    <div class="card brand-band !bg-[#1a1a4e] !border-transparent text-white overflow-hidden" data-reveal>
                        <img src="/homeassets/img/site/consultation.webp" alt="" class="absolute inset-0 w-full h-full object-cover opacity-25">
                        <div class="relative">
                            <h3 class="text-xl font-semibold">Want to study here?</h3>
                            <p class="mt-2 text-white/70 text-sm">A Divjules counsellor will check your eligibility, help with your application and guide you through the visa.</p>
                            <a href="{{ route('home.contact') }}" class="btn btn-light w-full mt-5">Book a free consultation</a>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </section>

    @if ($related->count())
        <section class="py-20 px-4 bg-page-alt" data-no-auto>
            <div class="max-w-7xl mx-auto">
                <h2 class="h-display text-3xl md:text-4xl mb-8" data-reveal>More universities in {{ $u->country }}</h2>
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($related as $item)
                        <div data-reveal><x-university-card :university="$item" /></div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</div>
