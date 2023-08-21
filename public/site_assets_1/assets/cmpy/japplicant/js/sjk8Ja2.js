
var act_jid = job_key_from_url;
var act_jsmk = job_status;
var defau_act_ftab = 'applied';
var act_ftab = 'applied';
var jobp_api_url = 'company/api_posted_joblist';
var candi_api_url = 'company/applicantlist';
var candi_status_changes_url = baseurl + 'company/applicationStatusUpdate';

if (act_jid && act_jsmk) {
    job_status_menu_active(act_jsmk);
    load_job_list({'invoke_by':'initial', 'jkey':act_jid,'jstatus':act_jsmk});
} else {
}

function job_status_menu_active(act_jsmk){
    $('#jsmenufid .nav-link').removeClass('active');
    $('[data-jsmenukey="'+act_jsmk+'"]').addClass('active');
}

$(document).on('click', '#jsmenufid .nav-link', function (event) {
    event.preventDefault();
    act_jsmk = $(this).data('jsmenukey');
    // $('#jsmenufid .nav-link').removeClass('active');
    // $(this).addClass('active');

    //reset filter tabs
    tabnam = '#received-tab';
    var someTabTriggerEl = document.querySelector(tabnam);
    new bootstrap.Tab(someTabTriggerEl).show();

    // reset candidate filter c_search_inp, c_sortby set as default..
    $('#c_sortby').prop('selectedIndex', 0);
    $('#c_search_inp').val('');

    job_status_menu_active(act_jsmk);
    load_job_list({'invoke_by':'jstatus_change', 'jkey':act_jid,'jstatus':act_jsmk});
});


$(document).on('click', '#tempskle2 .jlsca', function (event) {
    event.preventDefault();
    act_jid = $(this).data('jkey');
    //active current jptab
    if (!$(this).hasClass('jpcactive')) {
        // alert(jkey)
        $('#tempskle2 .jlsca').removeClass('jpcactive');
        $(this).addClass('jpcactive');

        //change url state
        change_url_state(act_jid);

        //breadcrumb title change
        jtit = $(this).find('h4').text();
        $("#bi_activ_jt").text(jtit);

        //reset main1 tabs
        tabnam = '#received-tab';
        var someTabTriggerEl = document.querySelector(tabnam);
        new bootstrap.Tab(someTabTriggerEl).show();

        //reset filter tabs
        tabnam = '#'+defau_act_ftab+'-tab';
        var someTabTriggerEl = document.querySelector(tabnam);
        // alert(tabnam)
        new bootstrap.Tab(someTabTriggerEl).show();
        
        //reset filter tab value
        act_ftab =defau_act_ftab;

        // reset candidate filter c_search_inp, c_sortby set as default..
        $('#c_sortby').prop('selectedIndex', 0);
        $('#c_search_inp').val('');


        //load candidate list
        load_candidate_list_data(act_jid,act_ftab);
    }
});

function change_url_state(jkey){
    //change url state
    the_url = window.location.href;
    resURL = url_remove_last_path(the_url);
    resURL= resURL + '/' + jkey;
    history.pushState({}, '',resURL );
}

function url_remove_last_path(the_url){
    var the_arr = the_url.split('/');
    the_arr.pop();
    return( the_arr.join('/') );
}

window.onpopstate = function(event) {
    //load the page
    // alert(window.location.href.split("/").pop())
    //change url state
    // the_url = window.location.href;
    // resURL = url_remove_last_path(the_url);
    // resURL= resURL + '/' + act_jid;
    // history.pushState({}, '',resURL );

    load_job_list({'jkey':act_jid,'jstatus':act_jsmk});
};

var jp_search_inp_ini = $('#jp_search_inp').val();
var jp_search_inp = $('#jp_search_inp').val();
$("#jp_search_btn").click(function () {
    clear_jp_search_err();
    jp_search_inp = $('#jp_search_inp').val();
    if(jp_search_inp !=''){
        if(jp_search_inp != jp_search_inp_ini){
            jp_search_inp_ini = jp_search_inp;
            load_job_list({'jkey':act_jid,'jstatus':act_jsmk,'jpsearch_inp':jp_search_inp});
        }else{
            // $('.jpsearerr').text('Please enter the search term');
            $("#jp_search_inp, #jp_search_btn").addClass("is_invalid_c1");
        }
    }
    else{
        // $('.jpsearerr').text('Please enter the search term');
        $("#jp_search_inp, #jp_search_btn").addClass("is_invalid_c1");
    }
});
$("#jp_search_inp").keyup(function () {
    clear_jp_search_err();
    jp_search_inp = $('#jp_search_inp').val();
    if(jp_search_inp ==''){
        load_job_list({'jkey':act_jid,'jstatus':act_jsmk,'jpsearch_inp':jp_search_inp});
    }
});
function clear_jp_search_err(){
    $("#jp_search_inp, #jp_search_btn").removeClass("is_invalid_c1");
}


