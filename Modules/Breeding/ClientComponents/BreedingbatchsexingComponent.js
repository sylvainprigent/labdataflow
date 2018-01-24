function breedingEditBatchSexing(id_batch, id_space) {

    $('#breeding-batch-edit-sexing-div').mumuxForm({

        formId: "breeding-batch-edit-sexing-form",
        class: "lf-form",
        authAjax: true,
        action: {
            type: "POST",
            url: mumuxconfig.apiurl + "spaces/" + id_space + "/breedingbatches/" + id_batch + "/sexing"
        },
        title: "i18n.breeding.sexing",
        data: {
            origin: "list",
            list: {
                num_female: 0,
                num_male: 0
            }
        },
        widgets: [
            {
                type: "number",
                name: "num_female",
                label: "i18n.breeding.malesnum",
            },
            {
                type: "number",
                name: "num_male",
                label: "i18n.breeding.femalenum",
            },

        ],
        successCallback: function (result) {

            $('#lf-space-message-div').mumuxMessage({
                message: "i18n.breeding.sexingdonemessage" + result.femalename + ", " + result.malename,
                type: "success",
                visible: true
            });
            breedingEditBatchHeader(id_space, id_batch);
        }

    });
}
