@extends('GymOwner.master')
@section('title','Dashboard')
@section('content')

<!--**********************************
            Content body start
        ***********************************-->
<div class="content-body ">
	<div class="container-fluid">
		<div class="page-titles">
			<ol class="breadcrumb">
				<li class="breadcrumb-item active"><a href="javascript:void(0)">Add </a></li>
				<li class="breadcrumb-item active"><a href="javascript:void(0)">New Member Details</a></li>
			</ol>
		</div>
		<div class="row">
			<div class="col-xl-12">
				<div class="card">
					<div class="card-body">
						<form class="needs-validation" novalidate="" action="/add-user-by-gym" method="POST" enctype="multipart/form-data">
							@csrf
							<div class="row">
								<div class="col-lg-4 order-lg-2 mb-4">
									<h4 class="d-flex justify-content-between align-items-center mb-3">
										<span class="text-black">Member Image</span>
									</h4>
									<ul class="list-group mb-3">
										<li class="list-group-item d-flex justify-content-between lh-condensed">
											<div>
												<img id="selected_image" src="https://www.w3schools.com/howto/img_avatar.png" style="border-radius: 50%;width: 200px;height:200px">
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
											<input type="text" class="form-control" id="firstName" name="firstname" placeholder="" required="">
											<div class="invalid-feedback">
												Valid first name is required.
											</div>
										</div>

										<div class="col-md-6 mb-3">
											<label for="lastname">Last Name</label>
											<input type="text" class="form-control" id="lastname" name="lastname" placeholder="" required="">
											<div class="invalid-feedback">
												Valid first name is required.
											</div>
										</div>

									</div>
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="email">Email <span class="text-muted">(Optional)</span></label>
											<input type="email" name="email" class="form-control" id="email">
											<div class="invalid-feedback">
												Please enter a valid email address for shipping updates.
											</div>
										</div>

										<div class="col-md-6 mb-3">
											<label for="member_number">Member Number</label>
											<input type="text" class="form-control" name="member_number" id="member_number" placeholder="" required>
										</div>


									</div>
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="employee_id">Staff Assigned</label>
											<select class="me-sm-2 form-control default-select" id="employee_id" name="employee_id">
												<option selected>Choose...</option>
												@foreach ($gymStaff as $staff)
												<option value="{{ $staff->id }}">{{ $staff->designation_name}}</option>
												@endforeach
											</select>
											<div class="invalid-feedback">
												Valid last name is required.
											</div>
										</div>

										<div class="col-md-6 mb-3">
											<label for="subscription_id">Member Subscription </label>
											<select class="me-sm-2 form-control default-select" id="subscription_id" name="subscription_id">
												<option selected>Choose...</option>
												@foreach ($gymSubscription as $subscription)
												<option value="{{ $subscription->id }}">{{ $subscription->subscription_name}}</option>
												@endforeach
											</select>
											<div class="invalid-feedback">
												Valid last name is required.
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="gender">Gender</label>
											<select class="me-sm-2 form-control default-select" id="gender" name="gender">
												<option selected>Choose...</option>
												<option value="male">Male</option>
												<option value="female">Female</option>
												<option value="Other">Other</option>
											</select>
										</div>

										<div class="col-md-6 mb-3">
											<label for="blood_group">Member Blood Group</label>
											<select class="me-sm-2 form-control default-select" id="blood_group" name="blood_group">
												<option selected>Choose...</option>
												<option value="A+">A+</option>
												<option value="A-">A-</option>
												<option value="B+">B+</option>
												<option value="B-">B-</option>
												<option value="AB+">AB+</option>
												<option value="AB-">AB-</option>
												<option value="O+">O+</option>
												<option value="O-">O-</option>
											</select>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="joining_date">Member Joining Date</label>
											<input type="date" class="form-control" id="joining_date" name="joining_date" placeholder="" required="">
										</div>
									</div>

									<div class="mb-3">
										<label for="address">Address</label>
										<input type="text" class="form-control" id="address" name="address" required="">
										<div class="invalid-feedback">
											Please enter your shipping address.
										</div>
									</div>

									<div class="row">
										<div class="col-md-5 mb-3">
											<label for="country">Country</label>
											<input type="text" class="form-control" id="country" name="country" required="">
										</div>
										<div class="col-md-4 mb-3">
											<label for="state">State</label>
											<input type="text" class="form-control" id="state" name="state" required="">
										</div>
										<div class="col-md-3 mb-3">
											<label for="zip_code">Zip</label>
											<input type="text" class="form-control" id="zip_code" name="zip_code" placeholder="" required="">
										</div>
									</div>
									<hr class="mb-4">
									<input type="submit" class="btn btn-primary btn-lg btn-block" value="Add Member">
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</div>
<!--**********************************
            Content body end
        ***********************************-->
<script>
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
</script>
@endsection