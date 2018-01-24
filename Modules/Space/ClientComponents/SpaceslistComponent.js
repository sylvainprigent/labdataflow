$(document).ready(function () {

    if ( window.sessionStorage.getItem('userstatus') > 1){
        $('#lf-space-list-add-div').show();
    }
    else{
        $('#lf-space-list-add-div').hide();
    }

    $('#lf-space-add-admin-a').click(function(){

        $('#lf-space-edit-modal-div').modal('show');
        $('#lf-space-edit-form-div').mumuxForm({
            formId: "SpaceAddForm",
            class: "",
            authAjax: true,
            action: {
                type: "POST",
                url: mumuxconfig.apiurl + "spaces/"
            },
            title: "",
            data:{
                origin: "list",
                list:{
                        name: "",
                        status: 1
                    }        
            },
            widgets: [
                {
                    type: "text",
                    name: "name",
                    label: "i18n.space.name",
                },
                {
                    type: "select",
                    name: "status",
                    label: "i18n.space.status",
                    options: {
                        origin: "list",
                        list: [
                            {
                                value: 1,
                                name: 'i18n.space.public'
                            },
                            {
                                value: 0,
                                name: 'i18n.space.private'
                            }
                        ]
                    }
                },
            ],
            successCallback: function (result) {
                alert(JSON.stringify(result));
                $('#lf-space-edit-modal-div').modal('hide');
            }
        });
        
    });

    $(this).authAjax({
        url: mumuxconfig.apiurl + "/spaces",
        type: 'GET',
        data: '',
        success: function (result) {

            data = result.spaces;

            if (!data) {
                $('#lf-space-list-display-div').html("");
                return;
            }
            spacecount = data.length;
            html = "";
            for (i = 0; i < spacecount; i++) {


                html += '<div class="card" style="width: 20rem;">';
                imgurl = data[i].image;
                if (data[i].image = "" || data[i].image == null || data[i].image == "null"){
                    imgurl = mumuxconfig.clienturl + "web/assets/img/card.svg";
                }
                html += '<img class="card-img-top" src="'+imgurl+'" alt="Card image cap" width="318px" height="180px">';
                html += '<div class="card-block d-flex flex-column">';
                html += '<h4 class="card-title">'+data[i].name+'</h4>';
                html += '<p class="card-text">';
                if (data[i].description){
                    html +=  data[i].description;
                }
                html += '</p>';
                html += '<a href="space/'+data[i].id+'" class="btn btn-secondary btn-lg btn-block text-truncate mt-auto">i18n.space.open</a>';
                html += '</div>';
                html += '</div>';

            }
            $('#lf-space-list-display-div').html(html);
        }
    });


});