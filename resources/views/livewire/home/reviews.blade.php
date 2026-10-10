<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};
use Livewire\WithPagination;
use App\Models\Testimonial;

new
#[Layout('components.layouts.home')]
#[Title('Student Reviews')]
class extends Component {
    use WithPagination;

    public $perPage = 12;
    public $filterRating = null;

    public function updatingFilterRating()
    {
        $this->resetPage();
    }

    public function with(): array
    {
        $query = Testimonial::approved()->ordered();

        if ($this->filterRating) {
            $query->where('rating', $this->filterRating);
        }

        return [
            'testimonials' => $query->paginate($this->perPage),
            'averageRating' => Testimonial::approved()->avg('rating'),
            'totalReviews' => Testimonial::approved()->count(),
            'ratingCounts' => [
                5 => Testimonial::approved()->where('rating', 5)->count(),
                4 => Testimonial::approved()->where('rating', 4)->count(),
                3 => Testimonial::approved()->where('rating', 3)->count(),
                2 => Testimonial::approved()->where('rating', 2)->count(),
                1 => Testimonial::approved()->where('rating', 1)->count(),
            ],
        ];
    }
}; ?>

<div>
    <section style="--hero-img: url('/homeassets/img/site/students-friends.webp')" class="page-hero pt-40 md:pt-48 pb-28 md:pb-36 px-4">
        <div class="max-w-4xl mx-auto text-center text-white">
            <span class="eyebrow !text-sky-300 justify-center">Student reviews</span>
            <h1 class="mt-5">Real stories from real students</h1>
            <p class="mt-5 text-xl">What it's like to study abroad with Divjules — in our students' own words.</p>
        </div>
    </section>

    {{-- rating summary --}}
    <section class="relative z-20 -mt-16 px-4" data-no-auto>
        <div class="max-w-5xl mx-auto surface rounded-[2rem] p-6 md:p-10 grid md:grid-cols-12 gap-8 items-center" style="box-shadow: var(--shadow-lg)">
            <div class="md:col-span-4 text-center md:text-left">
                <p class="text-7xl font-semibold tracking-tight text-ink tabular-nums">{{ number_format((float) $averageRating, 1) }}</p>
                <div class="mt-2 flex justify-center md:justify-start text-amber-400 gap-0.5 text-lg">
                    @for ($i = 1; $i <= 5; $i++)<i class="{{ $i <= round($averageRating) ? 'fas' : 'far' }} fa-star"></i>@endfor
                </div>
                <p class="mt-2 text-sm text-muted">Based on {{ $totalReviews }} {{ Str::plural('review', $totalReviews) }}</p>
            </div>
            <div class="md:col-span-5 space-y-2">
                @foreach ($ratingCounts as $stars => $count)
                    @php $pct = $totalReviews ? round($count / $totalReviews * 100) : 0; @endphp
                    <button type="button" wire:click="$set('filterRating', {{ $stars }})" class="w-full flex items-center gap-3 group text-sm" aria-label="Show {{ $stars }}-star reviews">
                        <span class="w-10 text-left text-muted group-hover:text-ink">{{ $stars }} <i class="fas fa-star text-amber-400 text-[10px]"></i></span>
                        <span class="flex-1 h-2 rounded-full bg-[var(--surface-2)] overflow-hidden"><span class="block h-full rounded-full bg-amber-400 rating-bar" style="width: {{ $pct }}%"></span></span>
                        <span class="w-8 text-right text-muted tabular-nums">{{ $count }}</span>
                    </button>
                @endforeach
            </div>
            <div class="md:col-span-3 flex flex-col gap-3">
                <a href="{{ route('home.submit-review') }}" class="btn btn-primary"><i class="fas fa-pen text-sm"></i> Write a review</a>
                <a href="{{ route('home.contact') }}" class="btn btn-ghost">Talk to us</a>
            </div>
        </div>
    </section>

    <section class="py-16 md:py-24 px-4" data-no-auto>
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-wrap items-center gap-2 mb-10" role="group" aria-label="Filter by rating">
                <button type="button" wire:click="$set('filterRating', null)" class="chip" aria-pressed="{{ $filterRating ? 'false' : 'true' }}">All reviews</button>
                @foreach ([5, 4, 3, 2, 1] as $rating)
                    <button type="button" wire:click="$set('filterRating', {{ $rating }})" class="chip" aria-pressed="{{ (int) $filterRating === $rating ? 'true' : 'false' }}">
                        {{ $rating }} <i class="fas fa-star text-amber-400 text-[11px]"></i> <span class="opacity-60 text-xs">{{ $ratingCounts[$rating] }}</span>
                    </button>
                @endforeach
            </div>

            @if ($testimonials->count() > 0)
                <div class="columns-1 md:columns-2 lg:columns-3 gap-5 [&>*]:mb-5" wire:loading.class="opacity-50" style="transition: opacity .2s ease">
                    @foreach ($testimonials as $t)
                        <figure wire:key="review-{{ $t->id }}" class="review-card card-in break-inside-avoid" style="--i: {{ $loop->index }}">
                            <div class="flex items-center justify-between">
                                <div class="flex text-amber-400 gap-0.5 text-sm">@for ($i = 1; $i <= 5; $i++)<i class="{{ $i <= $t->rating ? 'fas' : 'far' }} fa-star"></i>@endfor</div>
                                @if ($t->is_featured ?? false)<span class="meta-chip"><i class="fas fa-award"></i>Featured</span>@endif
                            </div>
                            <blockquote class="mt-4 text-ink leading-relaxed break-words">“{{ $t->review }}”</blockquote>
                            <figcaption class="mt-6 pt-5 border-t border-line flex items-center gap-3 min-w-0">
                                @if ($t->photo)
                                    <img src="{{ $t->photo_url }}" alt="{{ $t->student_name }}" class="w-11 h-11 rounded-full object-cover shrink-0">
                                @else
                                    <span class="grid place-items-center w-11 h-11 rounded-full bg-[var(--accent-soft)] text-accent font-semibold shrink-0">{{ Str::upper(Str::substr($t->student_name, 0, 1)) }}</span>
                                @endif
                                <span class="min-w-0">
                                    <span class="block font-semibold text-ink truncate">{{ $t->student_name }}</span>
                                    <span class="block text-xs text-muted truncate">{{ $t->university }}@if ($t->course) · {{ $t->course }}@endif</span>
                                </span>
                            </figcaption>
                        </figure>
                    @endforeach
                </div>
                <div class="mt-12">{{ $testimonials->links() }}</div>
            @else
                <div class="card max-w-lg mx-auto text-center py-14">
                    <span class="icon-tile w-16 h-16 mx-auto text-2xl"><i class="fas fa-comments"></i></span>
                    <h3 class="mt-6 text-2xl font-semibold text-ink">No reviews here yet</h3>
                    <p class="mt-2 text-muted">Try another rating, or be the first to share your experience.</p>
                    <button type="button" wire:click="$set('filterRating', null)" class="btn btn-primary mt-6">Show all reviews</button>
                </div>
            @endif
        </div>
    </section>

    <section class="px-4 pb-24" data-no-auto>
        <div class="max-w-7xl mx-auto brand-band relative overflow-hidden rounded-[2rem] text-white p-8 md:p-14 flex flex-col md:flex-row md:items-center justify-between gap-6"
            style="background: linear-gradient(120deg, rgba(26,26,78,.95), rgba(15,15,46,.88)), url('/homeassets/img/site/graduates-caps.webp') center/cover;" data-reveal>
            <div>
                <h2 class="text-3xl md:text-4xl font-semibold tracking-tight">Studied abroad with us?</h2>
                <p class="mt-3 text-white/70 max-w-lg">Your story helps the next student take the leap. It only takes two minutes.</p>
            </div>
            <a href="{{ route('home.submit-review') }}" class="btn btn-light shrink-0" data-magnetic>Share your experience <i class="fas fa-arrow-right text-xs btn-arrow"></i></a>
        </div>
    </section>
</div>
