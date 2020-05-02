$(document).ready(() => {
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

        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 4
                }
            },
            {
                breakpoint: 900,
                settings: {
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 640,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1
                }
            }
        ]

    });

    let $formStars = $("form .rating ");
    $formStars.find(".star").hover(function () {
        let $this = $(this),
            $form = $this.closest("form"),
            $input = $form.find(`input[name=rating]`),
            $parent = $this.parent(),
            index = $this.index();
        $input.val(index + 1);
        for (let i = 0; i <= index; i++) {
            $parent.find(".star").eq(i).removeClass("empty");
        }
        for (let i = index + 1; i <= 5; i++) {
            $parent.find(".star").eq(i).addClass("empty");
        }
    });
});
let $product = $(".product[data-id]");
$product.find(".buy_button").click(async function () {
    let $this = $(this),
        product_id = $this.closest(".product").attr("data-id");
    console.log(product_id);
    let url = new URL(window.location.protocol + `//` + window.location.host + "/api/cart/add");
    url.searchParams.append("product_id", product_id);
    url.searchParams.append("count", 1);
    let response = await fetch(url);
    response = await response.json();
    let content = `<span>Товар успешно добавлен в <a href="/cart"> корзину</a></span>`;
    if (response.status != "OK") {

        content = "Произошла ошибка при добавлении. попробуйте позже";
    }
    let $popover = $(`#popover`);
    $popover.html(content);
    $popover.addClass("active");
    $popover.offset($this.offset());
    setInterval(()=>{
        $popover.removeClass("active")
    },3000);

});
console.log($product);
