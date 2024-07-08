@extends('admin.master')
@section('title','Dashboard')
@section('content')

<!--**********************************
            Content body start
        ***********************************-->
<div class="content-body ">
	<div class="container-fluid">
		<div class="page-titles">
			<ol class="breadcrumb">
				<li class="breadcrumb-item active"><a href="javascript:void(0)">Edit </a></li>
				<li class="breadcrumb-item active"><a href="javascript:void(0)">Staff Details</a></li>
			</ol>
		</div>
		<div class="row">
			<div class="col-xl-12">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-lg-4 order-lg-2 mb-4">
								<h4 class="d-flex justify-content-between align-items-center mb-3">
									<span class="text-black">Staff Image</span>
								</h4>
								<ul class="list-group mb-3">
									<li class="list-group-item d-flex justify-content-between lh-condensed">
										<div>
											<img id="selected_image" src="{{ '../'.$staffDetail->image ?? 'https://www.w3schools.com/howto/img_avatar.png' }} " style="border-radius: 50%;width: 200px;height:200px">
										</div>
									</li>

								</ul>

								<form>
									<div class="input-group">
										<input class="form-control form-control-sm" id="staff_photo" name="staff_photo" onchange="loadFile(event)" accept="image/*" type="file">
									</div>
								</form>
							</div>
							<div class="col-lg-8 order-lg-1">
								<h4 class="mb-3">Billing address</h4>
								<form class="needs-validation" novalidate="">
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="firstName">Staff Name</label>
											<input type="text" class="form-control" id="firstName" placeholder="" value="{{ $staffDetail->name}}" required="">
											<div class="invalid-feedback">
												Valid first name is required.
											</div>
										</div>

										<div class="col-md-6 mb-3">
											<label for="firstName">Staff Emp Id</label>
											<input type="text" class="form-control" id="firstName" placeholder="" value="{{ $staffDetail->employee_id}}" required="">
											<div class="invalid-feedback">
												Valid first name is required.
											</div>
										</div>

									</div>
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="email">Email <span class="text-muted">(Optional)</span></label>
											<input type="email" class="form-control" id="email" value="{{ $staffDetail->email}}">
											<div class="invalid-feedback">
												Please enter a valid email address for shipping updates.
											</div>
										</div>

										<div class="col-md-6 mb-3">
											<label for="lastName">Staff Designation</label>
											<select class="me-sm-2 form-control default-select" id="designation" name="designation">
												<option selected>Choose...</option>
												@foreach ($designations as $designation)
												<option value="{{ $designation->id }}">{{ $designation->designation_name}}</option>
												@endforeach
											</select>
											<div class="invalid-feedback">
												Valid last name is required.
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="firstName">Staff Number</label>
											<input type="text" class="form-control" id="firstName" placeholder="" value="{{ $staffDetail->number}}" required="">
										</div>

										<div class="col-md-6 mb-3">
											<label for="lastName">Staff Salary</label>
											<input type="text" class="form-control" id="firstName" placeholder="" value="{{ $staffDetail->salary}}" required="">
										</div>
									</div>

									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="firstName">Staff Joining Date</label>
											<input type="text" class="form-control" id="firstName" placeholder="" value="{{ $staffDetail->joining_date}}" required="">
										</div>

										<div class="col-md-6 mb-3">
											<label for="lastName">Staff Blood Group</label>
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

									<div class="mb-3">
										<label for="address">Address</label>
										<input type="text" class="form-control" id="address" value="{{ $staffDetail->address}}" required="">
										<div class="invalid-feedback">
											Please enter your shipping address.
										</div>
									</div>

									<div class="row">
										<div class="col-md-5 mb-3">
											<label for="country">Country</label>
											<input type="text" class="form-control" id="address" value="{{ $staffDetail->Country}}" required="">
										</div>
										<div class="col-md-4 mb-3">
											<label for="state">State</label>
											<input type="text" class="form-control" id="address" value="{{ $staffDetail->state}}" required="">
										</div>
										<div class="col-md-3 mb-3">
											<label for="zip">Zip</label>
											<input type="text" class="form-control" id="zip" placeholder="" required="">

										</div>
									</div>
									<hr class="mb-4">
									<button class="btn btn-primary btn-lg btn-block" type="submit">Continue to
										checkout</button>
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

@endsection