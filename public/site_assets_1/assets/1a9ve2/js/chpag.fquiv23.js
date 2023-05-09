
let csrf_token = $('meta[name=csrf-token]').attr('content');

$("#passbtn").click(function(){
    var data = current_city;
    search('',data);
});

$('.titsearch').on('click', function(){
    var designation =  $(this).attr('data-d');
    var location =  $(this).attr('data-l');
    search(designation,location);
});

$(".jobsearch").click(function(){

    var location = current_city;

    // $div = $(this).parent("div");

    // id = $div.attr("class");

    position = $(this).find(".jobsearchtitle").text();

    search(position, location);

});

$(".topcities").click(function(){

    // $div = $(this).parent("div");

    // id = $div.attr("class");

    // position = $div.find(".fw-bolder").text();

    position = $(this).find(".city").text();

    search('', position);

});

$(".topsector").click(function(){

    position = $(this).find(".sector").text();

    search(position, '');

});

// document.onkeyup = enter;
function enter(e) {
    if (e.which == 13) {
        var myElement = document.getElementById('designation');
        var myElement1 = document.getElementById('location');
        if(myElement === document.activeElement || myElement1 === document.activeElement){
            $('#msearch_btn').trigger('click');
        }
    }
} 

$('.resentsearch').on('click', function(){
search($(this).data('d'),$(this).data('l'));
});



$('#designation').on('keyup', function(){
    $('#designation').css('border','1px solid lightgray');
});

$('#msearch_btn').on('click', function(){
    //myElement Has Focus
    search($('#designation').val(),$('#location').val());
});


$(function(){
    var cache1 = JSON.parse(localStorage.getItem('designation'))??{};
    var enter_limit = 1;
    
    $('#designation').typeahead({ // focus on first result in dropdown
        source: function(query, result) {
            var local_cache = JSON.parse(localStorage.getItem('designation'));
            if ((local_cache!=null) && (query in local_cache)) {
                // If result is already in local_cache, return it
                result(cache1[query]);
                return;
            }
            $.ajax({
                url: path1,
                method: 'GET',
                data: {q: query},
                dataType: 'json',
                success: function(data) {
                    cache1[query] = data;
                    localStorage.setItem('designation',JSON.stringify(cache1));
                    result(data);
                }
            });
        },
        autoSelect: false,
        showHintOnFocus: true
    }).focus(function () {
        $(this).typeahead("search", "");
    }).on('keydown', function(event){        
        if(event.keyCode=='40' || event.keyCode=='38'){
            enter_limit=0;
            if($('#designation').val()==''){
                $(".designation").find('.active').removeClass('active');
                $(".designation").find('li:first-child').addClass('active li-active');
            }else{
                $(".designation").find('li').removeClass('li-active');
                $(".designation").find('.active').addClass('li-active');
            }
            var current_designation = $(".designation").find('.active').text();
            $('#designation').val(current_designation);
        }else if(event.keyCode=='13'){
            if(enter_limit==1){
                document.onkeyup = enter;
            }else if(enter_limit==0){
                enter_limit=1;
            }
        } 
    });

    var cache = JSON.parse(localStorage.getItem('search_city'))??{};
    var enter_limit1 = 1;
 
    $('#location').typeahead({ // focus on first result in dropdown
        source: function(query, result) {
            var local_cache = JSON.parse(localStorage.getItem('search_city'));
            if ((local_cache!=null) && (query in local_cache)) {
                // If result is already in local_cache, return it
                result(cache[query]);
                return;
            }
            $.ajax({
                url: path,
                method: 'GET',
                data: {q: query},
                dataType: 'json',
                success: function(data) {
                    cache[query] = data;
                    localStorage.setItem('search_city',JSON.stringify(cache));
                    result(data);
                }
            });
        },
        autoSelect: false,
        showHintOnFocus: true
    }).focus(function () {
        $(this).typeahead("search", "");
    }).on('keydown', function(event) {
        if(event.keyCode=='40' || event.keyCode=='38'){
            enter_limit1=0;
            if($('#location').val()==''){
                $(".location").find('.active').removeClass('active');
                $(".location").find('li:first-child').addClass('active li-active');
            }else{
                $(".location").find('li').removeClass('li-active');
                $(".location").find('.active').addClass('li-active');
            }
            var current_location = $(".location").find('.active').text();
            $('#location').val(current_location);
        }else if(event.keyCode=='13'){
            if(enter_limit1==1){
                document.onkeyup = enter;
            }else if(enter_limit1==0){
                enter_limit1=1;
            }
        } 
    });
});