function load_job_list(params) {

    jkey = params.jkey;
    jstatus = params.jstatus;
    search_inp = params.jpsearch_inp ?? '';
    invoke_by = params.invoke_by ?? '';

    // $('.filterTooltip, #tooltip').remove();
    
    $("#tempskle2").addClass("is-loading");
    $(".canlsection").addClass("is-loading");

    let csrf_token = $('meta[name=csrf-token]').attr('content');
    // let req_url = '/api' + window.location.search;
    let req_params = '';
    let req_url = baseurl + jobp_api_url + '?' + decodeURIComponent(req_params);

    let page_no = 1;

    $.ajax({
        url: req_url,
        type: 'POST',
        data: { "_token": csrf_token, 'jkey': jkey, 'jstatus': jstatus, 'page': page_no , 'search':search_inp },
        datatype: 'JSON',
        // beforeSend:function(){
        //     $("#tempskle2").addClass("is-loading");
        // },
        success: function (data) {
            // console.log(data)
            
            populate_joblist_data({'data':data.data,'jkey':jkey,'invoke_by':invoke_by});
            $("#tempskle2").removeClass("is-loading");
            $(".canlsection").removeClass("is-loading");
        },
        error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            // console.log(errorMsg)
            // $('#content').html(errorMsg);
        }
    });

}

function populate_joblist_data(params) {
    data = params.data;
    jkey = params.jkey;
    invoke_by = params.invoke_by;

    if (data && data.length != 0 ) {

        if(invoke_by == 'jstatus_change'){
            //autoselect fst jobpost
            jkeytt = data[0].jkey ?? null;
            if(jkeytt){
                jkey = act_jid = jkeytt;
                change_url_state(jkey);
            }
        }

        html_jp = create_jobpostlist_html(data, jkey);
        if (html_jp) {
            $("#tempskle2").html(html_jp);

            //canidatelist tabs
            $("#received_msg").html('');
            $("#received_cnt").show();
            load_candidate_list_data(jkey, act_ftab);

        }
    }else{
        $("#tempskle2").html('<p class="m-3">No posts available</p>');
        $("#received_msg").html('<p class="m-3">No data available</p>');
        $("#received_cnt").hide();
        applicant_count_reset();
    }
}

function create_jobpostlist_html(data, act_jid) {
    let html = '';
    let jkey, j_title, j_status, j_expiry_date;
    // let data = data;

    $.each(data, function (key, val) {
        jkey = val.jkey || '1';
        j_title = val.title || 'PHP Devevloper';
        j_status = val.status || '3';
        if (j_status == 1) {
            j_status = 'Active';
        } else if (j_status == 2) {
            j_status = 'In Active';
        } else if (j_status == 3) {
            j_status = 'Expired';
        } else {
            j_status = 'Expired';
        }

        j_expiry_date = val.expiry_date || '21-Aug-2022';
        j_expiry_date = format(new Date(j_expiry_date));

        if (jkey == act_jid) {
            active_cls = 'jpcactive';
        } else {
            active_cls = '';
        }

        html += '<div class="card card-body jlsca ' + active_cls + '" data-jkey="' + jkey + '">';
        html += '<h4 class="fw-bolder">' + j_title + '</h4>';
        html += '<text class="mb-1">Job Status : <strong class="text-dark fw-bolder">' + j_status + '</strong></text>';
        if(j_status == 'Expired'){
            html += '<text class="text-black-50">Expired on : ' + j_expiry_date + '</text>';
        }else{
            html += '<text class="text-black-50">Expires on : ' + j_expiry_date + '</text>';
        }
        
        html += '</div>';
    });
    // console.log(html)
    return html;
}


$(document).on('click', '#candiftabs .nav-item', function (event) {
    event.preventDefault();
    act_ftabtemp = $(this).children().attr('id');
    act_ftabtemp = act_ftabtemp.replace('-tab','');
    
    //get count if 0 dontcall api
    act_ftab_rc = $(this).children().children().text().trim();
    act_ftab_rc = act_ftab_rc.replace('(','').replace(')','');
    
    if(act_ftab_rc == 0){
        ftab_section = '#'+act_ftabtemp + '-c';
        $html =`<div class="mt-5 text-center"><h4>No Data Found</h4></div>`;
        $(ftab_section).html($html);
        disable_candi_sort_sear_actions();
    }else{
        act_ftab = act_ftabtemp;
        //active current jptab
        act_ftab = act_ftab.replace('-tab','');
        load_candidate_list_data(act_jid, act_ftab);
    }
    
    // c_search_inp, c_sortby set as default..
    $('#c_sortby').prop('selectedIndex', 0);
    $('#c_search_inp').val('');
});


