
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

            song.addEventListener('timeupdate',function (){
                progress.css("width", song.currentTime/song.duration*100+"%")
            });
            play.click(function () {

                if($(".fa",this).hasClass("fa-play")) {
                    song.play();
                    $(".fa",this).removeClass("fa-play").addClass("fa-pause");
                } else {
                    song.pause();
                    $(".fa",this).removeClass("fa-pause").addClass("fa-play");
                }
            });

        });


    };
}( jQuery ));