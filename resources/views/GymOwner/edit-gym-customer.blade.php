@extends('GymOwner.master')
@section('title', 'Edit Member')
@section('content')

<!--**********************************
            Content body start
        ***********************************-->
<div class="content-body ">
	<div class="container-fluid">
		<div class="page-titles">
			<ol class="breadcrumb">
				<li class="breadcrumb-item active"><a href="javascript:void(0)">Update </a></li>
				<li class="breadcrumb-item active"><a href="javascript:void(0)">Update Member Details</a></li>
			</ol>
		</div>
		<form id="updateUserForm" class="needs-validation" action="/update-user/{{ $userDetail->uuid }}" method="POST"
			enctype="multipart/form-data" novalidate>
			@csrf
			<div class="row">
				<div class="col-xl-12">
					<div class="card">
						<div class="card-body">
							<div class="row">
								<div class="col-lg-4 order-lg-2 mb-4">
									<h4 class="d-flex justify-content-between align-items-center mb-3">
										<span class="text-black">Member Image</span>
									</h4>
									<ul class="list-group mb-3">
										<li class="list-group-item d-flex justify-content-between lh-condensed">
											<div>
												<img id="selected_image"
													src="{{ $userDetail->image ?? 'https://www.w3schools.com/howto/img_avatar.png' }} "
													style="border-radius: 50%;width: 200px;height:200px">
											</div>
										</li>

									</ul>

									<div class="input-group">
										<input class="form-control form-control-sm" id="image" name="image"
											onchange="loadFile(event)" accept="image/*" type="file">
									</div>
								</div>

								<div class="col-lg-8 order-lg-1">
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="firstName">First Name</label>
											<input type="text" class="form-control" id="firstname" name="firstname"
												value="{{$userDetail->firstname}}" placeholder="" required>
											<small id="firstError" class="text-danger" style="display: none;">Only
												Letters are allowed.</small>
											<div class="invalid-feedback">
												First Name is required.
											</div>
										</div>

										<div class="col-md-6 mb-3">
											<label for="lastname">Last Name</label>
											<input type="text" class="form-control" id="lastname" name="lastname"
												value="{{$userDetail->lastname}}" placeholder="" required>
											<small id="lastError" class="text-danger" style="display: none;">Only
												Letters are allowed.</small>
											<div class="invalid-feedback">
												Last Name is required
											</div>
										</div>

									</div>
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="email">Email </label>
											<input type="email" name="email" class="form-control"
												value="{{$userDetail->email}}" id="email" readonly>
											<div class="invalid-feedback">
												Please enter a valid email address for shipping updates.
											</div>
										</div>

										<div class="col-md-6 mb-3">
											<div class="form-group position-relative">
												<label for="password">Set Password</label>
												<input type="password" class="form-control" name="password"
													id="password" value="{{$userDetail->password}}" placeholder=""
													required>
												<span class="show-pass eye" onclick="togglePasswordVisibility()">
													<i class="fa fa-eye-slash"></i>
													<i class="fa fa-eye"></i>
												</span>
												<small id="passwordError" class="text-danger" style="display:none;">
													Password must be at least 8 characters long.
												</small>
												<div class="invalid-feedback">
													Password is required.
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="phone_no">Phone Number</label>
											<input type="text" class="form-control" name="phone_no" id="phone_no"
												value="{{$userDetail->phone_no}}" placeholder="" required>
											<small id="phoneError" class="text-danger" style="display: none;">Please
												enter a valid phone
												number.</small>
											<div class="invalid-feedback">
												Phone Number is required.
											</div>
										</div>
										<div class="col-md-6 mb-3">
											<label for="joining_date">Member Joining Date</label>
											<input type="date" class="form-control"
												value="{{$userDetail->joining_date}}" id="joining_date"
												name="joining_date" required>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="employee_id">Staff Assigned</label>
											<select class="me-sm-2 form-control default-select" id="staff_assign_id"
												name="staff_assign_id">
												<option value="">Choose...</option>
												@foreach ($gymStaff as $staff)
													<option value="{{ $staff->id }}" {{ $staff->designation_name == $staff->id ? 'selected' : '' }}>
														{{ $staff->designation_name }}
													</option>
												@endforeach
											</select>
											<div class="invalid-feedback">
												Staff Assigned is required.
											</div>
										</div>

										<div class="col-md-6 mb-3">
											<label for="gender">Gender</label>
											<select class="me-sm-2 form-control default-select" id="gender"
												name="gender" required>
												<option selected>Choose...</option>
												<option {{ $userDetail->gender == 'male' ? 'selected' : '' }}
													value="male">Male</option>
												<option {{ $userDetail->gender == 'female' ? 'selected' : '' }}
													value="female">Female</option>
												<option {{ $userDetail->gender == 'Other' ? 'selected' : '' }}
													value="Other">Other</option>
											</select>
											<div class="invalid-feedback">
												Choose a gender.
											</div>
										</div>
									</div>

									<div class="row">

										<div class="col-md-6 mb-3">
											<label for="blood_group">Member Blood Group</label>
											<select class="me-sm-2 form-control default-select" id="blood_group"
												name="blood_group" required>
												<option>Choose...</option>
												<option {{ $userDetail->blood_group == 'A+' ? 'selected' : '' }}
													value="A+">A+</option>
												<option {{ $userDetail->blood_group == 'A-' ? 'selected' : '' }}
													value="A-">A-</option>
												<option {{ $userDetail->blood_group == 'B+' ? 'selected' : '' }}
													value="B+">B+</option>
												<option {{ $userDetail->blood_group == 'B-' ? 'selected' : '' }}
													value="B-">B-</option>
												<option {{ $userDetail->blood_group == 'AB+' ? 'selected' : '' }}
													value="AB+">AB+</option>
												<option {{ $userDetail->blood_group == 'AB-' ? 'selected' : '' }}
													value="AB-">AB-</option>
												<option {{ $userDetail->blood_group == 'O+' ? 'selected' : '' }}
													value="O+">O+</option>
												<option {{ $userDetail->blood_group == 'O-' ? 'selected' : '' }}
													value="O-">O-</option>
											</select>
											<div class="invalid-feedback">
												Choose a Blood Group .
											</div>
										</div>

										<div class="col-md-6 mb-3">
											<label for="dob">D.O.B</label>
											<input type="date" class="form-control" value="{{$userDetail->dob}}"
												id="dob" name="dob" required>
											<small id="dobError" class="text-danger" style="display: none;">You
												must be at least 14 years old.</small>
											<div class="invalid-feedback" required>
												D.O.B is required.
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12 mb-3">
											<label for="address">Address</label>
											<textarea type="text" class="form-control" rows="5" id="address"
												name="address" required>{{$userDetail->address}}</textarea>
											<div class="invalid-feedback">
												Address is required.
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="country">Country</label>
											<input type="text" class="form-control" id="country" name="country"
												value="{{$userDetail->country}}" required>
											<small id="countryError" class="text-danger" style="display: none;">Only
												Letters are allowed.</small>
											<div class="invalid-feedback">
												Country is required.
											</div>
										</div>
										<div class="col-md-6 mb-3">
											<label for="state">State</label>
											<input type="text" class="form-control" id="state" name="state"
												value="{{$userDetail->state}}" required>
											<small id="stateError" class="text-danger" style="display: none;">Only
												Letters are allowed.</small>
											<div class="invalid-feedback">
												State is required.
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="city">City</label>
											<input type="text" class="form-control" id="city" name="city"
												value="{{$userDetail->city}}" required>
											<small id="cityError" class="text-danger" style="display: none;">Only
												Letters are allowed.</small>
											<div class="invalid-feedback">
												City is required.
											</div>

										</div>
										<div class="col-md-6 mb-3">
											<label for="zip_code">Zip</label>
											<input type="text" class="form-control" id="zip_code" name="zip_code"
												placeholder="" value="{{$userDetail->zip_code}}" required>
											<small id="zipError" class="text-danger" style="display: none;">zip code
												must be 6 digit long.</small>
											<div class="invalid-feedback">
												Zip is required.
											</div>
										</div>
									</div>
								</div>
							</div>
							<input type="submit" class="btn btn-primary btn-lg btn-block" value="Update Member">
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
</div>
</div>
<!--**********************************
            Content body end
        ***********************************-->
