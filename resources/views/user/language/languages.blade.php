@extends('layouts.app')

@section('custom_scripts')
<link href="{{asset('css/user_skill.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="wrapper" >
	@include('layouts.header')
	@include('layouts.side_navbar')

	<div class="main-panel main-panel-custom">
		<div class="content">
			<div class="page-inner">
                <div id="language_knwn" class="mt-4">
                    <div class="text-center ttleicn">
                        <h2 class="fw-bolder"><img src="{{asset('images/lang.png')}}">&nbsp;Languages Known</h2>
                    </div>

                    <div class="crdbxpl mt-5">
                        <div class="row">
                            <div class="col-5 col-md-7 px-4 align-self-center">Languages Known</div>
                            <div class="col-7 col-md-5 align-self-center text-end addSkills"><button class="btn openForm addbtn" type="button" data-form="new">Add Language +</button></div>
                        </div>
                    </div>
                </div>
                <div id="language_knwn1" class="mt-4">
                    <!-- Form Tag -->
                    <div class="append-card-language" id="append-card-language"></div>
                    <!-- End Form -->
                </div>
                
                <div id="language_knwn" class="mt-4">
                    <!-- Language List card-->
                    <div class="" id="language_div"></div>                        
                    <!-- Language List card end -->

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('custom_bottom_scripts')
<script type="text/javascript">
var baseurl = '{{ url("/") }}/';
</script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/user@ie3e2!/js/dashboard/ulang.!e52q)y6.js') }}"></script>
@endsection