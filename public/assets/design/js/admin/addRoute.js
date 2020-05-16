
const request = async (url, params = [], method = 'GET') => {
    return new Promise(((resolve, reject) => {
        url = new URL(url);
        if (method.toLocaleUpperCase() === 'GET') url.search = new URLSearchParams(params).toString();
        let fetchParams = {
            method: method,
        };

        if (method.toLocaleUpperCase() === 'POST') {

            function getFormData(object) {
                const formData = new FormData();
                for (const key in object) {
                    formData.append(key, object[key]);
                }
                return formData;
            }

            fetchParams['body'] = getFormData(params);
        }
        fetch(url, fetchParams).then((response) => {
            if (response.status >= 500) {
                let err = 'Внутренная ошибка. Обратитесь к руководителю ' +
                    Date.now();
                this.notify.show(err, 'error');
                reject(err);
            } else if (response.status == 404) {
                reject('Страница не найдена ' + Date.now());
            } else {
                resolve(response.json());
            }
        }).catch((e) => {
            reject(e);
        });

    }));
}
const $addRouteBtn = $(".addRoute.btn"),
    $modal = $(`#modal`),
    $modalTitle = $modal.find(".modal-title"),
    $modalBody = $modal.find(".modal-body"),
    $preloader = $modal.find(".preloader"),
    $alert = $modal.find(".alert");
url = window.location.protocol + `//` + window.location.host + `/api`;
const updateEvents = ($form) =>{
    $form.find(`.btn[data-type="image"]`).unbind();
    $form.find(`.btn[data-type="menu"]`).unbind();
    $form.find(`.btn[data-type="text"]`).unbind();
    $form.find(`.btn[data-action="remove"]`).unbind();
    $form.find(`.btn[data-type="image"]`).click(async function () {
        let $this = $(this),
            action = $this.data("action"),
            name = $this.data("name"),
            isMultiply = $this.data("multiply");
        switch (action) {
            case "add":
                let $modalClone = $modal.clone(false);
                $modalClone.find(".modal-body").find("> :not(.preloader)").remove();
                $modalClone.find(".preloader").show();
                $modalClone.find(".modal-title").text("Фотографии");
                $modalClone.modal("show");
                let response = await request(url + "/image");
                if (!response.error) {
                    let $wrapper = $(`<div class="images"/>`);
                    $.each(response.data, (key, image) => {
                        let $imageWrapper = $(`<div class="image"/>`),
                            $image = $(`<img/>`),
                            $alias = $(`<span />`)
                        $imageWrapper.click(() => {
                            if (action == "add") {
                                let $image_item = $(`
                                                   <div class="image-item item">
                                                        <img src="${image.path}" width="30px" height="30px"
                                                             alt=""><span class="name">${image.alias}</span>
                                                        <input type="hidden" name="${name}" value="${image.id}">
                                                        <span class="btn btn-sm btn-danger" data-action="remove" ><i class="fa fa-minus"></i></span>
                                                   </div>`);
                                if (isMultiply) {
                                    $image_item.appendTo($this.siblings(".images"));
                                } else {
                                    $this.siblings(".image-item").remove();
                                    $this.after($image_item);
                                }
                                updateEvents($form);
                            }
                            $modalClone.modal("hide");
                        });
                        $image.attr("src", image.path);
                        $alias.text(image.alias);
                        $image.appendTo($imageWrapper);
                        $alias.appendTo($imageWrapper);

                        $imageWrapper.appendTo($wrapper);
                    });
                    $modalClone.find(".preloader").hide();
                    $wrapper.appendTo($modalClone.find(".modal-body"));

                } else {
                    $alert.addClass("alert-danger");
                    $alert.text(response.error_msg);
                    $alert.show();
                    $preloader.hide();
                }

                break;
        }

    })
    $form.find(`.btn[data-type="menu"]`).click(async function () {
        let $this = $(this),
            action = $this.data("action"),
            name = $this.data("name"),
            isMultiply = $this.data("multiply");
       if (action === "add") {
                let $modalClone = $modal.clone(false);
                $modalClone.find(".modal-body").find("> :not(.preloader)").remove();
                $modalClone.find(".preloader").show();
                $modalClone.find(".modal-title").text("Меню");
                $modalClone.modal("show");
                let response = await request(url + "/menu");
                if (!response.error) {
                    let $wrapper = $(`<div class="menus"/>`);
                    $.each(response.data, (key, menu) => {
                        let $menuWrapper = $(`<div class="menu"/>`),
                            $alias = $(`<span />`);
                        $menuWrapper.click(() => {
                                let $menu_item = $(`
                                                   <div class="menu-item item">
                                                        <span class="name">${menu.name}</span>
                                                        <input type="hidden" name="${name}" value="${menu.id}">
                                                        <span class="btn btn-sm btn-danger" data-action="remove" ><i class="fa fa-minus"></i></span>
                                                   </div>`);
                                if (isMultiply) {
                                    $menu_item.appendTo($this.siblings(".menus"));
                                } else {
                                    $this.siblings(".menu-item").remove();
                                    $this.after($menu_item);
                                }
                                updateEvents($form);

                            $modalClone.modal("hide");
                        });
                        $alias.text(menu.name);
                        $alias.appendTo($menuWrapper);

                        $menuWrapper.appendTo($wrapper);
                    });
                    $modalClone.find(".preloader").hide();
                    $wrapper.appendTo($modalClone.find(".modal-body"));

                } else {
                    $alert.addClass("alert-danger");
                    $alert.text(response.error_msg);
                    $alert.show();
                    $preloader.hide();
                }

       }

    })
    $form.find(`.btn[data-type="text"]`).click(async function () {
        const $this = $(this),
            action = $this.data("action") || '',
            isMultiply = $this.data("multiply") || false,
            name = $this.data("name") || '';
        if (action === "add" && isMultiply) {
            const $text_item = $(`
                        <div class="text-item item">
                            <input type="text" class="form-control" name="${name}">
                            <span class="btn btn-sm btn-danger" data-action="remove"><i class="fa fa-minus"></i></span>
                        </div>`);
            $text_item.appendTo($this.siblings(".texts"));
            updateEvents($form);
        }
    });
    $form.find(`.btn[data-action="remove"]`).click(async function () {
        let $this = $(this);
        $this.parent().remove();
    });
}

