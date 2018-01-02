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
            function(response){
                if ( response[0].status == 'success' ){
                    //alert("token = " + response[0].jwt);
                    window.sessionStorage.accessToken = response[0].jwt;
                    window.location.replace(mumuxconfig.clienturl + mumuxconfig.homepage);
                }
                else{
                    $("#error-message").show();
                }
            },
            'json' 
        );
    }); 
});
