$(document).ready( ()=>{
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

    let $formStars = $("form .rating ");
    $formStars.find(".star").hover(function () {
        let $this = $(this),
            $form = $this.closest("form"),
            $input = $form.find(`input[name=rating]`),
            $parent = $this.parent(),
            index = $this.index();
        $input.val(index+1);
        for (let i = 0;i<=index;i++){
            $parent.find(".star").eq(i).removeClass("empty");
        }
        for (let i=index+1;i<=5;i++){
            $parent.find(".star").eq(i).addClass("empty");
        }
    });
});

