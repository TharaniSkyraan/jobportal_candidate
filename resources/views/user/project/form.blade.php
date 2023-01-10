
<link href="{{ asset('site_assets_1/assets/css/input_tag/jquery-ui.min.css')}}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/css/input_tag/jquery.tagsinput-revisited.css')}}" rel="stylesheet">
      <style type="text/css">
    .bootstrap-tagsinput .tag {
      margin-right: 2px;
      color: white !important;
      background-color: #0d6efd;
      padding: 0.2rem;
    }
  </style> 
    <div class="card mt-4">
        <div class="mb-4">    
            <label for="" class="form-label fw-bold">Project Title</label>
            {!! Form::text('name', null, array('class'=>'form-control required', 'id'=>'name', 'placeholder'=>__('Enter your Project name/Title'))) !!}
            <small class="help-block form-text text-muted text-danger err_msg name-error" id="err_name"></small>            
        </div>

        <div class="mb-4">    
            <label for="" class="form-label fw-bold">Project done By </label>    
            <select class="form-control required" name="user_experience_id" id="user_experience_id"> 
                <option value=""> Select Company </option>
                @foreach($experience_companies as $key => $company)
                    <option value="{{$key}}" @isset($userProject) @if($userProject->user_experience_id==$key) selected @endif @endisset>{{$company}}</option>
                @endforeach
                <!-- <option value="0" @isset($userProject) @if($userProject->user_experience_id==0) selected @endif @endisset> Other </option> -->
            </select>
            <small class="help-block form-text text-muted text-danger err_msg user_experience_id-error" id="err_user_experience_id"></small>            

        </div>

        <div class="row align-items-baseline mb-4">
            <div class="d-flex">
                <div class="col-md-4 justify-content-center align-self-center">
                    <input class="form-check-input" type="checkbox" value="yes" id="work_as_team" name="work_as_team" @if( isset($userProject) && $userProject->work_as_team=='yes') checked @endif>
                    <label class="form-check-label" for="work_as_team"> Worked as team </label>
                </div>

                <span class="team-length" style="display:none;">
                    <div class="value-button" id="decrease" onclick="decreaseValue()" value="Decrease Value">-</div>
                        {!! Form::number('noof_team_member', 0, array('id'=>'number')) !!}
                    <div class="value-button" id="increase" onclick="increaseValue()" value="Increase Value">+</div>
                    <small class="help-block form-text text-muted text-danger err_msg noof_team_member-error" id="err_noof_team_member"></small>  
                </span>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label fw-bold">Project location</label>  
                
            <div class="form-check form-check-inline ms-3">
                <input class="form-check-input" type="radio" name="project_location" id="onsite" value="on_site" @if(isset($userProject) && $userProject->project_location=='on_site') checked @endif>
                <label class="form-check-label" for="onsite">Onsite</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="project_location" id="Offsite" value="off_site" @if(isset($userProject) && $userProject->project_location=='off_site') checked @elseif(!isset($userProject)) checked @endif>
                <label class="form-check-label" for="Offsite">Offsite</label>
            </div>
            
            <div class="row">
                @php
                    $country_id = (!empty($userProject->country_id)?$userProject->country_id:$ip_data->country_id);
                    $country = (!empty($userProject->country_id)?$userProject->getCountry('country'):$ip_data->geoplugin_countryName);
                @endphp

                <div class="mb-2">
                    <label class="form-label fw-bolder"> Location <span class="country_text">- {{ $country }} <a href="javascript:void(0);" onClick="CountryChange()">Change</a></span></label>  
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12 mb-3 country_change"  style="display:none;">
                            <label class="form-label fw-bolder"> Country </label>  
                            {!! Form::select('country_id_dd', [''=>__('Select Country')]+$countries['value'], $country_id, array('class'=>'form-select country_id required', 'id'=>'country_id_dd'), $countries['attribute']) !!}
                            <small class="help-block form-text text-muted text-danger err_msg country_id_dd-error" id="err_country_id_dd"></small>                        
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12 mb-2">
                            <label class="form-label fw-bolder">City </label>  
                            {!! Form::text('location', null, array('class'=>'form-control-2 required typeahead', 'id'=>'location', 'placeholder'=>__('Enter city'),' aria-label'=>'Enter city')) !!}
                            <small class="form-text text-muted text-danger err_msg" id="err_location"></small>                          
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row align-items-baseline">
            <label for="" class="form-label fw-bold">Period of project</label>
            @php
                $fromdate = old('date_start')?date('Y-m-d',strtotime(old('date_start'))):'';
                $todate = old('date_end')?date('Y-m-d',strtotime(old('date_end'))):'';
            @endphp
            <div class="col-md-6 col-lg-4 col-6 mb-3">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">From</span>
                    {!! Form::month('date_start', $userProject->date_start??null, array('class'=>'form-control required', 'max' =>date("Y-m"), 'min'=>'1980-01','id'=>'date_start', 'placeholder'=>__('Start date'))) !!}
                </div>
                <small class="help-block form-text text-muted text-danger err_msg date_start-error" id="err_date_start"></small> 
            </div>
            <div class="col-md-6 col-lg-4 col-6 hide_currently_working_checked">
                <div class="input-group mb-2">
                    <span class="input-group-text" id="basic-addon1">To</span>
                    {!! Form::month('date_end', $userProject->date_end??null, array('class'=>'form-control required','max' =>date("Y-m"), 'min'=>'1980-01', 'id'=>'date_end', 'placeholder'=>__('End date'))) !!}
                </div>
                <small class="help-block form-text text-muted text-danger err_msg date_end-error" id="err_date_end"></small> 
            </div>
            <div class="col-md-6 col-lg-4 col-6 mb-3 justify-content-center">
                <input class="form-check-input" type="checkbox" value="1" id="is_on_going" name="is_on_going" @if(isset($userProject) && $userProject->is_on_going == 1) checked @endif>
                <label class="form-check-label" for="is_on_going"> On progress </label>
            </div>
        </div>

        <div class="mb-4">    
            <label for="" class="form-label fw-bold">Project Description</label>
            {!! Form::textarea('description', null, array('class'=>'form-control required', 'id'=>'description', 'rows'=>5, 'placeholder'=>'Describe about the project')) !!}
            <small class="help-block form-text text-muted text-danger err_msg description-error" id="err_description"></small>   
        </div>

        <div class="mb-4">    
            <label for="" class="form-label fw-bold">Your role on the project (Optional)</label>
            {!! Form::textarea('role_on_project', null, array('class'=>'form-control', 'id'=>'role_on_project', 'rows'=>3, 'placeholder'=>'Write about your role and responsiblities in this project')) !!}
        </div>

        <div class="mb-4">    
            <label for="" class="form-label fw-bold">Tools / Softwares Used (Optional)</label>   
            <input  type="text" name="used_tools" class="form-control" value="{{$userProject->used_tools??''}}" id="tagsinputproj">
        </div>

        <div class="row">
            <div class="col-6 text-center">
                <button class="btn bg-grey-color user-project-cancel"  onClick="cancelUserProjectForm({{$userProject->id??0}})" type="button">Cancel</button>
            </div>
            <div class="col-6 text-center">
                <button class="btn btn-submit bg-green-color" type="button" onclick="submitUserProjectForm()">Save</button>
            </div>
        </div>
    </div>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/js/input_tag/jquery.tagsinput-revisited.js') }}"></script>
<script>
$(function() {	
    getSkill()
    function getSkill(){

        $.ajax({

            type: "GET",

            url: "{{ route('get.skills.data') }}",

            data: {"_token": "{{ csrf_token() }}"},

            datatype: 'json',

            success: function (json) {

                $('#tagsinputproj').tagsInput({

                    'autocomplete': {
                        source: json.skills
                    } 

                });

            }

        });

    }
    
});

$(function(){
    var stocks = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.whitespace,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: 'api/autocomplete/search_location',
        remote: {
            url: "api/autocomplete/search_location",
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
    $('#location.typeahead').typeahead({
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