$addRouteBtn.click(async function () {
    $preloader.show();
    $alert.hide();
    let $this = $(this),
        parentId = $this.data("parent-id"),
        menuId = $this.data("menu-id");
    if (menuId) {
        $modalBody.find(" > :not(.preloader)").remove();
        $modal.modal("show");
        let response = await request(url + `/template/get`);

        if (!response.error) {
            $preloader.hide();

            let templates = response.data.templates || [],
                $wrapper = $(`<div class="templates-wrapper" />`);

            $.each(templates, (i, template) => {
                let $template = $(`<div class="template"><span>${template.name}</span></div>`);

                $template.click(async () => {
                    $modalTitle.text(template.name);
                    $modalBody.find(" > :not(.preloader)").remove();
                    $preloader.show();
                    let response = await request(url + `/template/${template.id}/get/form`, {
                        parent_id: parentId
                    });
                    if (!response.error) {
                        let $form = $(response.data.form);
                        $preloader.hide();
                        $alert.hide();
                        $form.appendTo($modalBody);
                        $form.find('div[data-type="html"]').trumbowyg();

                        updateEvents($form);

                        $form.submit(async (e) => {
                            e.preventDefault();
                            e.stopPropagation();
                            let params = {};

                            $form.find(`div[data-type="html"]`).each(function () {
                                params[$(this).attr("name")] = $(this).html()
                            })
                            params[`route[menu_id]`] = menuId;
                            if (parentId) params[`route[parent_id]`] = parentId;
                            let out = [];

                            for (var key in params) {
                                if (params.hasOwnProperty(key)) {
                                    out.push(key + '=' + encodeURIComponent(params[key]));
                                }
                            }
                            out.join('&');
                            let request_url = `${url}/route/create?${$form.serialize()}&${ out.join('&')}`;
                            let response = await fetch(request_url);

                            response = await response.json();
                            console.log(response);
                            if (!response.error) {
                                location.reload();
                            } else {
                                $alert.addClass("alert-danger");
                                $alert.text(response.error_msg);
                                $alert.show();
                                $preloader.hide();
                            }
                        });
                    } else {
                        $alert.addClass("alert-danger");
                        $alert.text(response.error_msg);
                        $alert.show();
                        $preloader.hide();
                    }

                });
                $template.appendTo($wrapper);
            });
            $wrapper.appendTo($modalBody);
        } else {
            $alert.addClass("alert-danger");
            $alert.text(response.error_msg);
            $alert.show();
            $preloader.hide();
        }
    }
});
$(".editRoute").click(async function () {
    $preloader.show();
    $alert.hide();
    let $this = $(this),
        id = $this.data("id"),
        template_id = $this.data("template-id");
    if (id && template_id) {
        $modalBody.find(" > :not(.preloader)").remove();
        $modal.modal("show");
        $modalTitle.text($this.closest(".btn-group").prev().text());
        $modalBody.find(" > :not(.preloader)").remove();
        $preloader.show();
        let response = await request(url + `/template/${template_id}/get/form`, {
            route_id: id
        });
        if (!response.error) {
            let $form = $(response.data.form);
            $preloader.hide();
            $alert.hide();
            $form.appendTo($modalBody);
            $form.find('div[data-type="html"]').trumbowyg();
            updateEvents($form);

            $form.submit(async (e) => {
                e.preventDefault();
                e.stopPropagation();

                let params = {};
                $form.find(`div[data-type="html"]`).each(function () {
                    params[$(this).attr("name")] = $(this).html()
                });
                let out = [];

                for (var key in params) {
                    if (params.hasOwnProperty(key)) {
                        out.push(key + '=' + encodeURIComponent(params[key]));
                    }
                }
                out.join('&');
                let request_url = `${url}/route/${id}/edit?${$form.serialize()}&${ out.join('&')}`;
                let response = await fetch(request_url);

                response = await response.json();
                if (!response.error) {
                    location.reload();
                } else {
                    $alert.addClass("alert-danger");
                    $alert.text(response.error_msg);
                    $alert.show();
                    $preloader.hide();
                }
            });
        } else {
            $alert.addClass("alert-danger");
            $alert.text(response.error_msg);
            $alert.show();
            $preloader.hide();
        }
    }
})

const $settingsForm = $(`#site_settings`);
if ($settingsForm.length) updateEvents($settingsForm);