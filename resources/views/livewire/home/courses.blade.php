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

        $categories = CourseCategory::active()->ordered()->get();
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
    <section class="bg-gradient-to-r from-purple-600 to-indigo-600 pt-32 pb-16 px-4 mt-20">
        <div class="max-w-7xl mx-auto text-center text-white">
            <h1 class="text-5xl font-bold mb-4">Explore Our Courses</h1>
            <p class="text-xl">Find the perfect program for your academic and career goals</p>
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
                @if($level || $category || $university || $search)
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
                        placeholder="Search courses..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                </div>

                <!-- Level -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Course Level</label>
                    <select wire:model.live="level" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                        <option value="">All Levels</option>
                        <option value="undergraduate">Undergraduate</option>
                        <option value="postgraduate">Postgraduate</option>
                        <option value="diploma">Diploma</option>
                        <option value="certificate">Certificate</option>
                    </select>
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Field of Study</label>
                    <select wire:model.live="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                        <option value="">All Fields</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- University -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">University</label>
                    <select wire:model.live="university" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                        <option value="">All Universities</option>
                        @foreach($universities as $uni)
                            <option value="{{ $uni->id }}">{{ $uni->name }}</option>
                        @endforeach
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

    <!-- Courses Grid -->
    <section class="py-16 px-4 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            @if($courses->count() > 0)
                <div class="mb-8">
                    <p class="text-gray-600">{{ $courses->total() }} courses found</p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($courses as $course)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                        <!-- Course Header -->
                        <div class="p-6 bg-gradient-to-r from-{{ $course->courseCategory->color ?? 'purple' }}-500 to-{{ $course->courseCategory->color ?? 'indigo' }}-500" style="background: linear-gradient(to right, {{ $course->courseCategory->color ?? '#9333ea' }}, {{ $course->courseCategory->color ?? '#6366f1' }});">
                            <div class="flex items-start justify-between mb-4">
                                <span class="px-3 py-1 bg-white bg-opacity-20 text-white rounded-full text-sm font-semibold">
                                    {{ ucfirst($course->level) }}
                                </span>
                                @if($course->is_featured)
                                    <span class="px-3 py-1 bg-yellow-400 text-gray-900 rounded-full text-sm font-bold">
                                        Featured
                                    </span>
                                @endif
                            </div>
                            <h3 class="text-xl font-bold text-white mb-2">{{ $course->name }}</h3>
                            <p class="text-white text-opacity-90 text-sm">{{ $course->university->name }}</p>
                        </div>

                        <!-- Course Body -->
                        <div class="p-6">
                            <!-- Category Badge -->
                            <div class="mb-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold" style="background-color: {{ $course->courseCategory->color }}20; color: {{ $course->courseCategory->color }};">
                                    @if($course->courseCategory->icon)
                                        <i class="fas fa-{{ $course->courseCategory->icon }} mr-2"></i>
                                    @endif
                                    {{ $course->courseCategory->name }}
                                </span>
                            </div>

                            @if($course->description)
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">{!! Str::limit(strip_tags($course->description), 150) !!}</p>
                            @endif

                            <!-- Course Details -->
                            <div class="space-y-2 mb-4 pb-4 border-b">
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-clock mr-2 text-purple-600"></i>
                                    {{ $course->duration }}
                                </div>
                                @if($course->tuition_fee)
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-dollar-sign mr-2 text-purple-600"></i>
                                        {{ $course->formatted_tuition_fee }}
                                    </div>
                                @endif
                                @if($course->mode_of_study)
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-graduation-cap mr-2 text-purple-600"></i>
                                        {{ $course->mode_of_study }}
                                    </div>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-2">
                                <button class="flex-1 px-4 py-2 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition">
                                    View Details
                                </button>
                                <button class="px-4 py-2 border-2 border-purple-600 text-purple-600 rounded-lg font-semibold hover:bg-purple-50 transition">
                                    <i class="fas fa-bookmark"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $courses->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <i class="fas fa-book-open text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-2xl font-bold text-gray-700 mb-2">No Courses Found</h3>
                    <p class="text-gray-500 mb-4">Try adjusting your filters or search criteria</p>
                    <button wire:click="clearFilters" class="px-6 py-3 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition">
                        Clear All Filters
                    </button>
                </div>
            @endif
        </div>
    </section>

    <!-- Course Categories Section -->
    @if($categories->count() > 0)
    <section class="py-16 px-4 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Browse by Field of Study</h2>
                <p class="text-xl text-gray-600">Explore courses across different academic disciplines</p>
            </div>

            <div class="grid md:grid-cols-4 gap-6">
                @foreach($categories as $cat)
                <button
                    wire:click="$set('category', '{{ $cat->id }}')"
                    class="p-6 bg-white border-2 border-gray-200 rounded-xl hover:border-purple-600 hover:shadow-lg transition-all duration-300 text-center group">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center" style="background-color: {{ $cat->color }}20;">
                        @if($cat->icon)
                            <i class="fas fa-{{ $cat->icon }} text-3xl" style="color: {{ $cat->color }};"></i>
                        @endif
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2 group-hover:text-purple-600">{{ $cat->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $cat->courses_count ?? 0 }} courses</p>
                </button>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- CTA Section -->
    <section class="py-16 px-4 bg-gradient-to-r from-purple-600 to-indigo-600">
        <div class="max-w-4xl mx-auto text-center text-white">
            <h2 class="text-4xl font-bold mb-4">Need Help Choosing the Right Course?</h2>
            <p class="text-xl mb-8">Our expert counsellors are here to guide you</p>
            <a href="/contact" class="inline-block px-8 py-4 bg-white text-purple-600 rounded-lg font-semibold hover:bg-gray-100 transition">Get Free Consultation</a>
        </div>
    </section>
</div>
