function breedingEditBatchTreatments(id_batch, id_space){

    $('#breeding-batch-edit-treatments-div').mumuxTableEditor({
        class: "lf-table",
        messageareaid: "lf-space-message-div", 
        authAjax: true,
        id: "breeding-batch-edit-treatment-tableeditor",
        api: {
            url_getall: mumuxconfig.apiurl + "spaces/"+id_space+"/breedingbatches/"+id_batch+"/treatments",
            url_getone: mumuxconfig.apiurl + "spaces/"+id_space+"/breedingbatches/"+id_batch+"/treatments/",
            url_deleteone: mumuxconfig.apiurl + "spaces/"+id_space+"/breedingbatches/"+id_batch+"/treatments/",
            url_addone: mumuxconfig.apiurl + "spaces/"+id_space+"/breedingbatches/"+id_batch+"/treatments",
            url_updateone: mumuxconfig.apiurl + "spaces/"+id_space+"/breedingbatches/"+id_batch+"/treatments/",
        },
        messages:{
            editsuccess: "i18n.breeding.saveddata",
            deletesuccess: "i18n.breeding.deleteddata",
            addsuccess: "i18n.breeding.addeddata"
        },
        table: {
            
            title: "i18n.breeding.treatment",
            header: [
                {
                    name: "date",
                    label: "i18n.breeding.date",
                },
                {
                    name: "antibiotic",
                    label: "i18n.breeding.antibiotic",
                },
                {
                    name: "suppressor",
                    label: "i18n.breeding.suppressor",
                },
                {
                    name: "water",
                    label: "i18n.breeding.water",
                },
                {
                    name: "food",
                    label: "i18n.breeding.food",
                }
                ,
                {
                    name: "comment",
                    label: "i18n.breeding.comment",
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
                    type: "hidden",
                    name: "id_batch",
                },
                {
                    type: "date",
                    name: "date",
                    label: "i18n.breeding.date"
                },
                {
                    type: "text",
                    name: "antibiotic",
                    label: "i18n.breeding.antibiotic"
                },
                {
                    type: "text",
                    name: "suppressor",
                    label: "i18n.breeding.suppressor"
                },
                {
                    type: "text",
                    name: "water",
                    label: "i18n.breeding.water"
                },
                {
                    type: "text",
                    name: "food",
                    label: "i18n.breeding.food"
                },
                {
                    type: "textarea",
                    name: "comment",
                    label: "i18n.breeding.comment"
                },
            ],
        }
    });
}