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
          <h5>Rebasing the CPI: A Vital Step for
            Accuracy</h5>
          <p class="py-2">The rebasing of the CPI is a crucial step for ensuring inflation
            data reflects the current economic landscape. The previous
            base year failed to capture shifts in consumer behavior and
            market trends, which impacted the accuracy of the inflation
            data. The updated CPI methodology now includes a more
            representative basket of goods and services, improving the
            reliability of the inflation figures and providing policymakers
            with a better tool to gauge economic conditions.
          </br>
        </br>
          </p>
          <h5>Inflation Hits 24.48% in January 2025</h5>
          <p class="py-2">Nigeria’s headline inflation rate has decreased to 24.48%
            year-on-year in January 2025, following the rebasing of the
            Consumer Price Index (CPI), according to the National Bureau
            of Statistics (NBS). This new rate reflects a significant
            reduction from the previous 34.80% in December 2024,
            calculated using the old methodology. The adjustment in the
            CPI offers a more accurate picture of the country’s current
            economic conditions and consumer spending patterns,
            making the figures more reflective of the present-day reality.
            </p>
         


          <div class="div">
            <a href="/homeassets/files/inflationreport.pdf" style="color:#b2570e;">Download Full Report </a>
          </div>
        
        </div>
    </div>
    <div class="col-lg-4">
        <div class="about3-images-area">
        <img src="/homeassets/img/inflationimage.png" alt="">
        
        </div>
    </div>
    </div>
</div>
</div>
<!--===== ABOUT ENDS=======-->


@endsection