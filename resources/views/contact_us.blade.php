@extends('layouts.app')
@section('custom_scripts')
<title>Mugaam - Contact Us</title>
<link href="{{ asset('site_assets_1/assets/css/static_css.css') }}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/css/contactus.css') }}" rel="stylesheet">
@endsection
@section('content')
@include('layouts.header')
<div id="content-wrap">
    <div class="main mt-3">
        <div class="container panel panel-default mb-5">
            <form id="contact-form">
                {{-- <div class="row"> --}}
                <div class="row flex-column-reverse flex-md-row">
                    <div class="col-xl-5 col-lg-6 col-md-6 col-sm-12 col-12 contactinf">
                        <h3>Contact Information</h3>
                        <div class="d-flex mt-4 mb-3">
                            <span class="m-3">
                                <img draggable="false" src="{{asset('images/m_svg/call.svg')}}" class="phone-img border-radius-10 contact-icons" alt="...">
                            </span>
                            <span class="my-3">
                                <div class='fdwq'>Phone</div> <br>
                                <a href="tel://+91-9900559924">+91-9900559924</a>
                            </span>                               
                        </div>
                        <div class="d-flex email mb-3">
                            <span class="m-3">
                                <img draggable="false" src="{{asset('images/m_svg/mail.svg')}}" class="email-img border-radius-10 contact-icons" alt="...">
                            </span>
                            <span class="my-3">
                                <div class='fdwq'>Email</div> <br>
                                <a href="mailto:contact@mugaam.com">contact@mugaam.com</a>
                            </span> 
                        </div>
                        <div class="d-flex">                        
                            <span class="m-3">
                                <img draggable="false" src="{{asset('images/m_svg/location.svg')}}" class="address-img border-radius-10 contact-icons" alt="...">
                            </span>
                            <span class="my-3">
                                <div class='fdwq'>Address</div> <br>
                                <a href="javascript:void(0)" class="cursor-default"> Hari Complex, 207/A3, Sathy Rd, opp. Prozone Mall, Saravanampatti, Coimbatore, Tamil Nadu 641035</a>
                            </span>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 contactdet">
                        <div id="success"></div>
                        <h3>Send us a message</h3>
                        <div class="row">
                            <!-- Name input -->
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-6 col-12">
                                <div class="form-group mb-3">
                                    <input class="form-control" id="name" type="text" placeholder="Name" name="name"
                                        value="{{old('name')}}" autocomplete="off" required />
                                    <span class="text-danger" id="name-error"></span>

                                </div>
                            </div>

                            <!-- Email address input -->
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-6 col-12">
                                <div class="form-group mb-3">
                                    <input class="form-control" id="email" type="text" name="email"
                                        placeholder="Email Address" value="{{old('email')}}" autocomplete="off" required/>
                                    <span class="text-danger" id="email-error"></span>
                                </div>
                            </div>
                        </div>
                        <!-- Subject input -->
                        <div class="form-group mb-3">
                            <input class="form-control" id="subject" type="text" name="subject"
                                placeholder="Subject" value="{{old('subject')}}" autocomplete="off" required/>
                            <span class="text-danger" id="subject-error"></span>
                        </div>
                        <!-- Message input -->
                        <div class="form-group mb-4">
                            <textarea class="form-control" id="message" type="text" name="message"
                                placeholder="Message" style="height:8rem !important;" value="{{old('message')}}"
                                autocomplete="off" required></textarea>
                            <span class="text-danger" id="message-error"></span>
                        </div>
                        <!-- Form submit button -->
                        <div class="d-grid" style="cursor:pointer">
                            <button class="btn search-button-bg" type="submit" id="msearch_btn">Send Message</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('footer')
    @include('layouts.footer')
@endsection

@push('scripts')
<script type="text/javascript">
$(document).ready(function() {
    {{-- $(".alert-dismissible").hide(); --}}
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#contact-form').on('submit', function(event) {
    event.preventDefault();
    $('#name-error').text('');
    $('#email-error').text('');
    $('#subject-error').text('');
    $('#message-error').text('');

    name = $('#name').val();
    email = $('#email').val();
    subject = $('#subject').val();
    message = $('#message').val();

    $.ajax({
        url: "{{route('contact.insert')}}",
        type: "POST",
        data: {
            name: name,
            email: email,
            subject: subject,
            message: message,
        },
        success: function(response) {
            if (response) {
                $('.alert-dismissible').addClass('alert alert-success alert-dismissible fade show');
                $(".alert-dismissible").show();
                $('#success').html('<div class="alert alert-success alert-dismissible fade show" role="alert">'
                                +'<span id="success-message">Send Message Successfully.!</span>'
                                +'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
                            +'</div>');
                            
                $("#success").animate({scrollTop: $(window).scrollTop(0)},"slow");
                $("#contact-form")[0].reset();
            }
        },
        error: function(response) {
            $('#name-error').text(response.responseJSON.errors.name);
            $('#email-error').text(response.responseJSON.errors.email);
            $('#subject-error').text(response.responseJSON.errors.subject);
            $('#message-error').text(response.responseJSON.errors.message);
        }
    });
});
</script>
@endpush