@extends('layouts.app')

@section('content')

    @component('layouts.components.center-card')

        @slot('header')
            Lobby
        @endslot

        @slot('content')
            People will be here
        @endslot

    @endcomponent

@endsection
