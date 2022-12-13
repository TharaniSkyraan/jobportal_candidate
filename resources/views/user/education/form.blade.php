
<div class="card mt-5">
    <div class="col-md-10 mb-4" id="div_education_level_id">
        <label for="div_education_level_id" class="form-label fw-bolder">Highest Qualification Level</label>
        {!! Form::select('education_level_id', [''=>__('Select Education')]+$educationLevels, null, array('class'=>'form-select required', 'id'=>'education_level_id')) !!}
        <small class="help-block form-text text-muted text-danger err_msg education_level_id-error" id="err_education_level_id"></small> 
    </div>
    <div class="col-md-10 education_type_div" style="display:none;">
        <label for="education_type_id" class="form-label fw-bolder">Education</label>
        <div class="" id="education_types_dd">                    
            {!! Form::select('education_type_id', [''=>__('Select Education Type')], null, array('class'=>'form-select required', 'id'=>'education_type_id')) !!}
        </div>
        <small class="help-block form-text text-muted text-danger err_msg education_type_id-error" id="err_education_type_id"></small> 
    </div>

    <hr/>

    @php
        $country_id = (!empty($userEducation->country_id))?$userEducation->country_id:$ip_data->country_id;
        $country = (!empty($userEducation->country_id))?$userEducation->getCountry('country'):$ip_data->geoplugin_countryName;
    @endphp

    <div class="col-md-10 mb-4">
        <label class="form-label fw-bolder">Place of Education</label>
        <div class="mb-3 country_change"  style="display:none;">
            <label for="country_id" class="form-label fw-bolder">Country</label>
            {!! Form::select('country_id_dd', [''=>__('Select Country')]+$countries['value'], $country_id, array('class'=>'form-select country_id required', 'id'=>'country_id_dd'), $countries['attribute']) !!}
            <small class="help-block form-text text-muted text-danger err_msg country_id_dd-error" id="err_country_id_dd"></small>                        
        </div>
     </div>
    
    <div class="row">
        <div class="col-md-6">
            <label for="location" class="form-label fw-bolder">City</label>
            {!! Form::text('location', null, array('class'=>'form-control-2 required typeahead', 'id'=>'location', 'placeholder'=>__('Enter city'),' aria-label'=>'Enter city')) !!}
            <small class="form-text text-muted text-danger err_msg" id="err_location"></small>                          
        </div>
    </div>

    <hr/>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label fw-bolder">Institution name</label>
        {!! Form::text('institution', null, array('class'=>'form-control-2 required typeahead mb-2', 'id'=>'institution', 'placeholder'=>__('Institution Name'))) !!}
        <small class="help-block form-text text-muted text-danger err_msg institution-error" id="err_institution"></small>  
    </div>

    <div class="row">
        <div class="col-md-8 col-sm-12 col-xs-12">
            <div class="row">
                    @php
                        $d = $userEducation->from_year??date('Y-m-d');
                        $fromdate = old('from_year')?date('Y-m-d',strtotime(old('from_year'))):'';

                        $d = $userEducation->to_year??date('Y-m-d');
                        $todate = old('to_year')?date('Y-m-d',strtotime(old('to_year'))):'';
                    @endphp
                <label for="" class="form-label fw-bolder">Year of education</label>
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
        
        <div class="col-md-4 col-sm-12 col-xs-12 mb-2 mt-5">
            {!! Form::checkbox('pursuing', 'yes', $userEducation->pursuing??null, array('class'=>'form-check-input', 'id'=>'pursuing')) !!}
            <label class="form-check-label" for="pursuing">
            Pursuing
            </label>
        </div>
    </div>

    <hr/>

    <label for="" class="form-label fw-bolder">Secured</label>
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

    <div class="row mt-5">
        <div class="col-6 d-flex justify-content-center">
            <input type="button" class="btn cnsl_btn" value="Cancel">
        </div>
        <div class="col-6 d-flex justify-content-center">
            <input type="submit" class="btn sb_btn" value="Submit">
        </div>
    </div>
</div>
<script>
    /**
    * Search Location
    */
    $(function(){
        var location_s = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: 'api/autocomplete/search_location',
            remote: {
                url: "api/autocomplete/search_location",
                replace: function(url, query) {
                    var country_code = $('#country_id_dd').find(':selected').attr('data-code');
                    return url + "?q=" + query+"&country_code="+country_code;
                },        
                filter: function(stocks) {
                    return $.map(stocks, function(data) {
                        return {
                            // tokens: data.tokens,
                            // symbol: data.symbol,
                            name: data.name
                        }
                    });
                }
            }
        });
        
        location_s.initialize();
        $('#location.typeahead').typeahead({
            hint: true,
            highlight: false,
            minLength: 1,
        },{
            name: 'location_s',
            displayKey: 'name',
            source: location_s.ttAdapter(),
            limit:Number.MAX_VALUE
        }); 
    });
    $(function(){
        var stocks = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: 'api/autocomplete/search_institute',
            remote: {
                url: "api/autocomplete/search_institute",
                replace: function(url, query) {
                    var country_code = $('#country_id_dd').find(':selected').attr('data-code')
                    return url + "?q=" + query+"&country_code="+country_code;
                },        
                filter: function(stocks) {
                    return $.map(stocks, function(data) {
                        return {
                            // tokens: data.tokens,
                            // symbol: data.symbol,
                            name: data.name
                        }
                    });
                }
            }
        });

        stocks.initialize();
        $('#institution.typeahead').typeahead({
            hint: true,
            highlight: false,
            minLength: 0,
        },{
            name: 'stocks',
            displayKey: 'name',
            source: stocks.ttAdapter(),
            limit:Number.MAX_VALUE
        }); 
    });

</script>