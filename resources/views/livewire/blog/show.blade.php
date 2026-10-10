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

    public function rendering($view): void
    {
        $p = $this->post;
        $seo = $p->seoDetail;
        $date = $p->published_at ?? $p->created_at;
        $cover = $p->cover_photo_path ? asset('storage/' . $p->cover_photo_path) : asset('homeassets/img/site/og-default.jpg');
        $description = $seo->description ?? ($p->sub_title ?: \Illuminate\Support\Str::limit(strip_tags($p->body), 160));

        $view->layoutData([
            'title' => $p->title,
            'metaTitle' => ($seo->title ?? $p->title) . ' | Divjules Blog',
            'metaDescription' => $description,
            'metaImage' => $cover,
            'metaType' => 'article',
            'breadcrumbs' => [['Blog', route('home.blog')], [$p->title, route('blog.show', $p->slug)]],
            'schema' => [[
                '@type' => 'BlogPosting',
                'headline' => \Illuminate\Support\Str::limit($p->title, 110, ''),
                'description' => $description,
                'image' => $cover,
                'datePublished' => $date->toAtomString(),
                'dateModified' => $p->updated_at->toAtomString(),
                'author' => ['@type' => 'Person', 'name' => $p->user->name ?? 'Divjules'],
                'publisher' => ['@id' => url('/') . '#org'],
                'mainEntityOfPage' => route('blog.show', $p->slug),
            ]],
        ]);
    }

    public function with(): array
    {
        $related = Post::with(['categories', 'user'])
            ->where('id', '!=', $this->post->id)
            ->where('status', 'published')
            ->whereHas('categories', fn ($q) => $q->whereIn('fblog_categories.id', $this->post->categories->pluck('id')))
            ->latest('published_at')->limit(3)->get();

        if ($related->count() < 3) {
            $related = $related->concat(
                Post::with(['categories', 'user'])->where('status', 'published')
                    ->whereNotIn('id', $related->pluck('id')->push($this->post->id))
                    ->latest('published_at')->limit(3 - $related->count())->get()
            );
        }

        return ['related' => $related];
    }
}; ?>

@php
    $date = $post->published_at ?? $post->created_at;
    $minutes = max(1, (int) ceil(str_word_count(strip_tags((string) $post->body)) / 200));
    $cover = $post->cover_photo_path ? asset('storage/' . $post->cover_photo_path) : asset('homeassets/img/site/library.webp');
    $shareUrl = urlencode(route('blog.show', $post->slug));
    $shareText = urlencode($post->title);
@endphp

