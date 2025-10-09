<?php

use function Livewire\Volt\{state};

//

?>

<div>
    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-2xl font-bold mb-4">Divjules</h3>
                    <p class="text-gray-400">Your trusted partner for international education.</p>
                    <div class="flex space-x-4 mt-4">
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-linkedin text-xl"></i></a>
                    </div>
                </div>

                <div>
                    <h4 class="font-bold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="/about" class="text-gray-400 hover:text-white">About Us</a></li>
                        <li><a href="/universities" class="text-gray-400 hover:text-white">Universities</a></li>
                        <li><a href="/courses" class="text-gray-400 hover:text-white">Courses</a></li>
                        <li><a href="/blog" class="text-gray-400 hover:text-white">Blog</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold mb-4">Services</h4>
                    <ul class="space-y-2">
                        <li><a href="/contact" class="text-gray-400 hover:text-white">Free Consultation</a></li>
                        <li><a href="/contact" class="text-gray-400 hover:text-white">University Selection</a></li>
                        <li><a href="/contact" class="text-gray-400 hover:text-white">Application Support</a></li>
                        <li><a href="/contact" class="text-gray-400 hover:text-white">Visa Assistance</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold mb-4">Contact</h4>
                    <ul class="space-y-2 text-gray-400">
                        @foreach($contactDetails->take(5) as $contact)
                            <li class="flex items-start">
                                @if($contact->is_clickable)
                                    <a href="{{ $contact->link }}" class="hover:text-white transition-colors">
                                        <i class="fas {{ str_replace('heroicon-o-', 'fa-', $contact->icon ?? 'fa-circle') }} mr-2 mt-1"></i>
                                        {{ $contact->value }}
                                    </a>
                                @else
                                    <span>
                                        <i class="fas {{ str_replace('heroicon-o-', 'fa-', $contact->icon ?? 'fa-circle') }} mr-2 mt-1"></i>
                                        {!! $contact->formatted_value !!}
                                    </span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
                <p>&copy; 2025 Divjules. All rights reserved.</p>
            </div>
        </div>
    </footer>
</div>
