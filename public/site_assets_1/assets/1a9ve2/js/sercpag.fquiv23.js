
let csrf_token = $('meta[name=csrf-token]').attr('content');
const ini_screensize = $( window ).width();
const web_screen = 576;
const mobile_screen = 575;
let widtherror = 'no';

function handleScreenSizeChange() {
    var screenWidth = $(window).width();

    if((ini_screensize<=mobile_screen) && (screenWidth<web_screen)){
        // console.log('Mob screen');
    }

    if((ini_screensize>mobile_screen) && (screenWidth>=web_screen)){
        // console.log('Web screen');
    }

    if((ini_screensize>=web_screen) && (screenWidth<=mobile_screen)){
        alert('Page Reloaded');
        widtherror ='yes';
        location.reload();
    }else if((ini_screensize<=mobile_screen) && (screenWidth>=web_screen)){
        alert('Page Reloaded');
        widtherror ='yes';
        location.reload();
    }
    return false;
}

// Attach the event listener to window resize
$(window).resize(function() {
    if(widtherror=='no'){
        // handleScreenSizeChange();
    }
});

// Call the function initially
handleScreenSizeChange();

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

$('#msearch_btn').on('click', function(){
    //myElement Has Focus
    var designation = $('#designation').val();
    var location = $('#location').val();
    search(designation,location, 'desk');
});

$('#mobsearch_btn').on('click', function(){
    //myElement Has Focus
    var designation = $('#mdesignation').val();
    var location = $('#mlocation').val();
    search(designation,location, 'mob');
});



    

if($( window ).width()<=575){

    // typeahead on header

    $(function(){
        var mdesignation_s = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.whitespace,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: 'api/autocomplete/search_title',
        remote: {
            url: "api/autocomplete/search_title",
            replace: function(url, query) {
                return url + "?q=" + query;
            },        
            filter: function(mdesignation_s) {
                return $.map(mdesignation_s, function(data) {
                    return {
                        // tokens: data.tokens,
                        // symbol: data.symbol,
                        name: data.name
                    }
                });
            }
        }
    });

    mdesignation_s.initialize();
    $('#mdesignation.typeahead').typeahead({
        hint: true,
        highlight: false,
        minLength: 1,
    },{
        name: 'mdesignation_s',
        displayKey: 'name',
        source: mdesignation_s.ttAdapter(),
        limit:Number.MAX_VALUE
        }); 
    });

    $(function(){
        var mlocation_s = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.whitespace,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: 'api/autocomplete/search_location_default',
        remote: {
            url: "api/autocomplete/search_location",
            replace: function(url, query) {
                return url + "?q=" + query;
            },        
            filter: function(mlocation_s) {
                return $.map(mlocation_s, function(data) {
                    return {
                        // tokens: data.tokens,
                        // symbol: data.symbol,
                        name: data.name
                    }
                });
            }
        }
    });

    mlocation_s.initialize();
    $('#mlocation.typeahead').typeahead({
        hint: true,
        highlight: false,
        minLength: 1,
    },{
        name: 'mlocation_s',
        displayKey: 'name',
        source: mlocation_s.ttAdapter(),
        limit:Number.MAX_VALUE
        }); 
    });
    // This is for adding attribute
    $("#designation").attr({"readonly":true,"data-bs-toggle":'offcanvas',"data-bs-target":'#offcanvasTop',"aria-controls":'offcanvasTop'});
    
    // And here example of removing both attribute
    $("#designation").removeAttr("data-mdb-toggle data-mdb-placement title");


}else{
        
    // typeaheade on body
    $(function(){
        var stocks = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.whitespace,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: 'api/autocomplete/search_title',
        remote: {
            url: "api/autocomplete/search_title",
            replace: function(url, query) {
                return url + "?q=" + query;
            },        
            filter: function(stocks) {
                return $.map(stocks, function(data) {
                    return {
                        // tokens: data.tokens,
                        // symbol: data.symbol,
                        name: data.name
                    }
                });
            }
        }
    });

    stocks.initialize();
    $('#designation.typeahead').typeahead({
        hint: true,
        highlight: false,
        minLength: 1,
    },{
        name: 'stocks',
        displayKey: 'name',
        source: stocks.ttAdapter(),
        limit:Number.MAX_VALUE
        }); 
    });

    $(function(){
        var location_s = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.whitespace,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: 'api/autocomplete/search_location_default',
        remote: {
            url: "api/autocomplete/search_location",
            replace: function(url, query) {
                return url + "?q=" + query;
            },        
            filter: function(location_s) {
                return $.map(location_s, function(data) {
                    return {
                        // tokens: data.tokens,
                        // symbol: data.symbol,
                        name: data.name
                    }
                });
            }
        }
    });

    location_s.initialize();
    $('#location.typeahead').typeahead({
        hint: true,
        highlight: false,
        minLength: 1,
    },{
        name: 'location_s',
        displayKey: 'name',
        source: location_s.ttAdapter(),
        limit:Number.MAX_VALUE
        }); 
    });
    
    // This is for adding attribute
    $("#designation").attr({"data-mdb-toggle":'tooltip',"data-mdb-placement":'left',"title":'Designation required'});
        
    // And here example of removing both attribute
    $("#designation").removeAttr("readonly data-bs-toggle data-bs-target aria-controls");

}
