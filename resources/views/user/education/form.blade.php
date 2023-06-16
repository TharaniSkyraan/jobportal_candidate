@if(count($educationTypes)!=0)
<style>
.institution ul.typeahead.dropdown-menu {
    top:64% !important
}
.education_type_div ul.typeahead.dropdown-menu {  
    top: 148px !important;
}
</style>
@else
<style>

.institution ul.typeahead.dropdown-menu {
    top: 164px !important
}
</style>
@endif
    <div class="modal-header">
        <h4 class="modal-title">Education Detail</h4>
        <button type="button" class="btn-close educationFromclose" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body modal-dialog-scrollable">
        <div class="col-md-12 mb-4" id="div_education_level_id">
            <label for="div_education_level_id" class="form-label">Highest Qualification Level <strong class="education_level_id"></strong></label>
            <div class="" id="education_level_dd" style="display:none;">                    
                {!! Form::select('education_level_id', [''=>__('Select Education')]+$educationLevels, $education_level_id??null, array('class'=>'form-select required', 'id'=>'education_level_id')) !!}
                <small class="help-block form-text text-muted text-danger err_msg education_level_id-error" id="err_education_level_id"></small> 
            </div>
        </div>
        @php
            $education_type = null;
            if(isset($userEducation)){
                $education_type = $userEducation->education_type??$userEducation->getEducationType('education_type');
            }
        @endphp

        <div class="col-md-12 education_type_div" @if(count($educationTypes)==0) style="display:none;" @endif>
            <label for="exampleInputEmail1" class="form-label grytxtv">Education</label>
            {!! Form::text('education_type', $education_type, array('class'=>'form-control required typeahead', 'id'=>'education_type', 'placeholder'=>__('Select education type'),'autocomplete'=>'off')) !!}
            <small class="form-text text-muted text-danger err_msg" id="err_education_type"></small>
            <small class="help-block form-text text-muted text-danger err_msg education_type-error" id="err_education_type"></small> 
        </div>


        <hr/>

        <div class="col-md-12 mb-4 institution">
            <label for="exampleInputEmail1" class="form-label">Institution name</label>
            {!! Form::text('institution', null, array('class'=>'form-control-2 required typeahead mb-2', 'id'=>'institution', 'placeholder'=>__('Institution Name'),'autocomplete'=>'off')) !!}
            <small class="help-block form-text text-muted text-danger err_msg institution-error" id="err_institution"></small>  
        </div>
        @php
            $country_id = (!empty($userEducation->country_id))?$userEducation->country_id:$ip_data['country_id'];
            //$country = (!empty($userEducation->country_id))?$userEducation->getCountry('country'):$ip_data['geoplugin_countryName'];
            $country = \App\Model\Country::where('country_id',$country_id)->pluck('country')->first();
        @endphp

        <div class="col-md-12 mb-4">
            <label class="form-label">Place of Education <span class="country_text"> - {{ $country }} <a href="javascript:void(0);" onClick="CountryChange()">Change</a></span> </label>
            <div class="country_change"  style="display:none;">
                <label for="country_id" class="form-label">Country</label>
                {!! Form::select('country_id_dd', [''=>__('Select Country')]+$countries['value'], $country_id, array('class'=>'form-select country_id required', 'id'=>'country_id_dd'), $countries['attribute']) !!}
                <small class="help-block form-text text-muted text-danger err_msg country_id_dd-error" id="err_country_id_dd"></small>                        
            </div>
        </div>
        
        <div class="col-md-12 mb-4 location">
            <label for="location" class="form-label">City</label>
            {!! Form::text('location', null, array('class'=>'form-control-2 required typeahead', 'id'=>'location', 'placeholder'=>__('Enter city'),' aria-label'=>'Enter city','autocomplete'=>'off')) !!}
            <small class="form-text text-muted text-danger err_msg" id="err_location"></small>                          
        </div>

        {{-- <hr/> --}}

        <label for="" class="form-label">Year of education</label>
        <div class="row mb-4">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    @php
                        $d = $userEducation->from_year??date('Y-m-d');
                        $fromdate = old('from_year')?date('Y-m-d',strtotime(old('from_year'))):'';

                        $d = $userEducation->to_year??date('Y-m-d');
                        $todate = old('to_year')?date('Y-m-d',strtotime(old('to_year'))):'';
                    @endphp
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-2">
                        <div class="input-group">
                            <span class="input-group-text" id="">From</span>
                            {!! Form::month('from_year', $userEducation->from_year??$fromdate, array('class'=>'form-control from_year required', 'id'=>'from_year', 'max'=>date("Y-m"), 'min'=>'1980-01', 'placeholder'=>__('From'), 'autocomplete'=>'off')) !!}
                        </div>    
                        <small class="help-block form-text text-muted text-danger err_msg from_year-error" id="err_from_year"></small> 
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-2">
                        <div class="input-group">
                            <span class="input-group-text" id="">To</span>
                            {!! Form::month('to_year', $userEducation->to_year??$todate, array('class'=>'form-control to_year required', 'id'=>'to_year', 'max'=>date("Y-m"), 'min'=>'1980-01', 'placeholder'=>__('Completed Year'), 'autocomplete'=>'off')) !!}
                        </div>      
                        <small class="help-block form-text text-muted text-danger err_msg to_year-error" id="err_to_year"></small> 
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 col-sm-12 col-xs-12 mb-2 align-self-center">
                {!! Form::checkbox('pursuing', 'yes', null, array('class'=>'form-check-input', 'id'=>'pursuing')) !!}
                <label class="form-check-label" for="pursuing">
                Pursuing
                </label>
            </div>
        </div>

        {{-- <hr/> --}}

        <label for="" class="form-label">Secured</label>
        <div class=" mb-3">
            @foreach($resultTypes as $key => $resultType)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" onclick="selmark()" name="result_type_id" id="secured{{$key}}" value="{{$key}}"  @if(isset($userEducation) && $userEducation->result_type_id==$key) checked @elseif($key==1 && !isset($userEducation)) checked @endif>
                <label class="form-check-label" for="secured{{$key}}">{{$resultType}}</label>
            </div>
            @endforeach
        </div>

        <div class="col-md-6">
            <div id="show_gpa_field">
                <div class="input-group">
                    {!! Form::text('gpa', isset($userEducation)?($userEducation->result_type_id==1?$userEducation->percentage:null):null, array('class'=>'form-control required', 'id'=>'gpa', 'placeholder'=>__('GPA'), 'onkeypress'=>'return isgpa()')) !!}
                </div>
                <small class="help-block form-text text-muted text-danger err_msg gpa-error" id="err_gpa"></small>
            </div>

            <div id="show_grade_field">
                <div>                      
                @php
                    $arrDays = ['A+'=> 'A+' ,'A-'=>'A-' ,'B' => 'B' , 'C'=> 'C' ,'D' => 'D' , 'O'=> 'O' , 'E'=>'E' ];
                    $grade = isset($userEducation)?($userEducation->result_type_id==2?$userEducation->percentage:null):null ;
                @endphp
                    {!! Form::select('grade', []+$arrDays, $grade, array('class'=>'form-select required', 'placeholder'=>'Select grade', 'id'=>'grade')) !!}
                </div>
                <small class="help-block form-text text-muted text-danger err_msg grade-error" id="err_grade"></small>
            </div>

            <div id="show_percentage_field">
                <div>
                    {!! Form::text('percentage', isset($userEducation)?($userEducation->result_type_id==3?$userEducation->percentage:null):null, array('class'=>'form-control required', 'id'=>'percentage','onkeypress'=>'return ispercentage()', 'placeholder'=>__('Percentage'))) !!}
                </div>
                <small class="help-block form-text text-muted text-danger err_msg percentage-error" id="err_percentage"></small>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn bg-grey-color user-education-cancel" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn_c_s1" onClick="submitUserEducationForm();">Save</button>
    </div>