var c_search_inp_ini = $('#c_search_inp').val();
var c_sortby_ini = $('#c_sortby').val();
var c_search_inp = $('#c_search_inp').val();
var c_sortby = $('#c_sortby').val();
$("#c_search_btn").click(function () {
    clear_c_search_err();
    c_search_inp = $('#c_search_inp').val();

    //when no data disable filter
    //get count if 0 dontcall api
    act_ftab_rc = $("#"+act_ftab+"_rc").text().trim();
    act_ftab_rc = act_ftab_rc.replace('(','').replace(')','');
    
    if(c_search_inp !='' ){
        if(c_search_inp != c_search_inp_ini){
            c_search_inp_ini = c_search_inp;
            load_candidate_list_data(act_jid, act_ftab, 1, c_search_inp, c_sortby_ini);
        }else{
            $("#c_search_inp, #c_search_btn").addClass("is_invalid_c1");
        }
    }
    else{
        $("#c_search_inp, #c_search_btn").addClass("is_invalid_c1");
    }
});

$("#c_search_inp").keyup(function () {
    clear_c_search_err();
    c_search_inp = $('#c_search_inp').val();
    if(c_search_inp ==''){
        load_candidate_list_data(act_jid, act_ftab, 1, c_search_inp, c_sortby_ini);
    }
});
function clear_c_search_err(){
    $("#c_search_inp, #c_search_btn").removeClass("is_invalid_c1");
}

$("#c_sortby").change(function () {
    c_sortby = $('#c_sortby').val();

    //when no data disable filter
    //get count if 0 dontcall api
    act_ftab_rc = $("#"+act_ftab+"_rc").text().trim();
    act_ftab_rc = act_ftab_rc.replace('(','').replace(')','');
    if(c_sortby !='' && act_ftab_rc >=2 ){
        if(c_sortby != c_sortby_ini){
            c_sortby_ini = c_sortby;
            load_candidate_list_data(act_jid,act_ftab,1,c_search_inp,c_sortby);
        }else{
            // $('.csearerr').text('Please enter the search term');
        }
    }
    else{
        // $('.csearerr').text('Please enter the search term');
    }
});

$(document).on('click', '.pagination a', function (event) {
    event.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    load_candidate_list_data(act_jid, act_ftab, page);
});


function disable_candi_sort_sear_actions(){
    $("#c_search_inp").attr("disabled", true);
    $("#c_sortby").attr("disabled", true);
}

function enable_candi_sort_sear_actions(){
    $("#c_search_inp").attr("disabled", false);
    $("#c_sortby").attr("disabled", false);
}

function load_candidate_list_data(act_jid, ftab_key, page_no = 1, search_inp='', sort_by='applied_date_new' ) {

    ftabid = "#" + ftab_key;

    clear_c_search_err()

    let csrf_token = $('meta[name=csrf-token]').attr('content');
    let req_params = '';
    let req_url = baseurl + candi_api_url + '?' + decodeURIComponent(req_params);

    $.ajax({
        url: req_url,
        type: 'POST',
        data: { "_token": csrf_token, 'jkey': act_jid,'ftab_key': ftab_key, 'jstatus': ftab_key, 'search': search_inp, 'sort_by': sort_by, 'page': page_no},
        datatype: 'JSON',
        beforeSend: function () {
            $(ftabid).addClass("is-loading");
        },
        success: function (response) {
            // console.log(json);

            populate_applicantlist_data({'response':response,'ftab_key':ftab_key});

            $(ftabid).removeClass("is-loading");
        },
        error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            // console.log(errorMsg);
            // $('#content').html(errorMsg);
        }
    });

}

function populate_applicantlist_data(params) {
    data = params.response.datas;
    ftab_key = params.ftab_key;

    ftabid = "#" + ftab_key;
    ftab_section = '#' + ftab_key + '-c';
    ftab_paginate_section = '#'+ftab_key + '-paginate';

    resCountArr = params.response.count;
    applicant_count_change(resCountArr);
    applicant_filters_count_change(resCountArr);

    if (data && data.length != 0 ) {
        // console.log('cccc');
        html_candi = applicantsListHtml(params.response, ftab_key);
        applicant_filters_count_change(resCountArr);
        if (html_candi) {
            enable_candi_sort_sear_actions();
            $(ftab_section).html(html_candi);
            $(ftab_paginate_section).html(params.response.paginate_html);
        } 
    }else{
        // applicant_filters_count_reset();
        // $(ftab_section).html('');
        $html =`<div class="mt-5 text-center"><h4>No Data Found</h4></div>`;
        $(ftab_section).html($html);
    }
}


