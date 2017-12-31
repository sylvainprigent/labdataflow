$(document).ready(function () {

    $("#member-list-all-button").click(function(){
        lf_member_list_ajax("all");
    });


    function lf_member_list_ajax(filter){

        $.ajax({
            url: mumuxconfig.apiurl + "/members/filter/" + filter ,
            type: 'GET',
            data: '',
            success: function (result)//we got the response
            {

                
                data = JSON.parse(result);
                thisobj.each(function () {
                    mumuxTableGenerate($(this), data);
                });

            },
            error: function (exception) {
                alert('Exception:' + JSON.stringify(exception));
            }
        });

    }
});