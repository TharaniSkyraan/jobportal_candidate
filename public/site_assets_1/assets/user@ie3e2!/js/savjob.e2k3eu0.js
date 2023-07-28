
let csrf_token = $('meta[name=csrf-token]').attr('content');
$(document).ready(function () {
    let activeappStatus = '';
    let applicationStatus = '';
    let page = '';
    $(document).on( 'click', '.applicationStatus', function(e) {
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
        url: baseurl+"saved-jobs?page="+page,
        data: {'sortBy': 'all',"_token": csrf_token},
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
        url: baseurl+"save/"+btn.attr("data-slug"),
        type: 'POST',
        data : {"_token": csrf_token,'is_login':1, 'fav':'yes' },
        datatype: 'JSON',
        success: function(resp) {
          toastr.success(resp.message);
          fetch_data(1);              
        }
    });
  } 
  
  $(document).on( 'click', '.favjob', function(e) {
    e.stopPropagation();
    // alert(jobidv)
    btn = $(this);
    jobUnsave(btn);
  });
  $(document).on( 'click', '.japplybtn', function(e) {
    e.stopPropagation();
    let jobidv = $(this).parent().parent().parent().parent().data('jobid');
    btn = $(this);
    jobApply(btn, jobidv);
   
});

$(document).on( 'click', '.job-list', function(e) {
    url = baseurl + 'job-detail/'+ $(this).data("jobid");
    openInNewTabWithNoopener(url)
});
function jobApply(e, jobidv) {

  
    if(jobidv != '') {

        let csrf_token = $('meta[name=csrf-token]').attr('content');
        let req_url = baseurl + 'apply/' + jobidv;

        $(btn).prop("disabled", true);

        $.ajax({
            url: req_url,
            type: 'POST',
            data : {"_token": csrf_token,'is_login':1 },
            datatype: 'JSON',
            beforeSend:function(){
                $(btn).html(
                    `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading..`
                );
            },
            success: function(resp) {
                
                let redir='';
                let applied_b =false;
                let reload_page = resp.reload_page || false;
                
                if(resp.success == true){
                    redir = resp.return_to;
                    applied_b=true;
                }
                else if(resp.success == false){
                    redir = resp.return_to;
                    applied_b=false;
                }
                else{
                    redir = resp.return_to;
                    applied_b=false;
                }
                
                if(applied_b){
                    $(`<label class="japplied-btn"><img class="imagesz-2" src="${baseurl}site_assets_1/assets/img/Shortlist.png" alt="applied"> <span class="fw-bold">Applied</span></label>`).insertAfter(btn);
                    $(btn).hide();
                }
                else{
                    $(btn).html(
                        `<img class="image-size" src="${baseurl}site_assets_1/assets/img/apply2.png" alt="apply"> Apply</button>`
                    );
                    $(btn).show();
                }
                $(btn).prop("disabled", false);

                let url ='';
                //redir action
                if(redir =='login' || redir == 'redirect_user' ){
                    url = baseurl + redir;
                    openInNewTabWithNoopener(url);
                    // alert()
                }else if(redir =='company/postedjobslist'){
                    location.reload();
                }
                else{
                    if(resp.success == false){
                        var html = `<div class="modal-content">
                            <div class="modal-body warning">
                                <div class="text-center mb-3">
                                    <h1 class="fw-bolder">Hi `+resp.candidate+`</h1>
                                    <h3 class="fw-bolder">Your Profile Completion is</h3>
                                </div>
                                <div class="mx-auto mb-3 progressbar useraccountsetting cursor-pointer fw-bolder" role="progressbar" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100" style="--value: `+resp.percentage+`">    
                                `+resp.percentage+`                     
                                </div>
                                <div class="mb-4">
                                    <span class="text-center align-items-center justify-content-center d-flex">Complete your profile minimum 40% to apply for Jobs</span>
                                </div>
                                <h3 class="text-center text-primary fw-bold"><a href="`+redir+`">COMPLETE NOW</a></h3>
                            </div>
                        </div>`;
                        $('.cmpPrf').html(html);
                        $('#cmptprf').modal('show');
                    }elseif(reload_page)
                    {
                            location.reload();
                    }
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                // $('#content').html(errorMsg);
            }
        });

    }

}

function openInNewTabWithNoopener(val) {
    const aTag = document.createElement('a');
    aTag.rel = 'noopener';
    aTag.target = "_blank";
    aTag.href = val;
    aTag.click();
}
