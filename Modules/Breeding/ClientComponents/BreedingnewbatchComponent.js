$(document).ready(function () {

    var id_space = mumuxGetUrlParameters()[1];

    $('#lf-breeding-newbatch-div').mumuxForm({
        formId: "lf-breeding-newbatch-form",
        class: "lf-form",
        authAjax: true,
        action: {
            type: "POST",
            url: mumuxconfig.apiurl + "/spaces/" + id_space + "/breedingbatches"
        },
        title: "i18n.breeding.newbatch",
        data: {
            origin: "list",
            list: {
                id: 0,
                name: "",
                id_space: id_space,
                date_created: "",
                id_male_spawner: 0,
                id_female_spawner: 0,
                id_destination: 0,
                id_product: 0,
                quantity: 0,
                chipped: 0,
                comment: ""
            }
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
                label: "i18n.breeding.quantity",
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
            $('#lf-breeding-newbatch-component-div').hide();
            breedingEditBatchForm(id_space, result.id);
        },
        class: "lf-form"
    });
});