<script>
    $('#country_id_dd').select2({ dropdownParent: ".education-form" });
    
    var education_level_text = $('#education_level_id option:selected').text(); 
    $('.education_level_id').html(' - '+education_level_text);
    
    $(function(){
        // if (education_level_id != ''){                      
        var path = baseurl + "suggestion-education-types-dropdown";
        
        var cache = {};
        $('#education_type').typeahead({ // focus on first result in dropdown
            source: function(query, result) {
                var education_level_id = $('#education_level_id').val();
                if ((query in cache)) {
                    // If result is already in local_cache, return it
                    result(cache[query]);
                    return;
                }
                $.ajax({
                    url: path,
                    method: 'POST',
                    data: {q: query,education_level_id:education_level_id, _token: csrf_token},
                    dataType: 'json',
                    success: function(data) {
                        cache[query] = data;
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
                if($('#education_type').val()==''){
                    $(".education_type_div").find('.active').removeClass('active');
                    $(".education_type_div").find('li:first-child').addClass('active li-active');
                }else{
                    $(".education_type_div").find('li').removeClass('li-active');
                    $(".education_type_div").find('.active').addClass('li-active');
                }
                var current_education_type = $(".education_type_div").find('.active').text();
                $('#education_type').val(current_education_type);
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
        /**
        * Search Institute
        */
        var cache2 = {};
        $('#institution').typeahead({ // focus on first result in dropdown
            source: function(query, result) {
                var country_code = $('#country_id_dd').find(':selected').attr('data-code')
                if (query in cache2) {
                    // If result is already in local_cache2, return it
                    result(cache2[query]);
                    return;
                }
                $.ajax({
                    url: "{{ url('api/autocomplete/search_institute') }}",
                    method: 'GET',
                    data: {q: query,country_code:country_code},
                    dataType: 'json',
                    success: function(data) {
                        cache2[query] = data;
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
                if($('#institution').val()==''){
                    $(".institution").find('.active').removeClass('active');
                    $(".institution").find('li:first-child').addClass('active li-active');
                }else{
                    $(".institution").find('li').removeClass('li-active');
                    $(".institution").find('.active').addClass('li-active');
                }
                var current_institution = $(".institution").find('.active').text();
                $('#institution').val(current_institution);
            }
        });
    });
</script>