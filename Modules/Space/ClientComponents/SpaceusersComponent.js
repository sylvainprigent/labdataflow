$(document).ready(function () {

    var id_space = mumuxGetUrlParameters()[1];

    $('#lf-spaceusers-div').mumuxTableEditor({
        messageareaid: "lf-space-users-message-div", 
        authAjax: true,
        id: "space-users-table",
        api: {
            url_getall: mumuxconfig.apiurl + "spaces/" + id_space + "/accesses",
            url_getone: mumuxconfig.apiurl + "spaces/" + id_space + "/accesses/",
            url_deleteone: mumuxconfig.apiurl + "spaces/" + id_space + "/accesses/",
            url_addone: mumuxconfig.apiurl + "spaces/" + id_space + "/accesses",
            url_updateone: mumuxconfig.apiurl + "spaces/" + id_space + "/accesses/",
        },
        messages:{
            editsuccess: "i18n.space.accesssaved",
            deletesuccess: "i18n.space.accessdeleted",
            addsuccess: "i18n.space.accessadded"
        },
        table: {
            title: "i18n.space.users",
            header: [
                {
                    name: "name",
                    label: "i18n.space.name",
                },
                {
                    name: "firstname",
                    label: "i18n.space.firstname",
                },
                {
                    name: "status",
                    label: "i18n.space.status",
                }
            ]
        },
        form: {
            title: "i18n.space.users",
            widgets: [
                {
                    type: "hidden",
                    name: "id",
                },
                {
                    type: "hidden",
                    name: "id_space",
                },
                {
                    type: "select",
                    name: "id_user",
                    label: "i18n.space.users",
                    options: {
                        origin: "ajax",
                        url: mumuxconfig.apiurl + "members",
                        value: "id",
                        name: "fullname"
                    }
                },
                {
                    type: "select",
                    name: "id_status",
                    label: "i18n.space.status",
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
                            }
                        ]
                    }
                }
            ],
        }

    });

});