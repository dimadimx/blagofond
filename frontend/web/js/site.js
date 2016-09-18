$(document).ready(function(){
    $(".currentLang").click(function(){
        $(this).next("div").slideToggle(150);
    });
    
    $(".langs span").click(function(){
        $(".currentLang").html($(this).html()).attr("data-lang",$(this).attr("data-lang"));
        $(".langs").slideUp(150);
    });
    
    $(".fixedButtons > a").click(function(){
        $(".fixedButtonsContent > div").eq($(this).index()).animate({
            "top":"0"
        },150);
        return false;
    });
    
    $(".closeFixed").click(function(){
        $(".fixedButtonsContent > div").animate({
            "top":"100%"
        },150);
    });
    
    if($("#slider").length > 0){
        $("#slider > div").eq(0).animate({
            "left":"0"
        },650,function(){
            $("#slider > div").eq(0).addClass("current");
        });
        setInterval(function(){
            var ind = $("#slider div.current").index();
            var nextInd = ind+1;
            if(nextInd >= $("#slider > div").length) nextInd = 0;
            
            $("#slider > div").eq(ind).animate({
                "left":"-100%"
            },650,function(){
                $("#slider > div").removeClass("current");
                $("#slider > div").eq(ind).css('left',"100%");
            });
            
            $("#slider > div").eq(nextInd).animate({
                "left":"0"
            },650,function(){$("#slider > div").eq(nextInd).addClass("current")});
        },4500);
    }
    
    function thm(){
        var thumbsWidth = 0;
        $("#thumbnails > div > div").each(function(){
            thumbsWidth += parseInt($(this).outerWidth(true));
        });
        
        $("#thumbnails > div").css("width",thumbsWidth);
        
        if($("#thumbnails img").length > 4){
            if($("prevThumbs").length < 1){
                $("#thumbnails").append("<a id='prevThumbs' />");
                $("#thumbnails").append("<a id='nextThumbs' />");
                $("#thumbnails").addClass("arrows");
            }
        }
        
        $("#thumbnails img").click(function(){
            var me = $(this);
            $("#bigPic img").animate({"opacity":"0"},150,function(){
               $("#bigPic img").attr("src",me.attr("src"));
               $("#bigPic img").animate({"opacity":"1"},250); 
            });
        });
        
        $("#prevThumbs").click(function(){
            var step = $("#thumbnails > div > div").outerWidth(true);
            if(parseInt($("#thumbnails > div").css("left")) < 0){
                $("#thumbnails > div").animate({"left":"+="+step});
            }
            return false;
        });
        $("#nextThumbs").click(function(){
            var width = parseInt($("#thumbnails").outerWidth(true));
            var limit = thumbsWidth - width;
            //alert(limit*-1);
            var step = $("#thumbnails > div > div").outerWidth(true);
            
            if(parseInt($("#thumbnails > div").css("left")) > limit*-1){
                $("#thumbnails > div").animate({"left":"-="+step});
            }
            return false;
        });
    }
    if($("#thumbnails").length > 0){
        thm();
        
        $(window).resize(function(){
            thm();
        });
    }
});