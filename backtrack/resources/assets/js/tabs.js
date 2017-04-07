if($(".tabtab-panel").length) {

    $(".tabswitch").click(function () {
        href = $(this).attr("href").replace("#", "");
        $(this).parent().siblings("li").removeClass("active");
        $(this).parents(".tabs-select").find(".title").html($(this).html())
        $(this).parent().addClass("active");
        $(".tabtab-panel").removeClass("active");
        $(".tabtab-panel#"+href+"_").addClass("active");
    });
    if(location.hash) {
        hash =location.hash.replace("#", "");
        $(".tabswitch[href='"+location.hash+"']").click();
    }
}