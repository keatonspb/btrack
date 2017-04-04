/**
 * Created by default on 04.04.2017.
 */
$(".open_dialog").click(function () {
    var $dialog = $($(this).data("dialog"));
    if($dialog.length) {
        $("input", $dialog).val("");
        $("textarea", $dialog).text("");
        $dialog.modal();

    }
});