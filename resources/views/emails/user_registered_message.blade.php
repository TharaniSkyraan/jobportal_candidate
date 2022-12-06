@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => '{{ url("/login") }}'])
            <img src="{{ asset('/') }}sitesetting_images/thumb/{{ $siteSetting->site_logo }}" />
        @endcomponent
    @endslot
    {{-- Body --}}
    <h3>Dear Admin ,</h3>
    Job Seeker with name "{{ $name }}" has been registered on "{{ $siteSetting->site_name }}"<br><br>
    <div style="text-align: center">
      <a href="{{ $link }}" class="button button-green">User Profile</a><br><br>
      <a href="{{ $link_admin }}" class="button button-green">Admin Link</a>
    </div>
    Regards,<br>
    {{ $siteSetting->site_name }}
    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ $siteSetting->site_name }}, All rights reserved
        @endcomponent
    @endslot
@endcomponent