@extends('layouts.master')

@section('title', '- ' . Auth::user()->name)

@section('styles')
    <!-- Include Editor style. -->
    <link href='https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.7.3/css/froala_editor.min.css' rel='stylesheet' type='text/css' />
    <link href='https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.7.3/css/froala_style.min.css' rel='stylesheet' type='text/css' />
@endsection

@section('message')
    <div class="message">
        <div>
            <span class="green"></span>
            <p></p>
            <button type="button" class="close_message" id="close_message"><i class="icon ion-close"></i></button>
        </div>
    </div>
@endsection

@section('addtask')
    @include('todo.addtask')
@endsection

{{-- Start Task Sections --}}
@section('today')

    <h3><i class="ion ion-speakerphone"></i> Today:</h3>
    <div class="tasks">
        @foreach ($tasks['today'] as $task)
            @include('todo.task')
        @endforeach
    </div>

@endsection

@section('tomorrow')

    <h3><i class="ion ion-paper-airplane"></i> Tomorrow:</h3>
    <div class="tasks">
        @foreach ($tasks['tomorrow'] as $task)
            @include('todo.task')
        @endforeach
    </div>

@endsection


@section('comming')

    <h3><i class="ion ion-flag"></i> Comming:</h3>
    <div class="tasks">
        @foreach ($tasks['comming'] as $task)
            @include('todo.task')
        @endforeach
    </div>

@endsection

@section('overdue')

    <h3><i class="ion ion-filing"></i> Overdue:</h3>
    <div class="tasks">
        @foreach ($tasks['overdue'] as $task)
            @include('todo.task')
        @endforeach
    </div>

@endsection
{{-- /End Task Sections --}}

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('scripts')

    <!-- SLIM SCROLL JS -->
    <script src="{{ URL::asset('js/jquery.slimscroll.min.js') }}"></script>

    <!-- FROALA-EDITOR JS -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.7.3/js/froala_editor.min.js'></script>

    <!-- JQUERY UI JS -->
    <script src="{{ URL::asset('js/jquery-ui.min.js') }}"></script>

    <!-- SCRIPT JS -->
    <script src="{{ URL::asset('js/script.js') }}"></script>

    {{-- Check for the user skin cookie --}}
    @if(request()->cookie('skin') !== null)
        <script>
            // Get the skin colors if cookie exist
            var skin = {!! request()->cookie('skin') !!};
            $('.future').css('background-color', skin.color1);
            $('.past').css('background-color', skin.color2);
            $('.sidebar').css('background-color', skin.bcolor);
        </script>
    @endif

@endsection
