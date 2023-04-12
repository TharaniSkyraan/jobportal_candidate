
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

    $div = $(this).parent("div");

    id = $div.attr("class");

    position = $div.find(".fw-bolder").text();

    search(position, location);

});

$(".topcities").click(function(){

    $div = $(this).parent("div");

    id = $div.attr("class");

    position = $div.find(".fw-bolder").text();

    search('', position);

});

document.onkeyup = enter;
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

function search(d, l){
    $('#designation').css('border','1px solid lightgray');
    $('.err_msg').html('');
    if($.trim(d) != '' || $.trim(l) !=''){      
        $.post(baseurl+"checkkeywords", {designation: d, location: l, _method: 'POST', _token: csrf_token})
            .done(function (response) {
                var l = '';
                var d = '';
            if(response.d !=''){
                d = 'd='+response.d;
            }
            if(response.l !=''){
                if(response.d !=''){
                    l += '&';
                }
                l += 'l='+response.l;
            }
            url = baseurl;
            window.location = url+response.sl+'?'+d+l;
        });
    }else{
        $('.designation-error').html('Please enter title, keyword or company');
        $('#designation').css('border','1px solid #f25961');
    }
}

$('#designation').on('keyup', function(){
    $('#designation').css('border','1px solid lightgray');
});

$('#msearch_btn').on('click', function(){
    //myElement Has Focus
    search($('#designation').val(),$('#location').val());
});


$(function(){
    var cache1 = JSON.parse(localStorage.getItem('designation'))??{};
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
        autoSelect: true,
        showHintOnFocus: true
    }).focus(function () {
        $(this).typeahead("search", "");
    });

    var cache = JSON.parse(localStorage.getItem('search_city'))??{};
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
        autoSelect: true,
        showHintOnFocus: true
    }).focus(function () {
        $(this).typeahead("search", "");
    });
});