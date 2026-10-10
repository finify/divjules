<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title, Validate};
use App\Models\ContactMessage;
use App\Mail\ContactFormSubmitted;
use Illuminate\Support\Facades\Mail;
use App\Models\ContactDetail;

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

    public $whatsappUrl = null;

    public $contactDetails = [];
    public $socialLinks = [];

    public function mount()
    {
        $this->contactDetails = ContactDetail::active()->ordered()->get();

        $keys = ['social_facebook', 'social_twitter', 'social_instagram', 'social_linkedin', 'social_youtube'];
        $rows = ContactDetail::whereIn('key', $keys)->pluck('value', 'key');
        $this->socialLinks = [
            'facebook'  => $rows['social_facebook']  ?? '',
            'twitter'   => $rows['social_twitter']   ?? '',
            'instagram' => $rows['social_instagram'] ?? '',
            'linkedin'  => $rows['social_linkedin']  ?? '',
            'youtube'   => $rows['social_youtube']   ?? '',
        ];
    }

    public array $faqs = [
        ['How long does the application process take?', "Typically, the entire process takes 4-8 weeks, depending on the university and course. We'll guide you through each step to ensure timely submission."],
        ['Do you charge for consultation services?', "Your initial consultation is completely free! We'll discuss your goals and provide guidance at no cost. Additional services may have fees, which we'll discuss transparently."],
        ['Can you help with visa applications?', 'Yes! We provide comprehensive visa assistance, including document preparation, application review, and interview preparation to maximize your chances of approval.'],
        ["What if I don't meet the entry requirements?", 'We offer pathway programs and foundation courses that can help you meet university requirements. Our counsellors will find the best route for your situation.'],
        ['Do you help with scholarships?', 'Absolutely! We have information on numerous scholarships and can help you identify and apply for opportunities that match your profile.'],
    ];

    public function rendering($view): void
    {
        $view->layoutData(['schema' => [[
            '@type' => 'FAQPage',
            'mainEntity' => array_map(fn ($f) => ['@type' => 'Question', 'name' => $f[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]]], $this->faqs),
        ]]]);
    }

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
                \Log::error('Contact form email error: ' . $mailException->getMessage());
            }

            // Build WhatsApp message for admin
            $adminNumber = preg_replace('/[^0-9]/', '', ContactDetail::where('key', 'whatsapp_number')->value('value') ?? '');
            if ($adminNumber) {
                $waText = implode("\n", [
                    '📋 *New Enquiry from Website*',
                    '',
                    '👤 *Name:* ' . $this->first_name . ' ' . $this->last_name,
                    '📧 *Email:* ' . $this->email,
                    '📞 *Phone:* ' . ($this->phone ?: 'Not provided'),
                    '🌍 *Country:* ' . $this->country,
                    '🎓 *Interested In:* ' . $this->interest,
                    '',
                    '💬 *Message:*',
                    $this->message,
                ]);
                $this->whatsappUrl = 'https://wa.me/' . $adminNumber . '?text=' . rawurlencode($waText);
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

@php
    $field = 'w-full h-12 px-4 rounded-2xl border border-line bg-[var(--surface-2)] text-ink focus:bg-[var(--surface)] transition';
    $interests = ['Undergraduate Programs' => 'Undergraduate', 'Postgraduate Programs' => 'Postgraduate', 'Pathway Courses' => 'Pathway', 'Free Consultation' => 'Consultation', 'Visa Assistance' => 'Visa help', 'Other Services' => 'Something else'];
@endphp

<div>
    <section style="--hero-img: url('/homeassets/img/site/consultation.webp')" class="page-hero pt-40 md:pt-48 pb-28 md:pb-36 px-4">
        <div class="max-w-4xl mx-auto text-center text-white">
            <span class="eyebrow !text-sky-300 justify-center">Contact us</span>
            <h1 class="mt-5">Let's plan your study abroad journey</h1>
            <p class="mt-5 text-xl">Ask us anything: courses, costs, scholarships or visas. A counsellor will reply within one working day.</p>
        </div>
    </section>

    {{-- quick channels --}}
    <section class="relative z-20 -mt-16 px-4" data-no-auto>
        <div class="max-w-6xl mx-auto grid sm:grid-cols-2 lg:grid-cols-{{ min(4, max(1, $contactDetails->count())) }} gap-4">
            @foreach($contactDetails->take(4) as $contact)
                @php $icon = $contact->fa_icon; @endphp
                <div class="card !p-5 group" data-reveal data-spotlight>
                    <span class="icon-tile group-hover:bg-[var(--accent)] group-hover:text-white transition-colors"><i class="{{ $icon }}"></i></span>
                    <p class="mt-4 text-xs font-mono uppercase tracking-wider text-muted">{{ $contact->label }}</p>
                    @if($contact->is_clickable)
                        <a href="{{ $contact->link }}" class="mt-1 block font-semibold text-ink break-words after:absolute after:inset-0 group-hover:text-accent transition-colors">{{ $contact->value }}</a>
                    @else
                        <p class="mt-1 font-semibold text-ink break-words">{!! $contact->formatted_value !!}</p>
                    @endif
                </div>
            @endforeach
        </div>
    </section>

    <section id="contact-form" class="py-20 md:py-24 px-4" data-no-auto>
        <div class="max-w-6xl mx-auto grid lg:grid-cols-12 gap-8">
            <div class="lg:col-span-7 card !p-7 md:!p-10" data-reveal>
                @if($submitted)
                    <div class="text-center py-10">
                        <span class="grid place-items-center w-20 h-20 mx-auto rounded-full bg-emerald-500/15 text-emerald-500 text-3xl"><i class="fas fa-check"></i></span>
                        <h2 class="mt-6 text-3xl font-semibold tracking-tight text-ink">Message sent</h2>
                        <p class="mt-3 text-muted">Thank you for contacting us. We'll get back to you as soon as possible.</p>
                        @if($whatsappUrl)
                            <div class="mt-8 p-5 rounded-2xl bg-emerald-500/10 border border-emerald-500/20">
                                <p class="text-ink font-medium">Want a faster reply? Send your enquiry on WhatsApp too.</p>
                                <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="btn mt-4 !bg-[#25D366] text-white hover:!bg-[#1ebe5d]"><i class="fab fa-whatsapp text-lg"></i> Send via WhatsApp</a>
                            </div>
                        @endif
                        <button wire:click="$set('submitted', false)" class="btn btn-ghost mt-8">Send another message</button>
                    </div>
                @else
                    <h2 class="text-3xl font-semibold tracking-tight text-ink">Send us a message</h2>
                    <p class="mt-2 text-muted">Fields marked * are required.</p>

                    @if (session('error'))
                        <div class="mt-6 p-4 rounded-2xl bg-red-500/10 text-red-600 dark:text-red-300 border border-red-500/20">{{ session('error') }}</div>
                    @endif

                    <form wire:submit="submit" class="mt-8 space-y-5" novalidate>
                        <div class="grid sm:grid-cols-2 gap-5">
                            <div>
                                <label for="c-first" class="block text-sm font-medium text-ink mb-2">First name *</label>
                                <input id="c-first" type="text" autocomplete="given-name" wire:model.blur="first_name" class="{{ $field }} @error('first_name') !border-red-500 @enderror">
                                @error('first_name') <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="c-last" class="block text-sm font-medium text-ink mb-2">Last name *</label>
                                <input id="c-last" type="text" autocomplete="family-name" wire:model.blur="last_name" class="{{ $field }} @error('last_name') !border-red-500 @enderror">
                                @error('last_name') <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="grid sm:grid-cols-2 gap-5">
                            <div>
                                <label for="c-email" class="block text-sm font-medium text-ink mb-2">Email *</label>
                                <input id="c-email" type="email" autocomplete="email" wire:model.blur="email" class="{{ $field }} @error('email') !border-red-500 @enderror">
                                @error('email') <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="c-phone" class="block text-sm font-medium text-ink mb-2">Phone / WhatsApp</label>
                                <input id="c-phone" type="tel" autocomplete="tel" wire:model.blur="phone" class="{{ $field }} @error('phone') !border-red-500 @enderror">
                                @error('phone') <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div>
                            <label for="c-country" class="block text-sm font-medium text-ink mb-2">Where do you want to study? *</label>
                            <select id="c-country" wire:model.blur="country" class="filter-select !max-w-none w-full !h-12 !rounded-2xl @error('country') !border-red-500 @enderror">
                                <option value="">Select a country</option>
                                @foreach (['United Kingdom', 'Canada', 'United States', 'Australia', 'Germany', 'Ireland', 'United Arab Emirates', 'Not sure yet', 'Other'] as $opt)
                                    <option value="{{ $opt }}">{{ $opt }}</option>
                                @endforeach
                            </select>
                            @error('country') <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <fieldset>
                            <legend class="block text-sm font-medium text-ink mb-2">I'm interested in *</legend>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($interests as $value => $label)
                                    <label class="chip has-[:checked]:!bg-[var(--accent)] has-[:checked]:!text-white has-[:checked]:!border-[var(--accent)]">
                                        <input type="radio" name="interest" value="{{ $value }}" wire:model="interest" class="sr-only">{{ $label }}
                                    </label>
                                @endforeach
                            </div>
                            @error('interest') <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p> @enderror
                        </fieldset>
                        <div>
                            <label for="c-msg" class="block text-sm font-medium text-ink mb-2">Your message *</label>
                            <textarea id="c-msg" wire:model.blur="message" rows="5" placeholder="Tell us what you'd like to study, your current qualification and when you'd like to start." class="w-full px-4 py-3 rounded-2xl border border-line bg-[var(--surface-2)] text-ink focus:bg-[var(--surface)] transition @error('message') !border-red-500 @enderror"></textarea>
                            @error('message') <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <label class="flex items-start gap-3 text-sm text-muted cursor-pointer">
                            <input type="checkbox" wire:model="consent" class="mt-0.5 w-5 h-5 rounded accent-[var(--accent)] shrink-0">
                            <span>I agree to receive information about courses and services from Divjules. We respect your privacy and will never share your details with third parties. *</span>
                        </label>
                        @error('consent') <p class="text-sm text-red-500">{{ $message }}</p> @enderror

                        <button type="submit" wire:loading.attr="disabled" class="btn btn-primary w-full !py-4 disabled:opacity-60">
                            <span wire:loading.remove wire:target="submit">Send message <i class="fas fa-paper-plane text-sm ml-1"></i></span>
                            <span wire:loading wire:target="submit"><i class="fas fa-circle-notch fa-spin mr-2"></i>Sending…</span>
                        </button>
                    </form>
                @endif
            </div>

            <aside class="lg:col-span-5 space-y-5">
                <div class="card brand-band !p-0 !bg-[#1a1a4e] !border-transparent text-white overflow-hidden" data-reveal>
                    <div class="relative h-48 overflow-hidden">
                        <img src="/homeassets/img/site/students-friends.webp" alt="Students smiling together" class="absolute inset-0 w-full h-full object-cover" data-img-zoom>
                        <div class="absolute inset-0 bg-gradient-to-t from-[#1a1a4e] to-transparent"></div>
                    </div>
                    <div class="p-7 -mt-8 relative">
                        <h3 class="text-xl font-semibold">What happens next</h3>
                        <ol class="mt-5 space-y-4">
                            @foreach ([['We reply within one working day', 'A counsellor reviews your message and gets in touch.'], ['Free consultation call', 'We talk through your goals, budget and qualifications.'], ['Your shortlist & plan', 'Universities, courses, deadlines and the visa route that fit you.']] as $i => [$t, $d])
                                <li class="flex gap-4">
                                    <span class="grid place-items-center w-8 h-8 rounded-full bg-white/10 text-sky-300 text-sm font-semibold shrink-0">{{ $i + 1 }}</span>
                                    <div><p class="font-medium">{{ $t }}</p><p class="text-sm text-white/60">{{ $d }}</p></div>
                                </li>
                            @endforeach
                        </ol>
                    </div>
                </div>

                <div class="card" data-reveal>
                    <h3 class="font-semibold text-ink">Follow us</h3>
                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach (['facebook' => 'facebook-f', 'twitter' => 'x-twitter', 'instagram' => 'instagram', 'linkedin' => 'linkedin-in', 'youtube' => 'youtube'] as $key => $icon)
                            @if ($socialLinks[$key])
                                <a href="{{ $socialLinks[$key] }}" target="_blank" rel="noopener" class="theme-toggle !w-11 !h-11" aria-label="{{ ucfirst($key) }}"><i class="fab fa-{{ $icon }}"></i></a>
                            @endif
                        @endforeach
                        @if (! array_filter($socialLinks))
                            <p class="text-sm text-muted">Social links coming soon.</p>
                        @endif
                    </div>
                    @if ($contactDetails->count() > 4)
                        <ul class="mt-6 pt-6 border-t border-line space-y-3 text-sm">
                            @foreach ($contactDetails->slice(4) as $contact)
                                <li class="flex gap-3"><i class="{{ $contact->fa_icon }} text-accent mt-1"></i>
                                    <span><span class="text-muted">{{ $contact->label }}:</span>
                                    @if ($contact->is_clickable)<a href="{{ $contact->link }}" class="text-ink hover:text-accent">{{ $contact->value }}</a>@else<span class="text-ink">{!! $contact->formatted_value !!}</span>@endif</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </aside>
        </div>
    </section>

    <section class="py-20 md:py-24 px-4 bg-page-alt" data-no-auto>
        <div class="max-w-6xl mx-auto grid lg:grid-cols-12 gap-10">
            <div class="lg:col-span-4">
                <span class="eyebrow" data-reveal>FAQ</span>
                <h2 class="h-display text-4xl md:text-5xl mt-4" data-reveal>Questions, answered.</h2>
                <p class="mt-4 text-muted" data-reveal>Still unsure? <a href="#contact-form" class="text-accent font-medium">Send us a message</a> and a counsellor will help.</p>
            </div>
            <div class="lg:col-span-8 space-y-3">
                @foreach ($faqs as $i => [$q, $a])
                    <details class="faq card !p-0 group" data-reveal {{ $i === 0 ? 'open' : '' }}>
                        <summary class="flex items-center justify-between gap-4 cursor-pointer list-none px-6 py-5 font-semibold text-ink">
                            {{ $q }}
                            <span class="grid place-items-center w-8 h-8 rounded-full bg-[var(--accent-soft)] text-accent shrink-0 transition-transform duration-300 group-open:rotate-45"><i class="fas fa-plus text-xs"></i></span>
                        </summary>
                        <div class="faq-body px-6 pb-6 -mt-1 text-muted leading-relaxed">{{ $a }}</div>
                    </details>
                @endforeach
            </div>
        </div>
    </section>
</div>
