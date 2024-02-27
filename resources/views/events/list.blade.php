@extends('layouts.app')

@push('css')
    <style>
        #calendar a {
            color: #000000;
            text-decoration: none;
        }

        .mr-auto {
            margin-right: auto;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <input type="hidden" id="eventId">
                        <label for="title">Titre</label>
                        <input type="text" placeholder="Enter Title" class="form-control" id="title" name="title" value="" required>
                    </div>
                    <div>
                        <label for="is_all_day">Toute la journée</label>
                        <input type="checkbox" id="is_all_day" name="is_all_day" value="" required>
                    </div>
                    <div>
                        <label for="startDateTime">Début</label>
                        <input type="text" placeholder="Select Start Date" readonly class="form-control" id="startDateTime" name="startDate" value="" required>
                    </div>
                    <div>
                        <label for="endDateTime">Fin</label>
                        <input type="text" placeholder="Select End Date" readonly class="form-control" id="endDateTime" name="endDate" value="" required>
                    </div>
                    <div>
                        <label for="description">Description</label>
                        <textarea placeholder="Enter Description" class="form-control" id="description" name="description"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger mr-auto" style="display: none" id="deleteEventBtn" onclick="deleteEvent()">Supprimer</button>
                    <button type="button" class="btn btn-primary" onclick="submitEventFormData()">Sauvegarder</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script>

        let calendar = null;
        document.addEventListener('DOMContentLoaded', function () {
            let calendarEl = document.getElementById('calendar');
            calendar = new FullCalendar.Calendar(calendarEl, {
                editable: true,
                locale: 'fr',
                weekNumberCalculation: 'ISO',
                initialView: 'dayGridMonth',
                initialDate: new Date(),
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,list',
                },
                views: {
                    dayGridMonth: {
                        fixedWeekCount: false,
                        showNonCurrentDates: true
                    },
                },
                events: '{{route('refetch-events')}}',
                dateClick: function (info) {
                    let startDate, endDate, allDay;
                    allDay = $('#is_all_day').prop('checked');
                    if (allDay) {
                        startDate = moment(info.date).format("YYYY-MM-DD");
                        endDate = moment(info.date).format("YYYY-MM-DD");
                        initializeStartDateEndDateFormat("Y-m-d", true)
                    }
                    else {
                        initializeStartDateEndDateFormat("Y-m-d H:i", false)
                        startDate = moment(info.date).format("YYYY-MM-DD HH:mm");
                        endDate = moment(info.date).add(30, "minutes").format("YYYY-MM-DD HH:mm");
                    }
                    $('#startDateTime').val(startDate);
                    $('#endDateTime').val(endDate);
                    modalReset();
                    $('#eventModal').modal('show');
                },
                eventClick: function (info) {
                    modalReset();
                    const event = info.event;
                    $('#title').val(event.title);
                    $('#eventId').val(info.event.id);
                    $('#description').val(event.extendedProps.description);
                    $('#startDateTime').val(event.extendedProps.startDay);
                    $('#endDateTime').val(event.extendedProps.endDay);
                    $('#is_all_day').prop('checked', event.allDay);
                    $('#eventModal').modal('show');
                    $('#deleteEventBtn').show();
                    console.log(info);
                    if (info.event.allDay) {
                        initializeStartDateEndDateFormat("Y-m-d", true);
                    }
                    else {
                        initializeStartDateEndDateFormat("Y-m-d H:i", false)
                    }
                },
                eventDrop: function (info) {
                    const event = info.event;
                    resizeEventUpdate(event);
                },
                eventResize: function (info) {
                    const event = info.event;
                    resizeEventUpdate(event);
                }
            });

            calendar.render();
            $('#is_all_day').change(function () {
                let is_all_day = $(this).prop('checked');
                if (is_all_day) {
                    let start = $('#startDateTime').val().slice(0, 10);
                    $('#startDateTime').val(start);
                    let endDateTime = $('#endDateTime').val().slice(0, 10);
                    $('#endDateTime').val(endDateTime);
                    initializeStartDateEndDateFormat("Y-m-d", is_all_day);
                }
                else {
                    let start = $('#startDateTime').val().slice(0, 10);
                    $('#startDateTime').val(start + " 00:00");
                    let endDateTime = $('#endDateTime').val().slice(0, 10);
                    $('#endDateTime').val(endDateTime + " 00:30");
                    initializeStartDateEndDateFormat("Y-m-d H:i", is_all_day);
                }
            })
        })

        function initializeStartDateEndDateFormat(format, allDay) {
            let timePicker = !allDay;
            $('#startDateTime').datetimepicker({
                format: format,
                timepicker: timePicker
            });
            $('#endDateTime').datetimepicker({
                format: format,
                timepicker: timePicker
            });
        }

        function modalReset() {
            $('#title').val("");
            $('#description').val("");
            $('#eventId').val("");
            $('#deleteEventBtn').hide();
        }

        function submitEventFormData() {
            let eventId = $("#eventId").val();
            let url = '{{route('events.store')}}';
            let postData = {
                start: $('#startDateTime').val(),
                end: $('#endDateTime').val(),
                title: $('#title').val(),
                description: $('#description').val(),
                is_all_day: $('#is_all_day').prop('checked') ? 1 : 0,
            };
            if (eventId) {
                url = '{{url('/')}}' + `/events/${eventId}`;
                postData._method = "PUT";
            }

            // JQUERY AJAX
            $.ajax({
                type: 'POST',
                url: url,
                dataType: "json",
                data: postData,
                success: function(res) {
                    if (res.success) {
                        calendar.refetchEvents();
                        $('#eventModal').modal('hide');
                    }
                    else {
                        alert("Something went wrong !");
                    }
                }
            });
        }
        function deleteEvent() {

            if (window.confirm("Êtes-vous sûr de vouloir supprimer cet événement ?")) {
                let eventId = $('#eventId').val();
                let url = '';
                if (eventId) {
                    url = '{{url('/')}}' + `/events/${eventId}`;
                }
                $.ajax({
                    type: 'DELETE',
                    url: url,
                    dataType: "json",
                    data: {},
                    success: function (res) {
                        if (res.success) {
                            calendar.refetchEvents();
                            $('#eventModal').modal('hide');
                        }
                        else {
                            alert("Someting going wrong !");
                        }
                    }
                });
            };
        }

        function resizeEventUpdate(event) {
            let eventId = event.id;
            let url = '{{url('/')}}' + `/events/${eventId}/resize`;
            let start = null, end = null;
            if (event.allDay) {
                start = moment(event.start).format("YYYY-MM-DD");
                end = start;
                if (event.end) {
                    end = moment(event.end).format("YYYY-MM-DD");
                }
            }
            else {
                start = moment(event.start).format("YYYY-MM-DD HH:mm");
                end = start;
                if (event.end) {
                    end = moment(event.end).format("YYYY-MM-DD HH:mm")
                }
            }

            let postData = {
                start: start,
                end: end,
                is_all_day: event.allDay ? 1 : 0,
                _method: "PUT"
            }

            $.ajax({
                type: 'POST',
                url: url,
                dataType: "json",
                data: postData,
                success: function(res) {
                    if (res.success) {
                        calendar.refetchEvents();
                    }
                    else {
                        alert("Something went wrong !");
                    }
                }
            })
        }


    </script>
@endpush
