@extends('components.layout')

@php

    $bladeTitle = 'Laravel';
    $bladeCssBar3='navigation-link-select';
    $bladeCss1='raw';
@endphp
@section('head')
@endsection


@section('content')


    <div class="bd-example m-0 border-0">
    <form class="row needs-validation"  action="" method="post">
        @csrf

        <form class="row g-3 needs-validation">
            <div class="col-md-4">
                <label for="titre" class="form-label">Titre</label>
                <input type="text" name="title" placeholder="titre" class="form-control" id="title" required>

            </div>
            <div class="col-md-4">
                <label for="content" class="form-label">Informations complémentaires</label>
                <textarea name="content" placeholder="Information " class="form-control" id="content"  required></textarea>

            </div>
            <div class="col-md-6">
                <label for="startDay" class="form-label">Date début</label>
                <input type="date" name="startDay" class="form-control" id="startDay">
            </div>
            <div class="col-md-6">
                <label for="endDay" class="form-label">Date de fin</label>
                <input type="date" name="endDay" class="form-control" id="endDay">
            </div>

            <div class="col-md-3">
                <label for="startTime" class="form-label">Start Time</label>
                <input type="time" name="startTime" class="form-control" id="startTime">
            </div>
            <div class="col-md-3">
                <label for="endTime" class="form-label">End Time</label>
                <input type="time" name="endTime" class="form-control" id="endTime">
            </div>
            <div class="col-12">
                <button class="btn btn-primary">Submit form</button>
            </div>
        </form>
    </form>
    </div>

    @endsection



