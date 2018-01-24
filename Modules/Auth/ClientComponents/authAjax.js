(function ($) {

    $.fn.authAjax = function (argument) {

        // parse args
        var param = {
            url: null,
            type: "GET",
            contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
            data: "",
            success: null,
            error: function (exception) {
                alert('Exception:' + JSON.stringify(exception));
            }
        };
        param = $.extend(param, argument); // on fusionne l'argument et l'objet

        $.ajax({
            url: param.url,
            type: param.type,
            contentType: param.contentType,
            data: param.data,
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Authorization", "Bearer " + window.sessionStorage.accessToken);
            },
            success: function (result)//we got the response
            {
                //alert( JSON.stringify( result ) );
                // store the new token or redirect to login
                if (typeof result =='object' && "jwt" in result) {
                    window.sessionStorage.accessToken = result.jwt;
                }
                else {
                    if (mumuxconfig.debugmode){
                        alert("token not found in ajax:" + JSON.stringify(result));
                    }
                    else{
                        window.location.replace(mumuxconfig.clienturl + 'login');
                    }
                    return;
                }

                //alert(JSON.stringify(result));

                if (param.success) {
                    param.success(result.data);
                }

            },
            error: function (exception) {
                if (param.error) {
                    param.error(exception);
                }
            }
        });
    };
})(jQuery);