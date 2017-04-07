<div class="panel panel-default">
    <div class="panel-heading">Tabs and lyrics
    </div>
    <div class="panel-body">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            @foreach($tabs_instruments as $tabs_instrument)
                <li role="presentation" @if ($loop->first) class="active" @endif>
                    <a href="#{{$tabs_instrument['name']}}" class="song-tab" role="tab" data-toggle="tab">
                        {{$tabs_instrument['name']}} @if($tabs_instrument['count_tabs'] > 1)
                            ({{$tabs_instrument['count_tabs']}}) @endif
                    </a>
                </li>
            @endforeach
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            @foreach($tabs_instruments as $tabs_instrument)
                <div role="tabpanel" class="tab-pane tab-tab fade in @if ($loop->first) active @endif"
                     id="{{$tabs_instrument['name']}}">
                    @if($tabs_instrument['count_tabs'] > 1)
                        <div class="dropdown tabs-select pull-right">
                            <button type="button" data-toggle="dropdown" class="btn btn-default">
                                <span class="title">Tab 1</span>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dLabel">
                                @foreach($tabs_instrument['tabs'] as $tab)
                                    <li class="@if ($loop->first) active @endif" role="presentation"><a class="tabswitch" href="#tab_{{$tabs_instrument['name']}}_{{$tab->id}}">Tab {{$loop->index+1}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="clearfix"></div>
                    @endif

                        @foreach($tabs_instrument['tabs'] as $tab)
                            <div class="tabtab-panel @if ($loop->first) active @endif {{$tab->instrument}}" id="tab_{{$tabs_instrument['name']}}_{{$tab->id}}_">
                                <div class="info">
                                    @if($tab->tuning_name) Tunning: <strong>{{$tab->tuning_name}} ({{$tab->tuning_strings}})</strong> @endif
                                </div>
                                <div class="content">
                                    {!! $tab->content !!}
                                </div>
                            </div>
                        @endforeach
                </div>

            @endforeach
        </div>

    </div>

</div>