$(document).ready(function () {

    $('#lf-customercompany-div').mumuxForm({
        formId: "lf-customer-compnay-form",
        class: "lf-form",
        authAjax: true,
        action: {
            type: "PUT",
            url: mumuxconfig.apiurl + "spaces/" + mumuxGetUrlParameters()[1] + "/companies"
        },
        title: "i18n.customer.company",
        data: {
            origin: "ajax",
            url: mumuxconfig.apiurl + "spaces/" + mumuxGetUrlParameters()[1] + "/companies",
            list: {
                id_space: mumuxGetUrlParameters()[1]
            }
        },
        widgets: [
            {
                type: "hidden",
                name: "id_space",
            },
            {
                type: "text",
                name: "name",
                label: "i18n.customer.name",
            },
            {
                type: "textarea",
                name: "address",
                label: "i18n.customer.address",
            },
            {
                type: "text",
                name: "zipcode",
                label: "i18n.customer.zipcode",
            },
            {
                type: "text",
                name: "city",
                label: "i18n.customer.city",
            },
            {
                type: "text",
                name: "county",
                label: "i18n.customer.county",
            },
            {
                type: "text",
                name: "country",
                label: "i18n.customer.country",
            },
            {
                type: "text",
                name: "phone",
                label: "i18n.customer.phone",
            },
            {
                type: "text",
                name: "fax",
                label: "i18n.customer.fax",
            },
            {
                type: "text",
                name: "email",
                label: "i18n.customer.email",
            },
            {
                type: "text",
                name: "approval_number",
                label: "i18n.customer.approval_number",
            },
        ],
        successCallback: function (result) {

            $('#lf-space-message-div').mumuxMessage({
                message: "i18n.customer.savedcompany",
                type: "success",
                visible: true
            });
        }

    });
});
