$(document).ready(function () {

    var id_space = mumuxGetUrlParameters()[1];

    $('#lf-breeding-tool-conf-activation-div').mumuxForm({
        formId: "lf-breeding-conf-activation-form",
        authAjax: true,
        action: {
            type: "PUT",
            url: mumuxconfig.apiurl + "spaces/" + id_space + "/tools/breeding"
        },
        title: "i18n.breeding.activate",
        data: {
            origin: "ajax",
            url: mumuxconfig.apiurl + "spaces/" + id_space + "/tools/breeding",
            list: {
                module: "breeding",
                tool: "breeding",
                name: "i18n.breeding.breeding",
                icon: "fa-user",
                id_space: id_space,
                color: "#008080"
            }
        },
        widgets: [
            {
                type: "hidden",
                name: "module"
            },
            {
                type: "hidden",
                name: "tool"
            },
            {
                type: "hidden",
                name: "name"
            },
            {
                type: "hidden",
                name: "id_space"
            },
            {
                type: "hidden",
                name: "icon"
            },
            {
                type: "hidden",
                name: "color"
            },
            {
                type: "select",
                name: "user_role",
                label: "i18n.breeding.activatefor",
                options: {
                    origin: "list",
                    list: [
                        {
                            value: 0,
                            name: 'i18n.space.disabled'
                        },
                        {
                            value: 1,
                            name: 'i18n.space.visitor'
                        },
                        {
                            value: 2,
                            name: 'i18n.space.user'
                        },
                        {
                            value: 3,
                            name: 'i18n.space.manager'
                        },
                        {
                            value: 4,
                            name: 'i18n.space.admin'
                        },
                    ]
                }
            },
            {
                type: "number",
                name: "display_order",
                label: "i18n.breeding.displayorder",
            },
        ],
        successCallback: function (result) {

            $('#lf-space-message-div').mumuxMessage({
                message: "i18n.breeding.configsaved",
                type: "success",
                visible: true
            })
            /*
            $('#user_role').val(result.user_role);
            $('#display_order').val(result.display_order);
            alert("callback success: " + result);
            */
        }
    });

});