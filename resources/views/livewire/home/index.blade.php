<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};
use App\Models\School;

new
#[Layout('components.layouts.home')]
#[Title('Home')]
class extends Component {
    public function with(): array
    {
        return [
            'schools' => School::active()->ordered()->get(),
        ];
    }
}; ?>

<div>
    <!-- Hero Section with Video Background -->
    <section class="hero-video-section mt-20">
        <!-- Video Background -->
        <video class="hero-video-bg" autoplay muted loop playsinline>
            <source src="https://admin.ahzassociates.com/documents/5/video-2_online-video-cutter.com.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>

        <!-- Overlay -->
        <div class="hero-overlay"></div>

        <!-- Content -->
        <div class="hero-content flex items-center min-h-screen px-4 py-32">
            <div class="max-w-7xl mx-auto w-full">
                <div class="max-w-2xl">
                    <h1 class="sliding-text text-5xl md:text-7xl font-bold mb-6 leading-tight text-white">
                        Your Gateway to Quality Education
                    </h1>
                    <p class="sliding-text text-xl md:text-2xl mb-8 text-white">
                        Expert guidance for your academic journey. Connect with top universities worldwide.
                    </p>
                    <div class="sliding-text flex flex-col sm:flex-row gap-4">
                        <a href="apply.html" class="px-8 py-4 bg-white text-purple-600 rounded-lg font-semibold hover:bg-gray-100 transition text-center shadow-lg">
                            Get Started
                        </a>
                        <a href="contact.html" class="px-8 py-4 bg-transparent border-2 border-white text-white rounded-lg font-semibold hover:bg-white hover:text-purple-600 transition text-center">
                            Book Free Consultation
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-4xl font-bold text-purple-600 mb-2">150+</div>
                    <div class="text-gray-600">Partner Universities</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-purple-600 mb-2">15+</div>
                    <div class="text-gray-600">Countries</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-purple-600 mb-2">10,000+</div>
                    <div class="text-gray-600">Students Placed</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-purple-600 mb-2">500+</div>
                    <div class="text-gray-600">Expert Counsellors</div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-20 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Why Choose Divjules?</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">We provide comprehensive support throughout your educational journey, from selection to enrollment and beyond.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-xl shadow-lg card-hover">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-university text-3xl text-purple-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Expert Guidance</h3>
                    <p class="text-gray-600">Our certified counsellors provide personalized advice to help you choose the right university and course.</p>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-lg card-hover">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-globe text-3xl text-purple-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Global Network</h3>
                    <p class="text-gray-600">Access to 150+ partner institutions across multiple countries for diverse opportunities.</p>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-lg card-hover">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-hand-holding-heart text-3xl text-purple-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">End-to-End Support</h3>
                    <p class="text-gray-600">From application to visa assistance and pre-departure briefing, we're with you every step.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Courses -->
    <section class="py-20 px-4 bg-gray-100">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Popular Courses</h2>
                <p class="text-xl text-gray-600">Explore our most sought-after academic programs</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-lg shadow card-hover cursor-pointer">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-briefcase text-2xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Business & Management</h3>
                    <p class="text-gray-600 text-sm mb-4">MBA, Finance, Marketing</p>
                    <a href="courses.html" class="text-purple-600 font-semibold hover:text-purple-700">Explore <i class="fas fa-arrow-right ml-1"></i></a>
                </div>

                <div class="bg-white p-6 rounded-lg shadow card-hover cursor-pointer">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-laptop-code text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Computing & IT</h3>
                    <p class="text-gray-600 text-sm mb-4">Computer Science, Data Science</p>
                    <a href="courses.html" class="text-purple-600 font-semibold hover:text-purple-700">Explore <i class="fas fa-arrow-right ml-1"></i></a>
                </div>

                <div class="bg-white p-6 rounded-lg shadow card-hover cursor-pointer">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-cogs text-2xl text-orange-600"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Engineering</h3>
                    <p class="text-gray-600 text-sm mb-4">Mechanical, Civil, Electrical</p>
                    <a href="courses.html" class="text-purple-600 font-semibold hover:text-purple-700">Explore <i class="fas fa-arrow-right ml-1"></i></a>
                </div>

                <div class="bg-white p-6 rounded-lg shadow card-hover cursor-pointer">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-heartbeat text-2xl text-red-600"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Health Sciences</h3>
                    <p class="text-gray-600 text-sm mb-4">Medicine, Nursing, Pharmacy</p>
                    <a href="courses.html" class="text-purple-600 font-semibold hover:text-purple-700">Explore <i class="fas fa-arrow-right ml-1"></i></a>
                </div>

                <div class="bg-white p-6 rounded-lg shadow card-hover cursor-pointer">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-balance-scale text-2xl text-purple-600"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Law</h3>
                    <p class="text-gray-600 text-sm mb-4">LLB, Corporate Law, International Law</p>
                    <a href="courses.html" class="text-purple-600 font-semibold hover:text-purple-700">Explore <i class="fas fa-arrow-right ml-1"></i></a>
                </div>

                <div class="bg-white p-6 rounded-lg shadow card-hover cursor-pointer">
                    <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-palette text-2xl text-pink-600"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Arts & Humanities</h3>
                    <p class="text-gray-600 text-sm mb-4">Design, Media, Languages</p>
                    <a href="courses.html" class="text-purple-600 font-semibold hover:text-purple-700">Explore <i class="fas fa-arrow-right ml-1"></i></a>
                </div>

                <div class="bg-white p-6 rounded-lg shadow card-hover cursor-pointer">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-flask text-2xl text-yellow-600"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Science</h3>
                    <p class="text-gray-600 text-sm mb-4">Physics, Chemistry, Biology</p>
                    <a href="courses.html" class="text-purple-600 font-semibold hover:text-purple-700">Explore <i class="fas fa-arrow-right ml-1"></i></a>
                </div>

                <div class="bg-white p-6 rounded-lg shadow card-hover cursor-pointer">
                    <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-graduation-cap text-2xl text-indigo-600"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Education</h3>
                    <p class="text-gray-600 text-sm mb-4">Teaching, Training, Development</p>
                    <a href="courses.html" class="text-purple-600 font-semibold hover:text-purple-700">Explore <i class="fas fa-arrow-right ml-1"></i></a>
                </div>
            </div>
        </div>
    </section>

    <!-- Partner Universities Slider -->
    <section class="py-20 px-4 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Schools We Work With</h2>
                <p class="text-xl text-gray-600">Partner universities and institutions across the globe</p>
            </div>

            <div class="universities-slider-wrapper">
                <div class="universities-slider-container relative">
                    <!-- Navigation Buttons -->
                    <button onclick="slowDownUniSlider()" class="uni-nav-btn left" aria-label="Slow down slider">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button onclick="speedUpUniSlider()" class="uni-nav-btn right" aria-label="Speed up slider">
                        <i class="fas fa-chevron-right"></i>
                    </button>

                    <!-- Slider Track -->
                    <div id="universitiesSliderTrack" class="universities-slider-track flex gap-8 items-center">
                    @forelse($schools as $school)
                    <div class="university-slide flex-shrink-0 bg-white p-4 rounded-lg hover:shadow-xl transition-all duration-300 h-36 w-56 flex flex-col items-center justify-center group cursor-pointer border border-gray-100">
                        @if($school->logo_url)
                            <img src="{{ $school->logo_url }}" alt="{{ $school->name }}" class="h-16 w-auto mb-2 object-contain group-hover:scale-110 transition-transform">
                        @endif
                        <div class="text-center px-2">
                            <div class="text-sm font-bold text-gray-800 line-clamp-2">{{ $school->name }}</div>
                        </div>
                    </div>
                    @empty
                    <div class="university-slide flex-shrink-0 bg-white p-4 rounded-lg h-36 w-56 flex items-center justify-center">
                        <p class="text-gray-500 text-sm">No schools added yet</p>
                    </div>
                    @endforelse

                    {{-- Duplicate slides for infinite loop effect --}}
                    @foreach($schools as $school)
                    <div class="university-slide flex-shrink-0 bg-white p-4 rounded-lg hover:shadow-xl transition-all duration-300 h-36 w-56 flex flex-col items-center justify-center group cursor-pointer border border-gray-100">
                        @if($school->logo_url)
                            <img src="{{ $school->logo_url }}" alt="{{ $school->name }}" class="h-16 w-auto mb-2 object-contain group-hover:scale-110 transition-transform">
                        @endif
                        <div class="text-center px-2">
                            <div class="text-sm font-bold text-gray-800 line-clamp-2">{{ $school->name }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="universities.html" class="inline-block px-8 py-3 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition">View All Universities</a>
            </div>
        </div>
    </section>

    <!-- Application Journey -->
    <section class="py-20 px-4 bg-gray-100">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Your Journey With Us</h2>
                <p class="text-xl text-gray-600">Simple steps to kickstart your academic career</p>
            </div>

            <div class="grid md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-20 h-20 bg-purple-600 text-white rounded-full flex items-center justify-center text-3xl font-bold mx-auto mb-4">1</div>
                    <h3 class="text-xl font-bold mb-2">Free Consultation</h3>
                    <p class="text-gray-600">Discuss your goals with our expert counsellors</p>
                </div>

                <div class="text-center">
                    <div class="w-20 h-20 bg-purple-600 text-white rounded-full flex items-center justify-center text-3xl font-bold mx-auto mb-4">2</div>
                    <h3 class="text-xl font-bold mb-2">University Selection</h3>
                    <p class="text-gray-600">Choose from our partner institutions</p>
                </div>

                <div class="text-center">
                    <div class="w-20 h-20 bg-purple-600 text-white rounded-full flex items-center justify-center text-3xl font-bold mx-auto mb-4">3</div>
                    <h3 class="text-xl font-bold mb-2">Application Support</h3>
                    <p class="text-gray-600">Complete guidance through the application process</p>
                </div>

                <div class="text-center">
                    <div class="w-20 h-20 bg-purple-600 text-white rounded-full flex items-center justify-center text-3xl font-bold mx-auto mb-4">4</div>
                    <h3 class="text-xl font-bold mb-2">Visa & Departure</h3>
                    <p class="text-gray-600">Visa assistance and pre-departure orientation</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Video Testimonials Slider -->
    <section class="py-20 px-4 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Student Video Testimonials</h2>
                <p class="text-xl text-gray-600">Watch success stories from students who achieved their dreams with Divjules</p>
            </div>

            <div class="testimonial-slider relative">
                <!-- Slide 1 -->
                <div class="testimonial-slide active">
                    <div class="grid md:grid-cols-3 gap-8">
                        <!-- Video Testimonial 1 -->
                        <div class="group cursor-pointer" onclick="openVideoModal('https://www.youtube.com/embed/dQw4w9WgXcQ')">
                            <div class="relative overflow-hidden rounded-xl shadow-lg">
                                <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=600&h=400&fit=crop" alt="Sarah Johnson" class="w-full h-64 object-cover transition-transform duration-300 group-hover:scale-110">
                                <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                                    <div class="w-20 h-20 bg-white bg-opacity-90 rounded-full flex items-center justify-center transition-transform duration-300 group-hover:scale-125">
                                        <i class="fas fa-play text-purple-600 text-2xl ml-1"></i>
                                    </div>
                                </div>
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">
                                    <h4 class="text-white font-bold text-lg">Sarah Johnson</h4>
                                    <p class="text-white text-sm">MSc Computer Science, UCL</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="flex text-yellow-400 mb-2">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <p class="text-gray-600 text-sm">"An incredible journey from application to acceptance!"</p>
                            </div>
                        </div>

                        <!-- Video Testimonial 2 -->
                        <div class="group cursor-pointer" onclick="openVideoModal('https://www.youtube.com/embed/dQw4w9WgXcQ')">
                            <div class="relative overflow-hidden rounded-xl shadow-lg">
                                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600&h=400&fit=crop" alt="Michael Chen" class="w-full h-64 object-cover transition-transform duration-300 group-hover:scale-110">
                                <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                                    <div class="w-20 h-20 bg-white bg-opacity-90 rounded-full flex items-center justify-center transition-transform duration-300 group-hover:scale-125">
                                        <i class="fas fa-play text-purple-600 text-2xl ml-1"></i>
                                    </div>
                                </div>
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">
                                    <h4 class="text-white font-bold text-lg">Michael Chen</h4>
                                    <p class="text-white text-sm">MBA, Cambridge University</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="flex text-yellow-400 mb-2">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <p class="text-gray-600 text-sm">"Professional guidance that made all the difference!"</p>
                            </div>
                        </div>

                        <!-- Video Testimonial 3 -->
                        <div class="group cursor-pointer" onclick="openVideoModal('https://www.youtube.com/embed/dQw4w9WgXcQ')">
                            <div class="relative overflow-hidden rounded-xl shadow-lg">
                                <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=600&h=400&fit=crop" alt="Priya Patel" class="w-full h-64 object-cover transition-transform duration-300 group-hover:scale-110">
                                <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                                    <div class="w-20 h-20 bg-white bg-opacity-90 rounded-full flex items-center justify-center transition-transform duration-300 group-hover:scale-125">
                                        <i class="fas fa-play text-purple-600 text-2xl ml-1"></i>
                                    </div>
                                </div>
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">
                                    <h4 class="text-white font-bold text-lg">Priya Patel</h4>
                                    <p class="text-white text-sm">BSc Engineering, Imperial College</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="flex text-yellow-400 mb-2">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <p class="text-gray-600 text-sm">"They supported me every step of the way!"</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="testimonial-slide">
                    <div class="grid md:grid-cols-3 gap-8">
                        <!-- Video Testimonial 4 -->
                        <div class="group cursor-pointer" onclick="openVideoModal('https://www.youtube.com/embed/dQw4w9WgXcQ')">
                            <div class="relative overflow-hidden rounded-xl shadow-lg">
                                <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=600&h=400&fit=crop" alt="David Okonkwo" class="w-full h-64 object-cover transition-transform duration-300 group-hover:scale-110">
                                <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                                    <div class="w-20 h-20 bg-white bg-opacity-90 rounded-full flex items-center justify-center transition-transform duration-300 group-hover:scale-125">
                                        <i class="fas fa-play text-purple-600 text-2xl ml-1"></i>
                                    </div>
                                </div>
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">
                                    <h4 class="text-white font-bold text-lg">David Okonkwo</h4>
                                    <p class="text-white text-sm">MSc Data Science, Oxford</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="flex text-yellow-400 mb-2">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <p class="text-gray-600 text-sm">"Dream university, thanks to Divjules team!"</p>
                            </div>
                        </div>

                        <!-- Video Testimonial 5 -->
                        <div class="group cursor-pointer" onclick="openVideoModal('https://www.youtube.com/embed/dQw4w9WgXcQ')">
                            <div class="relative overflow-hidden rounded-xl shadow-lg">
                                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=600&h=400&fit=crop" alt="Emma Williams" class="w-full h-64 object-cover transition-transform duration-300 group-hover:scale-110">
                                <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                                    <div class="w-20 h-20 bg-white bg-opacity-90 rounded-full flex items-center justify-center transition-transform duration-300 group-hover:scale-125">
                                        <i class="fas fa-play text-purple-600 text-2xl ml-1"></i>
                                    </div>
                                </div>
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">
                                    <h4 class="text-white font-bold text-lg">Emma Williams</h4>
                                    <p class="text-white text-sm">LLB Law, LSE</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="flex text-yellow-400 mb-2">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <p class="text-gray-600 text-sm">"Outstanding service and support throughout!"</p>
                            </div>
                        </div>

                        <!-- Video Testimonial 6 -->
                        <div class="group cursor-pointer" onclick="openVideoModal('https://www.youtube.com/embed/dQw4w9WgXcQ')">
                            <div class="relative overflow-hidden rounded-xl shadow-lg">
                                <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=600&h=400&fit=crop" alt="James Rodriguez" class="w-full h-64 object-cover transition-transform duration-300 group-hover:scale-110">
                                <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                                    <div class="w-20 h-20 bg-white bg-opacity-90 rounded-full flex items-center justify-center transition-transform duration-300 group-hover:scale-125">
                                        <i class="fas fa-play text-purple-600 text-2xl ml-1"></i>
                                    </div>
                                </div>
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">
                                    <h4 class="text-white font-bold text-lg">James Rodriguez</h4>
                                    <p class="text-white text-sm">MSc Finance, Edinburgh</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="flex text-yellow-400 mb-2">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <p class="text-gray-600 text-sm">"Best decision to work with Divjules!"</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slider Navigation -->
                <button onclick="changeSlide(-1)" class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 md:-translate-x-12 bg-white hover:bg-purple-600 text-purple-600 hover:text-white w-12 h-12 rounded-full shadow-lg flex items-center justify-center transition-all duration-300">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button onclick="changeSlide(1)" class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 md:translate-x-12 bg-white hover:bg-purple-600 text-purple-600 hover:text-white w-12 h-12 rounded-full shadow-lg flex items-center justify-center transition-all duration-300">
                    <i class="fas fa-chevron-right"></i>
                </button>

                <!-- Dots -->
                <div class="flex justify-center mt-8 space-x-2">
                    <button onclick="setSlide(0)" class="slider-dot w-3 h-3 rounded-full bg-purple-600"></button>
                    <button onclick="setSlide(1)" class="slider-dot w-3 h-3 rounded-full bg-gray-300"></button>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="contact.html" class="inline-block px-8 py-3 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition">Share Your Success Story</a>
            </div>
        </div>
    </section>

    <!-- Video Modal -->
    <div id="videoModal" class="video-modal">
        <div class="video-modal-content">
            <span class="video-close" onclick="closeVideoModal()">&times;</span>
            <div class="relative" style="padding-bottom: 56.25%; height: 0;">
                <iframe id="videoFrame" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
    </div>

    <!-- Review Modal -->
    <div id="reviewModal" class="review-modal">
        <div class="review-modal-content">
            <button onclick="closeReviewModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-3xl font-bold">&times;</button>

            <h2 class="text-3xl font-bold text-gray-800 mb-2">Share Your Experience</h2>
            <p class="text-gray-600 mb-8">Help future students by sharing your journey with Divjules</p>

            <form id="reviewForm" class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Your Name *</label>
                    <input type="text" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="John Doe">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">University/College *</label>
                    <input type="text" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="University of London">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Your Email *</label>
                    <input type="email" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="john@example.com">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Rating *</label>
                    <div class="flex gap-2" id="starRating">
                        <i class="fas fa-star text-3xl text-gray-300 cursor-pointer hover:text-yellow-500" data-rating="1"></i>
                        <i class="fas fa-star text-3xl text-gray-300 cursor-pointer hover:text-yellow-500" data-rating="2"></i>
                        <i class="fas fa-star text-3xl text-gray-300 cursor-pointer hover:text-yellow-500" data-rating="3"></i>
                        <i class="fas fa-star text-3xl text-gray-300 cursor-pointer hover:text-yellow-500" data-rating="4"></i>
                        <i class="fas fa-star text-3xl text-gray-300 cursor-pointer hover:text-yellow-500" data-rating="5"></i>
                    </div>
                    <input type="hidden" id="ratingValue" name="rating" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Your Review *</label>
                    <textarea required rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="Share your experience with Divjules..."></textarea>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Your Photo (Optional)</label>
                    <input type="file" accept="image/*" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Upload a professional photo (max 5MB)</p>
                </div>

                <button type="submit" class="w-full px-6 py-4 bg-purple-600 text-white rounded-lg font-bold text-lg hover:bg-purple-700 transition shadow-lg">
                    <i class="fas fa-paper-plane mr-2"></i>Submit Review
                </button>
            </form>
        </div>
    </div>

    <!-- Student Reviews Section -->
    <section class="py-20 px-4 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">What Our Students Say</h2>
                <p class="text-xl text-gray-600">Real experiences from students who trusted us with their future</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 mb-12">
                <!-- Review Card 1 -->
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition card-hover">
                    <div class="flex items-center mb-6">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Student" class="w-16 h-16 rounded-full object-cover mr-4">
                        <div>
                            <h3 class="font-bold text-gray-800">Sarah Johnson</h3>
                            <p class="text-sm text-gray-600">University of Manchester</p>
                            <div class="flex text-yellow-500 mt-1">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-700 leading-relaxed">
                        "Divjules made my dream of studying in the UK a reality. Their guidance through the application process was exceptional, and I'm now pursuing my Master's in Business Analytics!"
                    </p>
                </div>

                <!-- Review Card 2 -->
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition card-hover">
                    <div class="flex items-center mb-6">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Student" class="w-16 h-16 rounded-full object-cover mr-4">
                        <div>
                            <h3 class="font-bold text-gray-800">Michael Chen</h3>
                            <p class="text-sm text-gray-600">Imperial College London</p>
                            <div class="flex text-yellow-500 mt-1">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-700 leading-relaxed">
                        "From visa assistance to finding accommodation, Divjules supported me at every step. I couldn't have asked for better guidance. Highly recommend their services!"
                    </p>
                </div>

                <!-- Review Card 3 -->
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition card-hover">
                    <div class="flex items-center mb-6">
                        <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Student" class="w-16 h-16 rounded-full object-cover mr-4">
                        <div>
                            <h3 class="font-bold text-gray-800">Priya Patel</h3>
                            <p class="text-sm text-gray-600">University of Edinburgh</p>
                            <div class="flex text-yellow-500 mt-1">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-700 leading-relaxed">
                        "The team at Divjules is incredibly knowledgeable and patient. They helped me secure a scholarship and guided me through the entire admission process seamlessly."
                    </p>
                </div>

                <!-- Review Card 4 -->
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition card-hover">
                    <div class="flex items-center mb-6">
                        <img src="https://randomuser.me/api/portraits/men/46.jpg" alt="Student" class="w-16 h-16 rounded-full object-cover mr-4">
                        <div>
                            <h3 class="font-bold text-gray-800">James Williams</h3>
                            <p class="text-sm text-gray-600">King's College London</p>
                            <div class="flex text-yellow-500 mt-1">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-700 leading-relaxed">
                        "Professional, reliable, and genuinely caring. Divjules understood my goals and helped me find the perfect course. Now I'm living my dream in London!"
                    </p>
                </div>

                <!-- Review Card 5 -->
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition card-hover">
                    <div class="flex items-center mb-6">
                        <img src="https://randomuser.me/api/portraits/women/22.jpg" alt="Student" class="w-16 h-16 rounded-full object-cover mr-4">
                        <div>
                            <h3 class="font-bold text-gray-800">Emma Rodriguez</h3>
                            <p class="text-sm text-gray-600">University of Bristol</p>
                            <div class="flex text-yellow-500 mt-1">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-700 leading-relaxed">
                        "I was nervous about studying abroad, but Divjules made everything so easy. Their expertise and support gave me confidence throughout the journey. Thank you!"
                    </p>
                </div>

                <!-- Review Card 6 -->
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition card-hover">
                    <div class="flex items-center mb-6">
                        <img src="https://randomuser.me/api/portraits/men/52.jpg" alt="Student" class="w-16 h-16 rounded-full object-cover mr-4">
                        <div>
                            <h3 class="font-bold text-gray-800">David Kumar</h3>
                            <p class="text-sm text-gray-600">Durham University</p>
                            <div class="flex text-yellow-500 mt-1">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-700 leading-relaxed">
                        "Exceptional service from start to finish. Divjules helped me navigate complex visa requirements and ensured I had everything ready for my departure. Highly professional!"
                    </p>
                </div>
            </div>

            <!-- Add Review Button -->
            <div class="text-center">
                <button onclick="openReviewModal()" class="px-8 py-4 bg-purple-600 text-white rounded-lg font-bold text-lg hover:bg-purple-700 transition shadow-lg transform hover:scale-105">
                    <i class="fas fa-pen mr-2"></i>Share Your Experience
                </button>
            </div>
        </div>
    </section>

    <!-- CTA Section with Background Image -->
    <section class="relative py-32 px-4 overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=1600&q=80" alt="Students celebrating" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-purple-900/95 to-indigo-900/95"></div>
        </div>

        <!-- Content -->
        <div class="relative z-10 max-w-4xl mx-auto text-center text-white">
            <h2 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">Ready to Start Your Journey?</h2>
            <p class="text-xl md:text-2xl mb-10 text-purple-100">Book a free consultation with our expert counsellors today!</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="contact.html" class="px-10 py-5 bg-white text-purple-600 rounded-lg font-bold text-lg hover:bg-gray-100 transition shadow-2xl transform hover:scale-105">
                    <i class="fas fa-calendar-check mr-2"></i>Book Free Consultation
                </a>
                <a href="apply.html" class="px-10 py-5 bg-transparent border-3 border-white text-white rounded-lg font-bold text-lg hover:bg-white hover:text-purple-600 transition shadow-2xl transform hover:scale-105">
                    <i class="fas fa-paper-plane mr-2"></i>Apply Now
                </a>
            </div>

            <!-- Stats Row -->
            <div class="mt-16 grid grid-cols-3 gap-8 max-w-3xl mx-auto">
                <div class="text-center">
                    <div class="text-4xl font-bold mb-2">98%</div>
                    <div class="text-sm text-purple-200">Success Rate</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold mb-2">10k+</div>
                    <div class="text-sm text-purple-200">Students Placed</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold mb-2">150+</div>
                    <div class="text-sm text-purple-200">Universities</div>
                </div>
            </div>
        </div>
    </section>
</div>
