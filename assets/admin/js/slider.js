var tabindex=1;
$(document).ready(function(){

    $(".slider-wrap").css({width : $(window).width()});

    var windowWidthInit = $(".slider-wrap").width(),
        slides = $(".slider .slide").length,
        circle="",
        move="";
    $(".slider-wrap").hover(function(){
        if (windowWidthInit>700) {
            $(".arrow").fadeToggle();
        }
    });
    $(".slide").css({"width": windowWidthInit});
    for (var i=1;i<slides+1;i++) {
        if (i===tabindex) {
            circle = "<li><span class='circle'></circle></li>";
        } else {
            circle = "<li></li>";
        }
        $(circle).appendTo(".slider-wrap ul").bind("click", function(){
            var oldtabindex = tabindex;
            var windowWidth = $(".slider-wrap").width();
            if ($(this).index()+1!=tabindex) {
                tabindex=$(this).index()+1;
                moveindex=tabindex-oldtabindex;
                move="-="+windowWidth*(moveindex);
                $(".slider").animate({left: move});
            }
            $(".circle").fadeOut().remove();
            $("<span class='circle'></span>").appendTo(this).hide().fadeIn("fast");
        });
    }
    $(".arrow").click(function(){
        var windowWidth = $(".slider-wrap").width();
        if ($(this).attr("id")==="right") {
            if (tabindex===slides) {
                tabindex=1
                move="+="+windowWidth*(slides-1);
            } else {
                tabindex=tabindex+1;
                move="-="+windowWidth;
            }
        } else {
            if (tabindex===1){
                tabindex=slides;
                move="-="+windowWidth*(slides-1);
            } else {
                tabindex=tabindex-1;
                 move="+="+windowWidth;
            }
        }
        $(".slider").animate({left: move});
        $(".circle").fadeOut().remove();
        $("<span class='circle'></span>").appendTo(".slider-wrap ul li:nth-child("+tabindex+")").hide().fadeIn();
    });
    var pushLeft = ($(".slider-wrap ul").width()/2);
});
$(window).resize(function(){
    $(".slider-wrap").css({width : $(window).width()});
    var windowWidth = $(".slider-wrap").width();
    $(".slide").css({"width": windowWidth});
});





