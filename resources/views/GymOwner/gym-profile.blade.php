@extends('GymOwner.master')
@section('title', 'Gym Profile')
@section('content')
<div class="content-body ">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">App</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Profile</a></li>
            </ol>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="profile card card-body px-3 pt-3 pb-0">
                    <div class="profile-head">
                        <div class="photo-content">
                            <div class="cover-photo"></div>
                        </div>
                        <div class="profile-info">
                            <div class="profile-photo">
                                <img src="{{$gym->image}}" class="img-fluid rounded-circle" alt="">
                            </div>
                            <div class="profile-details">
                                <div class="profile-name px-3 pt-2">
                                    <h4 class="text-primary mb-0">{{$gym->gym_name}}</h4>
                                </div>
                                <div class="profile-email px-2 pt-2">
                                    <p>Email: {{$gym->email}}<br>Phone No: {{$gym->phone_no}}</p>
                                    <!-- <h4 class="text-muted mb-0">{{$gym->phone_no}}</h4> -->
                                </div>
                                <!-- <div class="dropdown ms-auto">
                                    <a href="#" class="btn btn-primary light sharp" data-bs-toggle="dropdown" aria-expanded="true"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                <circle fill="#000000" cx="5" cy="12" r="2"></circle>
                                                <circle fill="#000000" cx="12" cy="12" r="2"></circle>
                                                <circle fill="#000000" cx="19" cy="12" r="2"></circle>
                                            </g>
                                        </svg></a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li class="dropdown-item"><i class="fa fa-user-circle text-primary me-2"></i> View profile</li>
                                        <li class="dropdown-item"><i class="fa fa-users text-primary me-2"></i> Add to close friends</li>
                                        <li class="dropdown-item"><i class="fa fa-plus text-primary me-2"></i> Add to group</li>
                                        <li class="dropdown-item"><i class="fa fa-ban text-primary me-2"></i> Block</li>
                                    </ul>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4">
                <div class="card h-auto">
                    <div class="card-body">
                        <div class="profile-statistics mb-5">
                            <div class="text-center">
                                <div class="row">
                                    <div class="col">
                                        <h3 class="m-b-0">{{ $totalUsers }}</h3><span>Users</span>
                                    </div>
                                    <div class="col">
                                        <h3 class="m-b-0">5</h3><span>Total Years</span>
                                    </div>
                                    <div class="col">
                                        <h3 class="m-b-0">45</h3><span>Total Months</span>
                                    </div>
                                </div>
                                <!-- <div class="mt-4">
                                    <a href="javascript:void()" class="btn btn-primary mb-1" data-bs-toggle="modal" data-bs-target="#sendMessageModal">Send Message</a>
                                </div> -->
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="sendMessageModal">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Send Message</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="comment-form">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="text-black font-w600">Name <span
                                                                    class="required">*</span></label>
                                                            <input type="text" class="form-control" value="Author"
                                                                name="Author" placeholder="Author">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="text-black font-w600">Email <span
                                                                    class="required">*</span></label>
                                                            <input type="text" class="form-control" value="Email"
                                                                placeholder="Email" name="Email">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="text-black font-w600">Comment</label>
                                                            <textarea rows="8" class="form-control" name="comment"
                                                                placeholder="Comment"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <input type="submit" value="Post Comment"
                                                                class="submit btn btn-primary" name="submit">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="profile-blog mb-5 text-center">
                            <h5 class="text-primary d-inline">Scan OR Code</h5>
                            <img src="{{$gym->qrcode}}" alt="" class="img-fluid mt-4 mb-4 w-80 d-block mx-auto">
                        </div>
                        <!-- <div class="profile-news">
                            <h5 class="text-primary d-inline">Our Latest Reviews</h5>
                            <div class="media pt-3 pb-3">
                                <img src="https://fito.dexignzone.com/laravel/demo/images/profile/5.jpg" alt="image" class="me-3 rounded" width="75">
                                <div class="media-body">
                                    <h5 class="m-b-5"><a href="https://fito.dexignzone.com/laravel/demo/post-details" class="text-black">Collection of textile samples</a></h5>
                                    <p class="mb-0">I shared this on my fb wall a few months back, and I thought.</p>
                                </div>
                            </div>
                            <div class="media pt-3 pb-3">
                                <img src="https://fito.dexignzone.com/laravel/demo/images/profile/6.jpg" alt="image" class="me-3 rounded" width="75">
                                <div class="media-body">
                                    <h5 class="m-b-5"><a href="https://fito.dexignzone.com/laravel/demo/post-details" class="text-black">Collection of textile samples</a></h5>
                                    <p class="mb-0">I shared this on my fb wall a few months back, and I thought.</p>
                                </div>
                            </div>
                            <div class="media pt-3 pb-3">
                                <img src="https://fito.dexignzone.com/laravel/demo/images/profile/7.jpg" alt="image" class="me-3 rounded" width="75">
                                <div class="media-body">
                                    <h5 class="m-b-5"><a href="https://fito.dexignzone.com/laravel/demo/post-details" class="text-black">Collection of textile samples</a></h5>
                                    <p class="mb-0">I shared this on my fb wall a few months back, and I thought.</p>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card h-auto">
                    <div class="card-body">
                        <div class="profile-tab">
                            <div class="custom-tab-1">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item"><a href="#about-me" data-bs-toggle="tab"
                                            class="nav-link active show">About Me</a>
                                    </li>
                                    <li class="nav-item"><a href="#profile-settings" data-bs-toggle="tab"
                                            class="nav-link">Setting</a>
                                    </li>
                                    <li class="nav-item"><a href="#account-settings" data-bs-toggle="tab"
                                            class="nav-link">Update Profile</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div id="about-me" class="tab-pane fade active show">
                                        <div class="profile-about-me">
                                            <div class="pt-4 border-bottom-1 pb-3">
                                                <h4 class="text-primary">About Me</h4>
                                                <p class="mb-2">A wonderful serenity has taken possession of my entire
                                                    soul, like these sweet mornings of spring which I enjoy with my
                                                    whole heart. I am alone, and feel the charm of existence was created
                                                    for the bliss of souls like mine.I am so happy, my dear friend, so
                                                    absorbed in the exquisite sense of mere tranquil existence, that I
                                                    neglect my talents.</p>
                                                <p>A collection of textile samples lay spread out on the table - Samsa
                                                    was a travelling salesman - and above it there hung a picture that
                                                    he had recently cut out of an illustrated magazine and housed in a
                                                    nice, gilded frame.</p>
                                            </div>
                                        </div>

                                        <div class="profile-personal-info">
                                            <h4 class="text-primary mb-4">Personal Information</h4>
                                            <div class="row mb-4">
                                                <div class="col-lg-3 col-md-4 col-sm-6">
                                                    <h5 class="f-w-500">Name
                                                        <span class="d-none d-sm-block pull-right">:</span>
                                                    </h5>
                                                </div>
                                                <div class="col-lg-9 col-md-8 col-sm-6 mb-1">
                                                    <span>{{$gym->gym_name}}</span>
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <div class="col-lg-3 col-md-4 col-sm-6">
                                                    <h5 class="f-w-500">User Name
                                                        <span class="d-none d-sm-block pull-right">:</span>
                                                    </h5>
                                                </div>
                                                <div class="col-lg-9 col-md-8 col-sm-6">
                                                    <span>{{$gym->username}}</span>
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <div class="col-lg-3 col-md-4 col-sm-6">
                                                    <h5 class="f-w-500">Email
                                                        <span class="d-none d-sm-block pull-right">:</span>
                                                    </h5>
                                                </div>
                                                <div class="col-lg-9 col-md-8 col-sm-6">
                                                    <span>{{$gym->email}}</span>
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <div class="col-lg-3 col-md-4 col-sm-6">
                                                    <h5 class="f-w-500">Phone
                                                        <span class="d-none d-sm-block pull-right">:</span>
                                                    </h5>
                                                </div>
                                                <div class="col-lg-9 col-md-8 col-sm-6">
                                                    <span>{{$gym->phone_no}}</span>
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <div class="col-lg-3 col-md-4 col-sm-6">
                                                    <h5 class="f-w-500">Location
                                                        <span class="d-none d-sm-block pull-right">:</span>
                                                    </h5>
                                                </div>
                                                <div class="col-lg-9 col-md-8 col-sm-6">
                                                    <span>{{$gym->address}}</span>
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <div class="col-lg-3 col-md-4 col-sm-6">
                                                    <h5 class="f-w-500">City
                                                        <span class="d-none d-sm-block pull-right">:</span>
                                                    </h5>
                                                </div>
                                                <div class="col-lg-9 col-md-8 col-sm-6">
                                                    <span>{{$gym->city_id}}</span>
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <div class="col-lg-3 col-md-4 col-sm-6">
                                                    <h5 class="f-w-500">State
                                                        <span class="d-none d-sm-block pull-right">:</span>
                                                    </h5>
                                                </div>
                                                <div class="col-lg-9 col-md-8 col-sm-6">
                                                    <span>{{$gym->state_id}}</span>
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <div class="col-lg-3 col-md-4 col-sm-6">
                                                    <h5 class="f-w-500">Country
                                                        <span class="d-none d-sm-block pull-right">:</span>
                                                    </h5>
                                                </div>
                                                <div class="col-lg-9 col-md-8 col-sm-6">
                                                    <span>{{$gym->country_id}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="profile-settings" class="tab-pane fade">
                                        <div class="pt-3">
                                            <!-- Add Weekends Section -->
                                            <div class="settings-form">
                                                <div class="row">
                                                    <!-- Add Weekends Section -->
                                                    <div class="col-md-12">
                                                        <form action="/add-weekend" method="POST">
                                                            @csrf
                                                            <div
                                                                class="d-flex justify-content-between align-items-center mb-3">
                                                                <h4 class="text-primary mb-0">Add Weekends</h4>
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-primary">Save</button>
                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group col-md-12">
                                                                    <label>Select Weekend Days</label>
                                                                    <div class="row">
                                                                        <!-- Left Column (first 4 days) -->
                                                                        <div class="col-md-6">
                                                                            <div class="form-check custom-checkbox">
                                                                                <input type="checkbox"
                                                                                    name="weekend_day[]"
                                                                                    class="form-check-input"
                                                                                    id="weekend-monday" value="monday"
                                                                                    {{ in_array('monday', $savedWeekendDays) ? 'checked' : '' }}>
                                                                                <label class="form-check-label"
                                                                                    for="weekend-monday">Monday</label>
                                                                            </div>
                                                                            <div class="form-check custom-checkbox">
                                                                                <input type="checkbox"
                                                                                    name="weekend_day[]"
                                                                                    class="form-check-input"
                                                                                    id="weekend-tuesday" value="tuesday"
                                                                                    {{ in_array('tuesday', $savedWeekendDays) ? 'checked' : '' }}>
                                                                                <label class="form-check-label"
                                                                                    for="weekend-tuesday">Tuesday</label>
                                                                            </div>
                                                                            <div class="form-check custom-checkbox">
                                                                                <input type="checkbox"
                                                                                    name="weekend_day[]"
                                                                                    class="form-check-input"
                                                                                    id="weekend-wednesday"
                                                                                    value="wednesday" {{ in_array('wednesday', $savedWeekendDays) ? 'checked' : '' }}>
                                                                                <label class="form-check-label"
                                                                                    for="weekend-wednesday">Wednesday</label>
                                                                            </div>
                                                                            <div class="form-check custom-checkbox">
                                                                                <input type="checkbox"
                                                                                    name="weekend_day[]"
                                                                                    class="form-check-input"
                                                                                    id="weekend-thursday"
                                                                                    value="thursday" {{ in_array('thursday', $savedWeekendDays) ? 'checked' : '' }}>
                                                                                <label class="form-check-label"
                                                                                    for="weekend-thursday">Thursday</label>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Right Column (remaining 3 days) -->
                                                                        <div class="col-md-6">
                                                                            <div class="form-check custom-checkbox">
                                                                                <input type="checkbox"
                                                                                    name="weekend_day[]"
                                                                                    class="form-check-input"
                                                                                    id="weekend-friday" value="friday"
                                                                                    {{ in_array('friday', $savedWeekendDays) ? 'checked' : '' }}>
                                                                                <label class="form-check-label"
                                                                                    for="weekend-friday">Friday</label>
                                                                            </div>
                                                                            <div class="form-check custom-checkbox">
                                                                                <input type="checkbox"
                                                                                    name="weekend_day[]"
                                                                                    class="form-check-input"
                                                                                    id="weekend-saturday"
                                                                                    value="saturday" {{ in_array('saturday', $savedWeekendDays) ? 'checked' : '' }}>
                                                                                <label class="form-check-label"
                                                                                    for="weekend-saturday">Saturday</label>
                                                                            </div>
                                                                            <div class="form-check custom-checkbox">
                                                                                <input type="checkbox"
                                                                                    name="weekend_day[]"
                                                                                    class="form-check-input"
                                                                                    id="weekend-sunday" value="sunday"
                                                                                    {{ in_array('sunday', $savedWeekendDays) ? 'checked' : '' }}>
                                                                                <label class="form-check-label"
                                                                                    for="weekend-sunday">Sunday</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>


                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div
                                                                class="col-md-12 d-flex justify-content-between align-items-center">
                                                                <h4 class="text-primary">List of Holidays</h5>
                                                                    <button class="btn btn-primary btn-sm"
                                                                        data-toggle="modal"
                                                                        data-target="#addHolidayModal">
                                                                        <i class="fa fa-plus"></i>
                                                                    </button>
                                                            </div>
                                                        </div>

                                                        @if($holidays->isEmpty())
                                                            <p>No holidays added yet.</p>
                                                        @else

                                                            <div class="table-responsive"
                                                                style="max-height: 291px; overflow-y: auto; margin-top: 10px;">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Name</th>
                                                                            <th>Date</th>
                                                                            <th>Delete</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach($holidays as $holiday)
                                                                            <tr>
                                                                                <td>{{ $holiday->holiday_name }}</td>
                                                                                <td>{{ \Carbon\Carbon::parse($holiday->date)->format('d M Y') }}
                                                                                </td>
                                                                                <td>

                                                                                    <a href="#"
                                                                                        onclick="confirmDelete('{{ $holiday->id }}')"><button
                                                                                            type="submit"
                                                                                            class="btn btn-danger btn-sm">
                                                                                            <i class="fas fa-trash-alt"></i>
                                                                                            <!-- Font Awesome Trash Icon -->
                                                                                        </button></a>

                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div
                                                                class="col-md-12 d-flex justify-content-between align-items-center">
                                                                <h4 class="text-primary">Run Cron</h5>
                                                            </div>
                                                        </div>
                                                        <div class="table-responsive"
                                                            style="max-height: 291px; overflow-y: auto; margin-top: 10px;">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Cron Jobs Name</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>Allot Workout</td>
                                                                        <td>
                                                                            <form
                                                                                action="{{ route('runWorkoutCronJob') }}"
                                                                                method="get">
                                                                                @csrf
                                                                                <button type="submit"
                                                                                    class="btn btn-primary">Run</button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Allot Diet</td>
                                                                        <td>
                                                                            <form action="{{ route('runDietCronJob') }}"
                                                                                method="get">
                                                                                @csrf
                                                                                <button type="submit"
                                                                                    class="btn btn-primary">Run</button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>User Attendence</td>
                                                                        <td>
                                                                            <form
                                                                                action="{{ route('runAttendenceCronJob') }}"
                                                                                method="get">
                                                                                @csrf
                                                                                <button type="submit"
                                                                                    class="btn btn-primary">Run</button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Workout Histry</td>
                                                                        <td>
                                                                            <form
                                                                                action="{{ route('runWorkoutHistryCronJob') }}"
                                                                                method="get">
                                                                                @csrf
                                                                                <button type="submit"
                                                                                    class="btn btn-primary">Run</button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Diet Histry</td>
                                                                        <td>
                                                                            <form
                                                                                action="{{ route('runDietHistryCronJob') }}"
                                                                                method="get">
                                                                                @csrf
                                                                                <button type="submit"
                                                                                    class="btn btn-primary">Run</button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                    </div>

                                                </div>

                                                <!-- Modal Structure -->
                                                <div class="modal fade" id="addHolidayModal" tabindex="-1" role="dialog"
                                                    aria-labelledby="addHolidayModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="addHolidayModalLabel">Add
                                                                    Holiday</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!-- Form inside modal -->
                                                                <form action="/add-holiday" method="POST">
                                                                    @csrf
                                                                    <div class="form-group">
                                                                        <label for="holiday-name">Holiday Name</label>
                                                                        <input type="text" class="form-control"
                                                                            id="holiday-name" name="holiday_name"
                                                                            placeholder="Enter Holiday Name" />
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="holiday-date">Holiday Date</label>
                                                                        <input type="date" class="form-control"
                                                                            id="holiday-date" name="date" />
                                                                    </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Save
                                                                    Holiday</button>
                                                            </div>

                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div id="account-settings" class="tab-pane fade">
                                        <br>
                                        <form id="updateProfile" action="/update-gym-account" method="POST"
                                            enctype="multipart/form-data" class="needs-validation" novalidate>
                                            @csrf
                                            <div class="card mb-4" style="max-width: 600px; margin: 0 auto;">
                                                <div class="card-body text-center">
                                                    <!-- Display Current Profile Image -->
                                                    <div class="profile-image-wrapper mb-3">
                                                        @if($gym->image)
                                                            <img id="profileImagePreview" src="{{ asset($gym->image) }}"
                                                                alt="Profile Image"
                                                                style="width: 250px; height: 160px; object-fit: cover circle; border: 3px solid #6CC51D;">
                                                        @else
                                                            <img id="profileImagePreview"
                                                                src="{{ asset('images/avatar/default_gym_image.png') }}"
                                                                alt="Default Image"
                                                                style="width: 250px; height: 160px; object-fit: cover; border: 3px solid #007bff;">
                                                        @endif
                                                    </div>

                                                    <!-- File input for image upload -->
                                                    <div class="form-group">
                                                        <input type="file" name="image" id="profileImageInput"
                                                            class="form-control-file">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label>Gym Name <span class="required">*</span></label>
                                                    <input type="text" name="gym_name" placeholder="Email"
                                                        value="{{$gym->gym_name	}}" class="form-control" required>
                                                    <div class="invalid-feedback">
                                                        Gym Name are required.
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Username <span class="required">*</span></label>
                                                    <input type="text" name="username" value="{{$gym->username}}"
                                                        class="form-control" required>
                                                    <div class="invalid-feedback">
                                                        Username are required.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label>Email</label>
                                                    <input type="email" name="email" placeholder="Email"
                                                        value="{{$gym->email}}" class="form-control" readonly>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label>Phone <span class="required">*</span></label>
                                                    <input type="text" id="phone_no" name="phone_no" placeholder="Phone"
                                                        value="{{$gym->phone_no}}" class="form-control" required>
                                                    <small id="phoneError" class="text-danger"
                                                        style="display: none;">Please enter a valid 10-digit phone
                                                        number.</small>
                                                    <div class="invalid-feedback">
                                                        Phone are required.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label>Gym Type <span class="required">*</span></label>
                                                    <select name="gym_type" class="form-control" required>
                                                        <option value="">Select Gym Type</option>
                                                        <option value="Male" {{ $gym->gym_type == 'Male' ? 'selected' : '' }}>Male</option>
                                                        <option value="Female" {{ $gym->gym_type == 'Female' ? 'selected' : '' }}>Female</option>
                                                        <option value="Unisex" {{ $gym->gym_type == 'Unisex' ? 'selected' : '' }}>Unisex</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Gym Type are required.
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Facebook Link</label>
                                                    <input type="text" id="face_link" name="face_link"
                                                        placeholder="Facebook Link" value="{{$gym->face_link}}"
                                                        class="form-control">
                                                    <small id="facebookError" style="display:none; color: red;">Please
                                                        enter a valid Facebook URL (e.g.,
                                                        https://www.facebook.com/username).</small>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label class="mb-1" for="gym_documents">Gym Document <span
                                                            class="required">*</span></label>
                                                    <input type="file" class="form-control" id="gym_document"
                                                        name="gym_document" accept=".pdf, .jpg, .jpeg"
                                                        @if(!$gym->gym_document) required @endif>
                                                    <div class="invalid-feedback">
                                                        Gym Document (PDF or image) is required.
                                                    </div>
                                                    <!-- Display the current gym document filename if it exists -->
                                                    @if($gym->gym_document)
                                                        <small class="text-muted"> <a href="{{ asset($gym->gym_document) }}"
                                                                target="_blank">{{ basename($gym->gym_document) }}</a></small>
                                                    @endif
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label class="mb-1" for="owner_identity_document">Owner Identity
                                                        Document <span class="required">*</span></label>
                                                    <input type="file" class="form-control" id="owner_identity_document"
                                                        name="owner_identity_document" accept=".pdf, .jpg, .jpeg"
                                                        @if(!$gym->owner_identity_document) required @endif>
                                                    <div class="invalid-feedback">
                                                        Owner Identity Document (PDF or image) is required.
                                                    </div>
                                                    <!-- Display the current owner identity document filename if it exists -->
                                                    @if($gym->owner_identity_document)
                                                        <small class="text-muted"> <a
                                                                href="{{ asset($gym->owner_identity_document) }}"
                                                                target="_blank">{{ basename($gym->owner_identity_document) }}</a></small>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label>Website Link</label>
                                                    <input type="text" id="web_link" name="web_link"
                                                        placeholder="Web Link" value="{{$gym->web_link}}"
                                                        class="form-control">
                                                    <small class="error-message" id="websiteError"
                                                        style="color: red; display: none;">Please enter a valid Website
                                                        URL (e.g., https://www.example.com).</small>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Instagram Link</label>
                                                    <input type="text" id="insta_link" name="insta_link"
                                                        placeholder="Insta Link" value="{{$gym->insta_link}}"
                                                        class="form-control">
                                                    <small class="error-message" id="instagramError"
                                                        style="color: red; display: none;">Please enter a valid
                                                        Instagram URL (e.g.,
                                                        https://www.instagram.com/username).</small>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Address <span class="required">*</span></label>
                                                <textarea name="address" placeholder="Apartment, studio, or floor"
                                                    class="form-control" required>{{$gym->address}}</textarea>
                                                <div class="invalid-feedback">
                                                    Address are required.
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-4">
                                                    <label>City <span class="required">*</span></label>
                                                    <input name="city_id" type="text" class="form-control"
                                                        value="{{$gym->city_id}}" required>
                                                    <div class="invalid-feedback">
                                                        City are required.
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label>State <span class="required">*</span></label>
                                                    <input name="state_id" type="text" class="form-control"
                                                        value="{{$gym->state_id}}" required>
                                                    <div class="invalid-feedback">
                                                        State are required.
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label>Country <span class="required">*</span></label>
                                                    <input name="country_id" type="text" class="form-control"
                                                        value="{{$gym->country_id}}" required>
                                                    <div class="invalid-feedback">
                                                        Country are required.
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary col-md-12" type="submit">Update</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="replyModal">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Post Reply</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <textarea class="form-control" rows="4">Message</textarea>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger light"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Reply</button>
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

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

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

    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Are you sure you want to delete this holiday?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/delete-holiday/' + id;
            }
        });
    }

    document.getElementById('profileImageInput').addEventListener('change', function (event) {
        const imageFile = event.target.files[0];
        if (imageFile) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('profileImagePreview').src = e.target.result;
            };
            reader.readAsDataURL(imageFile);
        }
    });

    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("updateProfile");

        const phoneInput = document.getElementById("phone_no");

        const phoneError = document.getElementById("phoneError");

        const facebookInput = document.getElementById("face_link");
        const facebookError = document.getElementById("facebookError");

        const websiteInput = document.getElementById("web_link");
        const websiteError = document.getElementById("websiteError");

        const instagramInput = document.getElementById("insta_link");
        const instagramError = document.getElementById("instagramError");



        // Helper function to validate phone format
        function isValidPhone(phone) {
            const phonePattern = /^\d{10}$/; // for 10-digit phone numbers
            return phonePattern.test(phone);
        }

        // Helper function to validate general URL format
        function isValidURL(url) {
            const urlPattern = /^(https?:\/\/)?(www\.)?[a-zA-Z0-9-]+\.[a-zA-Z]{2,}(\S*)?$/;
            return urlPattern.test(url);
        }

        // Specific Facebook URL validation
        function isValidFacebook(url) {
            const facebookPattern = /^(https?:\/\/)?(www\.)?facebook\.com\/[a-zA-Z0-9(\.\?)?]/;
            return facebookPattern.test(url);
        }

        // Specific Instagram URL validation
        function isValidInstagram(url) {
            const instagramPattern = /^(https?:\/\/)?(www\.)?instagram\.com\/[a-zA-Z0-9(\.\?)?]/;
            return instagramPattern.test(url);
        }


        // Real-time validation for phone
        phoneInput.addEventListener("input", function () {
            if (!isValidPhone(phoneInput.value)) {
                phoneError.style.display = "block";
            } else {
                phoneError.style.display = "none";
            }
        });


        // Real-time validation for Facebook Link
        facebookInput.addEventListener("input", function () {
            if (!isValidFacebook(facebookInput.value)) {
                facebookError.style.display = "block";
            } else {
                facebookError.style.display = "none";
            }
        });

        // Real-time validation for Website Link
        websiteInput.addEventListener("input", function () {
            if (!isValidURL(websiteInput.value)) {
                websiteError.style.display = "block";
            } else {
                websiteError.style.display = "none";
            }
        });

        // Real-time validation for Instagram Link
        instagramInput.addEventListener("input", function () {
            if (!isValidInstagram(instagramInput.value)) {
                instagramError.style.display = "block";
            } else {
                instagramError.style.display = "none";
            }
        });



        // Form validation on submit
        form.addEventListener("submit", function (event) {
            let isFormValid = true;

            // Phone validation on submit
            if (!isValidPhone(phoneInput.value)) {
                phoneError.style.display = "block";
                phoneInput.classList.add("is-invalid");
                isFormValid = false;
            } else {
                phoneError.style.display = "none";
                phoneInput.classList.remove("is-invalid");
            }

            // // Facebook link validation on submit
            // if (!isValidFacebook(facebookInput.value)) {
            //     facebookError.style.display = "block";
            //     facebookInput.classList.add("is-invalid");
            //     isFormValid = false;
            // } else {
            //     facebookError.style.display = "none";
            //     facebookInput.classList.remove("is-invalid");
            // }

            // // Website link validation on submit
            // if (!isValidURL(websiteInput.value)) {
            //     websiteError.style.display = "block";
            //     websiteInput.classList.add("is-invalid");
            //     isFormValid = false;
            // } else {
            //     websiteError.style.display = "none";
            //     websiteInput.classList.remove("is-invalid");
            // }

            // // Instagram link validation on submit
            // if (!isValidInstagram(instagramInput.value)) {
            //     instagramError.style.display = "block";
            //     instagramInput.classList.add("is-invalid");
            //     isFormValid = false;
            // } else {
            //     instagramError.style.display = "none";
            //     instagramInput.classList.remove("is-invalid");
            // }


            // Prevent form submission if any field is invalid
            if (!isFormValid) {
                event.preventDefault(); // Stop form from submitting
            }
        });
    });



</script>

@include('CustomSweetAlert');
@endsection