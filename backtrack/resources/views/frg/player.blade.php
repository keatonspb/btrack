<div class="player {{$class|""}}">
    <audio src="{{$file}}"></audio>
    <div class="timeline">
        <div class="parts_container">
            <div class="part" style="left: 1%"><div class="cue"></div><span>intro</span></div>
            <div class="part" style="left: 10%"><div class="cue"></div><span>pre-chorus</span></div>
            <div class="part" style="left: 40%"><div class="cue"></div><span>chorus</span></div>
        </div>
        <div class="bar"><div class="progress" style="width: 0%;"></div><div class="cursor"></div> </div>
    </div>
    <div class="controls">
        <div class="buttons">
        <button class="play"><i class="fa fa-play" aria-hidden="true"></i></button>
        <button class="prev"><i class="fa fa-fast-backward" aria-hidden="true"></i></button>
        <button class="next"><i class="fa fa-fast-forward" aria-hidden="true"></i></button>
        <button class="add_cue"><i class="fa fa-fast-forward" aria-hidden="true"></i></button>
        </div>
        <div class="time">
            <span class="cur">00:00</span> / <span class="all">00:00</span>
        </div>
    </div>
</div>