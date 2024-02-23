<x-layout>

    <x-slot:title>
        Laravel Fullcalendar
    </x-slot:title>

    <x-slot:select1>
        navigation-link-select
    </x-slot:select1>

    <x-slot:headSlot>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />

        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    </x-slot:headSlot>

    <body>



        <div class="container">

            <h1>FullCalendar in Laravel</h1>

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

            FullCalendar JS Code

            --------------------------------------------

            --------------------------------------------*/

            var calendar = $('#calendar').fullCalendar({

                editable: true,

                events: SITEURL + "/fullcalendar",

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

                        var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm");

                        var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm");

                        $.ajax({

                            url: SITEURL + "/fullcalendarAjax",

                            data: {

                                name: title,

                                date_start: start,

                                date_end: end,

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

                    var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm");

                    var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm");



                    $.ajax({

                        url: SITEURL + '/fullcalendarAjax',

                        data: {

                            name: event.title,

                            date_start: start,

                            date_end: end,

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

                            url: SITEURL + '/fullcalendarAjax',

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



    </body>

</x-layout>