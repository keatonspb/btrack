<div class="player {{$class|""}}">
    <audio src="{{$track->getFilePath()}}"></audio>
    <div class="timeline">
        @if($track->getCues())
        <div class="parts_container">
            @foreach($track->getCues() as $cue)
                <div class="part" style="left: {{$cue->perc}}%" data-for="cue_{{$loop->index}}">
                    <div class="cue"></div>
                    <span>{{$cue->name}}</span></div>
            @endforeach
        </div>
        @endif
        <div class="bar">
            <div class="progress" style="width: 0%;"></div>
            <div class="cursor"></div>
        </div>
    </div>
    <div class="controls">
        <div class="buttons">
            <button title="Play" class="play"><i class="fa fa-play" aria-hidden="true"></i></button>
            <button title="Previous cue" class="prev"><i class="fa fa-fast-backward" aria-hidden="true"></i></button>
            <button title="Next cue" class="next"><i class="fa fa-fast-forward" aria-hidden="true"></i></button>
            @if($class == 'editable')
                <button title="Add cue" class="add_cue"><i class="text-primary fa fa-plus" aria-hidden="true"></i>
                </button>
                <button title="Remove cue" class="del_cue"><i class="text-danger fa fa-minus" aria-hidden="true"></i>
                </button>
            @endif
        </div>
        <div class="time">
            <span class="cur">00:00</span> / <span class="all">00:00</span>
        </div>
    </div>
</div>