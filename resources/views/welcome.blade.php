@extends('components.layout')
@php

    $bladeTitle = 'Laravel';
    $bladeCssBar2='navigation-link-select';
    $bladeCss1='raw';
@endphp


@section('content')
        <h1>Hello World!</h1>
        <p>Lorem ipsum dolor sit amet consectetur adipiscing elit. Hic, aut?</p>
        <button class="btn">Get Started</button>
@endsection
@section('vue')
    <user-list></user-list>
@endsection
