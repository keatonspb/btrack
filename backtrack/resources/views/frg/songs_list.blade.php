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
                @include('frg/instruments', ['track'=>$song])
            </td>
        </tr>
        @endforeach

    </tbody>
</table>