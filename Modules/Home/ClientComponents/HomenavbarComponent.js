$('document').ready( function(){

    $('#home-bar-members').click(function(){
        $("#home-component-news").hide();
        $("home-component-messenger").show();
        $("home-component-member").hide();
        $("home-component-space").hide();
        $("home-component-note").hide();
        $("home-component-calendar").hide();
    });

});