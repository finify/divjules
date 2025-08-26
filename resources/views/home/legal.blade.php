@extends('home.layout.layout')

@section('content')

<!--===== WELCOME STARTS=======-->
<div class="welcome-inner-section-area mt-5"
  style="background-image: url(/homeassets/img/bg2.webp); background-position: center; background-repeat: no-repeat; background-size: cover; padding-top:200px;">
  {{-- <img src="/homeassets/assets/img/elements/elementor40.png" alt=""
    class="elementor40 keyframe3 d-lg-block d-none"> --}}
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

<!--===== ABOUT STARTS=======-->
<div class="about3-section-area about-inner mt-2 pt-5" id="about">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-12">
        <div class="about3-textarea">
          <h4>Legal Policies</h4>
          </br>
          <p>
            The content provided on this website is for information purposes only.
            Certari Group is not responsible for and explicitly disclaims, all liability for damages of any kind arising out of the use, reference to or reliance on any information contained within the website.
            Although the Certari Group website may include links with direct access to other internet resources/websites, it is not responsible for the accuracy or content of the information listed on these sites.
            Links from the Certari Group website to third party websites do not constitute an endorsement by Group of those parties or their products and services.
          </p>


          <div class="about3-pera-text">
              <p class="mt-1"> <b>For Enquiries </b></br>
                Questions, comments and requests regarding this privacy policy are welcomed and should be addressed to;
                enquiry@certarigroup.com.</p>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
<!--===== ABOUT ENDS=======-->


@endsection