/**
 * Created by default on 04.04.2017.
 */
$(".open_dialog").click(function () {
    var $dialog = $($(this).data("dialog"));
    var getUrl = $(this).data("get");
    if(getUrl) {
        $.getJSON(getUrl, function (json) {
            if(json.success) {
                $.each(json.data, function (index, val) {
                    $("input[name="+index+"]").val(val);
                    $("select[name="+index+"]").val(val);
                    $("textarea[name="+index+"]").html(val);
                });
            }
        });
    }
    if($dialog.length) {
        $("input.fillable", $dialog).val("");
        $("textarea.fillable", $dialog).html("");

        $dialog.modal();

    }
});