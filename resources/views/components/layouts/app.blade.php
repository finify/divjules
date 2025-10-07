<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title.' - '.config('app.name') : config('app.name') }}</title>
    <link
      href="/assets/img/favicon.png"
      rel="shortcut icon"
      type="image/x-icon"
    />
    <link
      href="/assets/img/favicon.png"
      rel="apple-touch-icon"
    />

    <style>
        .mobileContainer__wdSTq.__tablet__dIlXn {
            width:100% !important;
        }
    </style>
        
    {{--  Currency  --}}
    {{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/gh/robsontenorio/mary@0.44.2/libs/currency/currency.js"></script> --}}
    @vite(
        [
            'resources/css/app.css',
            'resources/css/custom.css',
            'resources/js/app.js'
        ])

    @livewireStyles
 
</head>
<body class="min-h-screen flex flex-col font-sans antialiased bg-base-200"
    x-data="{
        collapsed: true,
        menuactive:1,
        loading: false,
    }">

    {{-- The navbar with `sticky` and `full-width` for both mobile and desktop--}}
    <livewire:user.layout.topnav key="topnav"/>

    

    {{-- Main content area containing sidebar and content --}}

    <div class="flex flex-col lg:flex-row h-auto">
        {{-- SIDEBAR --}}
        <div class="lg:block" :class="collapsed ? 'lg:w-[64px] w-full' : 'lg:w-[200px] w-full'" x-cloak>

            {{-- <livewire:user.returnprofit /> --}}
            <livewire:user.layout.sidebar  key="sidebar"/>
        </div>
        {{-- The main content area --}}
        <div class="h-auto flex-1">
            {{-- <div x-show="!loading">
                <span class="text-gray-500">Loading page…</span>
            </div> --}}

            <div x-show="loading" class="fixed inset-0 flex items-center justify-center backdrop-blur-md" id="loadingcover">
                <div class="flex flex-col items-center gap-4">
                    <x-loading class="loading-dots progress-primary" />
                </div>
            </div>
            
            <div>
                {{ $slot ?? '' }}
            </div>
        </div>

    </div>
    
    {{-- MAIN --}}
    {{-- <x-main with-nav full-width> --}}

        {{-- SIDEBAR --}}
        {{-- <livewire:user.layout.sidebar /> --}}

        {{-- The main content area --}}
        {{-- The `$slot` goes here --}}
        {{-- <x-slot:content :class="'!lg:p-0'">
            {{ $slot }}
        </x-slot:content>


    </x-main> --}}
    
    

    

    {{-- My Custome Apline x-toast --}}
    {{-- <x-toast-alpine /> --}}
    {{-- Chart.js  --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <!-- resources/views/layouts/app.blade.php -->
 {{--  TOAST area --}}
    <x-toast />
     <!-- ✅ Global Toast Component -->
    <div 
        x-data="toastHandler()" 
        x-init="initToast()" 
        class="fixed top-5 right-5 z-50"
    >
        <template x-for="(toast, index) in toasts" :key="index">
            <div
                x-show="toast.visible"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-2"
                class="alert shadow-lg mb-3 w-fit"
                :class="{
                    'alert-success': toast.type === 'success',
                    'alert-error': toast.type === 'error',
                    'alert-info': toast.type === 'info',
                    'alert-warning': toast.type === 'warning'
                }"
            >
                <span x-text="toast.message" class="font-bold"></span>
            </div>
        </template>
    </div>



    <script src="https://s3.tradingview.com/tv.js"></script>
    @stack('scripts')
    @livewireScripts

    <!-- ✅ Alpine Toast Logic -->
    <script>
    function toastHandler() {
        return {
            toasts: [],
            initToast() {
                window.showToast = this.showToast.bind(this); // make it global
            },
            showToast(message, type = 'success') {
                const id = Date.now();
                this.toasts.push({ id, message, type, visible: true });

                setTimeout(() => {
                    const toast = this.toasts.find(t => t.id === id);
                    if (toast) toast.visible = false;
                    setTimeout(() => {
                        this.toasts = this.toasts.filter(t => t.id !== id);
                    }, 300); // cleanup after fade out
                }, 4000);
            }
        }
    }
    </script>



   
   
</body>
</html>
