@extends('home.layout.layout')

@section('content')

<!--===== WELCOME STARTS=======-->
<div class="welcome-inner-section-area mt-5" style="background-image: url(/homeassets/img/bg2.webp); background-position: center; background-repeat: no-repeat; background-size: cover; padding-top:200px;">
    {{-- <img src="/homeassets/assets/img/elements/elementor40.png" alt="" class="elementor40 keyframe3 d-lg-block d-none"> --}}
    <div class="container">
        <div class="row">
            <div class="col-lg-3 m-auto">
                <div class="welcome-inner-header text-center">
                    <h1><b class="defence"></b></h1>
                    <a href="/"><span><i class="fa-light fa-angle-right"></i></span></a>
                    {{-- <img src="/homeassets/assets/img/elements/elementor20.png" alt=""> --}}
                </div>
            </div>
        </div>
    </div>
</div>
<!--===== WELCOME ENDS=======-->

<!--===== ABOUT STARTS=======-->
<div class="about3-section-area about-inner mt-2 pt-5" id="about">
    <div class="container">
        <div class="row align-items-center">
        <div class="col-lg-8">
            <div class="about3-textarea">
            <span>Article</span>
            <h2>Welcome to Certari Asset Management Limited.</h2>
            </br>
            <p class="fs-5">At Certari, we're driven by a commitment to excellence, innovation and delivering superior risk-
                adjusted returns. We understand that your investment goals are unique. Our approach provides
                tailored strategies to build long-term wealth, optimising your portfolio for every stage of your
                financial journey.
                We invite you to partner with us and experience the Certari diﬀerence:
            </br>
            </br>
                </p>
                <ul style="list-style: disc !important; padding-left: 20px; line-height: 1.3em; list-style-type: disc !important; , margin-bottom: 20px;">
                    <li style="margin-bottom: 10px; list-style: disc !important;"><strong style="font-weight: bold !important; display: inline;">Strategic Investment Opportunities:</strong> We identify and capitalise on opportunities in the evolving market landscape.</li>
                    <li style="margin-bottom: 10px; list-style: disc !important;"><strong style="font-weight: bold !important; display: inline;">Rigorous Risk Management:</strong> We employ robust risk mitigation strategies to safeguard your investments.</li>
                    <li style="margin-bottom: 10px; list-style: disc !important;"><strong style="font-weight: bold !important; display: inline;">Cost Efficiency:</strong> We strive to minimise costs, maximising your returns.</li>
                </ul>

                <p class="fs-5 mt-5">Thank you for entrusting Certari Asset Management with your financial future.</p>
                <p class="fs-5">We look forward to building a prosperous partnership together.</p>
                <p class="fs-5 mt-5">
                    <strong class="fs-4" style="font-weight: bold !important; display: inline;">IVIE OMOROGBE</strong><br>
                    Managing Director<br>
                    Certari Asset Management Limited
                </p>
            
            
            </div>
        </div>
        <div class="col-lg-4">
            <div class="about3-images-area">
            <img src="/homeassets/img/welcomeimage.png" alt="">
            
            </div>
        </div>
        </div>
    </div>
</div>
<!--===== ABOUT ENDS=======-->


@endsection