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
              <h5>NIGERIA: INFLATION DECLINES IN FEBRUARY AS NEW CPI FRAMEWORK TAKES EFFECT</h5>
              </br>
              <div class="div">
                <a href="/homeassets/files/febreport.pdf" style="color:#b2570e;">Download Full Report </a>
              </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="about3-images-area">
              <img src="/homeassets/img/febreport.jpg" alt="">
            </div>
        </div>
      </div>
  </div>
</div>
<!--===== ABOUT ENDS=======-->


@endsection