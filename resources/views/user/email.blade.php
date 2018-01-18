@extends('layouts.master')

@section('register')
<div class="container" style="position: absolute; left: 50%; transform: translate(-50%, -50%); top: 50%;">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>

                <div class="panel-body">

                    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary" id="send_email">
                                    Send Password Reset Link
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="status" style="color:#f00; text-align: center; background-color: rgba(0,0,0,0.05);"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
    $('#send_email').on('click', function(event) {
        event.preventDefault();

        var form = $(this).parents('form'),
            url = form.attr('action'),
            formData = new FormData(form[0]);

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
            data: formData,
            processData: false,
            contentType: false
        })
        .done(function(data) {
            $('.status').html(data.status);
        });
    });
    </script>
@endsection
