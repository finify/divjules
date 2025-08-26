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
          <h3>Nigeria 2025 Economic Outlook: A Concise Summary </br></br>
          <strong>Global Economic Landscape:</strong></h3>
            <ul class="py-2" style="list-style: disc !important; padding-left: 20px; line-height: 1.3em; list-style-type: disc !important; margin-bottom: 20px;">
              <li style="margin-bottom: 10px; list-style: disc !important;">The global economy is showing resilience with a 3.2% growth rate in 2024, driven by the US and large developing economies in Asia.</li>
              <li style="margin-bottom: 10px; list-style: disc !important;">Rising public debt, geopolitical tensions, and potential health emergencies pose challenges.</li>
              <li style="margin-bottom: 10px; list-style: disc !important;">Global trade is expected to reach $32 trillion by the end of 2024, with a decrease in global inflation.</li>
              <li style="margin-bottom: 10px; list-style: disc !important;">Key risks include rising public debt, ongoing conflicts, and potential disruptions to trade flows.</li>
          </ul>
          <h3>Nigerian Economic Overview:</h3>
          <ul class="py-2" style="list-style: disc !important; padding-left: 20px; line-height: 1.3em; list-style-type: disc !important; margin-bottom: 20px;">
            <li style="margin-bottom: 10px; list-style: disc !important;">Nigeria's economy grew at a modest 3.09% in 2024, driven by the service sector.</li>
            <li style="margin-bottom: 10px; list-style: disc !important;">The agricultural sector and industry experienced slower growth due to various challenges.</li>
            <li style="margin-bottom: 10px; list-style: disc !important;">Inflation has been on the rise, triggered by domestic policy changes, global energy shocks, and supply-driven factors.</li>
            <li style="margin-bottom: 10px; list-style: disc !important;">Unemployment remains a concern, with official figures potentially underestimating the true extent of the problem.</li>
          </ul>
          <h3>Key Sectoral Highlights:</h3>
          <ul class="py-2" style="list-style: disc !important; padding-left: 20px; line-height: 1.3em; list-style-type: disc !important; margin-bottom: 20px;">
            <li style="margin-bottom: 10px; list-style: disc !important;">The oil and gas industry is undergoing a transformation, with indigenous companies taking on a more prominent role.</li>
            <li style="margin-bottom: 10px; list-style: disc !important;">The telecom sector has experienced a decline in foreign investment, but challenges persist.</li>
            <li style="margin-bottom: 10px; list-style: disc !important;">The financial system is grappling with a cash scarcity paradox, despite an increase in currency in circulation.</li>
            <li style="margin-bottom: 10px; list-style: disc !important;">Fuel prices continue to rise, despite the commissioning of new refineries.</li>
            <li style="margin-bottom: 10px; list-style: disc !important;">The NGX ASI achieved a 37.65% gain in 2024, demonstrating resilience amidst market volatility.</li>
          </ul>
          <h3>2025 Outlook and Policy Implications:</h3>
          <ul class="py-2" style="list-style: disc !important; padding-left: 20px; line-height: 1.3em; list-style-type: disc !important; margin-bottom: 20px;">
            <li style="margin-bottom: 10px; list-style: disc !important;">The 2025 budget projects revenue of N34.8 trillion and expenditure of N47.9 trillion, with a focus on non-oil revenue and capital expenditure.</li>
            <li style="margin-bottom: 10px; list-style: disc !important;">Tax reforms aim to simplify the tax system and streamline tax collection.</li>
            <li style="margin-bottom: 10px; list-style: disc !important;">The return of Donald Trump to the US presidency could have significant implications for Nigeria's economy, particularly in trade, investment, and exchange rates.</li>
          </ul>
          <h3>Key Takeaways:</h3>
          <ul class="py-2" style="list-style: disc !important; padding-left: 20px; line-height: 1.3em; list-style-type: disc !important; margin-bottom: 20px;">
            <li style="margin-bottom: 10px; list-style: disc !important;">The global and Nigerian economies present both opportunities and challenges.</li>
            <li style="margin-bottom: 10px; list-style: disc !important;">Inflation, unemployment, and debt remain key concerns.</li>
            <li style="margin-bottom: 10px; list-style: disc !important;">Sectoral performance is mixed, with some sectors showing resilience and others facing headwinds.</li>
            <li style="margin-bottom: 10px; list-style: disc !important;">The 2025 budget and tax reforms signal policy direction, but their success hinges on addressing underlying challenges.</li>
            <li style="margin-bottom: 10px; list-style: disc !important;">The impact of US policies under Trump's presidency needs careful monitoring and mitigation strategies.</li>
          </ul>
          <ul>
            <li>This summary provides a high-level overview of the key economic trends and policy developments. It is important to consult the full report for a more in-depth understanding of the issues and their potential impact on business decisions.</li>
          </ul>

         
        </div>
        <div class="div">
          <a href="/contact" style="color:#b2570e;">Click here for full report </a>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="about3-images-area">
        <img src="/homeassets/img/shiftingimage.png" alt="">
        
        </div>
    </div>
    </div>
</div>
</div>
<!--===== ABOUT ENDS=======-->


@endsection