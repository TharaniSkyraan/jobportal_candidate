var FilterGroupSetCount=4;
var FilterMenus = ['citylFGid','salaryFGid','jobtypeFGid','edulevelFGid','wfhtypeFid','industrytypeGid','functionalareaGid'];
var FilterMenu_Experince ='experinceFv';

function _isEmpty(value){
    // if (typeof value !== 'undefined' && value) {
    //     //deal with value'
    // };
    return (value == null || value.length === 0 || value);
}

$(document).on('click', '.filter-more-link' , function(e){
    
    $('.filterTooltip, #tooltip').hide();
    let FG_id = $(this).parent().parent().data('filter-id');
    
    Filters = localStorage.getItem('filters_obj');
    Filters = Filters ? JSON.parse(Filters) : {};

    let checked_data = getParams();
    data = Filters[FG_id] || [];
    if(data){
        //get filter title
        let FG_id_title = $(this).parent().parent().parent().parent().find(".filterHeading p").text() || 'Filter';
        data = data.slice(FilterGroupSetCount);
        html = createFilterOptions_Morebox(FG_id, data, checked_data, FG_id_title);
        $(this).parent().after( html );
    }
});

$(document).on('click', '.jpaxicon-cross' , function(e){
    // $('.filterTooltip, #tooltip').hide();
    $('.filterTooltip, #tooltip').remove();
});

$(document).click(function(e){
    let container = $(".filterTooltip");
    let container_2 = $(".filter-more-link");
    let container_3 = $(".applied-link");
    // alert(container.has(e.target).length +'ss'+ container_2.has(e.target).length)
    // if the target of the click isn't the container nor a descendant of the container
    if (!container.is(e.target) && container.has(e.target).length === 0
      && !container_2.is(e.target) && container_2.has(e.target).length === 0 
      && !container_3.is(e.target) && container_3.has(e.target).length === 0 
      )
    {
        // container.hide();
        container.remove();
    }

});

$(document).on('click', '.jobcard' , function(){
    
    let jobid = $(this).data('jobid');
    if(jobid != '' ){
        url = baseurl + 'detail/'+ jobid;
        openInNewTabWithNoopener(url)
    }
});

window.onpopstate = function(event) {
    //load the page
    // alert(history.state)
    processing_data();
};


processing_data();


function processing_data(calby='onload'){

    $('.filterTooltip, #tooltip').remove();
    $("#tempskle").addClass("is-loading");

    let csrf_token = $('meta[name=csrf-token]').attr('content');
    // let req_url = '/api/search' + window.location.search;

    let desig = $("#designation").val();
    let locat = $("#location").val();
    let sortBy = $("#sortby").val();

    const url = new URL(window.location.href);
    let req_params = new URLSearchParams(url.search);
    req_params.append('d',desig);
    req_params.append('l',locat);
    req_params.append('sortBy',sortBy);

    let req_url = baseurl + 'api/search' + '?' + decodeURIComponent(req_params);

    $.ajax({
        url: req_url,
        type: 'POST',
        data : {"_token": csrf_token },
        datatype: 'JSON',
        // beforeSend:function(){
        //     $("#tempskle").addClass("is-loading");
        // },
        success: function(data){
            // console.log(data)
            populateData(data);
            $("#tempskle").removeClass("is-loading");
        },
        error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            // console.log(errorMsg)
            // $('#content').html(errorMsg);
        }
    });

}

function populateData(JsonRes){
    
    let getParamsArr = getParams();

    // var JsonRes = getstaticeResponse();
    let Filters = JsonRes.filters;
    // console.log(Filters)
    localStorage.setItem('filters_obj', JSON.stringify(Filters));

    let filtersArr = Object.keys(Filters);

    let fArr;
    let Fnum=1;
    filtersArr.forEach( function(e,val) {
        fArr =  Filters[e] || [];
        if(fArr != undefined || fArr != '' || fArr != [] ){

            farr_count = fArr.length;
            enableMoreBox=false; Morecount=0;
            if( farr_count > FilterGroupSetCount){
                enableMoreBox=true;
                Morecount = Math.abs(farr_count - FilterGroupSetCount);
            }
            
            fShowlist = fArr.slice(0, FilterGroupSetCount);
            fShowMorelist = fArr.slice(FilterGroupSetCount);
            
            htmls ='';
            if(fShowlist.length != 0){
                //show filter
                showHideFilterMenu(true,e);
                htmls = createFilterOptions(e, fShowlist,getParamsArr,Fnum++);
                htmls += enableMoreBox ? moreLink_HTMLstring(Morecount) : '';
            }
            else{                
                //hide filter
                showHideFilterMenu(false,e);
            }

            Filters_div = '[data-filter-id="'+e+'"]';
            // console.log(Filters_div);
            $(Filters_div).html("");
            $(Filters_div).html(htmls);
        }
    });

    let jobsList = JsonRes.joblist;
    if(_isEmpty(jobsList)){

        let sortbyC = JsonRes.sortBy || '';
        if( sortbyC != '' ){
            // sortbyC
            sortbyValueSetup(sortbyC);
        }

        let total_resCnt = jobsList.total || 0;
        let per_page = jobsList.per_page || 0;
        let jobsListArr = jobsList.data || [];
        
        let from_pn = jobsList.from || 0;
        let to_pn = jobsList.to || 0;

        if(total_resCnt){
            // 1 - 20 of 379 jobs
            resTotatxt = from_pn+' - '+to_pn+' of '+ total_resCnt + ' jobs';
            // resTotatxt = 
            $(".t_pgres").text(resTotatxt);

            appliedJobids = JsonRes.appliedJobids || [];
            jlhtml = createJoblistDiv(jobsListArr,appliedJobids);
           
            paginateData = {};
            paginateData.links = jobsList.links || [];
            paginateData.per_page = per_page;
            paginateData.next_page_url = jobsList.next_page_url;
            paginateData.prev_page_url = jobsList.prev_page_url;
            
            jlhtml += paginate_html(paginateData);            

            if(jlhtml != ''){
                $(".job-list").html(jlhtml);
            }else{
                $(".job-list").html('');
            }
            $("#no-res-res-containr").hide();
            $("#search-res-containr").show();
        }
        else{
            //res data was 0 show nodata
            $("#no-res-res-containr").show();
            $("#search-res-containr").hide();
        }
          
    }
        
    //experice
    FGid = getParamsArr[FilterMenu_Experince] || 0;
    // console.log(FGid + 'ddvv' + FGid != 0)
    if(FGid !== 0){
        rangeSetup(getParamsArr[FilterMenu_Experince]);
    }else{
        rangeSetup('any');
    }

    //applied btn show.hide--s
    let fcnt =0;
    fcnt = get_filter_selected_count();
    if( fcnt ){
        show_hide_applied_btn(fcnt);
    }else{
        show_hide_applied_btn(fcnt);
    }
    //applied btn show.hide--e
   
    $("#tempskle").removeClass("is-loading");

    // return true;

}