$(document).on('click', '#level1candiftabs .nav-item', function (event) {
    event.preventDefault();
    act_ftabtt = $(this).children().attr('id');
    
    //get count if 0 dontcall api
    act_ftab_rc = $(this).children().children().text().trim();
    act_ftab_rc = act_ftab_rc.replace('(','').replace(')','');
    
    if(act_ftab_rc == 0){
        // alert(act_ftabtt)
        ftab_section = '#'+act_ftabtt + '-c';
        $html =`<div class="mt-5 text-center"><h4>No Data Found</h4></div>`;
        // $(ftab_section).html($html);
        $("#suggested_msg").html($html);
        $("#suggested_cnt").hide();      

    }else{
        
        act_ftab = act_ftabtt.replace('-tab','');
        if( act_ftab == 'suggested' ){
            // only load
            act_ftab='suggested';
            load_candidate_list_data(act_jid, act_ftab);

            $("#suggested_msg").html('');
            $("#suggested_cnt").show();
        }
    }
    
    // c_search_inp, c_sortby set as default..
    $('#c_sortby').prop('selectedIndex', 0);
    $('#c_search_inp').val('');
});


function format(inputDate) {
    console.log(inputDate)
    let date, month, year;
    const monthname = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];

    date = inputDate.getDate();
    // month = inputDate.getMonth() + 1;
    let month_shna = monthname[inputDate.getMonth()];
    year = inputDate.getFullYear();
  
    date = date
        .toString()
        .padStart(2, '0');
    // month = month
    //     .toString()
    //     .padStart(2, '0');
  
    return `${date}-${month_shna}-${year}`;
}


function applicant_filters_count_change(resCountArr){
    // console.log(resCountArr)
    // resCountArr = resp.count;
    // filterAr1 = ['applied','viewed','shortlisted','considered','rejected'];
    if(1){
        $('#applied_rc').html(' (' + (resCountArr.applied??0) +')');
        $('#viewed_rc').html(' ('+ (resCountArr.viewed??0) +')');
        $('#shortlisted_rc').html(' ('+ (resCountArr.shortlisted??0) +')');
        $('#considered_rc').html(' ('+ (resCountArr.considered??0) +')');
        $('#rejected_rc').html(' ('+ (resCountArr.rejected??0) +')');
    }
}
function applicant_filters_count_reset(){
    if(1){
        $('#applied_rc').html(' (0)');
        $('#viewed_rc').html(' (0)');
        $('#shortlisted_rc').html(' (0)');
        $('#considered_rc').html(' (0)');
        $('#rejected_rc').html(' (0)');
    }
}

function applicant_count_change(resCountArr){
    if(1){
        $('#received_rc').html(' (' + (resCountArr.received??0) +')');
        $('#suggested_rc').html(' ('+ (resCountArr.suggested??0) +')');
    }
}
function applicant_count_reset(){
    if(1){
        $('#received_rc').html(' (0)');
        $('#suggested_rc').html(' (0)');
    }
}

