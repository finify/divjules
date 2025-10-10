<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title, Validate};
use Livewire\WithFileUploads;
use App\Models\{Application, University, Course, ApplicationStage};

new
#[Layout('components.layouts.home')]
#[Title('Apply Now - Study Abroad')]
class extends Component {
    use WithFileUploads;

    // Step management
    public $currentStep = 1;
    public $totalSteps = 4;

    // Personal Information
    #[Validate('required|string|max:191')]
    public $first_name = '';

    #[Validate('required|string|max:191')]
    public $last_name = '';

    #[Validate('required|email|max:191')]
    public $email = '';

    #[Validate('required|string|max:191')]
    public $phone = '';

    #[Validate('required|date|before:today')]
    public $date_of_birth = '';

    #[Validate('required|string|max:191')]
    public $nationality = '';

    // Address Information
    #[Validate('required|string')]
    public $address = '';

    #[Validate('required|string|max:191')]
    public $city = '';

    #[Validate('nullable|string|max:191')]
    public $state = '';

    #[Validate('required|string|max:191')]
    public $country = '';

    #[Validate('required|string|max:20')]
    public $postal_code = '';

    // Education Information
    #[Validate('nullable|string|max:191')]
    public $previous_education = '';

    // Course Selection
    #[Validate('required|exists:universities,id')]
    public $university_id = '';

    #[Validate('required|exists:courses,id')]
    public $course_id = '';

    // English Proficiency
    #[Validate('nullable|string|max:191')]
    public $english_proficiency = '';

    // File uploads
    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:2048')]
    public $passport;

    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:2048')]
    public $transcript;

    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:2048')]
    public $english_test;

    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:2048')]
    public $cv;

    // Custom documents
    public $customDocuments = [];
    public $newDocumentName = '';
    public $newDocumentFile = null;

    // Submission
    public $submitted = false;
    public $applicationNumber = '';

    public function mount()
    {
        $this->loadFromCache();
    }

    public function with(): array
    {
        return [
            'universities' => University::orderBy('name')->get(),
            'courses' => $this->university_id
                ? Course::where('university_id', $this->university_id)->orderBy('name')->get()
                : collect(),
        ];
    }

    public function updatedUniversityId()
    {
        $this->course_id = '';
        $this->saveToCache();
    }

    public function updated($property)
    {
        // Auto-save to cache on any change (debounced on frontend)
        if (!$this->submitted) {
            $this->saveToCache();
        }
    }

    private function saveToCache()
    {
        $data = [
            'currentStep' => $this->currentStep,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'date_of_birth' => $this->date_of_birth,
            'nationality' => $this->nationality,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
            'postal_code' => $this->postal_code,
            'previous_education' => $this->previous_education,
            'university_id' => $this->university_id,
            'course_id' => $this->course_id,
            'english_proficiency' => $this->english_proficiency,
        ];

        $this->dispatch('cache-form-data', data: $data);
    }

    private function loadFromCache()
    {
        // This will be handled by JavaScript on the frontend
        $this->dispatch('load-cached-data');
    }

