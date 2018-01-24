$(document).ready(function(){

    $('#lf-breeding-div').mumuxSidebar({
        title: "i18n.breeding.breeding",
        items:[
            {
                id: "lf-breeding-newbatch-component-div",
                label: "i18n.breeding.newbatch"
            },
            {
                id: "lf-breeding-openedbatches-component-div",
                label: "i18n.breeding.openbatches",
                callback: showBreedingOpendBatches()
            },
            {
                id: "lf-breeding-closedbatches-component-div",
                label: "i18n.breeding.closebatches",
                callback: showBreedingClosedBatches()
            },
            {
                id: "lf-breeding-product-component-div",
                label: "i18n.breeding.products",
                callback: showBreedingProducts()
            },
            {
                id: "lf-breeding-category-component-div",
                label: "i18n.breeding.categories",
                callback: showBreedingCategories()
            },
            {
                id: "lf-breeding-losstype-component-div",
                label: "i18n.breeding.losstypes",
                callback: showBreedingLossTypes()
            },
            {
                id: "lf-breeding-batch-edit-component-div",
                hidden: true
            }
        ]
    });

});