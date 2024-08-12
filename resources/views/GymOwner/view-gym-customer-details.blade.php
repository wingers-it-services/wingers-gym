@extends('GymOwner.master')
@section('title', 'Dashboard')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
    .nav-link i {
        font-size: 14px;
        /* Adjust the size as needed */
        margin-right: 8px;
        /* Add space between icon and text */
    }
</style>
<div class="content-body ">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
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
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-12 col-sm-12">
                                        <div class="card overflow-hidden">
                                            <div class="text-center p-3 overlay-box" style="background-image: url(https://fito.dexignzone.com/laravel/demo/images/big/img1.jpg);">
                                                <div class="profile-photo">
                                                    <img src="{{ asset($userDetail->image) }}" width="100" class="img-fluid rounded-circle" alt="">
                                                </div>
                                                <h3 class="mt-3 mb-1 text-white">{{ $userDetail->firstname }} {{ $userDetail->lastname }} </h3>
                                                <p class="text-white mb-0">Email: {{ $userDetail->email }} Phone: {{ $userDetail->phone_no }}</p>
                                                <p class="text-white mb-0">Gender: {{ $userDetail->gender }} Password: {{ $userDetail->password }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-12 col-sm-12">
                                        <div class="card overflow-hidden">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Member Subscription</span> <strong class="text-muted">{{ $userDetail->subscription->subscription_name }} </strong></li>
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span class="mb-0">Staff Assigned</span>
                                                    @if($userDetail->staff)
                                                    <strong class="text-muted">{{ $userDetail->staff->name }}</strong>
                                                    @endif
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Member Blood Group</span> <strong class="text-muted">{{ $userDetail->blood_group}} </strong></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Joining Date</span> <strong class="text-muted">{{ $userDetail->joining_date }}</strong></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-12 col-sm-12">
                                        <div class="card overflow-hidden">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Address</span> <strong class="text-muted">{{ $userDetail->address }} </strong></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Country</span> <strong class="text-muted">{{ $userDetail->country }}</strong></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0">State</span> <strong class="text-muted">{{ $userDetail->state }}</strong></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Zip</span> <strong class="text-muted">{{ $userDetail->zip_code }}</strong></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-12 col-sm-12">
                                        <div class="card overflow-hidden">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0">End Date</span> <strong class="text-muted">{{ $userDetail->end_date }} </strong></li>
                                                <!-- <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Email</span> <strong class="text-muted">{{ $userDetail->email }}</strong></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Phone Number</span> <strong class="text-muted">{{ $userDetail->member_number }}</strong></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Gender</span> <strong class="text-muted">{{ $userDetail->gender}}</strong></li> -->
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
                                    <a class="nav-link active" data-bs-toggle="tab" href="#subscription"><i class="fa fa-money"></i> Subscription</a>
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
                                    <a class="nav-link" data-bs-toggle="tab" href="#trainers"><i class="fa-solid fa-person-running"></i> Trainers</a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="subscription">
                                    <div class="modal fade" id="addNewSubscription">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Add Subscription</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('addUserSubscriptionByGym') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="user_id" value="{{ $userDetail->id }}">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <!-- Subscription Selection -->
                                                                <h4 class="mb-3 text-black">Select Subscription</h4>
                                                                <div class="mb-3">
                                                                    <select class="form-control default-select" id="subscription_id" name="subscription_id" required>
                                                                        <option value="" data-description="" data-amount="" data-validity="">-- Select Subscription --</option>
                                                                        @foreach ($gymSubscriptions as $subscription)
                                                                        <option value="{{ $subscription->id }}" data-description="{{ $subscription->description }}" data-amount="{{ $subscription->amount }}" data-validity="{{ $subscription->validity }}">
                                                                            {{ $subscription->subscription_name }}
                                                                        </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <!-- Subscription Description -->
                                                                <h4 class="mb-3 text-black">Subscription Description</h4>
                                                                <div class="mb-3">
                                                                    <textarea class="form-control" id="description" name="description" required readonly></textarea>
                                                                </div>
                                                                <!-- Joining Date -->
                                                                <div class="mb-3">
                                                                    <label for="joining_date" class="form-label">Member Joining Date</label>
                                                                    <input type="date" class="form-control" id="joining_date" name="joining_date" required>
                                                                </div>
                                                                <!-- Amount and End Date -->
                                                                <ul class="list-group mb-3">
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
                                                                            <input type="hidden" id="end_date" name="end_date">
                                                                        </div>
                                                                        <span class="text-muted" id="subscription_end_date"></span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="dropdown mt-sm-0 mt-3">
                                                            <button type="submit" id="addSubscriptionButton" class="btn btn-outline-primary rounded">Add Subscription</button>
                                                        </div>
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
                                                            <h4 class="text-black fs-20">Subscriptions Plan List</h4>
                                                        </div>

                                                        <div class="dropdown mt-sm-0 mt-3">
                                                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addNewSubscription" class="btn btn-outline-primary rounded">Add Subscription</a>
                                                        </div>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table id="example3" class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">Plan</th>
                                                                        <th scope="col">Amount</th>
                                                                        <th scope="col">Validity</th>
                                                                        <th scope="col">Start Date</th>
                                                                        <th scope="col">End Date</th>
                                                                        <th scope="col">Status</th>
                                                                        <th scope="col" class="text-end">Action
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($userSubscriptions as $subscription)
                                                                    <tr>
                                                                        <td>{{$subscription->subscription->subscription_name}}</td>
                                                                        <td>{{$subscription->subscription->amount}}</td>
                                                                        <td>{{$subscription->subscription->validity}} Months</td>
                                                                        <td>{{ \Carbon\Carbon::parse($subscription->joining_date)->format('M d, Y') }}</td>
                                                                        <td>{{ \Carbon\Carbon::parse($subscription->end_date)->format('M d, Y') }}</td>
                                                                        <td>

                                                                            {{ $subscription->status == \App\Enums\GymSubscriptionStatusEnum::ACTIVE ? 'Active' : ($subscription->status == \App\Enums\GymSubscriptionStatusEnum::INACTIVE ? 'Inactive' : 'Unknown') }}

                                                                        </td>
                                                                        <td class="text-end"><span><a href="javascript:void()" class="me-4" data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i>
                                                                                </a><a href="javascript:void()" data-bs-toggle="tooltip" data-placement="top" title="Close"><i class="fas fa-times color-danger"></i></a></span>
                                                                        </td>
                                                                    </tr>
                                                                    @endforeach
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
                                                    <form autocomplete="off" method="POST" action="/add-user-workout">
                                                        @csrf
                                                        <input type="text" id="user_id" name="user_id" value="{{$userDetail->id}}" class="form-control" hidden>
                                                        <div class="form-group">
                                                            <label>Excerise Name</label>
                                                            <div class="autocomplete">
                                                                <input id="workoutInput" type="text" name="exercise_name" placeholder="Workout Name" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Sets</label>
                                                            <input type="number" name="sets" min="0" max="1000" class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Reps</label>
                                                            <input type="number" name="reps" class="form-control" name="" min="0" required />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Weight</label>
                                                            <input type="number" name="weight" placeholder="Enter Weight in Kg" class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Description</label>
                                                            <textarea type="text" rows="10" name="notes" class="form-control" required></textarea>
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
                                                            <p class="fs-13 mb-0 text-black">Lorem ipsum dolor sit
                                                                amet, consectetur</p>
                                                        </div>

                                                        <div class="dropdown mt-sm-0 mt-3">
                                                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addNewWorkout" class="btn btn-outline-primary rounded">Add Workout</a>
                                                        </div>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table id="example3" class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">Excerise Name</th>
                                                                        <th scope="col">Sets</th>
                                                                        <th scope="col">Reps</th>
                                                                        <th scope="col">Weight</th>
                                                                        <th scope="col">Label</th>

                                                                        <th scope="col" class="text-end">Action
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($workouts as $workout)
                                                                    <tr>
                                                                        <td>{{$workout->exercise_name}}</td>
                                                                        <td>{{$workout->sets}} sets</td>
                                                                        <td>{{$workout->reps}} Reps</td>

                                                                        <td>{{$workout->weight}} kg</td>
                                                                        <td><span class="badge badge-warning">70%</span>
                                                                        </td>
                                                                        <td class="text-end"><span> <a href="javascript:void(0);" class="me-4 edit-workout" data-bs-toggle="tooltip" data-placement="top" title="Edit" data-workout="{{ json_encode($workout) }}">
                                                                                    <i class="fa fa-pencil color-muted"></i>
                                                                                </a><a onclick="confirmDelete('{{ $workout->uuid }}')" href="javascript:void()" data-bs-toggle="tooltip" data-placement="top" title="Close"><i class="fas fa-times color-danger"></i></a></span>
                                                                        </td>
                                                                    </tr>
                                                                    @endforeach
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
                                                    <form method="POST" action="/add-user-diet">
                                                        @csrf
                                                        <input type="text" id="user_id" name="user_id" value="{{$userDetail->id}}" class="form-control" hidden>
                                                        <div class="form-group">
                                                            <label>Meal Name</label>
                                                            <input type="text" id="meal_name" name="meal_name" class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Calories</label>
                                                            <input type="number" name="calories" min="0" max="1000" class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Protein</label>
                                                            <input type="number" name="protein" class="form-control" name="" min="0" required />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Carbs</label>
                                                            <input type="number" name="carbs" class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Fats</label>
                                                            <input type="number" name="fats" class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Description</label>
                                                            <textarea type="text" rows="10" name="notes" class="form-control" required></textarea>
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
                                                            <h4 class="text-black fs-20">Diet plan list</h4>
                                                            <p class="fs-13 mb-0 text-black">Lorem ipsum dolor sit
                                                                amet, consectetur</p>
                                                        </div>

                                                        <div class="dropdown mt-sm-0 mt-3">
                                                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addNewDiet" class="btn btn-outline-primary rounded">Add Diet</a>
                                                        </div>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table id="example3" class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">Meal Name</th>
                                                                        <th scope="col">Calories</th>
                                                                        <th scope="col">Protein</th>
                                                                        <th scope="col">Carbs</th>
                                                                        <th scope="col">Fats</th>
                                                                        <th scope="col">Label</th>
                                                                        <th scope="col" class="text-end">Action
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($diets as $diet)
                                                                    <tr>
                                                                        <td>{{$diet->meal_name}}</td>
                                                                        <td>{{$diet->calories}} gm</td>
                                                                        <td>{{$diet->protein}} gm</td>

                                                                        <td>{{$diet->carbs}} gm</td>
                                                                        <td>{{$diet->fats}} gm</td>
                                                                        <td><span class="badge badge-warning">70%</span>
                                                                        </td>
                                                                        <td class="text-end"><span> <a href="javascript:void(0);" class="me-4 edit-diet" data-bs-toggle="tooltip" data-placement="top" title="Edit" data-diet="{{ json_encode($diet) }}">
                                                                                    <i class="fa fa-pencil color-muted"></i>
                                                                                </a><a href="javascript:void()" onclick="confirmDietDelete('{{ $diet->uuid }}')" data-bs-toggle="tooltip" data-placement="top" title="Close"><i class="fas fa-times color-danger"></i></a></span>
                                                                        </td>
                                                                    </tr>
                                                                    @endforeach
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
                                    <form class="needs-validation" id="bmiForm" novalidate="" action="{{ route('addUserBodyMeasurement') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <!-- Left section -->
                                                    <div class="col-lg-4 order-lg-1">
                                                        <div class="row">
                                                            <input type="hidden" name="user_id" value="{{ $userDetail->id }}">
                                                            <div class="col-md-12 mb-3">
                                                                <label for="chest">Chest (cm)</label>
                                                                <input type="text" class="form-control" id="chest" name="chest" placeholder="" required="">
                                                                <div class="invalid-feedback">Valid first name is
                                                                    required.</div>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label for="triceps">Triceps (cm)</label>
                                                                <input type="text" class="form-control" id="triceps" name="triceps" placeholder="" required="">
                                                                <div class="invalid-feedback">Valid last name is
                                                                    required.</div>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label for="biceps">Biceps (cm)</label>
                                                                <input type="email" class="form-control" id="biceps" name="biceps">
                                                                <div class="invalid-feedback">Please enter a valid
                                                                    email address.</div>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label for="lats">Lats (cm)</label>
                                                                <input type="text" class="form-control" id="lats" name="lats" placeholder="" required="">
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label for="shoulder">Shoulder (cm)</label>
                                                                <input type="text" class="form-control" id="shoulder" name="shoulder" placeholder="" required="">
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label for="abs">Abs
                                                                    (cm)</label>
                                                                <input type="text" class="form-control" id="abs" name="abs" placeholder="" required="">
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <!-- Center section for the human body skeleton -->
                                                    <div class="col-lg-4 order-lg-2 text-center mb-4">
                                                        <img src="/images/bmi_images/male-skeleton.png" alt="Human Body Skeleton" style="margin-top: 20px; margin-left:-46px;">
                                                    </div>

                                                    <!-- Right section -->

                                                    <div class="col-lg-4 order-lg-3">

                                                        <div class="row">
                                                            <div class="col-md-12 mb-3">

                                                                <label for="forearms">Furams (cm)</label>
                                                                <input type="text" class="form-control" id="forearms" name="forearms" placeholder="" required="">
                                                                <div class="invalid-feedback">Valid first name is
                                                                    required.</div>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label for="traps">Traps (cm)</label>
                                                                <input type="text" class="form-control" id="traps" name="traps" placeholder="" required="">
                                                                <div class="invalid-feedback">Valid last name is
                                                                    required.</div>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label for="glutes">Glutes (cm)</label>
                                                                <input type="email" class="form-control" id="glutes" name="glutes">
                                                                <div class="invalid-feedback">Please enter a valid
                                                                    email address.</div>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label for="quads">Quades (cm)</label>
                                                                <input type="text" class="form-control" id="quads" name="quads" placeholder="" required="">
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label for="hamstring">Hamtring (cm)</label>
                                                                <input type="text" class="form-control" id="hamstring" name="hamstring" placeholder="" required="">
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label for="calves">Claves
                                                                    (cm)</label>
                                                                <input type="text" class="form-control" id="calves" name="calves" placeholder="" required="">
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- BMI Calculation Section -->
                                        <div class="row mt-5">
                                            <div class="col-lg-12">
                                                <h4 class="d-flex justify-content-between align-items-center mb-3">
                                                    <span class="text-black">Calculate BMI</span>
                                                </h4>
                                                <div class="row">
                                                    <div class="col-md-4 mb-3">
                                                        <label for="height">Height (cm)</label>
                                                        <input type="number" class="form-control" id="height" name="height" placeholder="Enter height in cm" required>
                                                        <div class="invalid-feedback">Height is required.</div>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label for="bmi_weight">Weight (kg)</label>
                                                        <input type="number" class="form-control" id="bmi_weight" name="weight" placeholder="Enter weight in kg" required>
                                                        <div class="invalid-feedback">Weight is required.</div>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label for="bmi">BMI</label>
                                                        <input type="number" class="form-control" id="calculatedBmi" name="bmi" placeholder="BMI will be calculated" readonly>
                                                        <!-- <input type="hidden" name="bmi" id="calculatedBmi" required class="form-control"> -->
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mb-3">
                                                        <button type="button" class="btn btn-primary btn-lg btn-block" onclick="calculateBMI()">Calculate BMI</button>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <button type="submit" class="btn btn-secondary btn-lg btn-block">Submit</button>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <button type="reset" class="btn btn-secondary btn-lg btn-block">Reset</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- End of BMI Calculation Section -->
                                    <div class="col-xl-12 col-xxl-12">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-header d-sm-flex d-block pb-0 border-0">
                                                        <div class="me-auto pe-3">
                                                            <h4 class="text-black fs-20">BMI List</h4>
                                                        </div>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table id="example3" class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">Height</th>
                                                                        <th scope="col">Weight</th>
                                                                        <th scope="col">BMI</th>
                                                                        <!-- <th scope="col">Progress</th>
                                                                        <th scope="col">Deadline</th>
                                                                        <th scope="col">Label</th> -->
                                                                        <th scope="col" class="text-end">
                                                                            Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($bmis as $bmi)
                                                                    <tr>
                                                                        <td>{{$bmi->height}}</td>
                                                                        <td>{{$bmi->weight}}</td>
                                                                        <td>{{$bmi->bmi}}</td>
                                                                        <!-- <td>
                                                                            <div class="progress" style="background: rgba(255, 193, 7, .1)">
                                                                                <div class="progress-bar bg-warning" style="width: 70%;" role="progressbar"><span class="sr-only">70%
                                                                                        Complete</span>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>Jun 28,2018</td>
                                                                        <td><span class="badge badge-warning">70%</span> -->
                                                                        </td>
                                                                        <td class="text-end"><span><a href="javascript:void()" class="me-4" data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i>
                                                                                </a><a href="javascript:void()" data-bs-toggle="tooltip" data-placement="top" title="Close"><i class="fas fa-times color-danger"></i></a></span>
                                                                        </td>
                                                                    </tr>
                                                                    @endforeach
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
                                <form id="trainerForm" action="{{ route('allotTrainer') }}" method="POST" class="form-horizontal">
                                    @csrf
                                    <div class="card-body">
                                        <div class="row">

                                            <div class="col-lg-8 order-lg-1">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">

                                                        <label for="trainer">Select a Trainer:</label>
                                                        <select class="me-sm-2 form-control default-select" id="trainer" name="trainer_id">
                                                            <option value="0">Select</option>
                                                            @foreach ($trainers as $trainer)
                                                            <option value="{{$trainer->id}}">{{$trainer->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <br><br>
                                                        <input type="hidden" name="user_id" value="{{$userDetail->id}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <input type="submit" class="btn btn-primary" value="Submit">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editWorkoutModal" tabindex="-1" role="dialog" aria-labelledby="editWorkoutModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Workout</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editWorkoutForm" method="POST" action="/update-user-workout">
                            @csrf
                            <input type="hidden" id="edit_user_id" name="user_id" value="{{$userDetail->id}}">
                            <input type="hidden" id="edit_workout_id" name="workout_id">
                            <div class="form-group">
                                <label>Exercise Name</label>
                                <input type="text" id="edit_exercise_name" name="exercise_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Sets</label>
                                <input type="number" id="edit_sets" name="sets" min="0" max="1000" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Reps</label>
                                <input type="number" id="edit_reps" name="reps" class="form-control" min="0" required />
                            </div>
                            <div class="form-group">
                                <label>Weight</label>
                                <input type="number" id="edit_weight" name="weight" placeholder="Enter Weight in Kg" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea type="text" id="edit_notes" rows="10" name="notes" class="form-control" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editDietModal" tabindex="-1" role="dialog" aria-labelledby="editDietModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Diet</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editDietForm" method="POST" action="/update-user-diet">
                            @csrf
                            <input type="hidden" id="edit_diet_id" name="diet_id">
                            <input type="hidden" id="edit_user_id" name="user_id" value="{{$userDetail->id}}">
                            <div class="form-group">
                                <label>Meal Name</label>
                                <input type="text" id="edit_meal_name" name="meal_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Calories</label>
                                <input type="number" id="edit_calories" name="calories" min="0" max="1000" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Protein</label>
                                <input type="number" id="edit_protein" name="protein" class="form-control" min="0" required />
                            </div>
                            <div class="form-group">
                                <label>Carbs</label>
                                <input type="number" id="edit_carbs" name="carbs" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Fats</label>
                                <input type="number" id="edit_fats" name="fats" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea type="text" id="diet_edit_notes" rows="10" name="notes" class="form-control" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit-workout');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const workout = JSON.parse(this.dataset.workout);

                document.getElementById('edit_workout_id').value = workout.id;
                document.getElementById('edit_exercise_name').value = workout.exercise_name;
                document.getElementById('edit_sets').value = workout.sets;
                document.getElementById('edit_reps').value = workout.reps;
                document.getElementById('edit_weight').value = workout.weight;
                document.getElementById('edit_notes').value = workout.notes;

                new bootstrap.Modal(document.getElementById('editWorkoutModal')).show();
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit-diet');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const diet = JSON.parse(this.getAttribute('data-diet'));

                document.getElementById('edit_diet_id').value = diet.id;
                document.getElementById('edit_meal_name').value = diet.meal_name;
                document.getElementById('edit_calories').value = diet.calories;
                document.getElementById('edit_protein').value = diet.protein;
                document.getElementById('edit_carbs').value = diet.carbs;
                document.getElementById('edit_fats').value = diet.fats;
                document.getElementById('diet_edit_notes').value = diet.notes;

                new bootstrap.Modal(document.getElementById('editDietModal')).show();
            });
        });
    });

    function confirmDelete(uuid) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Are you sure you want to delete this workout?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/delete-workout/' + uuid;
            }
        });
    }

    function confirmDietDelete(uuid) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Are you sure you want to delete this workout?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/delete-diet/' + uuid;
            }
        });
    }

    document.getElementById('subscription_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const amount = selectedOption.getAttribute('data-amount');
        const description = selectedOption.getAttribute('data-description');
        const validity = selectedOption.getAttribute('data-validity');

        // Set the amount and description in the form
        document.getElementById('amount').value = amount;
        document.getElementById('subscription_amount').innerText = '₹' + amount;
        document.getElementById('description').value = description;

        // Calculate and set the end date
        const joiningDate = document.getElementById('joining_date').value;
        if (joiningDate) {
            const endDate = new Date(joiningDate);
            endDate.setMonth(endDate.getMonth() + parseInt(validity));
            document.getElementById('end_date').value = endDate.toISOString().split('T')[0];
            document.getElementById('subscription_end_date').innerText = endDate.toISOString().split('T')[0];
        }
    });

    document.getElementById('joining_date').addEventListener('change', function() {
        const selectedOption = document.getElementById('subscription_id').options[document.getElementById('subscription_id').selectedIndex];
        const validity = selectedOption.getAttribute('data-validity');

        const endDate = new Date(this.value);
        endDate.setMonth(endDate.getMonth() + parseInt(validity));
        document.getElementById('end_date').value = endDate.toISOString().split('T')[0];
        document.getElementById('subscription_end_date').innerText = endDate.toISOString().split('T')[0];
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

    // document.querySelector('#addSubscriptionButton').addEventListener('click', function() {
    //     const userId = @json($userDetail -> id); // Get the user ID
    //     const subscriptionId = document.querySelector('#subscription_id').value;
    //     const joiningDate = document.querySelector('#joining_date').value;
    //     const amount = document.querySelector('#amount').value;
    //     const endDate = document.querySelector('#end_date').value;

    //     fetch(`/check-subscription/${userId}`, {
    //             method: 'POST',
    //             headers: {
    //                 'Content-Type': 'application/json',
    //                 'X-CSRF-TOKEN': '{{ csrf_token() }}'
    //             },
    //             body: JSON.stringify({
    //                 subscription_id: subscriptionId,
    //                 joining_date: joiningDate,
    //                 amount: amount,
    //                 end_date: endDate
    //             })
    //         })
    //         .then(response => response.json())
    //         .then(data => {
    //             if (data.status === 'exists') {
    //                 Swal.fire({
    //                     icon: 'info',
    //                     title: 'Subscription Exists',
    //                     text: `${data.message} The existing subscription ends on ${data.end_date}. Do you want to change the subscription?`,
    //                     showCancelButton: true,
    //                     confirmButtonText: 'Yes, change it!',
    //                     cancelButtonText: 'No, keep it'
    //                 }).then((result) => {
    //                     if (result.isConfirmed) {
    //                         // Call the update subscription route
    //                         fetch(`/update-user-subscription/` + userId, {
    //                                 method: 'POST',
    //                                 headers: {
    //                                     'Content-Type': 'application/json',
    //                                     'X-CSRF-TOKEN': '{{ csrf_token() }}'
    //                                 },
    //                                 body: JSON.stringify({
    //                                     subscription_id: subscriptionId,
    //                                     joining_date: joiningDate,
    //                                     amount: amount,
    //                                     end_date: endDate
    //                                 })
    //                             })
    //                             .then(response => response.json())
    //                             .then(data => {
    //                                 Swal.fire({
    //                                     icon: 'success',
    //                                     title: 'Subscription Updated',
    //                                     text: data.message,
    //                                     confirmButtonText: 'OK'
    //                                 }).then((result) => {
    //                                     if (result.isConfirmed) {
    //                                         // Optionally reload the page or update the UI
    //                                         location.reload();
    //                                     }
    //                                 });
    //                             });
    //                     }
    //                 });
    //             } else {
    //                 Swal.fire({
    //                     icon: 'success',
    //                     title: 'Subscription Created',
    //                     text: data.message,
    //                     confirmButtonText: 'OK'
    //                 }).then((result) => {
    //                     if (result.isConfirmed) {
    //                         // Optionally reload the page or update the UI
    //                         location.reload();
    //                     }
    //                 });
    //             }
    //         });
    // });

    function calculateBMI() {
        // Get height and weight values
        const height = document.querySelector('#height').value;
        const weight = document.querySelector('#bmi_weight').value;

        console.log('Height:', height);
        console.log('Weight:', weight);

        // Check if height and weight are not empty and valid
        if (height && weight && height > 0 && weight > 0) {
            // Convert height from cm to meters
            const heightInMeters = height / 100;

            // Calculate BMI
            const bmi = weight / (heightInMeters * heightInMeters);

            // Round BMI to two decimal places
            const roundedBmi = bmi.toFixed(2);

            // Update the BMI input field
            document.querySelector('#bmi').value = roundedBmi;
            document.querySelector('#calculatedBmi').value = roundedBmi;

            console.log('Calculated BMI:', roundedBmi);
        } else {
            // Handle invalid input
            alert('Please enter valid height and weight values.');
        }
    }

    function autocomplete(inp) {
        var currentFocus;

        inp.addEventListener("input", function(e) {
            var val = this.value;
            closeAllLists();
            if (!val) {
                return false;
            }
            currentFocus = -1;
            $.ajax({
                url: "{{ url('/autocomplete-workout') }}",
                type: "GET",
                data: {
                    query: val
                },
                dataType: 'json',
                success: function(data) {
                    a = document.createElement("DIV");
                    a.setAttribute("id", inp.id + "autocomplete-list");
                    a.setAttribute("class", "autocomplete-items");
                    inp.parentNode.appendChild(a);
                    for (i = 0; i < data.length; i++) {
                        b = document.createElement("DIV");
                        b.innerHTML = "<strong>" + data[i].substr(0, val.length) + "</strong>";
                        b.innerHTML += data[i].substr(val.length);
                        b.innerHTML += "<input type='hidden' value='" + data[i] + "'>";
                        b.addEventListener("click", function(e) {
                            inp.value = this.getElementsByTagName("input")[0].value;
                            closeAllLists();
                        });
                        a.appendChild(b);
                    }
                }
            });
        });

        inp.addEventListener("keydown", function(e) {
            var x = document.getElementById(this.id + "autocomplete-list");
            if (x) x = x.getElementsByTagName("div");
            if (e.keyCode == 40) { // down key
                currentFocus++;
                addActive(x);
            } else if (e.keyCode == 38) { // up key
                currentFocus--;
                addActive(x);
            } else if (e.keyCode == 13) { // enter key
                e.preventDefault();
                if (currentFocus > -1) {
                    if (x) x[currentFocus].click();
                }
            }
        });

        function addActive(x) {
            if (!x) return false;
            removeActive(x);
            if (currentFocus >= x.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = (x.length - 1);
            x[currentFocus].classList.add("autocomplete-active");
        }

        function removeActive(x) {
            for (var i = 0; i < x.length; i++) {
                x[i].classList.remove("autocomplete-active");
            }
        }

        function closeAllLists(elmnt) {
            var x = document.getElementsByClassName("autocomplete-items");
            for (var i = 0; i < x.length; i++) {
                if (elmnt != x[i] && elmnt != inp) {
                    x[i].parentNode.removeChild(x[i]);
                }
            }
        }

        document.addEventListener("click", function(e) {
            closeAllLists(e.target);
        });
    }

    /* Initialize the autocomplete function on the workoutInput element */
    autocomplete(document.getElementById("workoutInput"));
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>741
@include('CustomSweetAlert');
@endsection