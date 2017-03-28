
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./components/jquery.form.min');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

$(document).ready(function () {
   $(".track-form").ajaxForm(
       {
           beforeSubmit: function ($form) {
               $(".alert", $form).hide();
               $(".button", $form).attr("disabled", "disabled");
           },
           dataType: "json",
           success: function (json, statusText, xhr, $form) {
               console.info($form);
               $(".button", $form).removeAttr("disabled", "disabled");
               if (json.success) {
                    location.href = "/cabinet/song/edit/"+json.id;
                   $(".alert-success", $form).html(json.message).show();
               } else {
                   $(".alert-danger", $form).html(json.message).show();
               }
           }
       }
   );
});