function breedingEditBatchForm(id_space, id_batch){

    $('#breeding-informations-component-div').show();
    $('#breeding-moves-component-div').hide();
    $('#breeding-treatments-component-div').hide();
    $('#breeding-chipping-component-div').hide();
    $('#breeding-sexing-component-div').hide();
    $('#lf-breeding-batch-edit-component-div').show();

    $('#breeding-batch-edit-informations-a').addClass("active");

    $("#lf-breeding-batch-edit-form-div").mumuxForm({
        formId: "lf-breeding-informations-form",
        class: "lf-form",
        authAjax: true,
        action: {
            type: "PUT",
            url: mumuxconfig.apiurl + "/spaces/" + id_space + "/breedingbatches/" + id_batch
        },
        title: "",
        data:{
            origin: "ajax",
            url: mumuxconfig.apiurl + "/spaces/" + id_space + "/breedingbatches/" + id_batch
        },
        widgets: [
            {
                type: "hidden",
                name: "id"
            },
            {
                type: "hidden",
                name: "id_space"
            },
            {
                type: "text",
                name: "name",
                label: "i18n.breeding.reference"
            },
            {
                type: "date",
                name: "created_date",
                label: "i18n.breeding.birthdate"
            },
            {
                type: "select",
                name: "id_male_spawner",
                label: "i18n.breeding.malespawner",
                options: {
                    origin: "ajax",
                    url: mumuxconfig.apiurl + "/spaces/" + id_space + "/breedingbatches",
                    value: "id",
                    name: "name"
                }
            },
            {
                type: "select",
                name: "id_female_spawner",
                label: "i18n.breeding.femalespawner",
                options: {
                    origin: "ajax",
                    url: mumuxconfig.apiurl + "/spaces/" + id_space + "/breedingbatches",
                    value: "id",
                    name: "name"
                }
            },
            {
                type: "select",
                name: "id_destination",
                label: "i18n.breeding.destination",
                options: {
                    origin: "list",
                    list: [
                        {
                            value: 1,
                            name: 'i18n.breeding.sale'
                        },
                        {
                            value: 2,
                            name: 'i18n.breeding.lab'
                        }
                    ]
                }
            },
            {
                type: "select",
                name: "id_product",
                label: "i18n.breeding.product",
                options: {
                    origin: "ajax",
                    url: mumuxconfig.apiurl + "/spaces/" + id_space + "/breedingproducts",
                    value: "id",
                    name: "name"
                }
            },
            {
                type: "number",
                name: "initial_quantity",
                label: "i18n.breeding.initialquantity",
            },
            {
                type: "select",
                name: "chipped",
                label: "i18n.breeding.chipped",
                options: {
                    origin: "list",
                    list: [
                        {
                            value: 0,
                            name: 'i18n.breeding.no'
                        },
                        {
                            value: 1,
                            name: 'i18n.breeding.yes'
                        }
                    ]
                }
            },
            {
                type: "textarea",
                name: "comment",
                label: "i18n.breeding.comment",
            }

        ],
        successCallback: function (result) {
            $("#lf-space-message-div").mumuxMessage({
                message: "i18n.breeding.brbatchinfosaved",
            });
            breedingEditBatch(id_space, id_batch);
        }
    });

}
