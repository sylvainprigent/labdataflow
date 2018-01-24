$(document).ready(function () {

    $('#lf-customercustomers-users-div').hide();
    $('#lf-customercustomers-customers-div').show();

    var id_space = mumuxGetUrlParameters()[1];

    $('#lf-customercustomers-customers-div').mumuxTableEditor({
        messageareaid: "lf-space-message-div",
        authAjax: true,
        id: "space-customers-table",
        api: {
            url_getall: mumuxconfig.apiurl + "spaces/" + id_space + "/customers",
            url_getone: mumuxconfig.apiurl + "spaces/" + id_space + "/customers/",
            url_deleteone: mumuxconfig.apiurl + "spaces/" + id_space + "/customers/",
            url_addone: mumuxconfig.apiurl + "spaces/" + id_space + "/customers",
            url_updateone: mumuxconfig.apiurl + "spaces/" + id_space + "/customers/",
        },
        messages: {
            editsuccess: "i18n.customer.savedcustomer",
            deletesuccess: "i18n.customer.deletedcustomer",
            addsuccess: "i18n.customer.addedcustomer"
        },
        table: {
            title: "i18n.customer.customers",
            buttons: [
                {
                    name: "btnusers",
                    label: "i18n.customer.users",
                    widget: "btn-secondary",
                    action: function (id) {
                        //alert("edit customer users: " + id);
                        $('#lf-customercustomers-users-div').show();
                        $('#lf-customercustomers-customers-div').hide();
                        customercustomersuserseditor(id);

                    }
                }
            ],
            header: [
                {
                    name: "name",
                    label: "i18n.customer.name",
                },
                {
                    name: "pricingname",
                    label: "i18n.customer.pricing",
                },
            ]
        },
        form: {
            title: "i18n.customer.customers",
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
                    label: "i18n.customer.name"
                },
                {
                    type: "text",
                    name: "contact_name",
                    label: "i18n.customer.contactname"
                },
                {
                    type: "text",
                    name: "phone",
                    label: "i18n.customer.phone"
                },
                {
                    type: "text",
                    name: "email",
                    label: "i18n.customer.email"
                },
                {
                    type: "select",
                    name: "pricing",
                    label: "i18n.customer.pricing",
                    options: {
                        origin: "ajax",
                        url: mumuxconfig.apiurl + "spaces/" + id_space + "/pricings",
                        value: "id",
                        name: "name"
                    }
                },
                {
                    type: "select",
                    name: "invoice_send_preference",
                    label: "i18n.customer.invoice_send_preference",
                    options: {
                        origin: "list",
                        list: [
                            {
                                id: 1,
                                name: "i18n.customer.email"
                            },
                            {
                                id: 1,
                                name: "i18n.customer.mail"
                            }
                        ]

                    }
                },
                {
                    type: "separator",
                    label: "i18n.customer.deliveryaddress"
                },
                {
                    type: "text",
                    name: "delivery_institution",
                    label: "i18n.customer.institution"
                },
                {
                    type: "text",
                    name: "delivery_building_floor",
                    label: "i18n.customer.buildingfloor"
                },
                {
                    type: "text",
                    name: "delivery_service",
                    label: "i18n.customer.service"
                },
                {
                    type: "textarea",
                    name: "delivery_address",
                    label: "i18n.customer.address"
                },
                {
                    type: "text",
                    name: "delivery_zip_code",
                    label: "i18n.customer.zipcode"
                },
                {
                    type: "text",
                    name: "delivery_city",
                    label: "i18n.customer.city"
                },
                {
                    type: "text",
                    name: "delivery_country",
                    label: "i18n.customer.country"
                },
                {
                    type: "separator",
                    label: "i18n.customer.invoiceaddress"
                },
                {
                    type: "text",
                    name: "invoice_institution",
                    label: "i18n.customer.institution"
                },
                {
                    type: "text",
                    name: "invoice_building_floor",
                    label: "i18n.customer.buildingfloor"
                },
                {
                    type: "text",
                    name: "invoice_service",
                    label: "i18n.customer.service"
                },
                {
                    type: "textarea",
                    name: "invoice_address",
                    label: "i18n.customer.address"
                },
                {
                    type: "text",
                    name: "invoice_zip_code",
                    label: "i18n.customer.zipcode"
                },
                {
                    type: "text",
                    name: "invoice_city",
                    label: "i18n.customer.city"
                },
                {
                    type: "text",
                    name: "invoice_country",
                    label: "i18n.customer.country"
                },


            ],
        }
    });

    function customercustomersuserseditor(id_customer) {

        $(this).authAjax({
            url: mumuxconfig.apiurl + "spaces/" + id_space + "/customers/" + id_customer,
            type: 'GET',
            data: '',
            success: function (result)
            {
                $('#lf-customercustomers-users-tbale-div').mumuxTableEditor(
                    {
                        messageareaid: "lf-space-message-div",
                        authAjax: true,
                        id: "space-customers-users-table",
                        api: {
                            url_getall: mumuxconfig.apiurl + "spaces/" + id_space + "/customers/" + id_customer + "/users",
                            url_getone: mumuxconfig.apiurl + "spaces/" + id_space + "/customers/" + id_customer + "/users/",
                            url_deleteone: mumuxconfig.apiurl + "spaces/" + id_space + "/customers/" + id_customer + "/users/",
                            url_addone: mumuxconfig.apiurl + "spaces/" + id_space + "/customers/" + id_customer + "/users",
                            url_updateone: mumuxconfig.apiurl + "spaces/" + id_space + "/customers/" + id_customer + "/users/",
                        },
                        messages: {
                            editsuccess: "i18n.customer.savedcustomer",
                            deletesuccess: "i18n.customer.deletedcustomer",
                            addsuccess: "i18n.customer.addedcustomer"
                        },
                        table: {
                            title: "i18n.customer.users" + ": " + result.name,
                            header: [
                                {
                                    name: "name",
                                    label: "i18n.customer.name",
                                },
                                {
                                    name: "firstname",
                                    label: "i18n.customer.firstname",
                                },
                            ]
                        },
                        form: {
                            title: "i18n.customer.user",
                            widgets: [
                                {
                                    type: "hidden",
                                    name: "id",
                                },
                                {
                                    type: "hidden",
                                    name: "id_customer",
                                },
                                {
                                    type: "select",
                                    name: "id_user",
                                    label: "i18n.space.users",
                                    options: {
                                        origin: "ajax",
                                        url: mumuxconfig.apiurl + "members",
                                        value: "id",
                                        name: "fullname"
                                    }
                                }
                            ]
                        }
                    }
                );
            },
        });
    }

    $('#lf-customercustomers-backtocustomers-button').click(function(){
        $('#lf-customercustomers-users-div').hide();
        $('#lf-customercustomers-customers-div').show();
    });

});