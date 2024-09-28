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
							<form name="myForm" method="post" enctype="multipart/form-data" class="needs-validation"
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
													<input type="number" name="staff_id" class="form-control"
														placeholder="123" required>
													<div class="invalid-feedback">
														Staff image is required.
													</div>
												</div>
											</div>
											<div class="col-lg-6 mb-2">
												<div class="form-group">
													<label class="text-label">Full Name<span
															class="required">*</span></label>
													<input type="text" name="full_name" class="form-control"
														placeholder="Montana" required>
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
													<input type="text" class="form-control" id="experience"
														name="experience" placeholder="Experience" required>
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
														class="form-control" placeholder="(+1)408-657-9007" required>
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
														class="form-control" placeholder="(+1)408-657-9007">
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
													<div class="invalid-feedback">
														Staff Joining Date is required.
													</div>
												</div>
											</div>
											<div class="col-lg-6 mb-2">
												<div class="form-group">
													<label class="text-label">Salary<span
															class="required">*</span></label>
													<input type="text" name="salary" id="salary" placeholder="10000"
														class="form-control" required>
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
														<option value="">Choose...</option>
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
														name="designation">
														<option value="" selected>Choose...</option>
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
												</div>
											</div>
											<div class="col-lg-4 mb-2" id="staff-commission-field">
												<div class="form-group">
													<label class="text-label">Staff Commission (in %) <span
															class="required">*</span></label>
													<input type="number" name="staff_commission" id="staff_commission"
														placeholder="20" class="form-control" step="0.01" max="100">
													<small id="staff-commission-error"
														style="color: red; display: none;">Staff commission cannot be
														greater than 100%</small>
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
															onchange="handleFileUpload(this, 'aadhar')" required>
														<div class="upload-box" id="upload-box-aadhar">
															<div class="icon-container">
																<i class="fas fa-upload icon"></i>
															</div>
															<span class="upload-text">Upload Aadhar Card</span>
															<div class="progress-bar" id="progress-bar-aadhar"></div>
														</div>
													</label>
												</div>
											</div>
											<div class="col-lg-3 col-sm-6 col-6">
												<div class="form-group">
													<label for="mailclient12" class="upload-container"
														id="upload-container-pan">
														<input type="file" name="pan_card" id="mailclient12" hidden
															onchange="handleFileUpload(this, 'pan')" required>
														<div class="upload-box" id="upload-box-pan">
															<div class="icon-container">
																<i class="fas fa-upload icon"></i>
															</div>
															<span class="upload-text">Upload Pan Card</span>
															<div class="progress-bar" id="progress-bar-pan"></div>
														</div>
													</label>
												</div>
											</div>
											<div class="col-lg-3 col-sm-6 col-6">
												<div class="form-group">
													<label for="mailclient13" class="upload-container"
														id="upload-container-cheque">
														<input type="file" name="cancel_cheque" id="mailclient13" hidden
															onchange="handleFileUpload(this, 'cheque')" required>
														<div class="upload-box" id="upload-box-cheque">
															<div class="icon-container">
																<i class="fas fa-upload icon"></i>
															</div>
															<span class="upload-text">Upload Cancel Cheque</span>
															<div class="progress-bar" id="progress-bar-cheque"></div>
														</div>
													</label>
												</div>
											</div>
											<div class="col-lg-3 col-sm-6 col-6">
												<div class="form-group">
													<label for="mailclient14" class="upload-container"
														id="upload-container-other">
														<input type="file" name="other" id="mailclient14" hidden
															onchange="handleFileUpload(this, 'other')" required>
														<div class="upload-box" id="upload-box-other">
															<div class="icon-container">
																<i class="fas fa-upload icon"></i>
															</div>
															<span class="upload-text">Upload Other Document</span>
															<div class="progress-bar" id="progress-bar-other"></div>
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

	// document.addEventListener("DOMContentLoaded", function () {
	// 	const emailInput = document.getElementById("email");
	// 	const phoneInput = document.getElementById("phone_number");
	// 	const whatsPhoneInput = document.getElementById("whatsapp_no");
	// 	const emailError = document.getElementById("emailError");
	// 	const phoneError = document.getElementById("phoneError");
	// 	const phoneError1 = document.getElementById("whatsphoneError");

	// 	const dobInput = document.getElementById("dob");
	// 	const dobError = document.getElementById("dobError");

	// 	// Regular expression for validating email
	// 	const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

	// 	// Regular expression for validating phone numbers
	// 	const phoneRegex = /^(\(\+\d{1,3}\))?\d{3}\d{3}\d{4}$/;

	// 	// Email Validation Event Listener
	// 	emailInput.addEventListener("input", function () {
	// 		if (emailRegex.test(emailInput.value)) {
	// 			emailError.style.display = "none";
	// 		} else {
	// 			emailError.style.display = "block";
	// 		}
	// 	});

	// 	// Phone Validation Event Listener
	// 	phoneInput.addEventListener("input", function () {
	// 		if (phoneRegex.test(phoneInput.value)) {
	// 			phoneError.style.display = "none";
	// 		} else {
	// 			phoneError.style.display = "block";
	// 		}
	// 	});

	// 	whatsPhoneInput.addEventListener("input", function () {
	// 		if (phoneRegex.test(whatsPhoneInput.value)) {
	// 			phoneError1.style.display = "none";
	// 		} else {
	// 			phoneError1.style.display = "block";
	// 		}
	// 	});

	// 	dobInput.addEventListener("input", function () {
	// 		const selectedDate = new Date(dobInput.value);
	// 		const today = new Date();

	// 		let age = today.getFullYear() - selectedDate.getFullYear();
	// 		const monthDiff = today.getMonth() - selectedDate.getMonth();

	// 		if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < selectedDate.getDate())) {
	// 			age--;
	// 		}

	// 		if (age >= 18) {
	// 			dobError.style.display = "none";
	// 		} else {
	// 			dobError.style.display = "block";
	// 		}
	// 	});
	// });

	document.addEventListener("DOMContentLoaded", function () {
		const form = document.getElementById("myForm");

		const emailInput = document.getElementById("email");
		const phoneInput = document.getElementById("phone_number");
		const whatsPhoneInput = document.getElementById("whatsapp_no");
		const dobInput = document.getElementById("dob");

		const emailError = document.getElementById("emailError");
		const phoneError = document.getElementById("phoneError");
		const phoneError1 = document.getElementById("whatsphoneError");
		const dobError = document.getElementById("dobError");

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

	document.addEventListener('DOMContentLoaded', function () {

		

	});



</script>
@include('CustomSweetAlert');
@endsection