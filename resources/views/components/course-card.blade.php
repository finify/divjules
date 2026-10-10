@props(['course', 'showUniversity' => true])
@php
    $c = $course;
    $levelLabel = ['undergraduate' => 'Undergraduate', 'postgraduate' => 'Postgraduate', 'diploma' => 'Diploma', 'certificate' => 'Certificate'][$c->level] ?? ucfirst($c->level);
@endphp

<article class="course-card group" data-tilt="3" data-spotlight>
    <div class="flex items-start justify-between gap-3">
        <span class="icon-tile"><i class="fas fa-{{ $c->courseCategory->icon ?? 'graduation-cap' }}"></i></span>
        <div class="flex flex-wrap justify-end gap-1.5">
            @if ($c->is_featured)<span class="meta-chip !bg-amber-400/15 !text-amber-600 dark:!text-amber-300"><i class="fas fa-star"></i>Featured</span>@endif
            <span class="level-badge level-{{ $c->level }}">{{ $levelLabel }}</span>
        </div>
    </div>

    <p class="mt-5 font-mono text-[11px] uppercase tracking-[0.16em] text-muted">{{ $c->courseCategory->name ?? 'Course' }}</p>
    <h3 class="mt-1.5 text-lg font-semibold tracking-tight text-ink leading-snug">
        <a href="{{ route('courses.show', $c->slug) }}" class="after:absolute after:inset-0">{{ $c->name }}</a>
    </h3>

    @if ($showUniversity && $c->university)
        <div class="mt-4 flex items-center gap-3">
            <img src="{{ $c->university->cover_url }}" alt="" class="w-10 h-10 rounded-xl object-cover" loading="lazy">
            <div class="min-w-0">
                <p class="text-sm font-medium text-ink truncate">{{ $c->university->name }}</p>
                <p class="text-xs text-muted truncate">{{ $c->university->city ? $c->university->city . ', ' : '' }}{{ $c->university->country }}</p>
            </div>
        </div>
    @endif

    <dl class="mt-5 grid grid-cols-2 gap-px rounded-2xl overflow-hidden border border-line bg-[var(--line)] text-sm">
        <div class="bg-[var(--surface)] px-4 py-3">
            <dt class="text-[11px] uppercase tracking-wider text-muted">Duration</dt>
            <dd class="mt-0.5 font-medium text-ink">{{ $c->duration }}</dd>
        </div>
        <div class="bg-[var(--surface)] px-4 py-3">
            <dt class="text-[11px] uppercase tracking-wider text-muted">{{ $c->tuition_fee ? 'Tuition' : 'Study mode' }}</dt>
            <dd class="mt-0.5 font-medium text-ink truncate">{{ $c->tuition_fee ? $c->formatted_tuition_fee : ($c->mode_of_study ?: 'Full-time') }}</dd>
        </div>
    </dl>

    <div class="mt-auto pt-5 flex items-center justify-between gap-3">
        <span class="text-sm font-medium text-accent inline-flex items-center gap-1.5 group-hover:gap-2.5 transition-all">Course details <i class="fas fa-arrow-right text-xs"></i></span>
        <a href="{{ route('home.apply', ['course' => $c->id]) }}" class="relative z-10 btn btn-primary !py-2 !px-4 text-sm">Apply</a>
    </div>
</article>
