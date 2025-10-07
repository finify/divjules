<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};

new 
#[Layout('components.layouts.home')]
#[Title('Home')]
class extends Component {
    //
}; ?>

<div>
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-purple-600 to-indigo-600 pt-32 pb-16 px-4 mt-20">
        <div class="max-w-7xl mx-auto text-center text-white">
            <h1 class="text-5xl font-bold mb-4">About Divjules</h1>
            <p class="text-xl">Empowering students to achieve their global education dreams</p>
        </div>
    </section>

    <!-- Our Story -->
    <section class="py-20 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-4xl font-bold text-gray-800 mb-6">Our Story</h2>
                    <p class="text-gray-600 text-lg mb-4">Founded with a vision to make international education accessible to students worldwide, Divjules has been at the forefront of educational consulting for over a decade.</p>
                    <p class="text-gray-600 text-lg mb-4">We understand that choosing the right university and course is one of the most important decisions in a student's life. That's why we're committed to providing personalized, expert guidance every step of the way.</p>
                    <p class="text-gray-600 text-lg">With a global network of partner institutions and a team of experienced counsellors, we've helped thousands of students transform their educational aspirations into reality.</p>
                </div>
                <div>
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800" alt="Team working together" class="rounded-lg shadow-xl">
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="py-20 px-4 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12">
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-12 rounded-2xl">
                    <div class="w-16 h-16 bg-purple-600 text-white rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-bullseye text-2xl"></i>
                    </div>
                    <h3 class="text-3xl font-bold mb-4">Our Mission</h3>
                    <p class="text-gray-700 text-lg">To provide comprehensive, personalized educational consulting services that empower students to make informed decisions about their academic future and achieve their full potential in a global context.</p>
                </div>

                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-12 rounded-2xl">
                    <div class="w-16 h-16 bg-blue-600 text-white rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-eye text-2xl"></i>
                    </div>
                    <h3 class="text-3xl font-bold mb-4">Our Vision</h3>
                    <p class="text-gray-700 text-lg">To be the world's most trusted education consultancy, recognized for our commitment to student success, innovation in educational services, and creating pathways to quality education for students from all backgrounds.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Values -->
    <section class="py-20 px-4 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Our Core Values</h2>
                <p class="text-xl text-gray-600">The principles that guide everything we do</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-xl shadow-lg text-center">
                    <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-handshake text-3xl text-purple-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Integrity</h3>
                    <p class="text-gray-600">We maintain the highest standards of honesty and transparency in all our interactions with students and partners.</p>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-lg text-center">
                    <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-star text-3xl text-blue-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Excellence</h3>
                    <p class="text-gray-600">We strive for excellence in every aspect of our service delivery and continuously improve our offerings.</p>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-lg text-center">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-users text-3xl text-green-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Student-Centric</h3>
                    <p class="text-gray-600">Every decision we make prioritizes the best interests and success of our students.</p>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-lg text-center">
                    <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-lightbulb text-3xl text-orange-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Innovation</h3>
                    <p class="text-gray-600">We embrace new technologies and methods to enhance the student experience and service quality.</p>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-lg text-center">
                    <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-globe text-3xl text-red-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Global Perspective</h3>
                    <p class="text-gray-600">We foster cultural understanding and prepare students for success in an interconnected world.</p>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-lg text-center">
                    <div class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-heart text-3xl text-indigo-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Commitment</h3>
                    <p class="text-gray-600">We are dedicated to supporting our students throughout their entire educational journey.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Team -->
    <section class="py-20 px-4 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Meet Our Leadership Team</h2>
                <p class="text-xl text-gray-600">Experienced professionals dedicated to your success</p>
            </div>

            <div class="grid md:grid-cols-4 gap-8">
                <div class="text-center">
                    <img src="https://ui-avatars.com/api/?name=David+Jules&size=200&background=667eea&color=fff" alt="Team member" class="w-48 h-48 rounded-full mx-auto mb-4 shadow-lg">
                    <h3 class="text-xl font-bold mb-1">David Jules</h3>
                    <p class="text-purple-600 font-semibold mb-2">CEO & Founder</p>
                    <p class="text-gray-600 text-sm mb-4">15+ years in education consulting</p>
                    <div class="flex justify-center space-x-3">
                        <a href="#" class="text-gray-400 hover:text-purple-600"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-gray-400 hover:text-purple-600"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>

                <div class="text-center">
                    <img src="https://ui-avatars.com/api/?name=Sarah+Mitchell&size=200&background=764ba2&color=fff" alt="Team member" class="w-48 h-48 rounded-full mx-auto mb-4 shadow-lg">
                    <h3 class="text-xl font-bold mb-1">Sarah Mitchell</h3>
                    <p class="text-purple-600 font-semibold mb-2">Director of Operations</p>
                    <p class="text-gray-600 text-sm mb-4">12+ years in student services</p>
                    <div class="flex justify-center space-x-3">
                        <a href="#" class="text-gray-400 hover:text-purple-600"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-gray-400 hover:text-purple-600"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>

                <div class="text-center">
                    <img src="https://ui-avatars.com/api/?name=James+Anderson&size=200&background=667eea&color=fff" alt="Team member" class="w-48 h-48 rounded-full mx-auto mb-4 shadow-lg">
                    <h3 class="text-xl font-bold mb-1">James Anderson</h3>
                    <p class="text-purple-600 font-semibold mb-2">Head of Counselling</p>
                    <p class="text-gray-600 text-sm mb-4">10+ years counselling experience</p>
                    <div class="flex justify-center space-x-3">
                        <a href="#" class="text-gray-400 hover:text-purple-600"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-gray-400 hover:text-purple-600"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>

                <div class="text-center">
                    <img src="https://ui-avatars.com/api/?name=Emily+Chen&size=200&background=764ba2&color=fff" alt="Team member" class="w-48 h-48 rounded-full mx-auto mb-4 shadow-lg">
                    <h3 class="text-xl font-bold mb-1">Emily Chen</h3>
                    <p class="text-purple-600 font-semibold mb-2">Partnerships Director</p>
                    <p class="text-gray-600 text-sm mb-4">8+ years in university relations</p>
                    <div class="flex justify-center space-x-3">
                        <a href="#" class="text-gray-400 hover:text-purple-600"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-gray-400 hover:text-purple-600"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Global Presence -->
    <section class="py-20 px-4 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Our Global Presence</h2>
                <p class="text-xl text-gray-600">Offices across the world to serve you better</p>
            </div>

            <div class="grid md:grid-cols-3 lg:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <i class="fas fa-map-marker-alt text-3xl text-purple-600 mb-3"></i>
                    <h3 class="font-bold text-lg mb-1">United Kingdom</h3>
                    <p class="text-gray-600 text-sm">London, Manchester</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <i class="fas fa-map-marker-alt text-3xl text-purple-600 mb-3"></i>
                    <h3 class="font-bold text-lg mb-1">United States</h3>
                    <p class="text-gray-600 text-sm">New York, Los Angeles</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <i class="fas fa-map-marker-alt text-3xl text-purple-600 mb-3"></i>
                    <h3 class="font-bold text-lg mb-1">Canada</h3>
                    <p class="text-gray-600 text-sm">Toronto, Vancouver</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <i class="fas fa-map-marker-alt text-3xl text-purple-600 mb-3"></i>
                    <h3 class="font-bold text-lg mb-1">Australia</h3>
                    <p class="text-gray-600 text-sm">Sydney, Melbourne</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <i class="fas fa-map-marker-alt text-3xl text-purple-600 mb-3"></i>
                    <h3 class="font-bold text-lg mb-1">India</h3>
                    <p class="text-gray-600 text-sm">Delhi, Mumbai, Bangalore</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <i class="fas fa-map-marker-alt text-3xl text-purple-600 mb-3"></i>
                    <h3 class="font-bold text-lg mb-1">Singapore</h3>
                    <p class="text-gray-600 text-sm">Central Business District</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <i class="fas fa-map-marker-alt text-3xl text-purple-600 mb-3"></i>
                    <h3 class="font-bold text-lg mb-1">UAE</h3>
                    <p class="text-gray-600 text-sm">Dubai, Abu Dhabi</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <i class="fas fa-map-marker-alt text-3xl text-purple-600 mb-3"></i>
                    <h3 class="font-bold text-lg mb-1">Nigeria</h3>
                    <p class="text-gray-600 text-sm">Lagos, Abuja</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Accreditations -->
    <section class="py-20 px-4 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Accreditations & Partnerships</h2>
                <p class="text-xl text-gray-600">Recognized and certified by leading educational bodies</p>
            </div>

            <div class="grid md:grid-cols-4 gap-8">
                <div class="bg-gray-50 p-8 rounded-lg text-center">
                    <i class="fas fa-certificate text-5xl text-purple-600 mb-4"></i>
                    <h3 class="font-bold mb-2">British Council</h3>
                    <p class="text-sm text-gray-600">Certified Education Agent</p>
                </div>

                <div class="bg-gray-50 p-8 rounded-lg text-center">
                    <i class="fas fa-award text-5xl text-blue-600 mb-4"></i>
                    <h3 class="font-bold mb-2">ICEF</h3>
                    <p class="text-sm text-gray-600">Agency Member</p>
                </div>

                <div class="bg-gray-50 p-8 rounded-lg text-center">
                    <i class="fas fa-medal text-5xl text-green-600 mb-4"></i>
                    <h3 class="font-bold mb-2">NAFSA</h3>
                    <p class="text-sm text-gray-600">Professional Member</p>
                </div>

                <div class="bg-gray-50 p-8 rounded-lg text-center">
                    <i class="fas fa-shield-alt text-5xl text-orange-600 mb-4"></i>
                    <h3 class="font-bold mb-2">UCAS</h3>
                    <p class="text-sm text-gray-600">Registered Center</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 px-4 bg-gradient-to-r from-purple-600 to-indigo-600">
        <div class="max-w-4xl mx-auto text-center text-white">
            <h2 class="text-4xl font-bold mb-4">Ready to Start Your Journey?</h2>
            <p class="text-xl mb-8">Join thousands of successful students who trusted us with their education</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="contact.html" class="px-8 py-4 bg-white text-purple-600 rounded-lg font-semibold hover:bg-gray-100 transition">Contact Us Today</a>
                <a href="apply.html" class="px-8 py-4 bg-transparent border-2 border-white text-white rounded-lg font-semibold hover:bg-white hover:text-purple-600 transition">Start Application</a>
            </div>
        </div>
    </section>
</div>
