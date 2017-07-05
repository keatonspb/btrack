
require('./bootstrap');
require('./player');
require('jquery-ui');
require('jquery-ui/ui/widgets/draggable');
require('jquery-bar-rating/dist/jquery.barrating.min')

require('./components/jquery.form.min');
require('./components/bootstrap-notify.min');


import "./tabs";
import './suggest';



$(document).ready(function () {

    $(".player").btplayer();
    $('.rating').barrating({
        emptyValue: 0,
        theme: 'fontawesome-stars',
        onSelect: function (value, text, event) {
            if (typeof(event) !== 'undefined') {
                // rating was selected by a user
                console.log(value, event);
                var track = $(event.target).parents(".br-wrapper").first().find("select").data("track")
                $.getJSON("/track/rate/"+track, {
                    rate: value,
                }, function (json) {

                });
            }
        }
    });
    $(".rating").each(function (i, e) {
        console.info(i, e, this);
        $(e).barrating('set', parseFloat($(e).data("rating")));
    });


    $(".edit_track_form").ajaxForm({
            dataType: "json",
            success: function (json, statusText, xhr, $form) {
                if(json.success) {
                    $.notify({
                        message: json.message
                    });
                } else {
                    $.notify({
                        message: json.message
                    }, {
                        type: 'danger'
                    });
                }

            }
        }
    );
    $(".ajax-form").ajaxForm(
        {
            beforeSubmit: function (arr, $form, options) {
                options.headers = {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                $(".alert", $form).hide();
                $(".button", $form).attr("disabled", "disabled");
            },
            dataType: "json",
            success: function (json, statusText, xhr, $form) {
                $(".button", $form).removeAttr("disabled", "disabled");

                if(json.success) {
                    if($(".alert", $form).length) {
                        $(".alert", $form).removeClass("alert-danger").addClass("alert-success").html(json.message).show();
                    } else {
                        $.notify({
                            message: json.message
                        });
                    }
                    if($form.data("reload")) {
                        location.reload();
                    }

                } else {
                    if($(".alert", $form).length) {
                        $(".alert", $form).removeClass("alert-success").addClass("alert-danger").html(json.message).show();
                    } else {
                        $.notify({
                            message: json.message
                        }, {
                            type: 'danger'
                        });
                    }

                }
            },
            error: function (json, statusText, xhr, $form) {

                if($(".alert", $form).length) {
                    $(".alert", $form).removeClass("alert-success").addClass("alert-danger").html("Error on form submit").show();
                } else {
                    $.notify({
                        message: "Error on form submit"
                    }, {
                        type: 'danger'
                    });
                }
            }
        }
    );
    $(".track-form").ajaxForm(
        {
            uploadProgress: function (event, pos, total, percentComplete) {
                $(".track-form .progress").show();
                $(".track-form .progress .progress-bar").css("width", percentComplete + "%");
                $(".track-form .progress .progress-bar .sr-only").html(percentComplete + "%")
            },
            beforeSubmit: function ($form) {
                $(".alert", $form).hide();
                $(".button", $form).attr("disabled", "disabled");
            },
            dataType: "json",
            success: function (json, statusText, xhr, $form) {
                console.info($form);
                $(".button", $form).removeAttr("disabled", "disabled");
                if (json.success) {
                    location.href = "/cabinet/song/edit/" + json.id;
                    $(".alert-success", $form).html(json.message).show();
                } else {
                    $(".alert-danger", $form).html(json.message).show();
                }
            }
        }
    );
    require('./dialogs');

    $(".delete-item").click(function () {
        var resultConfirm = confirm("Are you sure?");
        var backurl = $(this).data("backurl") ? $(this).data("backurl") : location.href;
        if(resultConfirm) {
            $.getJSON($(this).attr("href"), function (json) {
                if(json.success) {
                    location.href = backurl;
                } else {
                    $.notify({
                        message: json.message
                    }, {
                        type: 'danger'
                    });
                }
            });
        }
        return false;
    });



});

