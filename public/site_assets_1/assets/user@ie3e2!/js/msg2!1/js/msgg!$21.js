var screensize= $( window ).width();
let csrf_token = $('meta[name=csrf-token]').attr('content');
var msg_api_url = 'messagelist';
var msg_contact_list = 'message_contact_list';
var msg_send = 'message_send';
var msg_listen = 'messagelisten';
var contact_status = 'contact_status';
act_mid = act_mid_from_url;
act_ftab = m_status;
last_date = last_chat_at = devwidth = '';
if(act_mid && act_ftab){    
    if(screensize>575){
    }
}
ContactList();

if(screensize<=575){
    devwidth = 'mobwidth';
}else{
    if(act_mid && act_ftab){ 
        $('.msglistpar').removeClass('hide');
        load_message_list_data(act_mid);
    }else{        
        $('#nodatamsg').removeClass('hide');
    }
}

/**  ****Start Status, Filters, Show contact, Select Contact * - Events**** */


// Expend and compress Message box 
$(document).on('click', '.textCompress' , function(e){
    $('.textExpend').show();
    $('.textCompress').hide();
    $('.message-list').removeClass('compress');
    $('#message').attr('rows', 2);
});
$(document).on('click', '.textExpend' , function(e){
    $('.textCompress').show();
    $('.textExpend').hide();
    $('.message-list').addClass('compress');
    $('#message').attr('rows', 10);
});
// Ascending Descending sort by
$(document).on('click', '.asc-desc' , function(e){
    if($(this).data('value')=='desc'){
        $(this).data('value','asc'); 
        $("#asc-desc").attr("src", `${baseurl}images/msgs/descending.svg`);
    }else{
        $(this).data('value','desc'); 
        $("#asc-desc").attr("src", `${baseurl}images/msgs/ascending.svg`);
    }
    ContactList();
});

// Read Status
$(document).on('click', '.MessageStatus .dropdown-item', function (event) {
    act_ftab = $(this).attr('id');
    act_ftab_rc = $(this).children().text().trim();
    act_ftab_rc = act_ftab_rc.replace('(','').replace(')','');
    $('#MessageStatus').html($('#'+act_ftab).html());
    change_url_state(act_mid,'');
    act_mid = '';
    ContactList('status_change');
});

$(document).on('click', '.mob-res-arrow', function(e){
    $('.job-filter').removeClass('jfilter');
    $('.msglistpar').addClass('hide'); 
});

$(document).on('click', '.action .dropdown-item', function (event) {
    update_status = $(this).attr('id');
    $.post(baseurl+"contact_status",{message_id:act_mid, _method: 'POST', _token: csrf_token, status: update_status})
        .done(function (response) {// Get select
            change_url_state(act_mid,'');
            $(`div [data-mkey='${act_mid}']`).remove();
            act_mid = '';
            $('.msglistpar').addClass('hide');
            if(update_status=='archive'){
                toastr.success('Moved Archive successfully');
            }else
            if(update_status=='archive'){
                toastr.success('Moved Spam successfully');
            }else{
                toastr.success('Revert successfully');
            }

        });
});
//Selete contact
$(document).on('click', '#tempskle2 .jlsca', function (event) 
{    
    change_url_state(act_mid,$(this).data('mkey'));
    act_mid = $(this).data('mkey');
    if (!$(this).hasClass('jpcactive') || devwidth=='devwidth') {
        $('#tempskle2 .jlsca').removeClass('jpcactive');
        $(this).addClass('jpcactive');
        $(this).removeClass('unread');
        
        if(devwidth=='mobwidth'){
            $('.job-filter').addClass('jfilter');
        }
        load_message_list_data(act_mid);
    }
    if(!$('#nodatamsg').hasClass('hide'))
    {
        $('#nodatamsg').addClass('hide');
    }
});

// Search Contact
var cp_search_inp = $('#jp_search_btn').val();
$("#jp_search_btn").click(function () {
    clear_cp_search_err();
    cp_search_inp = $('#jp_search_inp').val();
    if(cp_search_inp !=''){
        ContactList();
    }else{
        $("#jp_search_inp, #jp_search_btn").addClass("is_invalid_c1");
    }
});

$("#jp_search_inp").keyup(function () {
    jp_search_inp = $('#jp_search_inp').val();
    if(jp_search_inp =='' || event.keyCode=='13'){
        ContactList();
    }
});
/**  ****End Status, Filters, Show contact, Select Contact * - Events**** */



/** ***********Start Contact List & Message APi Template************** */

