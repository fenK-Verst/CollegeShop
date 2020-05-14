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
$addRouteBtn.click(async function () {
    $preloader.show();
    $alert.hide();
    let $this = $(this),
        parentId = $this.data("parent-id"),
        menuId = $this.data("menu-id");
    if (menuId) {
        $modalBody.find(" > :not(.preloader)").remove();
        $modal.modal("show");
        console.log(menuId);
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
                    let response = await request(url + `/template/${template.id}/get/form`);
                    if (!response.error) {
                        let $form = $(response.data.form);
                        $preloader.hide();
                        $alert.hide();
                        $form.appendTo($modalBody);
                        $form.submit(async (e)=>{
                            e.preventDefault();
                            e.stopPropagation();
                            console.log(e);
                            let params = {};

                            $form.find('input, textarea, select').each(function () {
                                params[this.name] = $(this).val();
                            });
                            params[`route[menu_id]`] = menuId;
                            let response = await request(`${url}/route/create`, params, "POST");
                            console.log(response);
                            if(!response.error){
                                location.reload();
                            }else{
                                $alert.addClass("alert-danger");
                                $alert.text(response.error_msg);
                                $alert.show();
                                $preloader.hide();
                            }
                        });
                    }else{
                        $alert.addClass("alert-danger");
                        $alert.text(response.error_msg);
                        $alert.show();
                        $preloader.hide();
                    }

                });

                $template.appendTo($wrapper);
            });
            $wrapper.appendTo($modalBody);
        }else{
            $alert.addClass("alert-danger");
            $alert.text(response.error_msg);
            $alert.show();
            $preloader.hide();
        }
    }
});