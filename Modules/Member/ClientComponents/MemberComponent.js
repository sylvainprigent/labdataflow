$(document).ready(function () {

    // set admin options
    if ( window.sessionStorage.getItem('userstatus') > 1){
        $('#member-navbar-item-ul').append(
            '<li id="lf-member-navbar-admin-li" class="nav-item"><a id="lf-member-navbar-admin-a" class="nav-link" href="#">i18n.member.add</a></li>'
        );
    }

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

        // call ajax for view
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