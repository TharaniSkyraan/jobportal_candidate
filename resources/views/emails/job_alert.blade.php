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
                font-weight: 500;
                font-size: 16px;
            }
            .title{
                font-size: 25px;
                font-weight: 400;
                text-align: center !important;
                background-color: transparent !important;
                padding: 30px 10px 0px 10px;
                color: #5f5f5f !important;
                width: fit-content;
                margin: 0 auto;
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
                text-align: center !important;
                padding: 1.5rem 0rem;
                border-top: 1px #4285f4bf solid;
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
                margin: 15px auto !important;
                width: 100%;              
            }
            .expiry_date{
                
                font-size: 10px !important;
                font-weight: 500 !important;
                color: #817a7a !important;
            }
            
            .body-header .table tbody td{
                font-size: 16px !important;
            }
            .body-header .table table{
                margin:unset !important;
            }
            @media only screen and (max-width: 500px) {
                .button {
                    width: unset !important;
                }
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
            .apply-button{
                display: flex;
                font-weight: 600;
                font-size: 14px;
                text-decoration: unset;
                color: #0b872a !important;
                width: 55%;
                padding: 5px 0px;
                place-content: center;
            }
            .apply-button img{
                filter: invert(76%) sepia(30%) saturate(3461%) hue-rotate(111deg) brightness(127%) contrast(91%) !important;
                margin-right :5px
            }
        </style>
    @endslot    
    {{-- Body --}}
    <div style="border-bottom: 2px #eee solid;" class="body-header">
        @component('mail::table')
        | | |
        | :--- | :--- |
        | <a href="https://mugaam.com/login"><img draggable="false" src="{{ asset('/') }}sitesetting_images/thumb/{{ $siteSetting->site_logo }}" style="width: 25%;margin-bottom: 20px;"/></a> | <a href="https://mugaam.com/">Jobs</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="https://mugaam.com/login"> Sign In</a> |
        @endcomponent
    </div>
    <p class="title"><b>Job Alert !</b></p>
    <p class="text-center"><img draggable="false" src="{{ asset('/') }}images/mail/applyjob.jpg" style="width: 65%;"/></p>
    <p class="text-left"><b>These job ads match your saved job alert. </p>
    @php $jobcount = ($limit!=count($jobs))?count($jobs):count($jobs)-1;@endphp
    @foreach ($jobs as $key => $job)
        @if($key<$jobcount)
            @component('mail::table')
            | <th colspan="3"><a><span style="text-decoration: underline;">{{ $job->title }} </span><br><span class="company_name">{{ $job['company_name'] }}</span></a> | | | |
            |:--| :-- | :-- | :-- |
            | | <img draggable="false" src="{{ asset('/site_assets_1/assets/img/side_nav_icon/experience.png') }}" style="margin-bottom: -2px;width: 15px;"/> {{ $job['experience']}} |<img draggable="false" src="{{ asset('/site_assets_1/assets/img/side_nav_icon/salary.png') }}" style=" margin-bottom: -2px;width: 15px;"/> {{ $job['salary']??'1-3 Lakh / Annum'}}</span> |
            | <td colspan="3" style="padding: 10px 0px 10px 0px !important;"><img draggable="false" src="{{ asset('/site_assets_1/assets/img/side_nav_icon/location.png') }}" style=" margin-bottom: -2px;width: 15px;"/>{{$job['location']}}<td> |
            | | <a href="{{ url('/detail')}}/{{$job->slug}}" class="apply-button"><img draggable="false" src="{{ asset('/') }}images/mail/apply.svg"/>Apply now</a> |
            | <td colspan="3"><span style="color:#8a8a8a;padding-top:10px;"> Posted On : {{ MiscHelper::timeSince($job->posted_date) }} <span><td> |
            @endcomponent
            @if($key<($jobcount-1))
            <hr style="width:85%;border: 0;border-top: 1px solid #dee2e6;">
            @endif
        @else
        <p class="text-left">
            <a class="" style="color: #2b2b9c;text-decoration: unset;" href="{{ url('/') }}/{{$slug}}">
                View More jobs for {{$jobalert->title}}
            </a>
        </p>        
        @endif
    @endforeach
   <div class="footer-content">
        <span> <b> Contact us <b> </span>
        <span style="margin: 5px;">:</span>
       <span> <img draggable="false" src="{{ asset('/site_assets_1/assets/img/job_description/contact_message.png') }}" style="margin-bottom: -2px;width: 15px;"/> support@mugaam.com </span>
       <span style="margin: 5px;">|</span>
       <span> <img draggable="false" src="{{ asset('/site_assets_1/assets/img/job_description/contact_num.png') }}" style="margin-bottom: -2px;width: 15px;"/> +91 9900559924 </span>
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