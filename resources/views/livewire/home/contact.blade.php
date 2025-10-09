<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title, Validate};
use App\Models\ContactMessage;
use App\Mail\ContactFormSubmitted;
use Illuminate\Support\Facades\Mail;

new
#[Layout('components.layouts.home')]
#[Title('Contact Us')]
class extends Component {
    #[Validate('required|string|max:191')]
    public $first_name = '';

    #[Validate('required|string|max:191')]
    public $last_name = '';

    #[Validate('required|email|max:191')]
    public $email = '';

    #[Validate('nullable|string|max:191')]
    public $phone = '';

    #[Validate('required|string')]
    public $country = '';

    #[Validate('required|string')]
    public $interest = '';

    #[Validate('required|string|min:10')]
    public $message = '';

    #[Validate('accepted')]
    public $consent = false;

    public $submitted = false;

    public function submit()
    {
        $this->validate();

        try {
            // Create contact message
            $contactMessage = ContactMessage::create([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'phone' => $this->phone,
                'country' => $this->country,
                'interest' => $this->interest,
                'message' => $this->message,
                'consent' => $this->consent,
            ]);

            // Try to send email to admin
            try {
                $adminEmail = config('mail.admin_email');
                if ($adminEmail) {
                    Mail::to($adminEmail)->send(new ContactFormSubmitted($contactMessage));
                }
            } catch (\Exception $mailException) {
                // Log mail error but don't fail the submission
                \Log::error('Contact form email error: ' . $mailException->getMessage());
            }

            $this->submitted = true;
            $this->reset(['first_name', 'last_name', 'email', 'phone', 'country', 'interest', 'message', 'consent']);

            session()->flash('success', 'Thank you for contacting us! We will get back to you soon.');

        } catch (\Exception $e) {
            \Log::error('Contact form submission error: ' . $e->getMessage());
            session()->flash('error', 'There was an error sending your message. Please try again.');
        }
    }
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
                    @if($submitted)
                        <div class="text-center py-8">
                            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Message Sent Successfully!</h3>
                            <p class="text-gray-600 mb-6">Thank you for contacting us. We'll get back to you as soon as possible.</p>
                            <button wire:click="$set('submitted', false)" class="px-6 py-3 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition">
                                Send Another Message
                            </button>
                        </div>
                    @else
                        <h2 class="text-3xl font-bold mb-6">Send Us a Message</h2>

                        @if (session('error'))
                            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form wire:submit="submit" class="space-y-6">
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">First Name *</label>
                                    <input type="text" wire:model.blur="first_name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('first_name') border-red-500 @enderror">
                                    @error('first_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Last Name *</label>
                                    <input type="text" wire:model.blur="last_name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('last_name') border-red-500 @enderror">
                                    @error('last_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                                <input type="email" wire:model.blur="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('email') border-red-500 @enderror">
                                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                <input type="tel" wire:model.blur="phone" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('phone') border-red-500 @enderror">
                                @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Country *</label>
                                <select wire:model.blur="country" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('country') border-red-500 @enderror">
                                    <option value="">Select your country</option>
                                    <option value="United Kingdom">United Kingdom</option>
                                    <option value="United States">United States</option>
                                    <option value="Canada">Canada</option>
                                    <option value="Australia">Australia</option>
                                    <option value="India">India</option>
                                    <option value="Nigeria">Nigeria</option>
                                    <option value="United Arab Emirates">United Arab Emirates</option>
                                    <option value="Singapore">Singapore</option>
                                    <option value="Other">Other</option>
                                </select>
                                @error('country') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">I'm Interested In *</label>
                                <select wire:model.blur="interest" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('interest') border-red-500 @enderror">
                                    <option value="">Select an option</option>
                                    <option value="Undergraduate Programs">Undergraduate Programs</option>
                                    <option value="Postgraduate Programs">Postgraduate Programs</option>
                                    <option value="Pathway Courses">Pathway Courses</option>
                                    <option value="Free Consultation">Free Consultation</option>
                                    <option value="Visa Assistance">Visa Assistance</option>
                                    <option value="Other Services">Other Services</option>
                                </select>
                                @error('interest') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Your Message *</label>
                                <textarea wire:model.blur="message" rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('message') border-red-500 @enderror"></textarea>
                                @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex items-start">
                                <input type="checkbox" wire:model="consent" class="mt-1 mr-3">
                                <label class="text-sm text-gray-600">
                                    I agree to receive information about courses and services from Divjules. We respect your privacy and will never share your details with third parties. *
                                </label>
                            </div>
                            @error('consent') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                            <button type="submit" wire:loading.attr="disabled" class="w-full px-8 py-4 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition disabled:opacity-50">
                                <span wire:loading.remove wire:target="submit">Send Message</span>
                                <span wire:loading wire:target="submit">Sending...</span>
                            </button>
                        </form>
                    @endif
                </div>

                <!-- Contact Information -->
                <div>
                    <div class="bg-white p-8 rounded-xl shadow-lg mb-8">
                        <h2 class="text-3xl font-bold mb-6">Contact Information</h2>

                        <div class="space-y-6">
                            @foreach($contactDetails as $contact)
                                <div class="flex items-start">
                                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                        <i class="fas {{ str_replace('heroicon-o-', 'fa-', $contact->icon ?? 'fa-circle') }} text-purple-600"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold mb-1">{{ $contact->label }}</h3>
                                        @if($contact->is_clickable)
                                            <a href="{{ $contact->link }}" class="text-gray-600 hover:text-purple-600 transition-colors">
                                                {{ $contact->value }}
                                            </a>
                                        @else
                                            <p class="text-gray-600">{!! $contact->formatted_value !!}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
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
