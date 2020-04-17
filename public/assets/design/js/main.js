let $mainSlider = $("main .main_slider"),
    $newsSlider = $("main .news_slider");
$mainSlider.slick({
                      dots: true,
                      arrows: false,
                  });
$newsSlider.slick({
                      infinite: true,
                      dots: false,
                      arrows: true,
                      slidesToShow: 5,
                      slidesToScroll: 1,
                  });
$newsSlider.find(".product_wrapper").on("mouseenter", function (e) {
   $(this).find(".product_hide").css({
       // bottom:-$(this).height()
                                     })
});