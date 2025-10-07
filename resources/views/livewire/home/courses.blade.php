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
            <h1 class="text-5xl font-bold mb-4">Explore Our Courses</h1>
            <p class="text-xl">Find the perfect program for your academic and career goals</p>
        </div>
    </section>

    <!-- Filter Section -->
    <section class="py-8 px-4 bg-white shadow-md sticky top-20 z-40">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Course Level</label>
                    <select id="level-filter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                        <option value="">All Levels</option>
                        <option value="undergraduate">Undergraduate</option>
                        <option value="postgraduate">Postgraduate</option>
                        <option value="diploma">Diploma</option>
                        <option value="certificate">Certificate</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Field of Study</label>
                    <select id="field-filter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                        <option value="">All Fields</option>
                        <option value="business">Business & Management</option>
                        <option value="computing">Computing & IT</option>
                        <option value="engineering">Engineering</option>
                        <option value="health">Health Sciences</option>
                        <option value="law">Law</option>
                        <option value="arts">Arts & Humanities</option>
                        <option value="science">Science</option>
                        <option value="education">Education</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Duration</label>
                    <select id="duration-filter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                        <option value="">Any Duration</option>
                        <option value="1year">1 Year</option>
                        <option value="2years">2 Years</option>
                        <option value="3years">3 Years</option>
                        <option value="4years">4 Years</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <input type="text" id="search-input" placeholder="Search courses..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                </div>
            </div>
        </div>
    </section>

    <!-- Course Categories -->
    <section class="py-16 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-8">Browse by Category</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4">
                    <button class="category-btn px-4 py-3 bg-white rounded-lg shadow hover:shadow-lg transition text-center border-2 border-transparent hover:border-purple-600" data-category="all">
                        <i class="fas fa-th text-2xl text-purple-600 mb-2"></i>
                        <p class="text-sm font-semibold">All</p>
                    </button>
                    <button class="category-btn px-4 py-3 bg-white rounded-lg shadow hover:shadow-lg transition text-center border-2 border-transparent hover:border-purple-600" data-category="business">
                        <i class="fas fa-briefcase text-2xl text-blue-600 mb-2"></i>
                        <p class="text-sm font-semibold">Business</p>
                    </button>
                    <button class="category-btn px-4 py-3 bg-white rounded-lg shadow hover:shadow-lg transition text-center border-2 border-transparent hover:border-purple-600" data-category="computing">
                        <i class="fas fa-laptop-code text-2xl text-green-600 mb-2"></i>
                        <p class="text-sm font-semibold">Computing</p>
                    </button>
                    <button class="category-btn px-4 py-3 bg-white rounded-lg shadow hover:shadow-lg transition text-center border-2 border-transparent hover:border-purple-600" data-category="engineering">
                        <i class="fas fa-cogs text-2xl text-orange-600 mb-2"></i>
                        <p class="text-sm font-semibold">Engineering</p>
                    </button>
                    <button class="category-btn px-4 py-3 bg-white rounded-lg shadow hover:shadow-lg transition text-center border-2 border-transparent hover:border-purple-600" data-category="health">
                        <i class="fas fa-heartbeat text-2xl text-red-600 mb-2"></i>
                        <p class="text-sm font-semibold">Health</p>
                    </button>
                    <button class="category-btn px-4 py-3 bg-white rounded-lg shadow hover:shadow-lg transition text-center border-2 border-transparent hover:border-purple-600" data-category="law">
                        <i class="fas fa-balance-scale text-2xl text-purple-600 mb-2"></i>
                        <p class="text-sm font-semibold">Law</p>
                    </button>
                    <button class="category-btn px-4 py-3 bg-white rounded-lg shadow hover:shadow-lg transition text-center border-2 border-transparent hover:border-purple-600" data-category="arts">
                        <i class="fas fa-palette text-2xl text-pink-600 mb-2"></i>
                        <p class="text-sm font-semibold">Arts</p>
                    </button>
                    <button class="category-btn px-4 py-3 bg-white rounded-lg shadow hover:shadow-lg transition text-center border-2 border-transparent hover:border-purple-600" data-category="science">
                        <i class="fas fa-flask text-2xl text-yellow-600 mb-2"></i>
                        <p class="text-sm font-semibold">Science</p>
                    </button>
                </div>
            </div>

            <!-- Courses Grid -->
            <div class="mb-8">
                <p class="text-gray-600"><span id="results-count">48</span> courses found</p>
            </div>

            <div id="courses-grid" class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">

                <!-- Course Card 1 - Business -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover course-card" data-level="postgraduate" data-field="business" data-duration="1year">
                    <div class="h-48 bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center p-6">
                        <div class="text-white text-center">
                            <i class="fas fa-briefcase text-5xl mb-4"></i>
                            <h3 class="text-2xl font-bold">MBA</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 bg-purple-100 text-purple-600 rounded-full text-sm font-semibold">Postgraduate</span>
                            <span class="text-gray-600 text-sm"><i class="far fa-clock mr-1"></i> 1-2 Years</span>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Master of Business Administration</h3>
                        <p class="text-gray-600 mb-4">Develop strategic leadership and management skills for senior business roles.</p>
                        <div class="border-t pt-4 mb-4">
                            <div class="flex items-center text-sm text-gray-600 mb-2">
                                <i class="fas fa-university mr-2 text-purple-600"></i>
                                <span>Available at 45+ universities</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-pound-sign mr-2 text-purple-600"></i>
                                <span>£15,000 - £50,000/year</span>
                            </div>
                        </div>
                        <a href="#" class="block w-full text-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">View Details</a>
                    </div>
                </div>

                <!-- Course Card 2 - Computing -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover course-card" data-level="undergraduate" data-field="computing" data-duration="3years">
                    <div class="h-48 bg-gradient-to-br from-green-500 to-green-700 flex items-center justify-center p-6">
                        <div class="text-white text-center">
                            <i class="fas fa-laptop-code text-5xl mb-4"></i>
                            <h3 class="text-2xl font-bold">Computer Science</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-sm font-semibold">Undergraduate</span>
                            <span class="text-gray-600 text-sm"><i class="far fa-clock mr-1"></i> 3 Years</span>
                        </div>
                        <h3 class="text-xl font-bold mb-2">BSc Computer Science</h3>
                        <p class="text-gray-600 mb-4">Learn programming, algorithms, and software development fundamentals.</p>
                        <div class="border-t pt-4 mb-4">
                            <div class="flex items-center text-sm text-gray-600 mb-2">
                                <i class="fas fa-university mr-2 text-purple-600"></i>
                                <span>Available at 60+ universities</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-pound-sign mr-2 text-purple-600"></i>
                                <span>£12,000 - £35,000/year</span>
                            </div>
                        </div>
                        <a href="#" class="block w-full text-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">View Details</a>
                    </div>
                </div>

                <!-- Course Card 3 - Engineering -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover course-card" data-level="undergraduate" data-field="engineering" data-duration="4years">
                    <div class="h-48 bg-gradient-to-br from-orange-500 to-orange-700 flex items-center justify-center p-6">
                        <div class="text-white text-center">
                            <i class="fas fa-cogs text-5xl mb-4"></i>
                            <h3 class="text-2xl font-bold">Engineering</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-sm font-semibold">Undergraduate</span>
                            <span class="text-gray-600 text-sm"><i class="far fa-clock mr-1"></i> 4 Years</span>
                        </div>
                        <h3 class="text-xl font-bold mb-2">BEng Mechanical Engineering</h3>
                        <p class="text-gray-600 mb-4">Design and analyze mechanical systems and manufacturing processes.</p>
                        <div class="border-t pt-4 mb-4">
                            <div class="flex items-center text-sm text-gray-600 mb-2">
                                <i class="fas fa-university mr-2 text-purple-600"></i>
                                <span>Available at 38+ universities</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-pound-sign mr-2 text-purple-600"></i>
                                <span>£14,000 - £32,000/year</span>
                            </div>
                        </div>
                        <a href="#" class="block w-full text-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">View Details</a>
                    </div>
                </div>

                <!-- Course Card 4 - Health -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover course-card" data-level="postgraduate" data-field="health" data-duration="1year">
                    <div class="h-48 bg-gradient-to-br from-red-500 to-red-700 flex items-center justify-center p-6">
                        <div class="text-white text-center">
                            <i class="fas fa-heartbeat text-5xl mb-4"></i>
                            <h3 class="text-2xl font-bold">Public Health</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 bg-purple-100 text-purple-600 rounded-full text-sm font-semibold">Postgraduate</span>
                            <span class="text-gray-600 text-sm"><i class="far fa-clock mr-1"></i> 1 Year</span>
                        </div>
                        <h3 class="text-xl font-bold mb-2">MSc Public Health</h3>
                        <p class="text-gray-600 mb-4">Study health policy, epidemiology, and population health management.</p>
                        <div class="border-t pt-4 mb-4">
                            <div class="flex items-center text-sm text-gray-600 mb-2">
                                <i class="fas fa-university mr-2 text-purple-600"></i>
                                <span>Available at 42+ universities</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-pound-sign mr-2 text-purple-600"></i>
                                <span>£16,000 - £40,000/year</span>
                            </div>
                        </div>
                        <a href="#" class="block w-full text-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">View Details</a>
                    </div>
                </div>

                <!-- Course Card 5 - Law -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover course-card" data-level="undergraduate" data-field="law" data-duration="3years">
                    <div class="h-48 bg-gradient-to-br from-purple-500 to-purple-700 flex items-center justify-center p-6">
                        <div class="text-white text-center">
                            <i class="fas fa-balance-scale text-5xl mb-4"></i>
                            <h3 class="text-2xl font-bold">Law</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-sm font-semibold">Undergraduate</span>
                            <span class="text-gray-600 text-sm"><i class="far fa-clock mr-1"></i> 3 Years</span>
                        </div>
                        <h3 class="text-xl font-bold mb-2">LLB Law</h3>
                        <p class="text-gray-600 mb-4">Study legal systems, contract law, criminal law, and constitutional law.</p>
                        <div class="border-t pt-4 mb-4">
                            <div class="flex items-center text-sm text-gray-600 mb-2">
                                <i class="fas fa-university mr-2 text-purple-600"></i>
                                <span>Available at 55+ universities</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-pound-sign mr-2 text-purple-600"></i>
                                <span>£13,000 - £28,000/year</span>
                            </div>
                        </div>
                        <a href="#" class="block w-full text-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">View Details</a>
                    </div>
                </div>

                <!-- Course Card 6 - Data Science -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover course-card" data-level="postgraduate" data-field="computing" data-duration="1year">
                    <div class="h-48 bg-gradient-to-br from-teal-500 to-teal-700 flex items-center justify-center p-6">
                        <div class="text-white text-center">
                            <i class="fas fa-chart-line text-5xl mb-4"></i>
                            <h3 class="text-2xl font-bold">Data Science</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 bg-purple-100 text-purple-600 rounded-full text-sm font-semibold">Postgraduate</span>
                            <span class="text-gray-600 text-sm"><i class="far fa-clock mr-1"></i> 1 Year</span>
                        </div>
                        <h3 class="text-xl font-bold mb-2">MSc Data Science</h3>
                        <p class="text-gray-600 mb-4">Master machine learning, big data analytics, and statistical modeling.</p>
                        <div class="border-t pt-4 mb-4">
                            <div class="flex items-center text-sm text-gray-600 mb-2">
                                <i class="fas fa-university mr-2 text-purple-600"></i>
                                <span>Available at 52+ universities</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-pound-sign mr-2 text-purple-600"></i>
                                <span>£18,000 - £42,000/year</span>
                            </div>
                        </div>
                        <a href="#" class="block w-full text-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">View Details</a>
                    </div>
                </div>

                <!-- Course Card 7 - Finance -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover course-card" data-level="postgraduate" data-field="business" data-duration="1year">
                    <div class="h-48 bg-gradient-to-br from-indigo-500 to-indigo-700 flex items-center justify-center p-6">
                        <div class="text-white text-center">
                            <i class="fas fa-chart-pie text-5xl mb-4"></i>
                            <h3 class="text-2xl font-bold">Finance</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 bg-purple-100 text-purple-600 rounded-full text-sm font-semibold">Postgraduate</span>
                            <span class="text-gray-600 text-sm"><i class="far fa-clock mr-1"></i> 1 Year</span>
                        </div>
                        <h3 class="text-xl font-bold mb-2">MSc Finance</h3>
                        <p class="text-gray-600 mb-4">Advanced training in financial analysis, investment, and risk management.</p>
                        <div class="border-t pt-4 mb-4">
                            <div class="flex items-center text-sm text-gray-600 mb-2">
                                <i class="fas fa-university mr-2 text-purple-600"></i>
                                <span>Available at 48+ universities</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-pound-sign mr-2 text-purple-600"></i>
                                <span>£20,000 - £55,000/year</span>
                            </div>
                        </div>
                        <a href="#" class="block w-full text-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">View Details</a>
                    </div>
                </div>

                <!-- Course Card 8 - Psychology -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover course-card" data-level="undergraduate" data-field="science" data-duration="3years">
                    <div class="h-48 bg-gradient-to-br from-pink-500 to-pink-700 flex items-center justify-center p-6">
                        <div class="text-white text-center">
                            <i class="fas fa-brain text-5xl mb-4"></i>
                            <h3 class="text-2xl font-bold">Psychology</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-sm font-semibold">Undergraduate</span>
                            <span class="text-gray-600 text-sm"><i class="far fa-clock mr-1"></i> 3 Years</span>
                        </div>
                        <h3 class="text-xl font-bold mb-2">BSc Psychology</h3>
                        <p class="text-gray-600 mb-4">Explore human behavior, cognition, and mental health processes.</p>
                        <div class="border-t pt-4 mb-4">
                            <div class="flex items-center text-sm text-gray-600 mb-2">
                                <i class="fas fa-university mr-2 text-purple-600"></i>
                                <span>Available at 65+ universities</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-pound-sign mr-2 text-purple-600"></i>
                                <span>£11,000 - £26,000/year</span>
                            </div>
                        </div>
                        <a href="#" class="block w-full text-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">View Details</a>
                    </div>
                </div>

                <!-- Course Card 9 - Marketing -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover course-card" data-level="postgraduate" data-field="business" data-duration="1year">
                    <div class="h-48 bg-gradient-to-br from-yellow-500 to-yellow-700 flex items-center justify-center p-6">
                        <div class="text-white text-center">
                            <i class="fas fa-bullhorn text-5xl mb-4"></i>
                            <h3 class="text-2xl font-bold">Marketing</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 bg-purple-100 text-purple-600 rounded-full text-sm font-semibold">Postgraduate</span>
                            <span class="text-gray-600 text-sm"><i class="far fa-clock mr-1"></i> 1 Year</span>
                        </div>
                        <h3 class="text-xl font-bold mb-2">MSc Marketing</h3>
                        <p class="text-gray-600 mb-4">Learn digital marketing, brand management, and consumer behavior.</p>
                        <div class="border-t pt-4 mb-4">
                            <div class="flex items-center text-sm text-gray-600 mb-2">
                                <i class="fas fa-university mr-2 text-purple-600"></i>
                                <span>Available at 50+ universities</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-pound-sign mr-2 text-purple-600"></i>
                                <span>£14,000 - £38,000/year</span>
                            </div>
                        </div>
                        <a href="#" class="block w-full text-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">View Details</a>
                    </div>
                </div>

            </div>

            <!-- Load More Button -->
            <div class="text-center mt-12">
                <button class="px-8 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-semibold">
                    Load More Courses
                </button>
            </div>
        </div>
    </section>

    <!-- Pathway Courses Section -->
    <section class="py-16 px-4 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Pathway Programs</h2>
                <p class="text-xl text-gray-600">Preparation courses to help you meet university entry requirements</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-8 rounded-xl card-hover">
                    <div class="w-16 h-16 bg-purple-600 text-white rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-book text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">Foundation Programs</h3>
                    <p class="text-gray-700 mb-4">Bridge the gap between high school and university degree programs.</p>
                    <ul class="space-y-2 mb-6">
                        <li class="flex items-center text-sm"><i class="fas fa-check text-purple-600 mr-2"></i> Duration: 6-12 months</li>
                        <li class="flex items-center text-sm"><i class="fas fa-check text-purple-600 mr-2"></i> Entry to undergraduate</li>
                        <li class="flex items-center text-sm"><i class="fas fa-check text-purple-600 mr-2"></i> Subject-specific pathways</li>
                    </ul>
                    <a href="#" class="inline-block px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">Learn More</a>
                </div>

                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-8 rounded-xl card-hover">
                    <div class="w-16 h-16 bg-blue-600 text-white rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-graduation-cap text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">Pre-Masters</h3>
                    <p class="text-gray-700 mb-4">Prepare for postgraduate study with academic and English skills.</p>
                    <ul class="space-y-2 mb-6">
                        <li class="flex items-center text-sm"><i class="fas fa-check text-blue-600 mr-2"></i> Duration: 3-9 months</li>
                        <li class="flex items-center text-sm"><i class="fas fa-check text-blue-600 mr-2"></i> Entry to postgraduate</li>
                        <li class="flex items-center text-sm"><i class="fas fa-check text-blue-600 mr-2"></i> Research methodology</li>
                    </ul>
                    <a href="#" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Learn More</a>
                </div>

                <div class="bg-gradient-to-br from-green-50 to-green-100 p-8 rounded-xl card-hover">
                    <div class="w-16 h-16 bg-green-600 text-white rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-language text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">English Language</h3>
                    <p class="text-gray-700 mb-4">Improve your English proficiency to meet university requirements.</p>
                    <ul class="space-y-2 mb-6">
                        <li class="flex items-center text-sm"><i class="fas fa-check text-green-600 mr-2"></i> Duration: Flexible</li>
                        <li class="flex items-center text-sm"><i class="fas fa-check text-green-600 mr-2"></i> IELTS/TOEFL preparation</li>
                        <li class="flex items-center text-sm"><i class="fas fa-check text-green-600 mr-2"></i> Academic English</li>
                    </ul>
                    <a href="#" class="inline-block px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">Learn More</a>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 px-4 bg-gradient-to-r from-purple-600 to-indigo-600">
        <div class="max-w-4xl mx-auto text-center text-white">
            <h2 class="text-4xl font-bold mb-4">Not Sure Which Course to Choose?</h2>
            <p class="text-xl mb-8">Our expert counsellors can help you find the perfect program</p>
            <a href="contact.html" class="inline-block px-8 py-4 bg-white text-purple-600 rounded-lg font-semibold hover:bg-gray-100 transition">Get Free Guidance</a>
        </div>
    </section>
</div>
