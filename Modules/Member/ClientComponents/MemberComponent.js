$(document).ready(function () {

    // show contacts by default
    $("#lf-member-contacts-div").show();
    $("#lf-member-list-div").hide();
    $("#lf-member-add-div").hide();

    $('#lf-member-navbar-contacts-a').click(function(e){

        e.preventDefault();

        $("#lf-member-contacts-div").show();
        $("#lf-member-navbar-contacts-li").addClass("active");

        $("#lf-member-list-div").hide();
        $("#lf-member-navbar-members-li").removeClass("active");
        
        $("#lf-member-add-div").hide();
        $("#lf-member-navbar-admin-li").removeClass("active");

        // call here ajax for view
    });

    $('#lf-member-navbar-members-a').click(function(e){

        e.preventDefault();

        $("#lf-member-contacts-div").hide();
        $("#lf-member-navbar-contacts-li").removeClass("active");

        $("#lf-member-list-div").show();
        $("#lf-member-navbar-members-li").addClass("active");
        
        $("#lf-member-add-div").hide();
        $("#lf-member-navbar-admin-li").removeClass("active");

        // call here ajax for view
    });

    $('#lf-member-navbar-admin-a').click(function(e){

        e.preventDefault();

        $("#lf-member-contacts-div").hide();
        $("#lf-member-navbar-contacts-li").removeClass("active");

        $("#lf-member-list-div").hide();
        $("#lf-member-navbar-members-li").removeClass("active");
        
        $("#lf-member-add-div").show();
        $("#lf-member-navbar-admin-li").addClass("active");

        // call here ajax for view
    });

});