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

// typeaheade on body
$(function(){
    var stocks = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.whitespace,
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    prefetch: 'api/autocomplete/search_designation_default',
    remote: {
        url: "api/autocomplete/search_designation",
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

// typeahead on header

$(function(){
    var mdesignation_s = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.whitespace,
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    prefetch: 'api/autocomplete/search_designation_default',
    remote: {
        url: "api/autocomplete/search_designation",
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