function applicantsListHtml(resp,ftab_key){

    $html = "";
    candi_data = resp.datas;
    // alert(ftab_key);

    if(candi_data.length!=0){

        $.each(candi_data, function(key,val) {
            var user = val.userdetail;
            $html += `<div class="card card-body candpcard" data-id="`+val.id+`" data-appstatus="`+val.application_status+`">
                <div class="col-md-12 d-flex flex-row rounded">
                <div class="col-md-7">
                    <div class="border-left ccontse">
                        <h2 class="text-default fw-bolder mb-2">`+user.name+`</h2>`;
                        // $html +=`<h4 class="mb-1">`+user.gender+`, `+user.age+`</h4>`;
                        
                        $html +=`<div class="row mt-1">
                        <div class="row col-md-12 mb-2">
                            <div class="col-md-5">
                            <label class="text-default">Designation</label>
                            </div>
                            <div class="col-md-7 d-flex">
                                <div class="me-1">:</div>
                                <div class="text-truncate-2"><text>`+user.career_title+`</text></div>
                            </div>
                        </div>
                        
                        <div class="row col-md-12 mb-2">
                            <div class="col-md-5">
                            <label class="text-default">Total Experience</label>
                            </div>
                            <div class="col-md-7 d-flex">
                                <div class="me-1">:</div>
                                <div class="text-truncate-2"><text>`+user.total_experience+`</text></div>
                            </div>
                        </div>`;
                        if(user.availability_to_join!=null){
                        $html +=`<div class="row col-md-12 mb-2">
                            <div class="col-md-5">
                            <label class="text-default">Availablility to join</label>
                            </div>
                            <div class="col-md-7 d-flex">
                                <div class="me-1">:</div>
                                <div class="text-truncate-2"><text>`+user.availability_to_join+`</text></div>
                            </div>
                        </div>`;
                        }
                        // $html +=`<div class="row col-md-12 mb-2">
                        //     <div class="col-md-4">
                        //     <label class="text-default">Email</label>
                        //     </div>
                        //     <div class="col-md-8 d-flex">
                        //         <div class="me-1">:</div>
                        //         <div class="text-truncate-2"><text>`+user.email+`</text></div>
                        //     </div>
                        // </div>`;

                         $html +=`<div class="row col-md-12 mb-2">
                            <div class="col-md-5">
                            <label class="text-default">Current Location</label>
                            </div>
                            <div class="col-md-7 d-flex">
                                <div class="me-1">:</div>
                                <div class="text-truncate-2"><text>`+user.location+`</text></div>
                            </div>
                        </div>
                        </div>
                        <hr>
                        <div class="row mt-1">`;
                        // $html +=`<div class="row col-md-12 mb-2">
                        //     <div class="col-md-4">
                        //     <label class="text-default">Highest Education</label>
                        //     </div>
                        //     <div class="col-md-8 d-flex">
                        //         <div class="me-1">:</div>
                        //         <div class="text-truncate-2"><text>`+user.education+`</text></div>
                        //     </div>
                        // </div>`;
                        if(user.skill != null){
                        $html +=`<div class="row col-md-12 mb-4">
                                <div class="col-md-5">
                                <label class="text-default">Skills</label>
                                </div>
                                <div class="col-md-7 d-flex">
                                    <div class="me-1">:</div>
                                    <div class="text-truncate-1"><text>`+user.skill+`</text></div>
                                </div>
                            </div>`;
                        }  
                        
                        if(ftab_key!='suggested'){
                            $html +=`<div class="row col-md-12">
                            <h6 class="text-default">Applied `+ (val.created_at ? timeSince(val.created_at):'nil') +`</h6>
                            </div>`;
                        }

                    $html +=`</div>
                    </div>
                </div>
                <div class="col-md-5 ">
                    <div class="ovlapcard">
                    <div class="card-block">
                        <div class="row p-3 align-items-center justify-content-center">`;
                        $html +=`<div class="col-md-8 text-center">
                        <div class="row">
                            <div class="col p-0 ">`;
                                if(user.is_image=='yes'){
                                    $html +=`<div class="avatar avatar-md"> <img draggable="false" src="`+user.image+`" alt="Img" class="img-fluid rounded-circle"></div>`;
                                }else{                                    
                                    $html +=`<div class="avatar avatar-md" id="profileImage">`+user.avatar+`</div>`;
                                }         
                                $html +=`</div>
                                <div class="col p-0 text-start">
                                    <h4 class="fw-bolder">Profile Match</h4>
                                    <h2 class="fw-bolder">`+val.percentage+`%</h2>
                                </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="p-2">
                            <div class="p-0">
                            <div class="btn-rounded ">
                                <a href="`+(user.phone ? ('tel:'+user.phone):'#')+`"><button type="button" class="btn btn-icon ">
                                    <img draggable="false" src="${baseurl}site_assets_1/assets/img/candiimg/phone_24@2x.png" class="img-thumbnail border-0 imcs1" />
                                </button></a>`;
                                // $html +=`<button type="button" class="btn btn-icon btnspl_2">
                                //     <img draggable="false" src="${baseurl}site_assets_1/assets/img/candiimg/whatsapp_24@2x.png" class="img-thumbnail border-0 imcs1" />
                                // </button>`;
                            $html +=`</div>
                            </div>
                        </div>                           
                    </div>`;
                            
                    $html +=`</div>
                        <div class="row p-3 text-center">
                        <div class="col">
                            <div class="p-0 ">`;
                            if(ftab_key!='suggested')
                            {
                                $html +=`<div class="p-0 ">
                                    <button type="button" class="btn btn-icon btn-round btnact_st" data-value="shortlist" id="st_shortlist`+val.id+`">`;
                                    if(val.application_status == 'shortlist'){
                                        $html +=`<img draggable="false" src="${baseurl}site_assets_1/assets/img/candiimg/shortlist_c.png" class="img-fluid img-thumbnail imcsstat" />`;
                                    }else{
                                        $html +=`<img draggable="false" src="${baseurl}site_assets_1/assets/img/candiimg/shortlist.png" class="img-fluid img-thumbnail imcsstat" />`;
                                    }
                                        $html +=`</button>
                                </div>
                                <text>Shortlist</text>`;
                            }
                            $html +=`</div>
                        </div>
                        <div class="col">
                            <div class="p-0 ">`;
                            if(ftab_key!='suggested')
                            {
                                $html +=`<div class="p-0 ">
                                <button type="button" class="btn btn-icon btn-round btnact_st" data-value="consider" id="st_consider`+val.id+`">`;
                                if(val.application_status == 'consider'){
                                    $html +=`<img draggable="false" src="${baseurl}site_assets_1/assets/img/candiimg/consider_c.png" class="img-fluid img-thumbnail imcsstat" />`;
                                }else{
                                    $html +=`<img draggable="false" src="${baseurl}site_assets_1/assets/img/candiimg/consider.png" class="img-fluid img-thumbnail imcsstat" />`;
                                }
                                $html +=`</button>
                            </div>
                            <text>Consider</text>`;
                            }
                            
                            $html +=`</div>
                        </div>
                        <div class="col">
                            <div class="p-0 ">`;
                            if(ftab_key!='suggested')
                            {
                            $html +=`<div class="p-0 ">
                                <button type="button" class="btn btn-icon btn-round btnact_st" data-value="reject" id="st_reject`+val.id+`">`;
                                if(val.application_status == 'reject'){
                                    $html +=`<img draggable="false" src="${baseurl}site_assets_1/assets/img/candiimg/reject_c.png" class="img-fluid img-thumbnail imcsstat" />`;
                                }else{
                                    $html +=`<img draggable="false" src="${baseurl}site_assets_1/assets/img/candiimg/reject.png" class="img-fluid img-thumbnail imcsstat" />`;
                            } $html +=`</button>
                                </div>
                                <text>Reject</text>`;
                            } 
                        $html +=`</div>
                            </div>
                        </div>
        
        
                        <div class="row p-3 text-center">
                        <div class="col">
                            <div class="p-0 ">
                            <button class="btn btn-rounded rcbtnc1 resume" data-aci="`+user.cv+`">View Resume</button>
                            </div>
                        </div>
                        <div class="col">
                            <div class="p-0 ">
                            <a class="btn btn-rounded rcbtnc2" href="`+baseurl+`company/applicant-profile/`+val.id+`"> View Profile</a>
                            </div>
                        </div>
                        </div>
        
                    </div>
                    
                    </div>
                </div>        
                </div>
            </div>`;
        });

    }else{
        $html +=`<div class="mt-5 text-center">
            <h4>No Data Found</h4>
        </div>`;
    }
    return $html;

}

