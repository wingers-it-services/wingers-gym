@extends('GymOwner.master')
@section('title', 'Dashboard')
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
                        <form class="needs-validation" action="{{route('updateStaff')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-4 order-lg-2 mb-4">
                                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="text-black">Staff Image</span>
                                    </h4>
                                    <ul class="list-group mb-3">
                                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                                            <div>
                                                <img id="selected_image" src="{{ '../' . $staffDetail->image ?? 'https://www.w3schools.com/howto/img_avatar.png' }} " style="border-radius: 50%;width: 200px;height:200px">
                                            </div>
                                        </li>

                                    </ul>
                                    <div class="input-group">
                                        <input class="form-control form-control-sm" id="image" name="image" onchange="loadFile(event)" accept="image/*" type="file">
                                    </div>
                                </div>
                                <div class="col-lg-8 order-lg-1">
                                    <h4 class="mb-3">Staff Details</h4>
                                    <input type="hidden" class="form-control" id="uuid" name="uuid" placeholder="" value="{{ $staffDetail->uuid }}">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="name">Staff Name</label>
                                            <input type="text" class="form-control" id="full_name" name="full_name" placeholder="" value="{{ $staffDetail->name }}" required="">
                                            <div class="invalid-feedback">
                                                Valid first name is required.
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="employee_id">Staff Emp Id</label>
                                            <input type="text" class="form-control" id="employee_id" name="employee_id" placeholder="" value="{{ $staffDetail->employee_id }}" required="">
                                            <div class="invalid-feedback">
                                                Valid first name is required.
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="email">Email <span class="text-muted">(Optional)</span></label>
                                            <input type="email" class="form-control" id="email" name="email" value="{{ $staffDetail->email }}">
                                            <div class="invalid-feedback">
                                                Please enter a valid email address for shipping updates.
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="designation_id">Staff Designation</label>
                                            <select class="me-sm-2 form-control default-select" id="designation" name="designation">
                                                <option selected>Choose...</option>
                                                @foreach ($designations as $designation)
                                                <option value="{{ $designation->id }}" {{ $staffDetail->designation_id == $designation->id ? 'selected' : '' }}>
                                                    {{ $designation->designation_name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Valid last name is required.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="number">Staff Number</label>
                                            <input type="text" class="form-control" id="number" name="number" placeholder="" value="{{ $staffDetail->number }}" required="">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="salary">Staff Salary</label>
                                            <input type="text" class="form-control" id="salary" name="salary" placeholder="" value="{{ $staffDetail->salary }}" required="">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="joining_date">Staff Joining Date</label>
                                            <input type="text" class="form-control" id="joining_date" name="joining_date" placeholder="" value="{{ $staffDetail->joining_date }}" required="">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="blood_group">Staff Blood Group</label>
                                            <select class="me-sm-2 form-control default-select" id="blood_group" name="blood_group">
                                                <option {{ $staffDetail->blood_group == 'A+' ? 'selected' : '' }} value="A+">A+</option>
                                                <option {{ $staffDetail->blood_group == 'A-' ? 'selected' : '' }} value="A-">A-</option>
                                                <option {{ $staffDetail->blood_group == 'B+' ? 'selected' : '' }} value="B+">B+</option>
                                                <option {{ $staffDetail->blood_group == 'B-' ? 'selected' : '' }} value="B-">B-</option>
                                                <option {{ $staffDetail->blood_group == 'AB+' ? 'selected' : '' }} value="AB+">AB+</option>
                                                <option {{ $staffDetail->blood_group == 'AB-' ? 'selected' : '' }} value="AB-">AB-</option>
                                                <option {{ $staffDetail->blood_group == 'O+' ? 'selected' : '' }} value="O+">O+</option>
                                                <option {{ $staffDetail->blood_group == 'O-' ? 'selected' : '' }} value="O-">O-</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="joining_date">Phone Number</label>
                                            <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="" value="{{ $staffDetail->number }}" required="">
                                        </div>


                                    </div>


                                    <div class="mb-3">
                                        <label for="address">Address</label>
                                        <input type="text" class="form-control" id="address" value="{{ $staffDetail->address }}" name="address" required="">
                                        <div class="invalid-feedback">
                                            Please enter your shipping address.
                                        </div>
                                    </div>
                                    <hr class="mb-4">
                                    <button class="btn btn-primary btn-lg btn-block" type="submit">Update</button>
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
@include('CustomSweetAlert');
@endsection