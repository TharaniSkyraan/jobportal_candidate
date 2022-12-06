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
    .button-blue{
        background-color: #3140BE !important;
        border-bottom: 8px solid #3140BE !important;
        border-left: 18px solid #3140BE !important;
        border-right: 18px solid #3140BE !important;
        border-top: 8px solid #3140BE !important;
    }
    .text-center{
        text-align:center !important;
        padding: 3% !important;
    }
    .title-content{
        font-size:18px;
        text-align:center !important;
        font-weight: 500;
        color : #000000b3 !important;
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
        font-size:10px;
        text-align:center !important;
        padding: 2rem;
    }
    .content{
        box-shadow: 2px 6px 15px 0 rgb(69 65 78 / 10%) !important;
    }
</style>
  @component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => '{{ url("/login") }}'])
             
        @endcomponent
    @endslot
    {{-- Body --}}
    <div style="text-align: center;background-color: #E9FBFF !important;margin-bottom: 2rem !important;">
        <a href="{{ url("/login") }}">
            <img src="{{ asset('/') }}sitesetting_images/thumb/{{ $siteSetting->site_logo }}" />
        </a>
    </div>
    <p class="title-content">Confirm your Account Creation</h3>
    <p class="text-center">Verify your login Email ID by clicking on the below link button.</p><br>
    <p class="text-center">
        <a class="button button-blue" href="{{ route('email-verification.check', $user->verification_token) . '?email=' . urlencode($user->email) }}">
           Verify Your Email ID
        </a>
    </p>
    <br>
    <p class="footer-content">You have received this mail because your e-mail ID is registered with 
    mugaam.com. This is a system-generated e-mail regarding your 
    account preferences, please don't reply to this message. 
    The jobs sent in this mail have been posted by the clients. 
    And we have enabled auto-login for your convenience, 
    you are strongly advised not to forward this email to protect your 
    account from unauthorized access. IEIL has taken all reasonable steps 
    to ensure that the information in this mailer is authentic. 
    Users are advised to research bonafides of advertisers independently. 
    Please do not pay any money to anyone who promises to find you a job. 
    IEIL shall not have any responsibility in this regard. 
    We recommend that you visit our Terms & Conditions and the Security 
    Advice for more comprehensive information.</p>
    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ $siteSetting->site_name }}, All rights reserved
        @endcomponent
    @endslot
@endcomponent
