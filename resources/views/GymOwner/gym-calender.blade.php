@extends('GymOwner.master')
@section('title','Dashboard')
@section('content')

<div class="content-body ">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">App</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Calerdar</a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-intro-title">Calendar</h4>
                        <div class="">
                            <div id="external-events" class="my-3">
                                <p>Drag and drop your event or click in the calendar</p>
                                <div class="external-event btn-primary light" data-class="bg-primary"><i class="fa fa-move"></i><span>New Theme Release</span></div>
                                <div class="external-event btn-warning light" data-class="bg-warning"><i class="fa fa-move"></i>My Event</div>
                                <div class="external-event btn-danger light" data-class="bg-danger"><i class="fa fa-move"></i>Meet manager</div>
                                <div class="external-event btn-info light" data-class="bg-info"><i class="fa fa-move"></i>Create New theme</div>
                                <div class="external-event btn-dark light" data-class="bg-dark"><i class="fa fa-move"></i>Project Launch</div>
                                <div class="external-event btn-secondary light" data-class="bg-secondary"><i class="fa fa-move"></i>Meeting</div>
                            </div>
                            <!-- checkbox -->
                            <div class="checkbox form-check checkbox-event custom-checkbox pt-3 pb-5">
                                <input type="checkbox" class="form-check-input" id="drop-remove">
                                <label class="form-check-label" for="drop-remove">Remove After Drop</label>
                            </div>
                            <a href="javascript:void()" data-bs-toggle="modal" data-bs-target="#add-category" class="btn btn-primary btn-event w-100">
                                <span class="align-middle"><i class="ti-plus me-2"></i></span> Create New
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
                            <button type="button" class="btn btn-default waves-effect" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-success save-event waves-effect waves-light">Create
                                event</button>

                            <button type="button" class="btn btn-danger delete-event waves-effect waves-light" data-bs-dismiss="modal">Delete</button>
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
                            <form method="post" action="{{ route('addGymShedule') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="control-label">Event Name</label>
                                        <input class="form-control form-white" placeholder="Enter event name" type="text" name="event_name">
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 5%;">
                                <div class="col-md-6">
                                        <label class="control-label">Recurring</label>
                                        <select class="form-control form-white" data-placeholder="Choose..." name="is_recurring" id="is_recurring">
                                            <option value="" disabled selected>Choose...</option>
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label">Date</label>
                                        <input class="form-control form-white" type="date" name="date" id="date">             
                                        <div id="week_days_section" style="padding-top: 5%; display: none;">
                                        <label class="control-label">Week Day</label>
                                            @foreach(\App\Enums\WeekDaysEnum::getWeekDays() as $key => $day)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="week_days[]" value="{{ $key }}" id="day{{ $key }}">
                                                <label class="form-check-label" for="day{{ $key }}">{{ $day }}</label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 5%;">
                                    <div class="col-md-6">
                                        <label class="control-label">Start Time</label>
                                        <input class="form-control form-white" placeholder="Enter start time" type="time" name="start_time">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label">End Time</label>
                                        <input class="form-control form-white" placeholder="Enter end time" type="time" name="end_time">
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 5%;">
                                    <div class="col-md-12">
                                        <label class="control-label">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter description here..."></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger light waves-effect" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light save-category" data-bs-dismiss="modal">Save</button>
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
    document.addEventListener('DOMContentLoaded', function() {
        const isRecurringSelect = document.getElementById('is_recurring');
        const weekDaySelect = document.getElementById('date');
        const weekDaysSection = document.getElementById('week_days_section');

        isRecurringSelect.addEventListener('change', function() {
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
document.addEventListener('DOMContentLoaded', function() {
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
        events: function(fetchInfo, successCallback, failureCallback) {
            // Perform an AJAX request to fetch the events from the backend
            $.ajax({
                url: "/fetch-gym-schedules",  // Define your route here
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    var events = [];

                    // Loop through the response to format events for FullCalendar
                    response.forEach(function(event) {
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
                error: function(xhr, status, error) {
                    console.error("Error fetching events:", error);
                    failureCallback(error);  // Handle failure
                }
            });
        },
        eventDrop: function(arg) {
            if (document.getElementById('drop-remove').checked) {
                arg.draggedEl.parentNode.removeChild(arg.draggedEl);
            }
        }
    });

    calendar.render();
});

</script>




@endsection