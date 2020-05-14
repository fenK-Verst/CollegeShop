$(document).ready(()=>{
    $(".delete-folder").click(function(){
        $(this).submit();
    });
    let $nodes = $(".folders li"),
        $form = $("#folder_form");

    $form.find(".close").click(() => {
        $form.removeClass("active");
    })
    let $addBtn = $(`<span class="btn btn-sm btn-primary"><i class="fa fa-plus"></i></span>`);
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
            if ($(window).width() < 768){
                $form.css({
                    right:"10px",
                    left:"auto"
                })
            }
        }
    });
    $addBtn.appendTo($nodes.find(".folder-controls"));
});

