<table class="table">
    <thead>
    <tr>
        <th>Name</th>
        <th>Author</th>
        <th>Tracks</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach($songs as $song)
        <tr>
            <td><a href="/song/{{$song->id}}">{{$song->name}}</a></td>
            <td>{{$song->author_name}}</td>
            <td>{{$song->tcount}}</td>
            <td style="text-align: right;">
                <ul class="instruments">
                    <li class="lead_guitar @if($song->lead) active @endif"></li>
                    <li class="rhythm_guitar @if($song->rhythm) active @endif"></li>
                    <li class="bass @if($song->bass) active @endif"></li>
                    <li class="voice @if($song->voice) active @endif"></li>
                    <li class="drums @if($song->drums) active @endif"></li>
                    <li class="keys @if($song->keys) active @endif"></li>
                </ul>
            </td>
        </tr>
        @endforeach

    </tbody>
</table>