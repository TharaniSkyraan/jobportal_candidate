var hash = window.location.hash;
$('.nav-tabs a').click(function (e) {
    $(this).tab('show');
    var scrollmem = $('body').scrollTop();
    window.location.hash = this.hash;
    $('html,body').scrollTop(scrollmem);
});

if(hash){
    $('.nav-tabs > li > a[href="'+hash+'"]').addClass('active');
    $(hash).addClass('show active');
}else{
    $('.nav-tabs > li > a[href="#aboutcmp"]').addClass('active');
    $('#aboutcmp').addClass('show active');
}


$.get(cmp_url)
.done(function (response) 
{

if(response.data.length > 0)
{
    
    $.each(response.data, function (i, data) 
    { 
        $('.amhbgally').append(`<div class="col-md-4 col-lg-3 col-xl-3 col-6 col-sm-4">
                                    <div class="card gallery galleryl" data-val=`+data['id']+`>
                                        <div class="card-body clicks">
                                            <div class="image_div">
                                                <img src=`+data['image_exact_url']+` class="img-fluid" draggable="false">
                                                <div class="hov_prinfo">Tab to Preview</div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <h3 class="fw-bold clicks">
                                                `+data['title']+`
                                            </h3>
                                            <div class="row">
                                                <div class="col-md-11 col-xl-11 col-lg-10 col-11 clicks">
                                                    <p>
                                                        `+data['description']+`
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>`);
                            });
    }else{
        $('.amhbgally').append('<span class="text-center fw-bolder">No Active Gallery</span>');
    }
});

$('.new_post').addClass('bg-lit-green-col');

$('input[name=choose_job_post]').on('click', function() 
{
var val = $('input[name=choose_job_post]:checked').val(); 

if(val == 'new'){ 
    $('.new_post').addClass('bg-lit-green-col');
    $('.old_post').removeClass('bg-lit-green-col');
}else if(val == 'old'){
    $('.new_post').removeClass('bg-lit-green-col');
    $('.old_post').addClass('bg-lit-green-col');
}
});


// View Gallery
$(document).on('click', '.gallery .clicks', function () {
var glyid = $(this).closest('.gallery').attr('data-val');
var owlCarouselHtml = '<div class="owl-carousel">';
$('.gallery.galleryl').each(function (gid) {
    if($(this).attr('data-val')==glyid){
        id=gid;
    }
    var url =$(this).find('.img-fluid').attr('src');
    var title = $(this).find('h3').text();
    var description = $(this).find('p').text();        
    owlCarouselHtml += '<div class="item" id="' + gid + '">';
    owlCarouselHtml += '<img src="' + url + '">';
    owlCarouselHtml += '<div class="layer-bottom"><h3>' + title + '</h3>';
    owlCarouselHtml += '<p class="m-0">' + description + '</p></div>';
    owlCarouselHtml += '</div>';           
});
owlCarouselHtml += '</div>';

$('#previewgallery .open-images').html(owlCarouselHtml);

$('#previewgallery .owl-carousel').owlCarousel({
    items: 1,
    nav: true,
    dots: false,
    mouseDrag: true,
    startPosition: id,
});
var lessid = id;
$('#previewgallery .owl-carousel').trigger('to.owl.carousel', [lessid, 1, true]);
$('#previewgallery').css('opacity', 0);

setTimeout(() => {
    $('#previewgallery').css('opacity', 1);
}, 500);
$('#previewgallery').modal('show');
});

$(document).keydown(function(e) {
if (e.keyCode === 39) { // Right arrow key
    $('.owl-carousel').trigger('next.owl.carousel');
}
});

$(document).keydown(function(e) {
if (e.keyCode === 37) { // Left arrow key
    $('.owl-carousel').trigger('prev.owl.carousel');
}
});
