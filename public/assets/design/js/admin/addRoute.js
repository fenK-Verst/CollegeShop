let $addRouteBtn = $(".addRoute.btn"),
    $modal = $(`#modal`),
    $modalTitle = $modal.find(".modal-title"),
    $modalBody = $modal.find(".modal-body"),
    $preloader = $modal.find(".preloader"),
    url = window.location.protocol + `//` + window.location.host + `/api/templates`;
$addRouteBtn.click(async function () {
    $preloader.show();
    let $this = $(this),
        parentId = $this.data("parent-id"),
        menuId = $this.data("menu-id");

    console.log($this, menuId, parentId);
    if (menuId) {
        $modalBody.find(" > :not(.preloader)").remove();
        $modal.modal("show");

        let response = await fetch(url + `/get`);
        response = await response.json();
        if (!response.error) {
            $preloader.hide();
            let templates = response.data || [],
                $wrapper = $(`<div class="templates-wrapper" />`);
            $.each(templates, (i, template) => {
                console.log(template);
                let $template = $(`<div class="template"><span>${template.name}</span></div>`);
                $template.click(() => {
                    $modalTitle.text(template.name);
                    let $form = $(`<form class="form"></form>`),
                        $page_name = $(`
                                <div class="form-group">
                                    <label for="route[name]">Название </label>
                                    <input type="text" class="form-control" name="route[name]" id="route[name]">
                                </div>
                        `);
                    $page_name.appendTo($form);
                    let vars = JSON.parse(template.vars);
                    $.each(vars, (i, elem) => {
                        let $varWrapper =  $(`
                                <div class="form-group">
                                    <label for="route[${i}]">${elem.title} </label>
                                </div>
                        `);
                        let $input = $(`<input />`);

                        switch (elem.type) {
                            case "html":
                                $input = $(`<textarea name="route[${i}]" id="route[${i}]"/>`);
                                break;
                        }
                        $input.appendTo($varWrapper);
                        $input.addClass("form-control");
                        $varWrapper.appendTo($form);
                    });


                    $modalBody.find(" > :not(.preloader)").remove();
                    $form.appendTo($modalBody);
                });
                $template.appendTo($wrapper);
            });
            $wrapper.appendTo($modalBody);
        }
    }
});