<div>
    <div class="read-progress" data-read-progress aria-hidden="true"></div>

    <section style="--hero-img: url('{{ $cover }}')" class="page-hero pt-36 md:pt-44 pb-20 md:pb-28 px-4">
        <div class="max-w-4xl mx-auto text-center text-white">
            <nav class="text-sm text-white/60 mb-8" aria-label="Breadcrumb">
                <a href="{{ route('home.index') }}" class="hover:text-white">Home</a>
                <i class="fas fa-chevron-right text-[10px] mx-2"></i>
                <a href="{{ route('home.blog') }}" class="hover:text-white">Blog</a>
            </nav>
            <div class="flex flex-wrap gap-2 justify-center mb-6">
                @foreach($post->categories as $category)
                    <a href="{{ route('home.blog', ['category' => $category->slug]) }}" class="uni-chip hover:!bg-white/25 transition">{{ $category->name }}</a>
                @endforeach
            </div>
            <h1 style="font-size: clamp(2.2rem, 5.5vw, 4.25rem);">{{ $post->title }}</h1>
            @if($post->sub_title)
                <p class="mt-5 text-xl">{{ $post->sub_title }}</p>
            @endif
            <div class="mt-8 flex flex-wrap items-center justify-center gap-x-5 gap-y-2 text-sm text-white/75">
                <span class="flex items-center gap-2.5">
                    <span class="grid place-items-center w-9 h-9 rounded-full bg-white/15 font-semibold">{{ Str::upper(Str::substr($post->user->name ?? 'D', 0, 1)) }}</span>
                    <span class="text-white font-medium">{{ $post->user->name ?? 'Divjules' }}</span>
                </span>
                <span><i class="far fa-calendar mr-1.5"></i><time datetime="{{ $date->toDateString() }}">{{ $date->format('F j, Y') }}</time></span>
                <span><i class="far fa-clock mr-1.5"></i>{{ $minutes }} min read</span>
            </div>
        </div>
    </section>

    @if($post->cover_photo_path)
        <section class="relative z-10 -mt-12 px-4" data-no-auto>
            <figure class="max-w-5xl mx-auto rounded-[2rem] overflow-hidden aspect-[16/8] shadow-[var(--shadow-lg)]">
                <img src="{{ $cover }}" alt="{{ $post->photo_alt_text ?: $post->title }}" class="w-full h-full object-cover" data-img-zoom>
            </figure>
        </section>
    @endif

    <section class="py-16 md:py-20 px-4" data-no-auto>
        <div class="max-w-5xl mx-auto grid lg:grid-cols-[64px_1fr] gap-10">
            <aside class="hidden lg:block">
                <div class="sticky top-28 flex flex-col items-center gap-3">
                    <span class="font-mono text-[10px] uppercase tracking-widest text-muted [writing-mode:vertical-rl] rotate-180 mb-2">Share</span>
                    <a href="https://wa.me/?text={{ $shareText }}%20{{ $shareUrl }}" target="_blank" rel="noopener" class="theme-toggle" aria-label="Share on WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}" target="_blank" rel="noopener" class="theme-toggle" aria-label="Share on LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareText }}" target="_blank" rel="noopener" class="theme-toggle" aria-label="Share on X"><i class="fab fa-x-twitter"></i></a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener" class="theme-toggle" aria-label="Share on Facebook"><i class="fab fa-facebook-f"></i></a>
                    <button type="button" class="theme-toggle" aria-label="Copy link" onclick="navigator.clipboard.writeText(location.href); this.innerHTML='<i class=\'fas fa-check\'></i>'"><i class="fas fa-link"></i></button>
                </div>
            </aside>

            <article class="min-w-0 max-w-3xl">
                <div class="article-body">
                    {!! $post->body !!}
                </div>

                @if($post->tags->count() > 0)
                    <div class="mt-14 pt-8 border-t border-line flex flex-wrap gap-2">
                        @foreach($post->tags as $tag)
                            <a href="{{ route('home.blog') }}?tag={{ $tag->slug }}" class="chip">#{{ $tag->name }}</a>
                        @endforeach
                    </div>
                @endif

                <div class="mt-10 lg:hidden flex gap-2">
                    <a href="https://wa.me/?text={{ $shareText }}%20{{ $shareUrl }}" target="_blank" rel="noopener" class="theme-toggle" aria-label="Share on WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}" target="_blank" rel="noopener" class="theme-toggle" aria-label="Share on LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareText }}" target="_blank" rel="noopener" class="theme-toggle" aria-label="Share on X"><i class="fab fa-x-twitter"></i></a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener" class="theme-toggle" aria-label="Share on Facebook"><i class="fab fa-facebook-f"></i></a>
                </div>

                <div class="mt-10 card flex items-center gap-5">
                    <span class="grid place-items-center w-16 h-16 rounded-full bg-[var(--accent-soft)] text-accent text-xl font-semibold shrink-0">{{ Str::upper(Str::substr($post->user->name ?? 'D', 0, 1)) }}</span>
                    <div>
                        <p class="text-xs font-mono uppercase tracking-wider text-muted">Written by</p>
                        <p class="mt-1 text-lg font-semibold text-ink">{{ $post->user->name ?? 'Divjules' }}</p>
                        <p class="text-sm text-muted">Divjules Educational Consult</p>
                    </div>
                </div>

                <div class="mt-6 card brand-band !bg-[#1a1a4e] !border-transparent text-white flex flex-col sm:flex-row sm:items-center justify-between gap-5">
                    <div>
                        <p class="text-lg font-semibold">Have questions about studying abroad?</p>
                        <p class="text-white/70 text-sm mt-1">Talk to a counsellor. It's free.</p>
                    </div>
                    <a href="{{ route('home.contact') }}" class="btn btn-light shrink-0">Book a consultation</a>
                </div>
            </article>
        </div>
    </section>

    @if($related->count())
        <section class="py-20 px-4 bg-page-alt" data-no-auto>
            <div class="max-w-7xl mx-auto">
                <div class="flex items-end justify-between gap-4 mb-8">
                    <h2 class="h-display text-3xl md:text-4xl" data-reveal>Keep reading</h2>
                    <a href="{{ route('home.blog') }}" class="text-sm font-medium text-accent inline-flex items-center gap-1.5">All articles <i class="fas fa-arrow-right text-xs"></i></a>
                </div>
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($related as $item)
                        <div data-reveal><x-post-card :post="$item" /></div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</div>