function paginate_html(data){

    const url = new URL(window.location.href);

    let html ='';
    let next_page_url = data.next_page_url || '#';
    let prev_page_url = data.prev_page_url || '#';
    let links = data.links;
    if(prev_page_url){
        prev_disab = prev_page_url=='#' ? 'disabled':'';
        s_prev_page_url = prev_page_url.split('?page=')[1];
        url.searchParams.set('page',s_prev_page_url);
        s_prev_page_url = url.toString();
    }
    if(next_page_url){
        next_disab = next_page_url=='#' ? 'disabled':'';
        s_next_page_url = next_page_url.split('?page=')[1];
        url.searchParams.set('page',s_next_page_url);
        s_next_page_url = url.toString();
    }
    
    
    html += '<div class="mt-64 mb-60">';
        html += '<div class="pagination lastCompMark">';
            html += '<a  href="'+s_prev_page_url+'" class="fleft fs14 btn-glb previous" '+prev_disab+'>';
                // html +='<i class="bi bi-arrow-left mr-8 fleft fs16"></i>';
                html +='<span class="fw500 fleft">&laquo; Previous</span>';
            html +='</a>';

            html += '<div class="fleft pages " align="center">';
                //loop here
                let sub_html ='',disb_pgn1='';

                $.each(links, function(key,val) {
                    if(links.length == 3){
                        disb_pgn1='disabled';
                    }
                    if(key != 0 && key != (links.length-1) ){
                        let lnk = (val.url) || '';
                        lnk = lnk.split('?page=')[1];
                        url.searchParams.set('page',lnk);
                        let paglink = url.toString();
                        let label = (val.label) ? val.label : '';
                        let selected= (val.active==true) ? 'selected' : '';
                        paglink = disb_pgn1=='disabled' ? 'javascript:void(0);':paglink;

                        paglink = label=='...' ? 'javascript:void(0);':paglink;
                        sub_html +='<a href="'+paglink+'" class="'+selected+'" '+disb_pgn1+'>'+label+'</a>';
                    }
                });
                
                html +=sub_html;

            html +='</div>';
            
            html += '<a href="'+s_next_page_url+'" class="fright fs14 btn-glb" '+next_disab+'>';
                html +='<span class="fw500 fleft">Next  &raquo;</span>';
                // html +='<i class="bi bi-arrow-right ml-8 fleft fs16"></i>';
            html +='</a>';
        html +='</div>';
    html +='</div>';

    // console.log(html);
    return html ;
}

// function pageAction(page_no){

//     let url = new URL(window.location.href);
//     // if(url.searchParams.get('page')){
//         url.searchParams.set('page',page_no);
//         let url_s =url.toString() ;
//         window.history.pushState({}, '', url_s);
//     // }
//     processing_data();
// }

//dynamic check box actions
$(document).on('click', '.form-check-input' , function(e){

    let FG_id = $(this).parent().parent().data('filter-id');
    let chkb_cked = this.checked;
    if(FG_id == undefined){
        FG_id = $(this).parent().parent().parent().parent().data('filter-id');
    }
    if(FG_id == undefined){
        FG_id = $(this).parent().data('filter-id');
    }
    checkd_val = $(this).val();

    let params_total=0;
    if(checkd_val){
        params_total = append_URLParams(FG_id, checkd_val);
    }

    //remove pageno param when filter-apply
    removePageNoParam();

    //applied btn when input change show.hide--s
    let fcnt = 0;
    fcnt = get_filter_selected_count();
    if( fcnt ){
        show_hide_applied_btn(fcnt);
    }else{
        show_hide_applied_btn(fcnt);
    }
    //applied btn input change  show.hide--s

    processing_data();

});