    public function restoreFromCache($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key) && $key !== 'submitted' && $key !== 'applicationNumber') {
                $this->$key = $value;
            }
        }
    }

    public function nextStep()
    {
        $this->validateCurrentStep();

        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
            $this->saveToCache();
            $this->dispatch('step-changed', step: $this->currentStep);
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
            $this->saveToCache();
            $this->dispatch('step-changed', step: $this->currentStep);
        }
    }

    public function goToStep($step)
    {
        if ($step >= 1 && $step <= $this->totalSteps) {
            $this->currentStep = $step;
            $this->saveToCache();
            $this->dispatch('step-changed', step: $this->currentStep);
        }
    }

    private function validateCurrentStep()
    {
        $rules = match($this->currentStep) {
            1 => [
                'first_name' => 'required|string|max:191',
                'last_name' => 'required|string|max:191',
                'email' => 'required|email|max:191',
                'phone' => 'required|string|max:191',
                'date_of_birth' => 'required|date|before:today',
                'nationality' => 'required|string|max:191',
            ],
            2 => [
                'address' => 'required|string',
                'city' => 'required|string|max:191',
                'country' => 'required|string|max:191',
                'postal_code' => 'required|string|max:20',
            ],
            3 => [
                'university_id' => 'required|exists:universities,id',
                'course_id' => 'required|exists:courses,id',
            ],
            default => [],
        };

        $this->validate($rules);
    }

    public function submit()
    {
        // Validate all steps
        $this->validate();

        try {
            // Get the first active stage
            $initialStage = ApplicationStage::active()->ordered()->first();

            // Create application
            $application = Application::create([
                'application_stage_id' => $initialStage?->id,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'phone' => $this->phone,
                'date_of_birth' => $this->date_of_birth,
                'nationality' => $this->nationality,
                'address' => $this->address,
                'city' => $this->city,
                'state' => $this->state,
                'country' => $this->country,
                'postal_code' => $this->postal_code,
                'university_id' => $this->university_id,
                'course_id' => $this->course_id,
                'previous_education' => $this->previous_education,
                'english_proficiency' => $this->english_proficiency,
                'status' => 'submitted',
                'submitted_at' => now(),
            ]);

            // Upload documents
            $this->uploadDocuments($application);

            // Set submission success
            $this->submitted = true;
            $this->applicationNumber = $application->application_number;

            // Clear cache
            $this->dispatch('clear-form-cache');

            session()->flash('success', 'Application submitted successfully!');

        } catch (\Exception $e) {
            \Log::error('Application submission error: ' . $e->getMessage());
            session()->flash('error', 'There was an error submitting your application. Please try again.');
        }
    }

    public function addCustomDocument()
    {
        $this->validate([
            'newDocumentName' => 'required|string|max:191',
            'newDocumentFile' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $this->customDocuments[] = [
            'name' => $this->newDocumentName,
            'file' => $this->newDocumentFile,
            'temp_name' => $this->newDocumentFile->getClientOriginalName(),
        ];

        $this->newDocumentName = '';
        $this->newDocumentFile = null;
    }

    public function removeCustomDocument($index)
    {
        unset($this->customDocuments[$index]);
        $this->customDocuments = array_values($this->customDocuments);
    }

    private function uploadDocuments($application)
    {
        $documents = [
            'passport' => 'Passport',
            'transcript' => 'Academic Transcript',
            'english_test' => 'English Test Results',
            'cv' => 'Curriculum Vitae',
        ];

        foreach ($documents as $field => $label) {
            if ($this->$field) {
                $path = $this->$field->store('applications/' . $application->id, 'public');

                $application->documents()->create([
                    'document_type' => $label,
                    'file_name' => $this->$field->getClientOriginalName(),
                    'file_path' => $path,
                    'file_size' => $this->$field->getSize(),
                    'mime_type' => $this->$field->getMimeType(),
                ]);
            }
        }

        // Upload custom documents
        foreach ($this->customDocuments as $customDoc) {
            if (isset($customDoc['file'])) {
                $path = $customDoc['file']->store('applications/' . $application->id, 'public');

                $application->documents()->create([
                    'document_type' => $customDoc['name'],
                    'file_name' => $customDoc['file']->getClientOriginalName(),
                    'file_path' => $path,
                    'file_size' => $customDoc['file']->getSize(),
                    'mime_type' => $customDoc['file']->getMimeType(),
                ]);
            }
        }
    }
}; ?>

<div>
    @if($submitted)
        <!-- Success Message -->
        <section class="min-h-screen flex items-center justify-center px-4 bg-gradient-to-br from-purple-50 to-indigo-50">
            <div class="max-w-2xl w-full bg-white rounded-2xl shadow-2xl p-12 text-center">
                <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Application Submitted!</h1>
                <p class="text-xl text-gray-600 mb-8">Your application has been successfully submitted.</p>

                <div class="bg-purple-50 border-2 border-purple-200 rounded-xl p-6 mb-8">
                    <p class="text-sm text-gray-600 mb-2">Your Application Number</p>
                    <p class="text-3xl font-bold text-purple-600 tracking-wider">{{ $applicationNumber }}</p>
                    <p class="text-sm text-gray-500 mt-2">Please save this number for tracking your application</p>
                </div>

                <div class="space-y-4">
                    <a href="{{ route('application.track') }}"
                       class="block w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-4 px-6 rounded-lg transition-colors">
                        Track Your Application
                    </a>
                    <a href="{{ route('home.index') }}"
                       class="block w-full border-2 border-gray-300 hover:border-gray-400 text-gray-700 font-bold py-4 px-6 rounded-lg transition-colors">
                        Return to Homepage
                    </a>
                </div>
            </div>
        </section>
    @else
        <!-- Hero Section -->
        <section class="bg-gradient-to-r from-purple-600 to-indigo-600 pt-32 pb-16 px-4 mt-20">
            <div class="max-w-7xl mx-auto text-center text-white">
                <h1 class="text-5xl font-bold mb-4">Start Your Application</h1>
                <p class="text-xl">Complete your application in {{ $totalSteps }} simple steps</p>
            </div>
        </section>

        <!-- Progress Steps -->
        <section class="py-8 px-4 bg-white shadow-md sticky top-20 z-40">
            <div class="max-w-5xl mx-auto">
                <div class="flex items-center justify-between">
                    @for($i = 1; $i <= $totalSteps; $i++)
                        @if($i > 1)
                            <div class="h-1 flex-1 mx-2 {{ $currentStep >= $i ? 'bg-purple-600' : 'bg-gray-300' }}"></div>
                        @endif
                        <div class="flex items-center flex-1 cursor-pointer" wire:click="goToStep({{ $i }})">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center font-bold text-lg transition-colors {{ $currentStep >= $i ? 'bg-purple-600 text-white' : 'bg-gray-300 text-gray-600' }}">
                                {{ $i }}
                            </div>
                            <div class="ml-3 hidden sm:block">
                                <p class="font-bold text-sm">
                                    @if($i === 1) Personal Info
                                    @elseif($i === 2) Address
                                    @elseif($i === 3) Course Selection
                                    @elseif($i === 4) Documents
                                    @endif
                                </p>
                                <p class="text-xs text-gray-500">
                                    @if($i === 1) Basic details
                                    @elseif($i === 2) Contact info
                                    @elseif($i === 3) Choose your course
                                    @elseif($i === 4) Upload files
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </section>

        <!-- Application Form -->
        <section class="py-16 px-4 bg-gray-50">
            <div class="max-w-4xl mx-auto">
                <form wire:submit="submit">
                    <!-- Step 1: Personal Information -->
                    <div class="bg-white p-8 rounded-xl shadow-lg {{ $currentStep === 1 ? '' : 'hidden' }}">
                        <h2 class="text-3xl font-bold mb-2">Personal Information</h2>
                        <p class="text-gray-600 mb-8">Let's start with your basic details</p>

                        <div class="space-y-6">
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

                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                    <input type="email" wire:model.blur="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('email') border-red-500 @enderror">
                                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone *</label>
                                    <input type="tel" wire:model.blur="phone" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('phone') border-red-500 @enderror">
                                    @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth *</label>
                                    <input type="date" wire:model.blur="date_of_birth" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('date_of_birth') border-red-500 @enderror">
                                    @error('date_of_birth') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nationality *</label>
                                    <input type="text" wire:model.blur="nationality" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('nationality') border-red-500 @enderror">
                                    @error('nationality') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end">
                            <button type="button" wire:click="nextStep" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-8 rounded-lg transition-colors">
                                Next Step →
                            </button>
                        </div>
                    </div>

                    <!-- Step 2: Address Information -->
                    <div class="bg-white p-8 rounded-xl shadow-lg {{ $currentStep === 2 ? '' : 'hidden' }}">
                        <h2 class="text-3xl font-bold mb-2">Address Information</h2>
                        <p class="text-gray-600 mb-8">Where can we reach you?</p>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Address *</label>
                                <textarea wire:model.blur="address" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('address') border-red-500 @enderror"></textarea>
                                @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">City *</label>
                                    <input type="text" wire:model.blur="city" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('city') border-red-500 @enderror">
                                    @error('city') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">State/Province</label>
                                    <input type="text" wire:model.blur="state" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('state') border-red-500 @enderror">
                                    @error('state') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Country *</label>
                                    <input type="text" wire:model.blur="country" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('country') border-red-500 @enderror">
                                    @error('country') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Postal Code *</label>
                                    <input type="text" wire:model.blur="postal_code" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('postal_code') border-red-500 @enderror">
                                    @error('postal_code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-between">
                            <button type="button" wire:click="previousStep" class="border-2 border-gray-300 hover:border-gray-400 text-gray-700 font-bold py-3 px-8 rounded-lg transition-colors">
                                ← Previous
                            </button>
                            <button type="button" wire:click="nextStep" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-8 rounded-lg transition-colors">
                                Next Step →
                            </button>
                        </div>
                    </div>

                    <!-- Step 3: Course Selection -->
                    <div class="bg-white p-8 rounded-xl shadow-lg {{ $currentStep === 3 ? '' : 'hidden' }}">
                        <h2 class="text-3xl font-bold mb-2">Course Selection</h2>
                        <p class="text-gray-600 mb-8">Choose your preferred university and course</p>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">University *</label>
                                <select wire:model.live="university_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('university_id') border-red-500 @enderror">
                                    <option value="">Select a university</option>
                                    @foreach($universities as $university)
                                        <option value="{{ $university->id }}">{{ $university->name }}</option>
                                    @endforeach
                                </select>
                                @error('university_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Course *</label>
                                <select wire:model.blur="course_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('course_id') border-red-500 @enderror" {{ !$university_id ? 'disabled' : '' }}>
                                    <option value="">{{ $university_id ? 'Select a course' : 'Please select a university first' }}</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                                    @endforeach
                                </select>
                                @error('course_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Previous Education (Optional)</label>
                                <textarea wire:model.blur="previous_education" rows="3" placeholder="Tell us about your previous education..." class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">English Proficiency (Optional)</label>
                                <input type="text" wire:model.blur="english_proficiency" placeholder="e.g., IELTS 7.0, TOEFL 100" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                            </div>
                        </div>

                        <div class="mt-8 flex justify-between">
                            <button type="button" wire:click="previousStep" class="border-2 border-gray-300 hover:border-gray-400 text-gray-700 font-bold py-3 px-8 rounded-lg transition-colors">
                                ← Previous
                            </button>
                            <button type="button" wire:click="nextStep" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-8 rounded-lg transition-colors">
                                Next Step →
                            </button>
                        </div>
                    </div>

                    <!-- Step 4: Documents -->
                    <div class="bg-white p-8 rounded-xl shadow-lg {{ $currentStep === 4 ? '' : 'hidden' }}">
                        <h2 class="text-3xl font-bold mb-2">Upload Documents</h2>
                        <p class="text-gray-600 mb-8">Upload your supporting documents (PDF, JPG, PNG - Max 2MB each)</p>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Passport Copy (Optional)</label>
                                <input type="file" wire:model="passport" accept=".pdf,.jpg,.jpeg,.png" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                                @error('passport') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                <div wire:loading wire:target="passport" class="text-sm text-blue-600 mt-1">Uploading...</div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Academic Transcript (Optional)</label>
                                <input type="file" wire:model="transcript" accept=".pdf,.jpg,.jpeg,.png" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                                @error('transcript') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                <div wire:loading wire:target="transcript" class="text-sm text-blue-600 mt-1">Uploading...</div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">English Test Results (Optional)</label>
                                <input type="file" wire:model="english_test" accept=".pdf,.jpg,.jpeg,.png" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                                @error('english_test') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                <div wire:loading wire:target="english_test" class="text-sm text-blue-600 mt-1">Uploading...</div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">CV/Resume (Optional)</label>
                                <input type="file" wire:model="cv" accept=".pdf,.jpg,.jpeg,.png" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                                @error('cv') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                <div wire:loading wire:target="cv" class="text-sm text-blue-600 mt-1">Uploading...</div>
                            </div>

                            <!-- Custom Documents Section -->
                            <div class="mt-8 pt-8 border-t border-gray-200">
                                <h3 class="text-xl font-bold text-gray-900 mb-4">Additional Documents</h3>
                                <p class="text-sm text-gray-600 mb-6">Add any other documents that support your application</p>

                                <!-- List of custom documents -->
                                @if(count($customDocuments) > 0)
                                    <div class="space-y-3 mb-6">
                                        @foreach($customDocuments as $index => $doc)
                                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                                                <div class="flex items-center space-x-3">
                                                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                    </svg>
                                                    <div>
                                                        <p class="font-semibold text-gray-900">{{ $doc['name'] }}</p>
                                                        <p class="text-sm text-gray-500">{{ $doc['temp_name'] }}</p>
                                                    </div>
                                                </div>
                                                <button type="button" wire:click="removeCustomDocument({{ $index }})" class="text-red-600 hover:text-red-800 font-medium">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- Add new document form -->
                                <div class="bg-purple-50 border border-purple-200 rounded-lg p-6">
                                    <div class="grid md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Document Name</label>
                                            <input type="text" wire:model="newDocumentName" placeholder="e.g., Recommendation Letter" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('newDocumentName') border-red-500 @enderror">
                                            @error('newDocumentName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Choose File</label>
                                            <input type="file" wire:model="newDocumentFile" accept=".pdf,.jpg,.jpeg,.png" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('newDocumentFile') border-red-500 @enderror">
                                            @error('newDocumentFile') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            <div wire:loading wire:target="newDocumentFile" class="text-sm text-blue-600 mt-1">Uploading...</div>
                                        </div>
                                    </div>
                                    <button type="button" wire:click="addCustomDocument" wire:loading.attr="disabled" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors disabled:opacity-50">
                                        <span wire:loading.remove wire:target="addCustomDocument">+ Add Document</span>
                                        <span wire:loading wire:target="addCustomDocument">Adding...</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-between">
                            <button type="button" wire:click="previousStep" class="border-2 border-gray-300 hover:border-gray-400 text-gray-700 font-bold py-3 px-8 rounded-lg transition-colors">
                                ← Previous
                            </button>
                            <button type="submit" wire:loading.attr="disabled" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg transition-colors disabled:opacity-50">
                                <span wire:loading.remove wire:target="submit">Submit Application</span>
                                <span wire:loading wire:target="submit">Submitting...</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    @endif
</div>

@script
<script>
    const CACHE_KEY = 'application_form_data';

    // Load cached data on page load
    Livewire.on('load-cached-data', () => {
        const cached = localStorage.getItem(CACHE_KEY);
        if (cached) {
            try {
                const data = JSON.parse(cached);
                $wire.restoreFromCache(data);
            } catch (e) {
                console.error('Error loading cached data:', e);
            }
        }
    });

    // Save data to cache
    Livewire.on('cache-form-data', (event) => {
        localStorage.setItem(CACHE_KEY, JSON.stringify(event.data));
    });

    // Clear cache
    Livewire.on('clear-form-cache', () => {
        localStorage.removeItem(CACHE_KEY);
    });

    // Smooth scroll on step change
    Livewire.on('step-changed', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
</script>
@endscript
