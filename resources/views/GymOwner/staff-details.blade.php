@extends('GymOwner.master')
@section('title', 'Staff Details')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<style>
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
<!--**********************************
            Content body start
***********************************-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet"
	href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css">

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
										<div class="items" id="staff-cards" data-gym-id='{{$gymStaff->gym_id}}'
											data-employee-id='{{$gymStaff->id}}' data-employee-name='{{$gymStaff->name}}'
											data-employee-email='{{$gymStaff->email}}'
											data-employee-phone-number='{{$gymStaff->number}}'
											data-employee-designation='{{ $gymStaff->designation->designation_name ?? '----' }}'
											data-employee-salary='{{$gymStaff->salary}}'
											data-employee-blood-group='{{$gymStaff->blood_group}}'
											data-employee-joining-date='{{$gymStaff->joining_date}}'
											data-employee-address='{{$gymStaff->address}}' onclick="showStaffData(this);">
											<div class="d-sm-flex p-3 border border-light rounded">
												<img class="me-4 food-image rounded" src="{{ $gymStaff->image }}" alt=""
													style="height: 160px;">
												<div>
													<div class="d-flex align-items-center mb-2">
														<span class="fs-14 text-primary">{{ $gymStaff->name  }}</span>
													</div>

													<ul>
														<li class="mb-2"><i class="las la-clock scale5 me-3"></i>
															<span
																class="fs-14 text-black">#{{ $gymStaff->employee_id }}</span>
														</li>
														<li class="mb-2"><i class="las la-clock scale5 me-3"></i>
															<span class="fs-14 text-black">{{ $gymStaff->number }}</span>
														</li>
														<li><i class="fa fa-star me-3 scale5 text-warning"
																aria-hidden="true"></i><span
																class="fs-14 text-black font-w500">{{ $gymStaff->name }}</span>
														</li>
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
					</div>
					<div class="card-body">
						@include('GymOwner.custom-calender')
					</div>
				</div>
			</div>

			<div class="col-xl-12">
				<div class="card">
					<div class="card-header">
						<h4 class="card-title">Staff Details</h4>
					</div>
					<div class="card-body">
						<!-- Nav tabs -->
						<div class="default-tab">
							<ul class="nav nav-tabs" role="tablist">

								<li class="nav-item">
									<a class="nav-link active" data-bs-toggle="tab" href="#profile">
										<i class="la la-user me-2"></i> Profile</a>
								</li>

								<li class="nav-item">
									<a class="nav-link" data-bs-toggle="tab" href="#contact">
										<i class="la la-file me-2"></i> Documents
									</a>
								</li>

								<li class="nav-item">
									<a class="nav-link" data-bs-toggle="tab" href="#assets">
										<i class="la la-briefcase me-2"></i> Assets
									</a>
								</li>

								<li class="nav-item">
									<a class="nav-link" data-bs-toggle="tab" href="#leaves">
										<i class="la la-calendar me-2"></i> Leaves
									</a>
								</li>

								<li class="nav-item">
									<a class="nav-link" data-bs-toggle="tab" href="#slip">
										<i class="la la-file-invoice-dollar me-2"></i> Salary Slip</a>
								</li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane fade show active" id="profile">
									<div class="pt-4">

									</div>
									<div class="row">
										<div class="col-xl-6 col-lg-12 col-sm-12">
											<div class="card overflow-hidden">
												<ul class="list-group list-group-flush">
													<li class="list-group-item d-flex justify-content-between"><span
															class="mb-0">Name:</span> <strong class="text-muted"
															id="profile-name"></strong></li>
													<li class="list-group-item d-flex justify-content-between"><span
															class="mb-0">Email:</span> <strong class="text-muted"
															id="profile-email"></strong></li>
													<li class="list-group-item d-flex justify-content-between"><span
															class="mb-0">Phone Number:</span> <strong class="text-muted"
															id="profile-phone-number"></strong></li>
													<li class="list-group-item d-flex justify-content-between"><span
															class="mb-0">Designation:</span> <strong class="text-muted"
															id="profile-designation"></strong></li>
												</ul>
											</div>
										</div>
										<div class="col-xl-6 col-lg-12 col-sm-12">
											<div class="card overflow-hidden">
												<ul class="list-group list-group-flush">
													<li class="list-group-item d-flex justify-content-between"><span
															class="mb-0">Salary:</span> <strong class="text-muted"
															id="profile-salary"></strong></li>
													<li class="list-group-item d-flex justify-content-between"><span
															class="mb-0">Blood Group:</span> <strong class="text-muted"
															id="profile-blood-group"></strong></li>
													<li class="list-group-item d-flex justify-content-between"><span
															class="mb-0">Joining Date:</span> <strong class="text-muted"
															id="profile-joining-date"></strong></li>
													<li class="list-group-item d-flex justify-content-between"><span
															class="mb-0">Address:</span> <strong class="text-muted"
															id="profile-address"></strong></li>
												</ul>
											</div>
										</div>

									</div>
								</div>

								<div class="tab-pane fade" id="contact">
									<div class="modal fade" id="addDoc" tabindex="-1" aria-labelledby="addNewDocLabel"
										aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="addNewDocsLabel">Add Document</h5>
													<button type="button" class="btn-close" data-bs-dismiss="modal"
														aria-label="Close"></button>
												</div>
												<form action="{{route('addStaffDocuments')}}" method="POST"
													enctype="multipart/form-data" class="needs-validation" novalidate>
													@csrf
													<div class="modal-body">
														<!-- Hidden field for staff ID -->
														<input type="hidden" class="form-control staffId" id="staffId"
															name="staff_id">

														<div class="mb-3">
															<label for="document_name" class="form-label">File
																Name</label>
															<input type="text" class="form-control" id="document_name"
																name="document_name" required>
															<div class="invalid-feedback">
																Document Name is required.
															</div>
														</div>

														<!-- Aadhar Card Upload -->
														<div class="mb-3">
															<label for="file" class="form-label">Choose File</label>
															<input type="file" class="form-control" id="file"
																name="file" accept=".pdf, .jpg, .jpeg"
																onchange="previewFile(this, 'aadhaarCardPreview')"
																required>
															<img id="aadhaarCardPreview" class="img-preview mt-2"
																src="#" alt="Aadhar Card Preview"
																style="display: none; max-width: 100%; height: auto; border: 1px solid #ddd; padding: 5px;">
															<div class="invalid-feedback">
																Document file is required.
															</div>
														</div>
													</div>

													<div class="modal-footer">
														<button type="button" class="btn btn-secondary"
															data-bs-dismiss="modal">Close</button>
														<button type="submit" class="btn btn-primary">Save
															Document</button>
													</div>
												</form>
											</div>
										</div>
									</div>
									<div class="card-header d-sm-flex d-block pb-0 border-0">
										<div class="me-auto pe-3">
											<h4 class="text-black fs-20"> Documents </h4>
										</div>

										<div class="dropdown mt-sm-0 mt-3">
											<a href="javascript:void(0);" data-bs-toggle="modal"
												data-bs-target="#addDoc" class="btn btn-outline-primary rounded">Add
												Document</a>
										</div>

									</div>
									<div class="pt-4">
										<form action="" method="post" enctype="multipart/form-data">
											@csrf
											<div class="table-responsive docTable">
												<table id="documentTable"
													class="table verticle-middle table-responsive-md">
													<thead>
														<tr>
															<th scope="col">Document Name</th>
															<th class="text-center">Download File</th>
															<th scope="col">Status</th>
													</thead>

													<tbody>

													</tbody>
												</table>
											</div>
											<input type="number" name="staff_id" hidden>
										</form>
									</div>
								</div>
								<div class="tab-pane fade" id="assets">
									<!-- Add New Asset Modal -->
									<div class="modal fade" id="addNewAssets" tabindex="-1"
										aria-labelledby="addNewAssetsLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="addNewAssetsLabel">Add New Asset</h5>
													<button type="button" class="btn-close" data-bs-dismiss="modal"
														aria-label="Close"></button>
												</div>
												<form id="assetsForm" action="/add-staff-asset" method="POST"
													enctype="multipart/form-data" enctype="multipart/form-data"
													class="needs-validation" novalidate>
													@csrf
													<div class="modal-body">
														<input type="hidden" class="form-control staffId" id="staffId"
															name="staff_id">
														<div class="mb-3">
															<label for="assetName" class="form-label">Asset Name</label>
															<input type="text" class="form-control" id="assetName"
																name="name" required>
															<div class="invalid-feedback">
																Asset Name is required.
															</div>
														</div>
														<div class="mb-3">
															<label for="assetCategory" class="form-label">Asset
																Category</label>
															<input type="text" class="form-control" id="assetCategory"
																name="category" required>
															<div class="invalid-feedback">
																Asset Category is required.
															</div>
														</div>
														<div class="mb-3">
															<label for="assetTag" class="form-label">Asset Tag</label>
															<input type="text" class="form-control" id="assetTag"
																name="asset_tag" required>
															<div class="invalid-feedback">
																Asset Tag is required.
															</div>
														</div>
														<div class="mb-3">
															<label for="dateOfAllocation" class="form-label">Date Of
																Allocation</label>
															<input type="date" class="form-control"
																id="dateOfAllocation" name="allocation_date" required>
															<div class="invalid-feedback">
																Date Of Allocation is required.
															</div>
														</div>
														<div class="mb-3">
															<label for="price" class="form-label">Price</label>
															<input type="number" class="form-control" id="price"
																name="price" required>
															<small id="priceError"
																style="color: red; display: none;">Enter valid
																Price</small>
															<div class="invalid-feedback">
																Price is required.
															</div>
														</div>
														<div class="mb-3">
															<label for="status" class="form-label">Status</label>
															<select class="form-control" id="status" name="status"
																required>
																<option value="">Select Status</option>
																<option
																	value="{{ \App\Enums\GymStaffAssetStatusEnum::ALLOCATED }}">
																	Allocated</option>
																<option
																	value="{{ \App\Enums\GymStaffAssetStatusEnum::UNDER_REPAIR }}">
																	Under Repair</option>
																<option
																	value="{{ \App\Enums\GymStaffAssetStatusEnum::RETIRED }}">
																	Retired</option>
															</select>
															<div class="invalid-feedback">
																Status is required.
															</div>
														</div>
														<div class="mb-3">
															<label for="assetImage" class="form-label">Asset
																Image</label>
															<input type="file" class="form-control" id="assetImage"
																name="image" required>
															<div class="invalid-feedback">
																Asset Image is required.
															</div>
														</div>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary"
															data-bs-dismiss="modal">Close</button>
														<button type="submit" class="btn btn-primary">Save
															Asset</button>
													</div>
												</form>
											</div>
										</div>
									</div>

									<div class="pt-4">
										<div class="col-xl-12 col-lg-12 col-xxl-12 col-sm-12">
											<div class="card">
												<div class="card-header d-sm-flex d-block pb-0 border-0">
													<div class="me-auto pe-3">
														<h4 class="text-black fs-20">Staff Asset List</h4>
													</div>

													<div class="dropdown mt-sm-0 mt-3">
														<a href="javascript:void(0);" data-bs-toggle="modal"
															data-bs-target="#addNewAssets"
															class="btn btn-outline-primary rounded">Add Assets</a>
													</div>
												</div>
												<div class="card-body">
													<div class="table-responsive recentOrderTable">
														<table id="assetTable"
															class="table verticle-middle table-responsive-md">
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
																</tr>
															</thead>
															<tbody>
																<!-- Asset rows will be dynamically injected here -->
															</tbody>
														</table>
													</div>

												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="leaves">
									<div class="modal fade" id="addNewLeaves" tabindex="-1"
										aria-labelledby="addNewLeaveLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="addNewLeaveLabel">Add New Leave</h5>
													<button type="button" class="btn-close" data-bs-dismiss="modal"
														aria-label="Close"></button>
												</div>
												<form id="leaveForm" action="/add-staff-leave" method="POST"
													class="needs-validation" novalidate>
													@csrf
													<div class="modal-body">
														<input type="hidden" class="form-control staffId" id="staffId"
															name="staff_id">
														<div class="mb-3">
															<div class="form-group">
																<label for="leave_type" class="form-label">Leave
																	Type</label>
																<select class="form-control" id="leave_type"
																	name="leave_type" required>
																	<option value="">Select Leave Type</option>
																	<option value="Sick Leave">Sick Leave</option>
																	<option value="Vacation">Vacation</option>
																	<option value="Unpaid Leave">Unpaid Leave</option>
																</select>
																<div class="invalid-feedback">
																	Choose a Leave Type.
																</div>
															</div>
														</div>
														<div class="mb-3">
															<label for="start_date" class="form-label">Start
																Date</label>
															<input type="date" class="form-control" id="start_date"
																name="start_date" required>
															<small id="start_date_error"
																style="color: red; display: none;">
																Start Date must be today or later.
															</small>
															<div class="invalid-feedback">
																Start Date is required.
															</div>
														</div>
														<div class="mb-3">
															<label for="end_date" class="form-label">End Date</label>
															<input type="date" class="form-control" id="end_date"
																name="end_date" required>
															<small id="end_date_error"
																style="color: red; display: none;">
																End Date must be after the Start Date.
															</small>
															<div class="invalid-feedback">
																End Date is required.
															</div>
														</div>
														<div class="mb-3">
															<label for="reason" class="form-label">Reason for
																Leave</label>
															<textarea class="form-control" id="reason" name="reason"
																rows="3" required></textarea>
															<div class="invalid-feedback">
																Reason is required.
															</div>
														</div>
														<div class="mb-3">
															<div class="form-group">
																<label for="status" class="form-label">Leave
																	Status</label>
																<select class="form-control" id="status" name="status"
																	required>
																	<option value="">Select Leave Status</option>
																	<option
																		value="{{ \App\Enums\LeaveStatusEnum::ACCEPTED }}">
																		Accepted</option>
																	<option
																		value="{{ \App\Enums\LeaveStatusEnum::REJECTED }}">
																		Rejected</option>
																	<option
																		value="{{ \App\Enums\LeaveStatusEnum::PENDING }}">
																		Pending</option>
																</select>
																<div class="invalid-feedback">
																	Choose a Leave Status.
																</div>
															</div>
														</div>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary"
															data-bs-dismiss="modal">Close</button>
														<button type="submit" class="btn btn-primary">Save
															Leave</button>
													</div>
												</form>
											</div>
										</div>
									</div>
									<div class="pt-4">
										<div class="col-xl-12 col-lg-12 col-xxl-12 col-sm-12">
											<div class="card">
												<div class="card-header d-sm-flex d-block pb-0 border-0">
													<div class="me-auto pe-3">
														<h4 class="text-black fs-20">Staff Leaves List</h4>
													</div>

													<div class="dropdown mt-sm-0 mt-3">
														<a href="javascript:void(0);" data-bs-toggle="modal"
															data-bs-target="#addNewLeaves"
															class="btn btn-outline-primary rounded">Add Leaves</a>
													</div>
												</div>
												<div class="card-body">
													<div class="table-responsive recentOrderTable">
														<table id="leaveTable"
															class="table verticle-middle table-responsive-md">
															<thead>
																<tr>
																	<th scope="col">Leave Type</th>
																	<th scope="col">From</th>
																	<th scope="col">To</th>
																	<th scope="col">Reason</th>
																	<th scope="col">Status</th>
																</tr>
															</thead>
															<tbody>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="slip">
									<div class="pt-4">
										<h4>This is contact title</h4>
										<p>Far far away, behind the word mountains, far from the countries Vokalia and
											Consonantia, there live the blind texts. Separated they live in
											Bookmarksgrove.
										</p>
										<p>Far far away, behind the word mountains, far from the countries Vokalia and
											Consonantia, there live the blind texts. Separated they live in
											Bookmarksgrove.
										</p>
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

	(function () {
		hideEmployeeDetailsSection();

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
		staffIdFields.forEach(function (field) {
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

		// Optionally switch to the profile tab if not already there
		var profileTab = document.querySelector('.nav-link[href="#profile"]');
		var tabInstance = new bootstrap.Tab(profileTab);
		tabInstance.show();

		// Fetch asset data for the selected staff member
		fetchAssetData(staffId);
		fetchLeaveData(staffId);
		fetchDocumentData(staffId);
	}

	function fetchAssetData(staffId) {
		// Make an AJAX request to fetch the asset data
		fetch(`/gym-staff-assets/` + staffId)
			.then(response => response.json())
			.then(data => {
				// Assuming 'data' contains the asset information
				displayAssetData(data);
			})
			.catch(error => {
				console.error('Error fetching asset data:', error);
			});
	}

	function displayAssetData(assets) {
		var assetTableBody = document.querySelector('#assetTable tbody');
		const statusTextMap = {
			0: 'Allocated',
			1: 'Under Repair',
			2: 'Retired'
		};
		const statusClassMap = {
			0: 'badge-primary', // Allocated (Blue)
			1: 'badge-warning', // Under Repair (Yellow)
			2: 'badge-secondary' // Retired (Gray)
		};

		// Clear any existing asset rows
		assetTableBody.innerHTML = '';

		// Loop through each asset and create table rows
		assets.forEach(asset => {
			var row = document.createElement('tr');

			row.innerHTML = `
            <td>${asset.id}</td>
            <td>${asset.name}</td>
            <td>${asset.category}</td>
            <td>${asset.asset_tag}</td>
            <td>${asset.allocation_date}</td>
            <td>${asset.price}</td>
            <td>
                <form action="/update-asset-status/${asset.id}" method="GET">
                    <select name="status" class="form-select" onchange="this.form.submit()" style="min-width: 150px;">
                        <option value="{{ \App\Enums\GymStaffAssetStatusEnum::ALLOCATED }}" ${asset.status == 0 ? 'selected' : ''}>Allocated</option>
                        <option value="{{ \App\Enums\GymStaffAssetStatusEnum::UNDER_REPAIR }}" ${asset.status == 1 ? 'selected' : ''}>Under Repair</option>
                        <option value="{{ \App\Enums\GymStaffAssetStatusEnum::RETIRED }}" ${asset.status == 2 ? 'selected' : ''}>Retired</option>
                    </select>
                    <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                </form>
            </td>
            <td><img src="${asset.image}" alt="" style="height: 50px;"></td>
        `;

			assetTableBody.appendChild(row);
		});
	}



	function fetchLeaveData(staffId) {
		// Make an AJAX request to fetch the asset data
		fetch(`/gym-staff-leaves/` + staffId)
			.then(response => response.json())
			.then(data => {
				// Assuming 'data' contains the asset information
				displayLeaveData(data);
			})
			.catch(error => {
				console.error('Error fetching leave data:', error);
			});
	}

	function displayLeaveData(leaves) {
		var leaveTableBody = document.querySelector('#leaveTable tbody');
		const statusTextMap = {
			0: 'Pending',
			1: 'Rejected',
			2: 'Accepted'
		};

		const statusClassLeaveMap = {
			0: 'badge-warning', // Pending (Yellow)
			1: 'badge-danger', // Rejected (Red)
			2: 'badge-success' // Accepted (Green)
		};

		// Clear any existing rows
		leaveTableBody.innerHTML = '';

		// Loop through each leave and create table rows
		leaves.forEach(leave => {
			var row = document.createElement('tr');

			row.innerHTML = `
            <td>${leave.leave_type}</td>
            <td>${leave.start_date}</td>
            <td>${leave.end_date}</td>
            <td>${leave.reason}</td>
            <td>
				<form action="/update-leave-status/${leave.id}" method="GET">
                    <select name="status" class="form-select" onchange="this.form.submit()" style="width: 120px;">
                        <option value="{{ \App\Enums\LeaveStatusEnum::ACCEPTED }}" ${leave.status == 2 ? 'selected' : ''} >Accepted</option>
                        <option value="{{ \App\Enums\LeaveStatusEnum::PENDING }}" ${leave.status == 0 ? 'selected' : ''}>Pending</option>
                        <option value="{{ \App\Enums\LeaveStatusEnum::REJECTED }}" ${leave.status == 1 ? 'selected' : ''}>Rejected</option>
                    </select>
                    <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                </form>
            </td>
        `;

			leaveTableBody.appendChild(row);
		});
	}

	function fetchDocumentData(staffId) {
		// Make an AJAX request to fetch the asset data
		fetch(`/gym-staff-documents/` + staffId)
			.then(response => response.json())
			.then(data => {
				// Assuming 'data' contains the asset information
				displayDocumentData(data);
			})
			.catch(error => {
				console.error('Error fetching document data:', error);
			});
	}

	function displayDocumentData(docs) {
		var documentTableBody = document.querySelector('#documentTable tbody');

		// Clear any existing asset rows
		documentTableBody.innerHTML = '';

		// Loop through each asset and create table rows
		docs.forEach(docs => {
			var row = document.createElement('tr');

			row.innerHTML = `
            <td>${docs.document_name}</td>
			<td class="text-center align-middle">
    			<a href="${docs.file}" download> <i class="fas fa-download icon"></i></a>
			</td>

            <td>
				<form action="/update-document-status/${docs.id}" method="GET" style="width:60%;">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="{{ \App\Enums\GymStaffDocumentStatusEnum::VERIFY }}" ${docs.status == 1 ? 'selected' : ''} >Verify</option>
                        <option value="{{ \App\Enums\GymStaffDocumentStatusEnum::NOTVERIFY }}" ${docs.status == 0 ? 'selected' : ''}>Not Verify</option>

                    </select>
                    <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                </form>
            </td>
        `;

			documentTableBody.appendChild(row);
		});
	}

	function previewFile(input, previewId, iconId) {
		const file = input.files[0];
		const previewElement = document.getElementById(previewId);
		const iconElement = document.getElementById(iconId);

		if (file) {
			const reader = new FileReader();

			if (file.type.startsWith('image/')) {
				reader.onload = function (e) {
					previewElement.src = e.target.result;
					previewElement.style.display = 'block'; // Show the image preview
				};
				reader.readAsDataURL(file);
			} else if (file.type === 'application/pdf') {
				previewElement.style.display = 'none'; // Hide the image preview
			} else {
				previewElement.style.display = 'none'; // Hide the image preview
			}
		} else {
			previewElement.src = '#';
			previewElement.style.display = 'none'; // Hide the image preview
		}
	}


	const StaffAttendanceStatusEnum = {
		PRESENT: {{ \App\Enums\StaffAttendanceStatusEnum::PRESENT }},
		ABSENT: {{ \App\Enums\StaffAttendanceStatusEnum::ABSENT }},
		WEEKEND: {{ \App\Enums\StaffAttendanceStatusEnum::WEEKEND }},
		HOLIDAY: {{ \App\Enums\StaffAttendanceStatusEnum::HOLIDAY }},
		HALFDAY: {{ \App\Enums\StaffAttendanceStatusEnum::HALFDAY }}

    };


	function fetchAttendanceChart(gymId, staffId) {
		// Send an AJAX request to fetch attendance chart data
		$.ajax({
			url: '{{ route("fetchAttendanceChart") }}',
			method: 'POST',
			headers: {
				'X-CSRF-TOKEN': '{{ csrf_token() }}'
			},
			data: {
				gymId: gymId,
				staffId: staffId
			},
			success: function (response) {
				attendanceChart(response.data);
				attendanceDetails(response.gym);
			},
			error: function (error) {
				console.error(error);
			}
		});
	}

	function attendanceChart(data) {
		let chartStatus = Chart.getChart("attendanceChart"); // <canvas> id
		if (chartStatus != undefined) {
			chartStatus.destroy(); // Destroy if chart exists
		}

		var xValues = ["Absent", "Halfday", "Week Off", "Holiday", "Present", "Unmarked"];
		var yValues = [data.Absent, data.Halfday, data.Weekend, data.Holiday, data.Present, data.Unmarked];
		var barColors = ["indianred", "burlywood", "grey", "lightblue", "darkseagreen", "#f1f1fb"];

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

	function attendanceDetails(data, gymId) {

		const daysContainer = document.querySelector(".days");
		const nextBtn = document.querySelector(".next");
		const prevBtn = document.querySelector(".prev");
		const todayBtn = document.querySelector(".today");
		const month = document.querySelector(".month");
		const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

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

			// Days of the current month
			for (let i = 1; i <= lastDayDate; i++) {
				let fullDate = `${currentYear}-${(currentMonth + 1).toString().padStart(2, '0')}-${i.toString().padStart(2, '0')}`;
				let dayStatus = '';
				if (data && ('day' + i) in data) {
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
							dayStatus = 'style="background-color: #f1f1fb;"';
					}
				}

				daysHtml += `<div class="day" data-day="${i}" data-date="${fullDate}" ${dayStatus} onclick="openAttendanceMenu(this, ${i})">${i}</div>`;
			}

			// Next month's days
			for (let j = 1; j <= nextDays; j++) {
				daysHtml += `<div class="day next">${j}</div>`;
			}

			daysContainer.innerHTML = daysHtml;
			hideTodayBtn();

			// After rendering, disable holidays and weekends
			disableCalendarColumns(holidays, weekends);
		}

		// Fetch weekends and holidays for the gym
		function fetchHolidaysAndWeekends(gymId) {
			$.ajax({
				url: '/getGymHolidaysAndWeekends/' + gymId,
				method: 'GET',
				success: function (response) {
					if (response.status === 200) {
						holidays = response.holidays;  // Array of holiday dates (YYYY-MM-DD format)
						weekends = response.weekends;  // Array of weekend days (0 for Sunday, 6 for Saturday)
						renderCalendar();  // Re-render the calendar with the updated holidays and weekends
					}
				},
				error: function (error) {
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

			days.forEach(function (dayElement) {
				let dayDate = dayElement.dataset.date;  // Assume date is stored as data-date="YYYY-MM-DD"
				let dayOfWeek = new Date(dayDate).getDay(); // Get the day of the week (0 = Sunday, 6 = Saturday)

				// Disable entire columns for weekends
				if (weekendNumbers.includes(dayOfWeek)) {
					disableColumn(dayOfWeek); // Call function to disable the entire column for this day
				}

				// Disable holidays
				if (holidays.includes(dayDate)) {
					dayElement.classList.add('disabled');
					dayElement.style.pointerEvents = 'none';
					dayElement.style.backgroundColor = 'lightblue'; // Custom color for holidays
				}
			});
		}

		// Function to disable entire column based on the weekday
		function disableColumn(weekday) {
			let days = document.querySelectorAll('.day');

			days.forEach(function (dayElement) {
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


		// Event listeners for next, prev, and today buttons
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
			currentMonth = new Date().getMonth();
			currentYear = new Date().getFullYear();
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


		gymId ={{$gymStaff->gym_id ?? ''}}
			// Initial call to render the calendar and fetch holidays/weekends
			fetchHolidaysAndWeekends(gymId);
	}


	function openAttendanceMenu(dayElement, day) {
		$staffId = document.getElementById('staffId').value;
		const existingMenu = document.querySelector('.attendance-menu');
		if (existingMenu) {
			existingMenu.remove();
		}

		const attendanceMenu = document.createElement('div');
		attendanceMenu.classList.add('attendance-menu');
		attendanceMenu.innerHTML = `
        <button class="dropdown-item" onclick="markDayAttendance(${day}, StaffAttendanceStatusEnum.PRESENT, {{$gymStaff->gym_id ?? ''}} , $staffId)">Present</button>
        <button class="dropdown-item" style="background-color: indianred;" onmouseover="this.style.backgroundColor='#b22222'" onmouseout="this.style.backgroundColor='indianred'" onclick="markDayAttendance(${day}, StaffAttendanceStatusEnum.ABSENT, {{$gymStaff->gym_id ?? ''}}, $staffId)">Absent</button>
        <button class="dropdown-item" style="background-color: burlywood;" onmouseover="this.style.backgroundColor='#de9b44'" onmouseout="this.style.backgroundColor='burlywood'" onclick="markDayAttendance(${day}, StaffAttendanceStatusEnum.HALFDAY, {{$gymStaff->gym_id ?? ''}}, $staffId)">Half Day</button>
        <button class="dropdown-item" style="background-color: lightgray;" onmouseover="this.style.backgroundColor='#d3d3d3'" onmouseout="this.style.backgroundColor='lightgray'" onclick="markDayAttendance(${day}, null, {{$gymStaff->gym_id ?? ''}}, $staffId)">Unmark</button>
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

	function markDayAttendance(day, status, gymId, employeeId) {
		$.ajax({
			url: '{{ route("markGymStaffAttendance") }}',
			method: 'POST',
			headers: {
				'X-CSRF-TOKEN': '{{ csrf_token() }}'
			},
			data: {
				gymId: gymId,
				staffId: employeeId,
				attendanceStatus: status,
				day: day
			},
			success: function (response) {
				const selectedDay = document.querySelector(`.day[data-day='${day}']`);
				if (status === null) {
					// Remove any background color when unmarked
					selectedDay.style.backgroundColor = '#fff';
				} else {
					switch (status) {
						case StaffAttendanceStatusEnum.PRESENT:
							selectedDay.style.backgroundColor = 'darkseagreen';
							break;
						case StaffAttendanceStatusEnum.HALFDAY:
							selectedDay.style.backgroundColor = 'burlywood';
							break;
						case StaffAttendanceStatusEnum.ABSENT:
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
			error: function (error) {
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

	document.addEventListener("DOMContentLoaded", function () {
		const form = document.getElementById("assetsForm");

		const priceInput = document.getElementById("price");

		const priceError = document.getElementById("priceError");

		priceInput.addEventListener("input", function () {
			const priceValue = parseFloat(priceInput.value);
			if (priceValue <= 0 || isNaN(priceValue)) {
				priceError.style.display = "block";
			} else {
				priceError.style.display = "none";
			}
		});

		// Form validation on submit
		form.addEventListener("submit", function (event) {
			let isFormValid = true;

			const experienceValue = parseFloat(experienceInput.value);
			if (experienceValue <= 0 || isNaN(experienceValue)) {
				experienceError.style.display = "block";
				experienceInput.classList.add("is-invalid");
				isFormValid = false;
			} else {
				experienceError.style.display = "none";
				experienceInput.classList.remove("is-invalid");
			}
			// Prevent form submission if any field is invalid
			if (!isFormValid) {
				event.preventDefault(); // Stop form from submitting
			}
		});

	});

	document.addEventListener("DOMContentLoaded", function () {
		const leaveForm = document.getElementById("leaveForm");
		const startDateInput = document.getElementById("start_date");
		const endDateInput = document.getElementById("end_date");

		const startDateError = document.getElementById("start_date_error");
		const endDateError = document.getElementById("end_date_error");

		function validateDates() {
			const today = new Date().toISOString().split("T")[0]; // Get today's date in YYYY-MM-DD format
			const startDateValue = startDateInput.value;
			const endDateValue = endDateInput.value;
			let isValid = true;

			// Start Date validation (must be today or later)
			if (startDateValue && startDateValue < today) {
				startDateError.style.display = "block";
				isValid = false;
			} else {
				startDateError.style.display = "none";
			}

			// End Date validation (must be after or on the same day as Start Date)
			if (startDateValue && endDateValue && endDateValue < startDateValue) {
				endDateError.style.display = "block";
				isValid = false;
			} else {
				endDateError.style.display = "none";
			}

			return isValid;
		}

		// Validate on date change
		startDateInput.addEventListener("change", validateDates);
		endDateInput.addEventListener("change", validateDates);

		// Validate on form submission
		leaveForm.addEventListener('submit', function (event) {
			if (!validateDates()) {
				event.preventDefault(); // Stop form submission if validation fails
			}
		});
	});




</script>
<script src="{{asset('js/plugins-init/staff-attendance-overview-chart.js')}}" type="text/javascript"></script>
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


@include('CustomSweetAlert');
@endsection