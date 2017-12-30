$(document).ready(function () {

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