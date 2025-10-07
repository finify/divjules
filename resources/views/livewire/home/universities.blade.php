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
            <h1 class="text-5xl font-bold mb-4">Partner Universities</h1>
            <p class="text-xl">Explore 150+ world-class institutions across the globe</p>
        </div>
    </section>

    <!-- Filter Section -->
    <section class="py-8 px-4 bg-white shadow-md sticky top-20 z-40">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                    <select id="country-filter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                        <option value="">All Countries</option>
                        <option value="uk">United Kingdom</option>
                        <option value="usa">United States</option>
                        <option value="canada">Canada</option>
                        <option value="australia">Australia</option>
                        <option value="germany">Germany</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">University Type</label>
                    <select id="type-filter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                        <option value="">All Types</option>
                        <option value="research">Research University</option>
                        <option value="public">Public University</option>
                        <option value="private">Private University</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ranking</label>
                    <select id="ranking-filter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                        <option value="">All Rankings</option>
                        <option value="top50">Top 50</option>
                        <option value="top100">Top 100</option>
                        <option value="top200">Top 200</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <input type="text" id="search-input" placeholder="Search universities..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                </div>
            </div>
        </div>
    </section>

    <!-- Universities Grid -->
    <section class="py-16 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8">
                <p class="text-gray-600"><span id="results-count">24</span> universities found</p>
            </div>

            <div id="universities-grid" class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">

                <!-- University Card 1 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover university-card" data-country="uk" data-type="research" data-ranking="top50">
                    <div class="h-48 bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center">
                        <div class="text-center text-white">
                            <h3 class="text-3xl font-bold">Oxford</h3>
                            <p class="text-sm">University</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 bg-purple-100 text-purple-600 rounded-full text-sm font-semibold">UK</span>
                            <span class="text-yellow-500"><i class="fas fa-star"></i> Rank #1</span>
                        </div>
                        <h3 class="text-xl font-bold mb-2">University of Oxford</h3>
                        <p class="text-gray-600 mb-4">World-renowned research university with centuries of academic excellence.</p>
                        <div class="flex items-center text-sm text-gray-500 mb-2">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            <span>Oxford, United Kingdom</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <i class="fas fa-graduation-cap mr-2"></i>
                            <span>24,000+ Students</span>
                        </div>
                        <a href="#" class="block w-full text-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">View Details</a>
                    </div>
                </div>

                <!-- University Card 2 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover university-card" data-country="uk" data-type="research" data-ranking="top50">
                    <div class="h-48 bg-gradient-to-br from-green-500 to-green-700 flex items-center justify-center">
                        <div class="text-center text-white">
                            <h3 class="text-3xl font-bold">Cambridge</h3>
                            <p class="text-sm">University</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 bg-purple-100 text-purple-600 rounded-full text-sm font-semibold">UK</span>
                            <span class="text-yellow-500"><i class="fas fa-star"></i> Rank #2</span>
                        </div>
                        <h3 class="text-xl font-bold mb-2">University of Cambridge</h3>
                        <p class="text-gray-600 mb-4">One of the world's oldest and most prestigious universities.</p>
                        <div class="flex items-center text-sm text-gray-500 mb-2">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            <span>Cambridge, United Kingdom</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <i class="fas fa-graduation-cap mr-2"></i>
                            <span>23,000+ Students</span>
                        </div>
                        <a href="#" class="block w-full text-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">View Details</a>
                    </div>
                </div>

                <!-- University Card 3 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover university-card" data-country="uk" data-type="research" data-ranking="top50">
                    <div class="h-48 bg-gradient-to-br from-purple-500 to-purple-700 flex items-center justify-center">
                        <div class="text-center text-white">
                            <h3 class="text-3xl font-bold">Imperial</h3>
                            <p class="text-sm">College London</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 bg-purple-100 text-purple-600 rounded-full text-sm font-semibold">UK</span>
                            <span class="text-yellow-500"><i class="fas fa-star"></i> Rank #6</span>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Imperial College London</h3>
                        <p class="text-gray-600 mb-4">Leading science, engineering, medicine and business institution.</p>
                        <div class="flex items-center text-sm text-gray-500 mb-2">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            <span>London, United Kingdom</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <i class="fas fa-graduation-cap mr-2"></i>
                            <span>17,000+ Students</span>
                        </div>
                        <a href="#" class="block w-full text-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">View Details</a>
                    </div>
                </div>

                <!-- University Card 4 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover university-card" data-country="uk" data-type="public" data-ranking="top50">
                    <div class="h-48 bg-gradient-to-br from-red-500 to-red-700 flex items-center justify-center">
                        <div class="text-center text-white">
                            <h3 class="text-3xl font-bold">UCL</h3>
                            <p class="text-sm">London</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 bg-purple-100 text-purple-600 rounded-full text-sm font-semibold">UK</span>
                            <span class="text-yellow-500"><i class="fas fa-star"></i> Rank #8</span>
                        </div>
                        <h3 class="text-xl font-bold mb-2">University College London</h3>
                        <p class="text-gray-600 mb-4">London's leading multidisciplinary university with global reputation.</p>
                        <div class="flex items-center text-sm text-gray-500 mb-2">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            <span>London, United Kingdom</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <i class="fas fa-graduation-cap mr-2"></i>
                            <span>42,000+ Students</span>
                        </div>
                        <a href="#" class="block w-full text-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">View Details</a>
                    </div>
                </div>

                <!-- University Card 5 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover university-card" data-country="uk" data-type="public" data-ranking="top50">
                    <div class="h-48 bg-gradient-to-br from-orange-500 to-orange-700 flex items-center justify-center">
                        <div class="text-center text-white">
                            <h3 class="text-3xl font-bold">LSE</h3>
                            <p class="text-sm">London School of Economics</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 bg-purple-100 text-purple-600 rounded-full text-sm font-semibold">UK</span>
                            <span class="text-yellow-500"><i class="fas fa-star"></i> Rank #49</span>
                        </div>
                        <h3 class="text-xl font-bold mb-2">London School of Economics</h3>
                        <p class="text-gray-600 mb-4">Specialist in social sciences with outstanding global reputation.</p>
                        <div class="flex items-center text-sm text-gray-500 mb-2">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            <span>London, United Kingdom</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <i class="fas fa-graduation-cap mr-2"></i>
                            <span>12,000+ Students</span>
                        </div>
                        <a href="#" class="block w-full text-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">View Details</a>
                    </div>
                </div>

                <!-- University Card 6 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover university-card" data-country="uk" data-type="public" data-ranking="top100">
                    <div class="h-48 bg-gradient-to-br from-indigo-500 to-indigo-700 flex items-center justify-center">
                        <div class="text-center text-white">
                            <h3 class="text-3xl font-bold">Edinburgh</h3>
                            <p class="text-sm">University</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 bg-purple-100 text-purple-600 rounded-full text-sm font-semibold">UK</span>
                            <span class="text-yellow-500"><i class="fas fa-star"></i> Rank #15</span>
                        </div>
                        <h3 class="text-xl font-bold mb-2">University of Edinburgh</h3>
                        <p class="text-gray-600 mb-4">Scotland's premier university with rich history of innovation.</p>
                        <div class="flex items-center text-sm text-gray-500 mb-2">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            <span>Edinburgh, United Kingdom</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <i class="fas fa-graduation-cap mr-2"></i>
                            <span>35,000+ Students</span>
                        </div>
                        <a href="#" class="block w-full text-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">View Details</a>
                    </div>
                </div>

                <!-- University Card 7 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover university-card" data-country="usa" data-type="private" data-ranking="top50">
                    <div class="h-48 bg-gradient-to-br from-pink-500 to-pink-700 flex items-center justify-center">
                        <div class="text-center text-white">
                            <h3 class="text-3xl font-bold">Harvard</h3>
                            <p class="text-sm">University</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-sm font-semibold">USA</span>
                            <span class="text-yellow-500"><i class="fas fa-star"></i> Rank #3</span>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Harvard University</h3>
                        <p class="text-gray-600 mb-4">Prestigious Ivy League institution with unmatched academic excellence.</p>
                        <div class="flex items-center text-sm text-gray-500 mb-2">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            <span>Cambridge, Massachusetts</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <i class="fas fa-graduation-cap mr-2"></i>
                            <span>31,000+ Students</span>
                        </div>
                        <a href="#" class="block w-full text-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">View Details</a>
                    </div>
                </div>

                <!-- University Card 8 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover university-card" data-country="usa" data-type="private" data-ranking="top50">
                    <div class="h-48 bg-gradient-to-br from-teal-500 to-teal-700 flex items-center justify-center">
                        <div class="text-center text-white">
                            <h3 class="text-3xl font-bold">MIT</h3>
                            <p class="text-sm">Massachusetts Institute of Technology</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-sm font-semibold">USA</span>
                            <span class="text-yellow-500"><i class="fas fa-star"></i> Rank #5</span>
                        </div>
                        <h3 class="text-xl font-bold mb-2">MIT</h3>
                        <p class="text-gray-600 mb-4">World leader in science, technology, and innovation.</p>
                        <div class="flex items-center text-sm text-gray-500 mb-2">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            <span>Cambridge, Massachusetts</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <i class="fas fa-graduation-cap mr-2"></i>
                            <span>11,000+ Students</span>
                        </div>
                        <a href="#" class="block w-full text-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">View Details</a>
                    </div>
                </div>

                <!-- University Card 9 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover university-card" data-country="canada" data-type="public" data-ranking="top100">
                    <div class="h-48 bg-gradient-to-br from-yellow-500 to-yellow-700 flex items-center justify-center">
                        <div class="text-center text-white">
                            <h3 class="text-3xl font-bold">Toronto</h3>
                            <p class="text-sm">University</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 bg-red-100 text-red-600 rounded-full text-sm font-semibold">Canada</span>
                            <span class="text-yellow-500"><i class="fas fa-star"></i> Rank #21</span>
                        </div>
                        <h3 class="text-xl font-bold mb-2">University of Toronto</h3>
                        <p class="text-gray-600 mb-4">Canada's top-ranked university with global research impact.</p>
                        <div class="flex items-center text-sm text-gray-500 mb-2">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            <span>Toronto, Canada</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <i class="fas fa-graduation-cap mr-2"></i>
                            <span>95,000+ Students</span>
                        </div>
                        <a href="#" class="block w-full text-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">View Details</a>
                    </div>
                </div>

            </div>

            <!-- Load More Button -->
            <div class="text-center mt-12">
                <button class="px-8 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-semibold">
                    Load More Universities
                </button>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 px-4 bg-gradient-to-r from-purple-600 to-indigo-600">
        <div class="max-w-4xl mx-auto text-center text-white">
            <h2 class="text-4xl font-bold mb-4">Can't Find Your Ideal University?</h2>
            <p class="text-xl mb-8">Contact our expert counsellors for personalized recommendations</p>
            <a href="contact.html" class="inline-block px-8 py-4 bg-white text-purple-600 rounded-lg font-semibold hover:bg-gray-100 transition">Get Free Consultation</a>
        </div>
    </section>
</div>
