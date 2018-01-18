@extends('layouts.master')

@section('styles')
    {{-- parsley CSS --}}
    <link rel="stylesheat" href="{{ URL::asset('css/parsley.css') }}" />
@endsection

@section('register')
    @include('user.register')
@endsection

@section('scripts')
    <script src="{{ URL::asset('js/parsley.min.js') }}"></script>
    <script src="{{ URL::asset('js/validation.js') }}"></script>
@endsection
