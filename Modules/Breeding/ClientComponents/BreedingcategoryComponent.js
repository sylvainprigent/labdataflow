function showBreedingCategories(){

    var id_space = mumuxGetUrlParameters()[1];

    $('#lf-breeding-category-div').mumuxTableEditor({
        class: "lf-table",
        messageareaid: "lf-space-message-div", 
        authAjax: true,
        id: "breeding-category-table",
        api: {
            url_getall: mumuxconfig.apiurl + "spaces/" + id_space + "/breedingcategories",
            url_getone: mumuxconfig.apiurl + "spaces/" + id_space + "/breedingcategories/",
            url_deleteone: mumuxconfig.apiurl + "spaces/" + id_space + "/breedingcategories/",
            url_addone: mumuxconfig.apiurl + "spaces/" + id_space + "/breedingcategories",
            url_updateone: mumuxconfig.apiurl + "spaces/" + id_space + "/breedingcategories/",
        },
        messages:{
            editsuccess: "i18n.breeding.saveddata",
            deletesuccess: "i18n.breeding.deleteddata",
            addsuccess: "i18n.breeding.addeddata"
        },
        table: {
            
            title: "i18n.breeding.categories",
            header: [
                {
                    name: "name",
                    label: "i18n.breeding.name",
                },
                {
                    name: "description",
                    label: "i18n.breeding.description",
                }
            ]
        },
        form: {
            title: "i18n.breeding.category",
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
                ,
                {
                    type: "textarea",
                    name: "description",
                    label: "i18n.breeding.description"
                }
            ],
        }
    });

}