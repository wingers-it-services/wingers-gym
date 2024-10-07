@extends('GymOwner.master')
@section('title', 'Gym Schedule')
@section('content')

<style>
    .external-event {
        position: relative;
        padding-right: 25px;
        /* Create space for the delete icon */
    }

    .external-event .fa-remove {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: red;
        /* Initial color for the cross icon */
        transition: color 0.3s ease;
        /* Smooth transition for color change */
    }

    .external-event .fa-remove:hover {
        color: white;
        /* Color changes to white on hover */
    }
</style>
<div class="content-body ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-intro-title">Calendar</h4>
                        <div class="row">
                            <div id="external-events" class="my-3">
                                <p>Click on the "Create Event" to add new event in the calender</p>
                                @foreach ($gymShedule as $schedule)

                                    <div class="external-event btn-primary light" data-class="bg-primary"
                                        data-id="{{ $schedule->id }}">
                                        <i class="fa fa-move"></i>
                                        <span>{{ $schedule->event_name }}</span>
                                        <i class="fas fa-remove"></i>
                                    </div>
                                @endforeach

                            </div>
                            <a href="javascript:void()" data-bs-toggle="modal" data-bs-target="#add-category"
                                class="btn btn-primary btn-event w-100">
                                <span class="align-middle"><i class="ti-plus me-2"></i></span> Create Event
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9">
                <div class="card">
                    <div class="card-body">
                        <div id="calendar" class="app-fullcalendar"></div>
                    </div>
                </div>
            </div>
            <!-- BEGIN MODAL -->
            <div class="modal fade none-border" id="event-modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"><strong>Add New Event</strong></h4>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default waves-effect"
                                data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-success save-event waves-effect waves-light">Create
                                event</button>

                            <button type="button" class="btn btn-danger delete-event waves-effect waves-light"
                                data-bs-dismiss="modal">Delete</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade none-border" id="add-category">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"><strong>Add Shedule</strong></h4>
                        </div>
                        <div class="modal-body">
                            <form method="post" class="needs-validation" action="{{ route('addGymShedule') }}"
                                novalidate>
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="control-label">Event Name</label>
                                        <input class="form-control form-white" placeholder="Enter event name"
                                            type="text" name="event_name" required>
                                        <div class="invalid-feedback">
                                            Event Name is required.
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 5%;">
                                    <div class="col-md-6">
                                        <label class="control-label">Recurring</label>
                                        <select class="form-control form-white" data-placeholder="Choose..."
                                            name="is_recurring" id="is_recurring" required>
                                            <option value="" disabled selected>Choose...</option>
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Recurring is required.
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label">Date</label>
                                        <input class="form-control form-white" type="date" name="date" id="date">
                                        <div id="week_days_section" style="padding-top: 5%; display: none;">
                                            <label class="control-label">Week Day</label>
                                            @foreach(\App\Enums\WeekDaysEnum::getWeekDays() as $key => $day)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="week_days[]"
                                                        value="{{ $key }}" id="day{{ $key }}">
                                                    <label class="form-check-label" for="day{{ $key }}">{{ $day }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 5%;">
                                    <div class="col-md-6">
                                        <label class="control-label">Start Time</label>
                                        <input class="form-control form-white" placeholder="Enter start time"
                                            type="time" name="start_time" required>
                                        <div class="invalid-feedback">
                                        Start Time is required.
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label">End Time</label>
                                        <input class="form-control form-white" placeholder="Enter end time" type="time"
                                            name="end_time" required>
                                        <div class="invalid-feedback">
                                        End Time is required.
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 5%;">
                                    <div class="col-md-12">
                                        <label class="control-label">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="4"
                                            placeholder="Enter description here..." required></textarea>
                                            <div class="invalid-feedback">
                                            Description is required.
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger light waves-effect"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light save-category">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')

        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    })()

    document.addEventListener('DOMContentLoaded', function () {
        const isRecurringSelect = document.getElementById('is_recurring');
        const weekDaySelect = document.getElementById('date');
        const weekDaysSection = document.getElementById('week_days_section');

        isRecurringSelect.addEventListener('change', function () {
            if (this.value == '1') { // If recurring is "Yes"
                weekDaySelect.style.display = 'none'; // Hide the select dropdown
                weekDaysSection.style.display = 'block'; // Show checkboxes
            } else {
                weekDaySelect.style.display = 'block'; // Show the select dropdown
                weekDaysSection.style.display = 'none'; // Hide checkboxes
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            selectable: true,
            editable: true,
            droppable: true,
            events: function (fetchInfo, successCallback, failureCallback) {
                // Perform an AJAX request to fetch the events from the backend
                $.ajax({
                    url: "/fetch-gym-schedules",  // Define your route here
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        var events = [];

                        // Loop through the response to format events for FullCalendar
                        response.forEach(function (event) {
                            events.push({
                                title: event.title,
                                start: event.start,  // Use start directly from the response
                                end: event.end,  // Use end directly from the response
                                className: event.className,
                                allDay: !event.start_time // If there's no time, it's an all-day event
                            });
                        });


                        // Pass the formatted events to FullCalendar
                        successCallback(events);
                    },
                    error: function (xhr, status, error) {
                        console.error("Error fetching events:", error);
                        failureCallback(error);  // Handle failure
                    }
                });
            },
            eventDrop: function (arg) {
                if (document.getElementById('drop-remove').checked) {
                    arg.draggedEl.parentNode.removeChild(arg.draggedEl);
                }
            }
        });

        calendar.render();
    });

    document.querySelectorAll('.fa-remove').forEach(function (icon) {
        icon.addEventListener('click', function () {
            let eventDiv = this.closest('.external-event');
            let eventName = eventDiv.querySelector('span').textContent;
            let eventId = eventDiv.getAttribute('data-id'); // Assuming you have the event ID in the div
            alert(eventId);

            // Use SweetAlert for confirmation
            Swal.fire({
                title: 'Are you sure?',
                text: `Do you really want to delete the event "${eventName}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Make an AJAX request to delete the event from the server
                    $.ajax({
                        url: `/delete-gym-schedules/${eventId}`,
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if (data.success) {
                                eventDiv.remove(); // Remove the event div from DOM
                                Swal.fire(
                                    'Deleted!',
                                    'The event has been deleted.',
                                    'success'
                                ).then(() => {
                                    // Reload the page after successful deletion
                                    location.reload();
                                });

                            } else {
                                Swal.fire(
                                    'Error!',
                                    'Failed to delete the event.',
                                    'error'
                                );
                            }
                        },
                        error: function (error) {
                            Swal.fire(
                                'Error!',
                                'An error occurred while deleting the event.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });


</script>



@include('CustomSweetAlert');
@endsection