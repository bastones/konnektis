<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('meta')

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400">

    @yield('styles')

    <title>
        Loading...
    </title>
</head>
<body>
    <div id="root">
        <transition name="custom" enter-active-class="animated fadeIn" mode="out-in">
            <router-view></router-view>
        </transition>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
