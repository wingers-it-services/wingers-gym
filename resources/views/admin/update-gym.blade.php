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
				<li class="breadcrumb-item active"><a href="javascript:void(0)">Update GYM</a></li>
			</ol>
		</div>
		<div class="row">
			<div class="col-xl-12">
				<div class="card">
					<div class="card-body">
						<form method="POST" action="/admin/updateAdminGym" enctype="multipart/form-data">
							@csrf
							<div class="row">
								<div class="col-lg-4 order-lg-2 mb-4">
									<h4 class="d-flex justify-content-between align-items-center mb-3">
										<span class="text-black">Gym Image</span>
									</h4>
									<ul class="list-group mb-3">
										<li class="list-group-item d-flex justify-content-between lh-condensed">
											<div>
												<img id="selected_image" src="{{asset($gymLists->image)}}" style="border-radius: 50%;width: 200px;height:200px">
											</div>
										</li>

									</ul>

									<form>
										<div class="input-group">
											<input class="form-control form-control-sm" id="image" name="image" onchange="loadFile(event)" accept="image/*" type="file">
										</div>
									</form>
								</div>
								<div class="col-lg-8 order-lg-1">
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="gym_name">Gym Name</label>
											<input type="text" class="form-control" value="{{$gymLists->gym_name}}" id="gym_name" name="gym_name" placeholder="" required="">
											<div class="invalid-feedback">
												Valid first name is required.
											</div>
										</div>

										<div class="col-md-6 mb-3">
											<label for="username">User Name</label>
											<input type="text" class="form-control" value="{{$gymLists->username}}" id="username" name="username" placeholder="" required="">
											<div class="invalid-feedback">
												Valid first name is required.
											</div>
										</div>

									</div>
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="email">Email</label>
											<input type="email" value="{{$gymLists->email}}" class="form-control" name="email" id="email">
											<div class="invalid-feedback">
												Please enter a valid email address for shipping updates.
											</div>
										</div>

										<div class="col-md-6 mb-3">
											<label for="password">Password</label>
											<input type="password" value="{{$gymLists->password}}" class="form-control" id="password" name="password" placeholder="" required>
										</div>
									</div>
									<div class="mb-3">
										<label for="address">Address</label>
										<textarea type="text" class="form-control" id="address" name="address" required="">{{$gymLists->address}}</textarea>
										<div class="invalid-feedback">
											Please enter your shipping address.
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="firstName">Web Link <span class="text-muted">(Optional)</span></label>
											<input type="text" class="form-control" value="{{$gymLists->web_link}}" id="web_link" name="web_link" placeholder="">
										</div>
										<div class="col-md-6 mb-3">
											<label for="firstName">Gym Type</label>
											<input type="text" class="form-control" value="{{$gymLists->gym_type}}" id="gym_type" name="gym_type" placeholder="" required="">
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="firstName">Facebook Link <span class="text-muted">(Optional)</span></label>
											<input type="text" class="form-control" value="{{$gymLists->face_link}}" id="face_link" name="face_link" placeholder="">
										</div>
										<div class="col-md-6 mb-3">
											<label for="firstName">Instagram Link <span class="text-muted">(Optional)</span></label>
											<input type="text" class="form-control" value="{{$gymLists->ista_link}}" id="insta_link" name="insta_link" placeholder="">
										</div>
									</div>

									<div class="row">
										<div class="col-md-4 mb-3">
											<label for="country">Country</label>
											<input type="text" class="form-control" value="{{$gymLists->country}}" id="country" name="country" required="">
										</div>
										<div class="col-md-4 mb-3">
											<label for="state">City</label>
											<input type="text" class="form-control" value="{{$gymLists->city}}" id="city" name="city" required="">
										</div>
										<div class="col-md-4 mb-3">
											<label for="zip">State</label>
											<input type="text" class="form-control" value="{{$gymLists->state}}" id="state" placeholder="" name="state" required="">

										</div>
									</div>
									<hr class="mb-4">
									<input type="submit" class="btn btn-primary btn-lg btn-block" value="Update GYM">
								</div>
							</div>
						</form>
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


	var loadFile = function(event) {
		var selectedImage = document.getElementById('selected_image');
		selectedImage.src = URL.createObjectURL(event.target.files[0]);
		selectedImage.onload = function() {
			URL.revokeObjectURL(selectedImage.src) // free memory
		}
	};
</script>
@endsection