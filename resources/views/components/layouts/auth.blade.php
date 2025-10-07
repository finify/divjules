<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

     <!-- Meta Tags for Content Description -->
    <meta name="description"
        content="Log in to your dashboard and overview the activities of your cryptocurrency AI trading bot. For extra security enable 2FA and make sure the domain is correct.">
    <meta name="keywords" content="Login, account, 2FA">
    
    <link rel="preconnect" href="https://fonts.gstatic.com">

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&amp;display=swap" rel="stylesheet">
    <!--Stylesheet-->

    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" />
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script> --}}

    <link rel="stylesheet" href="/assets/css/loginstyle.css">
        
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
<body>
    
    <!-- The Modal -->
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="loader"></div>
    </div>

    <div class="container">

        {{ $slot }}

    </div>
    {{--  TOAST area --}}
    <x-toast />

    <script>
        function onSuccess(googleUser) {
            console.log('Logged in as: ' + googleUser.getBasicProfile().getName());
        }
        function onFailure(error) {
            console.log(error);
        }
        function renderButton() {
            gapi.signin2.render('my-signin2', {
                'scope': 'profile email',
                'width': 240,
                'height': 50,
                'longtitle': true,
                'theme': 'dark',
                'onsuccess': onSuccess,
                'onfailure': onFailure
            });
        }


        // Function to open the modal

        // Function to open the modal
        function openModal() {
            var modal = document.getElementById("myModal");
            modal.style.display = "flex";
        }

        // Function to close the modal
        function closeModal() {
            var modal = document.getElementById("myModal");
            modal.style.display = "none";
        }


        // Hide the modal when the page loads
        window.onload = function () {
            closeModal();
        };

        // Hide the modal when the user returns to the page (e.g., using the back button)
        window.addEventListener('pageshow', function (event) {
            if (event.persisted) {  // true if the page was restored from the cache (back/forward navigation)
                closeModal();
            }
        });
    </script>

    <script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>
    @stack('scripts')
    @livewireScripts
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
</body>
</html>