$(document).on('input', '#exp-range-slider' , function(e){
    let vall = $(this).val();
    rangeSetup(vall);
});

$(document).on('change', '#exp-range-slider' , function(e){

    let vall = $(this).val();
    let F_id = $(this).parent().parent().parent().data('filter-id');
    params_total = append_URLParams(F_id, vall,2);
    
    //remove pageno param when filter-apply
    removePageNoParam();

    //applied btn when input change show.hide--s
    let fcnt = 0;
    fcnt = get_filter_selected_count();
    if( fcnt ){
        show_hide_applied_btn(fcnt);
    }else{
        show_hide_applied_btn(fcnt);
    }
    //applied btn input change  show.hide--s

    processing_data();

});

//applied popup trigger
$(document).on( 'click', '.applied-link' , function(e) {
    html = geneApplyFilter_Box();
    $(this).next().remove();
    if(html != ''){
        $(this).after( html );
    }
});

$(document).on( 'click', '.filterReset', function() {
    
    filterResetallActions()
    processing_data();

});

$(document).on( 'click', '.japplybtnredir', function(e) {
 
    let jobid = $(this).closest('.jobcard').data('jobid');
    if(jobid != '' ){
        url = baseurl + 'detail/'+ jobid;
        openInNewTabWithNoopener(url)
    }
});
$(document).on( 'click', '.japplybtn', function(e) {
    e.stopPropagation();
    let jobidv = $(this).parent().parent().parent().parent().data('jobid');
    // alert(jobidv)
    btn = $(this);
    jobApply(btn, jobidv);
   
});

$(document).on('change', '#sortby' , function(){
    let sortbyC = $(this).val();
    sortbyValueSetup(sortbyC)
    processing_data();
});


function sortbyValueSetup(sortbyC){
    //let sortbtv = $("#sortby").val()
    $("#sortby").val(sortbyC)
}

function openInNewTabWithNoopener(val) {
    const aTag = document.createElement('a');
    aTag.rel = 'noopener';
    aTag.target = "_blank";
    aTag.href = val;
    aTag.click();
}


function showHideFilterMenu(show=true, e){
    if(show) {
        $("ul li").find(`[data-filter-id='${e}']`).parent().parent().show();
    }
    else {
        $("ul li").find(`[data-filter-id='${e}']`).parent().parent().hide();
    }
}


function moreLink_HTMLstring(more_total){

    str_tot_set = '+ '+ more_total +' More';

    html ='';
    html +='<div class="mt-8 fw500">';
        html +='<a class="blue-text filter-more-link">';
            html +='<span class="fleft lH20 fw-bold"> '+str_tot_set+' </span>';
            html +='<i class="jpaxicon jpaxicon-arrow fleft"></i>';
        html +='</a>';
    html +='</div>';
    return html;
}

function geneFilterOptions(filterName, data, filterTitle){

    // var obj = jQuery.parseJSON(response);
    html='';
    $.each(a, function(key,val) {
        val_txt = val.name || '';
        fshort='fod'
        tmp_id = fshort  + '-' + val_txt + 'Filter-expanded';
        title = val.title || '';
        fres_total= val.count || 0;
        fres_total = fres_total ? "("+fres_total+")" : '';

        html += '<div class="mt-8 chckBoxCont">';
            html += '<input type="checkbox" class="form-check-input" id="'+ tmp_id +'">';
            html +='<label class="chkLbl" for="'+ tmp_id +'">';
                html +='<p class="grey-text lH20 ml-8 txtLbl">';
                    html +='<span class="ellipsis fleft" title="'+ title +'">'+val_txt+'</span>';
                    html +='<span class="ml-5 fleft">'+fres_total+'</span>';
                html +='</p>';
            html +='</label>';
        html +='</div>';
    });
    
    p1html = '';
    p1html += '<div class="filterTooltip bgWhite z-depth-2" id="tooltip">';
        p1html +='<div class="heading">';
            p1html +='<span class="fw-bold fs16">'+filterTitle+'</span>';
            p1html +='<i class="jpaxicon jpaxicon-cross icon-24"></i>';
        p1html +='</div>';                                            
        p1html +='<div class="filter-comp-options">';
            p1html += html;
        p1html +='</div>';
    p1html +='</div>';
                                              
    return p1html;

}

function createFilterOptions( filterName, data, checked_data,Fnum){
    
    html='';
    i=0;
    $.each(data, function(key,val) {
        
        val_txt = val.label || '';
        fshort= 'chk'+Fnum+''+i;
        tmp_id = fshort  + '-' + val_txt;
        fres_total= val.count || 0;
        fres_totalv = fres_total ? "("+fres_total+")" : '';
        check_id = (val.id || 0).toString();
        let checked ='';
        checkedARR = checked_data[filterName] || [];

        if(checkedARR){
            checked = checkedARR.includes(check_id) ? 'checked':'';
        }
        if(fres_totalv !=''){
            html += '<div class="mt-8 chckBoxCont">';
                html += '<input type="checkbox" class="form-check-input" value="'+check_id+'" id="'+ tmp_id +'" '+checked+'>';
                html +='<label class="chkLbl" for="'+ tmp_id +'">';
                    html +='<p class="grey-text lH20 ml-8 txtLbl">';
                        html +='<span class="ellipsis fleft" title="'+ val_txt +'">'+val_txt+'</span>';
                        html +='<span class="ml-5 fleft">'+fres_totalv+'</span>';
                    html +='</p>';
                html +='</label>';
            html +='</div>';
        }
        
    i++;
    });
    
    return html;

}

