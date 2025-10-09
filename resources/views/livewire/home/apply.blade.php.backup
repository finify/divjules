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
            <h1 class="text-5xl font-bold mb-4">Start Your Application</h1>
            <p class="text-xl">Complete your application in a few simple steps</p>
        </div>
    </section>

    <!-- Progress Steps -->
    <section class="py-8 px-4 bg-white shadow-md sticky top-20 z-40">
        <div class="max-w-5xl mx-auto">
            <div class="flex items-center justify-between">
                <!-- Step 1 -->
                <div class="flex items-center flex-1">
                    <div id="step-indicator-1" class="w-12 h-12 step-active text-white rounded-full flex items-center justify-center font-bold text-lg">1</div>
                    <div class="ml-3 hidden sm:block">
                        <p class="font-bold text-sm">Personal Info</p>
                        <p class="text-xs text-gray-500">Basic details</p>
                    </div>
                </div>
                <div class="h-1 flex-1 bg-gray-300 mx-2"></div>

                <!-- Step 2 -->
                <div class="flex items-center flex-1">
                    <div id="step-indicator-2" class="w-12 h-12 bg-gray-300 text-white rounded-full flex items-center justify-center font-bold text-lg step-inactive">2</div>
                    <div class="ml-3 hidden sm:block">
                        <p class="font-bold text-sm">Education</p>
                        <p class="text-xs text-gray-500">Academic history</p>
                    </div>
                </div>
                <div class="h-1 flex-1 bg-gray-300 mx-2"></div>

                <!-- Step 3 -->
                <div class="flex items-center flex-1">
                    <div id="step-indicator-3" class="w-12 h-12 bg-gray-300 text-white rounded-full flex items-center justify-center font-bold text-lg step-inactive">3</div>
                    <div class="ml-3 hidden sm:block">
                        <p class="font-bold text-sm">Preferences</p>
                        <p class="text-xs text-gray-500">Course selection</p>
                    </div>
                </div>
                <div class="h-1 flex-1 bg-gray-300 mx-2"></div>

                <!-- Step 4 -->
                <div class="flex items-center flex-1">
                    <div id="step-indicator-4" class="w-12 h-12 bg-gray-300 text-white rounded-full flex items-center justify-center font-bold text-lg step-inactive">4</div>
                    <div class="ml-3 hidden sm:block">
                        <p class="font-bold text-sm">Documents</p>
                        <p class="text-xs text-gray-500">Upload files</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Application Form -->
    <section class="py-16 px-4">
        <div class="max-w-4xl mx-auto">
            <form id="application-form">

                <!-- Step 1: Personal Information -->
                <div id="step-1" class="bg-white p-8 rounded-xl shadow-lg">
                    <h2 class="text-3xl font-bold mb-2">Personal Information</h2>
                    <p class="text-gray-600 mb-8">Let's start with your basic details</p>

                    <div class="space-y-6">
                        <div class="grid md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                                <select required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                                    <option value="">Select</option>
                                    <option value="mr">Mr.</option>
                                    <option value="ms">Ms.</option>
                                    <option value="mrs">Mrs.</option>
                                    <option value="dr">Dr.</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">First Name *</label>
                                <input type="text" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Last Name *</label>
                                <input type="text" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                                <input type="email" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                                <input type="tel" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth *</label>
                                <input type="date" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Gender *</label>
                                <select required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                                    <option value="">Select</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                    <option value="prefer-not">Prefer not to say</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nationality *</label>
                                <select required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                                    <option value="">Select your country</option>
                                    <option value="uk">United Kingdom</option>
                                    <option value="us">United States</option>
                                    <option value="india">India</option>
                                    <option value="nigeria">Nigeria</option>
                                    <option value="canada">Canada</option>
                                    <option value="australia">Australia</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Country of Residence *</label>
                                <select required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                                    <option value="">Select your country</option>
                                    <option value="uk">United Kingdom</option>
                                    <option value="us">United States</option>
                                    <option value="india">India</option>
                                    <option value="nigeria">Nigeria</option>
                                    <option value="canada">Canada</option>
                                    <option value="australia">Australia</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Address *</label>
                            <textarea rows="3" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"></textarea>
                        </div>
                    </div>

                    <div class="flex justify-end mt-8">
                        <button type="button" onclick="nextStep(2)" class="px-8 py-3 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition">
                            Next: Education <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>

                <!-- Step 2: Education Background -->
                <div id="step-2" class="bg-white p-8 rounded-xl shadow-lg hidden">
                    <h2 class="text-3xl font-bold mb-2">Education Background</h2>
                    <p class="text-gray-600 mb-8">Tell us about your academic qualifications</p>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Highest Level of Education *</label>
                            <select required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                                <option value="">Select</option>
                                <option value="high-school">High School / Secondary</option>
                                <option value="diploma">Diploma</option>
                                <option value="bachelor">Bachelor's Degree</option>
                                <option value="master">Master's Degree</option>
                                <option value="phd">PhD</option>
                            </select>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Institution Name *</label>
                                <input type="text" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Country *</label>
                                <select required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                                    <option value="">Select</option>
                                    <option value="uk">United Kingdom</option>
                                    <option value="us">United States</option>
                                    <option value="india">India</option>
                                    <option value="nigeria">Nigeria</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Field of Study *</label>
                                <input type="text" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Grade/GPA *</label>
                                <input type="text" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Start Date *</label>
                                <input type="month" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">End Date *</label>
                                <input type="month" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                            </div>
                        </div>

                        <div>
                            <h3 class="font-bold mb-4">English Language Proficiency</h3>
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Test Type</label>
                                    <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                                        <option value="">Select (if taken)</option>
                                        <option value="ielts">IELTS</option>
                                        <option value="toefl">TOEFL</option>
                                        <option value="pte">PTE</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Score</label>
                                    <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between mt-8">
                        <button type="button" onclick="prevStep(1)" class="px-8 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition">
                            <i class="fas fa-arrow-left mr-2"></i> Back
                        </button>
                        <button type="button" onclick="nextStep(3)" class="px-8 py-3 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition">
                            Next: Preferences <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>

                <!-- Step 3: Course Preferences -->
                <div id="step-3" class="bg-white p-8 rounded-xl shadow-lg hidden">
                    <h2 class="text-3xl font-bold mb-2">Course Preferences</h2>
                    <p class="text-gray-600 mb-8">Select your preferred courses and universities</p>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Program Level *</label>
                            <select required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                                <option value="">Select</option>
                                <option value="undergraduate">Undergraduate</option>
                                <option value="postgraduate">Postgraduate (Masters)</option>
                                <option value="phd">PhD</option>
                                <option value="pathway">Pathway/Foundation</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Field of Study *</label>
                            <select required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                                <option value="">Select your field</option>
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
                            <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Course Title *</label>
                            <input type="text" required placeholder="e.g., MSc Computer Science" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Country *</label>
                            <select required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                                <option value="">Select</option>
                                <option value="uk">United Kingdom</option>
                                <option value="us">United States</option>
                                <option value="canada">Canada</option>
                                <option value="australia">Australia</option>
                                <option value="germany">Germany</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Universities (Select up to 3)</label>
                            <div class="space-y-2">
                                <input type="text" placeholder="University 1" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                                <input type="text" placeholder="University 2" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                                <input type="text" placeholder="University 3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Intended Start Date *</label>
                                <select required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                                    <option value="">Select</option>
                                    <option value="sep-2024">September 2024</option>
                                    <option value="jan-2025">January 2025</option>
                                    <option value="sep-2025">September 2025</option>
                                    <option value="jan-2026">January 2026</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Study Mode *</label>
                                <select required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                                    <option value="">Select</option>
                                    <option value="full-time">Full-time</option>
                                    <option value="part-time">Part-time</option>
                                    <option value="online">Online</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between mt-8">
                        <button type="button" onclick="prevStep(2)" class="px-8 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition">
                            <i class="fas fa-arrow-left mr-2"></i> Back
                        </button>
                        <button type="button" onclick="nextStep(4)" class="px-8 py-3 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition">
                            Next: Documents <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>

                <!-- Step 4: Documents -->
                <div id="step-4" class="bg-white p-8 rounded-xl shadow-lg hidden">
                    <h2 class="text-3xl font-bold mb-2">Upload Documents</h2>
                    <p class="text-gray-600 mb-8">Upload your supporting documents (PDF or JPG format, max 5MB each)</p>

                    <div class="space-y-6">
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Academic Transcripts *</label>
                            <input type="file" accept=".pdf,.jpg,.jpeg,.png" class="w-full">
                            <p class="text-xs text-gray-500 mt-2">Upload your official academic transcripts</p>
                        </div>

                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Degree Certificate/Diploma *</label>
                            <input type="file" accept=".pdf,.jpg,.jpeg,.png" class="w-full">
                            <p class="text-xs text-gray-500 mt-2">Upload your degree certificate or diploma</p>
                        </div>

                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Passport Copy *</label>
                            <input type="file" accept=".pdf,.jpg,.jpeg,.png" class="w-full">
                            <p class="text-xs text-gray-500 mt-2">Upload a clear copy of your passport</p>
                        </div>

                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">English Language Test Results</label>
                            <input type="file" accept=".pdf,.jpg,.jpeg,.png" class="w-full">
                            <p class="text-xs text-gray-500 mt-2">Upload IELTS/TOEFL/PTE results if available</p>
                        </div>

                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">CV/Resume</label>
                            <input type="file" accept=".pdf,.doc,.docx" class="w-full">
                            <p class="text-xs text-gray-500 mt-2">Upload your latest CV or resume</p>
                        </div>

                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Personal Statement</label>
                            <input type="file" accept=".pdf,.doc,.docx" class="w-full">
                            <p class="text-xs text-gray-500 mt-2">Upload your personal statement or statement of purpose</p>
                        </div>

                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex">
                                <i class="fas fa-info-circle text-blue-600 mt-1 mr-3"></i>
                                <div class="text-sm text-blue-800">
                                    <p class="font-semibold mb-1">Important Notes:</p>
                                    <ul class="list-disc list-inside space-y-1">
                                        <li>All documents should be in English or officially translated</li>
                                        <li>File size should not exceed 5MB per document</li>
                                        <li>Accepted formats: PDF, JPG, PNG, DOC, DOCX</li>
                                        <li>You can upload additional documents later if needed</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="border-t pt-6">
                            <div class="flex items-start mb-4">
                                <input type="checkbox" id="terms" required class="mt-1 mr-3">
                                <label for="terms" class="text-sm text-gray-700">
                                    I confirm that all information provided is accurate and complete. I agree to the <a href="#" class="text-purple-600 hover:underline">Terms & Conditions</a> and <a href="#" class="text-purple-600 hover:underline">Privacy Policy</a>.
                                </label>
                            </div>

                            <div class="flex items-start">
                                <input type="checkbox" id="marketing" class="mt-1 mr-3">
                                <label for="marketing" class="text-sm text-gray-700">
                                    I would like to receive updates, tips, and information about courses and scholarships from Divjules.
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between mt-8">
                        <button type="button" onclick="prevStep(3)" class="px-8 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition">
                            <i class="fas fa-arrow-left mr-2"></i> Back
                        </button>
                        <button type="submit" class="px-8 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition">
                            <i class="fas fa-check mr-2"></i> Submit Application
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </section>

    <!-- Help Section -->
    <section class="py-16 px-4 bg-white">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl font-bold mb-4">Need Help with Your Application?</h2>
            <p class="text-gray-600 text-lg mb-8">Our expert counsellors are here to assist you</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="contact.html" class="px-8 py-3 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition">
                    <i class="fas fa-phone mr-2"></i> Call Us Now
                </a>
                <a href="contact.html" class="px-8 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition">
                    <i class="fas fa-envelope mr-2"></i> Email Support
                </a>
            </div>
        </div>
    </section>

    <script>
        function nextStep(step) {
            // Hide all steps
            for (let i = 1; i <= 4; i++) {
                document.getElementById(`step-${i}`).classList.add('hidden');
                document.getElementById(`step-indicator-${i}`).classList.remove('step-active');
                document.getElementById(`step-indicator-${i}`).classList.add('step-inactive');
            }

            // Show target step
            document.getElementById(`step-${step}`).classList.remove('hidden');
            document.getElementById(`step-indicator-${step}`).classList.add('step-active');
            document.getElementById(`step-indicator-${step}`).classList.remove('step-inactive');

            // Scroll to top
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function prevStep(step) {
            nextStep(step);
        }

        // Handle form submission
        document.getElementById('application-form').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Application submitted successfully! Our team will contact you within 24 hours.');
            window.location.href = '/';
        });
    </script>
</div>
