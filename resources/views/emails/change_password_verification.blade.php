@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => '{{ url("/login") }}'])
        @endcomponent
        <style>
            .wrapper{
                background-color:#EEE !important
            }
            .body{
                background-color:#EEE !important;
            }  
            p{
                color : #000000bd !important;
            }
            .text-center{
                text-align:center !important;
            }
            .text-left{
                color: #808080 !important;
                line-height: 2em;
                text-align: left !important;
                margin: 30px;
                font-weight: 400;
                font-size: 16px;
            }
            .title-content{
                color: #000000bd !important;
                line-height: 1.5em;
                font-size: 18px;
                text-align: left !important;
                font-weight: 500;
                margin: 30px;
            }
            .footer{
                color: #54535c !important;
                font-weight: 500 !important;
                padding:32px !important
            }
            .footer-content{
                font-size: 14px;
                text-align: center !important;
                padding: 1.5rem 0rem;
                border-top: 1px #4285f4bf solid;
                margin: 0px 30px;
            }
            .top-banner{
                text-align: center;
                margin-bottom: 6px;
            }
            .top-banner img{
                width: 160px;
                padding: 10px;
            }
        </style>
    @endslot
    {{-- Body --}}
    <div class="top-banner">
        <a href="{{ url('/login') }}">
            <img src="{{ asset('/') }}sitesetting_images/thumb/{{ $siteSetting->site_logo }}" />
        </a>
    </div>
    <p class="title-content">{{ ucwords($user_name) }} ,</p>
    <p class="text-left"> {{ $user_name }} Your One Time Password(otp) <b>"{{ $otp }}"</b>.</p>
    <div class="footer-content">
         <span> <b> Contact us <b> </span>
         <span style="margin: 5px;">:</span>
        <span> <img src="{{ asset('/site_assets_1/assets/img/job_description/contact_message.png') }}" style="margin-bottom: -2px;width: 15px;"/> support@mugaam.com </span>
        <span style="margin: 5px;">|</span>
        <span> <img src="{{ asset('/site_assets_1/assets/img/job_description/contact_num.png') }}" style="margin-bottom: -2px;width: 15px;"/> +91 9900559924 </span>
     </div>
     {{-- Footer --}}
     @slot('footer')
         @component('mail::footer')
             You have received this mail because your e-mail ID
             is registered with mugaam.com. This is a system-generated e-mail 
             regarding your account preferences, please don't reply to this message. 
             The jobs sent in this mail have been posted by the clients. <br> © {{ date('Y') }} {{ $siteSetting->site_name }}, All rights reserved
         @endcomponent
     @endslot
@endcomponent