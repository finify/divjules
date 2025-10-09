<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title, Validate};
use App\Models\Application;

new
#[Layout('components.layouts.home')]
#[Title('Track Your Application')]
class extends Component {
    #[Validate('required|string')]
    public $application_number = '';

    public $application = null;
    public $searched = false;

    public function searchApplication()
    {
        $this->validate();

        $this->application = Application::with(['applicationStage', 'university', 'course'])
            ->where('application_number', $this->application_number)
            ->first();

        $this->searched = true;

        if (!$this->application) {
            session()->flash('error', 'Application not found. Please check your application number and try again.');
        }
    }

    public function resetSearch()
    {
        $this->application = null;
        $this->application_number = '';
        $this->searched = false;
        $this->resetValidation();
    }
}; ?>

<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-purple-600 to-indigo-600 pt-32 pb-16 px-4 mt-20">
        <div class="max-w-7xl mx-auto text-center text-white">
            <h1 class="text-5xl font-bold mb-4">Track Your Application</h1>
            <p class="text-xl">Enter your application number to check the status</p>
        </div>
    </section>

    <!-- Search Form -->
    <section class="py-16 px-4">
        <div class="max-w-2xl mx-auto">
            @if(!$application)
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold mb-6 text-center">Enter Application Number</h2>

                    <form wire:submit="searchApplication">
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Application Number *</label>
                            <input type="text"
                                   wire:model="application_number"
                                   placeholder="e.g., APP-2025-XXXXXXXX"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent @error('application_number') border-red-500 @enderror">
                            @error('application_number')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        @if(session('error'))
                            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded">
                                {{ session('error') }}
                            </div>
                        @endif

                        <button type="submit"
                                wire:loading.attr="disabled"
                                class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-lg transition-colors disabled:opacity-50">
                            <span wire:loading.remove wire:target="searchApplication">Search Application</span>
                            <span wire:loading wire:target="searchApplication">Searching...</span>
                        </button>
                    </form>

                    <div class="mt-8 pt-6 border-t border-gray-200 text-center">
                        <p class="text-sm text-gray-600">
                            Don't have an application number?
                            <a href="{{ route('home.apply') }}" class="text-purple-600 hover:text-purple-700 font-semibold">Apply Now</a>
                        </p>
                    </div>
                </div>
            @else
                <!-- Application Details -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-purple-600 to-indigo-600 p-8 text-white">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-3xl font-bold">Application Details</h2>
                            <button wire:click="resetSearch" class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg transition-colors">
                                New Search
                            </button>
                        </div>
                        <p class="text-xl font-semibold tracking-wider">{{ $application->application_number }}</p>
                    </div>

                    <!-- Application Stage Progress -->
                    <div class="p-8 bg-gray-50">
                        <h3 class="text-lg font-semibold mb-4">Current Stage</h3>
                        <div class="bg-white rounded-lg p-6 border-l-4" style="border-color: {{ $application->applicationStage?->color ?? '#9333ea' }}">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h4 class="text-xl font-bold text-gray-900 mb-2">
                                        {{ $application->applicationStage?->name ?? 'Pending' }}
                                    </h4>
                                    <p class="text-gray-600">
                                        {{ $application->applicationStage?->description ?? 'Your application is being processed.' }}
                                    </p>
                                </div>
                                <div class="ml-4">
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold text-white"
                                          style="background-color: {{ $application->applicationStage?->color ?? '#9333ea' }}">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Applicant Information -->
                    <div class="p-8">
                        <h3 class="text-lg font-semibold mb-4">Applicant Information</h3>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm text-gray-600">Full Name</p>
                                <p class="text-lg font-semibold">{{ $application->full_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Email</p>
                                <p class="text-lg font-semibold">{{ $application->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Phone</p>
                                <p class="text-lg font-semibold">{{ $application->phone }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Nationality</p>
                                <p class="text-lg font-semibold">{{ $application->nationality }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Course Selection -->
                    <div class="p-8 bg-gray-50">
                        <h3 class="text-lg font-semibold mb-4">Course Selection</h3>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm text-gray-600">University</p>
                                <p class="text-lg font-semibold">{{ $application->university?->name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Course</p>
                                <p class="text-lg font-semibold">{{ $application->course?->name ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div class="p-8">
                        <h3 class="text-lg font-semibold mb-4">Timeline</h3>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-3 h-3 rounded-full bg-green-500 mt-1.5"></div>
                                <div class="ml-4">
                                    <p class="font-semibold">Application Submitted</p>
                                    <p class="text-sm text-gray-600">{{ $application->submitted_at?->format('M d, Y \a\t h:i A') ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-3 h-3 rounded-full {{ $application->applicationStage ? 'bg-green-500' : 'bg-gray-300' }} mt-1.5"></div>
                                <div class="ml-4">
                                    <p class="font-semibold">{{ $application->applicationStage?->name ?? 'Awaiting Review' }}</p>
                                    <p class="text-sm text-gray-600">{{ $application->updated_at->format('M d, Y \a\t h:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="p-8 bg-gray-50 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row gap-4">
                            <button wire:click="resetSearch"
                                    class="flex-1 border-2 border-gray-300 hover:border-gray-400 text-gray-700 font-bold py-3 px-6 rounded-lg transition-colors">
                                Search Another Application
                            </button>
                            <a href="{{ route('home.index') }}"
                               class="flex-1 text-center bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-lg transition-colors">
                                Return to Homepage
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Help Section -->
    <section class="py-16 px-4 bg-white">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-3xl font-bold text-center mb-8">Need Help?</h2>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach($contactDetails->take(3) as $contact)
                    <div class="text-center p-6">
                        <svg class="w-12 h-12 mx-auto mb-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if($contact->type === 'email')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            @elseif($contact->type === 'phone')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            @endif
                        </svg>
                        <h3 class="font-bold mb-2">{{ $contact->label }}</h3>
                        @if($contact->is_clickable)
                            <a href="{{ $contact->link }}" class="text-gray-600 text-sm hover:text-purple-600 transition-colors">{{ $contact->value }}</a>
                        @else
                            <p class="text-gray-600 text-sm">{{ $contact->value }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
