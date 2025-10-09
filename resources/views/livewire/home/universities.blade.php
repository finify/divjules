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
    <section class="bg-gradient-to-r from-purple-600 to-indigo-600 pt-32 pb-16 px-4 mt-20">
        <div class="max-w-7xl mx-auto text-center text-white">
            <h1 class="text-5xl font-bold mb-4">Partner Universities</h1>
            <p class="text-xl">Explore world-class institutions across the globe</p>
        </div>
    </section>

    <!-- Mobile Filter Toggle Button -->
    <div class="md:hidden sticky top-20 z-40 bg-white shadow-md px-4 py-3">
        <button
            wire:click="$toggle('showFilters')"
            class="w-full flex items-center justify-between px-4 py-3 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition">
            <span class="flex items-center">
                <i class="fas fa-filter mr-2"></i>
                Filters
                @if($country || $type || $ranking || $search)
                    <span class="ml-2 bg-white text-purple-600 text-xs px-2 py-1 rounded-full">
                        Active
                    </span>
                @endif
            </span>
            <i class="fas fa-chevron-{{ $showFilters ? 'up' : 'down' }}"></i>
        </button>
    </div>

    <!-- Filter Section -->
    <section class="py-8 px-4 bg-white shadow-md {{ $showFilters ? '' : 'hidden md:block' }} sticky top-36 md:top-20 z-30">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-4 gap-4">
                <!-- Search -->
                <div class="md:col-span-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search universities..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                </div>

                <!-- Country -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                    <select wire:model.live="country" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                        <option value="">All Countries</option>
                        @foreach($countries as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">University Type</label>
                    <select wire:model.live="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                        <option value="">All Types</option>
                        <option value="research">Research University</option>
                        <option value="public">Public University</option>
                        <option value="private">Private University</option>
                    </select>
                </div>

                <!-- Ranking -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ranking</label>
                    <select wire:model.live="ranking" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                        <option value="">All Rankings</option>
                        <option value="top100">Top 100</option>
                        <option value="top500">Top 500</option>
                    </select>
                </div>

                <!-- Clear Filters -->
                <div class="flex items-end">
                    <button
                        wire:click="clearFilters"
                        class="w-full px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition">
                        Clear Filters
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Universities Grid -->
    <section class="py-16 px-4 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            @if($universities->count() > 0)
                <div class="mb-8">
                    <p class="text-gray-600">{{ $universities->total() }} universities found</p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($universities as $university)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                        <!-- University Banner -->
                        <div class="h-48 bg-gradient-to-r from-purple-500 to-indigo-500 relative">
                            @if($university->banner_image_url)
                                <img src="{{ $university->banner_image_url }}" alt="{{ $university->name }}" class="w-full h-full object-cover">
                            @endif
                            @if($university->is_featured)
                                <div class="absolute top-4 right-4 bg-yellow-400 text-gray-900 px-3 py-1 rounded-full text-sm font-bold">
                                    Featured
                                </div>
                            @endif
                        </div>

                        <!-- University Logo -->
                        <div class="relative px-6 -mt-12">
                            <div class="bg-white w-24 h-24 rounded-full shadow-lg flex items-center justify-center p-2">
                                @if($university->logo_url)
                                    <img src="{{ $university->logo_url }}" alt="{{ $university->name }}" class="w-full h-full object-contain">
                                @else
                                    <i class="fas fa-university text-4xl text-purple-600"></i>
                                @endif
                            </div>
                        </div>

                        <!-- University Info -->
                        <div class="p-6 pt-4">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $university->name }}</h3>

                            <div class="flex items-center text-gray-600 text-sm mb-2">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                {{ $university->city ? $university->city . ', ' : '' }}{{ $university->country }}
                            </div>

                            @if($university->ranking)
                                <div class="flex items-center text-gray-600 text-sm mb-3">
                                    <i class="fas fa-trophy mr-2 text-yellow-500"></i>
                                    Ranked #{{ $university->ranking }} globally
                                </div>
                            @endif

                            @if($university->description)
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $university->description }}</p>
                            @endif

                            <!-- Stats -->
                            <div class="flex items-center justify-between text-sm text-gray-600 mb-4 pb-4 border-b">
                                <div class="flex items-center">
                                    <i class="fas fa-book mr-2 text-purple-600"></i>
                                    {{ $university->courses_count }} Courses
                                </div>
                                <div class="bg-gray-100 px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ ucfirst($university->type) }}
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-2">
                                @if($university->website)
                                    <a href="{{ $university->website }}" target="_blank" class="flex-1 text-center px-4 py-2 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition">
                                        Visit Website
                                    </a>
                                @endif
                                <button class="px-4 py-2 border-2 border-purple-600 text-purple-600 rounded-lg font-semibold hover:bg-purple-50 transition">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $universities->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <i class="fas fa-university text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-2xl font-bold text-gray-700 mb-2">No Universities Found</h3>
                    <p class="text-gray-500 mb-4">Try adjusting your filters or search criteria</p>
                    <button wire:click="clearFilters" class="px-6 py-3 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition">
                        Clear All Filters
                    </button>
                </div>
            @endif
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 px-4 bg-gradient-to-r from-purple-600 to-indigo-600">
        <div class="max-w-4xl mx-auto text-center text-white">
            <h2 class="text-4xl font-bold mb-4">Can't Find Your Ideal University?</h2>
            <p class="text-xl mb-8">Contact our expert counsellors for personalized recommendations</p>
            <a href="/contact" class="inline-block px-8 py-4 bg-white text-purple-600 rounded-lg font-semibold hover:bg-gray-100 transition">Get Free Consultation</a>
        </div>
    </section>
</div>
