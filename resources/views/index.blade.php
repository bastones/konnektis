@extends('layouts.master')

@section('title', 'Konnektis')

@section('scripts')
    @parent

    <script src="{{ mix('js/app.js') }}"></script>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
@endsection

@section('main')
    <div class="wrapper">

    </div>
@endsection
