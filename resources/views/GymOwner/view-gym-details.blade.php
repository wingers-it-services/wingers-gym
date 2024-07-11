@extends('GymOwner.master')
@section('title','Dashboard')
@section('content')
<div class="content-body ">
    <div class="container-fluid">
<div class="page-titles">
<ol class="breadcrumb">
    {{-- <li class="breadcrumb-item"><a href="javascript:void(0)">Bootstrap</a></li> --}}
    <li class="breadcrumb-item active"><a href="javascript:void(0)">View gym member</a></li>
</ol>
</div>
<div class="row">
<div class="col-xl-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Gym Member Details</h4>
        </div>
        <div class="card-body">
            <!-- Nav tabs -->
            <div class="default-tab">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#users"><i class="fa fa-user"></i> User Info</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#subscription"><i class="fa fa-money"></i>     Subscription</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#workout"><i class="fa-solid fa-dumbbell"></i> Workout</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#Diet"><i class="fas fa-egg"></i> Diet</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#bmi"><i class="fa-solid fa-weight-scale"></i> BMI</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#trainers"><i class="fa-solid fa-person-running"></i>Trainers</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="users" role="tabpanel">

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
                                                                        {{-- @foreach ($gymStaff as $staff) --}}
                                                                        <option ></option>
                                                                        {{-- @endforeach --}}
                                                                    </select>
                                                                    <div class="invalid-feedback">
                                                                        Valid last name is required.
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6 mb-3">
                                                                    <label for="lastName">Member Subscription </label>
                                                                    <select class="me-sm-2 form-control default-select" id="designation" name="designation">
                                                                        <option selected>Choose...</option>
                                                                        {{-- @foreach ($gymSubscription as $subscription) --}}
                                                                        <option></option>
                                                                        {{-- @endforeach --}}
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
                    <div class="tab-pane fade" id="subscription">

			<div class="col-xl-12 col-xxl-12">
				<div class="row">
					<div class="col-12">
						<div class="card">
							<div class="card-header d-sm-flex d-block pb-0 border-0">
								<div class="me-auto pe-3">
									<h4 class="text-black fs-20">Subscriptions Plan List</h4>
									{{-- <p class="fs-13 mb-0 text-black">Lorem ipsum dolor sit amet, consectetur</p> --}}
								</div>

								{{-- <div class="dropdown mt-sm-0 mt-3">
									<a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addNewPlan" class="btn btn-outline-primary rounded">Add New Subscription</a>
								</div> --}}
							</div>

							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-bordered table-striped verticle-middle table-responsive-sm">
										<thead>
											<tr>
												<th scope="col">Plan</th>
												<th scope="col">Amount</th>
												<th scope="col">Validity</th>
												<th scope="col">Progress</th>
												<th scope="col">Deadline</th>
												<th scope="col">Label</th>
												<th scope="col" class="text-end">Action</th>
											</tr>
										</thead>
										<tbody>

											<tr>
												<td>muskan</td>
												<td>500</td>
												<td>2 Months</td>
												<td>
													<div class="progress" style="background: rgba(255, 193, 7, .1)">
														<div class="progress-bar bg-warning" style="width: 70%;" role="progressbar"><span class="sr-only">70% Complete</span>
														</div>
													</div>
												</td>
												<td>Jun 28,2018</td>
												<td><span class="badge badge-warning">70%</span>
												</td>
												<td class="text-end"><span><a href="javascript:void()" class="me-4" data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i> </a><a href="javascript:void()" data-bs-toggle="tooltip" data-placement="top" title="Close"><i class="fas fa-times color-danger"></i></a></span>
												</td>
											</tr>

										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
                    </div>
                    <div class="tab-pane fade" id="workout">
                        <div class="modal fade" id="addNewWorkout">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add New Workout</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="/gym-subscription">
                                            @csrf
                                            <div class="form-group">
                                                <label>Excerise Name</label>
                                                <input type="text" id="subscription_name" name="subscription_name" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Sets</label>
                                                <input type="number" name="validity" min="0" max="1000" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Reps</label>
                                                <input type="number" name="amount" class="form-control" name="" min="0" required />
                                            </div>
                                            <div class="form-group">
                                                <label>Weight</label>
                                                <input type="text" name="start_date" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea type="text" rows="10" name="description" class="form-control" required></textarea>
                                            </div>

                                            <button class="btn btn-primary">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-xl-12 col-xxl-12">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header d-sm-flex d-block pb-0 border-0">
                                            <div class="me-auto pe-3">
                                                <h4 class="text-black fs-20">Work Out</h4>
                                                <p class="fs-13 mb-0 text-black">Lorem ipsum dolor sit amet, consectetur</p>
                                            </div>

                                            <div class="dropdown mt-sm-0 mt-3">
                                                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addNewWorkout" class="btn btn-outline-primary rounded">Add New Subscription</a>
                                            </div>
                                        </div>

                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Excerise Name</th>
                                                            <th scope="col">Sets</th>
                                                            <th scope="col">Reps</th>
                                                            <th scope="col">Weight</th>
                                                            <th scope="col">Notes</th>

                                                            <th scope="col" class="text-end">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <tr>
                                                            <td>Push ups</td>
                                                            <td>10 sets</td>
                                                            <td>5 Reps</td>

                                                            <td>60 kg</td>
                                                            <td><span class="badge badge-warning">70%</span>
                                                            </td>
                                                            <td class="text-end"><span><a href="javascript:void()" class="me-4" data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i> </a><a href="javascript:void()" data-bs-toggle="tooltip" data-placement="top" title="Close"><i class="fas fa-times color-danger"></i></a></span>
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="Diet">
                        <div class="modal fade" id="addNewDiet">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add New Diet</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                            <div class="form-group">
                                                <label>Diet Plan</label>
                                                <input type="text" id="subscription_name" name="subscription_name" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Sets</label>
                                                <input type="number" name="validity" min="0" max="1000" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Reps</label>
                                                <input type="number" name="amount" class="form-control" name="" min="0" required />
                                            </div>
                                            <div class="form-group">
                                                <label>Weight</label>
                                                <input type="text" name="start_date" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea type="text" rows="10" name="description" class="form-control" required></textarea>
                                            </div>

                                            <button class="btn btn-primary">Submit</button>

                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-xl-12 col-xxl-12">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header d-sm-flex d-block pb-0 border-0">
                                            <div class="me-auto pe-3">
                                                <h4 class="text-black fs-20">Diet plan list</h4>
                                                <p class="fs-13 mb-0 text-black">Lorem ipsum dolor sit amet, consectetur</p>
                                            </div>

                                            <div class="dropdown mt-sm-0 mt-3">
                                                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addNewDiet" class="btn btn-outline-primary rounded">Add New Subscription</a>
                                            </div>
                                        </div>

                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Excerise Name</th>
                                                            <th scope="col">Sets</th>
                                                            <th scope="col">Reps</th>
                                                            <th scope="col">Weight</th>
                                                            <th scope="col">Notes</th>

                                                            <th scope="col" class="text-end">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <tr>
                                                            <td>Push ups</td>
                                                            <td>10 sets</td>
                                                            <td>5 Reps</td>

                                                            <td>60 kg</td>
                                                            <td><span class="badge badge-warning">70%</span>
                                                            </td>
                                                            <td class="text-end"><span><a href="javascript:void()" class="me-4" data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i> </a><a href="javascript:void()" data-bs-toggle="tooltip" data-placement="top" title="Close"><i class="fas fa-times color-danger"></i></a></span>
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="bmi">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <!-- Left section -->
                                    <div class="col-lg-4 order-lg-1">
                                        {{-- <h4 class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="text-black">Body Mesurement</span>
                                        </h4> --}}
                                    {{-- <hr class="mb-4"> --}}
                                        <form class="needs-validation" novalidate="" action="/add-user-by-gym" method="post">
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label for="firstName">Chest (cm)</label>
                                                    <input type="text" class="form-control" id="firstName" name="firstName" placeholder="" required="">
                                                    <div class="invalid-feedback">Valid first name is required.</div>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="lastName">Triceps (cm)</label>
                                                    <input type="text" class="form-control" id="lastName" name="lastName" placeholder="" required="">
                                                    <div class="invalid-feedback">Valid last name is required.</div>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="email">Biceps (cm)</label>
                                                    <input type="email" class="form-control" id="email">
                                                    <div class="invalid-feedback">Please enter a valid email address.</div>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="memberNumber">Lats (cm)</label>
                                                    <input type="text" class="form-control" id="memberNumber" name="memberNumber" placeholder="" required="">
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="memberNumber">Shoulder (cm)</label>
                                                    <input type="text" class="form-control" id="memberNumber" name="memberNumber" placeholder="" required="">
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="memberNumber">Abs
                                                        (cm)</label>
                                                    <input type="text" class="form-control" id="memberNumber" name="memberNumber" placeholder="" required="">
                                                </div>

                                            </div>
                                        </form>
                                    </div>

                                    <!-- Center section for the human body skeleton -->
                                    <div class="col-lg-4 order-lg-2 text-center mb-4">
                                        <img src="/images/bmi_images/male-skeleton.png" alt="Human Body Skeleton" style="margin-top: 20px;">
                                    </div>

                                    <!-- Right section -->

                                    <div class="col-lg-4 order-lg-3">

                                        <form class="needs-validation" novalidate="" action="/add-user-by-gym" method="post">
                                            <div class="row">
                                                <div class="col-md-12 mb-3">

                                                    <label for="firstName">Furams (cm)</label>
                                                    <input type="text" class="form-control" id="firstName" name="firstName" placeholder="" required="">
                                                    <div class="invalid-feedback">Valid first name is required.</div>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="lastName">Traps (cm)</label>
                                                    <input type="text" class="form-control" id="lastName" name="lastName" placeholder="" required="">
                                                    <div class="invalid-feedback">Valid last name is required.</div>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="email">Glutes (cm)</label>
                                                    <input type="email" class="form-control" id="email">
                                                    <div class="invalid-feedback">Please enter a valid email address.</div>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="memberNumber">Quades (cm)</label>
                                                    <input type="text" class="form-control" id="memberNumber" name="memberNumber" placeholder="" required="">
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="memberNumber">Hamtring (cm)</label>
                                                    <input type="text" class="form-control" id="memberNumber" name="memberNumber" placeholder="" required="">
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="memberNumber">Claves
                                                        (cm)</label>
                                                    <input type="text" class="form-control" id="memberNumber" name="memberNumber" placeholder="" required="">
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- BMI Calculation Section -->
                                <div class="row mt-5">
                                    <div class="col-lg-12">
                                        <h4 class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="text-black">Calculate BMI</span>
                                        </h4>
                                        <form class="needs-validation" novalidate="">
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label for="height">Height (cm)</label>
                                                    <input type="number" class="form-control" id="height" placeholder="Enter height in cm" required="">
                                                    <div class="invalid-feedback">Height is required.</div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="weight">Weight (kg)</label>
                                                    <input type="number" class="form-control" id="weight" placeholder="Enter weight in kg" required="">
                                                    <div class="invalid-feedback">Weight is required.</div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="bmi">BMI</label>
                                                    <input type="text" class="form-control" id="bmi" placeholder="BMI will be calculated" readonly>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <button type="button" class="btn btn-primary btn-lg btn-block" onclick="calculateBMI()">Calculate BMI</button>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <button type="reset" class="btn btn-secondary btn-lg btn-block">Reset</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- End of BMI Calculation Section -->
                                <div class="col-xl-12 col-xxl-12">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header d-sm-flex d-block pb-0 border-0">
                                                    <div class="me-auto pe-3">
                                                        <h4 class="text-black fs-20">BMI List</h4>
                                                        {{-- <p class="fs-13 mb-0 text-black">Lorem ipsum dolor sit amet, consectetur</p> --}}
                                                    </div>

                                                    {{-- <div class="dropdown mt-sm-0 mt-3">
                                                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addNewPlan" class="btn btn-outline-primary rounded">Add New Subscription</a>
                                                    </div> --}}
                                                </div>

                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">Plan</th>
                                                                    <th scope="col">Amount</th>
                                                                    <th scope="col">Validity</th>
                                                                    <th scope="col">Progress</th>
                                                                    <th scope="col">Deadline</th>
                                                                    <th scope="col">Label</th>
                                                                    <th scope="col" class="text-end">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                <tr>
                                                                    <td>muskan</td>
                                                                    <td>500</td>
                                                                    <td>2 Months</td>
                                                                    <td>
                                                                        <div class="progress" style="background: rgba(255, 193, 7, .1)">
                                                                            <div class="progress-bar bg-warning" style="width: 70%;" role="progressbar"><span class="sr-only">70% Complete</span>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>Jun 28,2018</td>
                                                                    <td><span class="badge badge-warning">70%</span>
                                                                    </td>
                                                                    <td class="text-end"><span><a href="javascript:void()" class="me-4" data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i> </a><a href="javascript:void()" data-bs-toggle="tooltip" data-placement="top" title="Close"><i class="fas fa-times color-danger"></i></a></span>
                                                                    </td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="trainers">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-lg-8 order-lg-1">
                                        <form class="needs-validation" novalidate="" action="/add-user-by-gym" method="post">

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="lastName">Trainer</label>
                                                    <select class="me-sm-2 form-control default-select" id="designation" name="designation">
                                                        <option selected>Choose...</option>
                                                        {{-- @foreach ($gymStaff as $staff) --}}
                                                        <option ></option>
                                                        {{-- @endforeach --}}
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Valid last name is required.
                                                    </div>
                                                </div>

                                            </div>
                                            <hr>
                                            <input type="submit" class="btn btn-primary" value="Submit">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



</div>
</div>
</div>


@endsection
