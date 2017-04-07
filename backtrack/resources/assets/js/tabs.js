function loadTabs() {
    var href = $(".active .song-tab").attr("href").substring(1);
    type = href.split("-");
    console.info(type);

}

$('a.song-tab').on('shown.bs.tab', function (e) {

    e.target // newly activated tab
    e.relatedTarget // previous active tab
});