    let csrf_token = $('meta[name=csrf-token]').attr('content');

    $(document).ready(function () {

        $("#sortby, #order").change(function(){
            fetch_data(1);
        });
        
        $("#search").click(function(){
            $('.searerr').text('')
            if($('#search_input').val() !=''){
                fetch_data(1);
            }else{
                $('.searerr').text('Please enter the search term')
            }
        });

        $("#search_input").keyup(function(){
            $('.searerr').text('')
            if($('#search_input').val() ==''){
                fetch_data(1);
            }
        });

        $(document).on('click', '.pagination a', function(event){
            event.preventDefault(); 
            var page = $(this).attr('href').split('page=')[1];
            fetch_data(page);
        });

    });

    function fetch_data(page)
    {  
        $.ajax({
            type: "POST",
            url: baseurl+"company/postedjobslist?page="+page,
            data: {"_token": csrf_token, "order" : $('#order').val(), "sortBy": $('#sortby').val(), "search": $('#search_input').val()},
            datatype: 'json',
            beforeSend:function(){
                $('#jobList').addClass('is-loading');
            },
            success: function (json) {
                $('#jobList').html(fetchDatas(json.jobs));
                $('#jobList').removeClass('is-loading');
                $('#paginate').html(json.paginate_html);
            }
        });
    }

    fetch_data(1);

    $("#statusUpdate").on('click' ,function(){

    let modalFor = $('#modalFor').val();
    if(modalFor == 'job_status'){
        let job_id =  $('#jbidv').val();
        let statusValue = $('#jbstatus').val();
        let statustxt =  $('#jbstatustxt').val();
        let statusImgsrc = $('#jbstatusimgsrc').val();
        $.ajax({
            type: "POST",
            url: baseurl+"company/jobStatusUpdate",
            data: {"_token": csrf_token, "job_id": job_id, "status": statusValue},
            datatype: 'json',
            success: function (json) {
                // toastr.options.timeOut = 560000000;
                toastr.success(json.message);
                $(`tbody [data-jbid='${job_id}']`).find('.selected-job-status').html('<img class="image-size" src="'+statusImgsrc+'" alt="'+statustxt+'"> '+statustxt);
                $('#applicationStatus').modal('hide');
            }
        });

    }
    else if(modalFor == 'job_del'){
        let job_id =  $('#jbidv').val();
        $.ajax({
            type: "POST",
            url: baseurl + "company/job/delete-job",
            data: {"_token": csrf_token, "job_id": job_id},
            datatype: 'json',
            success: function (json) {
                // toastr.options.timeOut = 560000000;
                toastr.success(json.message);
                $('#applicationStatus').modal('hide');
                fetch_data(1);
            }
        });
    }
    });
    
    


    function fetchDatas(data){

        html='';
        if(data.length!=0){
            
            $.each(data, function(key,val) {

                html += `<tr class="jdcarc" data-jbid="`+val.id+`">`;
                if(val.is_active==0)
                {

                 html += `<td>
                            <div class="mt-3">
                                <h4 class="text-green-color mb-3 trtitle"><b>`+val.title+`</b></h4>
                            </div>
                        </td>
                        <td colspan="4" class="text-center">
                            <div class="eralertbox">
                                <div class="d-flex align-items-center m-auto">
                                    <div class="">
                                        <label class="fw-bold">Your job posting is incomplete!</label>
                                    </div>
                                    <div>
                                        <a class="mx-4" href="`+baseurl+`company/job/create/job_info/`+val.id+`">
                                            <button class="btn btnc1">Finish job posting</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td colspan="2" class="text-center">
                            <div class="align-items-center">
                                <a class="" href="#">
                                    <button class="btn btnc2">Delete Draft</button>
                                </a>
                            </div>
                        </td>`;
                    } 
                    else
                    {
                    html += `<td>
                            <div class="mt-3">
                                <h4 class="text-green-color mb-3 trtitle"><b><a href="`+baseurl+`company/postedjob/`+val.jkey+`">`+val.title+`</a></b></h4>
                                <p class="expdc mb-2">Expiry Date :<span> `+format(new Date(val.expiry_date))+`<span></p>
                            </div>
                        </td>
                        <td class="text-center">`+val.suggested_users_count+`</td>
                        <td class="text-center">`;
                    if(val.applied_users_count !=0){
                        html += `<a href="`+baseurl+`company/postedjob/`+val.jkey+`" class="text-decoration-underline">
                        `+val.applied_users_count+`</a>`;
                    } else { html += `0`; }
                    html += `</td>
                        <td class="text-center">`+val.shortlistedcount+`</td>
                        <td class=" text-center">
                            <button class="btn selected-job-status dropdown-toggle" name="recordinput" data-bs-toggle="dropdown">`;
                            if(val.is_active == '1'){
                            html += `<img class="image-size" src="${baseurl}site_assets_1/assets/img/status/open.png" alt="Open"> Active`;
                            }else if(val.is_active == '2'){
                            html += `<img class="image-size" src="${baseurl}site_assets_1/assets/img/status/pause.png" alt="pause"> In active`;
                            }else if(val.is_active == '3'){
                            html += `<img class="image-size expired_btn" src="${baseurl}site_assets_1/assets/img/Rejected.png" alt="Expired"> Expired`;
                                
                            }else{
                            html += `<img class="image-size" src="${baseurl}site_assets_1/assets/img/status/open.png" alt="Open"> In active`;
                            }
                    html += `</button>
                            <ul class="dropdown-menu jobstatusmenu">
                                <li class="ddjslist dropdown-item"><div data-value="1"><img class="image-size" src="${baseurl}site_assets_1/assets/img/status/open.png" alt="open"><span class="ms-2">Active</span></div></li>
                                <li class="ddjslist dropdown-item"><div data-value="2"><img class="image-size" src="${baseurl}site_assets_1/assets/img/status/pause.png" alt="pause"><span class="ms-2">In active</span></div></li>
                                <!--<li class="ddjslist dropdown-item"><div data-value="3"><img class="image-size" src="${baseurl}site_assets_1/assets/img/Rejected.png" alt="close"><span class="ms-2">Close</span></div></li>-->
                            </ul>
                        </td>
                        <td class="text-center">
                            <div class="dropdown position-static">
                                <a class="btn " type="button" id="more_action" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="more_action">
                                    <li><a class="ddjslist dropdown-item" href="`+baseurl+`company/job/edit/`+val.id+`">Edit Job</a></li>
                                    <li><a class="ddjslist dropdown-item jactionvv" href="javascript:void(0);">Delete Job</a></li>
                                </ul>
                            </div>
                        </td>`;
                    }
                html +=`</tr>`;
            }); 

        }else{
            html = `<tr>
                <td colspan="7">
                    <div class="text-center">
                        <h5>No Data Found</h5>
                    </div>
                </td>
            </tr>`;
        }
        return html;
    }

    function format(inputDate) {
        let date, month, year;
      
        date = inputDate.getDate();
        month = inputDate.getMonth() + 1;
        year = inputDate.getFullYear();
      
          date = date
              .toString()
              .padStart(2, '0');
      
          month = month
              .toString()
              .padStart(2, '0');
      
        return `${date}/${month}/${year}`;
    
      }
    /////////////////////// Status Changes Script ////////////////////////////

    $(document).on('click', '.jobstatusmenu li' , function(e){
        
        let job_id =  $(this).parent().parent().parent().data('jbid');
        let statusValue = $(this).children().data('value');
        let statustxt = $(this).find('span').text();
        let statusImgsrc = $(this).find('.image-size').attr('src');
        // alert(job_id)
        if(job_id != '' && statusValue != '') {
            $('#modalFor').val('job_status');
            $('#jbidv').val(job_id);
            $('#jbstatus').val(statusValue);
            $('#jbstatustxt').val(statustxt);
            $('#jbstatusimgsrc').val(statusImgsrc);
            $('#txtmcontent').html('<h5 class="">Are you sure to change the Job Status as <b>'+statustxt+'?</b></h5>');
            $('#statusUpdate').text('Ok');
            $('#applicationStatus').modal('show');
        }
    });

    $(document).on('click', '.jactionvv' , function(e){
        let job_id =$(this).closest("tr").data('jbid');
        if(job_id != '') {
            $('#jbidv').val(job_id);
            $('#modalFor').val('job_del');
            $('#txtmcontent').html('<h5 class="">Are you sure want to delete the job?</b></h5>');
            $('#statusUpdate').text('Yes! Delete');
            $('#applicationStatus').modal('show');
        }
    });

    $(document).on('click', '.btnc2' , function(e){

        $('#jbidv').val($(this).closest("tr").data('jbid'));
        $('#modalFor').val('job_del');
        $('#txtmcontent').html('<h5 class="">Are you sure want to delete the job?</b></h5>');
        $('#statusUpdate').text('Yes! Delete');
        $('#applicationStatus').modal('show');

    });



