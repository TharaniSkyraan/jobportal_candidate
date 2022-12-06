@extends('layouts.app')

@section('custom_scripts')

<link href="{{ asset('site_assets_1/assets/css/input_tag/jquery-ui.min.css')}}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/css/input_tag/jquery.tagsinput-revisited.css')}}" rel="stylesheet">	  
<link href="{{ asset('site_assets_1/assets/vendor/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/vendor/selectize/selectize.css')}}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/date_flatpicker/flatpickr.min.css')}}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/1a9ve2/css/userbasic.w2fr4ha2.css')}}" rel="stylesheet">
<script src="{{ asset('site_assets_1/assets/date_flatpicker/flatpickr.js')}}"></script>
<link href="{{asset('css/user_skill.css')}}" rel="stylesheet">

@endsection

@section('content')
<div class="wrapper" >
	@include('layouts.header')
	@include('demo.sidebar')

	<div class="main-panel main-panel-custom">
		<div class="content">
			<div class="page-inner">
                <div id="language_knwn" class="mt-4">
                    <div class="text-center ttleicn">
                        <h2 class="fw-bolder"><img src="{{asset('images/candidate_educ.png')}}">&nbsp;Languages Known</h2>
                    </div>

                    <table class="table mt-4 text-center">
                        <tr class="thtg">
                            <th>language</th>
                            <th>Proficiency Level</th>
                            <th>Read</th>
                            <th>Speak</th>
                            <th>Write</th>
                            <th></th>
                            <th></th>
                        </tr>

                        <tr class="rslt">
                            <td class="fw-bolder">English</td>
                            <td>Begineer</td>
                            <td><i class="fa fa-check"></i></td>
                            <td><i class="fa fa-check"></i></td>
                            <td><i class="fa fa-check"></i></td>
                            <td><i class="fa fa-edit"></i></td>
                            <td><i class="fa fa-trash"></i></td>
                        </tr>

                        <tr class="addrw">
                            <td><input type="text" class="form_cnt" placeholder="Language"></td>
                            <td>
                                <select name="" class="form_se" id="">
                                    <option value="">Proficiency</option>
                                </select>
                            </td>
                            <td>
                                <input type="checkbox">
                            </td>
                            <td>
                                <input type="checkbox">
                            </td>
                            <td>
                                <input type="checkbox">
                            </td>
                            <td colspan="2">
                                <button class="addbtn">Add +</button>
                            </td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>