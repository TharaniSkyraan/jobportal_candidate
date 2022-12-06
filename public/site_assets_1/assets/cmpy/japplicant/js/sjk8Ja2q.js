var candi_status_changes_url = baseurl + 'company/applicationStatusUpdate';   
var download = baseurl + 'company/downloadcv/';   
setTimeout(function() {
    $('#exampleModalToggle').modal('show');
}, 100);

$('#cdate_assesment .cont_act').hide();

$("#cdate_assesment .book_fa").click(function(){
    $('#cdate_assesment .cont_act').toggle();
});  

$("#cdate_assesment .book_fa").click();   

// experience
$(".exp_more").on("click",function(){
        var more_val = $(this).attr('data-more');
        $(".experience_show_more_data_"+more_val).show();
        $(this).hide();
    });

    // project
    $(".proj_more").on("click",function(){
        var more_val = $(this).attr('data-more');
        $(".project_show_more_data_"+more_val).show();
        $(this).hide();
    });

    $(document).on('click', '.btnact_st' , function(e){
    var cdata = $(this);
    CandidateStatusUpdate(cdata);
});

function CandidateStatusUpdate(cdata){   


    let csrf_token = $('meta[name=csrf-token]').attr('content');
    
    var cstatus = $('.profile_card').attr('data-appstatus');
    var status = $(cdata).attr('data-value');
    
    if(cstatus!=status){                
        $.ajax({
            type: "POST",
            url: candi_status_changes_url,
            data: {"_token": csrf_token, "apply_id": a_id, "status": status},
            datatype: 'json',
            // beforeSend: function () {
            //    $(ftabid).addClass("is-loading");
            //},
            success: function (json) {
                toastr.success(json.message);
                // $(ftabid).removeClass("is-loading");
                //load candidate list
                
                $('.profile_card').attr('data-appstatus', status);

                if(status=='shortlist'){
                    $('#st_shortlist'+a_id).html(`<img src="${baseurl}site_assets_1/assets/img/candiimg/shortlist_c.png" class="img-fluid" />`);
                    $('#st_consider'+a_id).html(`<img src="${baseurl}site_assets_1/assets/img/candiimg/consider.png" class="img-fluid" />`);
                    $('#st_reject'+a_id).html(`<img src="${baseurl}site_assets_1/assets/img/candiimg/reject.png" class="img-fluid" />`);
                }
                if(status=='consider'){
                    $('#st_shortlist'+a_id).html(`<img src="${baseurl}site_assets_1/assets/img/candiimg/shortlist.png" class="img-fluid" />`);
                    $('#st_consider'+a_id).html(`<img src="${baseurl}site_assets_1/assets/img/candiimg/consider_c.png" class="img-fluid" />`);
                    $('#st_reject'+a_id).html(`<img src="${baseurl}site_assets_1/assets/img/candiimg/reject.png" class="img-fluid" />`);                    
                }
                if(status=='reject'){
                    $('#st_shortlist'+a_id).html(`<img src="${baseurl}site_assets_1/assets/img/candiimg/shortlist.png" class="img-fluid" />`);
                    $('#st_consider'+a_id).html(`<img src="${baseurl}site_assets_1/assets/img/candiimg/consider.png" class="img-fluid" />`);
                    $('#st_reject'+a_id).html(`<img src="${baseurl}site_assets_1/assets/img/candiimg/reject_c.png" class="img-fluid" />`);                    
                }
            }
        });
    }

}

$('.resume').click(function() {
    const aTag = document.createElement('a');
    aTag.rel = 'noopener';
    aTag.target = "_blank";
    aTag.href = download+$(this).data("aci");
    aTag.click();
});