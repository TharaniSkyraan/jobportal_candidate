
<link href="{{ asset('site_assets_1/assets/css/input_tag/jquery-ui.min.css')}}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/css/input_tag/jquery.tagsinput-revisited.css')}}" rel="stylesheet">


<div class="card mt-4">

    <div class="mb-4 title">    
        <label for="" class="form-label fw-bolder">Designation</label>
        <input class="form-control required typeahead" id="title" placeholder="{{__('Designation')}}" name="title" type="text" value="{{(isset($jobAlert)? $jobAlert->title:'')}}">
        <small class="help-block form-text text-muted text-danger err_msg title-error" id="err_title"></small>
    </div>
    @php
        $country_id = (!empty($jobAlert->country_id))?$jobAlert->country_id:$ip_data['country_id'];
        $country = \App\Model\Country::where('country_id',$country_id)->pluck('country')->first();
    @endphp

    <div class="mb-2">
        <label class="form-label fw-bolder"> Location <span class="country_text">- {{ $country }} <a href="javascript:void(0);" onClick="CountryChange()">Change</a></span></label>  
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 col-12 mb-3 country_change"  style="display:none;">
                <label class="form-label fw-bolder"> Country </label>  
                {!! Form::select('country_id_dd', [''=>__('Select Country')]+$countries['value'], $country_id, array('class'=>'form-select country_id required', 'id'=>'country_id_dd'), $countries['attribute']) !!}
                <small class="help-block form-text text-muted text-danger err_msg country_id_dd-error" id="err_country_id_dd"></small>                        
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 mb-2 location">
                <label class="form-label fw-bolder">City </label>  
                {!! Form::text('location', null, array('class'=>'form-control required typeahead', 'id'=>'location', 'placeholder'=>__('Enter city'),' aria-label'=>'Enter city', 'autocomplete'=>'off')) !!}
                <small class="form-text text-muted text-danger err_msg" id="err_location"></small>                          
            </div>
        </div>
    </div>
    <div class="mb-4">   
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" value="yes" id="immediate_join" name="immediate_join" @if(isset($jobAlert) && ($jobAlert->immediate_join=='yes')) checked @endif>
            <label class="form-check-label" for="immediate_join">
                Immediate Required Job
            </label>
        </div>
    </div>
    <div class="mb-4">   
        <a href="#jobtypeFilters" class="filterHeading collapsed" data-bs-toggle="collapse" aria-expanded="false">
            <label class="form-label fw-bolder">Job Type</label> <span class="caret"></span>
        </a>
        <div class="collapse {{ !empty($jobAlert->jobtypeFGid)?'show':'' }}" id="jobtypeFilters">
            <div class="dropdown_inner filterOptns" data-filter-id="jobtypeFv">
                <div class="row">  
                    @foreach ($filters['jobtypeFGid'] as $jobtype)                    
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 align-self-center">  
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" value="{{$jobtype->id}}" id="jobtypeFGid{{$jobtype->id}}" name="jobtypeFGid[]" @if(isset($jobAlert) && in_array($jobtype->id,explode(',',$jobAlert->jobtypeFGid))) checked @endif>
                                <label class="form-check-label" for="jobtypeFGid{{$jobtype->id}}">
                                {{$jobtype->label}}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4">    
        <a href="#jobshiftFilters" class="filterHeading collapsed" data-bs-toggle="collapse" aria-expanded="false">
            <label class="form-label fw-bolder">Job Shift</label> <span class="caret"></span>
        </a>
        <div class="collapse {{ !empty($jobAlert->jobshiftFGid)?'show':'' }}" id="jobshiftFilters">
            <div class="dropdown_inner filterOptns" data-filter-id="jobshiftFv">
                <div class="row"> 
                    @foreach ($filters['jobshiftFGid'] as $jobshift)                    
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 align-self-center">  
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" value="{{$jobshift->id}}" id="jobshiftFGid{{$jobshift->id}}" name="jobshiftFGid[]" @if(isset($jobAlert) && in_array($jobshift->id,explode(',',$jobAlert->jobshiftFGid))) checked @endif>
                                <label class="form-check-label" for="jobshiftFGid{{$jobshift->id}}">
                                {{$jobshift->label}}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4">
        <div class="row">   
            <a href="#experinceFilters" class="filterHeading collapsed" data-bs-toggle="collapse" aria-expanded="false">
                <label class="form-label fw-bolder">Experience </label><span class="caret"></span>
            </a>
            <input type="hidden" id="experienceFid" value="{{ (!empty($jobAlert->experienceFid) && $jobAlert->experienceFid!=0)?$jobAlert->experienceFid:'any' }}" name="experienceFid">
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 align-self-center">  
                <div class="collapse {{ (isset($jobAlert) && $jobAlert->experienceFid!=0 && !empty($jobAlert->experienceFid))?'show':'' }}" id="experinceFilters">
                    <div class="dropdown_inner filterOptns" data-filter-id="experinceFv">
                        <div class="p-3">
                            <div class="range-wrap">
                                <div class="range-value" id="rangeV" style="left: calc(100% + -8px);"><span>Any</span></div>
                                <input id="exp-range-slider" type="range" min="0" max="30" step="1">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4">  
        <a href="#wfhtypeFilters" class="filterHeading collapsed" data-bs-toggle="collapse" aria-expanded="false">
            <label class="form-label fw-bolder">Remote </label> <span class="caret"></span>
        </a>
        <div class="collapse {{ !empty($jobAlert->wfhtypeFid)?'show':'' }}" id="wfhtypeFilters">
            <div class="dropdown_inner filterOptns" data-filter-id="wfhtypeFv">
                <div class="row">   
                    @foreach ($filters['wfhtypeFid'] as $wfhtype)                    
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 align-self-center">  
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" value="{{$wfhtype['id']}}" id="wfhtypeFid{{$wfhtype['id']}}" name="wfhtypeFid[]" @if(isset($jobAlert) && in_array($wfhtype['id'],explode(',',$jobAlert->wfhtypeFid))) checked @endif>
                                <label class="form-check-label" for="wfhtypeFid{{$wfhtype['id']}}">
                                    {{$wfhtype['label']}}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4">  
        <a href="#salaryFilters" class="filterHeading collapsed" data-bs-toggle="collapse" aria-expanded="false">
            <label class="form-label fw-bolder">Expected Salary </label> <span class="caret"></span>
        </a>
        <div class="collapse {{ !empty($jobAlert->salaryFGid)?'show':'' }}" id="salaryFilters">
            <div class="dropdown_inner filterOptns" data-filter-id="salaryFv">
                <div class="row">  
                    @foreach ($filters['salaryFGid'] as $salary)                    
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 align-self-center">  
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" value="{{$salary['id']}}" id="salaryFGid{{$salary['id']}}" name="salaryFGid[]" @if(isset($jobAlert) && in_array($salary['id'],explode(',',$jobAlert->salaryFGid))) checked @endif>
                                <label class="form-check-label" for="salaryFGid{{$salary['id']}}">
                                {{$salary['label']}}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4">    
        <a href="#posteddateFilters" class="filterHeading collapsed" data-bs-toggle="collapse" aria-expanded="false">
            <label class="form-label fw-bolder">Jobs Posted within</label> <span class="caret"></span>
        </a>
        <div class="collapse {{ !empty($jobAlert->posteddateFid)?'show':'' }}" id="posteddateFilters">
            <div class="dropdown_inner filterOptns" data-filter-id="posteddateFv">
                <div class="row">  
                    @foreach ($filters['posteddateFid'] as $posteddate)                    
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 align-self-center">  
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" value="{{$posteddate['id']}}" id="posteddateFid{{$posteddate['id']}}" name="posteddateFid[]" @if(isset($jobAlert) && in_array($posteddate['id'],explode(',',$jobAlert->posteddateFid))) checked @endif>
                                <label class="form-check-label" for="posteddateFid{{$posteddate['id']}}">
                                {{$posteddate['label']}}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6 text-center">
            <button class="btn bg-grey-color user-job-alert-cancel" type="button"  onClick="cancelJobAlertForm({{$jobAlert->id??0}});">Cancel</button>
        </div>
        <div class="col-6 text-center">
            <button class="btn btn-submit btn_c_s1" type="button" onClick="submitJobAlertForm();">Save</button>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/js/input_tag/jquery.tagsinput-revisited.js') }}"></script>

