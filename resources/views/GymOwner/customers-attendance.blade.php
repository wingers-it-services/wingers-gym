@extends('GymOwner.master')
@section('title', 'Dashboard')
@section('content')

    <!--**********************************
                Content body start
    ***********************************-->
    <div class="content-body ">
        <!-- row -->
        <div class="container-fluid">
            <div class="row">
                <div class="card-header d-sm-flex d-block pb-0 border-0">
                    <div class="me-auto pe-3">
                        <h4 class="text-black fs-20">All Member List</h4>
                        <p class="fs-13 mb-0 text-black">Click on member to see attendance.</p>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3" style="height: 100vh; overflow-y: auto;">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Employee List</h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                @foreach ($gymStaffs as $gymStaff)
                                    <a href="javascript:void(0);"
                                        class="list-group-item list-group-item-action d-flex align-items-center"
                                        id="staff-cards" data-gym-id='{{ $gymStaff->gym_id }}'
                                        data-employee-id='{{ $gymStaff->id }}' data-employee-name='{{ $gymStaff->name }}'
                                        data-employee-email='{{ $gymStaff->email }}'
                                        data-employee-phone-number='{{ $gymStaff->number }}'
                                        data-employee-designation='{{ $gymStaff->designation->designation_name ?? '----' }}'
                                        data-employee-salary='{{ $gymStaff->salary }}'
                                        data-employee-blood-group='{{ $gymStaff->blood_group }}'
                                        data-employee-joining-date='{{ $gymStaff->joining_date }}'
                                        data-employee-address='{{ $gymStaff->address }}' onclick="showStaffData(this);">
                                        <img src="{{ $gymStaff->image }}" alt="" class="rounded-circle me-3"
                                            style="height: 50px; width: 50px; object-fit: cover;">
                                        <div>
                                            <h5 class="mb-0">{{ $gymStaff->firstname }} {{ $gymStaff->lastname }}</h5>
                                            <small>ID: {{ $gymStaff->id }}</small>
                                            <p class="mb-0 text-muted small">Phone: {{ $gymStaff->phone_no }}</p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="default-info-section" style="text-align: center;">
                    <div class="col-xl-8">
                        <div class="card bg-light">
                            {{-- <div class="card-body mb-0">
							<p class="card-text">Click on any Member to see it's attendance.</p>
						</div> --}}
                        </div>
                    </div>
                </div>

                <div class="col-xl-9 col-lg-8 col-md-12" id="employee-details-section">
                    {{-- <div class="col-xl-6 col-md-12">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">Attendance Chart</h4>
							</div>
							<div class="card-body">
								<canvas id="attendanceChart" style="width:100%;max-width:600px"></canvas>
							</div>
						</div>
					</div> --}}
                    <div class="card">
                        <div class="card-header d-sm-flex d-block pb-0 border-0">
                            <div class="me-auto pe-3">
                                <h4 class="text-black fs-20">Attendance Details</h4>
                                <p class="fs-13 mb-0 text-black">Monthly details</p>
                            </div>
                            <div class="dropdown mt-sm-0 mt-3">
                                <button type="button" class="btn btn-primary rounded border border-light dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Mark Present Today
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="javascript:void(0);"
                                        data-gym-id='{{ $gymStaff->gym_id }}' data-employee-id='{{ $gymStaff->id }}'
                                        data-attendance-status='1' onclick="markStaffAttendance(this);">Present</a>
                                    <a class="dropdown-item" href="javascript:void(0);"
                                        data-gym-id='{{ $gymStaff->gym_id }}' data-employee-id='{{ $gymStaff->id }}'
                                        data-attendance-status='0' onclick="markStaffAttendance(this);">Absent</a>
                                    <a class="dropdown-item" href="javascript:void(0);"
                                        data-gym-id='{{ $gymStaff->gym_id }}' data-employee-id='{{ $gymStaff->id }}'
                                        data-attendance-status='.5' onclick="markStaffAttendance(this);">Half Day</a>
                                </div>
                            </div>
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
                    var gymId = parseInt(input.getAttribute("data-gym-id"));
                    var staffId = parseInt(input.getAttribute("data-employee-id"));
                    var staffName = input.getAttribute("data-employee-name");
                    var staffEmail = input.getAttribute("data-employee-email");
                    var staffPhoneNumber = input.getAttribute("data-employee-phone-number");
                    var staffDesignation = input.getAttribute("data-employee-designation");
                    var staffSalary = input.getAttribute("data-employee-salary");
                    var staffBloodGroup = input.getAttribute("data-employee-blood-group");
                    var staffJoiningDate = input.getAttribute("data-employee-joining-date");
                    var staffAddress = input.getAttribute("data-employee-address");

                    var staffIdFields = document.querySelectorAll('.staffId');

                    // Loop through each element and set the value
                    staffIdFields.forEach(function(field) {
                        field.value = staffId;
                    });

                    // Fetch the attendance chart or any other data
                    fetchAttendanceChart(gymId, staffId);

                    // Hide the default information section
                    hideDefaultInfoSectionSection();

                    // Display the staff details in the designated section
                    document.getElementById('employee-details-section').style.display = "flex";
                    document.getElementById('staff-name').innerText = staffName;
                    document.getElementById('staff-name-section').style.display = "contents";

                    // Update the Profile tab with the selected staff's details
                    document.getElementById('profile-name').innerText = staffName;
                    document.getElementById('profile-email').innerText = staffEmail;
                    document.getElementById('profile-phone-number').innerText = staffPhoneNumber;
                    document.getElementById('profile-designation').innerText = staffDesignation;
                    document.getElementById('profile-salary').innerText = staffSalary;
                    document.getElementById('profile-blood-group').innerText = staffBloodGroup;
                    document.getElementById('profile-joining-date').innerText = staffJoiningDate;
                    document.getElementById('profile-address').innerText = staffAddress;
                }

                function markStaffAttendance(input) {
                    var gymId = parseInt(input.getAttribute("data-gym-id"));
                    var employeeId = document.getElementById("staffId").value;
                    var attendanceStatus = input.getAttribute("data-attendance-status");

                    // Send an AJAX request to update the user's status
                    $.ajax({
                        url: '{{ route('markGymStaffAttendance') }}', // Define your update status route
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
                        },
                        data: {
                            gymId: gymId,
                            staffId: employeeId,
                            attendanceStatus: attendanceStatus
                        },
                        success: function(response) {
                            // Handle success response (if needed)
                            console.log(response);
                            toastr.option = {
                                'progressBar': true,
                                "closeButton": true,
                            }
                            toastr.success(" Attendance Marked.");
                            fetchAttendanceChart(gymId, employeeId);
                        },
                        error: function(error) {
                            // Handle error (if needed)
                            console.error(error);
                        }
                    });
                }

                function fetchAttendanceChart(gymId, staffId) {
                    // Send an AJAX request to update the user's status
                    $.ajax({
                        url: '{{ route('fetchAttendanceChart') }}', // Define your update status route
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the headers
                        },
                        data: {
                            gymId: gymId,
                            staffId: staffId
                        },
                        success: function(response) {
                            // Handle success response (if needed)
                            console.log(response.data.Absent);
                            attendanceChart(response.data);
                            attendanceDetails(response.gym);
                        },
                        error: function(error) {
                            // Handle error (if needed)
                            console.log(error);
                        }
                    });
                }

                function attendanceChart(data) {
                    let attendanceChartStatus = Chart.getChart("attendanceChart"); // <canvas> id
                    if (attendanceChartStatus != undefined) {
                        attendanceChartStatus.destroy();
                    }

                    var xValues = ["Absent", "Halfday", "Week Off", "Present", "Unmarked"];
                    var yValues = [data.Absent, data.Halfday, data.WeekOff, data.Present, data.Unmarked];
                    var barColors = [
                        "indianred",
                        "burlywood",
                        "grey",
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

                function attendanceDetails(data) {
                    const daysContainer = document.querySelector(".days");
                    const nextBtn = document.querySelector(".next");
                    const prevBtn = document.querySelector(".prev");
                    const todayBtn = document.querySelector(".today");
                    const month = document.querySelector(".month");

                    const months = [
                        "January",
                        "February",
                        "March",
                        "April",
                        "May",
                        "June",
                        "July",
                        "August",
                        "September",
                        "October",
                        "November",
                        "December",
                    ];

                    const days = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];

                    const date = new Date();
                    let currentMonth = date.getMonth();
                    let currentYear = date.getFullYear();

                    const renderCalendar = () => {
                        date.setDate(1);
                        const firstDay = new Date(currentYear, currentMonth, 1);
                        const lastDay = new Date(currentYear, currentMonth + 1, 0);
                        const lastDayIndex = lastDay.getDay();
                        const lastDayDate = lastDay.getDate();
                        const prevLastDay = new Date(currentYear, currentMonth, 0);
                        const prevLastDayDate = prevLastDay.getDate();
                        const nextDays = 7 - lastDayIndex - 1;

                        month.innerHTML = `${months[currentMonth]} ${currentYear}`;

                        let days = "";

                        for (let x = firstDay.getDay(); x > 0; x--) {
                            days += `<div class="day prev">${prevLastDayDate - x + 1}</div>`;
                        }

                        for (let i = 1; i <= lastDayDate; i++) {
                            if (
                                i === new Date().getDate() &&
                                currentMonth === new Date().getMonth() &&
                                currentYear === new Date().getFullYear()
                            ) {
                                days += `<div class="day today">${i}</div>`;
                            } else {
                                if (data && ('day' + i) in data) {
                                    var dayStatus = '';
                                    switch (data['day' + i]) {
                                        case "0":
                                            dayStatus = 'style="background-color: indianred;"';
                                            break;
                                        case "0.5":
                                            dayStatus = 'style="background-color: burlywood;"';
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
                                days += `<div class="day" ${dayStatus}>${i} </div>`;
                            }
                        }

                        for (let j = 1; j <= nextDays; j++) {
                            days += `<div class="day next">${j} </div>`;
                        }

                        daysContainer.innerHTML = days;
                        hideTodayBtn();
                    };

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
                }
            </script>
            <!--**********************************
                Content body end
    ***********************************-->
            <script src="{{ asset('js/plugins-init/staff-attendance-overview-chart.js') }}" type="text/javascript"></script>


            @include('CustomSweetAlert');
        @endsection
