      
$(document).on('select2:open', () => {
    document.querySelector('.select2-search__field').focus();
});

var ck_email = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
var ck_username = /^[A-Za-z0-9_]{1,20}$/;
var ck_phone = /^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/i;
var passwordRegex =  /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,36}$/;

$(document).on('keypress change', ".required", function() {

var fieldId = $(this).attr('id');
var fieldVal = $(this).val();

$('#'+fieldId).removeClass('is-invalid').removeClass('is-valid');

if(fieldId.indexOf('email') === -1) {  var checkEmail = false; }else{ var checkEmail = true; }
if(fieldId.indexOf('password') === -1) {  var checkPassword = false; }else{ var checkPassword = true; }
if(checkEmail === true){
    if(!ck_email.test(fieldVal)){
        setMsg(fieldId,'Please enter a valid email');
    } else {
        $('#div_'+fieldId).removeClass('has-error').addClass('has-success');$('#err_'+fieldId).html('');
    }  
}else if(checkPassword === true){
    if(!passwordRegex.test(fieldVal)){
        setMsg(fieldId,'Use min 8-36 characters with at least an Uppercase, Lowercase, Numbers & Symbols');
    }else {
        $('#'+fieldId).removeClass('is-invalid').addClass('is-valid');
        $('#div_'+fieldId).removeClass('has-error').addClass('has-success');$('#err_'+fieldId).html('');
    } 
}else{
    if(fieldVal == 0){
        setMsg(fieldId,'');
    }else {
        $('#div_'+fieldId).removeClass('has-error').addClass('has-success');$('#err_'+fieldId).html('');
        $('#div_'+fieldId).find('.select2-selection--single').removeClass('select2-is-invalid');
    }
}
});


function clrErr(){
    $(".form-group, .checkbox,.col-xs-8" ).removeClass( "has-error" );
    $(".err_msg").html('');
    $('.select2-selection--single').removeClass('select2-is-invalid');
    
    let isinvcls = document.querySelectorAll('.is-invalid');
    isinvcls.forEach(function(item) {
        item.classList.remove('is-invalid');
    });
}

