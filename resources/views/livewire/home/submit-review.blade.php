<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title, Validate};
use Livewire\WithFileUploads;
use App\Models\Testimonial;

new
#[Layout('components.layouts.home')]
#[Title('Submit Your Review')]
class extends Component {
    use WithFileUploads;

    #[Validate('required|string|max:191')]
    public $student_name = '';

    #[Validate('required|email|max:191')]
    public $email = '';

    #[Validate('required|string|max:191')]
    public $university = '';

    #[Validate('nullable|string|max:191')]
    public $course = '';

    #[Validate('required|integer|min:1|max:5')]
    public $rating = 5;

    #[Validate('required|string|min:50')]
    public $review = '';

    #[Validate('nullable|image|max:5120')]
    public $photo;

    public $submitted = false;

    public function submit()
    {
        $this->validate();

        try {
            $data = [
                'student_name' => $this->student_name,
                'email' => $this->email,
                'university' => $this->university,
                'course' => $this->course,
                'rating' => $this->rating,
                'review' => $this->review,
                'status' => 'pending',
            ];

            // Handle photo upload
            if ($this->photo) {
                $data['photo'] = $this->photo->store('testimonials', 'public');
            }

            Testimonial::create($data);

            $this->submitted = true;

            session()->flash('success', 'Thank you for your review! It will be published after approval.');

        } catch (\Exception $e) {
            \Log::error('Testimonial submission error: ' . $e->getMessage());
            session()->flash('error', 'There was an error submitting your review. Please try again.');
        }
    }

    public function submitAnother()
    {
        $this->reset();
        $this->submitted = false;
    }
}; ?>

<div>
    @if($submitted)
        <!-- Success Message -->
        <section class="min-h-screen flex items-center justify-center px-4 bg-gradient-to-br from-purple-50 to-indigo-50 py-32">
            <div class="max-w-2xl w-full bg-white rounded-2xl shadow-2xl p-12 text-center">
                <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Thank You!</h1>
                <p class="text-xl text-gray-600 mb-8">Your review has been submitted successfully.</p>

                <div class="bg-purple-50 border-2 border-purple-200 rounded-xl p-6 mb-8">
                    <p class="text-gray-700 mb-2">Your review is pending approval and will be published on our website soon.</p>
                    <p class="text-sm text-gray-500">We appreciate you taking the time to share your experience!</p>
                </div>

                <div class="space-y-4">
                    <button wire:click="submitAnother"
                       class="block w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-4 px-6 rounded-lg transition-colors">
                        Submit Another Review
                    </button>
                    <a href="{{ route('home.index') }}"
                       class="block w-full border-2 border-gray-300 hover:border-gray-400 text-gray-700 font-bold py-4 px-6 rounded-lg transition-colors">
                        Return to Homepage
                    </a>
                </div>
            </div>
        </section>
    @else
        <!-- Review Form -->
        <section class="bg-gradient-to-r from-purple-600 to-indigo-600 pt-32 pb-16 px-4 mt-20">
            <div class="max-w-7xl mx-auto text-center text-white">
                <h1 class="text-5xl font-bold mb-4">Share Your Experience</h1>
                <p class="text-xl">Help future students by sharing your journey with Divjules</p>
            </div>
        </section>

        <section class="py-16 px-4 bg-gray-50">
            <div class="max-w-3xl mx-auto">
                <div class="bg-white p-8 md:p-12 rounded-xl shadow-lg">
                    <form wire:submit="submit">
                        <!-- Personal Information -->
                        <div class="mb-8">
                            <h2 class="text-2xl font-bold mb-6 text-gray-800">Personal Information</h2>

                            <div class="grid md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Your Name *</label>
                                    <input type="text" wire:model="student_name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('student_name') border-red-500 @enderror" placeholder="John Doe">
                                    @error('student_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                                    <input type="email" wire:model="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('email') border-red-500 @enderror" placeholder="john@example.com">
                                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">University/College *</label>
                                    <input type="text" wire:model="university" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('university') border-red-500 @enderror" placeholder="University of London">
                                    @error('university') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Course/Program (Optional)</label>
                                    <input type="text" wire:model="course" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('course') border-red-500 @enderror" placeholder="MSc Computer Science">
                                    @error('course') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Review Details -->
                        <div class="mb-8">
                            <h2 class="text-2xl font-bold mb-6 text-gray-800">Your Review</h2>

                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Rating *</label>
                                <div class="flex gap-2" id="starRating" x-data="{ rating: @entangle('rating') }">
                                    @for($i = 1; $i <= 5; $i++)
                                    <button type="button" @click="rating = {{ $i }}" class="focus:outline-none">
                                        <i class="fas fa-star text-4xl transition-colors"
                                           :class="rating >= {{ $i }} ? 'text-yellow-500' : 'text-gray-300'"
                                           @mouseenter="$el.classList.add('text-yellow-400')"
                                           @mouseleave="rating < {{ $i }} && $el.classList.remove('text-yellow-400')"
                                        ></i>
                                    </button>
                                    @endfor
                                </div>
                                @error('rating') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Your Review * (Minimum 50 characters)</label>
                                <textarea wire:model="review" rows="6" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('review') border-red-500 @enderror" placeholder="Share your experience with Divjules..."></textarea>
                                <p class="text-xs text-gray-500 mt-1">{{ strlen($review) }} characters</p>
                                @error('review') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Your Photo (Optional)</label>
                                <input type="file" wire:model="photo" accept="image/*" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('photo') border-red-500 @enderror">
                                <p class="text-xs text-gray-500 mt-1">Upload a professional photo (max 5MB)</p>
                                @error('photo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                <div wire:loading wire:target="photo" class="text-sm text-blue-600 mt-1">Uploading...</div>

                                @if ($photo)
                                    <div class="mt-4">
                                        <p class="text-sm text-gray-600 mb-2">Preview:</p>
                                        <img src="{{ $photo->temporaryUrl() }}" class="w-32 h-32 rounded-full object-cover border-4 border-purple-200">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex gap-4">
                            <button type="submit" wire:loading.attr="disabled" class="flex-1 px-6 py-4 bg-purple-600 text-white rounded-lg font-bold text-lg hover:bg-purple-700 transition shadow-lg disabled:opacity-50">
                                <span wire:loading.remove wire:target="submit">
                                    <i class="fas fa-paper-plane mr-2"></i>Submit Review
                                </span>
                                <span wire:loading wire:target="submit">
                                    <i class="fas fa-spinner fa-spin mr-2"></i>Submitting...
                                </span>
                            </button>
                        </div>

                        <p class="text-xs text-gray-500 mt-4 text-center">
                            Your review will be published after approval by our team.
                        </p>
                    </form>
                </div>

                <!-- FAQ Section -->
                <div class="mt-12 bg-white p-8 rounded-xl shadow-lg">
                    <h3 class="text-xl font-bold mb-4 text-gray-800">Why share your review?</h3>
                    <ul class="space-y-3 text-gray-600">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <span>Help future students make informed decisions</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <span>Share your success story and inspire others</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <span>Provide valuable feedback to improve our services</span>
                        </li>
                    </ul>
                </div>
            </div>
        </section>
    @endif
</div>
