
(function( $ ) {
    $.fn.btplayer = function() {

        // Iterate and reformat each matched element.
        return this.each(function() {

            var elem = $( this );
            var audio = $("audio", elem);
            var play = $(".play", elem);
            var prev = $(".prev", elem);
            var next = $(".next", elem);
            var progress = $(".progress", elem);

            var song = new Audio(audio.attr("src"));
            song.play();
            song.addEventListener('timeupdate',function (){
                console.info(curtime, song.currentTime/song.duration*100+"%")
                progress.css("width", song.currentTime/song.duration*100+"%")
            });

        });


    };
}( jQuery ));