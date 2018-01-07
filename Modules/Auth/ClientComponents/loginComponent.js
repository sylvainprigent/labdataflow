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
                    window.sessionStorage.accessToken = response[0].jwt;
                    window.sessionStorage.setItem('username', response[0].user.name);
                    window.sessionStorage.setItem('userfirstname', response[0].user.firstname);
                    window.sessionStorage.setItem('userstatus', response[0].user.status_id);
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