$(document).on('click', '.resume' , function(e){
    const aTag = document.createElement('a');
    aTag.rel = 'noopener noreferer';
    aTag.target = "_blank";
    aTag.href = cv_download_url + $(this).data("aci");
    aTag.click();
});

$(document).on('click', '.btnact_st' , function(e){
    var cdata = $(this);
    CandidateStatusUpdate(cdata);
});

function CandidateStatusUpdate(cdata){   

    ftabid = "#" + ftab_key;

    let csrf_token = $('meta[name=csrf-token]').attr('content');
    
    var a_id = $(cdata).closest('.candpcard').attr('data-id');
    var cstatus = $(cdata).closest('.candpcard').attr('data-appstatus');
    var status = $(cdata).attr('data-value');
    
    if(cstatus!=status){                
        $.ajax({
            type: "POST",
            url: candi_status_changes_url,
            data: {"_token": csrf_token, "apply_id": a_id, "status": status},
            datatype: 'json',
            beforeSend: function () {
                $(ftabid).addClass("is-loading");
            },
            success: function (json) {
                toastr.success(json.message);
                $(ftabid).removeClass("is-loading");
                //load candidate list
                load_candidate_list_data(act_jid,act_ftab);

                if(act_ftab=='received'){
                    $(cdata).closest('.candpcard').attr('data-appstatus', status);
                }else{
                    $(cdata).closest('.candpcard').remove();
                }

                if(status=='shortlist'){
                    $('#st_shortlist'+a_id).html(`<img draggable="false" src="${baseurl}site_assets_1/assets/img/candiimg/shortlist_c.png" class="img-fluid img-thumbnail imcsstat" />`);
                    $('#st_consider'+a_id).html(`<img draggable="false" src="${baseurl}site_assets_1/assets/img/candiimg/consider.png" class="img-fluid img-thumbnail imcsstat" />`);
                    $('#st_reject'+a_id).html(`<img draggable="false" src="${baseurl}site_assets_1/assets/img/candiimg/reject.png" class="img-fluid img-thumbnail imcsstat" />`);
                }
                if(status=='consider'){
                    $('#st_shortlist'+a_id).html(`<img draggable="false" src="${baseurl}site_assets_1/assets/img/candiimg/shortlist.png" class="img-fluid img-thumbnail imcsstat" />`);
                    $('#st_consider'+a_id).html(`<img draggable="false" src="${baseurl}site_assets_1/assets/img/candiimg/consider_c.png" class="img-fluid img-thumbnail imcsstat" />`);
                    $('#st_reject'+a_id).html(`<img draggable="false" src="${baseurl}site_assets_1/assets/img/candiimg/reject.png" class="img-fluid img-thumbnail imcsstat" />`);                    
                }
                if(status=='reject'){
                    $('#st_shortlist'+a_id).html(`<img draggable="false" src="${baseurl}site_assets_1/assets/img/candiimg/shortlist.png" class="img-fluid img-thumbnail imcsstat" />`);
                    $('#st_consider'+a_id).html(`<img draggable="false" src="${baseurl}site_assets_1/assets/img/candiimg/consider.png" class="img-fluid img-thumbnail imcsstat" />`);
                    $('#st_reject'+a_id).html(`<img draggable="false" src="${baseurl}site_assets_1/assets/img/candiimg/reject_c.png" class="img-fluid img-thumbnail imcsstat" />`);                    
                }
            }
        });
    }

}