function createFilterOptions_Morebox( filterName, data, checked_data,filterTitle){

    html='';
    i=0;
    $.each(data, function(key,val) {

        val_txt = val.label || '';
        fshort= 'chk'+i;
        tmp_id = fshort  + '-' + val_txt + 'Filter-expanded';
        fres_total= val.count || 0;
        fres_total = fres_total ? "("+fres_total+")" : '';
        check_id = (val.id || 0).toString();
        let checked ='';
        checkedARR = checked_data[filterName] || [];
        if(checkedARR){
            checked = checkedARR.includes(check_id) ? 'checked':'';
        }

        html += '<div class="mt-8 chckBoxCont">';
            html += '<input type="checkbox" class="form-check-input" value="'+check_id+'" id="'+ tmp_id +'" '+checked+'>';
            html +='<label class="chkLbl" for="'+ tmp_id +'">';
                html +='<p class="grey-text lH20 ml-8 txtLbl">';
                    html +='<span class="ellipsis fleft" title="'+ val_txt +'">'+val_txt+'</span>';
                    html +='<span class="ml-5 fleft">'+fres_total+'</span>';
                html +='</p>';
            html +='</label>';
        html +='</div>';
        i++;
    });
    
    p1html = '';
    p1html += '<div class="filterTooltip bgWhite z-depth-2" id="tooltip">';
        p1html +='<div class="heading">';
            p1html +='<span class="fw-bold fs16">'+filterTitle+'</span>';
            p1html +='<i class="jpaxicon jpaxicon-cross icon-24"></i>';
        p1html +='</div>';                                            
        p1html +='<div class="filter-comp-options">';
            p1html += html;
        p1html +='</div>';
    p1html +='</div>';
                                              
    return p1html;
}

