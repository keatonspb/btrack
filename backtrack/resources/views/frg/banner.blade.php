<div class="banner">
    <div class="cover"></div>
    <div class="container">
        <div class="header">Batrack is a huge database of <span>{{$tracks_count}}</span> tracks for guitar and drums player</div>
        <div class="search-box">
            <form action="/search">
                <div class="input-group">
                    <input type="text" class="form-control suggest" autocomplete="off" style="width: 100%; float: none;" name="q" value="{{$search_example}}">
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <p>And it also available on <a target="_blank" href="https://play.google.com/store/apps/details?id=ru.discode.batrack&utm_source=web&pcampaignid=MKT-Other-global-all-co-prtnr-py-PartBadge-Mar2515-1">google play</a></p>
    </div>
</div>