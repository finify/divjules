<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title, Url};
use Livewire\WithPagination;
use App\Models\Course;
use App\Models\University;
use App\Models\CourseCategory;

new
#[Layout('components.layouts.home')]
#[Title('Explore Courses')]
class extends Component {
    use WithPagination;

    #[Url]
    public $level = '';

    #[Url]
    public $category = '';

    #[Url]
    public $university = '';

    #[Url]
    public $search = '';

    public $showFilters = false;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedLevel()
    {
        $this->resetPage();
    }

    public function updatedCategory()
    {
        $this->resetPage();
    }

    public function updatedUniversity()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['level', 'category', 'university', 'search']);
        $this->resetPage();
    }

    public function with(): array
    {
        $query = Course::query()
            ->active()
            ->with(['university', 'courseCategory']);

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhereHas('university', function($uq) {
                      $uq->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if ($this->level) {
            $query->where('level', $this->level);
        }

        if ($this->category) {
            $query->where('course_category_id', $this->category);
        }

        if ($this->university) {
            $query->where('university_id', $this->university);
        }

        $courses = $query->ordered()->paginate(12);

        $categories = CourseCategory::active()->ordered()->withCount(['courses' => fn ($q) => $q->active()])->get();
        $universities = University::active()->ordered()->get();

        return [
            'courses' => $courses,
            'categories' => $categories,
            'universities' => $universities,
        ];
    }
}; ?>

<div>
    <!-- Hero Section -->
    <section style="--hero-img: url('/homeassets/img/site/lecture.webp')" class="page-hero pt-40 md:pt-48 pb-20 md:pb-28 px-4">
        <div class="max-w-7xl mx-auto text-center text-white">
            <h1 class="text-5xl font-bold mb-4">Explore Our Courses</h1>
            <p class="text-xl">Find the perfect program for your academic and career goals</p>
        </div>
    </section>

    <x-filter-bar placeholder="Search courses..." :active="$level || $category || $university || $search" :open="$showFilters">
        <select wire:model.live="level" class="filter-select" aria-label="Course level">
            <option value="">All levels</option>
            <option value="undergraduate">Undergraduate</option>
            <option value="postgraduate">Postgraduate</option>
            <option value="diploma">Diploma</option>
            <option value="certificate">Certificate</option>
        </select>
        <select wire:model.live="category" class="filter-select" aria-label="Field of study">
            <option value="">All fields</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>
        <select wire:model.live="university" class="filter-select" aria-label="University">
            <option value="">All universities</option>
            @foreach($universities as $uni)
                <option value="{{ $uni->id }}">{{ $uni->name }}</option>
            @endforeach
        </select>
    </x-filter-bar>

    <!-- Courses grid -->
    <section class="pt-14 pb-24 px-4" data-no-auto>
        <div class="max-w-7xl mx-auto">
            @if($courses->count() > 0)
                <div class="results-bar">
                    <p class="text-muted"><span class="text-ink font-semibold">{{ $courses->total() }}</span> {{ Str::plural('course', $courses->total()) }} found</p>
                    <p class="text-sm text-muted hidden sm:block">Showing {{ $courses->firstItem() }}–{{ $courses->lastItem() }}</p>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6" wire:loading.class="opacity-50 pointer-events-none" style="transition: opacity .2s ease">
                    @foreach($courses as $item)
                        <div wire:key="course-{{ $item->id }}" class="card-in" style="--i: {{ $loop->index }}">
                            <x-course-card :course="$item" />
                        </div>
                    @endforeach
                </div>

                <div class="mt-14">
                    {{ $courses->links() }}
                </div>
            @else
                <div class="card max-w-lg mx-auto text-center py-14">
                    <span class="icon-tile w-16 h-16 mx-auto text-2xl"><i class="fas fa-book-open"></i></span>
                    <h3 class="mt-6 text-2xl font-semibold text-ink">No courses found</h3>
                    <p class="mt-2 text-muted">Try a different search, or clear your filters.</p>
                    <button wire:click="clearFilters" class="btn btn-primary mt-6">Clear all filters</button>
                </div>
            @endif
        </div>
    </section>

    <!-- Course Categories Section -->
    @if($categories->count() > 0)
    <section class="py-24 px-4 bg-page-alt" data-no-auto>
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
                <div>
                    <span class="eyebrow" data-reveal>Fields of study</span>
                    <h2 class="h-display text-4xl md:text-5xl mt-4" data-reveal>Browse by subject</h2>
                </div>
                <p class="text-muted max-w-sm" data-reveal>Tap a subject to filter the course list above.</p>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($categories as $cat)
                <button type="button" wire:click="$set('category', '{{ $cat->id }}')" onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
                    class="card !p-5 text-left group {{ (string) $category === (string) $cat->id ? '!border-[var(--accent)]' : '' }}" data-reveal data-spotlight>
                    <span class="icon-tile group-hover:bg-[var(--accent)] group-hover:text-white transition-colors"><i class="fas fa-{{ $cat->icon ?: 'graduation-cap' }}"></i></span>
                    <h3 class="mt-4 font-semibold text-ink">{{ $cat->name }}</h3>
                    <p class="mt-1 text-sm text-muted">{{ $cat->courses_count }} {{ Str::plural('course', $cat->courses_count) }}</p>
                </button>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- CTA Section -->
    <section style="--hero-img: url('/homeassets/img/site/students-cafe.webp')" class="page-hero brand-band py-24 md:py-32 px-4">
        <div class="max-w-4xl mx-auto text-center text-white">
            <h2 class="text-4xl font-bold mb-4">Need Help Choosing the Right Course?</h2>
            <p class="text-xl mb-8">Our expert counsellors are here to guide you</p>
            <a href="/contact" class="inline-block px-8 py-4 bg-white text-sky-700 rounded-lg font-semibold hover:bg-gray-100 transition">Get Free Consultation</a>
        </div>
    </section>
</div>
