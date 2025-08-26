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
          <h5>Macroeconomic Update: March 2024 Monetary Policy Rate (MPR)</h5>
          <h6>CBN Maintains Tight Monetary Policy Rate </h6>
          </br>
          <p>In a bid to fight inflation, the Nigeria Central  Bank significantly raised its key interest rate (MPR) for the tenth consecutive time. The  Monetary Policy Committee (MPC) Increased the MPR by 200 basis points (bps) to a record high of 24.75 at its meeting on March 26th, 2024.
          </br>
          </br>
            This move aims to curb inflation by making borrowing more expensive. Additionally, the MPC adjusted the symmetric corridor around the MPR to +100/300 bps. However, other parameters like the cash reserve ratio (45%) and liquidity ratio remained unchanged. </p>


          <div class="div">
            <a href="/homeassets/files/MPR-MARCH.pdf" style="color:#b2570e;">Click Here For More Information </a>
          </div>
        
        </div>
    </div>
    <div class="col-lg-4">
        <div class="about3-images-area">
        <img src="/homeassets/img/graph2.webp" alt="">
        
        </div>
    </div>
    </div>
</div>
</div>
<!--===== ABOUT ENDS=======-->


@endsection