@extends('GymOwner.master')
@section('title', 'Add Member')
@section('content')

<div class="content-body ">
	<div class="container-fluid">
		<div class="page-titles">
			<ol class="breadcrumb">
				<li class="breadcrumb-item active"><a href="javascript:void(0)">Add </a></li>
				<li class="breadcrumb-item active"><a href="javascript:void(0)">New Member Details</a></li>
			</ol>
		</div>
		<form id="userForm" class="needs-validation" action="/add-user-by-gym" method="POST"
			enctype="multipart/form-data" novalidate>
			@csrf
			<div class="row">
				<div class="col-xl-12">
					<div class="card">
						<div class="card-body">
							<div class="row">
								<div class="col-lg-12 order-lg-1">
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="email">Email</label>
											<input type="email" name="email" class="form-control" id="email">
											<small id="emailError" class="text-danger" style="display: none;">Please
												enter a valid email
												address.</small>
											<div class="invalid-feedback">
												Email is required.
											</div>
										</div>

										<div class="col-md-6 mb-3">
											<label for="phone_no">Phone Number</label>
											<input type="number" class="form-control" name="phone_no" id="phone_no"
												placeholder="" required>
											<small id="phoneError" class="text-danger" style="display: none;">Please
												enter a valid phone
												number.</small>
											<div class="invalid-feedback">
												Phone Number is required.
											</div>
										</div>

										<div class="col-md-12 mb-12">
											<input id="continue" type="button" class="btn btn-primary btn-lg btn-block"
												value="Continue">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="container">
					<div class="row" id="user-cards-container">
						<!-- User cards will be inserted here -->
					</div>
				</div>
				<div id="user-details-form" class="col-xl-12" style="display: none;">
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
													src="https://www.w3schools.com/howto/img_avatar.png"
													style="border-radius: 50%;width: 200px;height:200px">
											</div>
										</li>

									</ul>

									<div class="input-group">
										<input class="form-control form-control-sm" id="image" name="image"
											onchange="loadFile(event)" accept="image/*" type="file">
									</div>
								</div>
								<input type="hidden" id="user_id" name="user_id" value="">
								<div class="col-lg-8 order-lg-1">
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="firstName">First Name</label>
											<input type="text" class="form-control" id="firstname" name="firstname"
												placeholder="" required="">
											<small id="firstError" class="text-danger" style="display: none;">Only
												Letters are allowed.</small>
											<div class="invalid-feedback">
												First Name is required.
											</div>
										</div>

										<div class="col-md-6 mb-3">
											<label for="lastname">Last Name</label>
											<input type="text" class="form-control" id="lastname" name="lastname"
												placeholder="" required="">
											<small id="lastError" class="text-danger" style="display: none;">Only
												Letters are allowed.</small>
											<div class="invalid-feedback">
												Last Name is required
											</div>
										</div>

									</div>
									<div class="row">
										<div class="col-md-6 mb-3">
											<div class="form-group position-relative">
												<label for="password">Set Password</label>
												<input type="password" class="form-control" name="password"
													id="password" placeholder="" required>
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
										<div class="col-md-6 mb-3">
											<label for="joining_date">Member Joining Date</label>
											<input type="date" class="form-control" id="joining_date"
												name="joining_date" required>
											<small id="joiningDateError" class="text-danger" style="display: none;">
												Staff Joining Date must be today or a
												future date.</small>
											<div class="invalid-feedback" required>
												Joining Date is required.
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-4 mb-3">
											<label for="employee_id">Staff Assigned</label>
											<select class="me-sm-2 form-control default" id="staff_assign_id"
												name="staff_assign_id">
												@foreach ($gymStaff as $staff)
													<option value="{{ $staff->id }}">{{ $staff->designation_name}}</option>
												@endforeach
											</select>
											<div class="invalid-feedback">
												Staff Assigned is required.
											</div>
										</div>

										<div class="col-md-4 mb-3">
											<label for="gender">Gender</label>
											<select class="me-sm-2 form-control default-select" id="gender"
												name="gender" required>
												<option value="male">Male</option>
												<option value="female">Female</option>
												<option value="Other">Other</option>
											</select>
											<div class="invalid-feedback">
												Choose a gender.
											</div>
										</div>

										<div class="col-md-4 mb-3">
											<label for="employee_id">Goal</label>
											<select class="me-sm-2 form-control default" id="goal_id" name="goal_id">
												@foreach ($goals as $goal)
													<option value="{{ $goal->id }}">{{ $goal->goal}}</option>
												@endforeach
											</select>
											<div class="invalid-feedback">
												Choose a goal.
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="blood_group">Member Blood Group</label>
											<select class="me-sm-2 form-control default-select" id="blood_group"
												name="blood_group" required>
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

										<div class="col-md-6 mb-3">
											<label for="dob">D.O.B</label>
											<input type="date" class="form-control" id="dob" name="dob" required>
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
											<textarea type="text" class="form-control" id="address" name="address"
												required=""></textarea>
											<div class="invalid-feedback">
												Address is required.
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="country">Country</label>
											<input type="text" class="form-control" id="country" name="country"
												required="">
											<small id="countryError" class="text-danger" style="display: none;">Only
												Letters are allowed.</small>
											<div class="invalid-feedback">
												Country is required.
											</div>
										</div>
										<div class="col-md-6 mb-3">
											<label for="state">State</label>
											<input type="text" class="form-control" id="state" name="state" required="">
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
											<input type="text" class="form-control" id="city" name="city" required="">
											<small id="cityError" class="text-danger" style="display: none;">Only
												Letters are allowed.</small>
											<div class="invalid-feedback">
												City is required.
											</div>
										</div>
										<div class="col-md-6 mb-3">
											<label for="zip_code">Zip</label>
											<input type="number" class="form-control" id="zip_code" name="zip_code"
												placeholder="" required="">
											<small id="zipError" class="text-danger" style="display: none;">zip code
												must be 6 digit long.</small>
											<div class="invalid-feedback">
												Zip is required.
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-12" id="sub-cards-container" style="display: none;">
					<div class="card">
						<div class="card-body">
							<div class="row">
								<div class="col-lg-6 order-lg-1">
									<div class="col-xl-12 col-lg-12">
										<h4 class="d-flex justify-content-between align-items-center mb-3">
											<span class="text-black">Select Subscription</span>
										</h4>
										<ul class="list-group mb-3">
											<div class="col-md-12 mb-3">
												<select class="me-sm-2 form-control default-select" id="subscription_id"
													name="subscription_id" required>
													<option value="" data-description="" data-amount=""
														data-validity="">-- Select Subscription --</option>
													@foreach ($gymSubscriptions as $subscription)
														<option value="{{ $subscription->id }}"
															data-description="{{ $subscription->description }}"
															data-amount="{{ $subscription->amount }}"
															data-validity="{{ $subscription->validity }}">
															{{ $subscription->subscription_name }}
														</option>
													@endforeach
												</select>
												<div class="invalid-feedback">
													Choose a Subscription.
												</div>
											</div>

											<div class="col-md-12 mb-3">
												<label for="subscription_start_date">Subscription Joining Date</label>
												<input type="date" class="form-control" id="subscription_start_date"
													name="subscription_start_date" required>
												<small id="subjoiningDateError" class="text-danger"
													style="display: none;">
													Subscription Joining Date must be after User Joining Date.</small>
												<div class="invalid-feedback">
													Subscription Joining Date.
												</div>
											</div>

											<li class="list-group-item d-flex justify-content-between lh-condensed">
												<div>
													<small class="text-muted">Subscription Amount</small>
												</div>
												<span class="text-muted" id="subscription_amount">₹0</span>
												<input type="hidden" id="amount" name="amount">
											</li>
											<li class="list-group-item d-flex justify-content-between lh-condensed">
												<div>
													<small class="text-muted">Subscription End Date</small>
													<input type="hidden" id="end_date" name="subscription_end_date">
												</div>
												<span class="text-muted" id="subscription_end_date"></span>
											</li>

											<li class="list-group-item d-flex justify-content-between">
												<span>Total (USD)</span>
												<strong id="total_amount">₹0</strong>
											</li>
										</ul>
									</div>
								</div>
								<div class="col-lg-6 order-lg-1">
									<div class="col-xl-12 col-lg-12">
										<h4 class="d-flex justify-content-between align-items-center mb-3">
											<span class="text-black">Subscription Description</span>
										</h4>
										<div class="col-md-12 mb-3">
											<textarea type="text" class="form-control" id="description" rows="16"
												name="description" required="" readonly></textarea>
										</div>
									</div>
								</div>
							</div>
							<input type="submit" class="btn btn-primary btn-lg btn-block" value="Add Member">
						</div>
					</div>
				</div>
			</div>
		</form>
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

	document.getElementById('subscription_id').addEventListener('change', function () {
		var selectedOption = this.options[this.selectedIndex];
		var description = selectedOption.getAttribute('data-description');
		var amount = selectedOption.getAttribute('data-amount');
		var validity = selectedOption.getAttribute('data-validity');

		document.getElementById('description').value = description;
		document.getElementById('subscription_amount').innerText = '₹' + amount;
		document.getElementById('total_amount').innerText = '₹' + amount;
		document.getElementById('amount').value = amount;

		var joiningDate = document.getElementById('subscription_start_date').value;
		if (joiningDate) {
			updateEndDate(joiningDate, validity);
		}
	});

	document.getElementById('subscription_start_date').addEventListener('change', function () {
		var selectedOption = document.getElementById('subscription_id').options[document.getElementById('subscription_id').selectedIndex];
		var validity = selectedOption.getAttribute('data-validity');

		updateEndDate(this.value, validity);
	});

	function updateEndDate(joiningDate, validity) {
		if (joiningDate && validity) {
			var date = new Date(joiningDate);
			date.setMonth(date.getMonth() + parseInt(validity));
			var day = ("0" + date.getDate()).slice(-2);
			var month = ("0" + (date.getMonth() + 1)).slice(-2);
			var year = date.getFullYear();
			var formattedDate = year + '-' + month + '-' + day; // Correct MySQL format

			document.getElementById('subscription_end_date').innerText = day + '/' + month + '/' + year; // Display in dd/mm/yyyy
			document.getElementById('end_date').value = formattedDate; // Save in yyyy-mm-dd
		} else {
			document.getElementById('subscription_end_date').innerText = '';
			document.getElementById('end_date').value = '';
		}
	}

	document.addEventListener('DOMContentLoaded', function () {
		const button = document.getElementById('continue');
		const userDetailsFormContainer = document.getElementById('user-details-form');
		const userCardsContainer = document.getElementById('user-cards-container');
		const subDetailContainer = document.getElementById('sub-cards-container');

		button.addEventListener('click', function () {
			const email = document.getElementById('email').value;
			const phone_no = document.getElementById('phone_no').value;
			const emailInput = document.getElementById("email");
			const phoneInput = document.getElementById("phone_no");

			if (email || phone_no) {
				fetchUserDetails(email, phone_no);
			} else {
				emailInput.classList.add("is-invalid");
				phoneInput.classList.add("is-invalid");

			}
		});

		function fetchUserDetails(email, phone_no) {
			fetch(`/fetch-user-details?email=${encodeURIComponent(email)}&phone_no=${encodeURIComponent(phone_no)}`)
				.then(response => response.json())
				.then(data => {
					if (data.success) {
						displayUserCards(data.users);
						userDetailsFormContainer.style.display = 'none'; // Hide form if users are found
						subDetailContainer.style.display = 'none';

					} else {
						clearUserCards(); // Clear any existing cards
						showUserDetailsForm(); // Show the user details form
					}
				})
				.catch(error => console.error('Error:', error));
		}

		function displayUserCards(users) {
			userCardsContainer.innerHTML = ''; // Clear previous cards

			users.forEach(user => {
				const card = document.createElement('div');
				card.classList.add('col-md-4', 'mb-4'); // Bootstrap classes for responsive grid
				card.innerHTML = `
                <div class="card">
                    <img class="card-img-top" src="${user.image || '#'}" alt="${user.firstname} ${user.lastname}" style="height: 160px;">
                    <div class="card-body">
                        <h5 class="card-title">${user.firstname} ${user.lastname}</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="las la-clock scale5 me-3"></i>
                                <span>${user.email}</span>
                            </li>
                            <li class="mb-2"><i class="las la-clock scale5 me-3"></i>
                                <span>${user.phone_no}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            `;

				// Add click event listener to the card
				card.addEventListener('click', function () {
					autofillForm(user);
					userDetailsFormContainer.style.display = 'block'; // Show form when a card is clicked
					subDetailContainer.style.display = 'block'; // Show form when a card is clicked

					document.getElementById('firstname').focus();

				});

				userCardsContainer.appendChild(card);
			});
		}

		function clearUserCards() {
			userCardsContainer.innerHTML = ''; // Clear all cards
		}

		function showUserDetailsForm() {
			// Reset and show the user details form
			autofillForm({
				clear: true
			}); // Pass an option to clear only certain fields
			userDetailsFormContainer.style.display = 'block'; // Ensure the form is visible
			subDetailContainer.style.display = 'block'; // Ensure the form is visible

			document.getElementById('firstname').focus();
		}

		function autofillForm(user) {
			// Check if we should clear fields or set user data
			const clearFields = user.clear || false;

			if (clearFields) {
				// Clear all user detail fields
				document.getElementById('user_id').value = '';
				document.getElementById('firstname').value = '';
				document.getElementById('lastname').value = '';
				document.getElementById('address').value = '';
				document.getElementById('country').value = '';
				document.getElementById('state').value = '';
				document.getElementById('city').value = '';
				document.getElementById('zip_code').value = '';
				document.getElementById('joining_date').value = '';
				document.getElementById('password').value = '';
				document.getElementById('dob').value = '';

				// Reset image to default
				const image = document.getElementById('selected_image');
				image.src = 'https://www.w3schools.com/howto/img_avatar.png'; // Default image

				// Reset dropdown values
				const genderSelect = document.getElementById('gender');
				const bloodGroupSelect = document.getElementById('blood_group');
				const staffAssignSelect = document.getElementById('staff_assign_id');
				const goalIdSelect = document.getElementById('goal_id');

				genderSelect.value = '';
				bloodGroupSelect.value = '';
				staffAssignSelect.value = '';
				goalIdSelect.value = '';
			} else {
				// Set user data if provided
				document.getElementById('user_id').value = user.id || ''; // Set the user ID if exists
				document.getElementById('firstname').value = user.firstname || '';
				document.getElementById('lastname').value = user.lastname || '';
				document.getElementById('address').value = user.address || '';
				document.getElementById('country').value = user.country || '';
				document.getElementById('state').value = user.state || '';
				document.getElementById('city').value = user.city || '';
				document.getElementById('zip_code').value = user.zip_code || '';
				document.getElementById('joining_date').value = user.joining_date || '';
				document.getElementById('password').value = user.password || '';
				document.getElementById('phone_no').value = user.phone_no || '';
				document.getElementById('email').value = user.email || '';
				document.getElementById('dob').value = user.dob || '';


				// Handle image preview if available
				const image = document.getElementById('selected_image');
				image.src = user.image || 'https://www.w3schools.com/howto/img_avatar.png'; // Default image

				// Set dropdown values
				const genderSelect = document.getElementById('gender');
				const bloodGroupSelect = document.getElementById('blood_group');
				const staffAssignSelect = document.getElementById('staff_assign_id');

				genderSelect.value = user.gender || '';
				bloodGroupSelect.value = user.blood_group || '';
				staffAssignSelect.value = user.staff_assign_id || '';
			}
		}
	});

	document.addEventListener("DOMContentLoaded", function () {
		const form = document.getElementById("userForm");

		const emailInput = document.getElementById("email");
		const phoneInput = document.getElementById("phone_no");
		const firstInput = document.getElementById("firstname");
		const lastInput = document.getElementById("lastname");
		const passwordInput = document.getElementById("password");
		const joiningDateInput = document.getElementById("joining_date");
		const subjoiningDateInput = document.getElementById("subscription_start_date");
		const dobInput = document.getElementById("dob");
		const countryInput = document.getElementById("country");
		const stateInput = document.getElementById("state");
		const cityInput = document.getElementById("city");
		const zipInput = document.getElementById("zip_code");

		const emailError = document.getElementById("emailError");
		const phoneError = document.getElementById("phoneError");
		const firstError = document.getElementById("firstError");
		const lastError = document.getElementById("lastError");
		const passwordError = document.getElementById("passwordError");
		const joiningDateError = document.getElementById("joiningDateError");
		const subjoiningDateError = document.getElementById("subjoiningDateError");
		const dobError = document.getElementById("dobError");
		const countryError = document.getElementById("countryError");
		const stateError = document.getElementById("stateError");
		const cityError = document.getElementById("cityError");
		const zipError = document.getElementById("zipError");


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

		function isValidName(fullname) {
			const namePattern = /^[A-Za-z\s]+$/;
			return namePattern.test(fullname);
		}

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

		// joiningDateInput.addEventListener("change", function () {
		// 	if (!validateDates(joiningDateInput.value)) {
		// 		joiningDateError.style.display = "block";
		// 	} else {
		// 		joiningDateError.style.display = "none";
		// 	}
		// });

		subjoiningDateInput.addEventListener("change", function () {
			if (!validateDates(subjoiningDateInput.value)) {
				subjoiningDateError.style.display = "block";
			} else {
				subjoiningDateError.style.display = "none";
			}
		});

		function validateDates() {
			const today = new Date().toISOString().split("T")[0]; // Get today's date in YYYY-MM-DD format
			const startDateValue = joiningDateInput.value;
			const endDateValue = subjoiningDateInput.value;
			let isValid = true;

			// // Start Date validation (must be today or later)
			// if (startDateValue && startDateValue < today) {
			// 	joiningDateError.style.display = "block";
			// 	isValid = false;
			// } else {
			// 	joiningDateError.style.display = "none";
			// }

			// End Date validation (must be after or on the same day as Start Date)
			if (startDateValue && endDateValue && endDateValue < startDateValue) {
				subjoiningDateError.style.display = "block";
				isValid = false;
			} else {
				subjoiningDateError.style.display = "none";
			}

			return isValid;
		}

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

			// Date validation
			if (!validateDates()) {
				isFormValid = false;
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