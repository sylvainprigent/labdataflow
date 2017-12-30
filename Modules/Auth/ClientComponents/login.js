$( document ).ready(function() {

    $("#error-message").hide();

    $("#login-form").submit( function(e){
        e.preventDefault();

        $.post(
            mumuxconfig.apiurl + 'login', 
            {
                login : $('#login').val(), 
                password : $('#password').val(),
            }, 
            mumuxAuthLogin,
            'json' 
        );
    }); 
});

function mumuxAuthLogin(response){

    if ( response[0].status == 'success' ){
        window.sessionStorage.accessToken = response[0].token;
        window.location.replace(mumuxconfig.clienturl + 'user');
    }
    else{
        $("#error-message").show();
    }

}

