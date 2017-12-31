$(document).ready(function () {

    // logout
    $("#navbar-logout-a").click(function(e){
        e.preventDefault;
        window.sessionStorage.accessToken = "";
        window.location.replace(mumuxconfig.clienturl + "login");
    });

    // load user data
    $(this).authAjax({
        url: mumuxconfig.apiurl + 'navbar',
        type: 'GET',
        data: '',
        success: function (result)//we got the response
        {
            // action
            //alert("got the avatar" + JSON.stringify(result));
            $("#lf-navbar-avatar").attr('src', result.data.user.avatar)
            
        }
    });

    // show hide side bar
    $('#lf-sidenav-button').click(function (e) {
        e.preventDefault();

        if( $('#lf-side-navbar').css('width') == '0px' ){
            $('#lf-side-navbar').animate(
                {
                    width: '20%'
                },
                {
                    duration: 200,
                    easing: 'linear',
                }
            );
        }
        else{
            $('#lf-side-navbar').animate(
                {
                    width: '0px'
                },
                {
                    duration: 200,
                    easing: 'linear',
                }
            );
        }

        
    }


    );

});