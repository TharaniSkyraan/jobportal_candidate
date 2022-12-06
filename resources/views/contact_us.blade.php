
@extends('layouts.app')

@section('custom_scripts')
    <link href="{{ asset('site_assets_1/assets/css/static_css.css') }}" rel="stylesheet">
    <style>
        .search-button-bg{
            background-color: #4285F4;
            color: #fff;
        }
        .search-button-bg:hover{
            background-color: #4285F4;
            color: #fff;
            opacity: 1;
        }
        .search-button-bg:focus{
            box-shadow: 0 0 0 2px #fff, 0 0 0 3px #2557a7f2 !important; 
        }
        </style>
@endsection
@section('content')

@include('layouts.header')

<section class="page-title-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <h1 class="mb-4 fw-bold ">Contact Us</h1>
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="page-title-list">
                            <ol class="breadcrumb d-inline-block mb-0">
                                <li class="breadcrumb-item d-inline-block"><a href="{{ route('index') }}" class="fw-bold" style="color: #1e2022;font-size: 16px;">Home</a></li>
                                <li class="breadcrumb-item d-inline-block active"><a class="text-primary " style="font-weight:bold;">Contact Us</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="content-wrap">
    <div class="main">


        <div class="container panel panel-default mb-5">


            <form id="contact-form">


                <div class="card mt-5">
                    <div class="row mb-4">
                        <div class="row mt-5">
                            <div class="col-md-4">
                                <div class="dbox w-100 text-center">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <span class="fa fa-phone"></span>
                                    </div>
                                    <div class="text mb-5">
                                        <p class="h5"><span class="fw-bold">Phone:</span> <a href="tel://+91-987654321">+91-987654321</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-5">
                                <div class="dbox w-100 text-center">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <span class="fa fa-paper-plane"></span>
                                    </div>
                                    <div class="text">
                                        <p class="h5"><span class="fw-bold">Email:</span> <a
                                                href="mailto:contact@mugaam.com">contact@mugaam.com</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-5">
                                <div class="dbox w-100 text-center">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <span class="fa fa-globe"></span>
                                    </div>
                                    <div class="text">
                                        <p class="h5"><span class="fw-bold">Website:</span> <a href="https://www.mugaam.com/">www.mugaam.com</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-7" style="padding:1rem 4rem;">
                            <div id="success"></div>
                            <h3>Send us a message</h3>
                            <div class="row">
                                <!-- Name input -->
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="name">Name</label>
                                        <input class="form-control" id="name" type="text" placeholder="Name" name="name"
                                            value="{{old('name')}}" autocomplete="off" />
                                        <span class="text-danger" id="name-error"></span>

                                    </div>
                                </div>

                                <!-- Email address input -->
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="emailAddress">Email Address</label>
                                        <input class="form-control" id="email" type="text" name="email"
                                            placeholder="Email Address" value="{{old('email')}}" autocomplete="off" />
                                        <span class="text-danger" id="email-error"></span>

                                    </div>
                                </div>
                            </div>
                            <!-- Subject input -->
                            <div class="form-group mb-3">
                                <label class="form-label" for="subject">Subject</label>
                                <input class="form-control" id="subject" type="text" name="subject"
                                    placeholder="Subject" value="{{old('subject')}}" autocomplete="off" />
                                <span class="text-danger" id="subject-error"></span>

                            </div>
                            <!-- Message input -->
                            <div class="form-group mb-5">
                                <label class="form-label" for="message">Message</label>
                                <textarea class="form-control" id="message" type="text" name="message"
                                    placeholder="Message" style="height:8rem !important;" value="{{old('message')}}"
                                    autocomplete="off"></textarea>
                                <span class="text-danger" id="message-error"></span>

                            </div>
                            <!-- Form submit button -->
                            <div class="d-grid" style="cursor:pointer">
                                <button class="btn search-button-bg" type="submit" id="msearch_btn">Send
                                    Message</button>
                            </div>
                        </div>
                        <div class="col-md-5 d-flex align-items-stretch" >
                            <div class="info-wrap w-100 p-5 img" style="background-image:url('site_assets_1/assets/images/static_pages/contact_banner_image.jpg')">
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