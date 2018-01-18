<!DOCTYPE html>
<html lang="en">
<head>
    <!-- META -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Agenda is a smart task management app and to do list">
    <meta name="keywords" content="tasks, to do, agenda, list, task management">
    <meta name="author" content="Abdelaziz_Selim">
    <meta name="_token" content="{!! csrf_token() !!}"/>

    <!-- PAGE TITLE -->
    <title>Agenda @yield('title')</title>

    <!-- PAGE ICON -->
    <link rel="icon" type="image/x-icon" href="{{ URL::asset('images/ninga.png') }}">

    <!-- BOOTSTRAB CSS -->
    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}" />

    <!-- GOOGLE FONTS -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins" />

    <!-- IONICON FONTS -->
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />

    <!-- FONT AWESOME FONTS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />

    <!-- MAIN STYLE CSS -->
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}" />

    <!-- RESPONSIVE CSS -->
    <link rel="stylesheet" href="{{ URL::asset('css/media.css') }}" />

    @yield('styles')

    <!-- HTML5 shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="assets/js/html5shiv.min.js"></script>
        <script src="assets/js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
