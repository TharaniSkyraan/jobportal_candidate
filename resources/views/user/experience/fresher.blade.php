@extends('layouts.app')
@section('content')
<div class="wrapper" >
	@include('layouts.dashboard_header')
	@include('layouts.side_navbar')

	<div class="main-panel main-panel-custom">
		<div class="content">
			<div class="page-inner">
                <div id="my_expernce" class="mt-4">
                    <div class="text-center ttleicn">
                        <h2 class="fw-bolder"><img draggable="false" src="{{asset('images/sidebar/experience.svg')}}">&nbsp;My Experience</h2>
                    </div>

                    <h2 class="mt-5 mb-3 text-center fw-bolder">I am</h2>
                    @php
                        $user = Auth::user();
                    @endphp
                    {!! Form::open(array('method' => 'post', 'route' => array('employementstatus-update'))) !!}
                        <div class="row text-center">
                            <div class="col-md-6 col-6">
                                <input class="employment_status" type="radio" id="fresher" name="employment_status" style="display:none" value="fresher" checked>
                                <label for="fresher">
                                    <div class="levtstge_fre">
                                    </div>
                                    <div class="text-center fw-bolder mt-3">A Fresher</div>
                                </label>
                            </div>
                            <div class="col-md-6 col-6">
                                <input class="employment_status" type="radio" id="experienced" name="employment_status" style="display:none" value="experienced">
                                <label for="experienced">
                                    <div class="levtstge_exp">
                                    </div>
                                    <div class="text-center fw-bolder mt-3">A Experienced</div>
                                </label>
                            </div>
        
                            <div class="gap-2 justify-content-md-around pt-5 submit-button" style="display:none">
                                <button class="btn btn-submit btn_c_s text-white w-75" type="submit">Continue</button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>

    function checkstatus()
    {
        if($("input[name='employment_status']:checked").val()=='fresher'){
            $('.levtstge_fre').addClass('checked');
            $('.levtstge_exp').removeClass('checked');
            $('.submit-button').hide();
        }else
        
        if($("input[name='employment_status']:checked").val()=='experienced'){
            $('.levtstge_exp').addClass('checked');
            $('.levtstge_fre').removeClass('checked');
            $('.submit-button').show();

        }
    }
    checkstatus();
    $(document).on('click', '.employment_status', function (e) {
      checkstatus();
    });
</script>
@endpush