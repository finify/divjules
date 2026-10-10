<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title, Url};
use Livewire\WithPagination;
use Firefly\FilamentBlog\Models\Post;
use Firefly\FilamentBlog\Models\Category;

new
#[Layout('components.layouts.home')]
#[Title('Blog & News')]
class extends Component {
    use WithPagination;

    #[Url]
    public $category = '';

    #[Url]
    public $search = '';

    #[Url]
    public $tag = '';

    public function with(): array
    {
        $query = Post::with(['categories', 'user', 'tags'])
            ->where('status', 'published')
            ->where(function($q) {
                $q->whereNull('published_at')
                  ->orWhere('published_at', '<=', now());
            })
            ->latest('published_at');

        // Filter by category
        if ($this->category) {
            $query->whereHas('categories', function($q) {
                $q->where('slug', $this->category);
            });
        }

        // Filter by tag
        if ($this->tag) {
            $query->whereHas('tags', function($q) {
                $q->where('slug', $this->tag);
            });
        }

        // Search
        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('sub_title', 'like', '%' . $this->search . '%')
                  ->orWhere('body', 'like', '%' . $this->search . '%');
            });
        }

        $posts = $query->paginate(9);
        $featuredPost = Post::where('status', 'published')
            ->where(function($q) {
                $q->whereNull('published_at')
                  ->orWhere('published_at', '<=', now());
            })
            ->latest('published_at')
            ->first();

        $categories = Category::withCount('posts')->get();

        return [
            'posts' => $posts,
            'featuredPost' => $featuredPost,
            'categories' => $categories,
        ];
    }

    public function filterCategory($slug)
    {
        $this->category = $slug === 'all' ? '' : $slug;
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }
}; ?>