function timeSince(date){
    let $res ='30+ days ago';
    
    let curr_timez = new Date(date).getTime(); //GMT to localtime
    cur_sec = new Date().getTime(); // get localtime
    // post_time = Date.parse(date);
    // console.log("asd "+post_time);
    
    // Time difference in seconds
    let diff = Math.floor((cur_sec - curr_timez) / 1000);
    $sec=diff;
    $min = Math.round(diff / 60 );
    $hrs = Math.round(diff / 3600);
    $days= Math.round(diff / 86400 );
    // Convert time difference in weeks
    // $weeks     = round(diff / 604800);
    // Convert time difference in months
    // $mnths     = round(diff / 2600640 );
    // Convert time difference in years
    // $yrs     = round(diff / 31207680 );
    //  console.log("sec:"+ $sec + " min:"+ $min +" hrs:"+ $hrs + " days:"+$days)
    // Check for seconds
    if($sec <= 0){
        $res= "Just now";
    } 
    else if($sec < 60) {
        $res= $sec+" seconds ago";
    }
    else if($min < 60) {
        if($min==1) {
            $res="1 minute ago";
        }
        else {
            $res= $min+" minutes ago";
        }
    }
    else if($hrs < 24) {
        if($hrs == 1) { 
            $res="1 hour ago";
        }
        else{
            $res=$hrs +" hours ago";
        }
    }
    else if($days < 31) {
        if($days == 1) {
            $res="1 day ago";
        }
        else {
            $res= $days+" days ago";
        }
    }
    else {
        $res="30+ days ago";
    }
    return $res;
}

