@extends('home.layout.layout')

@section('content')
<!--===== WELCOME STARTS=======-->
{{-- <div class="welcome-inner-section-area" style="background-image: url(/homeassets/assets/img/bacground/inner-bg.png); background-position: center; background-repeat: no-repeat; background-size: cover;">
      <img src="/homeassets/assets/img/elements/elementor40.png" alt="" class="elementor40 keyframe3 d-lg-block d-none">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 m-auto">
                    <div class="welcome-inner-header text-center">
                        <h1>Green <b class="defence">Realty</b></h1>
                        <a href="/">Home <span><i class="fa-light fa-angle-right"></i></span> Green Realty</a>
                        <img src="/homeassets/assets/img/elements/elementor20.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
  <!--===== WELCOME ENDS=======-->

<!--===== WELCOME STARTS =======-->
<div class="slider-carousel-area owl-carousel">
    <div class="welcome6-section-area">
        <img src="/homeassets/img/green2.jpg" alt="" class="homepage6-bg" style="z-index:1">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="welcome6-header-area py-5">
                         <h1 data-aos="fade-left" data-aos-duration="900"></h1>
                        <p data-aos="fade-left" data-aos-duration="1000"></p>
                    </div>
                </div>
                <div class="col-lg-2"></div>
                <div class="col-lg-4" >
                    <div class="welcome6-elements-area">
                        <div class="polygon-author aniamtion-key-1" style="background-image: url(assets/img/elements/elementor33.svg); background-position: center; background-repeat: no-repeat; background-size: cover; display: inline-block;">
                            <div class="polygon-arrow">
                                <!-- <span><a href="contact1.html"><i class="fa-regular fa-arrow-right"></i></a></span>
                                <a href="contact1.html">Free Case Review</a> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="welcome6-section-area">
      
        <img src="/homeassets/img/green1.jpg" alt="" class="homepage6-bg" style="z-index:1">
      
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="welcome6-header-area py-5">
                        <h1 data-aos="fade-left" data-aos-duration="900"></h1>
                        <p data-aos="fade-left" data-aos-duration="1000"></p>
                        
                    </div>
                </div>
                <div class="col-lg-2"></div>
                <div class="col-lg-4" >
                    <div class="welcome6-elements-area">
                        <div class="polygon-author aniamtion-key-1" style="background-image: url(assets/img/elements/elementor33.svg); background-position: center; background-repeat: no-repeat; background-size: cover; display: inline-block;">
                            <div class="polygon-arrow">
                                <!-- <span><a href="contact1.html"><i class="fa-regular fa-arrow-right"></i></a></span>
                                 <a href="contact1.html">Free Case Review</a> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
</div>
<!--===== WELCOME ENDS =======-->

<!--===== ABOUT STARTS=======-->
<div class="about3-section-area about-inner" id="about">
<div class="container">
    <div class="row align-items-center">
    <div class="col-lg-6">
        <div class="about3-textarea">
            <span>GREEN REALTY</span>
            <h5>Certari Urban aims to provide turn-key solutions by developing design strategies
            that accommodate the long-term impact on the environment.</h5>

            <h5>Building sustainable housing using sustainable products for our rural communities across Nigeria and Africa at large.</h5>
            <div class="about3-pera-text">
                 <p>We have deep insight and understanding of the issues and challenges posed by many properties on the environment. Our expertise and flexibility allow us to consider investing in situations other investors may not. Our eco-friendly initiatives build on the two SDG goals below</p>
            </div>
           
        </div>
    </div>
    <div class="col-lg-6">
        <div class="about3-images-area">
        <img src="/homeassets/img/bamboo1.jpg" alt="">
        
        </div>
    </div>
    </div>
</div>
</div>
<!--===== ABOUT ENDS=======-->

<!--===== SERVICES STARTS =======-->
   <div class="service3-section-area sp1">
    <div class="container">
      <div class="row">
        <div class="col-lg-12" data-aos="zoom-out" data-aos-duration="1000">
          <div class="service-navs-area">
            <div class="row align-items-center">
              <div class="col-lg-6">
                <div class=" foter-carousel">
                  <div class="hero13-single-slider img5">
                    <img src="/homeassets/img/green1.jpg" height="100%" alt="">
                  </div>

                  <div class="hero13-single-slider img5">
                    <img src="/homeassets/img/solar1.jpg" height="100%" alt="">
                    
                  </div>

                 

              </div>
            </div>
            <div class="col-lg-6">
             <div class=" slider-nav1">
              <div class="testimonial-listarea">
                <h4>AFFORDABLE & CLEAN ENERGY</h4>
                <div class="service-pera1">
                  <p> Ensure access to affordable, reliable, sustainable, and modern energy for all.</p>
                 </div>
                 
              </div>

              <div class="testimonial-listarea">
                 <h4>SUSTANABLE CITIES & COMMINITIES</h4>
                 <div class="service-pera1">
                  <p> Ensure access to adequate, safe, and affordable housing built using sustainable
                    and eco-friendly building practices.</p>
                 </div>
              </div>

              
             </div>
             <div class="testimonial-arrows">
              <div class="testimonial-prev-arrow1">
                <button><i class="fa-solid fa-arrow-left"></i></button>
              </div>
              <div class="testimonial-next-arrow1">
                <button><i class="fa-solid fa-arrow-right"></i></button>
              </div>
            </div>
            </div>
            </div>
          </div>
        </div>
      </div>
     </div>
  </div>
<!--===== SERVICES ENDS =======-->

@endsection