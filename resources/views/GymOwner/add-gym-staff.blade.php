@extends('GymOwner.master')
@section('title', 'Add Staff')
@section('content')

<!--**********************************
            Content body start
        ***********************************-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
	.upload-box {
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		height: 120px;
		border: 2px dashed #ccc;
		border-radius: 10px;
		position: relative;
		background-color: #f9f9f9;
		transition: all 0.4s ease;
		cursor: pointer;
	}

	.icon-container {
		font-size: 30px;
		color: #777;
		transition: all 0.4s ease;
	}

	.upload-text {
		font-size: 14px;
		color: #555;
		text-align: center;
		margin-top: 10px;
	}

	/* Progress Bar */
	.progress-bar {
		width: 0%;
		height: 5px;
		background-color: #28a745;
		position: absolute;
		bottom: 0;
		left: 0;
		transition: width 0.4s ease;
	}

	/* Highlight effect after file upload */
	.uploaded {
		background-color: #e0f7ea;
		/* light green */
		border-color: #28a745;
		/* green border */
	}

	.uploaded .icon-container {
		color: #28a745;
	}

	.uploaded .upload-text {
		color: #28a745;
	}

	.uploaded::before {
		content: "✔";
		/* Checkmark symbol */
		font-size: 24px;
		color: #28a745;
		position: absolute;
		top: 10px;
		right: 10px;
	}
