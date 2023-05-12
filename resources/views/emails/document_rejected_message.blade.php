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
            td {
                padding:0px !important;
            }
            p{
                color : #000000bd !important;
            }
            .button-blue{
                background-color: #ea4335 !important;
                padding: 2px 10px;
                border:none !important;
                font-size:13px;
            }
            .button-gray{
                background-color: #817a7a !important; 
                padding: 2px 10px;
                border:none;
            }
            .text-center{
                text-align:center !important;
            }
            .text-left{
                text-align:left !important;
                margin: 30px;
                font-size:14px;
            }
            .title{
                font-size:18px;
                font-weight: 500;
                margin: 0px 25px;
                text-align:center !important;
                background-color: #4285f4 !important;
                padding: 10px;
                color:#fff !important;
            }
            .title-content{
                font-size:18px;
                text-align:left !important;
                font-weight: 500;
                margin: 30px;
            }
            .header{
                padding:32px!important
            }
            .footer{
                color: #54535c !important;
                font-weight: 500 !important;
                padding:32px !important
            }
            .footer-content{
                font-size: 14px;
                text-align:center !important;
                padding: 1.5rem 0rem;
                border-top: 2px #4285f4 solid;
                margin: 0px 30px;
            }
            .content{
                box-shadow: 2px 6px 15px 0 rgb(69 65 78 / 10%) !important;
            }   
            .company_name{
                font-size: 13px !important;
                color: #373737 !important;
            }
            .table tbody td{
                line-height: 22px !important;
                font-size: 12px !important;
                font-weight: 600 !important;
                color: #000000 !important;
            }
            .blue-color{
                /* color: #0060ff !important; */
            }
            .table table{
                padding-bottom: 3%;        
                border: 1px #4285f4 solid;
                border-radius: 10px;
                padding: 0px 0px 0px 5px;
            }
            @media only screen and (max-width: 500px) {
                .button {
                    width: unset !important;
                }
            }
        </style>
    @endslot
    {{-- Body --}}
    <div style="text-align: center;margin-bottom: 6px;">
        <a href="{{ url('/login') }}">
            <img src="{{ asset('/') }}sitesetting_images/thumb/{{ $siteSetting->site_logo }}" />
        </a>
    </div>
    <p class="title"><b>Document Rejected</b></p>
    <p class="title-content"><b>Hi {{$name}},</b></p>
    <p class="text-left"> Your uploaded document is not verified, kindly provide another document detail to move live the {{$title}} job you post on employer mugaam. Your job will be approve once you complete the Document verification process.</p>
    <p class="text-left"> To initiate the verification process please login <a href="{{$website_link}}">employer.mugaam.com</a> and follow the step-by-step instructions, or respond to this message with any one of the following document:</p>
    <p class="text-left"> <b>Document Verification : GST certificate / Company PAN</b>
        Excited to get started on your easy hiring journey on employer mugaam.</p>
    <p class="text-center">
        <a class="button button-blue" href="{{ $link }}">
            Upload Document
        </a>
    </p>
    <div class="footer-content">
        <span> <b> Contact us <b> </span>
        <span style="margin: 5px;">:</span>
        <span> <img src="{{ asset('/site_assets_1/assets/img/job_description/contact_message.png') }}" style="margin-bottom: -2px;width: 15px;"/> support@mugaam.com </span>
        <span style="margin: 5px;">|</span>
        <span> <img src="{{ asset('/site_assets_1/assets/img/job_description/contact_num.png') }}" style="margin-bottom: -2px;width: 15px;"/> +91 9876543210 </span>
    </div>
    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            You have received this mail because your e-mail ID
            is registered with employer.mugaam.com. This is a system-generated e-mail 
            regarding your account preferences, please don't reply to this message. 
            The jobs sent in this mail have been posted by the clients. <br> © {{ date('Y') }} {{ $siteSetting->site_name }}, All rights reserved
        @endcomponent
    @endslot
@endcomponent

