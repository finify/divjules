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
    <section style="--hero-img: url('/homeassets/img/site/cap-toss.webp')" class="page-hero pt-40 md:pt-48 pb-28 md:pb-36 px-4">
        <div class="max-w-3xl mx-auto text-center text-white">
            <span class="eyebrow !text-sky-300 justify-center">Share your story</span>
            <h1 class="mt-5">How was your journey?</h1>
            <p class="mt-5 text-xl">Your review helps the next student take the leap. It takes about two minutes.</p>
        </div>
    </section>

    <section class="relative z-20 -mt-16 px-4 pb-24" data-no-auto>
        <div class="max-w-3xl mx-auto card !p-7 md:!p-12" style="box-shadow: var(--shadow-lg)">
            @if ($submitted)
                <div class="text-center py-8 card-in">
                    <span class="grid place-items-center w-20 h-20 mx-auto rounded-full bg-emerald-500/15 text-emerald-500 text-3xl"><i class="fas fa-heart"></i></span>
                    <h2 class="mt-6 text-3xl font-semibold tracking-tight text-ink">Thank you!</h2>
                    <p class="mt-3 text-muted max-w-md mx-auto">Your review has been received and will be published once our team has approved it.</p>
                    <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
                        <a href="{{ route('home.reviews') }}" class="btn btn-ghost">Read other reviews</a>
                        <button type="button" wire:click="submitAnother" class="btn btn-primary">Submit another review</button>
                    </div>
                </div>
            @else
                @if (session('error'))
                    <div class="mb-6 p-4 rounded-2xl bg-red-500/10 text-red-600 dark:text-red-300 border border-red-500/20">{{ session('error') }}</div>
                @endif

                <form wire:submit="submit" class="space-y-8" novalidate>
                    <fieldset>
                        <legend class="text-xl font-semibold text-ink">Your rating</legend>
                        <div class="mt-4 flex items-center gap-2" role="radiogroup" aria-label="Rating">
                            @for ($i = 1; $i <= 5; $i++)
                                <button type="button" wire:click="$set('rating', {{ $i }})" class="star-pick {{ $i <= $rating ? 'is-on' : '' }}" role="radio" aria-checked="{{ (int) $rating === $i ? 'true' : 'false' }}" aria-label="{{ $i }} {{ Str::plural('star', $i) }}"><i class="fas fa-star"></i></button>
                            @endfor
                            <span class="ml-3 text-sm text-muted">{{ ['', 'Poor', 'Fair', 'Good', 'Very good', 'Excellent'][(int) $rating] ?? '' }}</span>
                        </div>
                        @error('rating') <p class="field-error">{{ $message }}</p> @enderror
                    </fieldset>

                    <fieldset class="grid sm:grid-cols-2 gap-5">
                        <legend class="text-xl font-semibold text-ink mb-4 sm:col-span-2">About you</legend>
                        <div>
                            <label for="r-name" class="field-label">Your name *</label>
                            <input id="r-name" type="text" wire:model.blur="student_name" placeholder="e.g. Ada Okafor" class="field @error('student_name') is-invalid @enderror">
                            @error('student_name') <p class="field-error">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="r-email" class="field-label">Email * <span class="text-muted font-normal">(not published)</span></label>
                            <input id="r-email" type="email" wire:model.blur="email" placeholder="you@example.com" class="field @error('email') is-invalid @enderror">
                            @error('email') <p class="field-error">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="r-uni" class="field-label">University / college *</label>
                            <input id="r-uni" type="text" wire:model.blur="university" placeholder="e.g. University of Leeds" class="field @error('university') is-invalid @enderror">
                            @error('university') <p class="field-error">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="r-course" class="field-label">Course <span class="text-muted font-normal">(optional)</span></label>
                            <input id="r-course" type="text" wire:model.blur="course" placeholder="e.g. MSc Data Science" class="field @error('course') is-invalid @enderror">
                            @error('course') <p class="field-error">{{ $message }}</p> @enderror
                        </div>
                    </fieldset>

                    <div>
                        <label for="r-review" class="text-xl font-semibold text-ink">Your review *</label>
                        <p class="text-sm text-muted mt-1 mb-4">What did we help with, and how did it go? At least 50 characters.</p>
                        <textarea id="r-review" wire:model.live.debounce.400ms="review" rows="6" placeholder="Share your experience with Divjules..." class="field @error('review') is-invalid @enderror"></textarea>
                        <div class="mt-1.5 flex justify-between text-xs">
                            @error('review') <p class="field-error !mt-0">{{ $message }}</p> @else <span></span> @enderror
                            <span class="{{ strlen($review) >= 50 ? 'text-emerald-500' : 'text-muted' }} tabular-nums">{{ strlen($review) }}/50</span>
                        </div>
                    </div>

                    <div>
                        <span class="field-label">Photo <span class="text-muted font-normal">(optional)</span></span>
                        <label class="dropzone {{ $photo ? 'is-done' : '' }}">
                            @if ($photo && method_exists($photo, 'temporaryUrl'))
                                <img src="{{ $photo->temporaryUrl() }}" alt="" class="w-12 h-12 rounded-full object-cover">
                            @else
                                <span class="icon-tile shrink-0"><i class="fas fa-camera"></i></span>
                            @endif
                            <span class="min-w-0">
                                <span class="block font-medium text-ink">{{ $photo ? 'Photo added. Tap to change' : 'Add a photo of yourself' }}</span>
                                <span class="block text-xs text-muted">JPG or PNG, up to 5MB</span>
                            </span>
                            <span wire:loading wire:target="photo" class="ml-auto text-xs text-accent"><i class="fas fa-circle-notch fa-spin"></i></span>
                            <input type="file" wire:model="photo" accept="image/*">
                        </label>
                        @error('photo') <p class="field-error">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" wire:loading.attr="disabled" class="btn btn-primary w-full !py-4 disabled:opacity-60">
                        <span wire:loading.remove wire:target="submit">Submit review <i class="fas fa-paper-plane text-sm ml-1"></i></span>
                        <span wire:loading wire:target="submit"><i class="fas fa-circle-notch fa-spin mr-2"></i>Submitting…</span>
                    </button>
                    <p class="text-xs text-muted text-center">Reviews are checked by our team before they appear on the site.</p>
                </form>
            @endif
        </div>
    </section>
</div>