function get_static_reponse_jpost()
{
    temp ='{"success":true,"data":[';
    temp    += '{"jkey":"fOTd0goLUv-42","title":"Junior Web Developer","expiry_date":"2022-10-03T12:29:34.000000Z","status":1,"experience_string":null,"salary_string":"","work_locations":"","benefits":"","supplementals":"","shortlistedcount":0,"job_work_location":[],"jobbenefits":[],"jobsupplementals":[],"applied_users":[]}';
    temp    += ',{"jkey":"fOTd0goLUv-42","title":"Junior Web Developer","expiry_date":"2022-10-03T12:29:34.000000Z","status":1,"experience_string":null,"salary_string":"","work_locations":"","benefits":"","supplementals":"","shortlistedcount":0,"job_work_location":[],"jobbenefits":[],"jobsupplementals":[],"applied_users":[]}';
    temp    += ',{"jkey":"fOTd0goLUv-42","title":"Junior Web Developer","expiry_date":"2022-10-03T12:29:34.000000Z","status":1,"experience_string":null,"salary_string":"","work_locations":"","benefits":"","supplementals":"","shortlistedcount":0,"job_work_location":[],"jobbenefits":[],"jobsupplementals":[],"applied_users":[]}';
    temp    += ',{"jkey":"fOTd0goLUv-42","title":"Junior Web Developer","expiry_date":"2022-10-03T12:29:34.000000Z","status":1,"experience_string":null,"salary_string":"","work_locations":"","benefits":"","supplementals":"","shortlistedcount":0,"job_work_location":[],"jobbenefits":[],"jobsupplementals":[],"applied_users":[]}';
    temp    += ',{"jkey":"fOTd0goLUv-42","title":"Junior Web Developer","expiry_date":"2022-10-03T12:29:34.000000Z","status":1,"experience_string":null,"salary_string":"","work_locations":"","benefits":"","supplementals":"","shortlistedcount":0,"job_work_location":[],"jobbenefits":[],"jobsupplementals":[],"applied_users":[]}';
    temp    += ',{"jkey":"fOTd0goLUv-42","title":"Junior Web Developer","expiry_date":"2022-10-03T12:29:34.000000Z","status":1,"experience_string":null,"salary_string":"","work_locations":"","benefits":"","supplementals":"","shortlistedcount":0,"job_work_location":[],"jobbenefits":[],"jobsupplementals":[],"applied_users":[]}';
    temp    += ',{"jkey":"fOTd0goLUv-42","title":"Junior Web Developer","expiry_date":"2022-10-03T12:29:34.000000Z","status":1,"experience_string":null,"salary_string":"","work_locations":"","benefits":"","supplementals":"","shortlistedcount":0,"job_work_location":[],"jobbenefits":[],"jobsupplementals":[],"applied_users":[]}';
    temp    += ',{"jkey":"fOTd0goLUv-42","title":"Junior Web Developer","expiry_date":"2022-10-03T12:29:34.000000Z","status":1,"experience_string":null,"salary_string":"","work_locations":"","benefits":"","supplementals":"","shortlistedcount":0,"job_work_location":[],"jobbenefits":[],"jobsupplementals":[],"applied_users":[]}';
    temp    += ',{"jkey":"fOTd0goLUv-42","title":"Junior Web Developer","expiry_date":"2022-10-03T12:29:34.000000Z","status":1,"experience_string":null,"salary_string":"","work_locations":"","benefits":"","supplementals":"","shortlistedcount":0,"job_work_location":[],"jobbenefits":[],"jobsupplementals":[],"applied_users":[]}';
    temp    += ',{"jkey":"fOTd0goLUv-42","title":"Junior Web Developer","expiry_date":"2022-10-03T12:29:34.000000Z","status":1,"experience_string":null,"salary_string":"","work_locations":"","benefits":"","supplementals":"","shortlistedcount":0,"job_work_location":[],"jobbenefits":[],"jobsupplementals":[],"applied_users":[]}';
    temp    += ',{"jkey":"fOTd0goLUv-42","title":"Junior Web Developer","expiry_date":"2022-10-03T12:29:34.000000Z","status":1,"experience_string":null,"salary_string":"","work_locations":"","benefits":"","supplementals":"","shortlistedcount":0,"job_work_location":[],"jobbenefits":[],"jobsupplementals":[],"applied_users":[]}';
    temp    += ',{"jkey":"fOTd0goLUv-42","title":"Junior Web Developer","expiry_date":"2022-10-03T12:29:34.000000Z","status":1,"experience_string":null,"salary_string":"","work_locations":"","benefits":"","supplementals":"","shortlistedcount":0,"job_work_location":[],"jobbenefits":[],"jobsupplementals":[],"applied_users":[]}';
    temp    += ',{"jkey":"fOTd0goLUv-42","title":"Junior Web Developer","expiry_date":"2022-10-03T12:29:34.000000Z","status":1,"experience_string":null,"salary_string":"","work_locations":"","benefits":"","supplementals":"","shortlistedcount":0,"job_work_location":[],"jobbenefits":[],"jobsupplementals":[],"applied_users":[]}';
    // temp    += ',{"jkey":"Vm8xDskCnq-26","title":"Content Writer","expiry_date":"2022-09-21T04:55:56.000000Z","status":1,"experience_string":null,"salary_string":"","work_locations":"","benefits":"","supplementals":"","shortlistedcount":0,"job_work_location":[],"jobbenefits":[],"jobsupplementals":[],"applied_users":[]},{"jkey":"TU5OOzl9m8-36","title":"Senior Content Writer","expiry_date":"2022-09-26T07:28:31.000000Z","status":1,"experience_string":null,"salary_string":"","work_locations":"","benefits":"","supplementals":"","shortlistedcount":0,"job_work_location":[],"jobbenefits":[],"jobsupplementals":[],"applied_users":[]},{"jkey":"EXMWg8IY2I-38","title":"iOS Developer","expiry_date":"2022-10-01T05:16:50.000000Z","status":1,"experience_string":null,"salary_string":"","work_locations":"","benefits":"","supplementals":"","shortlistedcount":0,"job_work_location":[],"jobbenefits":[],"jobsupplementals":[],"applied_users":[]},{"jkey":"BWeXqeDVAb-39","title":"Senior iOS Developer","expiry_date":"2022-10-02T06:49:00.000000Z","status":1,"experience_string":null,"salary_string":"","work_locations":"","benefits":"","supplementals":"","shortlistedcount":0,"job_work_location":[],"jobbenefits":[],"jobsupplementals":[],"applied_users":[]},{"jkey":"uz9QRsrKRV-40","title":"Junior iOS Developer","expiry_date":"2022-10-02T08:58:27.000000Z","status":1,"experience_string":null,"salary_string":"","work_locations":"","benefits":"","supplementals":"","shortlistedcount":0,"job_work_location":[],"jobbenefits":[],"jobsupplementals":[],"applied_users":[]}';
    temp    +=']}';
    return JSON.parse(temp);
}