let $nodes = $(".folders li"),
    $form = $("#folder_form");

$form.find(".close").click(() => {
    $form.removeClass("active");
})
let $addBtn = $(`<span class="btn btn-xs btn-primary"><i class="fa fa-plus"></i></span>`),
    $deleteBtn = $(` <form action="/admin/folder/delete" method="post" class="btn btn-xs btn-danger" style="display: inline">
                                      <input type="hidden" value="" name="folder_id">
                                      <button style="padding: 0;margin: 0;background: none; border: none"><i class="fa fa-remove"></i></button>
                                  </form>`);
$addBtn.click(function () {
    let $this = $(this);
    $form.toggleClass("active");
    if ($form.hasClass("active")) {
        let $folder = $this.closest(".folder"),
            parent_id = $folder.attr("data-id"),
            $input = $form.find(`input[name="parent_id"]`);
        $input.val(parent_id);
        $form.attr("action", `/admin/folder/${parent_id}/add`);
        $form.offset($this.offset());
    }
});
$deleteBtn.click(function () {
    $(this).find(`input[name="folder_id"]`).val($(this).closest(".folder").attr("data-id"));
})
$nodes.each((e, a) => {
    let $this = $(a),
        left = $this.attr("data-left"),
        right = $this.attr("data-right");
    if (right - left <= 1) {
        $this.addClass(`uncount`);
    }

});
$addBtn.appendTo($nodes.find(".folder-controls"));
$deleteBtn.appendTo($(".folders li.folder.uncount .folder-controls"));