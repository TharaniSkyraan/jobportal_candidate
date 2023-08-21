
    if(applied==true){
        $(".japplied-btn").show();
        $(".japply-btn").hide();
    }else{
        $(".japplied-btn").hide();
        $(".japply-btn").show();
    }
    v_is_login = is_login || 0;
    $('#is_login').val(v_is_login);
    let csrf_token = $('meta[name=csrf-token]').attr('content');
    
    $('.favjob').on('click', function(){
        let btn = $(".favjob");
        if(1) {

            let is_fav =  $('.favjob').attr("data-fav");            
            $('.favjob').prop("disabled", true);

            $.ajax({
                url: save_req_url,
                type: 'POST',
                data : {"_token": csrf_token,'is_login':v_is_login, 'fav':is_fav },
                datatype: 'JSON',
                // beforeSend:function(){
                //   $(btn).html(
                //       `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`
                //   );
                //}, 
                success: function(resp) {
                    
                    let redir='';
                    let fav_unfav =false;
                    let reload_page = resp.reload_page || false;
                    let fav = resp.fav;

                    $('.favjob').prop("disabled", false);
                    $('.favjob').attr("data-fav", fav);

                    if(fav=='yes'){
                        $(btn).html(`<img draggable="false" class="image-size1 cursor-pointer" src="${baseurl}site_assets_1/assets/img/star_filled.png" alt="bookmark">`);
                    }
                    else{
                       $(btn).html(`<img draggable="false" class="image-size1 cursor-pointer" src="${baseurl}site_assets_1/assets/img/star_unfilled.png" alt="bookmark">`);
                    }
                    
                    if(resp.success == true){
                        redir = resp.return_to;
                        fav_unfav=true;
                    }
                    else if(resp.success == false){
                        redir = resp.return_to;
                        fav_unfav=false;
                    }
                    else{
                        redir = resp.return_to;
                        fav_unfav=false;
                    }
                    

                    let url ='';

                    //redir action
                    if(redir =='login' || redir == 'redirect_user' ){
                        url = baseurl + redir;
                        openInNewTabWithNoopener(url);
                    }
                    else if(redir =='company/postedjobslist'){
                        location.reload();
                    }
                    else if(redir == ''){
                        $('#jasuccess').html('<div class="alert alert-success alert-dismissible">'
                        +resp.message
                        +'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
                        +'</div>');
                    }
                    else{ 
                        location.reload();
                    }
                    
                    if(reload_page){
                        location.reload();
                    }

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    // $('#content').html(errorMsg);
                }
            });
        }
    });
    $('.japplybtn').click(function(){
        
        if(is_admin==1 && reference_url!=''){
            openInNewTabWithNoopener(reference_url);
        }else{
            var data = {"_token": csrf_token,'is_login':v_is_login };
            jobApply(apply_req_url, data);
        }
    });

    $('.submit').click(function(){

        // form validation starts
        clrErr();
        var errStaus = false;
        $('.quiz').each(function(){
            quizerrStaus = false;
            code = $(this).attr('data-dsw3w14');
            type = $(this).attr('data-dsw3w15');
            bp = $(this).attr('data-bp');

            if(bp=='yes'){
                var inputname = 'answer_'+code;   
                if(type=='text' || type=='textarea' || type=='select'){
                    if(($.trim($('#'+inputname).val()) == '' || $('#'+inputname).val() == 0)){
                        errStaus=quizerrStaus=true;
                    }         
                }
                if(type=='single'){
                    if($("input[name="+inputname+"]:checked").length  == 0){
                        errStaus=quizerrStaus=true;
                    }          
                }
                if(type=='multiple'){   
                    if($("input[name='"+inputname+"[]']:checked").length  == 0){
                        errStaus=quizerrStaus=true;
                    }      
                }
            }
            if(quizerrStaus==true){
                $(this).find('.es2wa7s').html('Field is required');
            }

        });

        // form validation ends

        if(errStaus == true)
        {
            $('.es2wa7sd').html('Fill all above required field');
        }else
        {
            var form = $('#screeningQuiz');
            var req_url = form.attr('action');
            var data = form.serialize();
            jobApply(req_url, data);

        }

    });

    $('.skip-submit').click(function(){        
        var data = {"_token": csrf_token,'is_login':v_is_login,'skip_screening':'yes' };
        jobApply(apply_req_url, data);
    });

    function jobApply(req_url, data) {

        if(1) {
            $("#japplied-btn").hide();
            let btn = $(".japply-btn");
            $(btn).prop("disabled", true);

            $.ajax({
                url: req_url,
                type: 'POST',
                data : data,
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
                        $(".japplied-btn").show();
                        $(btn).hide();
                    }
                    else{
                        $(btn).html(
                            `<img draggable="false" class="image-size" src="${baseurl}site_assets_1/assets/img/apply2.png" alt="Apply"> <span class="fw-bold"> Apply</span></button>`
                        );
                        $(".japplied-btn").hide();
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
                    else if(redir == 'already_applied'){
                        $('#jasuccess').html('<div class="alert alert-success alert-dismissible">'
                            +resp.message
                            +'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
                            +'</div>');
                            $(".japplied-btn").show();
                            $(btn).hide();
                            $('#screeningQuiz72ers3').modal('hide');
                    }else if(redir == ''){
                        $('#jasuccess').html('<div class="alert alert-success alert-dismissible">'
                        +resp.message
                        +'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
                        +'</div>');
                        $(".japplied-btn").show();
                        $(btn).hide();
                        $('#screeningQuiz72ers3').modal('hide');
                    
                    }
                    else{ 
                        if(resp.success == false){
                            var html = `<div class="modal-content">
                                <div class="modal-body pending">
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
                        }
                        elseif(reload_page)
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
        
    function clrErr(){
        $(".form-group, .checkbox,.col-xs-8" ).removeClass( "has-error" );
        $(".err_msg").html('');
        $('.select2-selection--single').removeClass('select2-is-invalid');
        
        let isinvcls = document.querySelectorAll('.is-invalid');
        isinvcls.forEach(function(item) {
            item.classList.remove('is-invalid');
        });
    }