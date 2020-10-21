$("document").ready (function() {
    $("#ha_header .ha-mobile-menu").click(function() {
        $("#ha_header .ha-menu-list").stop().slideToggle( "slow" );
    });

});