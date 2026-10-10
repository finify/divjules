@props(['post'])
@php
    $p = $post;
    $date = $p->published_at ?? $p->created_at;
    $minutes = max(1, (int) ceil(str_word_count(strip_tags((string) $p->body)) / 200));
    $fallbacks = ['students-library', 'library-modern', 'students-cafe', 'study-group', 'campus', 'lecture'];
    $cover = $p->cover_photo_path ? asset('storage/' . $p->cover_photo_path) : asset('homeassets/img/site/' . $fallbacks[$p->id % count($fallbacks)] . '.webp');
@endphp

<article class="post-card group">
    <div class="post-card-media">
        <img src="{{ $cover }}" alt="{{ $p->photo_alt_text ?: $p->title }}" loading="lazy">
        @if ($p->categories->first())
            <span class="uni-chip absolute top-4 left-4">{{ $p->categories->first()->name }}</span>
        @endif
    </div>
    <div class="p-6 flex flex-col flex-1">
        <p class="text-xs text-muted font-mono uppercase tracking-wider">
            <time datetime="{{ $date->toDateString() }}">{{ $date->format('M j, Y') }}</time> · {{ $minutes }} min read
        </p>
        <h3 class="mt-3 text-xl font-semibold tracking-tight text-ink leading-snug line-clamp-2 group-hover:text-accent transition-colors">
            <a href="{{ route('blog.show', $p->slug) }}" class="after:absolute after:inset-0">{{ $p->title }}</a>
        </h3>
        <p class="mt-2 text-muted line-clamp-2">{{ $p->sub_title ?: Str::limit(strip_tags($p->body), 120) }}</p>
        <div class="mt-auto pt-5 flex items-center justify-between">
            <span class="flex items-center gap-2.5 text-sm">
                <span class="grid place-items-center w-8 h-8 rounded-full bg-[var(--accent-soft)] text-accent text-xs font-semibold">{{ Str::upper(Str::substr($p->user->name ?? 'D', 0, 1)) }}</span>
                <span class="text-ink font-medium">{{ $p->user->name ?? 'Divjules' }}</span>
            </span>
            <span class="w-9 h-9 grid place-items-center rounded-full border border-line text-accent group-hover:bg-[var(--accent)] group-hover:text-white group-hover:border-transparent transition"><i class="fas fa-arrow-right text-xs -rotate-45 group-hover:rotate-0 transition-transform duration-300"></i></span>
        </div>
    </div>
</article>