function ContactList(invoke_by=''){
    if(invoke_by=='status_change'){
        $('.asc-desc').data('value','desc'); 
        $("#asc-desc").attr("src", `${baseurl}images/msgs/ascending.svg`);
    }
    let req_url = baseurl + msg_contact_list;
    search_inp = $('#jp_search_inp').val();
    orderby = $('.asc-desc').data('value');
    $.ajax({
        url: req_url,
        type: 'POST',
        data: { "_token": csrf_token, 'message_id': act_mid, 'mstatus': act_ftab, 'search':search_inp, 'orderby': orderby },
        datatype: 'JSON',
        beforeSend:function(){
            $("#tempskle2").addClass("is-loading");
            $('.msglistpar').addClass("is-loading");
        },
        success: function (data) {
            populate_contactlist_data({'data':data.data,'act_mid':act_mid});
            $("#tempskle2").removeClass("is-loading");
            $('.msglistpar').removeClass("is-loading");
           
        },
        error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            // console.log(errorMsg)
            // $('#content').html(errorMsg);
        }
    });

}
// Contact List populate
function populate_contactlist_data(params){
    data = params.data;
    if (data && data.length != 0 ) {
        // Contact List html
        html_jp = conactlist_html(data);  
        if (html_jp) {
            $("#tempskle2").html(html_jp);
        }  
    }else{
        $("#tempskle2").html('<p class="m-3">No posts available</p>');
    }
    if (!$('.msglistpar').hasClass('hide') && act_mid=='') {
        $('.msglistpar').addClass('hide');
    }

}

// Contact List html replicate
function conactlist_html(data) {
    $html = "";
    $.each(data, function (key, val) {
        mid = val.message_id || '1';
        if (mid == act_mid) {
            active_cls = 'jpcactive';
        } else {
            active_cls = val.unread;
        }

        m_created_at = val.created_at || '21-Aug-2022';
        m_created_at = format(new Date(m_created_at));

        $html += `<div class="card card-body jlsca `+active_cls+`" data-mkey="`+val.message_id+`">
                    <div class="row">
                    <div class="col-xl-4 col-lg-4 col-3 cntpro">`;
        if(val.company_image!=null){
            $html +=`<div class="avatar avatar-md"><img draggable="false" src="`+val.company_image+`" alt="Img" class="img-fluid rounded-circle"></div>`;
        }else{
            $html +=`<div class="avatar avatar-md profileImage rounded-circle">`+val.company_avatar+`</div>`;
        }
                
        $html +=` </div>
                    <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-9">
                        <p>`+val.title+`</p>
                        <h4 class="m-0">`+val.company_name+`</h4>
                        <h5 class="m-0">`+m_created_at+`</h5>
                    </div>
                    </div>
                </div>`;

    });

    return $html;
}

// Message List Api
function load_message_list_data(mid) {
 
    let req_url = baseurl + msg_api_url;

    $.ajax({
        url: req_url,
        type: 'POST',
        data: { "_token": csrf_token, 'message_id': mid},
        datatype: 'JSON',
        beforeSend: function () {
            $('.msglistpar').addClass("is-loading");
        },
        success: function (response) {

            messagesPopulate(response.datas);
            tempPlaceholder = response.datas.contact;

            $('.msglistpar').removeClass("is-loading");
            $('.message-list').scrollTop($('.message-list')[0].scrollHeight);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            // console.log(errorMsg);
            // $('#content').html(errorMsg);
        }
    });

}
function message_listen_data(mid=act_mid) {
    
    let req_url = baseurl + msg_listen;

    $.ajax({
        url: req_url,
        type: 'POST',
        data: { "_token": csrf_token, 'message_id': mid, 'last_chat_at': last_chat_at},
        datatype: 'JSON',
        success: function (response) {       
            if(response.datas.length!=0){
                html_msg = messagesListHtml(response.datas);    
                $('.message-list').append(html_msg);
                $('.message-list').scrollTop($('.message-list')[0].scrollHeight);
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            // console.log(errorMsg);
            // $('#content').html(errorMsg);
        }
    });

}
function messagesPopulate(resp){
    $html_pro = "";
    candi_data = resp.contact;
    messages = resp.messages;

    $html_pro = `<div class="row">
        <div class="col-11 d-flex">
            <div class="mx-2 align-self-center mob-res-arrow" data-value="`+devwidth+`">
                <img draggable="false" src="${baseurl}images/msgs/arrow.png" alt="Img" class="img-fluid">
            </div>
            <div class="ms-2">
                <h5>`+candi_data.title+`</h5>
                <p class="m-0">`+candi_data.company_name+`</p>
            </div>
        </div>
        <div class="col-1 align-self-center">
            <div class="dropdown">
                <a class="dropdown-toggle w-100 text-start" id="action" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-ellipsis-vertical cursor-pointer p-2"></i>
                </a>
                <ul class="dropdown-menu action" aria-labelledby="action">`;
                if(candi_data.employer_active_status==null || candi_data.employer_active_status==''){
                    $html_pro += `<li class="dropdown-item cursor-pointer" id="not_interest">Not Interested</li>
                    <li class="dropdown-item cursor-pointer" id="archive">Archive</li>`;
                }else{
                    $html_pro += `<li class="dropdown-item cursor-pointer" id="">Revert</li>`;
                }
                $html_pro += `</ul>
            </div> 
        </div>
    </div>`;
    html_msg = messagesListHtml(messages);
    
    $('.cand-pro').html($html_pro);
    $('.message-list').html(html_msg);
    $('.msglistpar').removeClass('hide');

}
// Message List html replicate
function messagesListHtml(messages){
    $html_msg = "";

    if(messages.length!=0){
        
        $.each(messages, function (key, val) 
        {
            var date = new Date(val.send_at);
            var year = date.getFullYear();
            var month = date.getMonth() + 1; // Adding 1 because months are zero-based
            var day = date.getDate();
            var hours = date.getHours();
            var minutes = date.getMinutes();
            fulldate = day+"-"+month+"-"+year;
            var isInputDateToday = isToday(year+"-"+month+"-"+day);
            var isInputDateYesterday = isYesterday(year+"-"+month+"-"+day);
            var ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12; // Convert 0 to 12
            minutes = minutes < 10 ? '0' + minutes : minutes;
            var time = hours + ':' + minutes + ' ' + ampm;
            if(last_date!=fulldate){
                if(isInputDateToday==true){
                    $html_msg += '<div class="my-2 timebatch"><span>Today</span></div>';
                }else if(isInputDateYesterday==true){
                    $html_msg += '<div class="my-2 timebatch"><span>Yesterday</span></div>';
                }else{
                    $html_msg += '<div class="my-2 timebatch"><span>' + fulldate + '</span></div>';
                }
            }
            if(val.send_by=='employer'){
                $html_msg += `<div class="chat-left">`+val.message.replace(/\r?\n/g,'<br/>');
            }else{
                $html_msg += `<div class="chat-right">`+val.message.replace(/\r?\n/g,'<br/>');
            };

            $html_msg += `<br><span class="text-right">`+time+`</span></div>`;

            if(last_date=='' || last_date!=fulldate){
                last_date = fulldate;
            }
            last_chat_at = val.send_at;
        });

      
    }  

    return $html_msg;
}


/** ***********End Contact List & Message APi ************** */


/** ***********Start Send Message************** */

//Send Message

$(document).on('keyup keydown', '#message', function (event) {

    if($('#message').val()!='')
    {
        $('.textSend').removeClass('disabled');
        $('.textClose').removeClass('textCloseremoved');
    }else
    {
        $('.textSend').addClass('disabled');
        $('.textClose').addClass('textCloseremoved');
    }

});

$(document).on('click', '.textClose', function (event) {
    swal({
        title: "Discard Changes?",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            resetMessage();  
        } 
    });
});

