@extends('layouts.app')

@section('content')
<style>
  .preview_job{
    overflow: hidden;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 4;
  }
  .preview_job p{
    font-size: 14px;
    margin-bottom: 0.5rem;
  }
  .image-size{
    width: 16px;
    /* vertical-align: text-top; */
    margin-top: -2px;
  }
  .imagesz-2{
    width: 21px;
    /* vertical-align: text-bottom; */
    margin-top: -2px;
  }
  .nav-link{
    font-size: 1.025rem !important;
  }
  .janoimg{
    width: 50%;    
  }.btnc1{
    line-height: 0;
    padding: 1.165rem 1.7rem;
    border-radius: 3px;
    transition: 0.5s;
    color: #fff;
    background: #4285F4;
    box-shadow: 0px 5px 25px rgb(65 84 241 / 30%);
}
.btnc1 span {
    font-family: "Nunito", sans-serif;
    font-weight: 500;
    font-size: 14px;
    letter-spacing: 1px;
}
.btnc1:hover {
    color: #fff;
}
.nav-pills .nav-link {
    padding: 10px 30px;
}
</style>
<div class="wrapper">
        
	@include('layouts.header')
	@include('layouts.side_navbar')
        
	<div class="main-panel main-panel-custom">
		<div class="content">
        <div class="row">
          <div class="col-md-12 col-lg-10 col-sm-12 col-xs-12">         
            <div class="px-5 pt-4 pb-0 mt-3 mb-3">
                <div class="jobList allJobList">
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>
          
<script>

  $(document).ready(function () {
    let activeappStatus = '';
    let applicationStatus = '';
    let page = '';
    $(".applicationStatus").on("click", function() {
      applicationStatus = $(this).attr('role');
      if(applicationStatus != activeappStatus){
        fetch_data(1);
      }        
    });

    $(document).on('click', '.pagination a', function(event){
      event.preventDefault(); 
      page = $(this).attr('href').split('page=')[1];
      fetch_data(page);
    });
  });

  function fetch_data(page)
  { 
      $('.jobList').html(''); 
      $.ajax({
        type: "POST",
        url: "{{ route('saved-jobs-list') }}?page="+page,
        data: {'sortBy': 'all',"_token": "{{ csrf_token() }}"},
        datatype: 'json',
        beforeSend:function(){
          $('.jobList').addClass('is-loading');
        },
        success: function (json) {
          $('.allJobList').html(json.html);
          $('.jobList').removeClass('is-loading');

        }
    });
    
  }
  fetch_data(1);  

  function jobUnsave(btn){

      var csrf_token = $('meta[name=csrf-token]').attr('content');
      
      btn.prop("disabled", true);

      $.ajax({
          url: "{{ url('save') }}/"+btn.attr("data-slug"),
          type: 'POST',
          data : {"_token": csrf_token,'is_login':1, 'fav':'yes' },
          datatype: 'JSON',
          success: function(resp) {
            toastr.success(resp.message);
            fetch_data(1);              
          }
      });
  } 

  
</script>
@endsection