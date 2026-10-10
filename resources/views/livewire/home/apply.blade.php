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

    // set when the visitor arrives from a course/university page (?course= / ?university=)
    public $preselected = false;

    public function mount()
    {
        if ($courseId = request()->query('course')) {
            $course = Course::active()->find($courseId);
            if ($course) {
                $this->university_id = (string) $course->university_id;
                $this->course_id = (string) $course->id;
                $this->preselected = true;
            }
        } elseif ($uniId = request()->query('university')) {
            if (University::active()->whereKey($uniId)->exists()) {
                $this->university_id = (string) $uniId;
                $this->preselected = true;
            }
        }
    }

    public function with(): array
    {
        return [
            'universities' => University::active()->orderBy('name')->get(['id', 'name', 'country']),
            'courses' => $this->university_id
                ? Course::active()->where('university_id', $this->university_id)->orderBy('name')->get()
                : collect(),
            'selectedUniversity' => $this->university_id ? University::find($this->university_id) : null,
            'selectedCourse' => $this->course_id ? Course::with('courseCategory')->find($this->course_id) : null,
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
            if ($this->preselected && in_array($key, ['university_id', 'course_id'])) {
                continue;
            }
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

@php
    $steps = [
        1 => ['Personal info', 'Basic details', 'fa-user'],
        2 => ['Address', 'Where you live', 'fa-house'],
        3 => ['Course', 'What you want to study', 'fa-graduation-cap'],
        4 => ['Documents', 'Upload & submit', 'fa-file-arrow-up'],
    ];
    $docs = [
        'passport' => ['Passport', 'Photo page of your international passport', 'fa-passport'],
        'transcript' => ['Academic transcript', 'Your latest results or certificates', 'fa-scroll'],
        'english_test' => ['English test results', 'IELTS, TOEFL, PTE or equivalent', 'fa-language'],
        'cv' => ['CV / résumé', 'Required for most postgraduate courses', 'fa-id-card'],
    ];
@endphp

<div>
    @if ($submitted)
        <section style="--hero-img: url('/homeassets/img/site/graduates-caps.webp')" class="page-hero min-h-[100dvh] flex items-center px-4 py-32">
            <div class="max-w-2xl w-full mx-auto">
                <div class="card !p-8 md:!p-12 text-center card-in" style="box-shadow: var(--shadow-lg)">
                    <span class="grid place-items-center w-20 h-20 mx-auto rounded-full bg-emerald-500/15 text-emerald-500 text-3xl"><i class="fas fa-check"></i></span>
                    <h2 class="mt-6 text-3xl md:text-4xl font-semibold tracking-tight text-ink">Application submitted</h2>
                    <p class="mt-3 text-muted">Thank you! A Divjules counsellor will review your application and contact you within 2 working days.</p>

                    <div class="mt-8 rounded-2xl bg-[var(--surface-2)] p-6">
                        <p class="text-xs font-mono uppercase tracking-wider text-muted">Your application number</p>
                        <div class="mt-2 flex items-center justify-center gap-3">
                            <span class="text-2xl md:text-3xl font-semibold tracking-tight text-accent" id="app-number">{{ $applicationNumber }}</span>
                            <button type="button" class="theme-toggle" aria-label="Copy application number" onclick="navigator.clipboard.writeText('{{ $applicationNumber }}'); this.innerHTML='<i class=\'fas fa-check\'></i>'"><i class="fas fa-copy"></i></button>
                        </div>
                        <p class="mt-2 text-sm text-muted">Save this number — you'll need it to track your application.</p>
                    </div>

                    <ol class="mt-8 text-left space-y-4">
                        @foreach ([['We review your documents', 'and check your eligibility for the course.'], ['We submit to the university', 'and keep you updated at each stage.'], ['Offer, visa & departure', 'we guide you all the way to campus.']] as $i => [$t, $d])
                            <li class="flex gap-4"><span class="grid place-items-center w-8 h-8 rounded-full bg-[var(--accent-soft)] text-accent text-sm font-semibold shrink-0">{{ $i + 1 }}</span><p class="text-muted"><span class="text-ink font-medium">{{ $t }}</span> {{ $d }}</p></li>
                        @endforeach
                    </ol>

                    <div class="mt-10 flex flex-col sm:flex-row gap-3 justify-center">
                        <a href="{{ route('application.track') }}" class="btn btn-primary"><i class="fas fa-magnifying-glass-location text-sm"></i> Track application</a>
                        <a href="{{ route('home.index') }}" class="btn btn-ghost">Back to home</a>
                    </div>
                </div>
            </div>
        </section>
    @else
        <section style="--hero-img: url('/homeassets/img/site/students-books.webp')" class="page-hero pt-36 md:pt-44 pb-28 md:pb-32 px-4">
            <div class="max-w-4xl mx-auto text-center text-white">
                <span class="eyebrow !text-sky-300 justify-center">Apply</span>
                <h1 class="mt-5">Start your application</h1>
                <p class="mt-5 text-xl">Four short steps — about 10 minutes. Your progress is saved on this device as you go.</p>
            </div>
        </section>

        <section id="apply-form" class="relative z-20 -mt-16 px-4 pb-24" data-no-auto>
            <div class="max-w-6xl mx-auto grid lg:grid-cols-12 gap-6 items-start">

                {{-- Stepper (desktop) --}}
                <aside class="hidden lg:block lg:col-span-4 lg:sticky lg:top-28 space-y-5">
                    <nav class="card !p-3" aria-label="Application steps">
                        <ol>
                            @foreach ($steps as $i => [$title, $sub, $icon])
                                @php $state = $i < $currentStep ? 'done' : ($i === $currentStep ? 'current' : 'todo'); @endphp
                                <li>
                                    <button type="button" wire:click="goToStep({{ $i }})" class="apply-step is-{{ $state }}" @if ($state === 'current') aria-current="step" @endif>
                                        <span class="apply-step-dot">@if ($state === 'done')<i class="fas fa-check"></i>@else<i class="fas {{ $icon }}"></i>@endif</span>
                                        <span class="text-left">
                                            <span class="block font-semibold">{{ $title }}</span>
                                            <span class="block text-xs opacity-70">{{ $sub }}</span>
                                        </span>
                                    </button>
                                </li>
                            @endforeach
                        </ol>
                    </nav>
                    <div class="card brand-band !bg-[#1a1a4e] !border-transparent text-white">
                        <p class="font-semibold">Need a hand?</p>
                        <p class="mt-1.5 text-sm text-white/70">Not sure which course to pick? A counsellor can help you decide first.</p>
                        <a href="{{ route('home.contact') }}" class="btn btn-light w-full mt-4 !py-2.5 text-sm">Talk to a counsellor</a>
                    </div>
                </aside>

                {{-- Form --}}
                <div class="lg:col-span-8 card !p-6 md:!p-10" style="box-shadow: var(--shadow-lg)">
                    {{-- mobile progress --}}
                    <div class="lg:hidden mb-8">
                        <div class="flex items-center justify-between text-sm">
                            <span class="font-semibold text-ink">{{ $steps[$currentStep][0] }}</span>
                            <span class="text-muted">Step {{ $currentStep }} of {{ $totalSteps }}</span>
                        </div>
                        <div class="mt-3 grid grid-cols-4 gap-1.5">
                            @foreach ($steps as $i => $s)
                                <button type="button" wire:click="goToStep({{ $i }})" class="h-1.5 rounded-full transition-colors {{ $i <= $currentStep ? 'bg-[var(--accent)]' : 'bg-[var(--line)]' }}" aria-label="Go to step {{ $i }}"></button>
                            @endforeach
                        </div>
                    </div>

                    @if (session('error'))
                        <div class="mb-6 p-4 rounded-2xl bg-red-500/10 text-red-600 dark:text-red-300 border border-red-500/20">{{ session('error') }}</div>
                    @endif

                    <form wire:submit="submit" novalidate>
                        <div wire:key="step-{{ $currentStep }}" class="step-panel">
                            <p class="hidden lg:block text-xs font-mono uppercase tracking-wider text-muted">Step {{ $currentStep }} of {{ $totalSteps }}</p>
                            <h2 class="text-2xl md:text-3xl font-semibold tracking-tight text-ink lg:mt-2">
                                {{ ['', 'Tell us about yourself', 'Where do you live?', 'What do you want to study?', 'Upload your documents'][$currentStep] }}
                            </h2>

                            @if ($currentStep === 1)
                                <div class="mt-8 grid sm:grid-cols-2 gap-5">
                                    <div><label for="a-first" class="field-label">First name *</label><input id="a-first" type="text" autocomplete="given-name" wire:model.blur="first_name" class="field @error('first_name') is-invalid @enderror">@error('first_name')<p class="field-error">{{ $message }}</p>@enderror</div>
                                    <div><label for="a-last" class="field-label">Last name *</label><input id="a-last" type="text" autocomplete="family-name" wire:model.blur="last_name" class="field @error('last_name') is-invalid @enderror">@error('last_name')<p class="field-error">{{ $message }}</p>@enderror</div>
                                    <div><label for="a-email" class="field-label">Email *</label><input id="a-email" type="email" autocomplete="email" wire:model.blur="email" class="field @error('email') is-invalid @enderror">@error('email')<p class="field-error">{{ $message }}</p>@enderror</div>
                                    <div><label for="a-phone" class="field-label">Phone / WhatsApp *</label><input id="a-phone" type="tel" autocomplete="tel" wire:model.blur="phone" class="field @error('phone') is-invalid @enderror">@error('phone')<p class="field-error">{{ $message }}</p>@enderror</div>
                                    <div><label for="a-dob" class="field-label">Date of birth *</label><input id="a-dob" type="date" autocomplete="bday" wire:model.blur="date_of_birth" class="field @error('date_of_birth') is-invalid @enderror">@error('date_of_birth')<p class="field-error">{{ $message }}</p>@enderror</div>
                                    <div><label for="a-nat" class="field-label">Nationality *</label><input id="a-nat" type="text" wire:model.blur="nationality" placeholder="e.g. Nigerian" class="field @error('nationality') is-invalid @enderror">@error('nationality')<p class="field-error">{{ $message }}</p>@enderror</div>
                                </div>
                            @elseif ($currentStep === 2)
                                <div class="mt-8 grid sm:grid-cols-2 gap-5">
                                    <div class="sm:col-span-2"><label for="a-addr" class="field-label">Street address *</label><textarea id="a-addr" rows="2" autocomplete="street-address" wire:model.blur="address" class="field @error('address') is-invalid @enderror"></textarea>@error('address')<p class="field-error">{{ $message }}</p>@enderror</div>
                                    <div><label for="a-city" class="field-label">City *</label><input id="a-city" type="text" autocomplete="address-level2" wire:model.blur="city" class="field @error('city') is-invalid @enderror">@error('city')<p class="field-error">{{ $message }}</p>@enderror</div>
                                    <div><label for="a-state" class="field-label">State / region</label><input id="a-state" type="text" autocomplete="address-level1" wire:model.blur="state" class="field @error('state') is-invalid @enderror">@error('state')<p class="field-error">{{ $message }}</p>@enderror</div>
                                    <div><label for="a-country" class="field-label">Country *</label><input id="a-country" type="text" autocomplete="country-name" wire:model.blur="country" class="field @error('country') is-invalid @enderror">@error('country')<p class="field-error">{{ $message }}</p>@enderror</div>
                                    <div><label for="a-post" class="field-label">Postal code *</label><input id="a-post" type="text" autocomplete="postal-code" wire:model.blur="postal_code" class="field @error('postal_code') is-invalid @enderror">@error('postal_code')<p class="field-error">{{ $message }}</p>@enderror</div>
                                </div>
                            @elseif ($currentStep === 3)
                                <div class="mt-8 space-y-5">
                                    <div class="grid sm:grid-cols-2 gap-5">
                                        <div>
                                            <label for="a-uni" class="field-label">University *</label>
                                            <select id="a-uni" wire:model.live="university_id" class="field @error('university_id') is-invalid @enderror">
                                                <option value="">Select a university</option>
                                                @foreach ($universities->groupBy('country') as $countryName => $group)
                                                    <optgroup label="{{ $countryName }}">
                                                        @foreach ($group as $university)<option value="{{ $university->id }}">{{ $university->name }}</option>@endforeach
                                                    </optgroup>
                                                @endforeach
                                            </select>
                                            @error('university_id')<p class="field-error">{{ $message }}</p>@enderror
                                        </div>
                                        <div>
                                            <label for="a-course" class="field-label">Course *</label>
                                            <select id="a-course" wire:model.live="course_id" class="field @error('course_id') is-invalid @enderror" @disabled(! $university_id)>
                                                <option value="">{{ $university_id ? 'Select a course' : 'Choose a university first' }}</option>
                                                @foreach ($courses as $course)<option value="{{ $course->id }}">{{ $course->name }}</option>@endforeach
                                            </select>
                                            @error('course_id')<p class="field-error">{{ $message }}</p>@enderror
                                        </div>
                                    </div>

                                    @if ($selectedUniversity)
                                        <div class="flex items-center gap-4 p-3 rounded-2xl bg-[var(--surface-2)] card-in">
                                            <img src="{{ $selectedUniversity->cover_url }}" alt="" class="w-20 h-16 rounded-xl object-cover shrink-0">
                                            <div class="min-w-0">
                                                <p class="font-semibold text-ink truncate">{{ $selectedCourse?->name ?? $selectedUniversity->name }}</p>
                                                <p class="text-sm text-muted truncate">
                                                    @if ($selectedCourse){{ $selectedUniversity->name }} · {{ $selectedCourse->duration }} · {{ ucfirst($selectedCourse->level) }}@else{{ $selectedUniversity->city ? $selectedUniversity->city . ', ' : '' }}{{ $selectedUniversity->country }}@endif
                                                </p>
                                            </div>
                                            <a href="{{ $selectedCourse ? route('courses.show', $selectedCourse->slug) : route('universities.show', $selectedUniversity->slug) }}" target="_blank" class="ml-auto text-sm text-accent shrink-0 hidden sm:inline">Details <i class="fas fa-arrow-up-right-from-square text-[10px]"></i></a>
                                        </div>
                                    @endif

                                    <div><label for="a-edu" class="field-label">Previous education</label><textarea id="a-edu" wire:model.blur="previous_education" rows="3" placeholder="e.g. BSc Computer Science, University of Lagos, 2:1 (2023)" class="field"></textarea></div>
                                    <div><label for="a-eng" class="field-label">English proficiency</label><input id="a-eng" type="text" wire:model.blur="english_proficiency" placeholder="e.g. IELTS 7.0, or WAEC English B3" class="field"></div>
                                </div>
                            @else
                                <p class="mt-2 text-muted">PDF, JPG or PNG up to 2MB each. Everything is optional now — you can send documents later.</p>
                                <div class="mt-8 grid sm:grid-cols-2 gap-4">
                                    @foreach ($docs as $field => [$label, $hint, $icon])
                                        <div>
                                            <label class="dropzone {{ $this->{$field} ? 'is-done' : '' }}">
                                                <span class="icon-tile shrink-0 {{ $this->{$field} ? '!bg-emerald-500/15 !text-emerald-500' : '' }}"><i class="fas {{ $this->{$field} ? 'fa-check' : $icon }}"></i></span>
                                                <span class="min-w-0">
                                                    <span class="block font-medium text-ink">{{ $label }}</span>
                                                    <span class="block text-xs text-muted truncate">{{ $this->{$field} ? $this->{$field}->getClientOriginalName() : $hint }}</span>
                                                </span>
                                                <span wire:loading wire:target="{{ $field }}" class="ml-auto text-accent"><i class="fas fa-circle-notch fa-spin"></i></span>
                                                <input type="file" wire:model="{{ $field }}" accept=".pdf,.jpg,.jpeg,.png" aria-label="{{ $label }}">
                                            </label>
                                            @error($field)<p class="field-error">{{ $message }}</p>@enderror
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mt-8 rounded-2xl border border-line p-5">
                                    <p class="font-semibold text-ink">Other documents</p>
                                    <p class="text-sm text-muted">Reference letters, statement of purpose, certificates…</p>
                                    @if (count($customDocuments) > 0)
                                        <ul class="mt-4 space-y-2">
                                            @foreach ($customDocuments as $index => $doc)
                                                <li class="flex items-center gap-3 p-3 rounded-xl bg-[var(--surface-2)]">
                                                    <i class="fas fa-file-lines text-accent"></i>
                                                    <span class="min-w-0 flex-1"><span class="block text-sm font-medium text-ink truncate">{{ $doc['name'] }}</span><span class="block text-xs text-muted truncate">{{ $doc['temp_name'] }}</span></span>
                                                    <button type="button" wire:click="removeCustomDocument({{ $index }})" class="text-sm text-red-500 hover:text-red-600" aria-label="Remove {{ $doc['name'] }}"><i class="fas fa-trash-can"></i></button>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                    <div class="mt-4 grid sm:grid-cols-[1fr_1fr_auto] gap-3 items-start">
                                        <div><input type="text" wire:model="newDocumentName" placeholder="Document name" aria-label="Document name" class="field @error('newDocumentName') is-invalid @enderror">@error('newDocumentName')<p class="field-error">{{ $message }}</p>@enderror</div>
                                        <div>
                                            <label class="dropzone !py-2.5 !rounded-2xl {{ $newDocumentFile ? 'is-done' : '' }}">
                                                <i class="fas {{ $newDocumentFile ? 'fa-check text-emerald-500' : 'fa-paperclip text-accent' }}"></i>
                                                <span class="text-sm text-ink truncate">{{ $newDocumentFile ? $newDocumentFile->getClientOriginalName() : 'Choose file' }}</span>
                                                <input type="file" wire:model="newDocumentFile" accept=".pdf,.jpg,.jpeg,.png" aria-label="Document file">
                                            </label>
                                            @error('newDocumentFile')<p class="field-error">{{ $message }}</p>@enderror
                                        </div>
                                        <button type="button" wire:click="addCustomDocument" wire:loading.attr="disabled" class="btn btn-ghost h-12 !py-0">
                                            <span wire:loading.remove wire:target="addCustomDocument"><i class="fas fa-plus text-xs"></i> Add</span>
                                            <span wire:loading wire:target="addCustomDocument"><i class="fas fa-circle-notch fa-spin"></i></span>
                                        </button>
                                    </div>
                                </div>

                                {{-- review before submitting --}}
                                <div class="mt-8 rounded-2xl bg-[var(--surface-2)] p-5">
                                    <p class="font-semibold text-ink">Check your details</p>
                                    <dl class="mt-3 grid sm:grid-cols-2 gap-x-6 gap-y-2 text-sm">
                                        @foreach ([['Name', trim($first_name . ' ' . $last_name), 1], ['Email', $email, 1], ['Phone', $phone, 1], ['City', trim($city . ($country ? ', ' . $country : ''), ', '), 2], ['University', $selectedUniversity?->name, 3], ['Course', $selectedCourse?->name, 3]] as [$k, $v, $step])
                                            <div class="flex justify-between gap-3 min-w-0">
                                                <dt class="text-muted shrink-0">{{ $k }}</dt>
                                                <dd class="text-ink font-medium truncate text-right">{{ $v ?: '—' }} <button type="button" wire:click="goToStep({{ $step }})" class="text-accent text-xs ml-1" aria-label="Edit {{ $k }}"><i class="fas fa-pen"></i></button></dd>
                                            </div>
                                        @endforeach
                                    </dl>
                                </div>
                            @endif
                        </div>

                        <div class="mt-10 pt-6 border-t border-line flex items-center justify-between gap-3">
                            @if ($currentStep > 1)
                                <button type="button" wire:click="previousStep" class="btn btn-ghost"><i class="fas fa-arrow-left text-xs"></i> Back</button>
                            @else
                                <span class="text-xs text-muted hidden sm:block"><i class="fas fa-lock mr-1"></i>Your details are kept private.</span>
                            @endif

                            @if ($currentStep < $totalSteps)
                                <button type="button" wire:click="nextStep" wire:loading.attr="disabled" wire:target="nextStep" class="btn btn-primary ml-auto">
                                    Continue <i class="fas fa-arrow-right text-xs btn-arrow" wire:loading.remove wire:target="nextStep"></i><i class="fas fa-circle-notch fa-spin text-xs" wire:loading wire:target="nextStep"></i>
                                </button>
                            @else
                                <button type="submit" wire:loading.attr="disabled" class="btn btn-primary ml-auto disabled:opacity-60">
                                    <span wire:loading.remove wire:target="submit">Submit application <i class="fas fa-paper-plane text-xs ml-1"></i></span>
                                    <span wire:loading wire:target="submit"><i class="fas fa-circle-notch fa-spin mr-2"></i>Submitting…</span>
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </section>
    @endif
</div>

@script
<script>
    const CACHE_KEY = 'application_form_data';

    // restore saved progress from this device
    try {
        const cached = localStorage.getItem(CACHE_KEY);
        if (cached && !$wire.submitted) $wire.restoreFromCache(JSON.parse(cached));
    } catch (e) {}

    $wire.on('cache-form-data', (event) => {
        try { localStorage.setItem(CACHE_KEY, JSON.stringify(event.data ?? event[0]?.data ?? event)); } catch (e) {}
    });
    $wire.on('clear-form-cache', () => {
        try { localStorage.removeItem(CACHE_KEY); } catch (e) {}
        window.scrollTo({ top: 0 });
    });
    $wire.on('step-changed', () => {
        const top = document.getElementById('apply-form');
        if (!top) return;
        const y = top.getBoundingClientRect().top + window.scrollY - 100;
        if (window.scrollY > y) window.scrollTo({ top: y, behavior: 'smooth' });
    });
</script>
@endscript
