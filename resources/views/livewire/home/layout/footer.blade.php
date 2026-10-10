<?php

use function Livewire\Volt\{state};

//

?>

<div>
    <footer class="relative overflow-hidden bg-[#0f0f2e] text-white pt-20 pb-10 px-4">
        <div class="absolute inset-0 pointer-events-none opacity-60" style="background: radial-gradient(50% 60% at 90% 0%, rgba(3,105,161,.35), transparent 70%);"></div>
        <div class="container-x relative">
            <div class="grid lg:grid-cols-12 gap-12 pb-14 border-b border-white/10" data-reveal-group>
                <div class="lg:col-span-5" data-reveal>
                    <x-logo variant="light" class="h-11" />
                    <p class="mt-5 text-white/60 max-w-sm leading-relaxed">Your trusted partner for international education — from choosing a course to landing on campus.</p>
                    <a href="{{ route('home.contact') }}" class="btn btn-light mt-7" data-magnetic>Book a free consultation <i class="fas fa-arrow-right text-xs btn-arrow"></i></a>
                    <div class="flex gap-3 mt-8">
                        @foreach (['facebook-f', 'x-twitter', 'instagram', 'linkedin-in'] as $icon)
                            <a href="#" class="grid place-items-center w-10 h-10 rounded-full border border-white/15 text-white/70 hover:text-white hover:border-white hover:-translate-y-0.5 transition" aria-label="{{ $icon }}"><i class="fab fa-{{ $icon }}"></i></a>
                        @endforeach
                    </div>
                </div>

                <div class="lg:col-span-2" data-reveal>
                    <h4 class="font-mono text-xs uppercase tracking-[0.18em] text-white/40 mb-5">Explore</h4>
                    <ul class="space-y-3">
                        <li><a href="/about" class="footer-link">About us</a></li>
                        <li><a href="/universities" class="footer-link">Universities</a></li>
                        <li><a href="/courses" class="footer-link">Courses</a></li>
                        <li><a href="/blog" class="footer-link">Blog</a></li>
                        <li><a href="/reviews" class="footer-link">Reviews</a></li>
                    </ul>
                </div>

                <div class="lg:col-span-2" data-reveal>
                    <h4 class="font-mono text-xs uppercase tracking-[0.18em] text-white/40 mb-5">Services</h4>
                    <ul class="space-y-3">
                        <li><a href="/contact" class="footer-link">Free consultation</a></li>
                        <li><a href="/universities" class="footer-link">University selection</a></li>
                        <li><a href="/apply" class="footer-link">Application support</a></li>
                        <li><a href="/application/track" class="footer-link">Track application</a></li>
                        <li><a href="/contact" class="footer-link">Visa assistance</a></li>
                    </ul>
                </div>

                <div class="lg:col-span-3" data-reveal>
                    <h4 class="font-mono text-xs uppercase tracking-[0.18em] text-white/40 mb-5">Contact</h4>
                    <ul class="space-y-3 text-white/70">
                        @foreach($contactDetails->take(5) as $contact)
                            <li class="flex items-start">
                                @if($contact->is_clickable)
                                    <a href="{{ $contact->link }}" class="footer-link">
                                        <i class="{{ $contact->fa_icon }} mr-2 mt-1 text-sky-400"></i>
                                        {{ $contact->value }}
                                    </a>
                                @else
                                    <span>
                                        <i class="{{ $contact->fa_icon }} mr-2 mt-1 text-sky-400"></i>
                                        {!! $contact->formatted_value !!}
                                    </span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-white/45">
                <p>&copy; {{ date('Y') }} Divjules. All rights reserved.</p>
                <button type="button" class="inline-flex items-center gap-2 hover:text-white transition" data-scroll-top>
                    Back to top <i class="fas fa-arrow-up text-xs"></i>
                </button>
            </div>

            <div class="select-none pointer-events-none mt-10 text-center font-semibold tracking-tighter leading-none text-white/[0.04]" style="font-size: clamp(4rem, 17vw, 15rem);" data-footer-word>divjules</div>
        </div>
    </footer>
    <style>
        .footer-link { color: rgba(255,255,255,.7); transition: color .2s ease; display: inline-flex; align-items: flex-start; }
        .footer-link:hover { color: #fff; }
    </style>
</div>
