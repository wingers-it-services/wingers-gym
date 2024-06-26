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

								<form>
									<div class="input-group">
										<input class="form-control form-control-sm" id="member_photo" name="mtaff_photo" onchange="loadFile(event)" accept="image/*" type="file">
									</div>
								</form>
							</div>
							<div class="col-lg-8 order-lg-1">
								<form class="needs-validation" novalidate="" action="/add-user-by-gym" method="post">
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="firstName">First Name</label>
											<input type="text" class="form-control" id="firstName" name="firstName" placeholder="" required="">
											<div class="invalid-feedback">
												Valid first name is required.
											</div>
										</div>

										<div class="col-md-6 mb-3">
											<label for="firstName">Last Name</label>
											<input type="text" class="form-control" id="lastName" name="lastName" placeholder="" required="">
											<div class="invalid-feedback">
												Valid first name is required.
											</div>
										</div>

									</div>
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="email">Email <span class="text-muted">(Optional)</span></label>
											<input type="email" class="form-control" id="email">
											<div class="invalid-feedback">
												Please enter a valid email address for shipping updates.
											</div>
										</div>

										<div class="col-md-6 mb-3">
											<label for="firstName">Member Number</label>
											<input type="text" class="form-control" id="firstName" placeholder="" required>
										</div>


									</div>
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="lastName">Staff Assigned</label>
											<select class="me-sm-2 form-control default-select" id="designation" name="designation">
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
											<label for="lastName">Member Subscription </label>
											<select class="me-sm-2 form-control default-select" id="designation" name="designation">
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
											<label for="lastName">Gender</label>
											<select class="me-sm-2 form-control default-select" id="blood_group" name="blood_group">
												<option selected>Choose...</option>
												<option value="male">Male</option>
												<option value="female">Female</option>
												<option value="Other">Other</option>
											</select>
										</div>

										<div class="col-md-6 mb-3">
											<label for="lastName">Member Blood Group</label>
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
											<label for="firstName">Member Joining Date</label>
											<input type="date" class="form-control" id="firstName" placeholder="" required="">
										</div>
										<div class="col-md-6 mb-3">
											<label for="firstName">Member Joining Date</label>
											<input type="date" class="form-control" id="firstName" placeholder="" required="">
										</div>
									</div>

									<div class="mb-3">
										<label for="address">Address</label>
										<input type="text" class="form-control" id="address" required="">
										<div class="invalid-feedback">
											Please enter your shipping address.
										</div>
									</div>

									<div class="row">
										<div class="col-md-5 mb-3">
											<label for="country">Country</label>
											<input type="text" class="form-control" id="address" required="">
										</div>
										<div class="col-md-4 mb-3">
											<label for="state">State</label>
											<input type="text" class="form-control" id="address" required="">
										</div>
										<div class="col-md-3 mb-3">
											<label for="zip">Zip</label>
											<input type="text" class="form-control" id="zip" placeholder="" required="">

										</div>
									</div>
									<hr class="mb-4">
									<input type="submit" class="btn btn-primary btn-lg btn-block" value="Continue to checkout">
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