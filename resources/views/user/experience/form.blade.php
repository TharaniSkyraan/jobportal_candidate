
<link href="{{ asset('site_assets_1/assets/css/input_tag/jquery-ui.min.css')}}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/css/input_tag/jquery.tagsinput-revisited.css')}}" rel="stylesheet">

<style type="text/css">
    .bootstrap-tagsinput .tag {
      margin-right: 2px;
      color: white !important;
      background-color: #0d6efd;
      padding: 0.2rem;
    }

    .title .typeahead.dropdown-menu, .location .typeahead.dropdown-menu {
        width: -webkit-fill-available;
        margin-right: 35px;
    }
    @media (min-width: 576px){
        .location .typeahead.dropdown-menu {
            margin-right: 36.2%;
        }
    }
    
</style>

    <div class="card mt-4">
    
        <div class="mb-4 title">    
            <label for="" class="form-label fw-bolder">Designation</label>
            <input class="form-control required typeahead" id="title" placeholder="{{__('Designation')}}" name="title" type="text" value="{{(isset($userExperience)? $userExperience->title:'')}}">
            <small class="help-block form-text text-muted text-danger err_msg title-error" id="err_title"></small>
        </div>

        <div class="mb-4">    
            <label for="" class="form-label fw-bolder">Name of Industry / Organization</label>
            <input class="form-control required" id="company" placeholder="{{__('Company')}}" name="company" type="text" value="{{(isset($userExperience)? $userExperience->company:'')}}">
            <small class="help-block form-text text-muted text-danger err_msg company-error" id="err_company"></small> 
        </div>
        @php
            $country_id = (!empty($userExperience->country_id))?$userExperience->country_id:$ip_data['country_id'];
            //$country = (!empty($userExperience->country_id))?$userExperience->getCountry('country'):$ip_data['geoplugin_countryName'];
            $country = \App\Model\Country::where('country_id',$country_id)->pluck('country')->first();
        @endphp

        <div class="mb-4">
            <label class="form-label fw-bolder"> Location <span class="country_text">- {{ $country }} <a href="javascript:void(0);" onClick="CountryChange()">Change</a></span></label>  
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 col-12 mb-3 country_change"  style="display:none;">
                    <label class="form-label fw-bolder"> Country </label>  
                    {!! Form::select('country_id_dd', [''=>__('Select Country')]+$countries['value'], $country_id, array('class'=>'form-select country_id required', 'id'=>'country_id_dd'), $countries['attribute']) !!}
                    <small class="help-block form-text text-muted text-danger err_msg country_id_dd-error" id="err_country_id_dd"></small>                        
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 col-12 mb-2 location">
                    <label class="form-label fw-bolder">City </label>  
                    {!! Form::text('location', null, array('class'=>'form-control required typeahead', 'id'=>'location', 'placeholder'=>__('Enter city'),' aria-label'=>'Enter city', 'autocomplete'=>'off')) !!}
                    <small class="form-text text-muted text-danger err_msg" id="err_location"></small>                          
                </div>
            </div>
        </div>

            @php
                $date_start = isset($userExperience->date_start)?Carbon\Carbon::parse($userExperience->date_start):null;
                $date_end = isset($userExperience->date_end)?Carbon\Carbon::parse($userExperience->date_end):null;
            @endphp
        <div class="row align-items-baseline mb-3">
            <label for="" class="form-label fw-bolder">Year of Experience</label>
            <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12 col-12 mb-2">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">From</span>
                    {!! Form::month('date_start', $date_start??null, array('class'=>'form-control date_start required', 'id'=>'date_start', 'max'=>date("Y-m"), 'min'=>'1980-01', 'placeholder'=>__('From'), 'autocomplete'=>'off')) !!}
                </div>
                <small class="help-block form-text text-muted text-danger err_msg date_start-error" id="err_date_start"></small>
            </div>
            <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12 col-12 mb-2 hide_currently_working_checked">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">To</span>
                    {!! Form::month('date_end', $date_end??null, array('class'=>'form-control date_end required', 'id'=>'date_end', 'max'=>date("Y-m"), 'min'=>'1980-01', 'placeholder'=>__('Completed Year'), 'autocomplete'=>'off')) !!}
                </div>
                <small class="help-block form-text text-muted text-danger err_msg date_end-error" id="err_date_end"></small>
            </div>
            <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12 col-21 mb-2 justify-content-center">
                <input class="form-check-input" type="checkbox" name="is_currently_working" value="1" id="flexCheckDefault" @if(isset($userExperience) && $userExperience->is_currently_working == 1) checked @endif>
                <label class="form-check-label" for="flexCheckDefault">Still Working</label>
            </div>
        </div>

        <div class="mb-4">    
            <label for="" class="form-label fw-bolder">Job Description (Optional)</label>
            <textarea name="description" rows="3" class="form-control" maxlength='4000' placeholder="Write about your roles and responsibilities in this industry/ Organaisation" id="job_description">{{(isset($userExperience)? $userExperience->description:'')}}</textarea>
            <small class="job_desc_remain_char text-muted fw-bold"></small>
            <small class="description_remain_char"></small>
        </div>

        <div class="mb-4">    
            <label for="" class="form-label fw-bolder">Tools / Softwares Used (Optional)</label>   
            <input  type="text" name="used_tools" class="form-control" value="{{$userExperience->used_tools??''}}" id="tagsinputexp">
        </div>

        <div class="row">
            <div class="col-6 text-center">
                <button class="btn bg-grey-color user-experience-cancel" type="button"  onClick="cancelUserExperienceForm({{$userExperience->id??0}});">Cancel</button>
            </div>
            <div class="col-6 text-center">
                <button class="btn btn-submit btn_c_s1" type="button" onClick="submitUserExperienceForm();">Save</button>
            </div>
        </div>
    </div>
  <script type="text/javascript" src="{{ asset('site_assets_1/assets/js/input_tag/jquery.tagsinput-revisited.js') }}"></script>
  
<script>

    $(document).on("keyup","#job_description",function(e){
        var len = $(this).val().length;
        set = 4000;
        if(len == 0){
            $('.description_remain_char').hide();
            }else{
            $('.description_remain_char').show();
            }
        if(len >= set) {
            $('.description_remain_char').html('Maximum characters reached: <span class="text-danger">'+set+'</span>');
        }else{
            $('.description_remain_char').html('Remaining Maximum characters: <span class="text-success">'+(set-len)+'</span>');
        }
    });

    $('.country_id').select2();
    $(function() {	
        getSkill()
        function getSkill(){
            $.ajax({
                type: "GET",
                url: "{{ route('get.skills.data') }}",
                data: {"_token": "{{ csrf_token() }}"},
                datatype: 'json',
                success: function (json) {
                    $('#tagsinputexp').tagsInput({
                        'autocomplete': {
                            source: json.skills
                        } 
                    });
                }
            });
        }
    });
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
