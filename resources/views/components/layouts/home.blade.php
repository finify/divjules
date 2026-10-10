<!doctype html>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($title) ? $title . ' · Divjules' : 'Divjules - Your Gateway to Quality Education' }}</title>
    <meta name="description" content="Divjules Education Consultancy — expert guidance on universities, courses, applications and visas for studying abroad.">
    <meta name="theme-color" content="#1a1a4e">

    {{-- Apply the saved / system theme before first paint so there is no flash --}}
    <script>
        (function () {
            try {
                var saved = localStorage.getItem('dj-theme');
                var dark = saved ? saved === 'dark' : window.matchMedia('(prefers-color-scheme: dark)').matches;
                document.documentElement.classList.toggle('dark', dark);
            } catch (e) {}
        })();
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300..800&family=Geist+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="min-h-screen">
    <div class="scroll-progress" aria-hidden="true"></div>

    <livewire:home.layout.header />

    <main id="main">
        {{ $slot }}
    </main>

    <livewire:home.layout.footer />

    <x-whatsapp-button />

    @livewireScripts
    @stack('scripts')
</body>

</html>
