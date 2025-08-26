<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <!--=====TITLE=======-->
    <title>Certari | Home</title>

    <!--=====FAV ICON=======-->
    <link rel="shortcut icon" href="/homeassets/img/certarifavicon.svg" />

    <!--=====CSS=======-->
    <link rel="stylesheet" href="/homeassets/assets/css/plugins/bootstrap.min.css" />
    <link rel="stylesheet" href="/homeassets/assets/css/plugins/fontawesome.css" />
    <link rel="stylesheet" href="/homeassets/assets/css/plugins/sidebar.css" />
    <link rel="stylesheet" href="/homeassets/assets/css/plugins/aos.css" />
    <link rel="stylesheet" href="/homeassets/assets/css/plugins/mobile.css" />
    <link rel="stylesheet" href="/homeassets/assets/css/plugins/nice-select.css" />
    <link rel="stylesheet" href="/homeassets/assets/css/plugins/owl.carousel.min.css" />
    <link rel="stylesheet" href="/homeassets/assets/css/plugins/modal-video.min.css" />
    <link rel="stylesheet" href="/homeassets/assets/css/plugins/slick-slider.css" />
    <link rel="stylesheet" href="/homeassets/assets/css/typography.css" />
    <link rel="stylesheet" href="/homeassets/assets/scss/master.css" />

    <!--=====JQUERY=======-->
    <script src="/homeassets/assets/js/plugins/jquery-3-6-0.min.js"></script>
    <script src="/homeassets/assets/js/plugins/waypoints.js"></script>
<!-- Using <link> in HTML -->
<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <style>
        .Polygon2 {
            position: fixed;
            top: 0;
            right: -100%;
            /* Start position off the screen to the right */
            width: 100%;
            height: auto;
            transform: rotate(-25deg);
            /* Adjust the angle as needed */
            animation: slideIn 5s infinite alternate;
        }

        @keyframes slideIn {
            from {
                right: -100%;
            }

            to {
                right: 0;
            }
        }



        .glass {
            z-index: 1;
            /* animation: animate-to 2.4s 4s ease-in-out, animate-back 1.5s 6.4s ease-in-out; */
            animation: animate-glass 3.9s 4s ease-in-out infinite alternate;
            min-height: 100vh;
            left: -450px;
            position: absolute;
            top: 0;
            width: 450px;
            /* opacity: 0.5; */
            clip-path: polygon(30% 0, 100% 0%, 70% 100%, 0% 100%);
            background: linear-gradient(103.85deg, rgba(0, 0, 0, 0) 24.64%, rgba(255, 255, 255, 0.2) 42.66%, rgba(255, 255, 255, 0.2) 48.89%, rgba(255, 255, 255, 0.2) 55.09%, rgba(0, 0, 0, 0) 73.99%), rgba(255, 255, 255, 0.1);
            opacity: 0.5;
            box-shadow: inset -1px 0 4px #FFFFFF, inset 1px 0 4px #FFFFFF;
        }

        @keyframes animate-glass {

            0%,
            100% {
                left: -450px;
            }

            54%,
            65% {
                left: calc(100%);
            }
        }


        .video-background {
            position: relative;
            overflow: hidden;
            width: 100%;
            height: 50vh;
        }

        .video-background video {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100%;
            /* 100vh * 16/9 aspect ratio */
            height: 100vh;
            transform: translate(-50%, -50%);
            z-index: 1;
        }

        .content-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            /* Dark overlay */
            z-index: 2;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            text-align: center;
            color: white;
            padding: 0px 40px;
        }

        .contact-bg {
            background-image: url(/homeassets/img/contactnewimage.jpg);
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            padding-top: 300px;
        }

        @media (max-width: 768px) {
            .contact-bg {
                background-image: url(/homeassets/img/contactnewimage.jpg);
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
                padding-top: 300px;
            }
            .video-background video {
                width: 100vw;
                height: 100%;
                /* 100vw * 9/16 aspect ratio */
                scale: 176%;
                transform: translate(-50%, -30%);
            }

            .video-background {

                height: 400px;
            }
        }

        .btn-new {
            color: #ffffff;
            font-family: ARIAL, sans-serig;
            font-size: 16px;
            font-style: normal;
            font-weight: 600;
            line-height: 16px;
            display: inline-block;
            transition: all 0.4s ease-in-out;
            border-radius: 4px;
            background: #aa5515;
            padding: 18px 24px;
            position: relative;
            z-index: 1;
        }
        
        .blog-text{
            font-family: 'Poppins',sans-serif !important;
        }
    </style>
</head>

<body class="inner-pages">
    <!-- Main Header-->
    @include('home.layout.header')
    <!--End Main Header -->

    @yield('content')

    @include('home.layout.footer')



    <!--=====JS=======-->
    <script src="/homeassets/assets/js/plugins/bootstrap.min.js"></script>
    <script src="/homeassets/assets/js/plugins/fontawesome.js"></script>
    <script src="/homeassets/assets/js/plugins/counter.js"></script>
    <script src="/homeassets/assets/js/plugins/owl-carousel.min.js"></script>
    <script src="/homeassets/assets/js/plugins/jquery-modal.min.js"></script>
    <script src="/homeassets/assets/js/plugins/sidebar.js"></script>
    <script src="/homeassets/assets/js/plugins/jquery.nice-select.js"></script>
    <script src="/homeassets/assets/js/plugins/aos.js"></script>
    <script src="/homeassets/assets/js/plugins/slider.js"></script>
    <script src="/homeassets/assets/js/plugins/mobilemenu.js"></script>
    <script src="/homeassets/assets/js/main.js"></script>
</body>

</html>