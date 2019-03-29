$(document).ready(function() {


    $('input[type=password]').keyup(function() {
    var pswd = $(this).val();
    if ( pswd.length < 12 ) {
    $('#length').removeClass('valid').addClass('invalid');
} else {
    $('#length').removeClass('invalid').addClass('valid');
}
    if ( pswd.match(/[A-Z]/) ) {
    $('#capital').removeClass('invalid').addClass('valid');
} else {
    $('#capital').removeClass('valid').addClass('invalid');
}
    if ( pswd.match(/\d/) ) {
    $('#number').removeClass('invalid').addClass('valid');
} else {
    $('#number').removeClass('valid').addClass('invalid');
}
        if ( pswd.match(/[^\w\s]/gi) ) {
    $('#special').removeClass('invalid').addClass('valid');
} else {
    $('#special').removeClass('valid').addClass('invalid');
}
            if ( pswd.match(/[a-z]/) ) {
    $('#lower').removeClass('invalid').addClass('valid');
} else {
    $('#lower').removeClass('valid').addClass('invalid');
}
    
}).focus(function() {
    $('#pswd_info').show();
}).blur(function() {
    $('#pswd_info').hide();
});

});