function validateFormFields(fieldName, errMsg, fieldType,fieldValue=null){

    var ck_email = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    var ck_username = /^[A-Za-z0-9_]{1,20}$/;
    var ck_phone = /^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/i;
    var passwordRegex =  /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,36}$/;

    if(fieldType == 'radioClass') {
        // console.log($('.'+fieldName).is(':checked').length);
        if($('.'+fieldName).is(':checked').length  == 0){
            console.log('checked'+fieldType);
            setMsg(fieldName,errMsg);return true;
        }else{
            return false
        }
    }else if(fieldType == 'CKEDITOR'){
        var fieldText = fieldValue;
        if(fieldText == '<p><br></p>' || fieldText == '' || fieldText == '<p><br></p><ul></ul>' || fieldText == '<p></p>'){ 
            $('#'+fieldName).val('');
            setMsg(fieldName,errMsg);return true; 
        }

    }else if(fieldType == 'radio' ){
        if($("input[name="+fieldName+"]:checked").length  == 0){
            setMsg(fieldName,errMsg);return true;
        }else{
            return false
        }
    }else if(fieldType == 'checkbox'){
        if($("input[name='"+fieldName+"[]']:checked").length  == 0){
            setMsg(fieldName,errMsg);return true;
        }else{
            return false
        }
    }else if(fieldType == 'validateURL'){

        // var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
        //     '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
        //     '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
        //     '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
        //     '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
        //     '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
        // var pattern = /^((ftp|http|https):\/\/)?(www.)?(?!.*(ftp|http|https|www.))[a-zA-Z0-9_-]+(\.[a-zA-Z]+)+((\/)[\w#]+)*(\/\w+\?[a-zA-Z0-9_]+=\w+(&[a-zA-Z0-9_]+=\w+)*)?$/gm;
        var pattern = new RegExp('(http(s)?:\\/\\/.)?(www\\.)?[-a-zA-Z0-9@:%._\\+~#=]{2,256}\\.[a-z]{2,6}\\b([-a-zA-Z0-9@:%_\\+.~#?&=]*)', '');
        // console.log(pattern);

        let fval=$('#'+fieldName).val();
        if($.trim(fval) && !pattern.test(fval) ){
            setMsg(fieldName,'Invalid URL');return true;
        }else{
            return false;
        }
    }else if(fieldType == 'ValiDesignation'){
        var pattern = /^(([a-zA-Z ,.'-/]{6,180}))$/i;
        let fval=$('#'+fieldName).val();
        if($.trim(fval) == ''){
            setMsg(fieldName,errMsg);return true;
        }
        else if($.trim(fval) && !pattern.test(fval) ){
            setMsg(fieldName,'Please enter valid designation');return true;
        }else{
            return false;
        }
    }else if(fieldType == 'ValiCity'){
        let fval=$('#'+fieldName).val();
        if($.trim(fval) == ''){
            setMsg(fieldName,errMsg);return true;
        }
        else if(fval.length >= 180 || fval.length <= 6){
            if(fieldName=='company'){
                setMsg(fieldName,'Please enter valid Company');return true;
            }else if(fieldName=='name'){
                setMsg(fieldName,'Please enter valid Project title');return true;
            }else{
                setMsg(fieldName,'Please enter valid Location');return true;
            }
        }else{
            return false;
        }
    }else if(fieldType == 'ValInstitute'){
        var pattern = /^(([a-zA-Z &@,.'-/]{6,180}))$/i;
        let fval=$('#'+fieldName).val();
        if($.trim(fval) == ''){
            setMsg(fieldName,errMsg);return true;
        }
        else if($.trim(fval) && !pattern.test(fval) ){
            setMsg(fieldName,'Please enter valid Institute');return true;
        }else{
            return false;
        }
    }
    else if(fieldType == 'NameVali'){ 
        var pattern = /^(([a-zA-Z ,.'-]{1,75}))$/i;
        // var pattern = /^(([a-zA-Z ,.'-]{2,19}))$/i;
        var fval=$('#'+fieldName).val(); 
         fval = $.trim(fval);
        if(fval && !pattern.test(fval) ){
            setMsg(fieldName,'Please enter valid name');return true;
        }else if(fval == ''){
            setMsg(fieldName,errMsg); return true; 
        }else{
            return false;
        }
    }
    else if(fieldType == 'ValiPincode'){
        var pattern = /^(\d{4}|\d{6})$/i;
        let fval=$('#'+fieldName).val();
        if($.trim(fval) && !pattern.test(fval) ){
            setMsg(fieldName,'Please enter the valid pincode');return true;
        }else if(fval == ''){
            setMsg(fieldName,errMsg); return true;
        }else{
            return false;
        }
    }
    else{
        
        if(($.trim($('#'+fieldName).val()) == '' || $('#'+fieldName).val() == 0)){
            setMsg(fieldName,errMsg);return true;
        }else if(fieldType == 'validEmail' && !ck_email.test($('#'+fieldName).val())){
            setMsg(fieldName,'Please enter a valid email');return true;
        }
        else if(fieldType == 'validMobile' && !ck_phone.test($('#'+fieldName).val())){
            setMsg(fieldName,'Please enter a valid phone number');return true;
        }
        else if(fieldType == 'validUsername' && !ck_username.test($('#'+fieldName).val())){
            setMsg(fieldName,'Please enter a valid username');return true;
        }
        else if(fieldType == 'validPass' && !passwordRegex.test($('#'+fieldName).val()) && ($('#'+fieldName).val())){
            setMsg(fieldName,'Use min 8-36 characters with at least an Uppercase, Lowercase, Numbers & Symbols');return true;
        }
    else{
            return false;
        }
    }
}

function setMsg(fieldId,errMsg){
    $('#div_'+fieldId).removeClass('has-success').addClass('has-error');
    $('#err_'+fieldId).fadeIn();
    $('#err_'+fieldId).html(errMsg);
    // $('#'+fieldId).focus();
    $('#'+fieldId).addClass('is-invalid');  
    
    $('#div_'+fieldId).find(".select2-selection").addClass('select2-is-invalid');
}

$(function () {
    hideErrorMessages();
// 	$('input[type=checkbox], input[type=radio]').checkator();
});

function hideErrorMessages(){
    $('.alert-hide').delay(6000).fadeOut("slow");       
}
function tConv24(time24) {
    var ts = time24;
    var H = +ts.substr(0, 2);
    var h = (H % 12) || 12;
    h = (h < 10)?("0"+h):h;  // leading 0 at the left for 1 digit hours
    var ampm = H < 12 ? " AM" : " PM";
    ts = h + ts.substr(2, 3) + ampm;
    return ts;
};