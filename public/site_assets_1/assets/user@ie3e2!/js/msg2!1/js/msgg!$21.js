var screensize= $( window ).width();
let csrf_token = $('meta[name=csrf-token]').attr('content');
var msg_api_url = 'messagelist';
var msg_contact_list = 'message_contact_list';
var msg_send = 'message_send';
var msg_listen = 'messagelisten';
act_mid = act_mid_from_url;
act_ftab = m_status;
last_date = last_chat_at = '';

if (act_mid && act_ftab) {
    change_url_state(is_empty_mkey);
    ContactList('initiate');
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
    ContactList('orderby');
});

// Read Status
$(document).on('click', '.MessageStatus .dropdown-item', function (event) {
    act_ftab = $(this).attr('id');
    act_ftab_rc = $(this).children().text().trim();
    act_ftab_rc = act_ftab_rc.replace('(','').replace(')','');
    $('#MessageStatus').html($('#'+act_ftab).html());
    ContactList('status_change');
});

$(document).on('click', '.mob-res-arrow', function(e){
    $('.job-filter').removeClass('jfilter');
    $('.msglistpar').removeClass('msglist'); 
});

//Selete contact
$(document).on('click', '#tempskle2 .jlsca', function (event) 
{
    act_mid = $(this).data('mkey');
    if (!$(this).hasClass('jpcactive')) {
        $('#tempskle2 .jlsca').removeClass('jpcactive');
        $(this).addClass('jpcactive');
        $(this).removeClass('unread');
        change_url_state(act_mid);
        
        if($('.mob-res-arrow').data('value')=='mobwidth'){
            $('.job-filter').addClass('jfilter');
            $('.msglistpar').addClass('msglist');
        }
        load_message_list_data(act_mid);
    }
});

// Search Contact
var cp_search_inp = $('#jp_search_btn').val();
$("#jp_search_btn").click(function () {
    clear_cp_search_err();
    cp_search_inp = $('#jp_search_inp').val();
    if(cp_search_inp !=''){
        ContactList('search');
    }else{
        $("#jp_search_inp, #jp_search_btn").addClass("is_invalid_c1");
    }
});

/**  ****End Status, Filters, Show contact, Select Contact * - Events**** */




/** ***********Start Contact List & Message APi ************** */

function ContactList(invoke_by){
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
        },
        success: function (data) {
            populate_contactlist_data({'data':data.data,'act_mid':act_mid, 'invoke_by':invoke_by});
            $("#tempskle2").removeClass("is-loading");
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
    mid = params.act_mid;
    invoke_by = params.invoke_by;
    
    if (data && data.length != 0 ) {
        if(invoke_by == 'status_change'){
            //autoselect fst jobpost
            miid = data[0].message_id ?? null;
            if(miid){
                mid = act_jid = miid;
                change_url_state(mid);
            }
        }
        // Contact List html
        html_jp = conactlist_html(data, mid);  
        if (html_jp) {
            $("#tempskle2").html(html_jp);

            //Message List 
            $("#nodatamsg").html('');
            $(".msglistpar").show();
            if(invoke_by == 'status_change' || invoke_by == 'initiate'){
                load_message_list_data(mid);
            }
        }  
    }else{
        $("#tempskle2").html('<p class="m-3">No posts available</p>');
        $("#nodatamsg").html(`<div class="m-3 text-center"><img class="janoimg mt-5" src="${baseurl}site_assets_1/assets/img/no_results.svg" rel="nofollow"><h4>No data available</h4></div>`);
        $(".msglistpar").hide();
    }

}

// Contact List html replicate
function conactlist_html(data, mid) {
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
        if(val.user_image!=null){
            $html +=`<div class="avatar avatar-md"><img src="`+val.user_image+`" alt="Img" class="img-fluid rounded-circle"></div>`;
        }else{
            $html +=`<div class="avatar avatar-md profileImage rounded-circle">`+val.user_avatar+`</div>`;
        }
                
        $html +=` </div>
                    <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-9">
                        <p>`+val.title+`</p>
                        <h4 class="m-0">`+val.user_name+`</h4>
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
            html_msg = messagesListHtml(response.datas);    
            $('.message-list').append(html_msg);
            $('.message-list').scrollTop($('.message-list')[0].scrollHeight);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            // console.log(errorMsg);
            // $('#content').html(errorMsg);
        }
    });

}
function messagesPopulate(resp){
    $html_pro = devwidth = "";
    candi_data = resp.contact;
    messages = resp.messages;

    if(screensize<=575){
        devwidth = 'mobwidth';
    }
    
    $html_pro = `<div class="row">
        <div class="col-11 d-flex">
            <div class="mx-2 align-self-center mob-res-arrow" data-value="`+devwidth+`">
                <img src="${baseurl}images/msgs/arrow.png" alt="Img" class="img-fluid">
            </div>
            <div class="ms-2">
                <h5>`+candi_data.title+`</h5>
                <p class="m-0">`+candi_data.user_name+`</p>
            </div>
        </div>
        <div class="col-1 align-self-center">
        <i class="fa-solid fa-ellipsis-vertical"></i>
        </div>
    </div>`;
    html_msg = messagesListHtml(messages);
    
    $('.cand-pro').html($html_pro);
    $('.message-list').html(html_msg);
    $('#nodatamsg').html('');
    $('.msglistpar').show();

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

function change_url_state(mkey){
    //change url state
    resURL = window.location.href;
    if(mkey!=''){
        resURL = url_remove_last_path(resURL);
    }else{
        mkey = act_mid;
    }
    resURL= resURL + '/' + mkey;
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
setInterval(message_listen_data, 3000); // Fetch messages every 3 seconds (adjust as needed)
