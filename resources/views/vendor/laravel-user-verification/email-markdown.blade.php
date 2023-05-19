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
        text-align:center !important;
        padding: 1.5rem 0rem;
        border-top: 2px #4285f4 solid;
        margin: 0px 30px;
        font-size: 14px;
    }
    .content{
        box-shadow: 2px 6px 15px 0 rgb(69 65 78 / 10%) !important;
    }
    .table{
        padding: 0% 5% !important;
    }
    .table thead th{
        font-weight: 500 !important;
        color: #0060ff !important;
        text-align:left !important;
        line-height: 30px !important;
        border : none !important;
        font-size: 20px !important;
    }
    .table tbody td{
        line-height: 22px !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        color: #000000 !important;
    }
    .expiry_date{            
        font-size: 10px !important;
        font-weight: 500 !important;
        color: #817a7a !important;
        margin: -15px 30px 30px !important;
    }
    .otp{
        font-weight: bold;
        font-size: 16px !important;
        border: 1px #4285f4 solid;
        padding: 2px 10px;
        border-radius: 5px;
    }
</style>
  @component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => '{{ url("/login") }}'])
             
        @endcomponent
    @endslot
    <div style="text-align: center;margin-bottom: 6px;">
        <a href="{{ url('/login') }}">
            <img src="{{ asset('/') }}sitesetting_images/thumb/{{ $siteSetting->site_logo }}" />
        </a>
    </div>
    <p class="title" style=""><b>OTP For Secure Signup</b><br></p>    
    <p class="text-left">Please use the one-time-password below for secure signup.</p>
    <p class="text-center">
        <span class="otp">{{ $user->verify_otp }}</span>
    </p>
    <p class="text-left expiry_date">This code is valid for 5 minutes.</p>
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
            is registered with mugaam.com. This is a system-generated e-mail 
            regarding your account preferences, please don't reply to this message. 
            The jobs sent in this mail have been posted by the clients. <br> © {{ date('Y') }} {{ $siteSetting->site_name }}, All rights reserved
        @endcomponent
    @endslot
@endcomponent