function jobApply(e, jobidv) {

    v_is_login = is_login || 0;

    if(jobidv != '') {

        let csrf_token = $('meta[name=csrf-token]').attr('content');
        let req_url = baseurl + 'apply/' + jobidv;

        $(btn).prop("disabled", true);

        $.ajax({
            url: req_url,
            type: 'POST',
            data : {"_token": csrf_token,'is_login':v_is_login },
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
                    $(`<label class="japplied-btn"><img draggable="false" class="imagesz-2" src="${baseurl}site_assets_1/assets/img/Shortlist.png" alt="applied"> <span class="fw-bold">Applied</span></label>`).insertAfter(btn);
                    $(btn).hide();
                }
                else{
                    $(btn).html(
                        `<img draggable="false" class="image-size" src="${baseurl}site_assets_1/assets/img/apply2.png" alt="apply"> Apply</button>`
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
                    else if(reload_page)
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


function filterResetallActions(){

    //remove pageno param when filter-apply
    removePageNoParam();

    $('input.form-check-input:checkbox').prop('checked', false);
    rangeSetup('any');
    removeFilter_URL_Params();
    show_hide_applied_btn(0);

}

function get_filter_selected_count(){

    let applied_count = 0;
    // $('.dropdown_inner>.mt-8>.form-check-input:checkbox:checked').each(function () {
    //     applied_count++;
    // });
    const url = new URL(window.location.href);
    new URL(url).searchParams.forEach(function (val, key) {
        if(FilterMenus.includes(key)){
            applied_count++;
        }
	});
    let expvv = new URL(location.href).searchParams.get(FilterMenu_Experince);
    if($("#exp-range-slider").val() && expvv){
        applied_count += 1;
    }
    return applied_count;
}

function show_hide_applied_btn(count=0){
    if(count){
        txt = 'Applied ('+count+')';
        applied_html = '<a class="blue-text-2 fw-bold appliedTxt applied-link">'+txt+'</a>';
        $("#FilterHeadtitle").next('a').remove();
        $(applied_html).insertAfter("#FilterHeadtitle");
    }else{
        $("#FilterHeadtitle").next('a').remove();
        $("").insertAfter("#FilterHeadtitle");
    }
}

function show_hide_applied_MENU(){
    html = geneApplyFilter_Box();
    $(".applied-link").next().remove();
    if(html != ''){
        $(".applied-link").after( html );
    }
}

function geneApplyFilter_Box_old(){
    //case 2 method from dom
    // let arr = {};
    html='';
    $('input.form-check-input:checkbox:checked').each(function () {
        let FG_id = $(this).parent().parent().data('filter-id');
        let chkb_cked = this.checked;
        if(FG_id == undefined){
            FG_id = $(this).parent().parent().parent().parent().data('filter-id');
        }

        key = FG_id;
        val = $(this).val();
        label = $(this).next().find('span').eq(0).text();
        count = $(this).next().find('span').eq(1).text();
        
        // temp = {'id' : val ,'label' : label ,'count' : count };
        // if (arr[key] !== undefined) {
		// 	if (!Array.isArray(arr[key])) {
		// 		arr[key] = [arr[key]];
		// 	}
        //     arr[key].push(temp);
		// } else {
		// 	arr[key] = Array(temp);
		// }
        
        ///
        check_id = val || 0;
        val_txt = label || '';
        fshort='fod'
        tmp_id = fshort  + '-' + val_txt + 'Filter-expanded';
        fres_total= count || 0;
        checked ='checked';

        html += '<div class="mt-8 chckBoxCont" data-filter-id="'+key+'">';
            html += '<input type="checkbox" class="form-check-input" value="'+ check_id +'" id="'+ tmp_id +'" '+checked+'>';
            html +='<label class="chkLbl" for="'+ tmp_id +'">';
                html +='<p class="grey-text lH20 ml-8 txtLbl">';
                    html +='<span class="ellipsis fleft" title="'+ val_txt +'">'+val_txt+'</span>';
                    html +='<span class="ml-5 fleft">'+fres_total+'</span>';
                html +='</p>';
            html +='</label>';
        html +='</div>';
        //
    });
    
    let expvv = new URL(location.href).searchParams.get(FilterMenu_Experince);
    if($("#exp-range-slider").val() && expvv){
        val_txt =  expvv+' Years';
        tmp_id = 'fod'  + '-' + val_txt + 'Filter-expanded';
        html += '<div class="mt-8 chckBoxCont" data-filter-id="'+FilterMenu_Experince+'">';
            html += '<input type="checkbox" class="form-check-input" value="'+ expvv +'" id="'+ tmp_id +'" checked>';
            html +='<label class="chkLbl" for="'+ tmp_id +'">';
                html +='<p class="grey-text lH20 ml-8 txtLbl">';
                    html +='<span class="ellipsis fleft" title="'+ val_txt +'">'+val_txt+'</span>';
                    // html +='<span class="ml-5 fleft">'+fres_total+'</span>';
                html +='</p>';
            html +='</label>';
        html +='</div>';
    }
    
    p1html='';
    if(html != ''){
        p1html ='<div id="applied-filters" class="filterTooltip bgWhite applied-filters z-depth-2">';
        p1html += '<div><a class="blue-text fw500 filterReset">Reset All</a><i class="jpaxicon jpaxicon-cross icon-16"></i></div>';
            p1html +='<div>'
                p1html += html;
            p1html +='</div>';
        p1html +='</div>';
    }
    return p1html;
}

function geneApplyFilter_Box(){

    //case 1 method from localstorage
    Filters = localStorage.getItem('filters_obj');
    Filters = Filters ? JSON.parse(Filters) : {};
    let checked_data = getParams();
    let checked_data_keys = Object.keys(checked_data);
    // console.log(Filters)
    // console.log(checked_data);
    html='';
    i=0;
    $.each(Filters, function( KEY, VAL) {
        if( checked_data_keys.includes(KEY)){
            // console.log(KEY)
            FG_data = Filters[KEY];
            FG_checked_data = checked_data[KEY];
            // console.log(FG_checked_data);
            $.each(FG_data , function( key, val ) {
                check_id = (val.id || '0' ).toString();
                // console.log(FG_checked_data + 'ss'+check_id);
                // console.log( FG_checked_data.includes(check_id));
                if( FG_checked_data.includes(check_id) ){
                    // console.log(val)
                    val_txt = val.label || '';
                    fshort='fa'+ (i++);
                    tmp_id = fshort  + '-' + val_txt + 'f-chked';
                    fres_total= val.count || 0;
                    fres_total = fres_total ? "("+fres_total+")" : '';
                    html += '<div class="mt-8 chckBoxCont" data-filter-id="'+KEY+'">';
                        html += '<input type="checkbox" class="form-check-input"  value="'+ check_id +'" id="'+ tmp_id +'" checked>';
                        html +='<label class="chkLbl" for="'+ tmp_id +'">';
                            html +='<p class="grey-text lH20 ml-8 txtLbl">';
                                html +='<span class="ellipsis fleft" title="'+ val_txt +'">'+val_txt+'</span>';
                                html +='<span class="ml-5 fleft">'+fres_total+'</span>';
                            html +='</p>';
                        html +='</label>';
                    html +='</div>';
                }
            });
        }
    });

    let expvv = new URL(location.href).searchParams.get(FilterMenu_Experince);
    if($("#exp-range-slider").val() && expvv){
        val_txt =  expvv+' Years';
        tmp_id = 'fod'  + '-' + val_txt + 'f-chked';
        html += '<div class="mt-8 chckBoxCont" data-filter-id="'+FilterMenu_Experince+'">';
            html += '<input type="checkbox" class="form-check-input" value="'+ expvv +'" id="'+ tmp_id +'" checked>';
            html +='<label class="chkLbl" for="'+ tmp_id +'">';
                html +='<p class="grey-text lH20 ml-8 txtLbl">';
                    html +='<span class="ellipsis fleft" title="'+ val_txt +'">'+val_txt+'</span>';
                    // html +='<span class="ml-5 fleft">'+fres_total+'</span>';
                html +='</p>';
            html +='</label>';
        html +='</div>';
    }

    p1html='';
    if(html != ''){
        p1html ='<div id="applied-filters" class="filterTooltip bgWhite applied-filters z-depth-2">';
        p1html += '<div><a class="blue-text fw500 filterReset">Reset All</a><i class="jpaxicon jpaxicon-cross icon-16"></i></div>';
            p1html +='<div>'
                p1html += html;
            p1html +='</div>';
        p1html +='</div>';
    }
    
    return p1html;
}

function rangeSetup(val='any'){

    const range = document.getElementById('exp-range-slider');
    const rangeV = document.getElementById('rangeV');
    let vall = 0,txt = 'Any';
    if(val === 'any'){
        txt = 'Any';
        vall = 30;
        document.getElementById('exp-range-slider').value = vall;
    }
    else{
        txt = val;
        vall = val ;
        document.getElementById('exp-range-slider').value = vall;
    }
    
    newValue = Number( (vall - range.min) * 100 / (range.max - range.min) );
    newPosition = 10 - (newValue * 0.2);

    rangeV.innerHTML = `<span>${txt}</span>`;
    rangeV.style.left = `calc(${newValue}% + (${newPosition}px))`;

}

function removePageNoParam(){
    let url = new URL(window.location.href);
    if(url.searchParams.get('page')){
        url.searchParams.delete('page');
        let url_s =url.toString() ;
        window.history.pushState({}, '', url_s);
    }
    return true;
}

function removeFilter_URL_Params(){
    const url = new URL(window.location.href);
	let params = {};
	new URL(url).searchParams.forEach(function (val, key) {
        if(!FilterMenus.includes(key) && FilterMenu_Experince != key){
            if (params[key] !== undefined) {
                if (!Array.isArray(params[key])) {
                    params[key] = [params[key]];
                }
                params[key].push(val);
            } else {
                params[key] = Array(val);
            }
        }
	});

    // console.log(params);

    params_count=0;
    if(params == [] || params == undefined){
        queryP='';
    }else{
        params_count = params.length;
        queryP = buildParams(params);
    }

    let urlSParams = location.pathname;
    if(queryP == ''){
        urlSParams = location.pathname;
    }else{
        urlSParams = '?' + queryP;
    }
    window.history.pushState({}, '', urlSParams);

    return null;
}

function append_URLParams(FG_id,val,FgType=1){

    const url = new URL(window.location.href);
	let params = {};

	new URL(url).searchParams.forEach(function (val, key) {
        // val = decodeURIComponent(val);
        
        if (params[key] !== undefined) {
            if (!Array.isArray(params[key])) {
                params[key] = [params[key]];
            }
            params[key].push(val);
        } else {
            if(FgType ==2) {
                params[key] = val;
            }else{
                params[key] = Array(val);
            }
        }
		
	});
    // console.log(params);

    TempPars = params[FG_id] || [];
    
    if(TempPars.length != 0){
        if(params[FG_id].includes(val)){
            params[FG_id] = params[FG_id].filter(function(e) { return e !== val });
        }else{
            // params[FG_id].push(val);
            if(FgType ==2) {
                params[FG_id] = val;
            }else{
                params[FG_id].push(val);
            }
        }
    }
    else{
        if (params[FG_id] !== undefined) {
			if (!Array.isArray(params[FG_id])) {
				params[FG_id] = [params[FG_id]];
			}
			params[FG_id].push(val);
		} else {
			// params[FG_id] = Array(val);
            if(FgType ==2) {
                params[FG_id] = val;
            }else{
                params[FG_id] = Array(val);
            }
		}
    }
    
    // console.log(params);
    params_count=0;
    if(params == [] || params == undefined){
        queryP='';
    }else{
        params_count = params.length;
        queryP = buildParams(params);
    }
    // console.log(queryP)
    let urlSParams = location.pathname;
    if(queryP == ''){
        urlSParams = location.pathname;
    }else{
        urlSParams = '?' + queryP;
    }
    window.history.pushState({}, '', urlSParams);

    return params_count;
}

function get_URLParamsasArr(){

    const url = new URL(window.location.href);
	let params = {};
	new URL(url).searchParams.forEach(function (val, key) {
        // val = decodeURIComponent(val);
        
        if (params[key] !== undefined) {
            if (!Array.isArray(params[key])) {
                params[key] = [params[key]];
            }
            params[key].push(val);
        } else {
            if(FgType ==2) {
                params[key] = val;
            }else{
                params[key] = Array(val);
            }
        }
		
	});
    // console.log(params);
    return params;
}

function buildParams(data) {
    const params = new URLSearchParams()
    Object.entries(data).forEach(([key, value]) => {
        if (Array.isArray(value)) {
            value.forEach( (value) => { params.append(key, value.toString()) });
        } else {
            params.append(key, value.toString())
        }
    });
    return params.toString()
}

function getParams (url = window.location) {
	// Create a params object
	let params = {};
	new URL(url).searchParams.forEach(function (val, key) {
        // val = decodeURIComponent(val);
		if (params[key] !== undefined) {
			if (!Array.isArray(params[key])) {
				params[key] = [params[key]];
			}
			params[key].push(val);
		} else {
			params[key] = Array(val);
		}
	});
	return params;
}

function createJoblistDiv(data,appliedJobids){
    html='';
    // i=0;
    // dataArr = data.data 
    // var aDay = 24*60*60*1000;
    // console.log((new Date(Date.now())));
    // console.log(timeSince(new Date(Date.now()-aDay*2)));

    $.each(data, function(key,val) {;
        
        job_id = (val.job_id || 0 );
        jobslug = val.slug || '';

        title = val.title || 'PHP Dev';
        cmp_name = val.company_name || 'Axeraan Technologies';
        locationa = val.location || 'Coimbatore';
        if(locationa){
            locationa =locationa.replace(/,\s$/,'');
        }
        experi = val.experience || '1-2 years';
        salary= val.salary || 'Not disclosed';
        shortdesc=val.description || 'Research and write compelling SEO contents Research and write compelling SEO contents Research and write compelling SEO contents Research and write compelling SEO contents Research and write compelling SEO contents';
        shortdesc=shortdesc.slice(0,450);
        shortdesc=shortdesc.replace(/\r/g, ' ');
        shortdesc=shortdesc.replace(/\n/g, ' ');
        shortdesc=shortdesc.replace(/\t/g, ' ');
        shortdesc=shortdesc.replace(/\s\s+/g, ' ');
        shortdesc=shortdesc.trim();
        // shortdesc=shortdesc.slice(0,350);
        posted_ago = val.posted_date || 'Posted: 1 day ago';
        imdjoin_v = val.immediate_join || ' Immediate Join';
        imdjoin = imdjoin_v;
        if(imdjoin_v == 'Immediate Join'){imdjoin = imdjoin_v;}

        posted_ago_a = '2 Days ago';
        if(posted_ago != ''){
            posted_ago_a = timeSince(posted_ago);
        }

        html += '<div class="card jobcard" data-jobid="'+jobslug+'">';
            html += '<div class="card-body">';
                html += '<div class="row mb-2">';
                    html +='<div class="col-md-9 col-sm-9 col-xs-9 col-12"><h3 class="text-green-color ellipsis">'+title+'</h3></div>';
                    // html +='<div class="col-md-2 col-sm-2 col-xs-12" style="text-align: -webkit-right;"><button class="p-1 shadow-sm bg-color-blue rounded-pill" style="width:max-content"><img draggable="false" class="image-size" src="'+baseurl+''+baseurl+'site_assets_1/assets/img/apply2.png" alt="apply"> Apply</button></div>';
                    html +='<div class="col-md-3 col-sm-3 col-xs-3 col-6" style="text-align: -webkit-right;">';
                        if(appliedJobids.includes(job_id)){
                            html +='<label class="japplied-btn" ><img draggable="false" class="imagesz-2" src="'+baseurl+'site_assets_1/assets/img/Shortlist.png" alt="applied"> <span class="fw-bold">Applied</span></label>';
                        }else{
                            if(val.have_screening_quiz=='yes' || val.is_admin==1){
                                html +='<button class="btn p-1 shadow-sm bg-color-blue rounded-pill japply-btn japplybtnredir" id="japplybtn"><img draggable="false" class="image-size" src="'+baseurl+'site_assets_1/assets/img/apply2.png" alt="apply"> Apply</button>';
                            }else{
                                html +='<button class="btn p-1 shadow-sm bg-color-blue rounded-pill japply-btn japplybtn" id="japplybtn"><img draggable="false" class="image-size" src="'+baseurl+'site_assets_1/assets/img/apply2.png" alt="apply"> Apply</button>';
                            }
                        }
                    html +='</div>';

                html +='</div>';

                html +='<div class="mb-2 fw-bold ellipsis cmp_name ">'+cmp_name+'</div>';

                html += '<div class="row mb-4">';
                    // html +='<div class="col-md-4 col-sm-4 col-xs-12"><div><text class="fw-bold tt_txt">Experience:</text> <text class="text-green-color tt_txt"> '+experi+' </text></div></div>';
                    html +='<div class="col-md-4 col-sm-4 col-xs-12 d-flex"><span><img draggable="false" class="me-2 image-size" src="'+baseurl+'site_assets_1/assets/img/side_nav_icon/experience.png"></span> <text class="text-green-color tt_txt fw-bold text-truncate">'+experi+'</text></div>';
                    html +='<div class="col-md-4 col-sm-4 col-xs-12 d-flex"><span><img draggable="false" class="me-2 image-size" src="'+baseurl+'site_assets_1/assets/img/side_nav_icon/salary.png"></span> <text class="text-green-color tt_txt fw-bold text-truncate">'+salary+'</text></div>';
                    html +='<div class="col-md-4 col-sm-4 col-xs-12 d-flex"><span><img draggable="false" class="me-2 image-size" src="'+baseurl+'site_assets_1/assets/img/side_nav_icon/location.png"></span> <text class="text-green-color tt_txt fw-bold text-truncate">'+locationa+'</text></div>';
                html +='</div>';

                html += '<div class="mb-4">';
                    html +='<p class="text-truncate jd_txt">'+shortdesc+'</p>';
                html +='</div>';
                
                html += '<div class="d-flex mb-1 justify-content-between">';
                    html +='<div class=""><i class="jpaicon bi-clock-history"></i><span>'+posted_ago_a+'</span></div>';
                    if(imdjoin !=''){
                        html +='<div class=""><text><img draggable="false" class="image-size" src="'+baseurl+'site_assets_1/assets/img/Imm_join.png" alt="immediate join">'+imdjoin+'</text></div>';
                    }
                    html +='<div class="d-flex">';
                    html +='</div>';
                html +='</div>';

            html +='</div>';
        html +='</div>';

    // i++;
    });
    
    // console.log(html)
    return html;

}





//----inactive functions -----

function getstaticeResponse(){

    var obj = { filters: {
        // business_size: [{id: "213", count: 743, label: "Foreign MNC"}, {id: "211", count: 131, label: "Corporate"}],
        citylFGid: [ {id: "1", count: 268, label: "Remote"}, {id: "2", count: 3303, label: "Bangalore/Bengaluru"}
        ,{id: "3", count: 2628, label: "Chennai"}, {id: "4", count: 3303, label: "Karnataka"}, {id: "5", count: 3303, label: "eeee"}
        , {id: "6", count: 3303, label: "vvvvvvvvvv"}, {id: "7", count: 3303, label: "wwwwwwwwwwwww"}, {id: "8", count: 3303, label: "asdasd"}
        , {id: "81", count: 3303, label: "asdasd vvvvvvvvvv"}
        , {id: "82", count: 3303, label: "asdasd vvvvvvvvvv"}
        , {id: "83", count: 3303, label: "asdasd vvvvvvvvvv"}
        , {id: "84", count: 3303, label: "asdasdd vvvvvvvvv"}
        , {id: "85", count: 3303, label: "asdasdd vvvvvvvvv"}
        , {id: "86", count: 3303, label: "asdasdd vvvvvvvvv"}
        , {id: "87", count: 3303, label: "asdasd d vvvvvvvvv "}
        , {id: "88", count: 3303, label: "asdasdd vvvvvvvvv"}
        , {id: "89", count: 3303, label: "asdasd d vvvvvvvvv"}
        , {id: "90", count: 3303, label: "asdas d vvvvvvvvv d"}
        , {id: "91", count: 3303, label: "asdasdd vvvvvvvvv"}
        , {id: "92", count: 3303, label: "asdasd d vvvvvvvvv"}
        , {id: "93", count: 3303, label: "asdasdd vvvvvvvvv "}
        , {id: "94", count: 3303, label: "asdasdd vvvvvvvvv "}
        , {id: "95", count: 3303, label: "asdasdd vvvvvvvvv "}
        , {id: "96", count: 3303, label: "asdasdd vvvvvvvvv"}
        , {id: "97", count: 3303, label: "asdasdd vvvvvvvvv "}
        , {id: "98", count: 3303, label: "asdasdd vvvvvvvvv"}
        , {id: "99", count: 3303, label: "asdasd d vvvvvvvvv "}
           ],
        salaryFGid: [{id: "1", count: 18915, label: "Company Jobs"}, {id: "2", count: 1871, label: "Consultant Jobs"}],
        jobtypeFGid: [{id: "957870", count: 1, label: "Groupon"}, {id: "4250870", count: 1, label: "Micron Tech"}],
        edulevelFGid:[{id: "9510", count: 6789, label: "Post Graduation Not Required"}],
        wfhtypeFid: [{id: "1", count: 491, label: "WFH during Covid"}],
        industrytypeGid: [{id: "5", count: 17089, label: "Engineering - Software & QA"}],
        functionalareaGid: [{id: "5", count: 17089, label: "Engineering - Software & QA"}]
        },

        jobsList:
        [
            {title: "UI Lead - PHP with Laravel | Remote | Immediate Joiners | Inoptra", jobId: "290322005856"},
            {title: "UI Lead - PHP with Laravel | Remote | Immediate Joiners | Inoptra", jobId: "290322005856"},
        ]
        
    };

    // var obj = { filters: {
    // business_size: [{id: "213", count: 743, label: "Foreign MNC"}, {id: "211", count: 131, label: "Corporate"}],
    // citiesGid: [{id: "9513", count: 268, label: "Remote"}, {id: "97", count: 3303, label: "Bangalore/Bengaluru"}],
    // employement: [{id: "1", count: 18915, label: "Company Jobs"}, {id: "2", count: 1871, label: "Consultant Jobs"}],
    // featuredCompanies: [{id: "957870", count: 1, label: "Groupon"}, {id: "4250870", count: 1, label: "Micron Tech"}],
    // functionalAreaGid: [{id: "5", count: 17089, label: "Engineering - Software & QA"}],
    // glbl_RoleCat: [{id: "1028", count: 16509, label: "Software Development"}],
    // industryTypeGid: [{id: "109", count: 11928, label: "IT Services & Consulting"}],
    // jobTags: [{id: "Skill_39976_39978", count: 1430, label: "Java"}],
    // pgCourseGid: [{id: "9510", count: 6789, label: "Post Graduation Not Required"}],
    // salaryRange: [{id: "0to3", count: 3993, label: "0-3 Lakhs"}, {id: "3to6", count: 13064, label: "3-6 Lakhs"}],
    // topCompanyId: [{id: "27117", count: 27, label: "Accenture"}, {id: "3830654", count: 19, label: "Meesho"}],
    // ugCourseGid: [{id: "12", count: 10610, label: "B.Tech/B.E."}, {id: "9502", count: 9934, label: "Any Graduate"}],
    // wfhType: [{id: "1", count: 491, label: "WFH during Covid"}]}};
    const myJSON = JSON.stringify(obj);
    // console.log(myJSON)

    return obj;
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

function sleep(milliseconds) {  
    return new Promise(resolve => setTimeout(resolve, milliseconds));  
}

function read_get_parameter_1(){

    const paramsString = window.location.search;
    const searchParams = new URLSearchParams(paramsString);
    const params = Object.fromEntries(searchParams.entries());
    
    // console.log(params)
    if(params !=undefined || params != '' || params){
        return params;
    }else{
        return false;
    }
    // if(desig == '' || id == '' || id == undefined){
    //     searchParams.delete('sub_link_id');
    // }
    // else{
    //     searchParams.set('sub_link_id', id );
    // }
    

}
function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
function eraseCookie(name) {   
    document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}