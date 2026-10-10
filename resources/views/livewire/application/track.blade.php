<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title, Validate};
use App\Models\Application;
use App\Models\ApplicationStage;

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

    public function with(): array
    {
        $path = collect();
        if ($this->application) {
            $stages = ApplicationStage::active()->ordered()->get();
            $current = $this->application->applicationStage;
            $branches = ['rejected', 'waitlisted'];
            // main path ends in "Accepted"; a rejected/waitlisted outcome replaces that last step
            $path = $stages->reject(fn ($s) => in_array(strtolower($s->name), $branches));
            if ($current && in_array(strtolower($current->name), $branches)) {
                $path = $path->reject(fn ($s) => strtolower($s->name) === 'accepted')->push($current);
            }
        }

        return ['path' => $path->values()];
    }

    public function resetSearch()
    {
        $this->application = null;
        $this->application_number = '';
        $this->searched = false;
        $this->resetValidation();
    }
}; ?>

<div>
    <section style="--hero-img: url('/homeassets/img/site/airport.webp')" class="page-hero pt-40 md:pt-48 pb-28 md:pb-36 px-4">
        <div class="max-w-3xl mx-auto text-center text-white">
            <span class="eyebrow !text-sky-300 justify-center">Application status</span>
            <h1 class="mt-5">Track your application</h1>
            <p class="mt-5 text-xl">Enter the application number we sent you to see where things stand.</p>
        </div>
    </section>

    <section class="relative z-20 -mt-16 px-4 pb-24" data-no-auto>
        <div class="max-w-3xl mx-auto">
            @if (! $application)
                <div class="card !p-7 md:!p-10 card-in" style="box-shadow: var(--shadow-lg)">
                    <form wire:submit="searchApplication" class="flex flex-col sm:flex-row gap-3">
                        <label for="t-num" class="sr-only">Application number</label>
                        <div class="relative flex-1">
                            <i class="fas fa-hashtag absolute left-4 top-1/2 -translate-y-1/2 text-muted text-sm"></i>
                            <input id="t-num" type="text" wire:model="application_number" placeholder="e.g. APP-2026-XXXXXXXX" autocomplete="off" class="field !h-14 !pl-10 !text-base uppercase tracking-wide @error('application_number') is-invalid @enderror">
                        </div>
                        <button type="submit" wire:loading.attr="disabled" class="btn btn-primary !h-14 disabled:opacity-60">
                            <span wire:loading.remove wire:target="searchApplication">Track <i class="fas fa-arrow-right text-xs ml-1"></i></span>
                            <span wire:loading wire:target="searchApplication"><i class="fas fa-circle-notch fa-spin"></i></span>
                        </button>
                    </form>
                    @error('application_number') <p class="field-error">{{ $message }}</p> @enderror
                    @if (session('error'))
                        <div class="mt-5 p-4 rounded-2xl bg-red-500/10 text-red-600 dark:text-red-300 border border-red-500/20 text-sm"><i class="fas fa-circle-exclamation mr-2"></i>{{ session('error') }}</div>
                    @endif
                    <p class="mt-6 text-sm text-muted">Don't have an application number yet? <a href="{{ route('home.apply') }}" class="text-accent font-medium">Start an application</a></p>
                </div>
            @else
                @php
                    $current = $application->applicationStage;
                    $currentIndex = $current ? $path->search(fn ($s) => $s->id === $current->id) : -1;
                    $currentIndex = $currentIndex === false ? -1 : $currentIndex;
                @endphp
                <div class="card !p-0 overflow-hidden card-in" style="box-shadow: var(--shadow-lg)">
                    <div class="brand-band p-7 md:p-9 text-white" style="background: linear-gradient(135deg, #1a1a4e, #0f0f2e)">
                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <div>
                                <p class="text-xs font-mono uppercase tracking-wider text-white/50">Application</p>
                                <p class="mt-1 text-2xl md:text-3xl font-semibold tracking-tight">{{ $application->application_number }}</p>
                            </div>
                            <span class="uni-chip !text-sm !px-4 !py-1.5" style="background: {{ $current?->color ?? '#0369a1' }}"><i class="fas fa-circle text-[6px]"></i>{{ $current?->name ?? 'Pending' }}</span>
                        </div>
                        <p class="mt-4 text-white/70">{{ $current?->description ?? 'Your application is being processed.' }}</p>
                    </div>

                    <div class="p-7 md:p-9">
                        <h2 class="font-semibold text-ink">Progress</h2>
                        <ol class="mt-6 relative">
                            @foreach ($path as $i => $stage)
                                @php $state = $i < $currentIndex ? 'done' : ($i === $currentIndex ? 'current' : 'todo'); @endphp
                                <li class="relative flex gap-4 pb-7 last:pb-0">
                                    @if (! $loop->last)<span class="absolute left-[15px] top-8 bottom-0 w-[2px] {{ $state === 'done' ? 'bg-emerald-500' : 'bg-[var(--line)]' }}"></span>@endif
                                    <span class="relative grid place-items-center w-8 h-8 rounded-full shrink-0 text-xs
                                        {{ $state === 'done' ? 'bg-emerald-500 text-white' : ($state === 'current' ? 'text-white ring-4 ring-[var(--accent-soft)]' : 'bg-[var(--surface-2)] text-muted border border-line') }}"
                                        @if ($state === 'current') style="background: {{ $stage->color ?? '#0369a1' }}" @endif>
                                        @if ($state === 'done')<i class="fas fa-check"></i>@else{{ $i + 1 }}@endif
                                    </span>
                                    <div class="pt-1">
                                        <p class="font-medium {{ $state === 'todo' ? 'text-muted' : 'text-ink' }}">{{ $stage->name }}</p>
                                        @if ($state === 'current')
                                            <p class="text-sm text-muted mt-0.5">Updated {{ $application->updated_at->format('M j, Y') }}</p>
                                        @elseif ($i === 0 && $application->submitted_at)
                                            <p class="text-sm text-muted mt-0.5">Submitted {{ $application->submitted_at->format('M j, Y') }}</p>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ol>

                        <div class="mt-10 grid sm:grid-cols-2 gap-4">
                            <div class="rounded-2xl bg-[var(--surface-2)] p-5">
                                <p class="text-xs font-mono uppercase tracking-wider text-muted">Applicant</p>
                                <p class="mt-2 font-semibold text-ink">{{ $application->full_name }}</p>
                                <p class="text-sm text-muted break-all">{{ $application->email }}</p>
                                <p class="text-sm text-muted">{{ $application->phone }}</p>
                            </div>
                            <div class="rounded-2xl bg-[var(--surface-2)] p-5">
                                <p class="text-xs font-mono uppercase tracking-wider text-muted">Course</p>
                                <p class="mt-2 font-semibold text-ink">{{ $application->course?->name ?? 'N/A' }}</p>
                                <p class="text-sm text-muted">{{ $application->university?->name ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <div class="mt-8 flex flex-col sm:flex-row gap-3">
                            <button type="button" wire:click="resetSearch" class="btn btn-ghost flex-1">Track another application</button>
                            <a href="{{ route('home.contact') }}" class="btn btn-primary flex-1">Contact your counsellor</a>
                        </div>
                    </div>
                </div>
            @endif

            <div class="mt-10 grid sm:grid-cols-3 gap-4">
                @foreach ($contactDetails->take(3) as $contact)
                    <div class="card !p-5 group" data-reveal>
                        <span class="icon-tile"><i class="{{ $contact->fa_icon }}"></i></span>
                        <p class="mt-3 text-xs font-mono uppercase tracking-wider text-muted">{{ $contact->label }}</p>
                        @if ($contact->is_clickable)
                            <a href="{{ $contact->link }}" class="mt-1 block text-sm font-semibold text-ink break-words after:absolute after:inset-0 group-hover:text-accent">{{ $contact->value }}</a>
                        @else
                            <p class="mt-1 text-sm font-semibold text-ink break-words">{{ $contact->value }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
