let $choose = $("#chooseImage"),
    $modal = $("#modal"),
    $modalBody = $modal.find(".modal-body"),
    $preloader = $modal.find(".preloader"),
    $alert = $modal.find(".alert"),
    $input = $(` [name="product[image_id]"]`);
let url = window.location.protocol + `//` + window.location.host + `/api/image`;
console.log(url);
$modal.on('show.bs.modal', async function (event) {
    $preloader.show();
    $alert.hide();
    $modalBody.find(" > :not(.preloader)").remove();
    let response = await fetch(url);
    response = await response.json();
    if (!response.error) {
        let $wrapper = $(`<div class="images"/>`);
        $.each(response.data, (key, image) => {
            let $imageWrapper = $(`<div class="image"/>`),
                $image = $(`<img/>`),
                $alias = $(`<span />`);
            $imageWrapper.click(() => {
                $input.val(image.id);
                $(".image-name").text(image.alias);
                $modal.modal("hide");
            });
            $image.attr("src", image.path);
            $alias.text(image.alias);
            $image.appendTo($imageWrapper);
            $alias.appendTo($imageWrapper);

            $imageWrapper.appendTo($wrapper);
        });
        $preloader.hide();

        $wrapper.appendTo($modalBody);
    } else {
        $alert.text("Что то пошло не так. Попробуйте перезагрузить страницу");
        $alert.show();
        $preloader.hide();
    }

});