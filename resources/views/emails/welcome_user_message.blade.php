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
                text-align:center !important;
                background-color: #ea4335 !important;
                border:none !important;
                font-size: 16px !important;
                font-weight: 500;
                padding: 12px 35px;
                border-radius: 30px !important;
                margin-top: -7px !important;
            }
            .button-gray{
                background-color: #817a7a !important; 
                padding: 2px 10px;
                border:none;
            }
            .text-center{
                text-align:center !important;
            }
            .text-right{
                text-align:right !important;
                margin: 30px;
                font-size:14px;
            }
            .text-left{
                text-align:left !important;
                margin: 30px;
                font-size:14px;
                font-weight: 500;
            }
            .body-content{
                text-align:left !important;
                margin: 30px;
                font-size: 18px;
                font-weight: 500;
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
                font-size:25px;
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
            .table thead th{
                border:none !important;
            }
            .body-header .table table{
                margin:none;
            }
            .table tbody td{
                line-height: 22px !important;
                font-size: 16px !important;
                font-weight: 600 !important;
                color: #000000 !important;
            }
            .table table{
                padding-bottom: 3%;        
                border-radius: 10px;
                padding: 0px 30px 0px 30px;
            }
            .expiry_date{
                
                font-size: 10px !important;
                font-weight: 500 !important;
                color: #817a7a !important;
            }
            
            .body-header .table img{
                width: 50% !important;
            }
            @media only screen and (max-width: 500px) {
                .body-header .table img{
                    width: 60% !important;
                }
            }
            @media only screen and (max-width: 400px) {
                .body-header .table img{
                    width: 85% !important;
                }
                .body-header .table table tbody td{
                    width: 40%;
                }

            }
        </style>
    @endslot
    {{-- Body --}}
    <div style="border-bottom: 2px #eee solid;" class="body-header">
        @component('mail::table')
        | | |
        | :--- | :--- |
        | <a href="https://mugaam.com/login"><img src="{{ asset('/') }}sitesetting_images/thumb/{{ $siteSetting->site_logo }}" style="width: 25%;margin-bottom: 20px;"/></a> | <a href="https://mugaam.com/">Jobs</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="https://mugaam.com/login"> Sign In</a> |
        @endcomponent
    </div>
    <p class="text-left">Hello  {{$name}},</p>
    <p class="title-content"><b>Welcome to Mugaam!</b></p>
    <p class="body-content">We're here to help you navigate the next steps in your job search with advice, resources and tools.</p>
    <p class="text-right"><a href="https://mugaam.com/" class="button button-blue">Let's Begin</a></p>
    <p class="text-left"><img src="{{ asset('/') }}images/welcome.png" style="width: 100%;margin-top: -30px;"/></p>
    <p style="border-top: 20px #eee solid;"></p>
    <p class="text-left">Looking for help? </p>
    <p class="title-content"><b>Mugaam's Career Guide is the best place to start.</b></p>   
    <p class="body-content">Find tips for getting the job and growing your career. Here are some recommendations to get going:</p>
    <p style="border-top: 1px #eee solid;margin: 30px;"></p>
   @component('mail::table')
    | | |
    | :--- | :--- |
    | <img src="{{ asset('/') }}images/1.svg"/> | <span style="font-size:14px;"> Search a job </span> <br> <span>Looking for a job while studying, fresher or experienced? in search of the right job. </span> <br><br>  |
    | <img src="{{ asset('/') }}images/2.svg"/> | <span style="font-size:14px;"> Find a job </span> <br> <span>Pick a job from the live list for your skill set.</span> <br><br>  |
    | <img src="{{ asset('/') }}images/3.svg"/> | <span style="font-size:14px;"> Get a job </span> <br> <span>Attend the scheduled job interview and you will be offered an interesting job position.</span> <br><br>  |
    @endcomponent
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


