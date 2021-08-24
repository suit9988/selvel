function MatchHeight1() {

    $(".match").matchHeight({})

}

$(document).ready(function() {

    $.cookie("preloader") ? ($("#loader-wrapper").hide(),

    $(".wrapper").show()) : ($(window).on("load", function() {

        $("#loader-wrapper").fadeOut(1e3)

    }),

    $(".wrapper").show(),

    $.cookie("preloader", !0, {

        path: "/",

        expire: 1

    }))

}),

$(document).ready(function() {

    MatchHeight1()

}),

$(document).resize(function() {

    MatchHeight1()

}),

$(window).scroll(function() {

    $(window).scrollTop() >= 150 ? $("header").addClass("sticky") : $("header").removeClass("sticky")

}),

$(".banner-home").slick({

    slidesToShow: 1,

    slidesToScroll: 1,

    autoplay: !0,

    autoplaySpeed: 2e3,

    speed: 200,

    dots: !0,

    arrows: !1,

    infinite: !0,

    fade: !0,

    cssEase: "linear",

    responsive: [{

        breakpoint: 550,

        settings: {

            slidesToShow: 1,

            slidesToScroll: 1,

            cssEase: "ease",

            dots: !1,

        }

    }]

}),

$(".slider-reviews").slick({

  dots: true,
  infinite: true,
  autoplay: true,
  autoplaySpeed: 6000,
  speed: 800,
  slidesToShow: 3,
	cssEase: "linear",
	 responsive: [{

        breakpoint: 550,

        settings: {

            slidesToShow: 1,

            slidesToScroll: 1,

            cssEase: "ease",

            dots: !1,

        }

    }]
}),

$(".slider-reviews-nav").slick({

    slidesToShow: 1,

    slidesToScroll: 1,

    fade: !0,

    arrows: !1,

    dots: !1,

    asNavFor: ".slider-reviews"

}),

$("#gallery_01").not(".slick-initialized").slick({

    vertical: !0,

    infinite: !1,

    slidesToShow: 4,

    slidesToScroll: 1,

    verticalSwiping: !0,

    autoplay: !1,

    autoplaySpeed: 2e3,

    dots: !1,

    arrows: !0,

    responsive: [{

        breakpoint: 1e3,

        settings: {

            slidesToShow: 4,

            slidesToScroll: 1,

            vertical: !1,

            verticalSwiping: !1,

            arrows: !0,

            dots: !1

        },

        breakpoint: 600,

        settings: {

            slidesToShow: 3,

            slidesToScroll: 1,

            vertical: !1,

            verticalSwiping: !1,

            arrows: !0,

            dots: !1

        }

    }]

}),

$(".fp-btn").click(function() {

    $(".page-heading").text("Forgot Password"),

    $(".login-box").addClass("switch-form")

}),

$(".back-btn").click(function() {

    $(".page-heading").text("Login"),

    $(".login-box").removeClass("switch-form"),

    $(".hideOnback").hide()

}),

$(".passwordtoggle").click(function() {

    $(this).toggleClass("fa-eye-slash"),

    "text" == $(".password-show").attr("type") ? $(".password-show").attr("type", "password") : $(".password-show").attr("type", "text")

}),

$(".passwordtoggles").click(function() {

    $(this).toggleClass("fa-eye-slash"),

    "text" == $(".password-shows").attr("type") ? $(".password-shows").attr("type", "password") : $(".password-shows").attr("type", "text")

}),

/*$("#open-register").click(function() {

    $("#login-page").slideToggle(),

    $("#register-page").slideToggle()

}),

$("#open-login-here").click(function() {

    $("#login-page").slideToggle(),

    $("#register-page").slideToggle()

}),*/

 /*$(document).ready(function() {

    $(".clickmenu").click(function() {

        $(this).parent().find(".dropdon-click").slideToggle(),

        $(this).toggleClass("rotate")

    })

   $(".togglemenus").click(function() {

        $(".menu-section").toggleClass("slide")

    })

}),*/

$("#slide-simmi1").length > 4 && $("#slider-simmi").slick({

    slidesToShow: 4,

    slidesToScroll: 1,

    autoplay: !0,

    infinite: !1,

    autoplaySpeed: 2e3,

    responsive: [{

        breakpoint: 991,

        settings: {

            slidesToShow: 2,

            slidesToScroll: 1

        }

    }, {

        breakpoint: 600,

        settings: {

            slidesToShow: 1,

            slidesToScroll: 1,

            infinite: !0

        }

    }]

});

var m = $(window).width();

