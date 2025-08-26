@extends('home.layout.layout')

@section('content')
<!--===== WELCOME STARTS=======-->
<div class="welcome-inner-section-area mt-5 contact-bg" style="padding:250px 0px!important;">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 m-auto">
                <div class="welcome-inner-header text-center">
                    <h1><b class="defence"></b></h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!--===== WELCOME ENDS=======-->

<!--===== WELCOME STARTS=======-->
<div class="welcome-inner-section-area" style="background-image: url(/homeassets/assets/img/contactnewimage.jpg); background-position: center; background-repeat: no-repeat; background-size: cover;     padding: 59px 0 57px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 m-auto">
                <div class="welcome-inner-header text-center">
                    <h1>Contact <span class="defence">Us</span></h1>
                    {{-- <a href="/">Home <span><i class="fa-light fa-angle-right"></i></span> Contact Us</a> --}}
                </div>
            </div>
        </div>
    </div>
</div>
<!--===== WELCOME ENDS=======-->

<!--===== CONTACT STARTS =======-->
<div class="contact1-section-area sp1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="contact-auhtor-area">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="contact-submit-area">
                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                <h3>Send Us A Message</h3>
                                <form action="{{ route('home.contactform') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="contact-inner">
                                                <input type="text" placeholder="First Name"  name="firstname" value="{{ old('name') }}" required>
                                            </div>
                                            @error('firstname')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="contact-inner">
                                                <input type="text" placeholder="Last Name" name="lastname" value="{{ old('lastname') }}" required>
                                            </div>
                                            @error('lastname')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="contact-inner">
                                                <input type="number" placeholder="Phone Number" name="phonenumber" value="{{ old('phonenumber') }}" required>
                                            </div>
                                            @error('phonenumber')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="contact-inner">
                                                <input type="email" placeholder="Email Address" name="email" value="{{ old('email') }}" required>
                                            </div>
                                            @error('email')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="contact-inner">
                                                <textarea placeholder="Message" cols="30" rows="10" name="message" required></textarea>
                                            </div>
                                            @error('message')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="contact-inner">
                                            <button type="submit">Send Message<i class="fa-light fa-arrow-right"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="contact-widget-area">
                                <div class="clock-img">
                                    <img src="/homeassets/assets/img/icons/clock1.svg" alt="">
                                </div>
                                <div class="content">
                                    <h4>Contact Us</h4>
                                    <a href="#">1st Floor, Rock Towers, Rock Drive, Lekki Phase 1, Lagos, Nigeria.</a>
                                </div>
                            </div>
                            <div class="space20"></div>
                            <div class="contact-widget-area">
                                <div class="clock-img">
                                    <img src="/homeassets/assets/img/icons/phone2.svg" alt="">
                                </div>
                                <div class="content">
                                    <h4>Call or text</h4>
                                    <a href="+234(0)8083425374">+234(0)8104533228</a>
                                </div>
                            </div>
                            <div class="space20"></div>
                            <div class="contact-widget-area">
                                <div class="clock-img">
                                    <img src="/homeassets/assets/img/icons/email2.svg" alt="">
                                </div>
                                <div class="content">
                                    <h4>Email us today</h4>
                                    <a href="enquiry@certarigroup.com">enquiry@certarigroup.com</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="space60"></div>
            <div class="col-lg-12">
                <div class="map-section-area">
                    <div class="mapouter">
                        <div class="gmap_canvas">
                          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4950.645276260915!2d3.4697089749922085!3d6.439479593551766!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x103bf44d2419cc2b%3A0xa23ac6cacd532099!2sThe%20Rock%20Tower!5e1!3m2!1sen!2sng!4v1723685298448!5m2!1sen!2sng" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                      </div>    
                </div>
            </div>
        </div>
    </div>
</div>
<!--===== CONTACT STARTS =======-->
@endsection