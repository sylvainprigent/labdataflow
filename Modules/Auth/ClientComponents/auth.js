$( document ).ready(function() {

    $( document ).jqueryComplete(function( event, xhr, settings ) {
     
        data = $.parseJSON(xhr.responseText);

        // if token store the token
        if ('token' in data){
            window.sessionStorage.accessToken = data.token;
        }
        // if no token redirect to login
        else{
            window.location.replace(mumuxconfig.clienturl + 'login');
        }
        
    });

});