<script>

    $('.country_id').select2();
    var cache2 = JSON.parse(localStorage.getItem('designation'))??{};
    $('#title.typeahead').typeahead({ // focus on first result in dropdown
        source: function(query, result) {
            var local_cache = JSON.parse(localStorage.getItem('designation'));
            if ((local_cache!=null) && (query in local_cache)) {
                // If result is already in local_cache, return it
                result(cache2[query]);
                return;
            }
            $.ajax({
                url: 'api/autocomplete/search_designation',
                method: 'GET',
                data: {q: query},
                dataType: 'json',
                success: function(data) {
                    cache2[query] = data;
                    localStorage.setItem('designation',JSON.stringify(cache2));
                    result(data);
                }
            });
        },
        autoSelect: true,
        showHintOnFocus: true
    }).focus(function () {
        $(this).typeahead("search", "");
    }).on('keydown', function(event){        
        if(event.keyCode=='40' || event.keyCode=='38'){
            if($('#title').val()==''){
                $(".title").find('.active').removeClass('active');
                $(".title").find('li:first-child').addClass('active li-active');
            }else{
                $(".title").find('li').removeClass('li-active');
                $(".title").find('.active').addClass('li-active');
            }
            var current_title = $(".title").find('.active').text();
            $('#title').val(current_title);
        }
    });
     
    /**
    * Search Location
    */
    var cache1 = JSON.parse(localStorage.getItem('search_city'))??{};
    $('#location').typeahead({ // focus on first result in dropdown
        source: function(query, result) {
            var country_code = $('#country_id_dd').find(':selected').attr('data-code')
            var local_cache1 = JSON.parse(localStorage.getItem('search_city'));
            if ((local_cache1!=null) && ((country_code+query) in local_cache1)) {
                // If result is already in local_cache1, return it
                result(cache1[country_code+query]);
                return;
            }
            $.ajax({
                url: "{{ url('api/autocomplete/search_location') }}",
                method: 'GET',
                data: {q: query,country_code:country_code},
                dataType: 'json',
                success: function(data) {
                    cache1[country_code+query] = data;
                    localStorage.setItem('search_city',JSON.stringify(cache1));
                    result(data);
                }
            });
        },
        autoSelect: true,
        showHintOnFocus: true
    }).focus(function () {
        $(this).typeahead("search", "");
    }).on('keydown', function(event){        
        if(event.keyCode=='40' || event.keyCode=='38'){
            if($('#location').val()==''){
                $(".location").find('.active').removeClass('active');
                $(".location").find('li:first-child').addClass('active li-active');
            }else{
                $(".location").find('li').removeClass('li-active');
                $(".location").find('.active').addClass('li-active');
            }
            var current_location = $(".location").find('.active').text();
            $('#location').val(current_location);
        }
    });  
</script>
