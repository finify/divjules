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
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-purple-600 to-indigo-600 py-20 mt-20">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center text-white">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Student Reviews</h1>
                <p class="text-xl text-purple-100 mb-6">See what our students have to say about their experience with Divjules</p>

                @if($totalReviews > 0)
                <div class="flex items-center justify-center gap-4 mt-8">
                    <div class="bg-white rounded-lg px-6 py-4 text-gray-800">
                        <div class="text-4xl font-bold text-purple-600">{{ number_format($averageRating, 1) }}</div>
                        <div class="flex text-yellow-400 text-xl my-2">
                            @for($i = 0; $i < floor($averageRating); $i++)
                                <i class="fas fa-star"></i>
                            @endfor
                            @if($averageRating - floor($averageRating) >= 0.5)
                                <i class="fas fa-star-half-alt"></i>
                            @endif
                        </div>
                        <div class="text-sm text-gray-600">Based on {{ $totalReviews }} reviews</div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Filter Section -->
    @if($totalReviews > 0)
    <section class="py-8 bg-gray-50 border-b">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Filter by Rating:</h3>
                </div>
                <div class="flex flex-wrap gap-2">
                    <button wire:click="$set('filterRating', null)"
                            class="px-4 py-2 rounded-lg font-medium transition {{ $filterRating === null ? 'bg-purple-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                        All Reviews
                    </button>
                    @foreach([5, 4, 3, 2, 1] as $rating)
                        <button wire:click="$set('filterRating', {{ $rating }})"
                                class="px-4 py-2 rounded-lg font-medium transition {{ $filterRating === $rating ? 'bg-purple-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                            <span class="flex items-center gap-2">
                                {{ $rating }} <i class="fas fa-star text-yellow-400"></i>
                                <span class="text-xs opacity-75">({{ $ratingCounts[$rating] }})</span>
                            </span>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Reviews Grid -->
    <section class="py-16 px-4 bg-white">
        <div class="max-w-7xl mx-auto">
            @if($testimonials->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                    @foreach($testimonials as $testimonial)
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition card-hover border border-gray-100">
                        <div class="flex items-center mb-6">
                            @if($testimonial->photo)
                                <img src="{{ $testimonial->photo_url }}" alt="{{ $testimonial->student_name }}" class="w-16 h-16 rounded-full object-cover mr-4">
                            @else
                                <div class="w-16 h-16 rounded-full bg-purple-100 flex items-center justify-center mr-4">
                                    <span class="text-2xl font-bold text-purple-600">{{ substr($testimonial->student_name, 0, 1) }}</span>
                                </div>
                            @endif
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-800">{{ $testimonial->student_name }}</h3>
                                <p class="text-sm text-gray-600">{{ $testimonial->university }}</p>
                                @if($testimonial->course)
                                    <p class="text-xs text-gray-500">{{ $testimonial->course }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="flex text-yellow-500 mb-4">
                            @for($i = 0; $i < $testimonial->rating; $i++)
                                <i class="fas fa-star"></i>
                            @endfor
                            @for($i = $testimonial->rating; $i < 5; $i++)
                                <i class="far fa-star"></i>
                            @endfor
                        </div>

                        <p class="text-gray-700 leading-relaxed">
                            "{{ $testimonial->review }}"
                        </p>

                        @if($testimonial->approved_at)
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <p class="text-xs text-gray-400">
                                Reviewed on {{ $testimonial->approved_at->format('M d, Y') }}
                            </p>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $testimonials->links() }}
                </div>
            @else
                <!-- No Reviews Found -->
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-comments text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">No Reviews Found</h3>
                    <p class="text-gray-600 mb-8">
                        @if($filterRating)
                            No reviews with {{ $filterRating }} stars yet. Try adjusting your filter.
                        @else
                            Be the first to share your experience with Divjules!
                        @endif
                    </p>
                    @if($filterRating)
                        <button wire:click="$set('filterRating', null)" class="px-6 py-3 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition">
                            View All Reviews
                        </button>
                    @endif
                </div>
            @endif
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 px-4 bg-gradient-to-r from-purple-600 to-indigo-600">
        <div class="max-w-4xl mx-auto text-center text-white">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Share Your Experience</h2>
            <p class="text-xl text-purple-100 mb-8">Had a great experience with Divjules? Let others know!</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('home.submit-review') }}" class="px-8 py-4 bg-white text-purple-600 rounded-lg font-bold text-lg hover:bg-gray-100 transition shadow-lg transform hover:scale-105">
                    <i class="fas fa-pen mr-2"></i>Write a Review
                </a>
                <a href="/" class="px-8 py-4 bg-transparent border-2 border-white text-white rounded-lg font-bold text-lg hover:bg-white hover:text-purple-600 transition shadow-lg transform hover:scale-105">
                    <i class="fas fa-home mr-2"></i>Back to Home
                </a>
            </div>
        </div>
    </section>
</div>
