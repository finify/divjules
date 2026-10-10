<?php

use function Livewire\Volt\{state};

//

?>

@php
    $links = [
        ['home.index', 'Home'],
        ['home.universities', 'Universities'],
        ['home.courses', 'Courses'],
        ['home.about', 'About'],
        ['home.blog', 'Blog'],
        ['home.contact', 'Contact'],
    ];
@endphp

<div>
    <nav class="site-nav fixed w-full top-0 z-50" data-site-nav aria-label="Main">
        <div class="container-x">
            <div class="flex justify-between items-center h-20 gap-6">
                <a href="{{ route('home.index') }}" class="flex items-center shrink-0" aria-label="Divjules home">
                    <x-logo class="h-10 sm:h-11" />
                </a>

                {{-- Search pill that docks here when a page's filter bar scrolls away (see initDockSearch) --}}
                <div class="nav-search" data-nav-search aria-hidden="true">
                    <div class="nav-search-pill">
                        <i class="fas fa-magnifying-glass text-sm text-muted"></i>
                        <input type="search" class="nav-search-input" data-nav-search-input tabindex="-1" aria-label="Search" autocomplete="off">
                        <button type="button" class="nav-search-btn" data-nav-search-filters tabindex="-1" aria-label="Show all filters"><i class="fas fa-sliders"></i></button>
                    </div>
                </div>

                <div class="hidden lg:flex items-center gap-8 nav-links">
                    @foreach ($links as [$name, $label])
                        <a href="{{ route($name) }}" class="nav-link {{ request()->routeIs($name) || request()->routeIs(str_replace('home.', '', $name) . '.*') ? 'is-active' : '' }}">{{ $label }}</a>
                    @endforeach
                </div>

                <div class="hidden lg:flex items-center gap-3">
                    <button type="button" class="theme-toggle" data-theme-toggle aria-label="Toggle dark mode">
                        <i class="fas fa-moon i-moon"></i>
                        <i class="fas fa-sun i-sun"></i>
                    </button>
                    <a href="{{ route('home.contact') }}" class="btn btn-ghost !py-2.5 !px-5 text-sm">Free consultation</a>
                    <a href="{{ route('home.apply') }}" class="btn btn-primary !py-2.5 !px-5 text-sm" data-magnetic>Apply now <i class="fas fa-arrow-right text-xs btn-arrow"></i></a>
                </div>

                <div class="lg:hidden flex items-center gap-2">
                    <button type="button" class="theme-toggle" data-theme-toggle aria-label="Toggle dark mode">
                        <i class="fas fa-moon i-moon"></i>
                        <i class="fas fa-sun i-sun"></i>
                    </button>
                    <button id="mobile-menu-btn" type="button" class="menu-burger" aria-label="Open menu" aria-expanded="false" aria-controls="mobile-menu">
                        <span></span><span></span>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    {{-- Full-screen mobile menu --}}
    <div id="mobile-menu" class="mobile-menu lg:hidden" aria-hidden="true" role="dialog" aria-modal="true" aria-label="Menu">
        <div class="mobile-menu-bg" data-menu-bg></div>
        <div class="mobile-menu-panel" data-menu-panel>
            <div class="container-x w-full flex items-center justify-between h-20 shrink-0">
                <x-logo variant="light" class="h-10" />
                <button type="button" class="menu-close" data-menu-close aria-label="Close menu"><i class="fas fa-xmark"></i></button>
            </div>

            <nav class="container-x w-full flex-1 flex flex-col justify-center py-6" aria-label="Mobile">
                @foreach ($links as $i => [$name, $label])
                    <a href="{{ route($name) }}" class="mobile-link group {{ request()->routeIs($name) ? 'is-active' : '' }}" data-menu-item>
                        <span class="font-mono text-xs text-sky-300/60 w-8">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <span class="flex-1">{{ $label }}</span>
                        <i class="fas fa-arrow-right text-base text-white/30 group-hover:text-sky-300 group-hover:translate-x-1 transition"></i>
                    </a>
                @endforeach
            </nav>

            <div class="container-x w-full pb-8 shrink-0" data-menu-item>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('home.contact') }}" class="btn btn-outline-light">Consultation</a>
                    <a href="{{ route('home.apply') }}" class="btn btn-light">Apply now</a>
                </div>
                <div class="mt-6 flex items-center justify-between text-sm text-white/50">
                    <a href="{{ route('application.track') }}" class="hover:text-white transition"><i class="fas fa-magnifying-glass-location mr-2"></i>Track application</a>
                    <div class="flex gap-4 text-base">
                        <a href="#" aria-label="Instagram" class="hover:text-white"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="Facebook" class="hover:text-white"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="LinkedIn" class="hover:text-white"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
