@extends('layouts.pages.common_app')

@section('custom_scripts')
<link href="{{ asset('site_assets_1/assets/vendor/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/css/input_tag/jquery-ui.min.css')}}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/css/input_tag/jquery.tagsinput-revisited.css')}}" rel="stylesheet">	  
<link href="{{ asset('site_assets_1/assets/vendor/selectize/selectize.css')}}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/1a9ve2/css/userbasic.w2fr4ha2.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('site_assets_1/assets/date_flatpicker/flatpickr.min.css')}}">
<script src="{{ asset('site_assets_1/assets/date_flatpicker/flatpickr.js')}}"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>
@endsection
@section('title') Mugaam - My Education Page @endsection

@section('content')
<style>
ul.typeahead.dropdown-menu {
    max-height: 188px !important;
    overflow: auto;
    display: block;
    margin-right: 16px;
    width: -webkit-fill-available;
}
.location ul.typeahead.dropdown-menu {
    top:unset !important
}
/* .select2-container .select2-search__field {
   z-index: 99999;
} */
</style>
<div class="wrapper" >
        
	@include('layouts.header.auth.dashboard_header')
	@include('layouts.sidenavbar.side_navbar')

	<div class="main-panel main-panel-custom">
		<div class="content">
			<div class="page-inner">
                <div id="my_eductin" class="mt-4">
                    <div class="text-center ttleicn">
                        <h2 class="fw-bolder"><img draggable="false" src="{{asset('images/sidebar/experience.svg')}}">&nbsp;My Eduaction</h2>
                    </div>
                    @php
                        $eduLevels = App\Helpers\DataArrayHelper::langEducationlevelsArray();
                        $eduLevelids = App\Model\UserEducation::whereUserId(Auth::user()->id)->pluck('education_level_id')->toArray();
                    @endphp
                    @foreach ($eduLevels as $key => $eduLevel)  
                    <div class="educationAdd_{{$key}}  {{ (!in_array($key, $eduLevelids)) ? 'crdbxpl' : 'crdbxless' }} mt-4 {{ (in_array($key, $eduLevelids) && ($key!=1 || $key!=2))? '' : 'openForm' }}" data-education-level-id="{{$key}}" type="button" data-form="new">
                        <div class="row">
                            <div class="col-10 px-5">{{ $eduLevel }}</div>
                            <div class="col-2 align-self-center">
                            @if(in_array($key, $eduLevelids) && ($key!=1 || $key!=2)) @else <i class="fa fa-plus"></i>@endif</div>
                        </div>
                    </div>                    
                    {{-- <div class="educationListAdd_{{$key}} educationListAdd mb-4 form-empty"></div>   --}}
                    @php
                        $educations = App\Model\UserEducation::whereUserId(Auth::user()->id)->where('education_level_id',$key)->get();
                    @endphp
                    <div id="educationList_{{$key}}"></div>
                    @endforeach

                </div>  
            </div>
        </div>
    </div>
</div>

<!-- Button trigger modal -->
<div class="modal fade educationForm" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-scrollable">
    <div class="modal-content education-form">
           
    </div>
  </div>
</div>

@endsection
@push('scripts')
<script type="text/javascript" src="{{ asset('site_assets_1/assets/vendor/select2/select2.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js" integrity="sha512-HWlJyU4ut5HkEj0QsK/IxBCY55n5ZpskyjVlAoV9Z7XQwwkqXoYdCIC93/htL3Gu5H3R4an/S0h2NXfbZk3g7w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
var baseurl = '{{ url("/") }}/';
</script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/user@ie3e2!/js/dashboard/uedu!eu@21.js') }}"></script>
@endpush