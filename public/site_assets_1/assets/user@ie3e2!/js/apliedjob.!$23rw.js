  var activeappStatus = applicationStatus = page = '';
  var hash = window.location.hash;
  $('.nav-tabs a').click(function (e) {
      $(this).tab('show');
      var scrollmem = $('body').scrollTop();
      window.location.hash = this.hash;
      hash = this.hash;
      applicationStatus =  hash.replace("#", "");
      if(applicationStatus != activeappStatus){
        activeappStatus = applicationStatus;
        fetch_data(1);
      }
      $('html,body').scrollTop(scrollmem);
  });

  if(hash){
      $('.nav-tabs > li > a[href="'+hash+'"]').addClass('active');
      $(hash).addClass('show active');
      activeappStatus = hash.replace("#", "");
  }else{
      $('.nav-tabs > li > a[href="#all"]').addClass('active');
      $('#all').addClass('show active');
      activeappStatus = 'all';
  }
  
  $(document).on('click', '.pagination a', function(event){
    event.preventDefault(); 
    page = $(this).attr('href').split('page=')[1];
    fetch_data(page);
  });

  function fetch_data(page)
  { 

      $('.jobList').html(''); 
      var csrf_token = $('meta[name=csrf-token]').attr('content');
      $.ajax({
        type: "POST",
        url: baseurl+"applied-jobs?page="+page,
        data: {'sortBy': activeappStatus,"_token": csrf_token},
        datatype: 'json',
        beforeSend:function(){
          $('.jobList').addClass('is-loading');
        },
        success: function (json) {
          if(activeappStatus == 'all'){
            $('.allJobList').html(json.html);
          }
          else if(activeappStatus == 'viewed'){
            $('.viewedJobList').html(json.html);
          }
          else if(activeappStatus == 'shortlisted'){
            $('.shortlistedJobList').html(json.html);
          }
          // else if(activeappStatus == 'consider'){
          //   $('.consideredJobList').html(json.html);
          // }
          else if(activeappStatus == 'rejected'){
            $('.rejectedJobList').html(json.html);
          }

          $('.jobList').removeClass('is-loading');
        }

      });
    
  }
  fetch_data(1);  

  $(document).on( 'click', '.favjob', function(e) {
    e.stopPropagation();
    // alert(jobidv)
    btn = $(this);
    jobUnsave(btn);
  });
  
  function jobUnsave(favj)
  {
  
    var csrf_token = $('meta[name=csrf-token]').attr('content');

    favj.prop("disabled", true);
    var btn = $(favj).children().first();

    $.ajax({
        url: baseurl+"save/"+favj.attr("data-slug"),
        type: 'POST',
        data : {"_token": csrf_token,'is_login':1, 'fav':$(favj).attr("data-fav") },
        datatype: 'JSON',
        success: function(resp) {
          
          var fav = resp.fav;
          $(favj).prop("disabled", false); 
          $(favj).attr("data-fav", fav);

          if(fav=='yes'){
              $(btn).html(`<img draggable="false" class="image-size cursor-pointer" src="${baseurl}site_assets_1/assets/img/star_filled.png" alt="bookmark"> <span> Saved</span>`);
          }
          else{
              $(btn).html(`<img draggable="false" class="image-size cursor-pointer" src="${baseurl}site_assets_1/assets/img/star_unfilled.png" alt="bookmark"> <span> Save</span>`);
          }
          // toastr.success(resp.message);    
        }
    });

  } 
  
  $(document).on( 'click', '.job-list', function(e) {
      url = baseurl + 'detail/'+ $(this).data("jobid");
      openInNewTabWithNoopener(url)
  });

  function openInNewTabWithNoopener(val) {
      const aTag = document.createElement('a');
      aTag.rel = 'noopener';
      aTag.target = "_blank";
      aTag.href = val;
      aTag.click();
  }
  