$(document).on('click', '.textSend', function (event) {
    if (!$(this).hasClass('disabled')) {
        sendChatMessages();
    }
});
function sendChatMessages()
{
    
    let req_url = baseurl + msg_send;

    var message = $('#message').val();
    $.ajax({
        url: req_url,
        type: 'POST',
        data: { "_token": csrf_token, 'message_id': act_mid, 'message': message, 'chat_at':new Date().getTime() },
        datatype: 'JSON',
        success: function (data) {
            resetMessage();
            message_listen_data(act_mid);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            console.log(errorMsg)
            // $('#content').html(errorMsg);
        }
    });
}

function resetMessage(){
    $('#message').val('');
    $('.textClose').addClass('textCloseremoved');
    $('.textSend').addClass('disabled');  
}
/** ***********End Send Message************** */

function isToday(date) {
    var today = new Date();
    var inputDate = new Date(date);
    
    // Set the time values of both dates to 0 for accurate comparison
    today.setHours(0, 0, 0, 0);
    inputDate.setHours(0, 0, 0, 0);

    return today.getTime() === inputDate.getTime();
}

function isYesterday(date) {
    var today = new Date();
    today.setHours(0, 0, 0, 0);
    
    var yesterday = new Date(today);
    yesterday.setDate(today.getDate() - 1);
    
    var inputDate = new Date(date);
    inputDate.setHours(0, 0, 0, 0);

    return yesterday.getTime() === inputDate.getTime();
}


function change_url_state(mkey,mid){

    //change url state           
    resURL = window.location.href;
    if(mkey!=''){
        resURL = url_remove_last_path(resURL);
    }
    if(mid!=''){
        resURL= resURL + '/' + mid;
    }
    if(mid==''){
        $("#nodatamsg").html(`<div class="m-3 text-center"><img draggable="false" class="mt-5" style="margin-top: 6rem !important;margin-left: -10rem;" src="${baseurl}site_assets_1/assets/img/letschat.png" rel="nofollow"></div>`);
    }
    history.pushState({}, '',resURL );
}

function url_remove_last_path(the_url){
    var the_arr = the_url.split('/');
    the_arr.pop();
    return( the_arr.join('/') );
}

function clear_cp_search_err(){
    $("#jp_search_inp, #jp_search_btn").removeClass("is_invalid_c1");
}

function format(inputDate) {
    let date, month, year;
    const monthname = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];

    date = inputDate.getDate();
    let month_shna = monthname[inputDate.getMonth()];
    year = inputDate.getFullYear();
  
    date = date
        .toString()
        .padStart(2, '0');
    return `${date}-${month_shna}-${year}`;
}

// Call fetchMessages function periodically to fetch new messages
setInterval(message_listen_data, 30000); // Fetch messages every 3 seconds (adjust as needed)
