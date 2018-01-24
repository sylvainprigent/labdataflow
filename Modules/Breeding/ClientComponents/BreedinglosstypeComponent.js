function showBreedingLossTypes(){

    var id_space = mumuxGetUrlParameters()[1];

    $('#lf-breeding-losstype-div').mumuxTableEditor({
        class: "lf-table",
        messageareaid: "lf-space-message-div", 
        authAjax: true,
        id: "breeding-losstype-table",
        api: {
            url_getall: mumuxconfig.apiurl + "spaces/" + id_space + "/losstypes",
            url_getone: mumuxconfig.apiurl + "spaces/" + id_space + "/losstypes/",
            url_deleteone: mumuxconfig.apiurl + "spaces/" + id_space + "/losstypes/",
            url_addone: mumuxconfig.apiurl + "spaces/" + id_space + "/losstypes",
            url_updateone: mumuxconfig.apiurl + "spaces/" + id_space + "/losstypes/",
        },
        messages:{
            editsuccess: "i18n.breeding.saveddata",
            deletesuccess: "i18n.breeding.deleteddata",
            addsuccess: "i18n.breeding.addeddata"
        },
        table: {
            
            title: "i18n.breeding.losstypes",
            header: [
                {
                    name: "name",
                    label: "i18n.breeding.name",
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
                    label: "i18n.breeding.name"
                }
            ],
        }
    });

}