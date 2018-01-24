$(document).ready(function(){

    $('#lf-customer-div').mumuxSidebar({
        title: "i18n.customer.customer",
        items:[
            {
                id: "lf-customer-customer-div",
                label: "i18n.customer.customers"
            },
            {
                id: "lf-customer-pricing-div",
                label: "i18n.customer.pricing"
            },
            {
                id: "lf-customer-companyinfo-div",
                label: "i18n.customer.companyinfo"
            }
        ]
    });

});