function showBreedingProducts(){

    var id_space = mumuxGetUrlParameters()[1];

    $('#lf-breeding-product-div').mumuxTableEditor({
        class: "lf-table",
        messageareaid: "lf-space-message-div", 
        authAjax: true,
        id: "breeding-product-table",
        api: {
            url_getall: mumuxconfig.apiurl + "spaces/" + id_space + "/breedingproducts",
            url_getone: mumuxconfig.apiurl + "spaces/" + id_space + "/breedingproducts/",
            url_deleteone: mumuxconfig.apiurl + "spaces/" + id_space + "/breedingproducts/",
            url_addone: mumuxconfig.apiurl + "spaces/" + id_space + "/breedingproducts",
            url_updateone: mumuxconfig.apiurl + "spaces/" + id_space + "/breedingproducts/",
        },
        messages:{
            editsuccess: "i18n.breeding.saveddata",
            deletesuccess: "i18n.breeding.deleteddata",
            addsuccess: "i18n.breeding.addeddata"
        },
        table: {
            
            title: "i18n.breeding.products",
            header: [
                {
                    name: "name",
                    label: "i18n.breeding.name",
                },
                {
                    name: "category",
                    label: "i18n.breeding.category",
                }
            ]
        },
        form: {
            title: "i18n.breeding.product",
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
                },
                {
                    type: "select",
                    name: "id_category",
                    label: "i18n.breeding.category",
                    options: {
                        origin: "ajax",
                        url: mumuxconfig.apiurl + "spaces/" + id_space + "/breedingcategories",
                        value: "id",
                        name: "name"
                    }
                },
                {
                    type: "textarea",
                    name: "description",
                    label: "i18n.breeding.description"
                }
            ],
        }
    });

}