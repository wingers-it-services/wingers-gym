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
                    <div class="dropdown ms-auto">
                        <a href="#" class="btn btn-primary light sharp" data-bs-toggle="dropdown" aria-expanded="true"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg></a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li class="dropdown-item"><i class="fa fa-user-circle text-primary me-2"></i> View profile</li>
                            <li class="dropdown-item"><i class="fa fa-users text-primary me-2"></i> Add to close friends</li>
                            <li class="dropdown-item"><i class="fa fa-plus text-primary me-2"></i> Add to group</li>
                            <li class="dropdown-item"><i class="fa fa-ban text-primary me-2"></i> Block</li>
                        </ul>
                    </div>
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
                            <h3 class="m-b-0">{{ $totalUsers }}</h3><span>Follower</span>
                        </div>
                        <div class="col">
                            <h3 class="m-b-0">5</h3><span>Total Years</span>
                        </div>
                        <div class="col">
                            <h3 class="m-b-0">45</h3><span>Reviews</span>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="javascript:void()" class="btn btn-primary mb-1" data-bs-toggle="modal" data-bs-target="#sendMessageModal">Send Message</a>
                    </div>
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
                                                <label class="text-black font-w600">Name <span class="required">*</span></label>
                                                <input type="text" class="form-control" value="Author" name="Author" placeholder="Author">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label  class="text-black font-w600">Email <span class="required">*</span></label>
                                                <input type="text" class="form-control" value="Email" placeholder="Email" name="Email">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label  class="text-black font-w600">Comment</label>
                                                <textarea rows="8" class="form-control" name="comment" placeholder="Comment"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <input type="submit" value="Post Comment" class="submit btn btn-primary" name="submit">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="profile-news">
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
            </div>
        </div>
    </div>
</div>
<div class="col-xl-8">
    <div class="card h-auto">
        <div class="card-body">
            <div class="profile-tab">
                <div class="custom-tab-1">
                    <ul class="nav nav-tabs">
                        <li class="nav-item"><a href="#about-me" data-bs-toggle="tab" class="nav-link">About Me</a>
                        </li>
                        <li class="nav-item"><a href="#profile-settings" data-bs-toggle="tab" class="nav-link">Setting</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="about-me" class="tab-pane fade active show">
                            <div class="profile-about-me">
                                <div class="pt-4 border-bottom-1 pb-3">
                                    <h4 class="text-primary">About Me</h4>
                                    <p class="mb-2">A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart. I am alone, and feel the charm of existence was created for the bliss of souls like mine.I am so happy, my dear friend, so absorbed in the exquisite sense of mere tranquil existence, that I neglect my talents.</p>
                                    <p>A collection of textile samples lay spread out on the table - Samsa was a travelling salesman - and above it there hung a picture that he had recently cut out of an illustrated magazine and housed in a nice, gilded frame.</p>
                                </div>
                            </div>
                            <!-- <div class="profile-skills mb-5">
                                <h4 class="text-primary mb-2">Skills</h4>
                                <a href="javascript:void()" class="btn btn-primary light btn-xs mb-1">Admin</a>
                                <a href="javascript:void()" class="btn btn-primary light btn-xs mb-1">Dashboard</a>
                                <a href="javascript:void()" class="btn btn-primary light btn-xs mb-1">Photoshop</a>
                                <a href="javascript:void()" class="btn btn-primary light btn-xs mb-1">Bootstrap</a>
                                <a href="javascript:void()" class="btn btn-primary light btn-xs mb-1">Responsive</a>
                                <a href="javascript:void()" class="btn btn-primary light btn-xs mb-1">Crypto</a>
                            </div> -->
                          
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
                                <div class="settings-form">
                                    <h4 class="text-primary">Account Setting</h4>
                                    <form>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Email</label>
                                                <input type="email" placeholder="Email" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Password</label>
                                                <input type="password" placeholder="Password" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input type="text" placeholder="1234 Main St" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Address 2</label>
                                            <input type="text" placeholder="Apartment, studio, or floor" class="form-control">
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>City</label>
                                                <input type="text" class="form-control">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>State</label>
                                                <select class="form-control default-select" id="inputState">
                                                    <option selected="">Choose...</option>
                                                    <option>Option 1</option>
                                                    <option>Option 2</option>
                                                    <option>Option 3</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label>Zip</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-check custom-checkbox">
                                                <input type="checkbox" class="form-check-input" id="gridCheck">
                                                <label class="form-check-label" for="gridCheck"> Check me out</label>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary" type="submit">Sign
                                            in</button>
                                    </form>
                                </div>
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
                                <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
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




@endsection
