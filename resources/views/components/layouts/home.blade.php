<!doctype html>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        // Per-page SEO. Detail pages pass $metaTitle / $metaDescription / $metaImage / $schema via layoutData().
        $seoPages = [
            'home.index' => ['Study Abroad Consultants | Divjules Educational Consult', 'Divjules helps students study abroad in the UK, Canada, USA, Australia, Germany, Ireland and Dubai, with free consultation, university selection, applications and visa guidance.'],
            'home.universities' => ['Partner Universities Abroad | Divjules', 'Explore partner universities in the UK, Canada, USA, Australia, Germany, Ireland and Dubai. Compare locations and courses, then apply with expert support from Divjules.'],
            'home.courses' => ['Courses to Study Abroad: Undergraduate, Masters & Diplomas | Divjules', 'Search undergraduate, postgraduate, diploma and certificate courses at universities abroad: business, computing, engineering, nursing, law and more.'],
            'home.about' => ['About Divjules Educational Consult', 'Meet Divjules, an education consultancy guiding students from course choice to campus, with counsellors, a global university network and end-to-end support.'],
            'home.blog' => ['Study Abroad Blog: Guides, Visas & Scholarships | Divjules', 'Practical guides on studying abroad: choosing a university, applications, scholarships, student visas and life as an international student.'],
            'home.contact' => ['Contact Divjules | Book a Free Study Abroad Consultation', 'Talk to a Divjules counsellor about studying abroad. Book a free consultation by phone, email, WhatsApp or the contact form.'],
            'home.apply' => ['Apply to Study Abroad | Divjules', 'Start your study abroad application with Divjules in four simple steps: personal details, contact information, course choice and documents.'],
            'home.reviews' => ['Student Reviews | Divjules Educational Consult', 'Read reviews from students who studied abroad with the help of Divjules.'],
            'home.submit-review' => ['Share Your Experience | Divjules', 'Studied abroad with Divjules? Share your experience to help future students.'],
            'application.track' => ['Track Your Application | Divjules', 'Check the status of your Divjules study abroad application with your application number.'],
        ];
        $routeName = request()->route()?->getName();
        $metaTitle = $metaTitle ?? ($seoPages[$routeName][0] ?? (isset($title) ? $title . ' | Divjules' : 'Divjules Educational Consult'));
        $metaDescription = \Illuminate\Support\Str::limit(strip_tags($metaDescription ?? ($seoPages[$routeName][1] ?? $seoPages['home.index'][1])), 160);
        $metaImage = $metaImage ?? asset('homeassets/img/site/og-default.jpg');
        $metaType = $metaType ?? 'website';
        $canonical = url()->current();
        $noindex = in_array($routeName, ['application.track', 'home.submit-review']);

        $graph = [
            ['@type' => 'EducationalOrganization', '@id' => url('/') . '#org', 'name' => 'Divjules Educational Consult', 'url' => url('/'), 'logo' => asset('assets/images/logo-brand.png'), 'image' => asset('homeassets/img/site/og-default.jpg'), 'description' => $seoPages['home.index'][1]],
            ['@type' => 'WebSite', '@id' => url('/') . '#website', 'url' => url('/'), 'name' => 'Divjules', 'publisher' => ['@id' => url('/') . '#org']],
        ];
        if ($routeName && $routeName !== 'home.index') {
            $crumbs = [['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')]];
            foreach ($breadcrumbs ?? [[$title ?? $metaTitle, $canonical]] as $i => [$crumbName, $crumbUrl]) {
                $crumbs[] = ['@type' => 'ListItem', 'position' => $i + 2, 'name' => $crumbName, 'item' => $crumbUrl];
            }
            $graph[] = ['@type' => 'BreadcrumbList', 'itemListElement' => $crumbs];
        }
        foreach ($schema ?? [] as $node) { $graph[] = $node; }
    @endphp
    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <link rel="canonical" href="{{ $canonical }}">
    @if ($noindex)<meta name="robots" content="noindex, follow">@else<meta name="robots" content="index, follow, max-image-preview:large">@endif
    <meta property="og:site_name" content="Divjules Educational Consult">
    <meta property="og:type" content="{{ $metaType }}">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:image" content="{{ $metaImage }}">
    <meta property="og:locale" content="en_GB">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $metaTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    <meta name="twitter:image" content="{{ $metaImage }}">
    <meta name="theme-color" content="#1a1a4e">
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/logo-brand.png') }}">
    <script type="application/ld+json">{!! json_encode(['@context' => 'https://schema.org', '@graph' => $graph], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

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
