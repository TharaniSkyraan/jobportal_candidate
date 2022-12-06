@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => '{{ url("/login") }}'])
            <img src="{{ asset('/') }}sitesetting_images/thumb/{{ $siteSetting->site_logo }}" />
        @endcomponent
    @endslot
    {{-- Body --}}
    <h3>{{ ucwords($user_name) }} ,</h3>
    Dear {{ $user_name }} Your One Time Password(otp) "{{ $otp }}".<br><br>
    Regards,<br>
    {{ $siteSetting->site_name }}
    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ $siteSetting->site_name }}, All rights reserved
        @endcomponent
    @endslot
@endcomponent