<script>
	function togglePasswordVisibility() {
		var passwordField = document.getElementById("password");
		var toggleIcon = document.getElementById("togglePassword");

		if (passwordField.type === "password") {
			passwordField.type = "text";
			toggleIcon.classList.remove('fa-eye-slash');
			toggleIcon.classList.add('fa-eye');
		} else {
			passwordField.type = "password";
			toggleIcon.classList.remove('fa-eye');
			toggleIcon.classList.add('fa-eye-slash');
		}
	}

	var loadFile = function (event) {
		// var selected_image = document.getElementById('selected_image');

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

	document.addEventListener("DOMContentLoaded", function () {
		const form = document.getElementById("updateUserForm");

		const phoneInput = document.getElementById("phone_no");
		const firstInput = document.getElementById("firstname");
		const lastInput = document.getElementById("lastname");
		const passwordInput = document.getElementById("password");
		const joiningDateInput = document.getElementById("joining_date");
		const dobInput = document.getElementById("dob");
		const countryInput = document.getElementById("country");
		const stateInput = document.getElementById("state");
		const cityInput = document.getElementById("city");
		const zipInput = document.getElementById("zip_code");

		const phoneError = document.getElementById("phoneError");
		const firstError = document.getElementById("firstError");
		const lastError = document.getElementById("lastError");
		const passwordError = document.getElementById("passwordError");
		const joiningDateError = document.getElementById("joiningDateError");
		const dobError = document.getElementById("dobError");
		const countryError = document.getElementById("countryError");
		const stateError = document.getElementById("stateError");
		const cityError = document.getElementById("cityError");
		const zipError = document.getElementById("zipError");



		// Helper function to validate phone format
		function isValidPhone(phone) {
			const phonePattern = /^\d{10}$/; // for 10-digit phone numbers
			return phonePattern.test(phone);
		}

		function isValidName(fullname) {
			const namePattern = /^[A-Za-z\s]+$/;
			return namePattern.test(fullname);
		}

		// Real-time validation for phone
		phoneInput.addEventListener("input", function () {
			if (!isValidPhone(phoneInput.value)) {
				phoneError.style.display = "block";
			} else {
				phoneError.style.display = "none";
			}
		});

		firstInput.addEventListener("input", function () {
			if (!isValidName(firstInput.value)) {
				firstError.style.display = 'block';
			} else {
				firstError.style.display = 'none';
			}
		});

		lastInput.addEventListener("input", function () {
			if (!isValidName(lastInput.value)) {
				lastError.style.display = 'block';
			} else {
				lastError.style.display = 'none';
			}
		});

		countryInput.addEventListener("input", function () {
			if (!isValidName(countryInput.value)) {
				countryError.style.display = 'block';
			} else {
				countryError.style.display = 'none';
			}
		});

		stateInput.addEventListener("input", function () {
			if (!isValidName(stateInput.value)) {
				stateError.style.display = 'block';
			} else {
				stateError.style.display = 'none';
			}
		});

		cityInput.addEventListener("input", function () {
			if (!isValidName(cityInput.value)) {
				cityError.style.display = 'block';
			} else {
				cityError.style.display = 'none';
			}
		});

		passwordInput.addEventListener('input', function () {
			if (passwordInput.value.length < 8) {
				passwordError.style.display = 'block';
			} else {
				passwordError.style.display = 'none';
			}
		});

		zipInput.addEventListener('input', function () {
			const zipValue = zipInput.value;

			// Check if zip code is exactly 6 digits long and is numeric
			if (zipValue.length !== 6 || isNaN(zipValue)) {
				zipError.style.display = 'block';  // Show the error message
			} else {
				zipError.style.display = 'none';   // Hide the error message
			}
		});

		function isValidDOB(dob) {
			const today = new Date();
			const birthDate = new Date(dob);
			const age = today.getFullYear() - birthDate.getFullYear();
			const monthDifference = today.getMonth() - birthDate.getMonth();

			// Check if the user hasn't had their birthday this year yet
			if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
				return age - 1 >= 16;
			}
			return age >= 16;
		}

		dobInput.addEventListener("change", function () {
			if (!isValidDOB(dobInput.value)) {
				dobError.style.display = "block";
			} else {
				dobError.style.display = "none";
			}
		});

		// Form validation on submit
		form.addEventListener("submit", function (event) {
			let isFormValid = true;

			// Phone validation on submit
			if (!isValidPhone(phoneInput.value)) {
				phoneError.style.display = "block";
				phoneInput.classList.add("is-invalid");
				isFormValid = false;
			} else {
				phoneError.style.display = "none";
				phoneInput.classList.remove("is-invalid");
			}

			if (!isValidName(firstInput.value)) {
				firstError.style.display = "block";
				firstInput.classList.add("is-invalid");
				isFormValid = false;
			} else {
				firstError.style.display = "none";
				firstInput.classList.remove("is-invalid");
			}

			if (!isValidName(lastInput.value)) {
				lastError.style.display = "block";
				lastInput.classList.add("is-invalid");
				isFormValid = false;
			} else {
				lastError.style.display = "none";
				lastInput.classList.remove("is-invalid");
			}

			if (!isValidName(countryInput.value)) {
				countryError.style.display = "block";
				countryInput.classList.add("is-invalid");
				isFormValid = false;
			} else {
				countryError.style.display = "none";
				countryInput.classList.remove("is-invalid");
			}

			if (!isValidName(stateInput.value)) {
				stateError.style.display = "block";
				stateInput.classList.add("is-invalid");
				isFormValid = false;
			} else {
				stateError.style.display = "none";
				stateInput.classList.remove("is-invalid");
			}

			if (!isValidName(cityInput.value)) {
				cityError.style.display = "block";
				cityInput.classList.add("is-invalid");
				isFormValid = false;
			} else {
				cityError.style.display = "none";
				cityInput.classList.remove("is-invalid");
			}

			const zipValue = zipInput.value;
			// Check if zip code is exactly 6 digits long and is numeric
			if (zipValue.length !== 6 || isNaN(zipValue)) {
				zipError.style.display = 'block';  // Show the error message
				zipInput.classList.add("is-invalid");
				isFormValid = false;
			} else {
				zipError.style.display = 'none';   // Hide the error message
				zipInput.classList.remove("is-invalid");
			}

			const passwordValue = passwordInput.value;
			if (passwordInput.value.length < 8) {
				passwordError.style.display = 'block';
				passwordInput.classList.add("is-invalid");
				isFormValid = false;
			} else {
				passwordError.style.display = 'none';
				passwordInput.classList.remove("is-invalid");
			}

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
</script>
@include('CustomSweetAlert');
@endsection