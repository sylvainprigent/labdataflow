function breedingEditBatch(id_space, id_batch){

    // set summary table data
    breedingEditBatchHeader(id_space, id_batch);

    // set batch edit navfor link info
    $("#breeding-batch-edit-informations-a").data("batch", id_batch);
    $("#breeding-batch-edit-informations-a").data("space", id_space);
    $("#breeding-batch-edit-moves-a").data("batch", id_batch);
    $("#breeding-batch-edit-moves-a").data("space", id_space);
    $("#breeding-batch-edit-treatments-a").data("batch", id_batch);
    $("#breeding-batch-edit-treatments-a").data("space", id_space);
    $("#breeding-batch-edit-chipping-a").data("batch", id_batch);
    $("#breeding-batch-edit-chipping-a").data("space", id_space);
    $("#breeding-batch-edit-sexing-a").data("batch", id_batch);
    $("#breeding-batch-edit-sexing-a").data("space", id_space);
    
    // set the default page
    
    breedingEditBatchForm(id_space, id_batch);

}

function breedingEditBatchHeader(id_space, id_batch){

    $(document).authAjax({
        url: mumuxconfig.apiurl + "/spaces/" + id_space + "/breedingbatches/" + id_batch,
        type: 'GET',
        data: '',
        success: function (result)
        {
            //alert( "got result for header" + JSON.stringify(result) );
            $('#breeding-batch-edit-title').html(result.name);
            $('#breeding-batch-edit-quantity-td').html(result.quantity);
            $('#breeding-batch-edit-initialquantity-td').html(result.initial_quantity);
            if (result.quantity_losse){
                $('#breeding-batch-edit-loss-td').html(result.quantity_losse);
            }
            else{
                $('#breeding-batch-edit-loss-td').html("0");
            }
            if (result.quantity_sale){
                $('#breeding-batch-edit-sales-td').html(result.quantity_sale);
            }
            else{
                $('#breeding-batch-edit-sales-td').html("0");
            }

            if ( result.sexing_date != "" && result.sexing_date != "0000-00-00" ){
                $("#breeding-batch-edit-table").append(
                    '<tr><td>i18n.breeding.sexing</td><td><span>'+ result.sexing_date + ": " + result.sexing_female_num + ' i18n.breeding.females, ' + result.sexing_male_num + ' i18n.breeding.males' + '</span></td></tr>'
                );
            }
        }
    });

}

$(document).ready(function(){

    $('#breeding-batch-edit-informations-a').click(function(){

        $('#breeding-batch-edit-informations-a').addClass("active");
        $("#breeding-batch-edit-moves-a").removeClass("active");
        $("#breeding-batch-edit-treatments-a").removeClass("active");
        $("#breeding-batch-edit-chipping-a").removeClass("active");
        $("#breeding-batch-edit-sexing-a").removeClass("active");

        $('#breeding-informations-component-div').show();
        $('#breeding-moves-component-div').hide();
        $('#breeding-treatments-component-div').hide();
        $('#breeding-chipping-component-div').hide();
        $('#breeding-sexing-component-div').hide();

        breedingEditBatchForm($(this).data("batch"), $(this).data("space"));
    });

    $('#breeding-batch-edit-moves-a').click(function(){
        $('#breeding-informations-component-div').hide();
        $('#breeding-moves-component-div').show();
        $('#breeding-treatments-component-div').hide();
        $('#breeding-chipping-component-div').hide();
        $('#breeding-sexing-component-div').hide();

        $('#breeding-batch-edit-informations-a').removeClass("active");
        $("#breeding-batch-edit-moves-a").addClass("active");
        $("#breeding-batch-edit-treatments-a").removeClass("active");
        $("#breeding-batch-edit-chipping-a").removeClass("active");
        $("#breeding-batch-edit-sexing-a").removeClass("active");

        breedingEditBatchMoves($(this).data("batch"), $(this).data("space"));
    });

    $('#breeding-batch-edit-treatments-a').click(function(){
        $('#breeding-informations-component-div').hide();
        $('#breeding-moves-component-div').hide();
        $('#breeding-treatments-component-div').show();
        $('#breeding-chipping-component-div').hide();
        $('#breeding-sexing-component-div').hide();

        $('#breeding-batch-edit-informations-a').removeClass("active");
        $("#breeding-batch-edit-moves-a").removeClass("active");
        $("#breeding-batch-edit-treatments-a").addClass("active");
        $("#breeding-batch-edit-chipping-a").removeClass("active");
        $("#breeding-batch-edit-sexing-a").removeClass("active");
        
        breedingEditBatchTreatments($(this).data("batch"), $(this).data("space"));
    });

    $('#breeding-batch-edit-chipping-a').click(function(){
        $('#breeding-informations-component-div').hide();
        $('#breeding-moves-component-div').hide();
        $('#breeding-treatments-component-div').hide();
        $('#breeding-chipping-component-div').show();
        $('#breeding-sexing-component-div').hide();

        $('#breeding-batch-edit-informations-a').removeClass("active");
        $("#breeding-batch-edit-moves-a").removeClass("active");
        $("#breeding-batch-edit-treatments-a").removeClass("active");
        $("#breeding-batch-edit-chipping-a").addClass("active");
        $("#breeding-batch-edit-sexing-a").removeClass("active");

        breedingEditBatchChipping($(this).data("batch"), $(this).data("space"));
    });

    $('#breeding-batch-edit-sexing-a').click(function(){
        $('#breeding-informations-component-div').hide();
        $('#breeding-moves-component-div').hide();
        $('#breeding-treatments-component-div').hide();
        $('#breeding-chipping-component-div').hide();
        $('#breeding-sexing-component-div').show();

        $('#breeding-batch-edit-informations-a').removeClass("active");
        $("#breeding-batch-edit-moves-a").removeClass("active");
        $("#breeding-batch-edit-treatments-a").removeClass("active");
        $("#breeding-batch-edit-chipping-a").removeClass("active");
        $("#breeding-batch-edit-sexing-a").addClass("active");

        breedingEditBatchSexing($(this).data("batch"), $(this).data("space"));
    });

});