$(document).ready(function(){


        // home
        $('#lf-space-navbar-title').click(function(e){
            e.preventDefault;
            window.location.replace(mumuxconfig.clienturl + "space/" + mumuxGetUrlParameters()[1]);
        });

    $(this).authAjax({
        url: mumuxconfig.apiurl + "/spaces/" + mumuxGetUrlParameters()[1],
        type: 'GET',
        data: '',
        success: function (result) {
            $('#lf-space-navbar-title').html(result.name);
        }
    });

});