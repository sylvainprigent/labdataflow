$(document).ready(function () {

    $('#lf-member-add-div').mumuxForm({

        formId: "addMemberForm",
        class: "lf-form",
        authAjax: true,
        action: {
            type: "POST",
            url: mumuxconfig.apiurl + "members"
        },
        title: "i18n.member.addmember",
        data:{
                origin: "list",
                list: {
                    id: 0,
                    firstname: "",
                    name: "",
                    login: "",
                    email: "",
                    password: "",
                    passwordconfirm: "",
                    phone: "",
                    date: new Date().toJSON().slice(0,10)
                }
        },
        widgets: [
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
                type: "password",
                name: "password",
                label: "i18n.member.password",
            },
            {
                type: "password",
                name: "passwordconfirm",
                label: "i18n.member.passwordconfirm",
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
        successCallback: function(result){

            if ( result.status ){
                if ( result.status == "success"){
                    $('#lf-member-message-div').mumuxMessage({
                        message: "i18n.member.memberhasbeencreated",
                        type: "success",
                        visible: true
                    });
                }
                else if ( result.status == "error" && result.code == "1"){

                    $('#lf-member-message-div').mumuxMessage({
                        message: "i18n.member.passwordsdifferent",
                        type: "danger",
                        visible: true
                    });
                }
                else if ( result.status == "error" && result.code == "2"){

                    $('#lf-member-message-div').mumuxMessage({
                        message: "i18n.member.loginalreadytaken",
                        type: "danger",
                        visible: true
                    });
                }
                
            }
            else{
                    $('#lf-member-message-div').mumuxMessage({
                        message: JSON.stringify(result),
                        type: "danger",
                        visible: true
                    });
            }
        }

    });

});