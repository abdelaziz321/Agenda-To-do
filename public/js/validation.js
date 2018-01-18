/*global $*/
/*-------------------------------------------
* Author      : Abdelaziz Selim
* Project     : Agenda - Todo Tasks
* Version     : 1.0
*-------------------------------------------*/

$(document).ready(function () {
    "use strict";
    var signinTab = $('.register_system .signin'),
        signupHeight = $('.register_system .signup:visible').outerHeight();

    // Match height the sign in | up | features
    signinTab.css('height', signupHeight);
    $('#features').css('height', signupHeight + $('.register_system .nav-tabs').outerHeight());

    $('#signin form').parsley();
    $('#signup form').parsley();

    // Signin request
    $('#signin_btn').on('click', function(event) {
        var form = $(this).parents('form'),
            feedback = form.find('.feedback'),
            url = form.attr('action'),
            formData = new FormData(form[0]);

        feedback.hide();
        form.parsley().validate();
        if ( form.parsley().isValid() ) {
            $.ajax({
                url: url,
                type: 'POST',
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false
            })
            .done(function(response) {
                window.location = response.url;

            }).fail(function(xhr, settings, thrownError) {
                var response = JSON.parse(xhr.responseText);
                if(response.status) {   // email or password incorrect
                    feedback.html(response.status).show();
                } else {    // validation failed
                    var message = '';
                    for (var error in response.errors) { message += (response.errors[error] + '<br>'); }
                    feedback.html(message).show();
                }
            });
        }
        event.preventDefault();
    });

    // Signup request
    $('#signup_btn').on('click', function(event) {
        var form = $(this).parents('form'),
            feedback = form.find('.feedback'),
            url = form.attr('action'),
            formData = new FormData(form[0]);

        feedback.hide();
        form.parsley().validate();
        if ( form.parsley().isValid() ) {
            $.ajax({
                url: url,
                type: 'POST',
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false
            })
            .done(function(response) {
                window.location = response.url;

            }).fail(function(xhr, settings, thrownError) {
                var errors = JSON.parse(xhr.responseText).errors,
                    message = '';
                for (var error in errors) { message += (errors[error] + '<br>'); }
                feedback.html(message).show();
            });
        }
        event.preventDefault();
    });
});
