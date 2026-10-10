<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title, Url};
use Livewire\WithPagination;
use App\Models\University;

new
#[Layout('components.layouts.home')]
#[Title('Partner Universities')]
class extends Component {
    use WithPagination;

    #[Url]
    public $country = '';

    #[Url]
    public $type = '';

    #[Url]
    public $ranking = '';

    #[Url]
    public $search = '';

    public $showFilters = false;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedCountry()
    {
        $this->resetPage();
    }

    public function updatedType()
    {
        $this->resetPage();
    }

    public function updatedRanking()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['country', 'type', 'ranking', 'search']);
        $this->resetPage();
    }

    public function with(): array
    {
        $query = University::query()
            ->active()
            ->with('courses')
            ->withCount('courses');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('city', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->country) {
            $query->where('country', $this->country);
        }

        if ($this->type) {
            $query->where('type', $this->type);
        }

        if ($this->ranking) {
            match($this->ranking) {
                'top100' => $query->where('ranking', '<=', 100)->whereNotNull('ranking'),
                'top500' => $query->whereBetween('ranking', [101, 500]),
                default => null,
            };
        }

        $universities = $query->ordered()->paginate(12);

        $countries = University::active()
            ->select('country')
            ->distinct()
            ->orderBy('country')
            ->pluck('country', 'country');

        return [
            'universities' => $universities,
            'countries' => $countries,
        ];
    }
}; ?>

<div>
    <!-- Hero Section -->
    <section style="--hero-img: url('/homeassets/img/site/campus.webp')" class="page-hero pt-40 md:pt-48 pb-20 md:pb-28 px-4">
        <div class="max-w-7xl mx-auto text-center text-white">
            <h1 class="text-5xl font-bold mb-4">Partner Universities</h1>
            <p class="text-xl">Explore world-class institutions across the globe</p>
        </div>
    </section>

    <x-filter-bar placeholder="Search universities..." :active="$country || $type || $ranking || $search" :open="$showFilters">
        <select wire:model.live="country" class="filter-select" aria-label="Country">
            <option value="">All countries</option>
            @foreach($countries as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
        <select wire:model.live="type" class="filter-select" aria-label="University type">
            <option value="">All types</option>
            <option value="research">Research</option>
            <option value="public">Public</option>
            <option value="private">Private</option>
        </select>
        <select wire:model.live="ranking" class="filter-select" aria-label="Ranking">
            <option value="">Any ranking</option>
            <option value="top100">Top 100</option>
            <option value="top500">Top 500</option>
        </select>
    </x-filter-bar>

    <!-- Universities grid -->
    <section class="pt-14 pb-24 px-4" data-no-auto>
        <div class="max-w-7xl mx-auto">
            @if($universities->count() > 0)
                <div class="results-bar">
                    <p class="text-muted"><span class="text-ink font-semibold">{{ $universities->total() }}</span> {{ Str::plural('university', $universities->total()) }} found</p>
                    <p class="text-sm text-muted hidden sm:block">Showing {{ $universities->firstItem() }}–{{ $universities->lastItem() }}</p>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6" wire:loading.class="opacity-50 pointer-events-none" style="transition: opacity .2s ease">
                    @foreach($universities as $item)
                        <div wire:key="university-{{ $item->id }}" class="card-in" style="--i: {{ $loop->index }}">
                            <x-university-card :university="$item" />
                        </div>
                    @endforeach
                </div>

                <div class="mt-14">
                    {{ $universities->links() }}
                </div>
            @else
                <div class="card max-w-lg mx-auto text-center py-14">
                    <span class="icon-tile w-16 h-16 mx-auto text-2xl"><i class="fas fa-building-columns"></i></span>
                    <h3 class="mt-6 text-2xl font-semibold text-ink">No universities found</h3>
                    <p class="mt-2 text-muted">Try a different search, or clear your filters.</p>
                    <button wire:click="clearFilters" class="btn btn-primary mt-6">Clear all filters</button>
                </div>
            @endif
        </div>
    </section>

    <!-- CTA Section -->
    <section style="--hero-img: url('/homeassets/img/site/dest-uk.webp')" class="page-hero brand-band py-24 md:py-32 px-4">
        <div class="max-w-4xl mx-auto text-center text-white">
            <h2 class="text-4xl font-bold mb-4">Can't Find Your Ideal University?</h2>
            <p class="text-xl mb-8">Contact our expert counsellors for personalized recommendations</p>
            <a href="/contact" class="inline-block px-8 py-4 bg-white text-sky-700 rounded-lg font-semibold hover:bg-gray-100 transition">Get Free Consultation</a>
        </div>
    </section>
</div>
