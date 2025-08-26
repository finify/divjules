@extends('home.layout.layout')

@section('content')

<!--===== WELCOME STARTS=======-->
<div class="welcome-inner-section-area mt-5"
  style="background-image: url(/homeassets/img/whistle.webp); background-position: center; background-repeat: no-repeat; background-size: cover; padding-top:200px;">
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
          <span>We value your Policies.</span>
          <h4>Whistle Blowing at Certari Group</h4>
          </br>
          <p>
            The Board and Management of Certari Asset Management remain committed to the principle of sound corporate
            governance and behavior as enunciated in the CBN Code of Corporate Governance for Banks and Other Financial
            Institutions in Nigeria. In line with our Risk Management Framework, Certari has put in place a
            Whistleblowing System. Over the years we have stayed committed to ethical and fair business conduct, and we
            encourage all our stakeholders, such as our Employees, Shareholders, Clients, Contractors, Vendors, and
            Regulators, to disclose actual, potential, or suspected instances of misconduct.
          </p>

          <p>
            Our collective commitments as stated in the Global Code of Conduct, specific to anti-bribery and corruption,
            include:
          </p>

          <p>Act lawfully, ethically and in the public interest; We do not tolerate behavior within, and similar acts
            linked to Certari, by clients or suppliers, or public officials with whom we deal, that is illegal,
            unethical or breaches human rights.</br>
            Accepting and offering bribes or participate in corrupt practices. We have a zero tolerance for bribery
            and corruption in any form by any party; and we keep a high standard of ethical conduct with our clients
            around the world.
          </p>

          <h4>Who can make a report?</h4>
          <p>
            Any person with a valid reason can make a report. All reports must be based on facts, and any allegations
            contained in it must be true and verifiable.
          </p>

          <h4>
            Non-acceptable Misconduct
          </h4>

          <ul style="list-style:circle !important; font-size: 16px">
            <li>Fraudulent/Illegal Conduct</li>
            <li>Unethical Conduct</li>
            <li>Internal Procedural Breach</li>
            <li>Regulatory Compliance Breach</li>
            <li>Health & Safety Risks</li>
            <li>Abuse of Office</li>
            <li>Misuse of Company Resources</li>
            <li>Willful Negligence</li>
            <li>Misconducts can be disclosed via any of the following channels</li>
          </ul>

          </br>
          <p>
            Report and state your claims: enquiry@certarigroup.com
          </p>

          <div class="about3-pera-text">
              <p class="mt-1"> <b>For Enquiries </b></br>
Misconducts can be disclosed via any of the following channels. Report and state your claims enquiry@certarigroup.com
              </br></br>
Questions, comments and requests regarding this privacy policy are welcomed and should be addressed to;
enquiry@certarigroup.com</p>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
<!--===== ABOUT ENDS=======-->


@endsection