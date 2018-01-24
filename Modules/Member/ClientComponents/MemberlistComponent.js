$(document).ready(function () {

    var memberListActiveButton = "member-list-all-button";
    lf_member_list_ajax("member-list-all-button", "all");
    $("#member-list-all-button").addClass("active");

    $('.mumber-list-letter-button').click(function () {

        filter = $(this).data("letter");

        buttonId = "member-list-" + filter + "-button";
        $(this).addClass("active");
        $('#' + memberListActiveButton).removeClass('active');
        memberListActiveButton = buttonId;

        lf_member_list_ajax(buttonId, filter);

    })

    $('#member-list-display-div').on('click', '.lf-member-edit-button', function () {
        $userid = $(this).data("id");

        
        $('#member-edit-form-div').mumuxForm({
            formId: "MemberEditForm",
            class: "",
            authAjax: true,
            action: {
                type: "PUT",
                url: mumuxconfig.apiurl + "members/" + $userid
            },
            
            title: "",
            data:{
                origin: "ajax",
                url: mumuxconfig.apiurl + "members/" + $userid
            },
            widgets: [
                {
                    type: "hidden",
                    name: "id",
                },
                {
                    type: "text",
                    name: "login",
                    label: "i18n.member.login",
                },
                {
                    type: "text",
                    name: "firstname",
                    label: "i18n.member.firstname",
                },
                {
                    type: "text",
                    name: "name",
                    label: "i18n.member.name"
                },
                {
                    type: "text",
                    name: "email",
                    label: "i18n.member.email"
                },
                {
                    type: "text",
                    name: "phone",
                    label: "i18n.member.phone"
                },
                {
                    type: "date",
                    name: "date_end_contract",
                    label: "i18n.member.dateendcontract"
                },
                {
                    type: "select",
                    name: "status_id",
                    label: "i18n.member.status",
                    options: {
                        origin: "list",
                        list: [
                            {
                                value: 1,
                                name: 'user'
                            },
                            {
                                value: 2,
                                name: 'admin'
                            }
                        ]
                    }
                },
            ],
            successCallback: function (result) {
                alert(JSON.stringify(result));
                $('#member-edit-modal-div').modal('hide');
            }
        });
        $('#member-edit-modal-div').modal('show');
    });

    function lf_member_list_ajax(buttonId, filter) {

        $(this).authAjax({
            url: mumuxconfig.apiurl + "members/filter/" + filter,
            type: 'GET',
            data: '',
            success: function (result) {

                data = result;

                if (!data) {
                    $('#member-list-display-div').html("");
                    return;
                }
                membercount = data.length;
                html = "";
                for (i = 0; i < membercount; i++) {
                    html += '<div class="row col-12 lf-member-row">';
                    html += '<div class="col-2">';
                    if (data[i].avatar != "") {
                        html += '<img src="' + data[i].avatar + '" alt="avatar" width="85" class="rounded mx-auto d-block">';
                    }
                    else {
                        html += '<div class="text-center">';
                        html += '<i class="fa fa-user fa-5x"></i>';
                        html += '</div>';
                    }
                    html += '</div>';
                    html += '<div class="col-7">';
                    html += '<p class="text-primary"><a><strong> ' + data[i].firstname + ' ' + data[i].name + ' </strong></A></p>';
                    html += '<span class="text-muted"> ' + data[i].institution;
                    if (data[i].location != "") {
                        html += ', ' + data[i].location;
                    }
                    html += ' <br/>';
                    html += ' ' + data[i].position;
                    if (data[i].title != "") {
                        html += ', ' + data[i].title;
                    }
                    html += ' </span>';
                    html += '</div>';

                    html += '<div class="col-3">';
                    html += '<button class="btn btn-secondary btn-block">i18n.member.contactadd</button>';
                    if (window.sessionStorage.getItem('userstatus') > 1) {
                        html += '<button class="btn btn-primary btn-block lf-member-edit-button" data-id="' + data[i].id + '">i18n.member.edit</button>';
                    }
                    html += '</div>';

                    html += '</div>';
                }
                $('#member-list-display-div').html(html);
            }
        });

    }
});