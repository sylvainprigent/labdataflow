(function ($) {

    $.fn.authAjax = function (argument) {

        // parse args
        var param = {
            url: null,
            type: "GET",
            data: "",
            success: null
        };
        param = $.extend(param, argument); // on fusionne l'argument et l'objet

        $.ajax({
            url: param.url,
            type: param.type,
            data: param.data,
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Authorization", "Bearer " + window.sessionStorage.accessToken);
            },
            success: function (result)//we got the response
            {
                // store the new token or redirect to login
                if ("jwt" in result) {
                    window.sessionStorage.accessToken = result.jwt;
                }
                else {
                    window.location.replace(mumuxconfig.clienturl + 'login');
                    return;
                }

                if (param.success) {
                    param.success(result);
                }

            },
            error: function (exception) {
                alert('Exception:' + JSON.stringify(exception));
            }
        });
    };
})(jQuery);