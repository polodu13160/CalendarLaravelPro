@extends('components.layout')

@php

    $bladeTitle = 'Laravel';
    $bladeCssBar1='navigation-link-select';
    $bladeCss1='raw';
@endphp

@section('head')
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />

        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>



        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
@endsection

@section('content')
        <div class="container">

            <h1>Laravel 10 FullCalender Tutorial Example - ItSolutionStuff.com</h1>

            <div id='calendar'></div>

        </div>



        <script type="text/javascript">
            $(document).ready(function() {



                /*------------------------------------------

                --------------------------------------------

                Get Site URL

                --------------------------------------------

                --------------------------------------------*/

                var SITEURL = "{{ url('/') }}";



                /*------------------------------------------

                --------------------------------------------

                CSRF Token Setup

                --------------------------------------------

                --------------------------------------------*/

                $.ajaxSetup({

                    headers: {

                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                    }

                });



                /*------------------------------------------

                --------------------------------------------

                FullCalender JS Code

                --------------------------------------------

                --------------------------------------------*/

                var calendar = $('#calendar').fullCalendar({

                    editable: true,

                    events: SITEURL + "/fullcalender",

                    displayEventTime: false,

                    editable: true,

                    eventRender: function(event, element, view) {

                        if (event.allDay === 'true') {

                            event.allDay = true;

                        } else {

                            event.allDay = false;

                        }

                    },

                    selectable: true,

                    selectHelper: true,

                    select: function(start, end, allDay) {

                        var title = prompt('Event Title:');

                        if (title) {

                            var start = $.fullCalendar.formatDate(start, "Y-MM-DD");

                            var end = $.fullCalendar.formatDate(end, "Y-MM-DD");

                            $.ajax({

                                url: SITEURL + "/fullcalenderAjax",

                                data: {

                                    title: title,

                                    start: start,

                                    end: end,

                                    type: 'add'

                                },

                                type: "POST",

                                success: function(data) {

                                    displayMessage("Event Created Successfully");



                                    calendar.fullCalendar('renderEvent',

                                        {

                                            id: data.id,

                                            title: title,

                                            start: start,

                                            end: end,

                                            allDay: allDay

                                        }, true);



                                    calendar.fullCalendar('unselect');

                                }

                            });

                        }

                    },

                    eventDrop: function(event, delta) {

                        var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");

                        var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");



                        $.ajax({

                            url: SITEURL + '/fullcalenderAjax',

                            data: {

                                title: event.title,

                                start: start,

                                end: end,

                                id: event.id,

                                type: 'update'

                            },

                            type: "POST",

                            success: function(response) {

                                displayMessage("Event Updated Successfully");

                            }

                        });

                    },

                    eventClick: function(event) {

                        var deleteMsg = confirm("Do you really want to delete?");

                        if (deleteMsg) {

                            $.ajax({

                                type: "POST",

                                url: SITEURL + '/fullcalenderAjax',

                                data: {

                                    id: event.id,

                                    type: 'delete'

                                },

                                success: function(response) {

                                    calendar.fullCalendar('removeEvents', event.id);

                                    displayMessage("Event Deleted Successfully");

                                }

                            });

                        }

                    }



                });



            });



            /*------------------------------------------

            --------------------------------------------

            Toastr Success Code

            --------------------------------------------

            --------------------------------------------*/

            function displayMessage(message) {

                toastr.success(message, 'Event');

            }
        </script>



        <div class="col-md-3">
        <div class="cardt rounded-0 shadow">
            <div class="card-header bg-gradient bg-primary text-light">
                <h5 class="card-title">Schedule Form</h5>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <form action="save_schedule.php" method="post" id="schedule-form">
                        <input type="hidden" name="id" value="">
                        <div class="form-group mb-2">
                            <label for="title" class="control-label">Title</label>
                            <input type="text" class="form-control form-control-sm rounded-0" name="title" id="title"
                                required="">
                        </div>
                        <div class="form-group mb-2">
                            <label for="description" class="control-label">Description</label>
                            <textarea rows="3" class="form-control form-control-sm rounded-0" name="description"
                                id="description" required=""></textarea>
                        </div>
                        <div class="form-group mb-2">
                            <label for="start_datetime" class="control-label">Start</label>
                            <input type="datetime-local" class="form-control form-control-sm rounded-0"
                                name="start_datetime" id="start_datetime" required="">
                        </div>
                        <div class="form-group mb-2">
                            <label for="end_datetime" class="control-label">End</label>
                            <input type="datetime-local" class="form-control form-control-sm rounded-0" name="end_datetime"
                                id="end_datetime" required="">
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary btn-sm rounded-0" type="button" form="schedule-form"><i
                        class="fa fa-save"></i> Save</button>
                <button class="btn btn-default border btn-sm rounded-0" type="reset" form="schedule-form"><i
                        class="fa fa-reset"></i> Cancel</button>
            </div>
        </div>
@endsection



