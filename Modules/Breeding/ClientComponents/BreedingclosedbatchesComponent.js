function showBreedingClosedBatches(){

    var id_space = mumuxGetUrlParameters()[1];

    $('#lf-breeding-closedbatches-div').mumuxTable({
        authAjax: true,
        class: "lf-form",
        title: "i18n.breeding.closedbatches",
        tableId: "breeding-closedbatches",
        buttons: [
            {
                name: "edit",
                label: "i18n.breeding.edit",
                widget: "btn-primary",
                action: function(id){
                    $('#lf-breeding-closedbatches-component-div').hide();
                    breedingEditBatch(id_space, id);
                }
            }
        ],
        header: [
            {
                name: "name",
                label: "i18n.breeding.name",
            },
            {
                name: "created_date",
                label: "i18n.breeding.createddate",
            }
        ],
        data: {
            origin: "ajax",
            url: mumuxconfig.apiurl + "/spaces/" + id_space + "/breedingbatchesclosed"    
        },
    });
    
}