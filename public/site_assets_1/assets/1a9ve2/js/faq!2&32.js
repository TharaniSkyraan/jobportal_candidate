
var act_ckey = cat_key_from_url;
var faqData = 'faqData';
// is_empty_categorykey
change_url_state(is_empty_categorykey);
load_faq_data(act_ckey);

function change_url_state(ckey){
  //change url state
  resURL = window.location.href;
  if(ckey!=''){
      resURL = url_remove_last_path(resURL);
  }else{
      ckey = act_ckey;
  }
  resURL= resURL + '/' + ckey;
  history.pushState({}, '',resURL );
}

function url_remove_last_path(the_url){
  var the_arr = the_url.split('/');
  the_arr.pop();
  return( the_arr.join('/') );
}


$(document).on('click', '#ctlist .ctkey', function (event) {
  $('#search_input').val('');
  if($(this).data('ckey')!=act_ckey){
    $('.link').removeClass('active');
    $(this).children().addClass('active');

    act_ckey = $(this).data('ckey');
    change_url_state(act_ckey);

    ctit = $(this).find('span').text();
    $("#bi_activ_ct").text(ctit);
    load_faq_data(act_ckey);

  }

});


$(document).on('click', '#search', function (event) {
  search_val = $('#search_input').val();
  load_faq_data(act_ckey,search_val);

});

function load_faq_data(act_ckey,search_val='') {

  let csrf_token = $('meta[name=csrf-token]').attr('content');
  let req_url = baseurl + faqData;

  $.ajax({
      url: req_url,
      type: 'POST',
      data: { "_token": csrf_token, 'ckey': act_ckey, 'search_q': search_val},
      datatype: 'JSON',
      beforeSend: function () {          
          $('#content').addClass("is-loading");
          $('#nodatamsg').html('');
          $('.catfaqs').hide();
      },
      success: function (response) {
        if(search_val!=''){
          $("#bi_activ_ct").text('');
        }
        loadHtml(response.data);
      },
      complete: function () {
        $('#content').removeClass("is-loading");
        
      },
      error: function (xhr, ajaxOptions, thrownError) {
          var errorMsg = 'Ajax request failed: ' + xhr.responseText;
          // console.log(errorMsg);
          // $('#content').html(errorMsg);
      }
  });

}

function loadHtml(data){
  
  if(data.length!=0)
  {            
      html = "";
      
      $.each(data, function(key,val) 
      {
        active = '';
        imagd = `<img class="dropdown" src="${baseurl}images/m_svg/down.png" rel="nofollow">`;
        if(key==0){
          active = 'active';
          imagd = `<img class="dropdown" src="${baseurl}images/m_svg/up.png" rel="nofollow">`;
        }
        html +=`<li class="card event `+active+`">
                  <div class="member-infos">
                      <div class='member-title d-flex justify-content-between'>
                          <div><h4>`+val.question+`</h4></div>
                          <div>
                              `+imagd+`
                          </div>
                      </div>
                      <div class="member-location ">
                          <span class='entypo-location'>`+val.answer+`</span>
                      </div>
                  </div>                  
                </li>`;
          
      });

      $('.catfaqs').html(html);
      $('.catfaqs').show();
  }else{
      html = `<div class="m-3 text-center"><img class="w-25 mt-5" src="${baseurl}site_assets_1/assets/img/no_results.svg" rel="nofollow"><h4>No data available</h4></div>`;
      $('#nodatamsg').html(html);
  }
  return true;


}

$(document).on('click', '.member-title' , function(e){
  if($(this).closest('.event').hasClass('active')){
      $(this).closest('.event').removeClass('active');
      $(this).closest('.event').find('.dropdown').attr("src", `${baseurl}images/m_svg/down.png`);

  }else{
      $(this).closest('.event').addClass('active');
      $(this).closest('.event').find('.dropdown').attr("src", `${baseurl}images/m_svg/up.png`);
  }
})