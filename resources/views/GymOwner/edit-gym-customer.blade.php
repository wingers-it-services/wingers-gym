@extends('GymOwner.master')
@section('title','Edet Member')
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
		<form class="needs-validation" novalidate="" action="/update-user/{{ $userDetail->uuid }}" method="POST" enctype="multipart/form-data">
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
												<img id="selected_image" src="{{ $userDetail->image ?? 'https://www.w3schools.com/howto/img_avatar.png' }} " style="border-radius: 50%;width: 200px;height:200px">
											</div>
										</li>

									</ul>

									<div class="input-group">
										<input class="form-control form-control-sm" id="image" name="image" onchange="loadFile(event)" accept="image/*" type="file">
									</div>
								</div>

								<div class="col-lg-8 order-lg-1">
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="firstName">First Name</label>
											<input type="text" class="form-control" id="firstname" name="firstname" value="{{$userDetail->firstname}}" placeholder="" disabled>
											<div class="invalid-feedback">
												Valid first name is required.
											</div>
										</div>

										<div class="col-md-6 mb-3">
											<label for="lastname">Last Name</label>
											<input type="text" class="form-control" id="lastname" name="lastname" value="{{$userDetail->lastname}}" placeholder="" disabled>
											<div class="invalid-feedback">
												Valid first name is required.
											</div>
										</div>

									</div>
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="email">Email </label>
											<input type="email" name="email" class="form-control" value="{{$userDetail->email}}" id="email" readonly>
											<div class="invalid-feedback">
												Please enter a valid email address for shipping updates.
											</div>
										</div>

										<div class="col-md-6 mb-3">
											<div class="form-group position-relative">
												<label for="password">Set Password</label>
												<input type="password" class="form-control" name="password" id="password" value="{{$userDetail->password}}" placeholder="" required>
												<span class="show-pass eye" onclick="togglePasswordVisibility()">
													<i class="fa fa-eye-slash"></i>
													<i class="fa fa-eye"></i>
												</span>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="phone_no">Phone Number</label>
											<input type="text" class="form-control" name="phone_no" id="phone_no" value="{{$userDetail->phone_no}}" placeholder="" required>
										</div>
										<div class="col-md-6 mb-3">
											<label for="joining_date">Member Joining Date</label>
											<input type="date" class="form-control" value="{{$userDetail->joining_date}}" name="joining_date" required>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="employee_id">Staff Assigned</label>
											<select class="me-sm-2 form-control default-select" id="staff_assign_id" name="staff_assign_id">
												<option value="">Choose...</option>
												@foreach ($gymStaff as $staff)
												<option value="{{ $staff->id }}" {{ $staff->designation_name == $staff->id ? 'selected' : '' }}>
													{{ $staff->designation_name }}
												</option>
												@endforeach
											</select>
											<div class="invalid-feedback">
												Valid last name is required.
											</div>
										</div>

										<div class="col-md-6 mb-3">
											<label for="gender">Gender</label>
											<select class="me-sm-2 form-control default-select" id="gender" name="gender">
												<option selected>Choose...</option>
												<option {{ $userDetail->gender == 'male' ? 'selected' : '' }} value="male">Male</option>
												<option {{ $userDetail->gender == 'female' ? 'selected' : '' }} value="female">Female</option>
												<option {{ $userDetail->gender == 'Other' ? 'selected' : '' }} value="Other">Other</option>
											</select>
										</div>
									</div>

									<div class="row">

										<div class="col-md-6 mb-3">
											<label for="blood_group">Member Blood Group</label>
											<select class="me-sm-2 form-control default-select" id="blood_group" name="blood_group">
												<option>Choose...</option>
												<option {{ $userDetail->blood_group == 'A+' ? 'selected' : '' }} value="A+">A+</option>
												<option {{ $userDetail->blood_group == 'A-' ? 'selected' : '' }} value="A-">A-</option>
												<option {{ $userDetail->blood_group == 'B+' ? 'selected' : '' }} value="B+">B+</option>
												<option {{ $userDetail->blood_group == 'B-' ? 'selected' : '' }} value="B-">B-</option>
												<option {{ $userDetail->blood_group == 'AB+' ? 'selected' : '' }} value="AB+">AB+</option>
												<option {{ $userDetail->blood_group == 'AB-' ? 'selected' : '' }} value="AB-">AB-</option>
												<option {{ $userDetail->blood_group == 'O+' ? 'selected' : '' }} value="O+">O+</option>
												<option {{ $userDetail->blood_group == 'O-' ? 'selected' : '' }} value="O-">O-</option>
											</select>
										</div>

										<!-- <div class="col-md-8 mb-3">
											<label for="address">Address</label>
											<textarea type="text" class="form-control" rows="5" id="address" name="address" required="">{{$userDetail->address}}</textarea>
											<div class="invalid-feedback">
												Please enter your shipping address.
											</div>
										</div> -->
										<div class="col-md-6 mb-3">
											<label for="dob">D.O.B</label>
											<input type="date" class="form-control" value="{{$userDetail->dob}}" id="dob" name="dob" required>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12 mb-3">
											<label for="address">Address</label>
											<textarea type="text" class="form-control" rows="5" id="address" name="address" required="">{{$userDetail->address}}</textarea>
											<div class="invalid-feedback">
												Please enter your shipping address.
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="country">Country</label>
											<input type="text" class="form-control" id="country" name="country" value="{{$userDetail->country}}" required="">
										</div>
										<div class="col-md-6 mb-3">
											<label for="state">State</label>
											<input type="text" class="form-control" id="state" name="state" value="{{$userDetail->state}}" required="">
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="city">City</label>
											<input type="text" class="form-control" id="city" name="city" value="{{$userDetail->city}}" required="">
										</div>
										<div class="col-md-6 mb-3">
											<label for="zip_code">Zip</label>
											<input type="text" class="form-control" id="zip_code" name="zip_code" placeholder="" value="{{$userDetail->zip_code}}" required="">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<input type="submit" class="btn btn-primary btn-lg btn-block" value="Update Member">

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
	var loadFile = function(event) {
		// var selected_image = document.getElementById('selected_image');

		var input = event.target;
		var image = document.getElementById('selected_image');
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
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

	(function() {
		'use strict'

		// Fetch all the forms we want to apply custom Bootstrap validation styles to
		var forms = document.querySelectorAll('.needs-validation')

		// Loop over them and prevent submission
		Array.prototype.slice.call(forms)
			.forEach(function(form) {
				form.addEventListener('submit', function(event) {
					if (!form.checkValidity()) {
						event.preventDefault()
						event.stopPropagation()
					}

					form.classList.add('was-validated')
				}, false)
			})
	})()

	// document.getElementById('subscription_id').addEventListener('change', function() {
	// 	var selectedOption = this.options[this.selectedIndex];
	// 	var description = selectedOption.getAttribute('data-description');
	// 	var amount = selectedOption.getAttribute('data-amount');
	// 	var validity = selectedOption.getAttribute('data-validity');

	// 	// Update the hidden fields and display elements
	// 	document.getElementById('description').value = description;
	// 	document.getElementById('subscription_amount').innerText = '₹' + amount;
	// 	document.getElementById('total_amount').innerText = '₹' + amount;
	// 	document.getElementById('amount').value = amount;
	// 	document.getElementById('validity').value = validity;
	// });

	// // If a subscription is already selected, trigger the change event on page load to populate the fields
	// document.addEventListener('DOMContentLoaded', function() {
	// 	var subscriptionSelect = document.getElementById('subscription_id');
	// 	if (subscriptionSelect.value) {
	// 		var event = new Event('change');
	// 		subscriptionSelect.dispatchEvent(event);
	// 	}
	// });


	// document.getElementById('joining_date').addEventListener('change', function() {
	// 	var selectedOption = document.getElementById('subscription_id').options[document.getElementById('subscription_id').selectedIndex];
	// 	var validity = selectedOption.getAttribute('data-validity');

	// 	updateEndDate(this.value, validity);
	// });

	// function updateEndDate(joiningDate, validity) {
	// 	if (joiningDate && validity) {
	// 		var date = new Date(joiningDate);
	// 		date.setMonth(date.getMonth() + parseInt(validity));
	// 		var day = ("0" + date.getDate()).slice(-2);
	// 		var month = ("0" + (date.getMonth() + 1)).slice(-2);
	// 		var year = date.getFullYear();
	// 		var formattedDate = year + '-' + month + '-' + day; // Correct MySQL format

	// 		document.getElementById('subscription_end_date').innerText = day + '/' + month + '/' + year; // Display in dd/mm/yyyy
	// 		document.getElementById('end_date').value = formattedDate; // Save in yyyy-mm-dd
	// 	} else {
	// 		document.getElementById('subscription_end_date').innerText = '';
	// 		document.getElementById('end_date').value = '';
	// 	}
	// }

	// // Trigger update on page load if joining date exists
	// document.addEventListener('DOMContentLoaded', function() {
	// 	var joiningDate = document.getElementById('joining_date').value;
	// 	var selectedOption = document.getElementById('subscription_id').options[document.getElementById('subscription_id').selectedIndex];
	// 	var validity = selectedOption.getAttribute('data-validity');

	// 	if (joiningDate && validity) {
	// 		updateEndDate(joiningDate, validity);
	// 	}
	// });
</script>
@include('CustomSweetAlert');
@endsection