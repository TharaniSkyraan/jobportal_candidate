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
                background-color: #4285f4 !important;
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
                color: #474242 !important;
                line-height: 2em;
                text-align: left !important;
                margin: 30px;
                font-weight: 400;
                font-size: 16px;
            }
            
            .title{
                font-size: 25px;
                font-weight: 400;
                border-bottom: 1px dotted;
                text-align: center !important;
                background-color: transparent !important;
                padding: 30px 10px 30px 10px;
                color: #5f5f5f !important;
                width: fit-content;
                margin: 0 auto;
                border-color: #5692f5ba;
            }
            .title-content{
                color: #000000bd !important;
                line-height: 1.5em;
                font-size: 18px;
                text-align: left !important;
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
                border-top: 1px #4285f4 solid;
                margin: 0px 30px;
            }
            .table{
                padding: 0% 5% !important;
            }
            .table thead th{
                border-bottom: 1px solid #edeff2;
                margin: 0;
                padding-bottom: 8px;
                color: #0060ff !important;
                text-align: left !important;
                line-height: 30px !important;
                border: none !important;
                font-size: 18px !important;
                /* text-decoration: underline; */
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
                border: none;
                /* border-bottom: 1px #eee solid; */
                border-radius: 0px;
                padding: 0px 0px 0px 5px;
                margin: 30px auto;
                width: 100%;
            }
            .expiry_date{                
                font-size: 10px !important;
                font-weight: 500 !important;
                color: #817a7a !important;
            }
            @media only screen and (max-width: 500px) {
                .button {
                    width: unset !important;
                }
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
    <p class="title"><b>New Candidate Received</b></p>
    <p class="title-content"><b>Hi {{$company_name}},</b></p>
    <p class="text-left"><b>{{$user_name}}</b> has applied for the below job post. You will find their(His/Her) information through the given link. </p>
    @component('mail::table')
    | <th colspan="3"><b>{{ $job->title??'Android Developer Fresher Android Developer Fresher'}} | | | |
    |:--| :-- | :-- | :-- |
    | | <img src="{{ asset('/site_assets_1/assets/img/side_nav_icon/experience.png') }}" style="margin-bottom: -2px;width: 15px;"/> {{ $job->experience_string??'0 - 3 years'}} |<img src="{{ asset('/site_assets_1/assets/img/side_nav_icon/salary.png') }}" style=" margin-bottom: -2px;width: 15px;"/> {{ $job->salary_string??'1-3 Lakh / Annum'}}</span> |
    | <td colspan="3" style="padding: 10px 0px 10px 0px !important;"><img src="{{ asset('/site_assets_1/assets/img/side_nav_icon/location.png') }}" style=" margin-bottom: -2px;width: 15px;"/> {{ $job->work_locations?rtrim($job->work_locations, ", "):'Coimbatore'}} <td> |
    @endcomponent
    <p class="text-center">
        <a class="button button-blue" href="{{ $user_link }}">
            View profile
        </a>
    </p>
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
            is registered with employer.mugaam.com. This is a system-generated e-mail 
            regarding your account preferences, please don't reply to this message. 
            The jobs sent in this mail have been posted by the clients. <br> © {{ date('Y') }} {{ $siteSetting->site_name }}, All rights reserved
        @endcomponent
    @endslot
@endcomponent