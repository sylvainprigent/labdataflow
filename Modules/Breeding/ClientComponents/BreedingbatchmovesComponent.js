function breedingEditBatchMoves(id_batch, id_space){

    $('#breeding-batch-edit-moves-div').mumuxTableEditor({
        class: "lf-table",
        messageareaid: "lf-space-message-div", 
        authAjax: true,
        id: "breeding-batch-edit-moves-tableeditor",
        api: {
            url_getall: mumuxconfig.apiurl + "spaces/"+id_space+"/breedingbatches/"+id_batch+"/losses",
            url_getone: mumuxconfig.apiurl + "spaces/"+id_space+"/breedingbatches/"+id_batch+"/losses/",
            url_deleteone: mumuxconfig.apiurl + "spaces/"+id_space+"/breedingbatches/"+id_batch+"/losses/",
            url_addone: mumuxconfig.apiurl + "spaces/"+id_space+"/breedingbatches/"+id_batch+"/losses",
            url_updateone: mumuxconfig.apiurl + "spaces/"+id_space+"/breedingbatches/"+id_batch+"/losses/",
        },
        messages:{
            editsuccess: "i18n.breeding.saveddata",
            deletesuccess: "i18n.breeding.deleteddata",
            addsuccess: "i18n.breeding.addeddata"
        },
        table: {
            
            title: "i18n.breeding.loss",
            header: [
                {
                    name: "quantity",
                    label: "i18n.breeding.quantity",
                },
                {
                    name: "date",
                    label: "i18n.breeding.date",
                },
                {
                    name: "typename",
                    label: "i18n.breeding.trlosstype",
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
                    type: "number",
                    name: "quantity",
                    label: "i18n.breeding.quantity"
                },
                {
                    type: "select",
                    name: "id_type",
                    label: "i18n.breeding.losstype",
                    options: {
                        origin: "ajax",
                        url: mumuxconfig.apiurl + "spaces/" + id_space + "/losstypes",
                        value: "id",
                        name: "name"
                    }
                },
                {
                    type: "textarea",
                    name: "comment",
                    label: "i18n.breeding.comment"
                },
            ],
        },
        callback: function(id){
            //alert("loss edit callback called");
            breedingEditBatchHeader(id_space, id_batch)
        }
    });
}