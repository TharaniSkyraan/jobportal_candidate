
@extends('layouts.app')

@section('custom_styles')
<style>
section{
    padding: 120px 0;
    overflow: hidden;
    background: #fff;
    position: relative;
}
</style>
@endsection
@section('custom_scripts')        
    <link href="{{ asset('site_assets_1/assets/css/static_css.css') }}" rel="stylesheet">
@endsection
@section('content')

    @include('layouts.header')

    <section class="about-style-01">
        <div class="container border-bottom border-color-extra-light-gray mb-1-9 mb-lg-6 pb-5 pb-1-9 pb-lg-6">
            <div class="row align-items-center mt-n2-9">
                <div class="col-lg-6 mt-2-9">
                    <div class="pe-xl-2-5">
                        <div class="row g-3">
                            <div class="col-8">
                                <img draggable="false" src="{{url('site_assets_1/assets/images/static_pages//about-01.jpg')}}" class="border-radius-10" alt="...">
                            </div>
                            <div class="col-4 mt-2-9 mt-sm-11 mt-md-16 mt-lg-9 mt-xl-2-5 mt-xxl-6" style="margin-top:60px;">
                                <div class="about-image-wrapper">
                                    <img draggable="false" src="{{url('site_assets_1/assets/images/static_pages//about-02.jpg')}}" class="border-radius-10" alt="...">
                                    <div class="position-absolute start-50 top-50 translate-middle">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="about-image">
                                    <img draggable="false" src="{{url('site_assets_1/assets/images/static_pages//about-03.jpg')}}" class="border-radius-10" alt="...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-2-9 pe-3">
                    <div class="about-right ps-xl-1-6 ps-xxl-2-9">
                        <h2 class="mb-4 text-capitalize">We Care About Your Life For Better Future.</h2>
                        <p class="mb-4">The mugaam.com has a process where even a senior experienced job position and fresher's job requirements can also be listed for free. One of the unique features to say in Mugaam.com is that job aspirants and employers can achieve their job needs without paying a single penny to the site.</p>
                        <div class="row   mb-1-9 pb-1-9">
                            <div class="col-md-6 mb-4 mb-md-0">
                                <h4 class="mb-3"><span>01</span>What We Believe</h4>
                                <p class="mb-0">We always proceeds with chances of creating new job opportunities and enrolling new candidates within the company.</p>
                            </div>
                            <div class="col-md-6">
                                <h4 class="mb-3"><span>02</span>What We Offer</h4>
                                <p class="mb-0">We allow employers to post jobs, filter the needed skill resume, allocate interviews, shortlist candidates for the next round, mark the final interview and so on.</p>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-5">
            <div class="row mt-n1-9">
                <div class="col-6 col-lg-3 mt-1-9 text-center text-sm-start">
                    <div class="d-sm-flex align-items-center mb-4">
                        <div class="flex-shrink-0 mb-3 mb-sm-0">
                            <img draggable="false" src="{{url('site_assets_1/assets/images/static_pages//icon-22.png')}}" alt="...">
                        </div>
                        <div class="flex-grow-1 border-sm-start border-color-extra-light-gray ps-sm-3 ps-xl-4 ms-sm-3 ms-xl-4">
                            <h3 class="countup h1 text-primary fw-bold mb-1">1327</h3>
                            <span class="text-muted">Jobs Posted</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 mt-1-9 text-center text-sm-start">
                    <div class="d-sm-flex align-items-center">
                        <div class="flex-shrink-0 mb-3 mb-sm-0">
                            <img draggable="false" src="{{url('site_assets_1/assets/images/static_pages//icon-23.png')}}" alt="...">
                        </div>
                        <div class="flex-grow-1 border-sm-start border-color-extra-light-gray ps-sm-3 ps-xl-4 ms-sm-3 ms-xl-4">
                            <h3 class="countup h1 text-primary fw-bold mb-1">150</h3>
                            <span class="font-weight-500 text-muted">Jobs Filled</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 mt-1-9 text-center text-sm-start">
                    <div class="d-sm-flex align-items-center">
                        <div class="flex-shrink-0 mb-3 mb-sm-0">
                            <img draggable="false" src="{{url('site_assets_1/assets/images/static_pages//icon-24.png')}}" alt="...">
                        </div>
                        <div class="flex-grow-1 border-sm-start border-color-extra-light-gray ps-sm-3 ps-xl-4 ms-sm-3 ms-xl-4">
                            <h3 class="countup h1 text-primary fw-bold mb-1">220</h3>
                            <span class="font-weight-500 text-muted">Companies</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 mt-1-9 text-center text-sm-start">
                    <div class="d-sm-flex align-items-center">
                        <div class="flex-shrink-0 mb-3 mb-sm-0">
                            <img draggable="false" src="{{url('site_assets_1/assets/images/static_pages//icon-25.png')}}" alt="...">
                        </div>
                        <div class="flex-grow-1 border-sm-start border-color-extra-light-gray ps-sm-3 ps-xl-4 ms-sm-3 ms-xl-4">
                            <h3 class="countup h1 text-primary fw-bold mb-1">2250</h3>
                            <span class="font-weight-500 text-muted">Candidates</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-img cover-background" data-overlay-dark="5" data-background="img/bg/bg-01.jpg"  style="background-image: url('{{asset('site_assets_1/assets/images/static_pages//bg-01.jpg')}}');">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="bg-white-opacity p-1-9 border-radius-10">
                        <h2 class="h3 mb-3 text-capitalize fw-bold">Find Talent From The Featured Ones For Your Dream Job</h2>
                        <p class="mb-4">The Jobseeker future is set with minimum job assurance for fresher's here in Mugaan.com and isn't available on any other web portal sites with the required "skill set" alone taken into consideration. In short,<b> one's job searching foil ends here on mugaam.com job site</b>.</p>
                        <a href="{{ route('index') }}" class="butn text-decoration-none">Get Started</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-very-light-gray">
        <div class="container">
            <div class="section-heading">
                <h2 class="fw-bold">Our Best Services For You</h2>
                <p>Know your really worth and find the job that qualify your life.</p>
            </div>
            <div class="row mt-n1-9">
                <div class="col-md-6 col-lg-4 mt-1-9  mb-4">
                    <div class="service-wrapper">
                        <div class="service-icons">
                            <img draggable="false" src="{{url('site_assets_1/assets/images/static_pages//icon-19.png')}}" alt="...">
                        </div>
                        <h4 class="h5 mb-3 fw-bold">Job Search</h4>
                         <p class="mb-0 w-90 mx-auto">Looking for a job while studying, fresher or experienced? in search of the right job.</p> 
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mt-1-9  mb-4">
                    <div class="service-wrapper">
                        <div class="service-icons">
                            <img draggable="false" src="{{url('site_assets_1/assets/images/static_pages//icon-20.png')}}" alt="...">
                        </div>
                        <h4 class="h5 mb-3 fw-bold">Display Jobs</h4>
                         <p class="mb-0 w-90 mx-auto">Pick a job from the live list for your skill set.<br><br></p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mt-1-9  mb-4">
                    <div class="service-wrapper">
                        <div class="service-icons">
                            <img draggable="false" src="{{url('site_assets_1/assets/images/static_pages//icon-18.png')}}" alt="...">
                        </div>
                        <h4 class="h5 mb-3 fw-bold">Achieve Your Dream Job</h4>
                         <p class="mb-0 w-90 mx-auto">Attend the scheduled job interview and you will be offered an interesting job position.</p> 
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('footer')
    @include('layouts.footer')
@endsection

@push('scripts')
<script type="text/javascript" src="{{ asset('site_assets_1/assets/vendor/jquery/jquery.min.js') }}"></script>

  <script>
    $('.countup').each(function () {
    $(this).prop('Counter',0).animate({
        Counter: $(this).text()
    }, {
        duration: 3000,
        easing: 'swing',
        step: function (now) {
            $(this).text(Math.ceil(now));
        }
    });
});
  </script>
  @endpush


