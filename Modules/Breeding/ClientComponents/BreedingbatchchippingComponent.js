function breedingEditBatchChipping(id_space, id_batch){

    $('#breeding-batch-edit-chipping-div').mumuxTableEditor({
        class: "lf-table",
        messageareaid: "lf-space-message-div", 
        authAjax: true,
        id: "breeding-batch-edit-chipping-tableeditor",
        api: {
            url_getall: mumuxconfig.apiurl + "spaces/"+id_space+"/breedingbatches/"+id_batch+"/chipping",
            url_getone: mumuxconfig.apiurl + "spaces/"+id_space+"/breedingbatches/"+id_batch+"/chipping/",
            url_deleteone: mumuxconfig.apiurl + "spaces/"+id_space+"/breedingbatches/"+id_batch+"/chipping/",
            url_addone: mumuxconfig.apiurl + "spaces/"+id_space+"/breedingbatches/"+id_batch+"/chipping",
            url_updateone: mumuxconfig.apiurl + "spaces/"+id_space+"/breedingbatches/"+id_batch+"/chipping/",
        },
        messages:{
            editsuccess: "i18n.breeding.saveddata",
            deletesuccess: "i18n.breeding.deleteddata",
            addsuccess: "i18n.breeding.addeddata"
        },
        table: {
            
            title: "i18n.breeding.chipping",
            header: [
                {
                    name: "date",
                    label: "i18n.breeding.date",
                },
                {
                    name: "chip_number",
                    label: "i18n.breeding.chchipnumber",
                },
                {
                    name: "comment",
                    label: "i18n.breeding.comment",
                }
            ]
        },
        form: {
            title: "i18n.breeding.chipping",
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
                    name: "chip_number",
                    label: "i18n.breeding.chchipnumber"
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