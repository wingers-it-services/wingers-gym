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

    /* Container for autocomplete items */
    .autocomplete-items {
        position: absolute;
        border: 1px solid #ddd;
        border-top: none;
        z-index: 99;
        background-color: #fff;
        max-height: 150px;
        /* Allows more space for items */
        overflow-y: auto;
        /* Enables scrolling if content exceeds max-height */
        width: 100%;
        /* Ensures dropdown matches the input width */
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        /* Adds slight shadow for better visibility */
    }

    /* Style each item in the autocomplete dropdown */
    .autocomplete-items div {
        padding: 10px;
        cursor: pointer;
        background-color: #fff;
        border-bottom: 1px solid #ddd;
    }

    /* Style the active item in the autocomplete dropdown */
    .autocomplete-active {
        background-color: #007bff;
        /* Matches the primary color */
        color: #fff;
    }
</style>
<div class="content-body ">
    <div class="container-fluid">
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
                                            <div class="text-center p-3 overlay-box"
                                                style="background-image: url(https://fito.dexignzone.com/laravel/demo/images/big/img1.jpg);">
                                                <div class="profile-photo">
                                                    <img src="{{ asset($userDetail->image) }}" width="100"
                                                        class="img-fluid rounded-circle" alt="">
                                                </div>
                                                <h3 class="mt-3 mb-1 text-white">{{ $userDetail->firstname }}
                                                    {{ $userDetail->lastname }}
                                                </h3>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-12 col-sm-12">
                                        <div class="card overflow-hidden">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item d-flex justify-content-between"><span
                                                        class="mb-0">Email</span> <strong
                                                        class="text-muted">{{ $userDetail->email }}</strong></li>
                                                <li class="list-group-item d-flex justify-content-between"><span
                                                        class="mb-0">Phone</span> <strong
                                                        class="text-muted">{{ $userDetail->phone_no  }}</strong></li>
                                                <li class="list-group-item d-flex justify-content-between"><span
                                                        class="mb-0">Gender</span> <strong
                                                        class="text-muted">{{ $userDetail->gender }}</strong></li>
                                                <li class="list-group-item d-flex justify-content-between"><span
                                                        class="mb-0">Member Blood Group</span> <strong
                                                        class="text-muted">{{ $userDetail->blood_group}} </strong></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-12 col-sm-12">
                                        <div class="card overflow-hidden">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span class="mb-0">Staff Assigned</span>
                                                    <strong
                                                        class="text-muted">{{ $userDetail->activeTrainers->first()->trainer->name ?? 'No active trainer' }}</strong>
                                                </li>

                                                <li class="list-group-item d-flex justify-content-between"><span
                                                        class="mb-0">Country</span> <strong
                                                        class="text-muted">{{ $userDetail->country }}</strong></li>
                                                <li class="list-group-item d-flex justify-content-between"><span
                                                        class="mb-0">State</span> <strong
                                                        class="text-muted">{{ $userDetail->state }}</strong></li>
                                                <li class="list-group-item d-flex justify-content-between"><span
                                                        class="mb-0">Zip</span> <strong
                                                        class="text-muted">{{ $userDetail->zip_code }}</strong></li>
                                                <div class="container mt-5">
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-12 col-sm-12">
                                        <div class="card overflow-hidden">
                                            <ul class="list-group list-group-flush">


                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <div class="row">
                                                            <div class="col-auto">
                                                                <span class="mb-0">Address</span>
                                                            </div>
                                                            <div class="col">
                                                                <strong
                                                                    class="text-muted text-wrap">{{ $userDetail->address }}</strong>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                        </div>
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
                                <a class="nav-link active" data-bs-toggle="tab" href="#subscription"><i
                                        class="fa fa-money"></i> Subscription</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#workout"><i
                                        class="fa-solid fa-dumbbell"></i> Workout</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#Diet"><i class="fas fa-egg"></i>
                                    Diet</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#bmi"><i
                                        class="fa-solid fa-weight-scale"></i> BMI</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#trainers"><i
                                        class="fa-solid fa-person-running"></i> Trainers</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="subscription">
                                <div class="modal fade" id="addNewSubscription">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Add Subscription</h5>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="subscriptionForm" class="needs-validation"
                                                    action="{{ route('addUserSubscriptionByGym') }}" method="POST"
                                                    novalidate>
                                                    @csrf
                                                    <input type="hidden" name="user_id" value="{{ $userDetail->id }}">
                                                    <input type="hidden" id="fetched_start_date" value="">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <!-- Subscription Selection -->
                                                            <h4 class="mb-3 text-black">Select Subscription</h4>
                                                            <div class="mb-3">
                                                                <select class="form-control default-select"
                                                                    id="subscription_id" name="subscription_id"
                                                                    required>
                                                                    <option value="" data-description="" data-amount=""
                                                                        data-validity="">-- Select
                                                                        Subscription --</option>
                                                                    @foreach ($gymSubscriptions as $subscription)
                                                                        <option value="{{ $subscription->id }}"
                                                                            data-description="{{ $subscription->description }}"
                                                                            data-amount="{{ $subscription->amount }}"
                                                                            data-validity="{{ $subscription->validity }}"
                                                                            data-start-date="{{ $subscription->start_date }}">
                                                                            {{ $subscription->subscription_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="invalid-feedback">
                                                                    Choose a Subscription.
                                                                </div>
                                                            </div>
                                                            <!-- Subscription Description -->
                                                            <h4 class="mb-3 text-black">Subscription Description
                                                            </h4>
                                                            <div class="mb-3">
                                                                <textarea class="form-control" id="description"
                                                                    rows="10" name="description" required
                                                                    readonly></textarea>
                                                            </div>
                                                            <!-- Joining Date -->
                                                            <div class="mb-3">
                                                                <label for="joining_date" class="form-label">Subscripion
                                                                    Start
                                                                    Date</label>
                                                                <input type="date" class="form-control"
                                                                    id="joining_date" name="subscription_start_date"
                                                                    required>
                                                                <small id="subError" class="text-danger"
                                                                    style="display: none;">The selected start date
                                                                    cannot be before the Selected subscription start
                                                                    date .</small>
                                                                <div class="invalid-feedback">
                                                                    Subscripion
                                                                    Start
                                                                    Date is required.
                                                                </div>
                                                            </div>
                                                            <!-- Amount and End Date -->
                                                            <ul class="list-group mb-3">
                                                                <li
                                                                    class="list-group-item d-flex justify-content-between lh-condensed">
                                                                    <div>
                                                                        <small class="text-muted">Subscription
                                                                            Amount</small>
                                                                    </div>
                                                                    <span class="text-muted"
                                                                        id="subscription_amount">₹0</span>
                                                                    <input type="hidden" id="amount" name="amount">
                                                                </li>
                                                                <li
                                                                    class="list-group-item d-flex justify-content-between lh-condensed">
                                                                    <div>
                                                                        <small class="text-muted">Subscription End
                                                                            Date</small>
                                                                        <input type="hidden" id="end_date"
                                                                            name="subscription_end_date">
                                                                    </div>
                                                                    <span class="text-muted"
                                                                        id="subscription_end_date"></span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="dropdown mt-sm-0 mt-3">
                                                        <button type="submit" id="addSubscriptionButton"
                                                            class="btn btn-outline-primary rounded">Add
                                                            Subscription</button>
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
                                                        <a href="javascript:void(0);" data-bs-toggle="modal"
                                                            data-bs-target="#addNewSubscription"
                                                            class="btn btn-outline-primary rounded">Add
                                                            Subscription</a>
                                                    </div>
                                                </div>

                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table id="example3"
                                                            class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">Plan</th>
                                                                    <th scope="col">Amount</th>
                                                                    <th scope="col">Validity</th>
                                                                    <th scope="col">Start Date</th>
                                                                    <th scope="col">End Date</th>
                                                                    <th scope="col">Status</th>
                                                                    <!-- <th scope="col" class="text-end">Action -->
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($userSubscriptions as $subscription)
                                                                    <tr>
                                                                        <td>{{$subscription->subscription->subscription_name}}
                                                                        </td>
                                                                        <td>{{$subscription->subscription->amount}}</td>
                                                                        <td>{{$subscription->subscription->validity}}
                                                                            Months</td>
                                                                        <td>{{ \Carbon\Carbon::parse($subscription->subscription_start_date)->format('M d, Y') }}
                                                                        </td>
                                                                        <td>{{ \Carbon\Carbon::parse($subscription->subscription_end_date)->format('M d, Y') }}
                                                                        </td>
                                                                        <td>
                                                                            @if ($subscription->status == \App\Enums\GymSubscriptionStatusEnum::ACTIVE)
                                                                                Active
                                                                            @elseif ($subscription->status == \App\Enums\GymSubscriptionStatusEnum::INACTIVE)
                                                                                Inactive
                                                                            @elseif ($subscription->status == \App\Enums\GymSubscriptionStatusEnum::EXPIRE)
                                                                                Expired
                                                                            @else
                                                                                Unknown
                                                                            @endif
                                                                            <!-- <form
                                                                                                                                                                                    action="/update-subscription-status/{{$userDetail->id}}"
                                                                                                                                                                                    method="POST">
                                                                                                                                                                                    @csrf
                                                                                                                                                                                    <select name="status"
                                                                                                                                                                                        onchange="this.form.submit()"
                                                                                                                                                                                        class="form-select" {{ $subscription->status == \App\Enums\GymSubscriptionStatusEnum::INACTIVE ? 'disabled' : '' }}>
                                                                                                                                                                                        <option
                                                                                                                                                                                            value="{{ \App\Enums\GymSubscriptionStatusEnum::ACTIVE }}"
                                                                                                                                                                                            {{ $subscription->status == \App\Enums\GymSubscriptionStatusEnum::ACTIVE ? 'selected' : '' }}>Active
                                                                                                                                                                                        </option>
                                                                                                                                                                                        <option
                                                                                                                                                                                            value="{{ \App\Enums\GymSubscriptionStatusEnum::INACTIVE }}"
                                                                                                                                                                                            {{ $subscription->status == \App\Enums\GymSubscriptionStatusEnum::INACTIVE ? 'selected' : '' }}>Inactive
                                                                                                                                                                                        </option>
                                                                                                                                                                                    </select>
                                                                                                                                                                                </form> -->

                                                                        </td>
                                                                        <!-- <td class="text-end"><span><a href="javascript:void()" class="me-4" data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i>
                                                                                                                                                                                                                                                        </a><a href="javascript:void()" onclick="confirmSubscriptionDelete('{{ $subscription->uuid }}')" data-bs-toggle="tooltip" data-placement="top" title="Close"><i class="fas fa-times color-danger"></i></a></span>
                                                                                                                                                                                                                                                </td> -->
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
                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Add New Workout</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="workoutForm" autocomplete="off" class="needs-validation"
                                                    method="POST" action="/add-user-workout" novalidate>
                                                    @csrf
                                                    <input type="text" id="user_id" name="user_id"
                                                        value="{{$userDetail->id}}" class="form-control" hidden>

                                                    <input id="workoutIdInput" type="hidden" name="workout_id">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>Day</label>
                                                            <select class="form-control" id="day" name="day" required>
                                                                <option value="">Choose Day</option>
                                                                <option value="monday">Monday</option>
                                                                <option value="tuesday">Tuesday</option>
                                                                <option value="wednesday">Wednesday</option>
                                                                <option value="thursday">Thursday</option>
                                                                <option value="friday">Friday</option>
                                                                <option value="saturday">Saturday</option>
                                                            </select>
                                                            <div class="invalid-feedback">
                                                                Day is required.
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Exercise Name</label>
                                                            <input id="workoutInput" class="form-control" type="text"
                                                                id="exercise_name" name="exercise_name"
                                                                placeholder="Workout Name" required>
                                                            <div class="invalid-feedback">
                                                                Exercise Name is required.
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Workout Details Section -->
                                                    <div id="workoutDetails" class="form-group">
                                                        <div class="row">
                                                            <div
                                                                style="display: flex; gap: 10px; align-items: center; overflow: auto;">
                                                                <img id="workoutImage" src="" alt="Workout Image"
                                                                    style="display:none; width: 100%; max-width: 350px; height: auto;">
                                                                <video id="workoutVideo" controls
                                                                    style="display:none; width: 100%; max-width: 350px; height: auto;">
                                                                    <source id="workoutVideoSource" src=""
                                                                        type="video/mp4">
                                                                    Your browser does not support the video tag.
                                                                </video>
                                                            </div>

                                                            <div id="workoutDescription"
                                                                style="display:none; margin-top: 10px;"></div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-md-6">
                                                            <label for="sets">Sets</label>
                                                            <input type="number" id="sets" name="sets" min="0"
                                                                max="1000" class="form-control" required>
                                                            <small id="setsFeedback"
                                                                style="color: red; display: none;">Enter a
                                                                valid sets</small>
                                                            <div class="invalid-feedback">
                                                                Sets is required.
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="reps">Reps</label>
                                                            <input type="number" id="reps" name="reps" min="0"
                                                                class="form-control" required />
                                                            <small id="repsFeedback"
                                                                style="color: red; display: none;">Enter a
                                                                valid reps</small>
                                                            <div class="invalid-feedback">
                                                                Reps is required.
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-6">
                                                            <label for="weight">Weight</label>
                                                            <input type="number" id="weight" name="weight"
                                                                placeholder="Enter Weight in Kg" class="form-control"
                                                                required>
                                                            <small id="weightFeedback"
                                                                style="color: red; display: none;">Enter a
                                                                valid weight</small>
                                                            <div class="invalid-feedback">
                                                                Weight is required.
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="weight">Targetted Body Part</label>
                                                            <select class="form-control" id="targeted_body_part"
                                                                name="targeted_body_part" required>
                                                                <option value="">Choose....</option>
                                                                <option value="biceps">Biceps</option>
                                                                <option value="leg">Leg</option>
                                                                <option value="forearm">Forearm</option>
                                                                <option value="tricep">Tricep</option>
                                                                <option value="shoulder">Shoulder</option>
                                                                <option value="chest">Chest</option>
                                                                <option value="abs">Abs</option>
                                                                <option value="back">Back</option>
                                                            </select>
                                                            <div class="invalid-feedback">
                                                                Targetted Body Part is required.
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Description</label>
                                                        <textarea type="text" rows="10" name="workout_des"
                                                            class="form-control" required></textarea>
                                                        <div class="invalid-feedback">
                                                            Description is required.
                                                        </div>
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
                                                        <a href="javascript:void(0);" data-bs-toggle="modal"
                                                            data-bs-target="#addNewWorkout"
                                                            class="btn btn-outline-primary rounded">Add Workout</a>
                                                    </div>
                                                </div>

                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table id="example3"
                                                            class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">Day</th>
                                                                    <th scope="col">Excerise Name</th>
                                                                    <th scope="col">Sets</th>
                                                                    <th scope="col">Reps</th>
                                                                    <th scope="col">Weight</th>
                                                                    <th scope="col">Targetted Body</th>

                                                                    <th scope="col" class="text-end">Action
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($workouts as $workout)
                                                                    <tr>
                                                                        <td>{{$workout->day}}</td>
                                                                        <td>{{$workout->exercise_name}}</td>
                                                                        <td>{{$workout->sets}} sets</td>
                                                                        <td>{{$workout->reps}} Reps</td>

                                                                        <td>{{$workout->weight}} kg</td>
                                                                        <td>{{$workout->targeted_body_part}}</td>
                                                                        </td>
                                                                        <td class="text-end"><span> <a
                                                                                    href="javascript:void(0);"
                                                                                    class="me-4 edit-workout"
                                                                                    data-bs-toggle="tooltip"
                                                                                    data-placement="top" title="Edit"
                                                                                    data-workout="{{ json_encode($workout) }}">
                                                                                    <i class="fa fa-pencil color-muted"></i>
                                                                                </a><a
                                                                                    onclick="confirmDelete('{{ $workout->uuid }}')"
                                                                                    href="javascript:void()"
                                                                                    data-bs-toggle="tooltip"
                                                                                    data-placement="top" title="Close"><i
                                                                                        class="fas fa-times color-danger"></i></a></span>
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
                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Add New Diet</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="dietForm" method="POST" class="needs-validation"
                                                    action="/add-user-diet" novalidate>
                                                    @csrf
                                                    <input id="diet_id" type="hidden" name="diet_id">
                                                    <input type="text" id="user_id" name="user_id"
                                                        value="{{$userDetail->id}}" class="form-control" hidden>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Day</label>
                                                                <select class="form-control" id="day" name="day"
                                                                    required>
                                                                    <option value="">Choose Day</option>
                                                                    <option value="monday">Monday</option>
                                                                    <option value="tuesday">Tuesday</option>
                                                                    <option value="wednesday">Wednesday</option>
                                                                    <option value="thursday">Thursday</option>
                                                                    <option value="friday">Friday</option>
                                                                    <option value="saturday">Saturday</option>
                                                                </select>
                                                                <div class="invalid-feedback"> Choose a day.</div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Goal</label>
                                                                <select class="form-control" id="goal" name="goal"
                                                                    required>
                                                                    <option value="">Choose Goal</option>
                                                                    <option value="Weight Gain">Weight Gain</option>
                                                                    <option value="Fit">Fit</option>
                                                                    <option value="Weight Loss">Weight Loss</option>
                                                                </select>
                                                                <div class="invalid-feedback"> Choose a Goal.</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Meal Type</label>
                                                                <select class="form-control" id="meal_type"
                                                                    name="meal_type" required>
                                                                    <option value="">Choose Meal Type</option>
                                                                    <option value="Vegetarian">Vegetarian</option>
                                                                    <option value="Non-Vegetarian">Non-Vegetarian
                                                                    </option>
                                                                    <option value="Lacto-vegetarian">
                                                                        Lacto-vegetarian</option>
                                                                    <option value="Ovo-vegetarian">Ovo-vegetarian
                                                                    </option>
                                                                    <option value="Vegan">Vegan</option>
                                                                    <option value="Pescatarian">Pescatarian
                                                                    </option>
                                                                    <option value="Beegan">Beegan</option>
                                                                    <option value="Flexitarian">Flexitarian
                                                                    </option>
                                                                </select>
                                                                <div class="invalid-feedback"> Choose a Meal Type.</div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Meal Name</label>
                                                                <input type="text" id="dietInput" name="meal_name"
                                                                    class="form-control" autocomplete="off" required>
                                                                <div class="invalid-feedback"> Choose a Meal Name.</div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="dietDetails" style="display: none;">
                                                        <div class="form-group text-center">
                                                            <img id="dietImage" alt="Diet Image"
                                                                style="display: none; max-width: 50%; height: auto;">
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <label>Calories (in kcals)</label>
                                                                    <input type="number" id="calories" name="calories"
                                                                        min="0" max="1000" class="form-control"
                                                                        required>
                                                                    <small class="error-message" id="caloriesError"
                                                                        style="color: red; display: none;">Calories
                                                                        cannot be negative.</small>
                                                                    <div class="invalid-feedback">Calories is required.
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <label>Protein (in grams)</label>
                                                                    <input type="number" id="protein" name="protein"
                                                                        class="form-control" min="0" required />
                                                                    <small class="error-message" id="proteinError"
                                                                        style="color: red; display: none;">Protein
                                                                        cannot be negative.</small>
                                                                    <div class="invalid-feedback"> Protein is required.
                                                                    </div>

                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label>Carbs (in grams)</label>
                                                                    <input type="number" id="carbs" name="carbs"
                                                                        class="form-control" required>
                                                                    <small class="error-message" id="carbsError"
                                                                        style="color: red; display: none;">Carbs cannot
                                                                        be negative.</small>
                                                                    <div class="invalid-feedback"> Carbs is required.
                                                                    </div>

                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label>Fats (in grams)</label>
                                                                    <input type="number" id="fats" name="fats"
                                                                        class="form-control" required>
                                                                    <small class="error-message" id="fatsError"
                                                                        style="color: red; display: none;">Fats cannot
                                                                        be negative.</small>
                                                                    <div class="invalid-feedback"> Fats is required.
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label>Diet Description</label>
                                                                    <textarea type="text" rows="5"
                                                                        name="diet_description" class="form-control"
                                                                        required></textarea>
                                                                    <div class="invalid-feedback"> Diet Description is
                                                                        required.</div>

                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>Alternative Diet Description</label>
                                                                    <textarea type="text" rows="5"
                                                                        name="alternative_diet_description"
                                                                        class="form-control"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div id="dietNotFoundMessage" class="alert alert-danger text-center"
                                                        style="display: none;">
                                                        Diet not found. Please add the diet to the system.
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
                                                        <a href="javascript:void(0);" data-bs-toggle="modal"
                                                            data-bs-target="#addNewDiet"
                                                            class="btn btn-outline-primary rounded">Add Diet</a>
                                                    </div>
                                                </div>

                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table id="example3"
                                                            class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">Day</th>
                                                                    <th scope="col">Meal Name</th>
                                                                    <th scope="col">Calories</th>
                                                                    <th scope="col">Protein</th>
                                                                    <th scope="col">Carbs</th>
                                                                    <th scope="col">Fats</th>
                                                                    <th scope="col" class="text-end">Action
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($diets as $diet)
                                                                    <tr>
                                                                        <td>{{$diet->day}}</td>
                                                                        <td>{{$diet->meal_name}}</td>
                                                                        <td>{{$diet->calories}} gm</td>
                                                                        <td>{{$diet->protein}} gm</td>

                                                                        <td>{{$diet->carbs}} gm</td>
                                                                        <td>{{$diet->fats}} gm</td>
                                                                        </td>
                                                                        <td class="text-end"><span> <a
                                                                                    href="javascript:void(0);"
                                                                                    class="me-4 edit-diet"
                                                                                    data-bs-toggle="tooltip"
                                                                                    data-placement="top" title="Edit"
                                                                                    data-diet="{{ json_encode($diet) }}">
                                                                                    <i class="fa fa-pencil color-muted"></i>
                                                                                </a><a href="javascript:void()"
                                                                                    onclick="confirmDietDelete('{{ $diet->uuid }}')"
                                                                                    data-bs-toggle="tooltip"
                                                                                    data-placement="top" title="Close"><i
                                                                                        class="fas fa-times color-danger"></i></a></span>
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
                                <!-- End of BMI Calculation Section -->
                                <div class="col-xl-12 col-xxl-12">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header d-sm-flex d-block pb-0 border-0">
                                                    <div class="me-auto pe-3">
                                                        <h4 class="text-black fs-20">BMI List</h4>
                                                    </div>

                                                    <div class="dropdown mt-sm-0 mt-3">
                                                        <a href="javascript:void(0);" data-bs-toggle="modal"
                                                            data-bs-target="#addNewBmi"
                                                            class="btn btn-outline-primary rounded">Add BMI</a>
                                                    </div>
                                                </div>


                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table id="example3"
                                                            class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">Month</th>
                                                                    <th scope="col">Height</th>
                                                                    <th scope="col">Weight</th>
                                                                    <th scope="col">BMI</th>
                                                                    <th scope="col" class="text-end">
                                                                        Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($bmis as $bmi)
                                                                    <tr>
                                                                        <td>{{ $bmi->month }}</td>
                                                                        <td>{{ $bmi->height }}</td>
                                                                        <td>{{ $bmi->weight }}</td>
                                                                        <td>{{ $bmi->bmi }}</td>
                                                                        <td class="text-end">
                                                                            <span>
                                                                                <a href="javascript:void()" class="edit-bmi"
                                                                                    data-bmi-id="{{ $bmi->id }}"
                                                                                    data-bs-toggle="tooltip"
                                                                                    data-placement="top" title="Edit">
                                                                                    <i class="fa fa-pencil color-muted"></i>
                                                                                </a>

                                                                                &nbsp; &nbsp;
                                                                                <a href="javascript:void()"
                                                                                    onclick="confirmSubscriptionDelete('{{ $bmi->uuid }}')"
                                                                                    data-bs-toggle="tooltip"
                                                                                    data-placement="top" title="Close">
                                                                                    <i
                                                                                        class="fas fa-times color-danger"></i>
                                                                                </a>
                                                                            </span>
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

                            <div class="tab-pane fade" id="trainers">
                                <div class="modal fade" id="addNewTainer">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Assign Trainer</h5>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form class="needs-validation" action="/allocateTrainer" method="POST"
                                                    novalidate>
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <input type="hidden" name="user_id"
                                                                value="{{$userDetail->id}}">
                                                            <!-- Subscription Selection -->
                                                            <div class="mb-3">
                                                                <label for="trainer">Select a Trainer:</label>
                                                                <select class="me-sm-2 form-control default-select"
                                                                    id="trainer" name="trainer_id" required>
                                                                    <option value="0">Select</option>
                                                                    @foreach ($trainers as $trainer)
                                                                        <option value="{{$trainer->id}}">
                                                                            {{$trainer->name}}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="invalid-feedback">Choose a Trainer.</div>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="status">Select Trainer Status:</label>
                                                                <select class="me-sm-2 form-control default-select"
                                                                    id="status" name="status" required>
                                                                    <option>Select</option>
                                                                    <option
                                                                        value="{{ \App\Enums\TrainerAssignToUserStatus::ACTIVE }}">
                                                                        Active</option>
                                                                    <option
                                                                        value="{{ \App\Enums\TrainerAssignToUserStatus::INACTIVE }}">
                                                                        Inactive</option>
                                                                </select>
                                                                <div class="invalid-feedback">Choose a Trainer Status.
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="dropdown mt-sm-0 mt-3">
                                                        <button type="submit"
                                                            class="btn btn-outline-primary rounded">Assign</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="card">
                                    <div class="col-xl-12 col-xxl-12">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-header d-sm-flex d-block pb-0 border-0">
                                                        <div class="me-auto pe-3">
                                                            <h4 class="text-black fs-20">Assigned Trainers List</h4>
                                                        </div>

                                                        <div class="dropdown mt-sm-0 mt-3">
                                                            <a href="javascript:void(0);" data-bs-toggle="modal"
                                                                data-bs-target="#addNewTainer"
                                                                class="btn btn-outline-primary rounded">Assign
                                                                Trainers</a>
                                                        </div>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table id="example3"
                                                                class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">Trainer Name</th>
                                                                        <th scope="col">Status</th>
                                                                        <!-- <th scope="col" class="text-end">Action -->
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($trainersHistories as $trainer)
                                                                        <tr>
                                                                            <td>{{$trainer->trainer->name}}</td>
                                                                            <td>
                                                                                <form
                                                                                    action="/update-trainer-status/{{$userDetail->id}}"
                                                                                    method="POST">
                                                                                    @csrf
                                                                                    @method('POST')
                                                                                    <input type="hidden" name="trainer_id"
                                                                                        value="{{ $trainer->id }}">
                                                                                    <!-- Hidden field for trainer_id -->
                                                                                    <select name="status"
                                                                                        onchange="this.form.submit()"
                                                                                        class="form-select" {{ $trainer->status == \App\Enums\TrainerAssignToUserStatus::INACTIVE ? 'disabled' : '' }}>
                                                                                        <option
                                                                                            value="{{ \App\Enums\TrainerAssignToUserStatus::ACTIVE }}"
                                                                                            {{ $trainer->status == \App\Enums\TrainerAssignToUserStatus::ACTIVE ? 'selected' : '' }}>Active
                                                                                        </option>
                                                                                        <option
                                                                                            value="{{ \App\Enums\TrainerAssignToUserStatus::INACTIVE }}"
                                                                                            {{ $trainer->status == \App\Enums\TrainerAssignToUserStatus::INACTIVE ? 'selected' : '' }}>
                                                                                            Inactive</option>
                                                                                    </select>
                                                                                </form>
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editWorkoutModal" tabindex="-1" role="dialog" aria-labelledby="editWorkoutModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Workout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editWorkoutForm" class="needs-validation" method="POST" action="/update-user-workout"
                        novalidate>
                        @csrf
                        <input type="hidden" id="edit_user_id" name="user_id" value="{{$userDetail->id}}">
                        <input type="hidden" id="edit_workout_id" name="workout_id">
                        <input type="hidden" id="edit_user_workout_id" name="id">

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Day</label>
                                    <select class="form-control" id="edit_day" name="day" required>
                                        <option value="">Choose Day</option>
                                        <option value="monday">Monday</option>
                                        <option value="tuesday">Tuesday</option>
                                        <option value="wednesday">Wednesday</option>
                                        <option value="thursday">Thursday</option>
                                        <option value="friday">Friday</option>
                                        <option value="saturday">Saturday</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Exercise Name</label>
                                    <input type="text" id="edit_exercise_name" name="exercise_name" class="form-control"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Sets</label>
                                    <input type="number" id="edit_sets" name="sets" min="0" max="1000"
                                        class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Reps</label>
                                    <input type="number" id="edit_reps" name="reps" class="form-control" min="0"
                                        required />
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label>Weight</label>
                                <input type="number" id="edit_weight" name="weight" placeholder="Enter Weight in Kg"
                                    class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>Targetted Body Part</label>
                                <select class="form-control" id="edit_targeted_body_part" name="targeted_body_part"
                                    required>
                                    <option value="">Choose....</option>
                                    <option value="biceps">Biceps</option>
                                    <option value="leg">Leg</option>
                                    <option value="forearm">Forearm</option>
                                    <option value="tricep">Tricep</option>
                                    <option value="shoulder">Shoulder</option>
                                    <option value="chest">Chest</option>
                                    <option value="abs">Abs</option>
                                    <option value="back">Back</option>
                                </select>
                            </div>

                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea type="text" id="edit_notes" rows="10" name="workout_des" class="form-control"
                                required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editDietModal" tabindex="-1" role="dialog" aria-labelledby="editDietModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
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
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Day</label>
                                    <select class="form-control" id="edit_diet_day" name="day" required>
                                        <option value="">Choose Day</option>
                                        <option value="monday">Monday</option>
                                        <option value="tuesday">Tuesday</option>
                                        <option value="wednesday">Wednesday</option>
                                        <option value="thursday">Thursday</option>
                                        <option value="friday">Friday</option>
                                        <option value="saturday">Saturday</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Goal</label>
                                    <select class="form-control" id="edit_goal" name="goal" required>
                                        <option value="">Choose Goal</option>
                                        <option value="Weight Gain">Weight Gain</option>
                                        <option value="Fit">Fit</option>
                                        <option value="Weight Loss">Weight Loss</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Meal Type</label>
                                    <select class="form-control" id="edit_meal_type" name="meal_type" required>
                                        <option value="">Choose Meal Type</option>
                                        <option value="Vegetarian">Vegetarian</option>
                                        <option value="Non-Vegetarian">Non-Vegetarian </option>
                                        <option value="Lacto-vegetarian">Lacto-vegetarian</option>
                                        <option value="Ovo-vegetarian">Ovo-vegetarian </option>
                                        <option value="Vegan">Vegan</option>
                                        <option value="Pescatarian">Pescatarian </option>
                                        <option value="Beegan">Beegan</option>
                                        <option value="Flexitarian">Flexitarian </option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Meal Name</label>
                                    <input type="text" id="edit_meal_name" name="meal_name" class="form-control"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Calories (in kcals)</label>
                                    <input type="number" id="edit_calories" name="calories" min="0" max="1000"
                                        class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Protein (in grams)</label>
                                    <input type="number" id="edit_protein" name="protein" class="form-control" min="0"
                                        required />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Carbs (in grams)</label>
                                    <input type="number" id="edit_carbs" name="carbs" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Fats (in grams)</label>
                                    <input type="number" id="edit_fats" name="fats" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Diet Description</label>
                                    <textarea type="text" id="edit_diet_discription" name="diet_description" rows="5"
                                        class="form-control" required></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label>Alternative Diet Description</label>
                                    <textarea type="text" id="edit_alternative_diet_description"
                                        name="alternative_diet_description" rows="5" class="form-control"
                                        required></textarea>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="addNewBmi" tabindex="-1" role="dialog" aria-labelledby="editDietModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add BMI</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" id="bmiForm" action="{{ route('addUserBodyMeasurement') }}"
                        method="POST" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="month">Select Month</label>
                                <select class="form-control" id="month" name="month" required>
                                    <option value="">Choose Month</option>
                                    <option value="January">January</option>
                                    <option value="February">February</option>
                                    <option value="March">March</option>
                                    <option value="April">April</option>
                                    <option value="May">May</option>
                                    <option value="June">June</option>
                                    <option value="July">July</option>
                                    <option value="August">August</option>
                                    <option value="September">September</option>
                                    <option value="October">October</option>
                                    <option value="November">November</option>
                                    <option value="December">December</option>
                                </select>
                                <div class="invalid-feedback">Month is required.</div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <!-- Left section -->
                            <div class="col-lg-4 mb-4">
                                <div class="row">
                                    <input type="hidden" name="user_id" value="{{ $userDetail->id }}">
                                    <div class="col-md-12 mb-3">
                                        <label for="chest">Chest (cm)</label>
                                        <input type="text" class="form-control" id="chest" name="chest" placeholder=""
                                            required>
                                        <small id="chestError" class="text-danger" style="display: none;">Enter a valid
                                            chest.</small>
                                        <div class="invalid-feedback">Chest measurement is required.</div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="triceps">Triceps (cm)</label>
                                        <input type="text" class="form-control" id="triceps" name="triceps"
                                            placeholder="" required>
                                        <small id="tricepsError" class="text-danger" style="display: none;">Enter a
                                            valid triceps.</small>
                                        <div class="invalid-feedback">Triceps measurement is required.</div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="biceps">Biceps (cm)</label>
                                        <input type="text" class="form-control" id="biceps" name="biceps" placeholder=""
                                            required>
                                        <small id="bicepsError" class="text-danger" style="display: none;">Enter a valid
                                            biceps.</small>
                                        <div class="invalid-feedback">Biceps measurement is required.</div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="lats">Lats (cm)</label>
                                        <input type="text" class="form-control" id="lats" name="lats" placeholder=""
                                            required>
                                        <small id="latsError" class="text-danger" style="display: none;">Enter a valid
                                            lats.</small>
                                        <div class="invalid-feedback">Lats measurement is required.</div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="shoulder">Shoulder (cm)</label>
                                        <input type="text" class="form-control" id="shoulder" name="shoulder"
                                            placeholder="" required>
                                        <small id="shoulderError" class="text-danger" style="display: none;">Enter a
                                            valid shoulder.</small>
                                        <div class="invalid-feedback">Shoulder measurement is required.</div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="abs">Abs (cm)</label>
                                        <input type="text" class="form-control" id="abs" name="abs" placeholder=""
                                            required>
                                        <small id="absError" class="text-danger" style="display: none;">Enter a valid
                                            abs.</small>
                                        <div class="invalid-feedback">Abs measurement is required.</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Center section for the human body skeleton -->
                            <div class="col-lg-4 mb-4 text-center">
                                <img src="/images/bmi_images/male-skeleton.png" alt="Human Body Skeleton"
                                    class="img-fluid"
                                    style="margin-top: 45px; margin-left: -25px; max-width: 129%; height: 90%;">
                            </div>

                            <!-- Right section -->
                            <div class="col-lg-4 mb-4">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="forearms">Forearms (cm)</label>
                                        <input type="text" class="form-control" id="forearms" name="forearms"
                                            placeholder="" required>
                                        <small id="forearmsError" class="text-danger" style="display: none;">Enter a
                                            valid forarms.</small>
                                        <div class="invalid-feedback">Forearms measurement is required.</div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="traps">Traps (cm)</label>
                                        <input type="text" class="form-control" id="traps" name="traps" placeholder=""
                                            required>
                                        <small id="trapsError" class="text-danger" style="display: none;">Enter a valid
                                            traps.</small>
                                        <div class="invalid-feedback">Traps measurement is required.</div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="glutes">Glutes (cm)</label>
                                        <input type="text" class="form-control" id="glutes" name="glutes" placeholder=""
                                            required>
                                        <small id="glutesError" class="text-danger" style="display: none;">Enter a valid
                                            glutes.</small>
                                        <div class="invalid-feedback">Glutes measurement is required.</div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="quads">Quads (cm)</label>
                                        <input type="text" class="form-control" id="quads" name="quads" placeholder=""
                                            required>
                                        <small id="quadsError" class="text-danger" style="display: none;">Enter a valid
                                            quads.</small>
                                        <div class="invalid-feedback">Quads measurement is required.</div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="hamstring">Hamstring (cm)</label>
                                        <input type="text" class="form-control" id="hamstring" name="hamstring"
                                            placeholder="" required>
                                        <small id="hamstringError" class="text-danger" style="display: none;">Enter a
                                            valid hamstring.</small>
                                        <div class="invalid-feedback">Hamstring measurement is required.</div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="calves">Calves (cm)</label>
                                        <input type="text" class="form-control" id="calves" name="calves" placeholder=""
                                            required>
                                        <small id="calvesError" class="text-danger" style="display: none;">Enter a valid
                                            Calves.</small>
                                        <div class="invalid-feedback">Calves measurement is required.</div>
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
                                        <input type="number" class="form-control" id="height" name="height"
                                            placeholder="Enter height in cm" min="50" max="250" required>
                                        <div class="invalid-feedback">Height is required.</div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="bmi_weight">Weight (kg)</label>
                                        <input type="number" class="form-control" id="bmi_weight" name="weight"
                                            placeholder="Enter weight in kg" min="1" max="300" required>
                                        <div class="invalid-feedback">Weight is required.</div>
                                    </div>
                                    <!-- BMI Result Display -->
                                    <div class="col-md-4 mb-3">
                                        <div id="bmiResult" style="display: none;">
                                            <h4>Your BMI is: <br><br><span id="bmiDisplay"></span></h4>

                                            <!-- Hidden input to store BMI value for submission -->
                                            <input type="hidden" id="storeBmi" name="bmi">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <button type="button" class="btn btn-primary btn-lg btn-block"
                                            onclick="calculateBMI()">Calculate BMI</button>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <button type="reset" class="btn btn-secondary btn-lg btn-block">Reset</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <button type="submit" class="btn btn-success btn-lg btn-block">Submit</button>
                                    </div>
                                </div>


                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit BMI and Body Measurement Modal -->
    <div class="modal fade" id="editBmiModal" tabindex="-1" role="dialog" aria-labelledby="editBmiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit BMI and Body Measurements</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" id="editBmiForm" novalidate action="/update-user-bmi" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $userDetail->id }}">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="month">Select Month</label>
                                <select class="form-control" id="edit_month" name="month" required>
                                    <option value="">Choose Month</option>
                                    <option value="January">January</option>
                                    <option value="February">February</option>
                                    <option value="March">March</option>
                                    <option value="April">April</option>
                                    <option value="May">May</option>
                                    <option value="June">June</option>
                                    <option value="July">July</option>
                                    <option value="August">August</option>
                                    <option value="September">September</option>
                                    <option value="October">October</option>
                                    <option value="November">November</option>
                                    <option value="December">December</option>
                                </select>
                                <div class="invalid-feedback">Month is required.</div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <!-- Left section (same as add modal) -->
                            <div class="col-lg-4 mb-4">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="edit_chest">Chest (cm)</label>
                                        <input type="text" class="form-control" id="edit_chest" name="chest" required>
                                        <div class="invalid-feedback">Chest measurement is required.</div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="edit_triceps">Triceps (cm)</label>
                                        <input type="text" class="form-control" id="edit_triceps" name="triceps"
                                            required>
                                        <div class="invalid-feedback">Triceps measurement is required.</div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="biceps">Biceps (cm)</label>
                                        <input type="text" class="form-control" id="edit_biceps" name="biceps"
                                            placeholder="">
                                        <div class="invalid-feedback">Biceps measurement is required.</div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="lats">Lats (cm)</label>
                                        <input type="text" class="form-control" id="edit_lats" name="lats"
                                            placeholder="" required>
                                        <div class="invalid-feedback">Lats measurement is required.</div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="shoulder">Shoulder (cm)</label>
                                        <input type="text" class="form-control" id="edit_shoulder" name="shoulder"
                                            placeholder="" required>
                                        <div class="invalid-feedback">Shoulder measurement is required.</div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="abs">Abs (cm)</label>
                                        <input type="text" class="form-control" id="edit_abs" name="abs" placeholder=""
                                            required>
                                        <div class="invalid-feedback">Abs measurement is required.</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Center section for the human body skeleton -->
                            <div class="col-lg-4 mb-4 text-center">
                                <img src="/images/bmi_images/male-skeleton.png" alt="Human Body Skeleton"
                                    class="img-fluid"
                                    style="margin-top: 45px; margin-left: -25px; max-width: 129%; height: 90%;">
                            </div>

                            <!-- Right section (same as add modal) -->
                            <div class="col-lg-4 mb-4">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="edit_forearms">Forearms (cm)</label>
                                        <input type="text" class="form-control" id="edit_forearms" name="forearms"
                                            required>
                                        <div class="invalid-feedback">Forearms measurement is required.</div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="edit_traps">Traps (cm)</label>
                                        <input type="text" class="form-control" id="edit_traps" name="traps" required>
                                        <div class="invalid-feedback">Traps measurement is required.</div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="glutes">Glutes (cm)</label>
                                        <input type="text" class="form-control" id="edit_glutes" name="glutes"
                                            placeholder="">
                                        <div class="invalid-feedback">Glutes measurement is required.</div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="quads">Quads (cm)</label>
                                        <input type="text" class="form-control" id="edit_quads" name="quads"
                                            placeholder="" required>
                                        <div class="invalid-feedback">Quads measurement is required.</div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="hamstring">Hamstring (cm)</label>
                                        <input type="text" class="form-control" id="edit_hamstring" name="hamstring"
                                            placeholder="" required>
                                        <div class="invalid-feedback">Hamstring measurement is required.</div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="calves">Calves (cm)</label>
                                        <input type="text" class="form-control" id="edit_calves" name="calves"
                                            placeholder="" required>
                                        <div class="invalid-feedback">Calves measurement is required.</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- BMI Calculation Section -->
                        <div class="row mt-5">
                            <div class="col-lg-12">
                                <h4 class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-black">Edit BMI</span>
                                </h4>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="edit_height">Height (cm)</label>
                                        <input type="number" class="form-control" id="edit_height" name="height"
                                            required>
                                        <div class="invalid-feedback">Height is required.</div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="edit_body_weight">Weight (kg)</label>
                                        <input type="number" class="form-control" id="edit_body_weight" name="weight"
                                            required>
                                        <div class="invalid-feedback">Weight is required.</div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="edit_calculatedBmi">BMI</label>
                                        <input type="number" class="form-control" id="edit_calculatedBmi" name="bmi"
                                            placeholder="BMI will be calculated" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <button id="bmiButton" type="button" class="btn btn-primary btn-lg btn-block"
                                            onclick="calculateEditBmi()">Calculate BMI</button>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <button type="reset" class="btn btn-secondary btn-lg btn-block">Reset</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <button type="submit" class="btn btn-success btn-lg btn-block">Update</button>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    document.addEventListener('DOMContentLoaded', function () {
        const editButtons = document.querySelectorAll('.edit-workout');

        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                const workout = JSON.parse(this.dataset.workout);

                document.getElementById('edit_user_workout_id').value = workout.id;
                document.getElementById('edit_workout_id').value = workout.workout_id;
                document.getElementById('edit_exercise_name').value = workout.exercise_name;
                document.getElementById('edit_day').value = workout.day;
                document.getElementById('edit_sets').value = workout.sets;
                document.getElementById('edit_reps').value = workout.reps;
                document.getElementById('edit_weight').value = workout.weight;
                document.getElementById('edit_targeted_body_part').value = workout.targeted_body_part;
                document.getElementById('edit_notes').value = workout.workout_des;

                new bootstrap.Modal(document.getElementById('editWorkoutModal')).show();
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const editButtons = document.querySelectorAll('.edit-diet');

        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                const diet = JSON.parse(this.getAttribute('data-diet'));

                document.getElementById('edit_diet_id').value = diet.id;
                document.getElementById('edit_meal_name').value = diet.meal_name;
                document.getElementById('edit_calories').value = diet.calories;
                document.getElementById('edit_protein').value = diet.protein;
                document.getElementById('edit_carbs').value = diet.carbs;
                document.getElementById('edit_fats').value = diet.fats;
                document.getElementById('edit_goal').value = diet.goal;
                document.getElementById('edit_meal_type').value = diet.meal_type;
                document.getElementById('edit_diet_day').value = diet.day;
                document.getElementById('edit_diet_discription').value = diet.diet_description;
                document.getElementById('edit_alternative_diet_description').value = diet.alternative_diet_description;

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
                window.location.href = '/delete-user-workout/' + uuid;
            }
        });
    }

    function confirmDietDelete(uuid) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Are you sure you want to delete this diet?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/delete-user-diet/' + uuid;
            }
        });
    }

    document.getElementById('subscription_id').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const amount = selectedOption.getAttribute('data-amount');
        const description = selectedOption.getAttribute('data-description');
        const validity = selectedOption.getAttribute('data-validity');
        const fetchedStartDate = selectedOption.getAttribute('data-start-date');

        document.getElementById('fetched_start_date').value = fetchedStartDate; // Store the fetched start date

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

    document.getElementById('joining_date').addEventListener('change', function () {
        const fetchedStartDate = new Date(document.getElementById('fetched_start_date').value);
        const selectedJoiningDate = new Date(this.value);
        const errorSubscription = document.getElementById("subError");

        // Check if the selected date is before the fetched subscription start date
        if (selectedJoiningDate < fetchedStartDate) {
            errorSubscription.style.display = 'block';
            // this.value = ''; // Clear the invalid date
            // return;
        }
        else {
            errorSubscription.style.display = 'none';
        }

        const selectedOption = document.getElementById('subscription_id').options[document.getElementById('subscription_id').selectedIndex];
        const validity = selectedOption.getAttribute('data-validity');

        const endDate = new Date(this.value);
        endDate.setMonth(endDate.getMonth() + parseInt(validity));
        document.getElementById('end_date').value = endDate.toISOString().split('T')[0];
        document.getElementById('subscription_end_date').innerText = endDate.toISOString().split('T')[0];
    });

    document.getElementById('subscriptionForm').addEventListener('submit', function (event) {
        const fetchedStartDate = new Date(document.getElementById('fetched_start_date').value);
        const selectedJoiningDate = new Date(document.getElementById('joining_date').value);
        const errorSubscription = document.getElementById("subError");

        // Check if the selected date is before the fetched subscription start date
        if (selectedJoiningDate < fetchedStartDate) {
            errorSubscription.style.display = 'block';
            event.preventDefault(); // Prevent form submission
        }
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
        const editButtons = document.querySelectorAll('.edit-bmi');

        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                const bmiId = this.getAttribute('data-bmi-id');

                if (bmiId) {
                    // Make an AJAX request to fetch the BMI and body measurement data
                    fetch(`/get-user-bmi/${bmiId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const bmi = data.bmi;
                                const bodyMeasurement = data.bodyMeasurement;

                                // Populate BMI fields
                                document.getElementById('edit_height').value = bmi.height || '';
                                document.getElementById('edit_body_weight').value = bmi.weight || '';
                                document.getElementById('edit_calculatedBmi').value = bmi.bmi || '';
                                document.getElementById('edit_month').value = bmi.month || '';


                                // Populate Body Measurement fields
                                document.getElementById('edit_chest').value = bodyMeasurement ? bodyMeasurement.chest || '' : '';
                                document.getElementById('edit_triceps').value = bodyMeasurement ? bodyMeasurement.triceps || '' : '';
                                document.getElementById('edit_biceps').value = bodyMeasurement ? bodyMeasurement.biceps || '' : '';
                                document.getElementById('edit_lats').value = bodyMeasurement ? bodyMeasurement.lats || '' : '';
                                document.getElementById('edit_shoulder').value = bodyMeasurement ? bodyMeasurement.shoulder || '' : '';
                                document.getElementById('edit_abs').value = bodyMeasurement ? bodyMeasurement.abs || '' : '';
                                document.getElementById('edit_forearms').value = bodyMeasurement ? bodyMeasurement.forearms || '' : '';
                                document.getElementById('edit_traps').value = bodyMeasurement ? bodyMeasurement.traps || '' : '';
                                document.getElementById('edit_glutes').value = bodyMeasurement ? bodyMeasurement.glutes || '' : '';
                                document.getElementById('edit_quads').value = bodyMeasurement ? bodyMeasurement.quads || '' : '';
                                document.getElementById('edit_hamstring').value = bodyMeasurement ? bodyMeasurement.hamstring || '' : '';
                                document.getElementById('edit_calves').value = bodyMeasurement ? bodyMeasurement.calves || '' : '';

                                // Show the modal
                                new bootstrap.Modal(document.getElementById('editBmiModal')).show();
                            } else {
                                console.error(data.message || 'Data not found for the given BMI ID.');
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching data:', error);
                        });
                } else {
                    console.error('BMI ID is missing.');
                }
            });
        });
    });

    function calculateBMI() {
        // Get height and weight values
        const height = document.querySelector('#height').value;
        const weight = document.querySelector('#bmi_weight').value;

        // Check if height and weight are not empty and valid
        if (height && weight && height > 0 && weight > 0) {
            // Convert height from cm to meters
            const heightInMeters = height / 100;

            // Calculate BMI
            const bmi = weight / (heightInMeters * heightInMeters);

            // Round BMI to two decimal places
            const roundedBmi = bmi.toFixed(2);

            // Display the BMI result
            document.querySelector('#storeBmi').value = roundedBmi;
            document.querySelector('#bmiResult').style.display = 'block';
            document.querySelector('#bmiDisplay').textContent = roundedBmi;

        } else {
            // Handle invalid input
            alert('Please enter valid height and weight values.');
        }
    }

    function calculateEditBmi() {
        // Get height and weight values from the form
        let height = parseFloat(document.getElementById('edit_height').value);
        let weight = parseFloat(document.getElementById('edit_body_weight').value);

        // Check if height and weight are valid
        if (height && weight && height > 0 && weight > 0) {
            // Convert height from cm to meters
            const heightInMeters = height / 100;

            // Calculate BMI
            const bmi = weight / (heightInMeters * heightInMeters);

            // Round BMI to two decimal places
            const roundedBmi = bmi.toFixed(2);

            // Display the BMI result
            document.getElementById('edit_calculatedBmi').value = roundedBmi; // Update the BMI input field
        } else {
            // Handle invalid input
            alert('Please enter valid height and weight values.');
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        const workoutInput = document.getElementById('workoutInput');
        let currentFocus;

        // Trigger the dropdown on input click
        workoutInput.addEventListener("focus", function () {
            fetchWorkouts(this.value);
        });

        // Trigger the dropdown on input typing
        workoutInput.addEventListener("input", function () {
            fetchWorkouts(this.value);
        });

        function fetchWorkouts(query) {
            currentFocus = -1;
            closeAllLists();

            $.ajax({
                url: "{{ url('/autocomplete-workout') }}",
                type: "GET",
                data: { query: query },
                dataType: 'json',
                success: function (data) {
                    const listContainer = document.createElement("DIV");
                    listContainer.setAttribute("id", workoutInput.id + "autocomplete-list");
                    listContainer.setAttribute("class", "autocomplete-items");
                    workoutInput.parentNode.appendChild(listContainer);

                    data.forEach(item => {
                        if (item.name.toLowerCase().includes(query.toLowerCase())) {
                            const itemElement = document.createElement("DIV");
                            const matchedText = item.name.substr(0, query.length);
                            const remainingText = item.name.substr(query.length);

                            itemElement.innerHTML = "<strong>" + matchedText + "</strong>" + remainingText;
                            itemElement.innerHTML += "<input type='hidden' value='" + item.name + "' data-id='" + item.id + "'>";

                            // Handle click on an item
                            itemElement.addEventListener("click", function () {
                                workoutInput.value = this.getElementsByTagName("input")[0].value;
                                document.getElementById('workoutIdInput').value = this.getElementsByTagName("input")[0].getAttribute('data-id');
                                fetchWorkoutDetails(workoutIdInput.value);
                                closeAllLists();
                            });

                            listContainer.appendChild(itemElement);
                        }
                    });
                }
            });

            workoutInput.addEventListener("keydown", function (e) {
                let items = document.getElementById(this.id + "autocomplete-list");
                if (items) items = items.getElementsByTagName("div");
                if (e.keyCode === 40) { // arrow down
                    currentFocus++;
                    addActive(items);
                } else if (e.keyCode === 38) { // arrow up
                    currentFocus--;
                    addActive(items);
                } else if (e.keyCode === 13) { // enter
                    e.preventDefault();
                    if (currentFocus > -1 && items) {
                        items[currentFocus].click();
                    }
                }
            });

            function addActive(items) {
                if (!items) return false;
                removeActive(items);
                if (currentFocus >= items.length) currentFocus = 0;
                if (currentFocus < 0) currentFocus = items.length - 1;
                items[currentFocus].classList.add("autocomplete-active");
            }

            function removeActive(items) {
                for (let i = 0; i < items.length; i++) {
                    items[i].classList.remove("autocomplete-active");
                }
            }

            function closeAllLists(elmnt) {
                const items = document.getElementsByClassName("autocomplete-items");
                for (let i = 0; i < items.length; i++) {
                    if (elmnt !== items[i] && elmnt !== workoutInput) {
                        items[i].parentNode.removeChild(items[i]);
                    }
                }
            }

            document.addEventListener("click", function (e) {
                closeAllLists(e.target);
            });
        }
    });



    function fetchWorkoutDetails(exerciseId) {
        $.ajax({
            url:
                "{{ url('/fetch-workout-details') }}",
            type: "GET",
            data: {
                workout_id: exerciseId
            },
            dataType: 'json',
            success: function (data) {
                if (data) {
                    // Update the image
                    if (data.image) {
                        $("#workoutImage").attr("src", data.image).show();
                    } else {
                        $("#workoutImage").hide();
                    }

                    // Update the video
                    if (data.vedio_link) {
                        $("#workoutVideoSource").attr("src", data.vedio_link);
                        $("#workoutVideo").show()[0].load();
                    } else {
                        $("#workoutVideo").hide();
                    }

                    if (data.gender) {
                        $("#workoutGender").html(data.gender).show();
                    } else {
                        $("#workoutGender").hide();
                    }

                    if (data.category) {
                        $("#workoutCategory").html(data.category).show();
                    } else {
                        $("#workoutCategory").hide();
                    }

                    // Update the description
                    if (data.description) {
                        // Update the textarea with the description
                        $("textarea[name='workout_des']").val(data.description);
                    } else {
                        // Clear the textarea if no description is found
                        $("textarea[name='workout_des']").val('');
                    }
                }
            },
            error: function () {
                console.error('Error fetching workout details');
            }
        });
    }

    //For Diet Name auto search
    document.addEventListener("DOMContentLoaded", function () {
        dietautocomplete(document.getElementById('dietInput'));
    });

    function dietautocomplete(inp) {
        var currentFocus;

        // Trigger the full list on input focus
        inp.addEventListener("focus", function (e) {
            var val = this.value; // Initial input value (empty on focus)
            fetchMealList(val); // Fetch full meal list on focus
        });

        // Handle input event for typing
        inp.addEventListener("input", function (e) {
            var val = this.value;
            closeAllLists(); // Close any previously opened list
            if (!val) {
                fetchMealList(''); // Fetch full list again if input is cleared
                return false;
            }
            currentFocus = -1; // Reset focus
            fetchMealList(val); // Fetch filtered meal list based on input
        });

        function fetchMealList(query) {
            $.ajax({
                url: "{{ url('/autocomplete-diet') }}",
                type: "GET",
                data: {
                    query: query // Send the input value as a query
                },
                dataType: 'json',
                success: function (data) {
                    // Create a DIV to contain suggestions
                    var a = document.createElement("DIV");
                    a.setAttribute("id", inp.id + "autocomplete-list");
                    a.setAttribute("class", "autocomplete-items");
                    inp.parentNode.appendChild(a);

                    data.forEach(item => {
                        if (item.toLowerCase().includes(query.toLowerCase())) { // Case insensitive matching
                            var b = document.createElement("DIV");

                            // Highlight matched part in bold
                            b.innerHTML = "<strong>" + item.substr(0, query.length) + "</strong>";
                            b.innerHTML += item.substr(query.length);

                            // Hidden input to store value
                            b.innerHTML += "<input type='hidden' value='" + item + "'>";

                            // Handle selection of item
                            b.addEventListener("click", function () {
                                inp.value = this.getElementsByTagName("input")[0].value; // Set input value
                                fetchDietDetails(inp.value); // Fetch the meal details on selection
                                closeAllLists(); // Close the list
                            });
                            a.appendChild(b);
                        }
                    });
                }
            });
        }

        // Keyboard navigation
        inp.addEventListener("keydown", function (e) {
            var x = document.getElementById(this.id + "autocomplete-list");
            if (x) x = x.getElementsByTagName("div");
            if (e.keyCode == 40) { // Down arrow key
                currentFocus++;
                addActive(x);
            } else if (e.keyCode == 38) { // Up arrow key
                currentFocus--;
                addActive(x);
            } else if (e.keyCode == 13) { // Enter key
                e.preventDefault();
                if (currentFocus > -1 && x) {
                    x[currentFocus].click(); // Simulate click on Enter
                }
            }
        });

        // Add active class to focused item
        function addActive(items) {
            if (!items) return false;
            removeActive(items);
            if (currentFocus >= items.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = items.length - 1;
            items[currentFocus].classList.add("autocomplete-active");
        }

        // Remove active class from all items
        function removeActive(items) {
            for (var i = 0; i < items.length; i++) {
                items[i].classList.remove("autocomplete-active");
            }
        }

        // Close all suggestion lists
        function closeAllLists(elmnt) {
            var x = document.getElementsByClassName("autocomplete-items");
            for (var i = 0; i < x.length; i++) {
                if (elmnt != x[i] && elmnt != inp) {
                    x[i].parentNode.removeChild(x[i]);
                }
            }
        }

        // Close the dropdown if user clicks outside
        document.addEventListener("click", function (e) {
            closeAllLists(e.target);
        });
    }

    function fetchDietDetails() {
        var goal = document.getElementById('goal').value;
        var mealType = document.getElementById('meal_type').value;
        var mealName = document.getElementById('dietInput').value;

        $('#dietDetails').slideUp();
        $('#dietNotFoundMessage').hide();

        if (mealName.trim() !== '') {
            $.ajax({
                url: "{{ url('/fetch-diet-details') }}",
                type: "GET",
                data: {
                    goal: goal,
                    meal_type: mealType,
                    meal_name: mealName
                },
                dataType: 'json',
                success: function (data) {
                    if (data && data.id) {
                        if (data.image) {
                            $("#dietImage").attr("src", data.image).show();
                        } else {
                            $("#dietImage").hide();
                        }
                        $("input[name='diet_id']").val(data.id);
                        $("input[name='calories']").val(data.calories);
                        $("input[name='protein']").val(data.protein);
                        $("input[name='carbs']").val(data.carbs);
                        $("input[name='fats']").val(data.fats);
                        $("textarea[name='diet_description']").val(data.diet);
                        $("textarea[name='alternative_diet_description']").val(data.alternative_diet);
                        $('#dietDetails').slideDown();
                        $('#dietNotFoundMessage').hide();
                    } else {
                        $('#dietDetails').slideUp();
                        $('#dietNotFoundMessage').show();
                    }
                },
                error: function () {
                    $('#dietDetails').slideUp();
                    $('#dietNotFoundMessage').show();
                }
            });
        } else {
            $('#dietDetails').slideUp();
            $('#dietNotFoundMessage').hide();
        }
    }



    function confirmTrainerDelete(uuid) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Are you sure you want to delete this Trainer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/deleteTrainer/' + uuid;
            }
        });
    }

    function confirmSubscriptionDelete(uuid) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Are you sure you want to delete this BMI.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/deleteBmi/' + uuid;
            }
        });
    }

    //User Workout validation
    // Function to validate Sets and Reps
    function validateInput(inputId, feedbackId) {
        const inputValue = document.getElementById(inputId).value;
        const feedbackElement = document.getElementById(feedbackId);

        // Check if the input value is valid
        if (inputValue <= 0 || !Number.isInteger(Number(inputValue))) {
            feedbackElement.style.display = 'block'; // Show feedback
            return false; // Invalid input
        } else {
            feedbackElement.style.display = 'none'; // Hide feedback
            return true; // Valid input
        }
    }

    // Real-time validation for Sets and Reps
    document.getElementById('sets').addEventListener('input', function () {
        validateInput('sets', 'setsFeedback');
    });

    document.getElementById('reps').addEventListener('input', function () {
        validateInput('reps', 'repsFeedback');
    });

    // Function to validate Weight
    function validateWeight() {
        const weight = document.getElementById('weight').value;
        const weightFeedback = document.getElementById('weightFeedback');

        // Check if the weight is valid
        if (weight < 0 || !Number.isInteger(Number(weight))) {
            weightFeedback.style.display = 'block'; // Show feedback
            return false; // Invalid input
        } else {
            weightFeedback.style.display = 'none'; // Hide feedback
            return true; // Valid input
        }
    }

    // Real-time validation for Weight
    document.getElementById('weight').addEventListener('input', validateWeight);

    // Form submission validation
    document.getElementById('workoutForm').addEventListener('submit', function (event) {
        let isValid = true;

        // Validate all fields before submission
        if (!validateInput('sets', 'setsFeedback')) isValid = false;
        if (!validateInput('reps', 'repsFeedback')) isValid = false;
        if (!validateWeight()) isValid = false;


        // If any validation fails, prevent form submission
        if (!isValid) {
            event.preventDefault();
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        const calorieInput = document.getElementById('calories');
        const proteinInput = document.getElementById('protein');
        const carbsInput = document.getElementById('carbs');
        const fatsInput = document.getElementById('fats');
        const dietForm = document.getElementById('dietForm');

        // Function to validate inputs
        function validateInput(input, errorElement) {
            const value = parseFloat(input.value);
            if (value <= 0) {
                errorElement.style.display = 'block'; // Show error message
            } else {
                errorElement.style.display = 'none'; // Hide error message
            }
        }

        // Add input event listeners for all fields
        calorieInput.addEventListener('input', function () {
            validateInput(this, document.getElementById('caloriesError'));
        });

        proteinInput.addEventListener('input', function () {
            validateInput(this, document.getElementById('proteinError'));
        });

        carbsInput.addEventListener('input', function () {
            validateInput(this, document.getElementById('carbsError'));
        });

        fatsInput.addEventListener('input', function () {
            validateInput(this, document.getElementById('fatsError'));
        });

        // Validate on form submission
        dietForm.addEventListener('submit', function (event) {
            let isValid = true; // Track validity status

            // Validate all fields on form submission
            [calorieInput, proteinInput, carbsInput, fatsInput].forEach(function (input) {
                const errorElement = document.getElementById(input.name + 'Error');
                if (parseFloat(input.value) <= 0) {
                    event.preventDefault(); // Prevent form submission
                    errorElement.style.display = 'block'; // Show error message
                    isValid = false;
                } else {
                    errorElement.style.display = 'none'; // Hide error message
                }
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const bmiForm = document.getElementById('bmiForm');
        const chestInput = document.getElementById('chest');
        const tricepsInput = document.getElementById('triceps');
        const bicepsInput = document.getElementById('biceps');
        const latsInput = document.getElementById('lats');
        const shoulderInput = document.getElementById('shoulder');
        const absInput = document.getElementById('abs');

        const forearmsInput = document.getElementById('forearms');
        const trapsInput = document.getElementById('traps');
        const glutesInput = document.getElementById('glutes');
        const quadsInput = document.getElementById('quads');
        const hamstringInput = document.getElementById('hamstring');
        const calvesInput = document.getElementById('calves');

        // Function to validate inputs
        function validateInput(input, errorElement) {
            const value = parseFloat(input.value);
            if (value <= 0) {
                errorElement.style.display = 'block'; // Show error message
            } else {
                errorElement.style.display = 'none'; // Hide error message
            }
        }

        // Add input event listeners for all fields
        chestInput.addEventListener('input', function () {
            validateInput(this, document.getElementById('chestError'));
        });

        tricepsInput.addEventListener('input', function () {
            validateInput(this, document.getElementById('tricepsError'));
        });

        bicepsInput.addEventListener('input', function () {
            validateInput(this, document.getElementById('bicepsError'));
        });

        latsInput.addEventListener('input', function () {
            validateInput(this, document.getElementById('latsError'));
        });

        shoulderInput.addEventListener('input', function () {
            validateInput(this, document.getElementById('shoulderError'));
        });

        absInput.addEventListener('input', function () {
            validateInput(this, document.getElementById('absError'));
        });

        forearmsInput.addEventListener('input', function () {
            validateInput(this, document.getElementById('forearmsError'));
        });

        trapsInput.addEventListener('input', function () {
            validateInput(this, document.getElementById('trapsError'));
        });

        glutesInput.addEventListener('input', function () {
            validateInput(this, document.getElementById('glutesError'));
        });

        quadsInput.addEventListener('input', function () {
            validateInput(this, document.getElementById('quadsError'));
        });

        hamstringInput.addEventListener('input', function () {
            validateInput(this, document.getElementById('hamstringError'));
        });

        calvesInput.addEventListener('input', function () {
            validateInput(this, document.getElementById('calvesError'));
        });

        // Validate on form submission
        dietForm.addEventListener('submit', function (event) {
            let isValid = true; // Track validity status

            // Validate all fields on form submission
            [chestInput, tricepsInput, bicepsInput, latsInput, shoulderInput, absInput, forearmsInput, trapsInput, glutesInput, quadsInput, hamstringInput, calvesInput].forEach(function (input) {
                const errorElement = document.getElementById(input.name + 'Error');
                if (parseFloat(input.value) <= 0) {
                    event.preventDefault(); // Prevent form submission
                    errorElement.style.display = 'block'; // Show error message
                    isValid = false;
                } else {
                    errorElement.style.display = 'none'; // Hide error message
                }
            });
        });
    });



</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@include('CustomSweetAlert');
@endsection