</style>
<div class="content-body ">
	<div class="container-fluid">
		<!-- row -->
		<div class="row">
			<div class="col-xl-12 col-xxl-12">
				<div class="card">
					<div class="card-header">
						<h4 class="card-title">Staff Information</h4>
					</div>
					<div class="card-body">
						<div id="smartwizard" class="form-wizard order-create">
							<ul class="nav nav-wizard">
								<li>
									<a class="nav-link" href="#wizard_Service"><span>1</span></a>
								</li>
								<!-- <li><a class="nav-link" href="#wizard_Time">
										<span>2</span>
									</a></li> -->
								<li>
									<a class="nav-link" href="#wizard_Details"> <span>2</span></a>
								</li>
								<li>
									<a class="nav-link" href="#wizard_Payment"> <span>3</span></a>
								</li>
							</ul>
							<form id="myForm" method="post" enctype="multipart/form-data" class="needs-validation"
								action="/gym-staff" novalidate>
								@csrf
								<div class="tab-content">
									<div id="wizard_Service" class="tab-pane" role="tabpanel"
										style="display: block;text-align: center;">
										<div class="row emial-setup">
											<div class="col-lg-12 col-sm-12 col-12">
												<div class="form-group">
													<div class="mailclinet" id="mailclinet">
														<img id="selected_image"
															src="https://www.w3schools.com/howto/img_avatar.png"
															style="border-radius: 50%;width: 200px;height:200px">
													</div>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-12">
												<div class="skip-email text-center">
													<div class="mb-3">
														<label for="staff_photo" class="form-label">Staff Image</label>
														<input class="form-control form-control-sm" id="staff_photo"
															name="staff_photo" onchange="loadFile(event)"
															accept="image/*" type="file" required>
														<div class="invalid-feedback">
															Staff Image is required.
														</div>
													</div>
												</div>
											</div>
										</div>

									</div>
									<div id="wizard_Details" class="tab-pane" role="tabpanel">
										<div class="row">
											<div class="col-lg-6 mb-2">
												<div class="form-group">
													<label class="text-label">Employee Id<span
															class="required">*</span></label>
													<input type="number" id="staff_id" name="staff_id" class="form-control"
														placeholder="123" required>
														<small id="employee-error" class="text-danger"
														style="display: none;">Enter a valid Employee Id.</small>
													<div class="invalid-feedback">
														Employee Id is required.
													</div>
												</div>
											</div>
											<div class="col-lg-6 mb-2">
												<div class="form-group">
													<label class="text-label">Full Name<span
															class="required">*</span></label>
													<input type="text" id="full_name" name="full_name"
														class="form-control" placeholder="Montana" required>
													<small id="nameError" class="text-danger"
														style="display: none;">Only letters are allowed.</small>
													<div class="invalid-feedback">
														Staff Full Name is required.
													</div>
												</div>
											</div>
											<div class="col-md-6 mb-3">
												<label for="gender">Gender</label>
												<select class="me-sm-2 form-control default-select" id="gender"
													name="gender" required>
													<option selected>Choose...</option>
													<option value="male">Male</option>
													<option value="female">Female</option>
													<option value="Other">Other</option>
												</select>
												<div class="invalid-feedback">
													Choose a gender.
												</div>
											</div>
											<div class="col-lg-6 mb-2">
												<div class="form-group">
													<label class="text-label">Experience (in Years)<span
															class="required">*</span></label>
													<input type="number" class="form-control" id="experience"
														name="experience" placeholder="Experience" required>
													<small id="experienceError" class="text-danger"
														style="display: none;">Please enter a valid Experience.</small>
													<div class="invalid-feedback">
														Staff Experience is required.
													</div>
												</div>
											</div>
											<div class="col-lg-6 mb-2">
												<div class="form-group">
													<label class="text-label">Email Address<span
															class="required">*</span></label>
													<input type="email" class="form-control" id="email" name="email"
														placeholder="example@example.com" required>
													<small id="emailError" class="text-danger"
														style="display: none;">Please enter a valid email
														address.</small>
													<div class="invalid-feedback">
														Staff Email is required.
													</div>
												</div>
											</div>
											<div class="col-lg-6 mb-2">
												<div class="form-group">
													<label class="text-label">Phone Number<span
															class="required">*</span></label>
													<input type="number" name="phone_number" id="phone_number"
														class="form-control" placeholder="(+91)4086579007" required>
													<small id="phoneError" class="text-danger"
														style="display: none;">Please enter a valid phone
														number.</small>
													<div class="invalid-feedback">
														Staff Phone Number is required.
													</div>
												</div>
											</div>
											<div class="col-lg-6 mb-2">
												<div class="form-group">
													<label class="text-label">Date Of Birth<span
															class="required">*</span></label>
													<input type="date" name="dob" id="dob" class="form-control"
														required>
													<small id="dobError" class="text-danger" style="display: none;">You
														must be at least 18 years old.</small>
													<div class="invalid-feedback" required>
														Staff D.O.B is required.
													</div>
												</div>
											</div>
											<div class="col-lg-6 mb-2">
												<div class="form-group">
													<label class="text-label">Whatsapp Number<span
															class="required">*</span></label>
													<input type="number" name="whatsapp_no" id="whatsapp_no"
														class="form-control" placeholder="(+91)4086579007">
													<small id="whatsphoneError" class="text-danger"
														style="display: none;">Please enter a valid whatsapp
														number.</small>
													<div class="invalid-feedback" required>
														Staff Whatsapp No. is required.
													</div>
												</div>
											</div>

											<div class="col-lg-6 mb-2">
												<div class="form-group">
													<label class="text-label">Joining Date<span
															class="required">*</span></label>
													<input type="date" name="joining_date" id="joining_date"
														class="form-control" required>
													<small id="joiningDateError" class="text-danger"
														style="display: none;"> Staff Joining Date must be today or a
														future date.</small>
													<div class="invalid-feedback">
														Staff Joining Date is required.
													</div>
												</div>
											</div>
											<div class="col-lg-6 mb-2">
												<div class="form-group">
													<label class="text-label">Salary<span
															class="required">*</span></label>
													<input type="number" name="salary" id="salary" placeholder="10000"
														class="form-control" required>
													<small id="salaryError" class="text-danger"
														style="display: none;">Please enter a valid salary.</small>
													<div class="invalid-feedback">
														Staff Salary is required.
													</div>
												</div>
											</div>
											<div class="col-lg-6 mb-2">
												<div class="form-group">
													<label class="text-label">Blood Group<span
															class="required">*</span></label>
													<select class="me-sm-2 form-control default-select" id="blood_group"
														name="blood_group" required>
														<option value="">Choose Blood Group</option>
														<option value="A+">A+</option>
														<option value="A-">A-</option>
														<option value="B+">B+</option>
														<option value="B-">B-</option>
														<option value="AB+">AB+</option>
														<option value="AB-">AB-</option>
														<option value="O+">O+</option>
														<option value="O-">O-</option>
													</select>
													<div class="invalid-feedback">
														Choose a Blood Group .
													</div>
												</div>
											</div>
											<div class="col-lg-6 mb-2">
												<div class="form-group">
													<label class="text-label">Designation<span
															class="required">*</span></label>
													<select class="me-sm-2 form-control default-select" id="designation"
														name="designation" required>
														<option value="" selected>Choose Designation</option>
														@foreach($designations as $designation)
															<option value="{{ $designation->id }}"
																data-is-commission-based="{{ $designation->is_commission_based }}">
																{{ $designation->designation_name }}
															</option>
														@endforeach
													</select>
													<div class="invalid-feedback">
														Choose a Staff Designation.
													</div>
												</div>
											</div>
											<div class="col-lg-4 mb-2" id="fees-field">
												<div class="form-group">
													<label class="text-label">Fees<span
															class="required">*</span></label>
													<input type="number" name="fees" id="fees" placeholder="10000"
														class="form-control">
													<small id="fees-error" style="color: red; display: none;">Enter a
														valid fees</small>
													<div class="invalid-feedback">
														Fees is required.
													</div>
												</div>
											</div>
											<div class="col-lg-4 mb-2" id="staff-commission-field">
												<div class="form-group">
													<label class="text-label">Staff Commission (in %) <span
															class="required">*</span></label>
													<input type="number" name="staff_commission" id="staff_commission"
														placeholder="20" class="form-control" step="0.01" max="100">
													<small id="staff-commission-error"
														style="color: red; display: none;">Enter valid Staff
														Commission</small>
													<div class="invalid-feedback">
														Staff Commission is required.
													</div>
												</div>
											</div>
											<div class="col-lg-4 mb-2" id="gym-commission-field">
												<div class="form-group">
													<label class="text-label">Gym Commission (in %)<span
															class="required">*</span></label>
													<input type="number" name="gym_commission" id="gym_commission"
														placeholder="80" class="form-control" readonly>
												</div>
											</div>

											<div class="col-lg-12 mb-3">
												<div class="form-group">
													<label class="text-label">Address<span
															class="required">*</span></label>
													<textarea type="text" name="address" rows="4" class="form-control"
														required></textarea>
													<div class="invalid-feedback">
														Staff Address is required.
													</div>
												</div>
											</div>
										</div>
									</div>
									<div id="wizard_Payment" class="tab-pane" role="tabpanel">
										<div class="row">
											<div class="col-lg-3 col-sm-6 col-6">
												<div class="form-group">
													<label for="mailclient11" class="upload-container"
														id="upload-container-aadhar">
														<input type="file" name="aadhaar_card" id="mailclient11" hidden
															onchange="handleFileUpload(this, 'aadhar')" accept=".pdf, .jpg, .jpeg" required>
														<div class="upload-box" id="upload-box-aadhar">
															<div class="icon-container">
																<i class="fas fa-upload icon"></i>
															</div>
															<span class="upload-text">Upload Aadhar Card</span>
															<div class="progress-bar" id="progress-bar-aadhar"></div>
															<div class="error-message" id="error-aadhaar_card"
																style="color: red; display: none;">Please upload a PDF
																file.</div>

														</div>
													</label>
												</div>
											</div>
											<div class="col-lg-3 col-sm-6 col-6">
												<div class="form-group">
													<label for="mailclient12" class="upload-container"
														id="upload-container-pan">
														<input type="file" name="pan_card" id="mailclient12" hidden
															onchange="handleFileUpload(this, 'pan')"  accept=".pdf, .jpg, .jpeg" required>
														<div class="upload-box" id="upload-box-pan">
															<div class="icon-container">
																<i class="fas fa-upload icon"></i>
															</div>
															<span class="upload-text">Upload Pan Card</span>
															<div class="progress-bar" id="progress-bar-pan"></div>
															<div class="error-message" id="error-pan_card"
																style="color: red; display: none;">Please upload a PDF
																file.</div>

														</div>
													</label>
												</div>
											</div>
											<div class="col-lg-3 col-sm-6 col-6">
												<div class="form-group">
													<label for="mailclient13" class="upload-container"
														id="upload-container-cheque">
														<input type="file" name="cancel_cheque" id="mailclient13" hidden
															onchange="handleFileUpload(this, 'cheque')" accept=".pdf, .jpg, .jpeg" required>
														<div class="upload-box" id="upload-box-cheque">
															<div class="icon-container">
																<i class="fas fa-upload icon"></i>
															</div>
															<span class="upload-text">Upload Cancel Cheque</span>
															<div class="progress-bar" id="progress-bar-cheque"></div>
															<div class="error-message" id="error-cancel_cheque"
																style="color: red; display: none;">Please upload a PDF
																file.</div>

														</div>
													</label>
												</div>
											</div>
											<div class="col-lg-3 col-sm-6 col-6">
												<div class="form-group">
													<label for="mailclient14" class="upload-container"
														id="upload-container-other">
														<input type="file" name="other" id="mailclient14" hidden
															onchange="handleFileUpload(this, 'other')" accept=".pdf, .jpg, .jpeg" required>
														<div class="upload-box" id="upload-box-other">
															<div class="icon-container">
																<i class="fas fa-upload icon"></i>
															</div>
															<span class="upload-text">Upload Other Document</span>
															<div class="progress-bar" id="progress-bar-other"></div>
															<div class="error-message" id="error-other"
																style="color: red; display: none;">Please upload a PDF
																file.</div>
														</div>
													</label>
												</div>
											</div>
										</div>
									</div>
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

	var loadFile = function (event) {
		var input = event.target;
		var image = document.getElementById('selected_image');
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				image.src = e.target.result;
			}
			reader.readAsDataURL(input.files[0]);
		}

		function validateForm() {
			let x = document.forms["myForm"]["staff_id"].value;
			if (x == "") {
				alert("Name must be filled out");
				return false;
			}
		}

	};

	document.addEventListener('DOMContentLoaded', function () {
		const designationSelect = document.getElementById('designation');
		const feesField = document.getElementById('fees-field');
		const staffCommissionField = document.getElementById('staff-commission-field');
		const gymCommissionField = document.getElementById('gym-commission-field');

		// Function to toggle fields based on commission-based value
		function toggleFields() {
			const selectedOption = designationSelect.options[designationSelect.selectedIndex];
			const isCommissionBased = selectedOption ? selectedOption.getAttribute('data-is-commission-based') === '1' : false;

			if (isCommissionBased) {
				feesField.style.display = 'block';
				staffCommissionField.style.display = 'block';
				gymCommissionField.style.display = 'block';
			} else {
				feesField.style.display = 'none';
				staffCommissionField.style.display = 'none';
				gymCommissionField.style.display = 'none';
			}
		}

		// Initialize visibility based on the initially selected option
		toggleFields();

		// Add event listener to handle changes
		designationSelect.addEventListener('change', toggleFields);
	});

	document.addEventListener('DOMContentLoaded', function () {
		const staffCommissionInput = document.getElementById('staff_commission');
		const gymCommissionInput = document.getElementById('gym_commission');
		const errorMessage = document.getElementById('staff-commission-error');

		staffCommissionInput.addEventListener('input', function () {
			let staffCommissionValue = parseFloat(staffCommissionInput.value) || 0;

			// Check if the value is greater than 100
			if (staffCommissionValue > 100) {
				errorMessage.style.display = 'block';
				gymCommissionInput.value = ''; // Clear gym commission if the input is invalid
			} else {
				errorMessage.style.display = 'none';

				// Calculate Gym Commission as the remaining percentage
				const gymCommissionValue = 100 - staffCommissionValue;
				gymCommissionInput.value = gymCommissionValue;
			}
		});
	});

	function handleFileUpload(input, id) {
		if (input.files && input.files[0]) {
			const uploadBox = document.getElementById('upload-box-' + id);
			const progressBar = document.getElementById('progress-bar-' + id);
			const textElement = uploadBox.querySelector('.upload-text');
			const fileName = input.files[0].name;
			const maxLength = 20; // Maximum characters to display for file name

			// Truncate the file name if it's too long
			const displayName = fileName.length > maxLength ? fileName.substring(0, maxLength) + '...' : fileName;

			// Reset progress bar and remove 'uploaded' state
			progressBar.style.width = '0%';
			uploadBox.classList.remove('uploaded');

			// Simulate upload progress
			let progress = 0;
			const progressInterval = setInterval(() => {
				progress += 10;
				progressBar.style.width = progress + '%';

				if (progress >= 100) {
					clearInterval(progressInterval);

					// After "upload", mark as uploaded
					setTimeout(() => {
						uploadBox.classList.add('uploaded');
						textElement.textContent = displayName + " uploaded!";
					}, 300); // Small delay to simulate upload completion
				}
			}, 100); // Simulates progress in 100ms intervals
		}
	}

	document.addEventListener("DOMContentLoaded", function () {
		const form = document.getElementById("myForm");

		const nameInput = document.getElementById("full_name");
		const emailInput = document.getElementById("email");
		const phoneInput = document.getElementById("phone_number");
		const whatsPhoneInput = document.getElementById("whatsapp_no");
		const dobInput = document.getElementById("dob");
		const feesInput = document.getElementById("fees");
		const staffCommissionInput = document.getElementById("staff_commission");
		const experienceInput = document.getElementById("experience");
		const salaryInput = document.getElementById("salary");
		const employeeInput =document.getElementById("staff_id");

		const joiningDateInput = document.getElementById("joining_date");
		const joiningDateError = document.getElementById("joiningDateError");
		const salaryError = document.getElementById("salaryError");
		const experienceError = document.getElementById("experienceError");
		const nameError = document.getElementById("nameError");
		const emailError = document.getElementById("emailError");
		const phoneError = document.getElementById("phoneError");
		const phoneError1 = document.getElementById("whatsphoneError");
		const dobError = document.getElementById("dobError");
		const staffCommissionError = document.getElementById("staff-commission-error");
		const feesError = document.getElementById("fees-error");
		const employeeError =document.getElementById("employee-error");


		// //Function to get today's date in 'YYYY - MM - DD' format
		// function getTodayDate() {
		// 	const today = new Date();
		// 	const year = today.getFullYear();
		// 	const month = (today.getMonth() + 1).toString().padStart(2, '0'); // Months are 0-indexed
		// 	const day = today.getDate().toString().padStart(2, '0');
		// 	return `${year}-${month}-${day}`;
		// }

		// // Set minimum date to today (prevents selecting past dates)
		// const today = getTodayDate();
		// joiningDateInput.setAttribute('min', today);

		// Real-time validation for fees
		feesInput.addEventListener("input", function () {
			const feesValue = parseFloat(feesInput.value);
			if (feesValue <= 0 || isNaN(feesValue)) {
				feesError.style.display = "block";
			} else {
				feesError.style.display = "none";
			}
		});

		employeeInput.addEventListener("input", function () {
			const employeeValue = parseFloat(employeeInput.value);
			if (employeeValue <= 0 || isNaN(employeeValue)) {
				employeeError.style.display = "block";
			} else {
				employeeError.style.display = "none";
			}
		});


		// Real-time validation for staff commission
		staffCommissionInput.addEventListener("input", function () {
			const staffCommissionValue = parseFloat(staffCommissionInput.value);
			if (staffCommissionValue <= 0 || staffCommissionValue > 100 || isNaN(staffCommissionValue)) {
				staffCommissionError.style.display = "block";
			} else {
				staffCommissionError.style.display = "none";
			}
		});

		salaryInput.addEventListener("input", function () {
			const salaryValue = parseFloat(salaryInput.value);
			if (salaryValue <= 0 || isNaN(salaryInput.value)) {
				salaryError.style.display = "block";
			} else {
				salaryError.style.display = "none";
			}
		});

		experienceInput.addEventListener("input", function () {
			const experienceValue = parseFloat(experienceInput.value);
			if (experienceValue < 0 || isNaN(salaryInput.value)) {
				experienceError.style.display = "block";
			} else {
				experienceError.style.display = "none";
			}
		});

		function isValidName(fullname) {
			const namePattern = /^[A-Za-z\s]+$/;
			return namePattern.test(fullname);
		}

		// Helper function to validate email format
		function isValidEmail(email) {
			const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
			return emailPattern.test(email);
		}

		// Helper function to validate phone format
		function isValidPhone(phone) {
			const phonePattern = /^\d{10}$/; // for 10-digit phone numbers
			return phonePattern.test(phone);
		}

		// Helper function to validate DOB (age >= 18)
		function isValidDOB(dob) {
			const selectedDate = new Date(dob);
			const today = new Date();
			let age = today.getFullYear() - selectedDate.getFullYear();
			const monthDiff = today.getMonth() - selectedDate.getMonth();

			if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < selectedDate.getDate())) {
				age--;
			}
			return age >= 18;
		}

		// Real-time validation for email
		nameInput.addEventListener("input", function () {
			if (!isValidName(nameInput.value)) {
				nameError.style.display = 'block';
			} else {
				nameError.style.display = 'none';
			}
		});

		emailInput.addEventListener("input", function () {
			if (!isValidEmail(emailInput.value)) {
				emailError.style.display = "block";
			} else {
				emailError.style.display = "none";
			}
		});

		// Real-time validation for phone
		phoneInput.addEventListener("input", function () {
			if (!isValidPhone(phoneInput.value)) {
				phoneError.style.display = "block";
			} else {
				phoneError.style.display = "none";
			}
		});

		whatsPhoneInput.addEventListener("input", function () {
			if (!isValidPhone(whatsPhoneInput.value)) {
				phoneError1.style.display = "block";
			} else {
				phoneError1.style.display = "none";
			}
		});


		// Real-time validation for DOB
		dobInput.addEventListener("input", function () {
			if (!isValidDOB(dobInput.value)) {
				dobError.style.display = "block";
			} else {
				dobError.style.display = "none";
			}
		});


		// Form validation on submit
		form.addEventListener("submit", function (event) {
			let isFormValid = true;

			const experienceValue = parseFloat(experienceInput.value);
			if (experienceValue < 0 || isNaN(experienceValue)) {
				experienceError.style.display = "block";
				experienceInput.classList.add("is-invalid");
				isFormValid = false;
			} else {
				experienceError.style.display = "none";
				experienceInput.classList.remove("is-invalid");
			}

			const salaryValue = parseFloat(salaryInput.value);
			if (salaryValue <= 0 || isNaN(salaryValue)) {
				salaryError.style.display = "block";
				salaryInput.classList.add("is-invalid");
				isFormValid = false;
			} else {
				salaryError.style.display = "none";
				salaryInput.classList.remove("is-invalid");
			}

			// // Validate fees
			// const feesValue = parseFloat(feesInput.value);
			// if (feesValue <= 0 || isNaN(feesValue)) {
			// 	feesError.style.display = "block";
			// 	feesInput.classList.add("is-invalid");
			// 	isFormValid = false;
			// } else {
			// 	feesError.style.display = "none";
			// 	feesInput.classList.remove("is-invalid");
			// }

			// // Validate staff commission
			// const staffCommissionValue = parseFloat(staffCommissionInput.value);
			// if (staffCommissionValue <= 0 || staffCommissionValue > 100 || isNaN(staffCommissionValue)) {
			// 	staffCommissionError.style.display = "block";
			// 	staffCommissionInput.classList.add("is-invalid");
			// 	isFormValid = false;
			// } else {
			// 	staffCommissionError.style.display = "none";
			// 	staffCommissionInput.classList.remove("is-invalid");
			// }

			const employeeValue = parseFloat(employeeInput.value);
			if (employeeValue <= 0 || isNaN(employeeValue)) {
				employeeError.style.display = "block";
				employeeInput.classList.add("is-invalid");
				isFormValid = false;
			} else {
				employeeError.style.display = "none";
				employeeInput.classList.remove("is-invalid");
			}

			if (!isValidName(nameInput.value)) {
				nameError.style.display = "block";
				nameInput.classList.add("is-invalid");
				isFormValid = false;
			} else {
				nameError.style.display = "none";
				nameInput.classList.remove("is-invalid");
			}

			// Email validation on submit
			if (!isValidEmail(emailInput.value)) {
				emailError.style.display = "block";
				emailInput.classList.add("is-invalid");
				isFormValid = false;
			} else {
				emailError.style.display = "none";
				emailInput.classList.remove("is-invalid");
			}

			// Phone validation on submit
			if (!isValidPhone(phoneInput.value)) {
				phoneError.style.display = "block";
				phoneInput.classList.add("is-invalid");
				isFormValid = false;
			} else {
				phoneError.style.display = "none";
				phoneInput.classList.remove("is-invalid");
			}

			// WhatsApp Phone validation on submit
			if (!isValidPhone(whatsPhoneInput.value)) {
				phoneError1.style.display = "block";
				whatsPhoneInput.classList.add("is-invalid");
				isFormValid = false;
			} else {
				phoneError1.style.display = "none";
				whatsPhoneInput.classList.remove("is-invalid");
			}

			// DOB validation on submit
			if (!isValidDOB(dobInput.value)) {
				dobError.style.display = "block";
				dobInput.classList.add("is-invalid");
				isFormValid = false;
			} else {
				dobError.style.display = "none";
				dobInput.classList.remove("is-invalid");
			}

			// Prevent form submission if any field is invalid
			if (!isFormValid) {
				event.preventDefault(); // Stop form from submitting
			}
		});

	});

	document.addEventListener("DOMContentLoaded", function () {
		const requiredFiles = ['aadhaar_card', 'pan_card', 'cancel_cheque']; // IDs of required file inputs
		const otherFile = 'other'; // ID of the optional file input
		const fileInputs = {
			'aadhaar_card': 'mailclient11',
			'pan_card': 'mailclient12',
			'cancel_cheque': 'mailclient13',
			'other': 'mailclient14'
		};
		const errorMessage = document.getElementById("error-aadhar");

		// Function to validate file inputs before submission
		function validateFileInputs() {
			let isValid = true;

			// Loop through the required files and check if they are empty
			requiredFiles.forEach(fileType => {
				const fileInput = document.getElementById(fileInputs[fileType]);
				const errorMessage = document.getElementById(`error-${fileType}`);
				if (!fileInput.files.length) {
					errorMessage.style.display = 'block';  // Show error message
					errorMessage.textContent = `Please upload ${fileType.replace('_', ' ')}.`;
					isValid = false;
				} else {
					errorMessage.style.display = 'none';  // Hide error message if file is selected
				}
			});

			return isValid;
		}

		// Handle form submission
		document.querySelector('form').addEventListener('submit', function (event) {
			if (!validateFileInputs()) {
				event.preventDefault(); // Stop form submission if validation fails
			}
		});
	});




</script>
@include('CustomSweetAlert');
@endsection