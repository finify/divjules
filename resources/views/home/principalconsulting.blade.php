@extends('home.layout.layout')

@section('content')
<!--===== WELCOME STARTS=======-->
  <div class="welcome-inner-section-area mt-5" style="background-image: url(/homeassets/img/about2.webp); background-position: center; background-repeat: no-repeat; background-size: cover; padding-top:300px;">
      {{-- <img src="/homeassets/assets/img/elements/elementor40.png" alt="" class="elementor40 keyframe3 d-lg-block d-none"> --}}
        <div class="container">
            <div class="row">
                <div class="col-lg-3 m-auto">
                    <div class="welcome-inner-header text-center">
                        <h1><b class="defence"></b></h1>
                        {{-- <img src="/homeassets/assets/img/elements/elementor20.png" alt=""> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
  <!--===== WELCOME ENDS=======-->

  <!--===== ABOUT STARTS =======-->
  <div class="about1-section-area " id="about">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6">
            <img src="/homeassets/img/principal1.webp" alt="">
        </div>

        <div class="col-lg-6">
          <div class="about-textarea-section">
            <!-- <span  data-aos="fade-left" data-aos-duration="600">About Us</span> -->
            <h3 data-aos="fade-left" data-aos-duration="800">We offer expertise, resources & guidelines to help our clients
            (Certarians) succeed in their industry.</h3>
            <p data-aos="fade-left" data-aos-duration="900">Our specialization covers a variety of sectors such as project management, finance, insurance, and sustainable real estate ecosystems.</p>
           
            <a href="#" class="welcome6-btn">What We Offer</a>
          </div>
        </div>
      </div>
    </div>
  </div>
<!--===== ABOUT ENDS =======-->



<!--===== ABOUT STARTS =======-->
<div class="about4-scetion-area cta5-section-area sp4" style="background-image: url(/homeassets/img/aboutimage.jpg); background-position: center; background-size: cover; background-repeat: no-repeat;">
  <div class="container">
    <div class="row align-items-center py-3">
      <div class="service7-header-area text-center">
            <h2 data-aos="fade-up" data-aos-duration="1000" class="text-white">
                What We Offer
            </h2>
        </div>
    </div>
    <div class="row align-items-center">
      <div class="col-lg-12">
        <div class="about4-all-boxarea">
          <div class="about4-single-boxarea" data-aos="fade-up" data-aos-durationduration="800" data-aos-easing="linear">
            {{-- <img src="assets/img/elements/elementor27.png" alt="" class="elementors27 aniamtion-key-1"> --}}
            <div class="check-icons">
              <img src="/homeassets/img/check-img3.svg" alt="">
            </div>
            <div class="about4-single-content-area">
              <a href="#">Direct Private Investing</a>
              <p> We enable you to invest alongside like-minded financial institutions and family offices. Our dedicated direct private investment team sources these exclusive opportunities from Certari's global institutional network and third-party sponsors. We also connect you directly to the financial sponsor or corporate issuer, equipping you with access to conduct your extensive due diligence on each transaction.</p>
            </div>
          </div>

          <div class="about4-single-boxarea" data-aos="fade-up" data-aos-duration="1000" data-aos-easing="linear">
            <div class="check-icons">
              <img src="/homeassets/img/check-img3.svg" alt="">
            </div>
            <div class="about4-single-content-area">
              <a href="#">Strategic Investing</a>
              <p> We invest on behalf of our clients to acquire strategic advantages by leveraging market intelligence & direction rather than simply financial outcomes to achieve the desired return.</p>
            </div>
          </div>

          <div class="about4-single-boxarea" data-aos="fade-up" data-aos-duration="1200" data-aos-easing="linear">
            <div class="check-icons">
              <img src="/homeassets/img/check-img3.svg" alt="">
            </div>
            <div class="about4-single-content-area">
              <a href="#">Impact Investing</a>
              <p> As a partner to our clients, our focus is long-term sustainability. We aim to be responsible corporate citizens and take ESG that has authentic and quantifiable financial impacts over the long term for our firm and the firms in which we invest. Long-term responsibility and sustainability are crucial to our business model and how we serve our clients, together with strategies that span the full spectrum of asset classes.</p>
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>
</div>
<!--===== ABOUT ENDS =======-->
@endsection