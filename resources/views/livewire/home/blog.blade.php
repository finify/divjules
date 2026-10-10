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
    <section style="--hero-img: url('/homeassets/img/site/library-modern.webp')" class="page-hero pt-40 md:pt-48 pb-24 md:pb-32 px-4">
        <div class="max-w-4xl mx-auto text-center text-white">
            <span class="eyebrow !text-sky-300 justify-center">The Divjules blog</span>
            <h1 class="mt-5">Guides for studying abroad</h1>
            <p class="mt-5 text-xl">Applications, scholarships, visas and student life — explained by our counsellors.</p>
        </div>
    </section>

    <!-- Filter Section -->
    <section class="relative z-20 -mt-9 px-4" data-no-auto data-dock-search>
        <div class="max-w-5xl mx-auto">
            <div class="filter-bar surface rounded-2xl md:rounded-full p-1.5 flex flex-col md:flex-row md:items-center gap-1.5">
                <div class="flex gap-1.5 overflow-x-auto scrollbar-hide md:flex-1 min-w-0" data-lenis-prevent>
                    <button wire:click="filterCategory('all')" class="chip shrink-0 !border-transparent" aria-pressed="{{ !$category ? 'true' : 'false' }}">All posts</button>
                    @foreach($categories as $cat)
                        <button wire:click="filterCategory('{{ $cat->slug }}')" class="chip shrink-0 !border-transparent" aria-pressed="{{ $category === $cat->slug ? 'true' : 'false' }}">{{ $cat->name }} <span class="opacity-60 text-xs">{{ $cat->posts_count }}</span></button>
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

    @if($featuredPost && !$category && !$search && !$tag && $posts->onFirstPage())
        @php
            $f = $featuredPost;
            $fDate = $f->published_at ?? $f->created_at;
            $fCover = $f->cover_photo_path ? asset('storage/' . $f->cover_photo_path) : asset('homeassets/img/site/students-library.webp');
        @endphp
        <section class="pt-16 px-4" data-no-auto>
            <article class="max-w-7xl mx-auto relative grid lg:grid-cols-2 overflow-hidden rounded-[2rem] surface group" data-reveal>
                <div class="relative min-h-[280px] lg:min-h-[460px] overflow-hidden">
                    <img src="{{ $fCover }}" alt="{{ $f->photo_alt_text ?: $f->title }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-[1.4s] ease-[cubic-bezier(.23,1,.32,1)] group-hover:scale-105">
                    <span class="uni-chip absolute top-5 left-5 !bg-amber-400 !text-[#1a1a4e]"><i class="fas fa-bolt"></i>Featured</span>
                </div>
                <div class="p-8 md:p-12 flex flex-col justify-center">
                    <p class="text-xs font-mono uppercase tracking-wider text-muted">
                        @if($f->categories->first()){{ $f->categories->first()->name }} · @endif
                        <time datetime="{{ $fDate->toDateString() }}">{{ $fDate->format('F j, Y') }}</time>
                    </p>
                    <h2 class="h-display text-3xl md:text-5xl mt-4 !leading-[1.08]">
                        <a href="{{ route('blog.show', $f->slug) }}" class="after:absolute after:inset-0">{{ $f->title }}</a>
                    </h2>
                    <p class="mt-5 text-lg text-muted line-clamp-3">{{ $f->sub_title ?: Str::limit(strip_tags($f->body), 180) }}</p>
                    <span class="mt-8 inline-flex items-center gap-2 font-medium text-accent group-hover:gap-3 transition-all">Read the article <i class="fas fa-arrow-right text-xs"></i></span>
                </div>
            </article>
        </section>
    @endif

    <section class="py-16 md:py-20 px-4" data-no-auto>
        <div class="max-w-7xl mx-auto">
            <div class="flex items-end justify-between gap-4 mb-8">
                <h2 class="h-display text-3xl md:text-4xl">
                    @if($category)
                        {{ $categories->firstWhere('slug', $category)?->name }}
                    @elseif($search)
                        Results for “{{ $search }}”
                    @else
                        Latest articles
                    @endif
                </h2>
                @if($posts->total())<p class="text-sm text-muted">{{ $posts->total() }} {{ Str::plural('article', $posts->total()) }}</p>@endif
            </div>

            @if($posts->count() > 0)
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6" wire:loading.class="opacity-50" style="transition: opacity .2s ease">
                    @foreach($posts as $post)
                        <div wire:key="post-{{ $post->id }}" class="card-in" style="--i: {{ $loop->index }}"><x-post-card :post="$post" /></div>
                    @endforeach
                </div>
                <div class="mt-14">{{ $posts->links() }}</div>
            @else
                <div class="card max-w-lg mx-auto text-center py-14">
                    <span class="icon-tile w-16 h-16 mx-auto text-2xl"><i class="fas fa-newspaper"></i></span>
                    <h3 class="mt-6 text-2xl font-semibold text-ink">No articles found</h3>
                    <p class="mt-2 text-muted">Try another search or browse all posts.</p>
                    <button wire:click="filterCategory('all')" class="btn btn-primary mt-6">View all articles</button>
                </div>
            @endif
        </div>
    </section>

    <section class="px-4 pb-24" data-no-auto>
        <div class="max-w-7xl mx-auto brand-band relative overflow-hidden rounded-[2rem] text-white p-8 md:p-14 grid lg:grid-cols-2 gap-8 items-center"
            style="background: linear-gradient(120deg, rgba(26,26,78,.95), rgba(15,15,46,.9)), url('/homeassets/img/site/students-library.webp') center/cover;" data-reveal>
            <div>
                <span class="eyebrow !text-sky-300">Newsletter</span>
                <h2 class="mt-4 text-3xl md:text-4xl font-semibold tracking-tight">Study-abroad tips in your inbox</h2>
                <p class="mt-3 text-white/70">Intake deadlines, scholarship alerts and visa updates — once a month, no spam.</p>
            </div>
            <form class="flex flex-col sm:flex-row gap-3">
                <label class="sr-only" for="newsletter-email">Email address</label>
                <input id="newsletter-email" type="email" required placeholder="Enter your email address" class="flex-1 h-14 px-6 rounded-full !bg-white/10 !border !border-white/20 !text-white placeholder:!text-white/50 focus:!border-sky-300 focus:outline-none">
                <button type="submit" class="btn btn-light h-14">Subscribe</button>
            </form>
        </div>
    </section>
</div>
