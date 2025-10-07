<!doctype html>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Divjules - Your Gateway to Quality Education</title>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
     <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }
        .hero-video-section {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
        }
        .hero-video-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 1;
        }
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.85) 0%, rgba(118, 75, 162, 0.85) 100%);
            z-index: 2;
        }
        .hero-content {
            position: relative;
            z-index: 3;
        }
        .sliding-text {
            animation: slideIn 1s ease-out forwards;
            opacity: 0;
        }
        @keyframes slideIn {
            from {
                transform: translateX(-100px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        .sliding-text:nth-child(1) { animation-delay: 0.2s; }
        .sliding-text:nth-child(2) { animation-delay: 0.4s; }
        .sliding-text:nth-child(3) { animation-delay: 0.6s; }
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        /* Video Modal */
        .video-modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            animation: fadeIn 0.3s ease;
        }
        .video-modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        /* Review Modal */
        .review-modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            animation: fadeIn 0.3s ease;
            overflow-y: auto;
        }
        .review-modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .review-modal-content {
            background: white;
            border-radius: 20px;
            padding: 40px;
            max-width: 600px;
            width: 100%;
            position: relative;
            animation: slideUp 0.3s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .video-modal-content {
            position: relative;
            width: 90%;
            max-width: 900px;
            animation: slideUp 0.3s ease;
        }
        @keyframes slideUp {
            from { transform: translateY(50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .video-close {
            position: absolute;
            top: -40px;
            right: 0;
            color: white;
            font-size: 35px;
            font-weight: bold;
            cursor: pointer;
            z-index: 10000;
        }
        .video-close:hover {
            color: #ccc;
        }
        /* Testimonial Slider */
        .testimonial-slider {
            position: relative;
        }
        .testimonial-slide {
            display: none;
        }
        .testimonial-slide.active {
            display: block;
        }
        /* Universities Slider */
        .universities-slider-container {
            overflow: hidden;
            padding: 20px 0;
            position: relative;
        }
        .universities-slider-track {
            animation: scroll 60s linear infinite;
            width: max-content;
            will-change: transform;
        }
        .universities-slider-track:hover {
            animation-play-state: paused;
        }
        @keyframes scroll {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-50%);
            }
        }
        /* Smooth transitions */
        .university-slide {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        /* Navigation buttons */
        .uni-nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            background: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        .uni-nav-btn:hover {
            background: #7c3aed;
            color: white;
            transform: translateY(-50%) scale(1.1);
            box-shadow: 0 6px 12px rgba(124, 58, 237, 0.3);
        }
        .uni-nav-btn.left {
            left: 10px;
        }
        .uni-nav-btn.right {
            right: 10px;
        }
        .uni-nav-btn i {
            font-size: 18px;
        }
        @media (max-width: 768px) {
            .uni-nav-btn {
                width: 45px;
                height: 45px;
            }
            .uni-nav-btn i {
                font-size: 16px;
            }
        }
        /* Add padding to parent for button visibility */
        .universities-slider-wrapper {
            padding: 0 80px;
            position: relative;
        }
        @media (max-width: 768px) {
            .universities-slider-wrapper {
                padding: 0 20px;
            }
        }
        /* Transparent Blur Header for Home Page */
        body nav {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        body nav .mobile-menu {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

         .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-gray-50">
        <livewire:home.layout.header />

        {{ $slot }}

    
        <livewire:home.layout.footer />


   
    @livewireScripts
    @stack('scripts')
    
</body>

</html>


       

    