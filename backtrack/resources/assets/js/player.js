
(function( $ ) {
    $.fn.btplayer = function() {

        // Iterate and reformat each matched element.
        return this.each(function() {

            var elem = $( this );
            var song = $("audio", elem)[0];
            var play = $(".play", elem);
            var prev = $(".prev", elem);
            var next = $(".next", elem);
            var progress = $(".progress", elem);
            var timeline = $(".timeline", elem);
            var bar = $(".bar", elem);
            var cursor = $(".cursor", elem);
            var curTime = $(".time .cur", elem);
            var allTime = $(".time .all", elem);
            var loaded = false;
            song.addEventListener("loadedmetadata", function () {
                allTime.html(maketime(song.duration));
            });
            song.addEventListener('timeupdate',function (){
                progress.css("width", song.currentTime/song.duration*100+"%")
                curTime.html(maketime(song.currentTime));
            });
            timeline.mousemove(function (ev) {
                posx =  ev.pageX - $(this).offset().left;
                cursor.css('left', posx);
            });
            timeline.click(function (ev) {
                posx =  ev.pageX - $(this).offset().left;
                perc = posx/$(this).width();
                song.currentTime = song.duration * perc;


            });
            play.click(function () {
                allTime.html(maketime(song.duration));
                if($(".fa",this).hasClass("fa-play")) {
                    song.play();
                    $(".fa",this).removeClass("fa-play").addClass("fa-pause");
                } else {
                    song.pause();
                    $(".fa",this).removeClass("fa-pause").addClass("fa-play");
                }
            });

            if(elem.hasClass("editable")) {
                $( ".part" ).draggable({ axis: "x" });
            }


        });

        function maketime(mtime) {

            mtime = Math.round(mtime);
            console.info(mtime);
            minutes = Math.floor(mtime/60);
            second =mtime%60;
            return (minutes < 10 ? "0"+minutes.toString() : minutes)+":"+(second < 10 ? "0"+second.toString() : second);
        }
    };
}( jQuery ));