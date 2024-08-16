@extends('GymOwner.master')
@section('title','Dashboard')
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
					<h4 class="text-black fs-20">All Employee List</h4>
					<p class="fs-13 mb-0 text-black">Click on employe to see details.</p>
				</div>
			</div>
			<div class="col-xl-12">
				<div class="card">
					<div class="card-body">
						<div class="tab-content">
							<div class="tab-pane fade show active" id="Breakfast" role="tabpanel">
								<div class="featured-menus owl-carousel">
									@foreach ($gymStaffs as $gymStaff)
									<div class="items" id="staff-cards" data-gym-id='{{$gymStaff->gym_id}}' data-employee-id='{{$gymStaff->id}}' data-employee-name='{{$gymStaff->name}}' onclick="showStaffData(this);">
										<div class="d-sm-flex p-3 border border-light rounded">
											<img class="me-4 food-image rounded" src="{{ $gymStaff->image }}" alt="" style="height: 160px;">
											<div>
												<div class="d-flex align-items-center mb-2">
													<span class="fs-14 text-primary">{{ $gymStaff->name  }}</span>
												</div>

												<ul>
													<li class="mb-2"><i class="las la-clock scale5 me-3"></i>
														<span class="fs-14 text-black">#{{ $gymStaff->employee_id }}</span>
													</li>
													<li class="mb-2"><i class="las la-clock scale5 me-3"></i>
														<span class="fs-14 text-black">{{ $gymStaff->number }}</span>
													</li>
													<li><i class="fa fa-star me-3 scale5 text-warning" aria-hidden="true"></i><span class="fs-14 text-black font-w500">{{ $gymStaff->name }}</span></li>
												</ul>
											</div>
										</div>
									</div>
									@endforeach
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row" id="default-info-section" style="text-align: center;">
			<div class="col-xl-12">
				<div class="card bg-light">
					<div class="card-body mb-0">
						<p class="card-text">Click on any Staff to see it's details.</p>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-12" id="staff-name-section">
			<div class="card text-white bg-primary">
				<div class="card-header">
					<h5 class="card-title text-white" id="staff-name">Primary card title</h5>
				</div>
			</div>
		</div>
		<div class="row" id="employee-details-section">
			<div class="col-xl-3 col-xxl-4 col-md-6">
				<div class="card">
					<div class="card-header">
						<h4 class="card-title">Attendance Chart</h4>
					</div>
					<div class="card-body">
						<canvas id="attendanceChart" style="width:100%;max-width:600px"></canvas>
					</div>
				</div>
			</div>
			<div class="col-xl-9 col-xxl-8">
				<div class="card">
					<div class="card-header d-sm-flex d-block pb-0 border-0">
						<div class="me-auto pe-3">
							<h4 class="text-black fs-20">Attendance Details</h4>
							<p class="fs-13 mb-0 text-black">Monthly details</p>
						</div>
						<div class="dropdown mt-sm-0 mt-3">

							<button type="button" class="btn btn-primary rounded border border-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
								Mark Present Today
							</button>
							<div class="dropdown-menu dropdown-menu-end">
								<a class="dropdown-item" href="javascript:void(0);" data-gym-id='{{$gymStaff->gym_id}}' data-employee-id='{{$gymStaff->id}}' data-attendance-status='1' onclick="markStaffAttendance(this);">Present</a>

								<a class="dropdown-item" href="javascript:void(0);" data-gym-id='{{$gymStaff->gym_id}}' data-employee-id='{{$gymStaff->id}}' data-attendance-status='0' onclick="markStaffAttendance(this);">Absent</a>

								<a class="dropdown-item" href="javascript:void(0);" data-gym-id='{{$gymStaff->gym_id}}' data-employee-id='{{$gymStaff->id}}' data-attendance-status='.5' onclick="markStaffAttendance(this);">Half Day</a>
							</div>

						</div>
					</div>
					<div class="card-body">
						@include('GymOwner.custom-calender')
					</div>
				</div>
			</div>

			<div class="col-xl-12">
				<div class="card">
					<div class="card-header">
						<h4 class="card-title">Default Tab</h4>
					</div>
					<div class="card-body">
						<!-- Nav tabs -->
						<div class="default-tab">
							<ul class="nav nav-tabs" role="tablist">

								<li class="nav-item">
									<a class="nav-link active" data-bs-toggle="tab" href="#profile"><i class="la la-user me-2"></i> Profile</a>
								</li>
								<!-- <li class="nav-item">
									<a class="nav-link" data-bs-toggle="tab" href="#home"><i class="la la-home me-2"></i> Expenses</a>
								</li> -->
								<li class="nav-item">
									<a class="nav-link" data-bs-toggle="tab" href="#contact"><i class="la la-phone me-2"></i> Documents</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-bs-toggle="tab" href="#assets"><i class="la la-envelope me-2"></i> Assets</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-bs-toggle="tab" href="#leaves"><i class="la la-envelope me-2"></i> Leaves</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-bs-toggle="tab" href="#assets"><i class="la la-envelope me-2"></i> Salary Slip</a>
								</li>
							</ul>
							<div class="tab-content">
								<!-- <div class="tab-pane fade show active" id="home" role="tabpanel">
									<div class="pt-4">
										<h4>This is home title</h4>
										<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove.
										</p>
										<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove.
										</p>
									</div>
								</div> -->
								<div class="tab-pane fade show active" id="profile">
									<div class="pt-4">
										<h4 id="staff-profile-title">Select a staff member to view details</h4>
										<div id="staff-profile-content">
											<!-- Profile details will be dynamically populated here -->
										</div>
									</div>
								</div>

								<div class="tab-pane fade" id="contact">
									<div class="pt-4">
										<h4>This is contact title</h4>
										<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove.
										</p>
										<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove.
										</p>
									</div>
								</div>
								<div class="tab-pane fade" id="assets">
									<div class="pt-4">
										<div class="col-xl-12 col-lg-12 col-xxl-12 col-sm-12">
											<div class="card">
												<div class="card-body">
													<div class="table-responsive recentOrderTable">
														<table class="table verticle-middle table-responsive-md">
															<thead>
																<tr>
																	<th scope="col">Asset No.</th>
																	<th scope="col">Asset Name</th>
																	<th scope="col">Asset Category</th>
																	<th scope="col">Asset Tag</th>
																	<th scope="col">Date Of Allocation</th>
																	<th scope="col">Price</th>
																	<th scope="col">Status</th>
																	<th scope="col">Image</th>
																	<th scope="col">Action</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>12</td>
																	<td>Mr. Bobby</td>
																	<td>Dr. Jackson</td>
																	<td>Dr. Jackson</td>
																	<td>01 August 2020</td>
																	<td>$5000</td>
																	<td><span class="badge badge-rounded badge-primary">Checkin</span></td>
																	<td>$120</td>
																	<td>
																		<div class="dropdown custom-dropdown mb-0">
																			<div class="btn sharp btn-primary tp-btn" data-bs-toggle="dropdown">
																				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewBox="0 0 24 24" version="1.1">
																					<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																						<rect x="0" y="0" width="24" height="24" />
																						<circle fill="#000000" cx="12" cy="5" r="2" />
																						<circle fill="#000000" cx="12" cy="12" r="2" />
																						<circle fill="#000000" cx="12" cy="19" r="2" />
																					</g>
																				</svg>
																			</div>
																			<div class="dropdown-menu dropdown-menu-end">
																				<a class="dropdown-item" href="javascript:void(0);">Details</a>
																				<a class="dropdown-item text-danger" href="javascript:void(0);">Cancel</a>
																			</div>
																		</div>
																	</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="leaves">
									<div class="pt-4">
										<div class="col-xl-12 col-lg-12 col-xxl-12 col-sm-12">
											<div class="card">
												<div class="card-body">
													<div class="table-responsive recentOrderTable">
														<table class="table verticle-middle table-responsive-md">
															<thead>
																<tr>
																	<th scope="col">Leave Name</th>
																	<th scope="col">From</th>
																	<th scope="col">To</th>
																	<!-- <th scope="col">Asset Tag</th>
																	<th scope="col">Date Of Allocation</th>
																	<th scope="col">Price</th>
																	<th scope="col">Status</th> -->
																	<!-- <th scope="col">Image</th> -->
																	<th scope="col">Action</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>Full Day</td>
																	<td>01 August 2020</td>
																	<td>01 August 2020</td>
																	<!-- <td>01 August 2020</td>
																	<td>$5000</td>
																	<td><span class="badge badge-rounded badge-primary">Checkin</span></td>-->
																	<!-- <td>$120</td>  -->
																	<td>
																		<div class="dropdown custom-dropdown mb-0">
																			<div class="btn sharp btn-primary tp-btn" data-bs-toggle="dropdown">
																				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewBox="0 0 24 24" version="1.1">
																					<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																						<rect x="0" y="0" width="24" height="24" />
																						<circle fill="#000000" cx="12" cy="5" r="2" />
																						<circle fill="#000000" cx="12" cy="12" r="2" />
																						<circle fill="#000000" cx="12" cy="19" r="2" />
																					</g>
																				</svg>
																			</div>
																			<div class="dropdown-menu dropdown-menu-end">
																				<a class="dropdown-item" href="javascript:void(0);">Details</a>
																				<a class="dropdown-item text-danger" href="javascript:void(0);">Cancel</a>
																			</div>
																		</div>
																	</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
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
		var gymId = parseInt(input.getAttribute("data-gym-id"));
		var staffId = parseInt(input.getAttribute("data-employee-id"));
		var staffName = input.getAttribute("data-employee-name");

		// Fetch the attendance chart or any other data
		fetchAttendanceChart(gymId, staffId);

		// Hide the default information section
		hideDefaultInfoSectionSection();

		// Display the staff details in the designated section
		document.getElementById('employee-details-section').style.display = "flex";
		document.getElementById('staff-name').innerText = staffName;
		document.getElementById('staff-name-section').style.display = "contents";

		// Update the Profile tab with the selected staff's details
		document.getElementById('staff-profile-title').innerText = staffName + " Profile";
		document.getElementById('staff-profile-content').innerHTML = `
        <img src="${input.getAttribute('data-employee-image')}" alt="${staffName}" style="height: 160px;" class="me-4 food-image rounded">
        <ul>
            <li><strong>ID:</strong> ${staffId}</li>
            <li><strong>Name:</strong> ${staffName}</li>
            <li><strong>Number:</strong> ${input.getAttribute('data-employee-number')}</li>
        </ul>
    `;

		// Optionally switch to the profile tab if not already there
		var profileTab = document.querySelector('.nav-link[href="#profile"]');
		var tabInstance = new bootstrap.Tab(profileTab);
		tabInstance.show();
	}


	function markStaffAttendance(input) {
		var gymId = parseInt(input.getAttribute("data-gym-id"));
		var employeeId = input.getAttribute("data-employee-id");
		var attendanceStatus = input.getAttribute("data-attendance-status");

		// Send an AJAX request to update the user's status
		$.ajax({
			url: '{{ route("markGymStaffAttendance") }}', // Define your update status route
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
			url: '{{ route("fetchAttendanceChart") }}', // Define your update status route
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
<script src="{{asset('js/plugins-init/staff-attendance-overview-chart.js')}}" type="text/javascript"></script>



@endsection