
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

    <div class="mb-4">    
        <label for="" class="form-label fw-bolder">Designation</label>
        <input class="form-control-2 required typeahead" id="title" placeholder="{{__('Designation')}}" name="title" type="text" value="{{(isset($userExperience)? $userExperience->title:'')}}">
        <small class="help-block form-text text-muted text-danger err_msg title-error" id="err_title"></small>
    </div>

    <div class="mb-4">    
        <label for="" class="form-label fw-bolder">Name of Industry / Organization</label>
        <input class="form-control required" id="company" placeholder="{{__('Company')}}" name="company" type="text" value="{{(isset($userExperience)? $userExperience->company:'')}}">
        <small class="help-block form-text text-muted text-danger err_msg company-error" id="err_company"></small> 
    </div>
    @php
        $country_id = (!empty($userExperience->country_id))?$userExperience->country_id:$ip_data->country_id;
        $country = (!empty($userExperience->country_id))?$userExperience->getCountry('country'):$ip_data->geoplugin_countryName;
    @endphp

    <div class="mb-4">
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

    <div class="row align-items-baseline mb-3">
        <label for="" class="form-label fw-bolder">Year of Experience</label>
        <div class="col-md-4 col-sm-6 col-xs-12 mb-2">
            <div class="input-group">
                <span class="input-group-text" id="basic-addon1">From</span>
                {!! Form::month('date_start', $userExperience->date_start??null, array('class'=>'form-control date_start required', 'id'=>'date_start', 'max'=>date("Y-m"), 'min'=>'1980-01', 'placeholder'=>__('From'), 'autocomplete'=>'off')) !!}
            </div>
            <small class="help-block form-text text-muted text-danger err_msg date_start-error" id="err_date_start"></small>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12 mb-2 hide_currently_working_checked">
            <div class="input-group">
                <span class="input-group-text" id="basic-addon1">To</span>
                {!! Form::month('date_end', $userExperience->date_end??null, array('class'=>'form-control date_end required', 'id'=>'date_end', 'max'=>date("Y-m"), 'min'=>'1980-01', 'placeholder'=>__('Completed Year'), 'autocomplete'=>'off')) !!}
            </div>
            <small class="help-block form-text text-muted text-danger err_msg date_end-error" id="err_date_end"></small>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12 mb-2 justify-content-center">
            <input class="form-check-input" type="checkbox" name="is_currently_working" value="1" id="flexCheckDefault" @if(isset($userExperience) && $userExperience->is_currently_working == 1) checked @endif>
            <label class="form-check-label" for="flexCheckDefault">Still Working</label>
        </div>
    </div>

    <div class="mb-4">    
        <label for="" class="form-label fw-bolder">Job Description (Optional)</label>
        <textarea name="description" rows="3" class="form-control" maxlength='255' placeholder="Write about your roles and responsibilities in this industry/ Organaisation" id="job_description">{{(isset($userExperience)? $userExperience->description:'')}}</textarea>
        <small class="job_desc_remain_char text-muted fw-bold"></small>
        <small class="description_remain_char"></small>
    </div>

    <div class="mb-4">    
        <label for="" class="form-label fw-bolder">Tools / Softwares Used (Optional)</label>   
        <input  type="text" name="used_tools" class="form-control" value="{{$userExperience->used_tools??''}}" id="tagsinputexp">
    </div>

    <div class="d-grid gap-2 m-4 d-md-flex justify-content-md-around">
        <button class="btn bg-grey-color user-experience-cancel" type="button"  onClick="cancelUserExperienceForm({{$userExperience->id??0}});">Cancel</button>
        <button class="btn btn-submit bg-green-color" type="button" onClick="submitUserExperienceForm();">Save</button>
    </div>
  
  <script type="text/javascript" src="{{ asset('site_assets_1/assets/js/input_tag/jquery.tagsinput-revisited.js') }}"></script>
  
<script>

{{-- $(document).on("keyup","#job_description",function(e){
    var len = $(this).val().length;
    set = 255;
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
}); --}}

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

    $(function(){
        var title = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: 'api/autocomplete/search_title',
            remote: {
                url: "api/autocomplete/search_title",
                replace: function(url, query) {
                    return url + "?q=" + query;
                },        
                filter: function(title) {
                    return $.map(title, function(data) {
                        return {
                            name: data.name
                        }
                    });
                }
            }
        });

        title.initialize();
        $('#title.typeahead').typeahead({
            hint: true,
            highlight: false,
            minLength: 0,
        },{
            name: 'title',
            displayKey: 'name',
            source: title.ttAdapter(),
            limit:Number.MAX_VALUE
        }); 
    });

</script>