<div>
    <!-- Hero Section -->
    <section style="--hero-img: url('/homeassets/img/site/library-modern.webp')" class="page-hero pt-40 md:pt-48 pb-20 md:pb-28 px-4">
        <div class="max-w-7xl mx-auto text-center text-white">
            <h1 class="text-5xl font-bold mb-4">Blog & News</h1>
            <p class="text-xl">Stay updated with the latest insights, tips, and news about studying abroad</p>
        </div>
    </section>

    <!-- Filter Section -->
    <section class="relative z-20 -mt-9 px-4" data-no-auto>
        <div class="max-w-5xl mx-auto">
            <div class="filter-bar surface rounded-2xl md:rounded-full p-1.5 flex flex-col md:flex-row md:items-center gap-1.5">
                <div class="flex gap-1.5 overflow-x-auto scrollbar-hide md:flex-1 min-w-0">
                    <button wire:click="filterCategory('all')" class="chip shrink-0 !border-transparent" aria-pressed="{{ !$category ? 'true' : 'false' }}">All posts</button>
                    @foreach($categories as $cat)
                        <button wire:click="filterCategory('{{ $cat->slug }}')" class="chip shrink-0 !border-transparent" aria-pressed="{{ $category === $cat->slug ? 'true' : 'false' }}">{{ $cat->name }}</button>
                    @endforeach
                </div>
                <label class="relative md:w-72 shrink-0">
                    <span class="sr-only">Search articles</span>
                    <i class="fas fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-sm text-muted pointer-events-none"></i>
                    <input type="search" wire:model.live.debounce.500ms="search" placeholder="Search articles..." class="filter-input w-full h-11 pl-10 pr-3 rounded-full">
                </label>
            </div>
        </div>
    </section>

    <!-- Featured Post -->
    @if($featuredPost && !$category && !$search && !$tag)
    <section class="py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold mb-8">Featured Article</h2>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                <div class="grid md:grid-cols-2">
                    <div class="h-96 bg-gray-100">
                        @if($featuredPost->cover_photo_path)
                            <img src="{{ asset('storage/' . $featuredPost->cover_photo_path) }}" alt="{{ $featuredPost->photo_alt_text }}" class="w-full h-full object-cover object-center">
                        @else
                            <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=800" alt="{{ $featuredPost->title }}" class="w-full h-full object-cover object-center">
                        @endif
                    </div>
                    <div class="p-8 flex flex-col justify-center">
                        <div class="flex items-center mb-4">
                            @if($featuredPost->categories->first())
                                <span class="px-3 py-1 bg-sky-100 text-sky-700 rounded-full text-sm font-semibold mr-3">
                                    {{ $featuredPost->categories->first()->name }}
                                </span>
                            @endif
                            <span class="text-gray-500 text-sm">
                                <i class="far fa-calendar mr-2"></i>
                                {{ $featuredPost->published_at ? $featuredPost->published_at->format('F d, Y') : $featuredPost->created_at->format('F d, Y') }}
                            </span>
                        </div>
                        <h3 class="text-3xl font-bold mb-4">{{ $featuredPost->title }}</h3>
                        <p class="text-gray-600 text-lg mb-6">{{ $featuredPost->sub_title ?? Str::limit(strip_tags($featuredPost->body), 150) }}</p>
                        <div class="flex items-center mb-6">
                            @if($featuredPost->user->profile_photo_path)
                                <img src="{{ asset('storage/' . $featuredPost->user->profile_photo_path) }}" alt="{{ $featuredPost->user->name }}" class="w-10 h-10 rounded-full mr-3">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($featuredPost->user->name) }}&size=40&background=667eea&color=fff" alt="{{ $featuredPost->user->name }}" class="w-10 h-10 rounded-full mr-3">
                            @endif
                            <div>
                                <p class="font-semibold">{{ $featuredPost->user->name }}</p>
                            </div>
                        </div>
                        <a href="{{ route('blog.show', $featuredPost->slug) }}" class="inline-block px-6 py-3 bg-sky-700 text-white rounded-lg font-semibold hover:bg-sky-800 transition">Read Full Article</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Blog Grid -->
    <section class="py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold mb-8">
                @if($category)
                    {{ $categories->firstWhere('slug', $category)?->name }} Articles
                @elseif($search)
                    Search Results for "{{ $search }}"
                @else
                    Latest Articles
                @endif
            </h2>

            @if($posts->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($posts as $post)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                        <div class="h-56 overflow-hidden bg-gray-100">
                            @if($post->cover_photo_path)
                                <img src="{{ asset('storage/' . $post->cover_photo_path) }}" alt="{{ $post->photo_alt_text }}" class="w-full h-full object-cover object-center">
                            @else
                                <img src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=800" alt="{{ $post->title }}" class="w-full h-full object-cover object-center">
                            @endif
                        </div>
                        <div class="p-6">
                            <div class="flex items-center mb-3">
                                @if($post->categories->first())
                                    <span class="px-3 py-1 bg-sky-100 text-sky-700 rounded-full text-xs font-semibold mr-3">
                                        {{ $post->categories->first()->name }}
                                    </span>
                                @endif
                                <span class="text-gray-500 text-sm">
                                    <i class="far fa-calendar mr-1"></i>
                                    {{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}
                                </span>
                            </div>
                            <h3 class="text-xl font-bold mb-3">{{ $post->title }}</h3>
                            <p class="text-gray-600 mb-4">{{ $post->sub_title ?? Str::limit(strip_tags($post->body), 100) }}</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    @if($post->user->profile_photo_path)
                                        <img src="{{ asset('storage/' . $post->user->profile_photo_path) }}" alt="{{ $post->user->name }}" class="w-8 h-8 rounded-full mr-2">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}&size=32&background=764ba2&color=fff" alt="{{ $post->user->name }}" class="w-8 h-8 rounded-full mr-2">
                                    @endif
                                    <span class="text-sm font-semibold">{{ $post->user->name }}</span>
                                </div>
                                <a href="{{ route('blog.show', $post->slug) }}" class="text-sky-700 font-semibold hover:text-sky-800">Read More <i class="fas fa-arrow-right ml-1"></i></a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $posts->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="text-gray-400 mb-4">
                        <i class="fas fa-search text-6xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-700 mb-2">No Articles Found</h3>
                    <p class="text-gray-600 mb-6">Try adjusting your search or filter criteria</p>
                    <button wire:click="filterCategory('all')" class="px-6 py-3 bg-sky-700 text-white rounded-lg font-semibold hover:bg-sky-800 transition">
                        View All Articles
                    </button>
                </div>
            @endif
        </div>
    </section>

    <!-- Newsletter Section -->
    <section style="--hero-img: url('/homeassets/img/site/students-library.webp')" class="page-hero brand-band py-24 md:py-32 px-4" data-preset="cta">
        <div class="max-w-4xl mx-auto text-center text-white">
            <h2 class="text-4xl font-bold mb-4">Subscribe to Our Newsletter</h2>
            <p class="text-xl mb-8">Get the latest articles, tips, and updates delivered to your inbox</p>
            <form class="flex flex-col sm:flex-row gap-4 max-w-2xl mx-auto">
                <input type="email" placeholder="Enter your email address" class="flex-1 px-6 py-4 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-white">
                <button type="submit" class="px-8 py-4 bg-white text-sky-700 rounded-lg font-semibold hover:bg-gray-100 transition">Subscribe</button>
            </form>
        </div>
    </section>
</div>
