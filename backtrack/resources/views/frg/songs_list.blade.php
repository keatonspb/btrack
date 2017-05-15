<table class="table">
    <thead>
    <tr>
        <th>Name</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach($songs as $song)
        <tr>
            <td><a href="/song/{{$song->author_alias}}/{{$song->alias}}">{{$song->name}}</a> - {{$song->author_name}}</td>
            <td style="text-align: right;">
                @if(sizeof($song->tabs))
                    <span class="hastabs" title="has tabs"></span>
                @endif
                @include('frg/instruments', ['track'=>$song])
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $songs->links() }}