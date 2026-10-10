@props(['placeholder' => 'Search...', 'active' => false, 'open' => false])

{{-- Compact one-line filter bar that tucks into the bottom of the page hero.
     Desktop: search + selects + clear in a single pill. Mobile: search + a toggle that reveals the selects. --}}
<section class="relative z-20 -mt-9 px-4" data-no-auto data-dock-search>
    <div class="max-w-5xl mx-auto">
        <div class="filter-bar surface rounded-2xl md:rounded-full p-1.5 flex flex-col md:flex-row md:items-center gap-1.5">
            <div class="flex items-center gap-1.5 flex-1 min-w-0">
                <label class="relative flex-1 min-w-0">
                    <span class="sr-only">Search</span>
                    <i class="fas fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-sm text-muted pointer-events-none"></i>
                    <input type="search" wire:model.live.debounce.300ms="search" placeholder="{{ $placeholder }}" class="filter-input w-full h-11 pl-10 pr-3 rounded-full">
                </label>
                <button type="button" wire:click="$toggle('showFilters')" class="grid md:hidden filter-icon-btn relative" aria-label="Show filters" aria-expanded="{{ $open ? 'true' : 'false' }}">
                    <i class="fas fa-sliders"></i>
                    @if ($active)<span class="absolute top-2 right-2 w-2 h-2 rounded-full bg-[var(--accent)]"></span>@endif
                </button>
            </div>

            <div class="{{ $open ? 'grid' : 'hidden' }} md:flex grid-cols-1 sm:grid-cols-3 md:items-center gap-1.5 md:shrink-0">
                {{ $slot }}
            </div>

            @if ($active)
                <button type="button" wire:click="clearFilters" class="filter-clear md:shrink-0" title="Clear filters">
                    <i class="fas fa-xmark"></i><span class="md:hidden lg:inline">Clear</span>
                </button>
            @endif
        </div>
    </div>
</section>
