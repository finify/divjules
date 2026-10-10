@props(['university'])
@php $u = $university; @endphp

<article class="uni-card group" data-tilt="3">
    <div class="uni-card-media">
        <img src="{{ $u->cover_url }}" alt="{{ $u->name }}, {{ $u->city ? $u->city . ', ' : '' }}{{ $u->country }}" loading="lazy">
        <div class="absolute inset-0 bg-gradient-to-t from-[#0f0f2e]/85 via-[#0f0f2e]/10 to-transparent"></div>
        <div class="absolute top-4 left-4 right-4 flex items-center justify-between gap-2">
            <span class="uni-chip">{{ $u->country }}</span>
            @if ($u->is_featured)
                <span class="uni-chip !bg-amber-400 !text-[#1a1a4e]"><i class="fas fa-star"></i>Featured</span>
            @endif
        </div>
        <p class="absolute right-5 bottom-4 text-white/90 text-sm font-medium"><i class="fas fa-location-dot mr-1.5 text-sky-300"></i>{{ $u->city ?: $u->country }}</p>
    </div>

    <div class="p-6 flex flex-col flex-1">
        <div class="logo-pill mb-4">
            @if ($u->logo_url)
                <img src="{{ $u->logo_url }}" alt="{{ $u->name }} logo" loading="lazy">
            @else
                <span class="logo-initials">{{ $u->initials }}</span>
            @endif
        </div>
        <h3 class="text-lg font-semibold tracking-tight text-ink leading-snug">
            <a href="{{ route('universities.show', $u->slug) }}" class="after:absolute after:inset-0">{{ $u->name }}</a>
        </h3>
        @if ($u->description)
            <p class="mt-2 text-sm text-muted line-clamp-2">{{ $u->description }}</p>
        @endif

        <div class="mt-4 flex flex-wrap gap-1.5">
            <span class="meta-chip">{{ ucfirst($u->type) }}</span>
            @if ($u->ranking)<span class="meta-chip"><i class="fas fa-trophy text-amber-500"></i>#{{ $u->ranking }} global</span>@endif
            @isset($u->courses_count)<span class="meta-chip"><i class="fas fa-book-open"></i>{{ $u->courses_count }} {{ Str::plural('course', $u->courses_count) }}</span>@endisset
        </div>

        <div class="mt-auto pt-5 flex items-center justify-between text-sm font-medium">
            <span class="text-accent inline-flex items-center gap-1.5 group-hover:gap-2.5 transition-all">View university <i class="fas fa-arrow-right text-xs"></i></span>
            <span class="w-9 h-9 grid place-items-center rounded-full border border-line text-muted group-hover:bg-[var(--accent)] group-hover:text-white group-hover:border-transparent transition"><i class="fas fa-arrow-up-right-from-square text-xs"></i></span>
        </div>
    </div>
</article>
