<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};
use Firefly\FilamentBlog\Models\Post;

new
#[Layout('components.layouts.home')]
class extends Component {
    public Post $post;

    public function mount($slug)
    {
        $this->post = Post::with(['categories', 'user', 'tags', 'seoDetail'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->where(function($query) {
                $query->whereNull('published_at')
                      ->orWhere('published_at', '<=', now());
            })
            ->firstOrFail();
    }

    public function getTitle(): string
    {
        return $this->post->title;
    }
}; ?>

<div>
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-purple-600 to-indigo-600 pt-32 pb-16 px-4 mt-20">
        <div class="max-w-4xl mx-auto text-center text-white">
            <div class="flex flex-wrap gap-2 items-center justify-center mb-4">
                @foreach($post->categories as $category)
                    <span class="px-3 py-1 bg-white/20 backdrop-blur-sm text-white rounded-full text-sm font-semibold">
                        {{ $category->name }}
                    </span>
                @endforeach
            </div>
            <h1 class="text-5xl font-bold mb-4">{{ $post->title }}</h1>
            @if($post->sub_title)
                <p class="text-xl mb-6">{{ $post->sub_title }}</p>
            @endif
            <div class="flex items-center justify-center gap-4 text-sm">
                <div class="flex items-center">
                    @if($post->user->profile_photo_path)
                        <img src="{{ asset('storage/' . $post->user->profile_photo_path) }}" alt="{{ $post->user->name }}" class="w-10 h-10 rounded-full mr-3">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}&size=40&background=667eea&color=fff" alt="{{ $post->user->name }}" class="w-10 h-10 rounded-full mr-3">
                    @endif
                    <span class="font-semibold">{{ $post->user->name }}</span>
                </div>
                <span>•</span>
                <span><i class="far fa-calendar mr-2"></i>{{ $post->published_at ? $post->published_at->format('F d, Y') : $post->created_at->format('F d, Y') }}</span>
            </div>
        </div>
    </section>

    <!-- Featured Image -->
    @if($post->cover_photo_path)
    <section class="py-8 px-4">
        <div class="max-w-4xl mx-auto">
            <div class="relative w-full h-96 bg-gray-100 rounded-xl overflow-hidden shadow-lg">
                <img src="{{ asset('storage/' . $post->cover_photo_path) }}" alt="{{ $post->photo_alt_text }}" class="w-full h-full object-cover object-center">
            </div>
        </div>
    </section>
    @endif

    <!-- Article Content -->
    <article class="py-12 px-4">
        <div class="max-w-4xl mx-auto">
            <div class="prose prose-lg max-w-none">
                {!! $post->body !!}
            </div>

            <!-- Tags -->
            @if($post->tags->count() > 0)
            <div class="mt-12 pt-8 border-t border-gray-200">
                <h3 class="text-lg font-semibold mb-4">Tags</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($post->tags as $tag)
                        <a href="{{ route('home.blog') }}?tag={{ $tag->slug }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-purple-100 hover:text-purple-600 transition">
                            #{{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Author Bio -->
            <div class="mt-12 p-8 bg-gradient-to-r from-purple-50 to-indigo-50 rounded-xl">
                <div class="flex items-start gap-6">
                    @if($post->user->profile_photo_path)
                        <img src="{{ asset('storage/' . $post->user->profile_photo_path) }}" alt="{{ $post->user->name }}" class="w-20 h-20 rounded-full">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}&size=80&background=667eea&color=fff" alt="{{ $post->user->name }}" class="w-20 h-20 rounded-full">
                    @endif
                    <div>
                        <h3 class="text-2xl font-bold mb-2">{{ $post->user->name }}</h3>
                        <p class="text-gray-600">Author at {{ config('app.name') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </article>

    <!-- Related Posts -->
    <section class="py-12 px-4 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold mb-8">Related Articles</h2>
            <div class="grid md:grid-cols-3 gap-8">
                @php
                    $relatedPosts = Post::where('id', '!=', $post->id)
                        ->where('status', 'published')
                        ->whereHas('categories', function($query) use ($post) {
                            $query->whereIn('fblog_categories.id', $post->categories->pluck('id'));
                        })
                        ->limit(3)
                        ->get();
                @endphp

                @foreach($relatedPosts as $relatedPost)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                    <div class="h-56 overflow-hidden bg-gray-100">
                        @if($relatedPost->cover_photo_path)
                            <img src="{{ asset('storage/' . $relatedPost->cover_photo_path) }}" alt="{{ $relatedPost->photo_alt_text }}" class="w-full h-full object-cover object-center">
                        @else
                            <img src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=800" alt="{{ $relatedPost->title }}" class="w-full h-full object-cover object-center">
                        @endif
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            @if($relatedPost->categories->first())
                                <span class="px-3 py-1 bg-purple-100 text-purple-600 rounded-full text-xs font-semibold mr-3">
                                    {{ $relatedPost->categories->first()->name }}
                                </span>
                            @endif
                            <span class="text-gray-500 text-sm">
                                <i class="far fa-calendar mr-1"></i>
                                {{ $relatedPost->published_at ? $relatedPost->published_at->format('M d, Y') : $relatedPost->created_at->format('M d, Y') }}
                            </span>
                        </div>
                        <h3 class="text-xl font-bold mb-3">{{ $relatedPost->title }}</h3>
                        <p class="text-gray-600 mb-4">{{ $relatedPost->sub_title ?? Str::limit(strip_tags($relatedPost->body), 100) }}</p>
                        <a href="{{ route('blog.show', $relatedPost->slug) }}" class="text-purple-600 font-semibold hover:text-purple-700">
                            Read More <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-16 px-4 bg-gradient-to-r from-purple-600 to-indigo-600">
        <div class="max-w-4xl mx-auto text-center text-white">
            <h2 class="text-4xl font-bold mb-4">Subscribe to Our Newsletter</h2>
            <p class="text-xl mb-8">Get the latest articles, tips, and updates delivered to your inbox</p>
            <form class="flex flex-col sm:flex-row gap-4 max-w-2xl mx-auto">
                <input type="email" placeholder="Enter your email address" class="flex-1 px-6 py-4 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-white">
                <button type="submit" class="px-8 py-4 bg-white text-purple-600 rounded-lg font-semibold hover:bg-gray-100 transition">Subscribe</button>
            </form>
        </div>
    </section>
</div>
