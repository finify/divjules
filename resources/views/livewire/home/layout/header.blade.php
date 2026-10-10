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
    <nav class="site-nav fixed w-full top-0 z-50" data-site-nav>
        <div class="container-x">
            <div class="flex justify-between items-center h-20 gap-6">
                <a href="{{ route('home.index') }}" class="flex items-center shrink-0" aria-label="Divjules home">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Divjules Logo" class="h-11 w-auto logo-themed">
                </a>

                <div class="hidden lg:flex items-center gap-8">
                    @foreach ($links as [$name, $label])
                        <a href="{{ route($name) }}" class="nav-link {{ request()->routeIs($name) ? 'is-active' : '' }}">{{ $label }}</a>
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
                    <a href="{{ route('home.contact') }}" class="btn btn-primary !py-2 !px-4 text-sm hidden sm:inline-flex">Book consultation</a>
                    <button id="mobile-menu-btn" type="button" class="theme-toggle" aria-label="Open menu" aria-expanded="false" aria-controls="mobile-menu">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>

        <div id="mobile-menu" class="hidden lg:hidden mobile-sheet">
            <div class="container-x py-4 flex flex-col">
                @foreach ($links as [$name, $label])
                    <a href="{{ route($name) }}" class="mobile-link flex items-center justify-between py-3.5 text-lg font-medium border-b border-line {{ request()->routeIs($name) ? 'text-accent' : 'text-ink' }}">
                        {{ $label }} <i class="fas fa-arrow-right text-xs text-muted"></i>
                    </a>
                @endforeach
                <div class="grid grid-cols-2 gap-3 pt-5">
                    <a href="{{ route('home.contact') }}" class="btn btn-ghost">Consultation</a>
                    <a href="{{ route('home.apply') }}" class="btn btn-primary">Apply now</a>
                </div>
            </div>
        </div>
    </nav>
</div>