m < 767 && (/*$(".flex-propers").slick({

    slidesToShow: 2,

    slidesToScroll: 3,

    autoplay: !0,

    autoplaySpeed: 2e3,

    speed: 1500,

    dots: !1,

    arrows: !0,

    infinite: !1,

    responsive: [{

        breakpoint: 600,

        settings: {

            slidesToShow: 1,

            slidesToScroll: 1,

            cssEase: "ease"

        }

    }]

}),*/

$(".flex-expo").slick({

    slidesToShow: 1,

    slidesToScroll: 1,

    autoplay: !0,

    autoplaySpeed: 2e3,

    speed: 1500,

    dots: !1,

    arrows: !0,

    infinite: !1,

    responsive: [{

        breakpoint: 600,

        settings: {

            arrows: !1

        }

    }]

}),

$(".Sort-By-filter").click(function() {

    $(".filter-boxs").toggleClass("up");

    $('.sortinform').removeClass('slide');

    $(this).find('.fa-minus').toggleClass('hide');

    $(this).find('.fa-plus').toggleClass('hide1');

    $(".Sort-By").find('.fa-plus').removeClass('hide1');

    $(".Sort-By").find('.fa-minus').addClass('hide');



}),

$(".Sort-By").click(function() {

    $(".filter-boxs").removeClass("up");

    $('.sortinform').toggleClass('slide');

    $(this).find('.fa-minus').toggleClass('hide');

    $(this).find('.fa-plus').toggleClass('hide1');

    $(".Sort-By-filter").find('.fa-plus').removeClass('hide1');

    $(".Sort-By-filter").find('.fa-minus').addClass('hide');

}));







var n = $(window).width();

n < 600 && ($("#slider-simmi").slick({

    slidesToShow: 2,

    slidesToScroll: 2,

    autoplay: !0,

    infinite: !1,

    autoplaySpeed: 2e3

}),

$("#myacnav").slick({

    slidesToShow: 2,

    slidesToScroll: 1,

    arrows: !0,

    infinite: !0

}),

$("#myordernav").slick({

    slidesToShow: 2,

    slidesToScroll: 1,

    arrows: !0,

    initialSlide: 1,

    infinite: !0

}),

$("#mywishnav").slick({

    slidesToShow: 2,

    slidesToScroll: 1,

    arrows: !0,

    initialSlide: 2,

    infinite: !0

}),

$("#myaddnav").slick({

    slidesToShow: 2,

    slidesToScroll: 1,

    arrows: !0,

    initialSlide: 3,

    infinite: !0

}),

$(".timeline-hoisto-lines").slick({

    slidesToShow: 1,

    slidesToScroll: 1,

    autoplay: !0,

    autoplaySpeed: 2e3,

    speed: 1500,

    dots: !1,

    arrows: !1,

    infinite: !1,

    adaptiveHeight: !0

}));





var cv = $(window).width();

    if (cv < 600) {

        $('.catclick').click(function(){

            $(this).parent().find('.formobilebox').slideToggle();

            $(this).toggleClass('ro');

        });



        $(document).ready(function(){

            $('.scrollbarhai').mCustomScrollbar('destroy');

        });



        /*$('.togglemenus').on("click", function(event)

            {

                $('.menu-section').toggleClass('slide');

                $('.bgpatchphone').toggleClass('slide');

                event.stopPropagation();

            });



            $('.menu-section').on("click", function(event)

            {

                event.stopPropagation();

            });



            $(document).on("click", function(event)

            {

                $('.menu-section').removeClass("slide");

                $('.bgpatchphone').removeClass('slide');

            });*/



            $('.togglemenus').click(function(){

                $('.menu-section').toggleClass('slide');

                $('.bgpatchphone').toggleClass('slide');

            });



            $('.bgpatchphone').click(function(){

                $('.menu-section').removeClass('slide');

                $(this).removeClass('slide');

            });







        $('.mainclickicon').click(function(){

            $('.mobilesearch').slideToggle();

        });



/*        (function($){

          $(window).on("load",function(){

            $(".cart-table-responsive").mCustomScrollbar({

              axis:"x",

              theme:"dark-3"

            });

          });

        })(jQuery);*/



        $(document).ready(function() {

            $(".clickmainmenu").click(function() {

                $(this).parent().find(".dropdon-click").slideToggle();

                $(this).parent().find('.clickmenu').toggleClass("rotate");

            })

        });

       

    }  



$(".Sort-By-filter").click(function() {

    if ($(this).find('#chtext').text() == "Filter By")

       $(this).find('#chtext').text("Apply")

    else

       $(this).find('#chtext').text("Filter By");

});



/*$(".Sort-By-filter").click(function() {

    $(this).find('.fa').toggleClass('fa fa-plus').toggleClass('fa fa-minus');

})*/



$('.newserchflex .fa').on("click", function(event)

{

    $('.searchboxpositionbox').slideToggle();

});



$('.clicklabel').click(function() {

    $('.sortinform').removeClass('slide');

    $('.Sort-By').find('.fa-minus').toggleClass('hide');

    $('.Sort-By').find('.fa-plus').toggleClass('hide1');

});