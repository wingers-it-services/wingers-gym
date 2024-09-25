@extends('GymOwner.master')
@section('title', 'Dashboard')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        .list-group {
            --bs-list-group-action-hover-bg: #BCDF9D;
            --bs-list-group-action-active-color: #BCDF9D;
            --bs-list-group-action-active-bg: #BCDF9D;
        }

        .list-group-item.active {
            background-color: #BCDF9D;
            /* Optional text color change */
        }

        .toast-success {
            background-color: #6cc51d;
            /* Set your custom color */
        }

        /* Error Message Background Color */
        .toast-error {
            background-color: #dc3545 !important;
            /* Set your custom color */
        }

        .attendance-menu {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 10px;
            position: absolute;
            z-index: 999;
            width: 150px;
        }

        .attendance-menu .dropdown-item {
            background-color: #8fbc8f;
            border: none;
            color: white;
            cursor: pointer;
            padding: 10px;
            margin: 5px 0;
            text-align: center;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .attendance-menu .dropdown-item:hover {
            background-color: #45a049;
        }

        .attendance-menu .dropdown-item:active {
            background-color: #3e8e41;
        }

        .attendance-menu .dropdown-item:focus {
            outline: none;
        }

        .day {
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-align: center;
            font-weight: bold;
        }

        .day:hover {
            background-color: #ddd;
        }

        .day[style*="background-color"] {
            color: #fff;
            border-radius: 50%;
        }

        .prev,
        .next {
            color: #aaa;
        }
    </style>
    <div class="content-body ">
        <!-- row -->
        <div class="container-fluid">
            <div class="row">
                <div class="card-header d-sm-flex d-block pb-0 border-0">
                    <div class="me-auto pe-3">
                        <h4 class="text-black fs-20">All Member List</h4>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3" style="height: 100vh; overflow-y: auto;">
                    <div class="card shadow-sm">
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                @foreach ($gymUsers as $gymUser)
                                    <a href="javascript:void(0);"
                                        class="list-group-item list-group-item-action d-flex align-items-center"
                                        id="staff-cards" data-gym-id='{{ $gymUser->gym_id }}'
                                        data-user-id='{{ $gymUser->id }}' onclick="showStaffData(this);">
                                        <img src="{{ $gymUser->image }}" alt="" class="rounded-circle me-3"
                                            style="height: 50px; width: 50px; object-fit: cover;">
                                        <div>
                                            <h5 class="mb-0">{{ $gymUser->firstname }} {{ $gymUser->lastname }}</h5>
                                            <small>ID: {{ $gymUser->id }}</small>
                                            <p class="mb-0 text-muted small">Phone: {{ $gymUser->phone_no }}</p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-9" id="default-info-section" style="text-align: center;">
                    <div class="col-xl-12">
                        <div class="card bg-light">
                            <div class="card-body mb-0">
                                <p class="card-text">Click on any Member to see it's attendance.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="userId" class="userId" />

                <div class="col-xl-9 col-lg-8 col-md-12" id="employee-details-section">
                    <div class="card">

                        <div class="card-header d-sm-flex d-block pb-0 border-0">
                            <div class="me-auto pe-3">
                                <h4 class="text-black fs-20">Attendance Details</h4>
                                <p class="fs-13 mb-0 text-black">Monthly details</p>
                            </div>
                            {{-- <div class="dropdown mt-sm-0 mt-3">

                                <button type="button" class="btn btn-primary rounded border border-light dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Mark Present Today
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="javascript:void(0);"
                                        data-gym-id='{{ $gymStaff->gym_id ?? '' }}' data-user-id='{{ $gymStaff->id ?? '' }}'
                                        data-attendance-status='1' onclick="markStaffAttendance(this);">Present</a>

                                    <a class="dropdown-item" href="javascript:void(0);"
                                        data-gym-id='{{ $gymStaff->gym_id ?? '' }}'
                                        data-user-id='{{ $gymStaff->id ?? '' }}' data-attendance-status='0'
                                        onclick="markStaffAttendance(this);">Absent</a>

                                    <a class="dropdown-item" href="javascript:void(0);"
                                        data-gym-id='{{ $gymStaff->gym_id ?? '' }}'
                                        data-user-id='{{ $gymStaff->id ?? '' }}' data-attendance-status='.5'
                                        onclick="markStaffAttendance(this);">Half Day</a>
                                </div>

                            </div> --}}
                        </div>
                        <div class="card-body">
                            @include('GymOwner.custom-calender')
                        </div>

                    </div>
                    <div class="col-xl-4 col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Attendance Chart</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="attendanceChart"></canvas>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>


    <script>
        (function() {
            hideEmployeeDetailsSection();
        })();


        function hideEmployeeDetailsSection() {
            document.getElementById('employee-details-section').style.display = "none";
            document.getElementById('staff-name-section').style.display = "none";
        }

        function hideDefaultInfoSectionSection() {
            document.getElementById('default-info-section').style.display = "none";
        }

        function showStaffData(input) {
            // Remove the "active" class from all list items
            document.querySelectorAll('.list-group-item').forEach(item => {
                item.classList.remove('active');
            });

            // Add the "active" class to the clicked item
            input.classList.add('active');

            // Fetch data attributes
            var gymId = parseInt(input.getAttribute("data-gym-id"));
            var userId = parseInt(input.getAttribute("data-user-id"));

            var userIdFields = document.querySelectorAll('.userId');

            // Loop through each element and set the value
            userIdFields.forEach(function(field) {
                field.value = userId;
            });

            // Fetch the attendance chart or any other data
            fetchAttendanceChart(gymId, userId);

            // Hide the default information section
            hideDefaultInfoSectionSection();

            // Display the staff details in the designated section
            document.getElementById('employee-details-section').style.display = "flex";
        }

        function fetchAttendanceChart(gymId, userId) {
            $.ajax({
                url: "/fetch-user-attendance-chart",
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    gymId: gymId,
                    userId: userId
                },
                success: function(response) {
                    attendanceChart(response.data);
                    attendanceDetails(response.gym);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function attendanceChart(data) {
            let chartStatus = Chart.getChart("attendanceChart"); // <canvas> id
            if (chartStatus != undefined) {
                chartStatus.destroy();
            }

            var xValues = ["Absent", "Holiday", "Weekend", "Present", "Unmarked"];
            var yValues = [data.Absent, data.Holiday, data.Weekend, data.Present, data.Unmarked];
            var barColors = [
                "indianred",
                "grey",
                "lightblue", 
                "darkseagreen",
                "#f1f1fb"
            ];

            var attendanceChart = new Chart("attendanceChart", {
                type: "doughnut",
                data: {
                    labels: xValues,
                    datasets: [{
                        backgroundColor: barColors,
                        data: yValues
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        }

        // Send an AJAX request to update the user's

        function attendanceDetails(data, gymId) {
            const daysContainer = document.querySelector(".days");
            const nextBtn = document.querySelector(".next");
            const prevBtn = document.querySelector(".prev");
            const todayBtn = document.querySelector(".today");
            const month = document.querySelector(".month");
            const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September",
                "October", "November", "December"
            ];

            let currentMonth = new Date().getMonth();
            let currentYear = new Date().getFullYear();
            let holidays = [];
            let weekends = [];

            function renderCalendar() {
                const firstDayOfMonth = new Date(currentYear, currentMonth, 1);
                const lastDayOfMonth = new Date(currentYear, currentMonth + 1, 0);
                const lastDayDate = lastDayOfMonth.getDate();
                const prevLastDay = new Date(currentYear, currentMonth, 0).getDate();
                const startDay = firstDayOfMonth.getDay();
                const nextDays = 7 - lastDayOfMonth.getDay() - 1;

                month.innerHTML = `${months[currentMonth]} ${currentYear}`;
                let daysHtml = "";



                // Days of previous month
                for (let x = startDay; x > 0; x--) {
                    daysHtml += `<div class="day prev">${prevLastDay - x + 1}</div>`;
                }

                for (let i = 1; i <= lastDayDate; i++) {
                    let fullDate =
                        `${currentYear}-${(currentMonth + 1).toString().padStart(2, '0')}-${i.toString().padStart(2, '0')}`;
                    let dayStatus = '';
                    if (data && ('day' + i) in data) {
                        switch (data['day' + i]) {
                            case "0":
                                dayStatus = 'style="background-color: indianred;"';
                                break;
                            case "1":
                                dayStatus = 'style="background-color: darkseagreen;"';
                                break;
                            case "2":
                                dayStatus = 'style="background-color: grey;"';
                                break;
                            default:
                                dayStatus = 'style="background-color: "#f1f1fb";"';
                                break;
                        }
                    }
                    daysHtml +=
                        `<div class="day" data-day="${i}" data-date="${fullDate}" ${dayStatus} onclick="openAttendanceMenu(this, ${i})">${i}</div>`;
                }



                for (let j = 1; j <= nextDays; j++) {
                    daysHtml += `<div class="day next">${j} </div>`;
                }

                daysContainer.innerHTML = daysHtml;
                hideTodayBtn();

                // After rendering, disable holidays and weekends
                disableCalendarColumns(holidays, weekends);
            }


            // Fetch weekends and holidays for the gym
            function fetchHolidaysAndWeekends(gymId) {
                $.ajax({
                    url: '/getGymHolidaysAndWeekendsOnGymAttendance/' + gymId,
                    method: 'GET',
                    success: function(response) {
                        if (response.status === 200) {
                            holidays = response.holidays; // Array of holiday dates (YYYY-MM-DD format)
                            weekends = response
                                .weekends; // Array of weekend days (0 for Sunday, 6 for Saturday)
                            renderCalendar(); // Re-render the calendar with the updated holidays and weekends
                        }
                    },
                    error: function(error) {
                        console.error("Failed to fetch holidays and weekends:", error);
                    }
                });
            }

            // Disable weekends and holidays on the calendar
            function disableCalendarColumns(holidays, weekends) {
                let days = document.querySelectorAll('.day');

                // Create a mapping from day names to numbers
                const dayMapping = {
                    'sunday': 0,
                    'monday': 1,
                    'tuesday': 2,
                    'wednesday': 3,
                    'thursday': 4,
                    'friday': 5,
                    'saturday': 6
                };

                // Convert weekend strings to their corresponding day numbers
                let weekendNumbers = weekends.map(day => dayMapping[day]);

                days.forEach(function(dayElement) {
                    let dayDate = dayElement.dataset.date; // Assume date is stored as data-date="YYYY-MM-DD"

                    let dayOfWeek = new Date(dayDate)
                        .getDay(); // Get the day of the week (0 = Sunday, 6 = Saturday)

                    // Disable entire columns for weekends
                    if (weekendNumbers.includes(dayOfWeek)) {
                        disableColumn(dayOfWeek); // Call function to disable the entire column for this day
                    }

                    // Disable holidays
                    if (holidays.includes(dayDate)) {
                        dayElement.classList.add('disabled');
                        dayElement.style.pointerEvents = 'none';
                        dayElement.style.backgroundColor = '#6c757d'; // Custom color for holidays
                    }
                });
            }

            // Function to disable entire column based on the weekday
            function disableColumn(weekday) {
                let days = document.querySelectorAll('.day');

                days.forEach(function(dayElement) {
                    let dayDate = dayElement.dataset.date;
                    let dayOfWeek = new Date(dayDate).getDay();

                    // Disable all days in the same column (weekday)
                    if (dayOfWeek === weekday) {
                        dayElement.classList.add('disabled');
                        dayElement.style.pointerEvents = 'none';
                        dayElement.style.backgroundColor = '#ccc'; // Custom background for disabled column
                    }
                });
            }


            nextBtn.addEventListener("click", () => {
                currentMonth++;
                if (currentMonth > 11) {
                    currentMonth = 0;
                    currentYear++;
                }
                renderCalendar();
            });

            prevBtn.addEventListener("click", () => {
                currentMonth--;
                if (currentMonth < 0) {
                    currentMonth = 11;
                    currentYear--;
                }
                renderCalendar();
            });

            todayBtn.addEventListener("click", () => {
                currentMonth = date.getMonth();
                currentYear = date.getFullYear();
                renderCalendar();
            });

            function hideTodayBtn() {
                if (
                    currentMonth === new Date().getMonth() &&
                    currentYear === new Date().getFullYear()
                ) {
                    todayBtn.style.display = "none";
                } else {
                    todayBtn.style.display = "flex";
                }
            }

            renderCalendar();

            gymId = {{ $gymUser->gym_id ?? '' }}
            // Initial call to render the calendar and fetch holidays/weekends
            fetchHolidaysAndWeekends(gymId);

        }

        function openAttendanceMenu(dayElement, day) {
            $userId = document.getElementById('userId').value;

            const existingMenu = document.querySelector('.attendance-menu');
            if (existingMenu) {
                existingMenu.remove();
            }

            const attendanceMenu = document.createElement('div');
            attendanceMenu.classList.add('attendance-menu');
            attendanceMenu.innerHTML = `
        <button class="dropdown-item" onclick="markDayAttendance(${day}, 1, {{ $gymUser->gym_id ?? '' }} , $userId)">Present</button>
        <button class="dropdown-item" style="background-color: indianred;" onmouseover="this.style.backgroundColor='#b22222'" onmouseout="this.style.backgroundColor='indianred'" onclick="markDayAttendance(${day}, 0, {{ $gymUser->gym_id ?? '' }}, $userId)">Absent</button>
        <button class="dropdown-item" style="background-color: lightgray;" onmouseover="this.style.backgroundColor='#d3d3d3'" onmouseout="this.style.backgroundColor='lightgray'" onclick="markDayAttendance(${day}, null, {{ $gymUser->gym_id ?? '' }}, $userId)">Unmark</button>
    `;

            document.body.appendChild(attendanceMenu);
            positionAttendanceMenu(dayElement, attendanceMenu);

            document.addEventListener('click', function outsideClickListener(event) {
                if (!attendanceMenu.contains(event.target) && !dayElement.contains(event.target)) {
                    attendanceMenu.remove();
                    document.removeEventListener('click', outsideClickListener);
                }
            });
        }

        function positionAttendanceMenu(dayElement, menu) {
            const rect = dayElement.getBoundingClientRect();
            menu.style.position = 'absolute';
            menu.style.top = `${rect.bottom + window.scrollY}px`;
            menu.style.left = `${rect.left + window.scrollX}px`;
        }

        function markDayAttendance(day, status, gymId, userId) {
            $.ajax({
                url: '/mark-gym-user-attendance',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    gymId: gymId,
                    userId: userId,
                    attendanceStatus: status,
                    day: day
                },
                success: function(response) {
                    const selectedDay = document.querySelector(`.day[data-day='${day}']`);
                    if (status === null) {
                        // Remove any background color when unmarked
                        selectedDay.style.backgroundColor = '#fff';
                    } else {
                        switch (status) {
                            case 1:
                                selectedDay.style.backgroundColor = 'darkseagreen';
                                break;
                            case 0:
                                selectedDay.style.backgroundColor = 'indianred';
                                break;
                        }
                    }

                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "positionClass": "toast-bottom-right", // Changed to bottom-left
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    };
                    toastr.success("Attendance updated for day " + day);
                },
                error: function(error) {
                    console.error(error);
                    toastr.error("Failed to mark attendance.");
                }
            });

            // Remove the dropdown after attendance selection
            const existingMenu = document.querySelector('.attendance-menu');
            if (existingMenu) {
                existingMenu.remove();
            }
        }
    </script>
    <!--**********************************
                                                    Content body end
                                        ***********************************-->
    <script src="{{ asset('js/plugins-init/staff-attendance-overview-chart.js') }}" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    @include('CustomSweetAlert');
@endsection
