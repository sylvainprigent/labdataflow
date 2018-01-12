$('document').ready( function(){

    $('#lf-home-bar-news-a').click(function(e){
        e.preventDefault();
        window.location.href = "home";
    });

    $('#lf-home-bar-messenger-a').click(function(e){
        e.preventDefault();
        window.location.href = "messenger";
    });

    $('#lf-home-bar-member-a').click(function(e){
        e.preventDefault();
        window.location.href = "member";
    });

    $('#lf-home-bar-spaces-a').click(function(e){
        e.preventDefault();
        window.location.href = "spaces";
    });


});