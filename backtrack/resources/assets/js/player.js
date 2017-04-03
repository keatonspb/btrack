
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
            var cues = [];
            var nextCue = 0;
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
            next.click(function () {
                song.pause();
                console.info(song.duration);
                perc = song.currentTime/song.duration*100;
                var fouded_cue = perc;
                console.info(fouded_cue);
                $(".part", elem).each(function () {
                    var parent = $(this).parent();
                    pos = $(this).position().left/parent.width()*100;
                    if((pos > perc && pos <= fouded_cue) || fouded_cue == 0 ) {
                        fouded_cue = pos;
                    }
                    console.info(fouded_cue);
                });
                song.currentTime = song.duration * (fouded_cue/100);

                song.play();
            });

            if(elem.hasClass("editable")) {
                $( ".part", elem).draggable({ axis: "x", containment: "parent", stop: function () {
                    syncCue(this);
                } });
                var cue_dialog = $("#edit_cue_dialog");
                $(".add_cue", elem).click(function () {
                    cue_dialog.modal();
                });


                $(".del_cue", elem).click(function () {
                    if($(this).hasClass("selected")) {
                        $(this).removeClass("selected");
                        $( ".part", elem).removeClass("deletable")
                    } else {
                        $(this).addClass("selected");
                        $( ".part", elem).addClass("deletable")
                    }
                });

                $(".parts_container").on("click", ".deletable", function() {
                    var id = $(this).data("for");
                    $("#"+id).remove();
                    $(this).remove();
                });

                $("#edit_cue_dialog .btn-primary").click(function() {
                    cue_dialog.modal("hide");
                    cue = $("<div class='part'/>");
                    cid = "cue_"+(new Date().getTime()/1000)
                    cue.data("data-for", cid);
                    perc = song.currentTime/song.duration*100;
                    cue.css("left", perc+"%");
                    cue_name = $("select", cue_dialog).val();
                    cue.html("<div class='cue'></div> <span>"+$("select option:selected", cue_dialog).html()+"</span>");
                    $(".parts_container", elem).prepend(cue);
                    input = $("<input type='hidden' id='"+cid+"' name='"+cue_name+"[]' value='"+perc+"' />");
                    $(".cue_container").append(input);
                    $( ".part" ).draggable({ axis: "x", containment: "parent", stop: function () {
                        syncCue(this);
                    }});
                });
            }


        });

        function collectCues(elem) {
            var cues = [];
            console.info($(".part", elem));
            $(".part", elem).each(function () {
                var parent = $(this).parent();
                cues.push($(this).position().left/parent.width()*100);
            });
            return cues;
        }

        function syncCue(el) {
            console.info("syncCue",el)
            var id = $(el).data("for");
            var parent = $(el).parent();
            perc = $(el).position().left/parent.width()*100;
            console.info(perc);
            $("#"+id).val(perc);
        }

        function maketime(mtime) {
            mtime = Math.round(mtime);
            minutes = Math.floor(mtime/60);
            second =mtime%60;
            return (minutes < 10 ? "0"+minutes.toString() : minutes)+":"+(second < 10 ? "0"+second.toString() : second);
        }
    };
}( jQuery ));