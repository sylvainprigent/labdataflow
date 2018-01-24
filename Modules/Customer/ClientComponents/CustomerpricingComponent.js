$(document).ready(function(){

    var id_space = mumuxGetUrlParameters()[1];

    $('#lf-customerpricing-div').mumuxTableEditor({
        messageareaid: "lf-space-message-div", 
        authAjax: true,
        id: "space-users-table",
        api: {
            url_getall: mumuxconfig.apiurl + "spaces/" + id_space + "/pricings",
            url_getone: mumuxconfig.apiurl + "spaces/" + id_space + "/pricings/",
            url_deleteone: mumuxconfig.apiurl + "spaces/" + id_space + "/pricings/",
            url_addone: mumuxconfig.apiurl + "spaces/" + id_space + "/pricings",
            url_updateone: mumuxconfig.apiurl + "spaces/" + id_space + "/pricings/",
        },
        messages:{
            editsuccess: "i18n.customer.savedpricing",
            deletesuccess: "i18n.customer.deletedpricing",
            addsuccess: "i18n.customer.addedpricing"
        },
        table: {
            title: "i18n.customer.pricings",
            header: [
                {
                    name: "name",
                    label: "i18n.space.name",
                }
            ]
        },
        form: {
            title: "i18n.customer.pricing",
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
                    type: "text",
                    name: "name",
                    label: "i18n.customer.name"
                }
            ],
        }
    });

});