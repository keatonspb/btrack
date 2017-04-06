<div class="modal fade" id="edit_tab_dialog" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Tab</h4>
            </div>
            <form method="post" class="ajax-form dialog-form" data-reload="1" action="/cabinet/tabs/save">
                {{ csrf_field() }}
                <input type="hidden" name="id" class="fillable" />
                <input type="hidden" name="song_id" value="{{$song->id}}" />
            <div class="modal-body">
                <div class="alert" style="display: none"></div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="td_type">Type</label>
                            <select id="td_type" name="instrument" class="form-control fillable">
                                <option value="guitar">Guitar</option>
                                <option value="bass">Bass</option>
                                <option value="drums">Drums</option>
                                <option value="lyrics">Lyrics</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label for="td_tunning">Tuning</label>
                        <select class="form-control fillable" id="td_tunning" name="tuning_id">
                            <option value="0">No tuning</option>
                            @foreach($tunings as $tuning)
                                <option value="{{$tuning->id}}" for="{{$tuning->instrument}}">{{$tuning->name}} ({{$tuning->strings}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <label for="td_tab">Tab</label>
                        <textarea rows="10" name="content" id="td_tab" class="form-control fillable"></textarea>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save tab</button>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->