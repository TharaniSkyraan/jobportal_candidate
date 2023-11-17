
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
    let jobidv = $(this).closest('.job-list').data('jobid');
    btn = $(this);
    jobApply(btn, jobidv);
   
});

$(document).on( 'click', '.job-list', function(e) {
    url = baseurl + 'detail/'+ $(this).data("jobid");
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
                    `<i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i> <span>Loading..</span>`
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
                    $(btn).closest('.japply-btn').addClass('japplied-btn').removeClass('japply-btn');
                    $(btn).closest('.japplied-btn').html(`<button class="btn p-1 px-2 shadow-sm rounded-pill">
                                                            <img draggable="false" class="imagesz-2" src="${baseurl}site_assets_1/assets/img/Shortlist.png" alt="applied"> 
                                                            <span class="fw-bold">Applied</span>
                                                        </button>`);
                }
                else{
                    $(btn).html(`<img draggable="false" class="image-size" src="${baseurl}site_assets_1/assets/img/apply2.png" alt="apply"> <span>Apply</span>`);
                }

                $(btn).prop("disabled", false);

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
