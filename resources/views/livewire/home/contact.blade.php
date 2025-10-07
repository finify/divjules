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
            <h1 class="text-5xl font-bold mb-4">Get in Touch</h1>
            <p class="text-xl">We're here to answer all your questions about studying abroad</p>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-20 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12">

                <!-- Contact Form -->
                <div class="bg-white p-8 rounded-xl shadow-lg">
                    <h2 class="text-3xl font-bold mb-6">Send Us a Message</h2>
                    <form id="contact-form" class="space-y-6">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="firstName" class="block text-sm font-medium text-gray-700 mb-2">First Name *</label>
                                <input type="text" id="firstName" name="firstName" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                            </div>
                            <div>
                                <label for="lastName" class="block text-sm font-medium text-gray-700 mb-2">Last Name *</label>
                                <input type="text" id="lastName" name="lastName" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                            </div>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                            <input type="email" id="email" name="email" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                            <input type="tel" id="phone" name="phone" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                        </div>

                        <div>
                            <label for="country" class="block text-sm font-medium text-gray-700 mb-2">Country *</label>
                            <select id="country" name="country" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                                <option value="">Select your country</option>
                                <option value="uk">United Kingdom</option>
                                <option value="us">United States</option>
                                <option value="canada">Canada</option>
                                <option value="australia">Australia</option>
                                <option value="india">India</option>
                                <option value="nigeria">Nigeria</option>
                                <option value="uae">United Arab Emirates</option>
                                <option value="singapore">Singapore</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div>
                            <label for="interest" class="block text-sm font-medium text-gray-700 mb-2">I'm Interested In *</label>
                            <select id="interest" name="interest" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                                <option value="">Select an option</option>
                                <option value="undergraduate">Undergraduate Programs</option>
                                <option value="postgraduate">Postgraduate Programs</option>
                                <option value="pathway">Pathway Courses</option>
                                <option value="consultation">Free Consultation</option>
                                <option value="visa">Visa Assistance</option>
                                <option value="other">Other Services</option>
                            </select>
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Your Message *</label>
                            <textarea id="message" name="message" rows="5" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"></textarea>
                        </div>

                        <div class="flex items-start">
                            <input type="checkbox" id="consent" name="consent" required class="mt-1 mr-3">
                            <label for="consent" class="text-sm text-gray-600">
                                I agree to receive information about courses and services from Divjules. We respect your privacy and will never share your details with third parties.
                            </label>
                        </div>

                        <button type="submit" class="w-full px-8 py-4 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition">
                            Send Message
                        </button>
                    </form>
                </div>

                <!-- Contact Information -->
                <div>
                    <div class="bg-white p-8 rounded-xl shadow-lg mb-8">
                        <h2 class="text-3xl font-bold mb-6">Contact Information</h2>

                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-phone text-purple-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold mb-1">Phone</h3>
                                    <p class="text-gray-600">+44 (0) 20 1234 5678</p>
                                    <p class="text-gray-600">+1 (555) 123-4567</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-envelope text-purple-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold mb-1">Email</h3>
                                    <p class="text-gray-600">info@divjules.com</p>
                                    <p class="text-gray-600">admissions@divjules.com</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-map-marker-alt text-purple-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold mb-1">Office Address</h3>
                                    <p class="text-gray-600">123 Education Street</p>
                                    <p class="text-gray-600">London, UK WC1A 1AA</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-clock text-purple-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold mb-1">Business Hours</h3>
                                    <p class="text-gray-600">Monday - Friday: 9:00 AM - 6:00 PM</p>
                                    <p class="text-gray-600">Saturday: 10:00 AM - 4:00 PM</p>
                                    <p class="text-gray-600">Sunday: Closed</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 pt-8 border-t">
                            <h3 class="font-bold mb-4">Follow Us</h3>
                            <div class="flex space-x-4">
                                <a href="#" class="w-12 h-12 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center hover:bg-purple-600 hover:text-white transition">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="w-12 h-12 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center hover:bg-purple-600 hover:text-white transition">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="w-12 h-12 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center hover:bg-purple-600 hover:text-white transition">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="#" class="w-12 h-12 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center hover:bg-purple-600 hover:text-white transition">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <a href="#" class="w-12 h-12 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center hover:bg-purple-600 hover:text-white transition">
                                    <i class="fab fa-youtube"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="bg-gradient-to-br from-purple-600 to-indigo-600 p-8 rounded-xl shadow-lg text-white">
                        <h3 class="text-2xl font-bold mb-4">Book a Free Consultation</h3>
                        <p class="mb-6">Schedule a one-on-one session with our expert counsellors to discuss your study abroad plans.</p>
                        <a href="apply.html" class="inline-block px-6 py-3 bg-white text-purple-600 rounded-lg font-semibold hover:bg-gray-100 transition">Book Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Office Locations -->
    <section class="py-20 px-4 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Our Office Locations</h2>
                <p class="text-xl text-gray-600">Visit us at any of our global offices</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- UK Office -->
                <div class="bg-gray-50 p-8 rounded-xl shadow-lg">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-purple-600 text-white rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-building"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-xl">London, UK</h3>
                            <span class="text-sm text-purple-600">Headquarters</span>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-2">123 Education Street</p>
                    <p class="text-gray-600 mb-2">London, WC1A 1AA</p>
                    <p class="text-gray-600 mb-4">United Kingdom</p>
                    <p class="text-gray-700"><i class="fas fa-phone mr-2 text-purple-600"></i> +44 (0) 20 1234 5678</p>
                </div>

                <!-- USA Office -->
                <div class="bg-gray-50 p-8 rounded-xl shadow-lg">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-blue-600 text-white rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-building"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-xl">New York, USA</h3>
                            <span class="text-sm text-blue-600">Regional Office</span>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-2">456 Fifth Avenue</p>
                    <p class="text-gray-600 mb-2">New York, NY 10001</p>
                    <p class="text-gray-600 mb-4">United States</p>
                    <p class="text-gray-700"><i class="fas fa-phone mr-2 text-blue-600"></i> +1 (555) 123-4567</p>
                </div>

                <!-- Canada Office -->
                <div class="bg-gray-50 p-8 rounded-xl shadow-lg">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-red-600 text-white rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-building"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-xl">Toronto, Canada</h3>
                            <span class="text-sm text-red-600">Regional Office</span>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-2">789 Bay Street</p>
                    <p class="text-gray-600 mb-2">Toronto, ON M5G 2C8</p>
                    <p class="text-gray-600 mb-4">Canada</p>
                    <p class="text-gray-700"><i class="fas fa-phone mr-2 text-red-600"></i> +1 (416) 123-4567</p>
                </div>

                <!-- India Office -->
                <div class="bg-gray-50 p-8 rounded-xl shadow-lg">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-orange-600 text-white rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-building"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-xl">Delhi, India</h3>
                            <span class="text-sm text-orange-600">Regional Office</span>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-2">Connaught Place</p>
                    <p class="text-gray-600 mb-2">New Delhi, 110001</p>
                    <p class="text-gray-600 mb-4">India</p>
                    <p class="text-gray-700"><i class="fas fa-phone mr-2 text-orange-600"></i> +91 11 1234 5678</p>
                </div>

                <!-- UAE Office -->
                <div class="bg-gray-50 p-8 rounded-xl shadow-lg">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-green-600 text-white rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-building"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-xl">Dubai, UAE</h3>
                            <span class="text-sm text-green-600">Regional Office</span>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-2">Business Bay</p>
                    <p class="text-gray-600 mb-2">Dubai</p>
                    <p class="text-gray-600 mb-4">United Arab Emirates</p>
                    <p class="text-gray-700"><i class="fas fa-phone mr-2 text-green-600"></i> +971 4 123 4567</p>
                </div>

                <!-- Australia Office -->
                <div class="bg-gray-50 p-8 rounded-xl shadow-lg">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-indigo-600 text-white rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-building"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-xl">Sydney, Australia</h3>
                            <span class="text-sm text-indigo-600">Regional Office</span>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-2">George Street</p>
                    <p class="text-gray-600 mb-2">Sydney, NSW 2000</p>
                    <p class="text-gray-600 mb-4">Australia</p>
                    <p class="text-gray-700"><i class="fas fa-phone mr-2 text-indigo-600"></i> +61 2 1234 5678</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20 px-4 bg-gray-50">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Frequently Asked Questions</h2>
                <p class="text-xl text-gray-600">Quick answers to common questions</p>
            </div>

            <div class="space-y-4">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="font-bold text-lg mb-2">How long does the application process take?</h3>
                    <p class="text-gray-600">Typically, the entire process takes 4-8 weeks, depending on the university and course. We'll guide you through each step to ensure timely submission.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="font-bold text-lg mb-2">Do you charge for consultation services?</h3>
                    <p class="text-gray-600">Your initial consultation is completely free! We'll discuss your goals and provide guidance at no cost. Additional services may have fees, which we'll discuss transparently.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="font-bold text-lg mb-2">Can you help with visa applications?</h3>
                    <p class="text-gray-600">Yes! We provide comprehensive visa assistance, including document preparation, application review, and interview preparation to maximize your chances of approval.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="font-bold text-lg mb-2">What if I don't meet the entry requirements?</h3>
                    <p class="text-gray-600">We offer pathway programs and foundation courses that can help you meet university requirements. Our counsellors will find the best route for your situation.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="font-bold text-lg mb-2">Do you help with scholarships?</h3>
                    <p class="text-gray-600">Absolutely! We have information on numerous scholarships and can help you identify and apply for opportunities that match your profile.</p>
                </div>
            </div>

            <div class="text-center mt-12">
                <p class="text-gray-600 mb-4">Still have questions?</p>
                <a href="#contact-form" class="inline-block px-8 py-3 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition">Contact Us Now</a>
            </div>
        </div>
    </section>
</div>
