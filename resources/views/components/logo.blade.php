@props(['variant' => 'auto', 'class' => 'h-10'])
{{-- Brand logo in the site's navy + sky. "auto" swaps to the light version in dark mode / over navy heroes. --}}
@if ($variant === 'light')
    <img src="{{ asset('assets/images/logo-light.png') }}" alt="Divjules Educational Consult" class="{{ $class }} w-auto" width="384" height="120">
@else
    <img src="{{ asset('assets/images/logo-brand.png') }}" alt="Divjules Educational Consult" class="logo-for-light {{ $class }} w-auto" width="384" height="120">
    <img src="{{ asset('assets/images/logo-light.png') }}" alt="" aria-hidden="true" class="logo-for-dark {{ $class }} w-auto" width="384" height="120">
@endif
