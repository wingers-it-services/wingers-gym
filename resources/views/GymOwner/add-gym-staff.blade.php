@extends('GymOwner.master')
@section('title','Dashboard')
@section('content')

<!--**********************************
            Content body start
        ***********************************-->
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
							<form name="myForm" method="post" enctype="multipart/form-data" action="/gym-staff" >
								@csrf
								<div class="tab-content">
									<div id="wizard_Service" class="tab-pane" role="tabpanel" style="display: block;text-align: center;">
										<div class="row emial-setup">
											<div class="col-lg-12 col-sm-12 col-12">
												<div class="form-group">
													<div class="mailclinet" id="mailclinet">
														<img id="selected_image" src="https://www.w3schools.com/howto/img_avatar.png" style="border-radius: 50%;width: 200px;height:200px">
													</div>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-12">
												<div class="skip-email text-center">
													<div class="mb-3">
														<label for="staff_photo" class="form-label">Staff Image</label>
														<input class="form-control form-control-sm" id="staff_photo" name="staff_photo" onchange="loadFile(event)" accept="image/*" type="file">
													</div>
												</div>
											</div>
										</div>
									</div>
									<div id="wizard_Details" class="tab-pane" role="tabpanel">
										<div class="row">
											<div class="col-lg-6 mb-2">
												<div class="form-group">
													<label class="text-label">Employee Id<span class="required">*</span></label>
													<input type="number" name="staff_id" class="form-control" placeholder="123" >
												</div>
											</div>
											<div class="col-lg-6 mb-2">
												<div class="form-group">
													<label class="text-label">Full Name<span class="required">*</span></label>
													<input type="text" name="full_name" class="form-control" placeholder="Montana" >
												</div>
											</div>
											<div class="col-lg-6 mb-2">
												<div class="form-group">
													<label class="text-label">Email Address<span class="required">*</span></label>
													<input type="email" class="form-control" id="email" name="email" placeholder="example@example.com.com" >
												</div>
											</div>
											<div class="col-lg-6 mb-2">
												<div class="form-group">
													<label class="text-label">Phone Number<span class="required">*</span></label>
													<input type="text" name="phone_number" id="phone_number" class="form-control" placeholder="(+1)408-657-9007" >
												</div>
											</div>

											<div class="col-lg-6 mb-2">
												<div class="form-group">
													<label class="text-label">Joining Date<span class="required">*</span></label>
													<input type="date" name="joining_date" id="joining_date" class="form-control" >
												</div>
											</div>
											<div class="col-lg-6 mb-2">
												<div class="form-group">
													<label class="text-label">Salary<span class="required">*</span></label>
													<input type="text" name="salary" id="salary" placeholder="10000" class="form-control" >
												</div>
											</div>
											<div class="col-lg-6 mb-2">
												<div class="form-group">
													<label class="text-label">Designation<span class="required">*</span></label>
													<select class="me-sm-2 form-control default-select" id="designation" name="designation">
														<option selected>Choose...</option>
                                                        @foreach($designations as $designation)
														<option value="{{$designation->id}}">{{$designation->designation_name}}</option>

                                                        @endforeach
													</select>
												</div>
											</div>
											<div class="col-lg-6 mb-2">
												<div class="form-group">
													<label class="text-label">Blood Group<span class="required">*</span></label>
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
											<div class="col-lg-12 mb-3">
												<div class="form-group">
													<label class="text-label">Address<span class="required">*</span></label>
													<textarea type="text" name="address" rows="4" class="form-control" ></textarea>

												</div>
											</div>
										</div>
									</div>


									<!-- <div id="wizard_Details" class="tab-pane" role="tabpanel">
										<div class="row  align-items-center">
											<div class="col-sm-4 mb-2">
												<span>Monday<span class="required">*</span></span>
											</div>
											<div class="col-6 col-sm-4 mb-2">
												<div class="form-group">
													<input class="form-control" value="9.00" type="number" name="input1" id="input1">
												</div>
											</div>
											<div class="col-6 col-sm-4 mb-2">
												<div class="form-group">
													<input class="form-control" value="6.00" type="number" name="input2" id="input2">
												</div>
											</div>
										</div>
										<div class="row  align-items-center">
											<div class="col-sm-4 mb-2">
												<span>Tuesday<span class="required">*</span></span>
											</div>
											<div class="col-6 col-sm-4 mb-2">
												<div class="form-group">
													<input class="form-control" value="9.00" type="number" name="input3" id="input3">
												</div>
											</div>
											<div class="col-6 col-sm-4 mb-2">
												<div class="form-group">
													<input class="form-control" value="6.00" type="number" name="input4" id="input4">
												</div>
											</div>
										</div>
										<div class="row  align-items-center">
											<div class="col-sm-4 mb-2">
												<span>Wednesday<span class="required">*</span></span>
											</div>
											<div class="col-6 col-sm-4 mb-2">
												<div class="form-group">
													<input class="form-control" value="9.00" type="number" name="input5" id="input5">
												</div>
											</div>
											<div class="col-6 col-sm-4 mb-2">
												<div class="form-group">
													<input class="form-control" value="6.00" type="number" name="input6" id="input6">
												</div>
											</div>
										</div>
										<div class="row  align-items-center">
											<div class="col-sm-4 mb-2">
												<span>Thrusday<span class="required">*</span></span>
											</div>
											<div class="col-6 col-sm-4 mb-2">
												<div class="form-group">
													<input class="form-control" value="9.00" type="number" name="input7" id="input7">
												</div>
											</div>
											<div class="col-6 col-sm-4 mb-2">
												<div class="form-group">
													<input class="form-control" value="6.00" type="number" name="input8" id="input8">
												</div>
											</div>
										</div>
										<div class="row align-items-center">
											<div class="col-sm-4 mb-2">
												<span>Friday<span class="required">*</span></span>
											</div>
											<div class="col-6 col-sm-4 mb-2">
												<div class="form-group">
													<input class="form-control" value="9.00" type="number" name="input9" id="input9">
												</div>
											</div>
											<div class="col-6 col-sm-4 mb-2">
												<div class="form-group">
													<input class="form-control" value="6.00" type="number" name="input10" id="input10">
												</div>
											</div>
										</div>
									</div>  -->
									<div id="wizard_Payment" class="tab-pane" role="tabpanel">
										<div class="row emial-setup">
											<div class="col-lg-3 col-sm-6 col-6">
												<div class="form-group">
													<label for="mailclient11" class="mailclinet mailclinet-gmail">
														<input type="radio" name="emailclient" id="mailclient11">
														<span class="mail-icon">
															<i class="mdi mdi-google-plus" aria-hidden="true"></i>
														</span>
														<span class="mail-text">I'm using Gmail</span>
													</label>
												</div>
											</div>
											<div class="col-lg-3 col-sm-6 col-6">
												<div class="form-group">
													<label for="mailclient12" class="mailclinet mailclinet-office">
														<input type="radio" name="emailclient" id="mailclient12">
														<span class="mail-icon">
															<i class="mdi mdi-office" aria-hidden="true"></i>
														</span>
														<span class="mail-text">I'm using Office</span>
													</label>
												</div>
											</div>
											<div class="col-lg-3 col-sm-6 col-6">
												<div class="form-group">
													<label for="mailclient13" class="mailclinet mailclinet-drive">
														<input type="radio" name="emailclient" id="mailclient13">
														<span class="mail-icon">
															<i class="mdi mdi-google-drive" aria-hidden="true"></i>
														</span>
														<span class="mail-text">I'm using Drive</span>
													</label>
												</div>
											</div>
											<div class="col-lg-3 col-sm-6 col-6">
												<div class="form-group">
													<label for="mailclient14" class="mailclinet mailclinet-another">
														<input type="radio" name="emailclient" id="mailclient14">
														<span class="mail-icon">
															<i class="fas fa-question-circle" aria-hidden="true"></i>
														</span>
														<span class="mail-text">Another Service</span>
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
<!--**********************************
            Content body end
        ***********************************-->



<!--**********************************
        Scripts
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
</script>
@include('CustomSweetAlert');
@endsection
