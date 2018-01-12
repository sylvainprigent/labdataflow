$(document).ready(function(){

    $("#lf-spaceconfig-div").mumuxTable({
        title: "i18n.space.availabletools",
        tableId: "space-tools-table",
        authAjax: true,
        buttons: [
            {
                name: "edit",
                label: "Edit",
                widget: "btn-primary",
                action: function(id){
                   window.location.href = mumuxconfig.clienturl + id + "/" + mumuxGetUrlParameters()[1];
                }
            },
        ],
        header: [
            {
                name: "name",
                label: "i18n.space.name",
            },
            {
                name: "description",
                label: "i18n.space.description",
            }
        ],
        data: {
            origin: "ajax",
            url: mumuxconfig.apiurl + "availabletools"   
        },
    });

});