@extends('email_2.layouts.email_template')
@section('content')

@php
if(auth('company')->check()){
$link = route('company.email-verification.check', $user->verification_token);
}elseif(auth()->check()){
$link = route('email-verification.check', $user->verification_token);
}else{
$link=route('login');
}
@endphp
<table border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center" class="title">
            <span>Confirm your Email ID</span>
        </td>
    </tr>
    <tr>
        <td align="center"> <span class="content-wrapper">Click on the below button to confirm your login email ID </span></td>
    </tr>
    <tr> <!-- class="subtitle" -->
        <td align="center">
            <a class="button" href="{{ $link . '?email=' . urlencode($user->email??'') }}">Confirm Email ID</a>
        </td>
    </tr>
    <tr>
        <td align="center" class="subtitle">
            <span>You have received this mail because your e-mail ID is registered with mugaam.com. This is a system-generated e-mail regarding your account preferences, please don't reply to this message. The jobs sent in this mail have been posted by the clients. And we have enabled auto-login for your convenience, you are strongly advised not to forward this email to protect your account from unauthorized access. IEIL has taken all reasonable steps to ensure that the information in this mailer is authentic. Users are advised to research bonafides of advertisers independently. Please do not pay any money to anyone who promises to find you a job. IEIL shall not have any responsibility in this regard. We recommend that you visit our Terms & Conditions and the Security Advice for more comprehensive information.</span>
        </td>
    </tr>
</table>
@endsection