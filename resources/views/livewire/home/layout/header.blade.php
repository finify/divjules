<?php

use function Livewire\Volt\{state};

//

?>

<div>
    <!-- Navigation -->
    <nav class="bg-white shadow-lg fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home.index') }}" class="flex items-center">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Divjules Logo" class="h-12 w-auto">
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-8">
                    <a href="{{ route('home.index') }}" class="text-gray-700 hover:text-purple-600 font-medium transition">Home</a>
                    <a href="{{ route('home.universities') }}" class="text-gray-700 hover:text-purple-600 font-medium transition">Universities</a>
                    <a href="{{ route('home.courses') }}" class="text-gray-700 hover:text-purple-600 font-medium transition">Courses</a>
                    <a href="{{ route('home.about') }}" class="text-gray-700 hover:text-purple-600 font-medium transition">About Us</a>
                    <a href="{{ route('home.blog') }}" class="text-gray-700 hover:text-purple-600 font-medium transition">Blog</a>
                    <a href="{{ route('home.contact') }}" class="text-gray-700 hover:text-purple-600 font-medium transition">Contact</a>
                </div>

                <!-- CTA Buttons -->
                <div class="hidden md:flex space-x-4">
                    <a href="{{ route('home.contact') }}" class="px-4 py-2 text-purple-600 border border-purple-600 rounded-lg hover:bg-purple-50 transition">Free Consultation</a>
                    <a href="{{ route('home.contact') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">Apply Now</a>
                </div>

                <!-- Mobile Menu Button & Book Consultation -->
                <div class="md:hidden flex items-center space-x-3">
                    <a href="{{ route('home.contact') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg text-sm font-semibold hover:bg-purple-700 transition">
                        Book Consultation
                    </a>
                    <button id="mobile-menu-btn" class="text-gray-700 hover:text-purple-600 focus:outline-none">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('home.index') }}" class="block px-3 py-2 text-gray-700 hover:bg-purple-50 hover:text-purple-600 rounded">Home</a>
                <a href="{{ route('home.universities') }}" class="block px-3 py-2 text-gray-700 hover:bg-purple-50 hover:text-purple-600 rounded">Universities</a>
                <a href="{{ route('home.courses') }}" class="block px-3 py-2 text-gray-700 hover:bg-purple-50 hover:text-purple-600 rounded">Courses</a>
                <a href="{{ route('home.about') }}" class="block px-3 py-2 text-gray-700 hover:bg-purple-50 hover:text-purple-600 rounded">About Us</a>
                <a href="{{ route('home.blog') }}" class="block px-3 py-2 text-gray-700 hover:bg-purple-50 hover:text-purple-600 rounded">Blog</a>
                <a href="{{ route('home.contact') }}" class="block px-3 py-2 text-gray-700 hover:bg-purple-50 hover:text-purple-600 rounded">Contact</a>
                <a href="{{ route('home.contact') }}" class="block px-3 py-2 bg-purple-600 text-white rounded text-center mt-4">Apply Now</a>
            </div>
        </div>
    </nav>
</div>
