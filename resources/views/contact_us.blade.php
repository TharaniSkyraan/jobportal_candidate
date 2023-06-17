
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
        .contact-icons {
            width: 50px;
            height: 50px;
            background: #ea4335;
            color: #fff;
            padding: 13.5px 16px;
            align-items: center;
            justify-content: center;
            display: inline-flex;
            border-radius: 30px;
            font-size: 22px !important;
        }
        .fa-paper-plane{
            padding: 13.5px 12px !important;
        }
        .fa-map-marker{
           padding: 13.5px 18px !important;
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
            <div class="card mt-5">
                <div class="row m-3">
                </div>
                <form id="contact-form">
                    <div class="row mx-3">
                        <div class="col-md-5" style="padding-left:6%">

                            <div class="d-flex mt-5 mb-4">
                                <span class="m-3">
                                    <i class="fa fa-phone contact-icons"></i>
                                </span>
                                <span class="fw-bold my-3">Phone <br>
                                    <a href="tel://+91-9900559924">+91-9900559924</a>
                                </span>                               
                            </div>
                            <div class="d-flex mb-4">
                                <span class="m-3">
                                    <i class="fa fa-paper-plane contact-icons"></i>
                                </span>
                                <span class="fw-bold my-3">Email <br>
                                    <a href="mailto:contact@mugaam.com">contact@mugaam.com</a>
                                </span> 
                            </div>
                            <div class="d-flex mb-4">                        
                                <span class="m-3">
                                    <i class="fa fa-globe contact-icons"></i>
                                </span>
                                <span class="fw-bold my-3">Website <br>
                                    <a href="https://www.mugaam.com/">www.mugaam.com</a>
                                </span>
                            </div>
                            <div class="d-flex">                        
                                <span class="m-3">
                                    <i class="fa fa-map-marker contact-icons"></i>
                                </span>
                                <span class="fw-bold my-3">Address <br>
                                    <a href=""> Hari Complex, 207/A3, Sathy Rd, opp. Prozone Mall, Saravanampatti, Coimbatore, Tamil Nadu 641035</a>
                                </span>
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
                    </div>
                </form>
            </div>
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