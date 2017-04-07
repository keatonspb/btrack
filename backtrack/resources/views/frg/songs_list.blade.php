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
            <td><a href="/song/{{$song->id}}">{{$song->name}}</a> - {{$song->author_name}}</td>
            <td style="text-align: right;">
                @include('frg/instruments', ['track'=>$song])
            </td>
        </tr>
        @endforeach

    </tbody>
</table>