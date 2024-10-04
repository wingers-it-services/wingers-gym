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
                        <form id="myForm" class="needs-validation" action="{{route('updateStaff')}}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-4 order-lg-2 mb-4">
                                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="text-black">Staff Image</span>
                                    </h4>
                                    <ul class="list-group mb-3">
                                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                                            <div>
                                                <img id="selected_image"
                                                    src="{{ $staffDetail->image ?? 'https://www.w3schools.com/howto/img_avatar.png' }} "
                                                    style="border-radius: 50%;width: 200px;height:200px">
                                            </div>
                                        </li>

                                    </ul>
                                    <div class="row">
                                        <div class="input-group">
                                            <input class="form-control form-control-sm" id="image" name="image"
                                                onchange="loadFile(event)" accept="image/*" type="file">
                                        </div>
                                    </div>

                                    <div class="row" style="padding-top: 8%;">
                                        <label for="address">Address <span class="required">*</span></label>

                                        <div class="input-group">
                                            <textarea type="text" class="form-control form-control-sm" rows="10"
                                                id="address" name="address"
                                                required="">{{ $staffDetail->address }}</textarea>
                                        </div>
                                        <div class="invalid-feedback">
														Staff Address is required.
													</div>
                                    </div>

                                </div>
                                <div class="col-lg-8 order-lg-1">
                                    <h4 class="mb-3">Staff Details</h4>
                                    <input type="hidden" class="form-control" id="uuid" name="uuid" placeholder=""
                                        value="{{ $staffDetail->uuid }}">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="name">Staff Name <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="full_name" name="full_name"
                                                placeholder="" value="{{ $staffDetail->name }}" required="">
                                            <small id="nameError" class="text-danger" style="display: none;">Only
                                                letters are allowed.</small>
                                            <div class="invalid-feedback">
                                                Staff Full Name is required.
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="employee_id">Staff Emp Id <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="staff_id" name="employee_id"
                                                placeholder="" value="{{ $staffDetail->employee_id }}" required="">
                                                <small id="employee-error" class="text-danger"
													style="display: none;">Enter a valid Employee Id.</small>
                                            <div class="invalid-feedback">
                                                Employee Id is required.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="gender">Gender <span class="required">*</span></label>
                                            <select class="me-sm-2 form-control default-select" id="gender"
                                                name="gender">
                                                <option value="">Choose...</option>
                                                <option {{ $staffDetail->gender == 'male' ? 'selected' : '' }}
                                                    value="male">Male</option>
                                                <option {{ $staffDetail->gender == 'female' ? 'selected' : '' }}
                                                    value="female">Female</option>
                                                <option {{ $staffDetail->gender == 'Other' ? 'selected' : '' }}
                                                    value="Other">Other</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Choose a gender.
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="employee_id">Experience in Years <span class="required">*</span></label>
                                            <input type="number" class="form-control" id="experience" name="experience"
                                                placeholder="" value="{{ $staffDetail->experience }}" required="">
                                            <small id="experienceError" class="text-danger"
                                                style="display: none;">Please enter a valid Experience.</small>
                                            <div class="invalid-feedback">
                                                Staff Experience is required.
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="email">Email Address <span class="required">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                value="{{ $staffDetail->email }}">
                                            <small id="emailError" class="text-danger" style="display: none;">Please
                                                enter a valid email
                                                address.</small>
                                            <div class="invalid-feedback">
                                                Staff Email is required.
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="number">Phone Number <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="phone_number" name="phone_number"
                                                placeholder="" value="{{ $staffDetail->number }}" required="">
                                            <small id="phoneError" class="text-danger" style="display: none;">Please
                                                enter a valid phone
                                                number.</small>
                                            <div class="invalid-feedback">
                                                Staff Phone Number is required.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="text-label">Date Of Birth<span
                                                    class="required">*</span></label>
                                            <input type="date" name="dob" id="dob" class="form-control"
                                                value="{{$staffDetail->dob}}">
                                            <small id="dobError" class="text-danger" style="display: none;">You
                                                must be at least 18 years old.</small>
                                            <div class="invalid-feedback" required>
                                                Staff D.O.B is required.
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="text-label">Whatsapp Number<span
                                                    class="required">*</span></label>
                                            <input type="text" name="whatsapp_no" id="whatsapp_no" class="form-control"
                                                value="{{$staffDetail->whatsapp_no}}" placeholder="(+1)408-657-9007">
                                            <small id="whatsphoneError" class="text-danger"
                                                style="display: none;">Please enter a valid whatsapp
                                                number.</small>
                                            <div class="invalid-feedback" required>
                                                Staff Whatsapp No. is required.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="joining_date">Joining Date <span
                                                    class="required">*</span></label>
                                            <input type="date" class="form-control" id="joining_date"
                                                name="joining_date" placeholder=""
                                                value="{{ $staffDetail->joining_date }}" required="">
                                            <small id="joiningDateError" class="text-danger" style="display: none;">
                                                Staff Joining Date must be today or a
                                                future date.</small>
                                            <div class="invalid-feedback">
                                                Staff Joining Date is required.
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="salary">Salary</label>
                                            <input type="text" class="form-control" id="salary" name="salary"
                                                placeholder="" value="{{ $staffDetail->salary }}" required="">
                                            <small id="salaryError" class="text-danger" style="display: none;">Please
                                                enter a valid salary.</small>
                                            <div class="invalid-feedback">
                                                Staff Salary is required.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-6 mb-3">
                                            <label for="blood_group">Staff Blood Group <span class="required">*</span></label>
                                            <select class="me-sm-2 form-control default-select" id="blood_group"
                                                name="blood_group">
                                                <option {{ $staffDetail->blood_group == 'A+' ? 'selected' : '' }}
                                                    value="A+">A+</option>
                                                <option {{ $staffDetail->blood_group == 'A-' ? 'selected' : '' }}
                                                    value="A-">A-</option>
                                                <option {{ $staffDetail->blood_group == 'B+' ? 'selected' : '' }}
                                                    value="B+">B+</option>
                                                <option {{ $staffDetail->blood_group == 'B-' ? 'selected' : '' }}
                                                    value="B-">B-</option>
                                                <option {{ $staffDetail->blood_group == 'AB+' ? 'selected' : '' }}
                                                    value="AB+">AB+</option>
                                                <option {{ $staffDetail->blood_group == 'AB-' ? 'selected' : '' }}
                                                    value="AB-">AB-</option>
                                                <option {{ $staffDetail->blood_group == 'O+' ? 'selected' : '' }}
                                                    value="O+">O+</option>
                                                <option {{ $staffDetail->blood_group == 'O-' ? 'selected' : '' }}
                                                    value="O-">O-</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Choose a Blood Group .
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="designation_id">Staff Designation <span
                                            class="required">*</span></label>
                                            <select class="me-sm-2 form-control" id="designation"
                                                name="designation">
                                                <option selected>Choose...</option>
                                                @foreach ($designations as $designation)
                                                    <option value="{{ $designation->id }}"
                                                        data-is-commission-based="{{ $designation->is_commission_based }}"
                                                        {{ $staffDetail->designation_id == $designation->id ? 'selected' : '' }}>
                                                        {{ $designation->designation_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
												Choose a Staff Designation.
												</div>
                                        </div>
                                        <div class="col-lg-4 mb-2" id="fees-field">
                                            <div class="form-group">
                                                <label class="text-label">Fees<span class="required">*</span></label>
                                                <input type="number" name="fees" id="fees" placeholder="10000"
                                                    value="{{$staffDetail->fees}}" class="form-control">
                                                    <small id="fees-error" style="color: red; display: none;">Enter a
														valid fees</small>
													<div class="invalid-feedback">
														Fees is required.
													</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 mb-2" id="staff-commission-field">
                                            <div class="form-group">
                                                <label class="text-label">Staff Commission (%) <span
                                                        class="required">*</span></label>
                                                <input type="number" name="staff_commission" id="staff_commission"
                                                    value="{{$staffDetail->staff_commission}}" placeholder="20"
                                                    class="form-control" step="0.01" max=100>
                                                    <small id="staff-commission-error"
														style="color: red; display: none;">Enter valid Staff
														Commission</small>
													<div class="invalid-feedback">
														Staff Commission is required.
													</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 mb-2" id="gym-commission-field">
                                            <div class="form-group">
                                                <label class="text-label">Gym Commission (%)<span
                                                        class="required">*</span></label>
                                                <input type="number" name="gym_commission" id="gym_commission"
                                                    value="{{$staffDetail->gym_commission}}" placeholder="80"
                                                    class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-lg btn-block" type="submit">Update</button>
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
</div>
</div>
<!--**********************************
                    Content body end
                ***********************************-->
<script>
    var loadFile = function (event) {
        // var selected_image = document.getElementById('selected_image');

        var input = event.target;
        var image = document.getElementById('selected_image');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
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

    (function () {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
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
        const staffCommissionInput = document.getElementById('staff_commission');
        const gymCommissionInput = document.getElementById('gym_commission');
        const errorMessage = document.getElementById('staff-commission-error');
        const designationSelect = document.getElementById('designation');
        const feesInput = document.getElementById('fees');

        // Handle Staff Commission Input
        staffCommissionInput.addEventListener('input', function () {
            let staffCommissionValue = parseFloat(staffCommissionInput.value) || 0;

            // Check if the value is greater than 100
            if (staffCommissionValue > 100) {
                errorMessage.style.display = 'block';
                gymCommissionInput.value = ''; // Clear gym commission if the input is invalid
            } else {
                errorMessage.style.display = 'none';

                // Calculate Gym Commission as the remaining percentage
                const gymCommissionValue = 100 - staffCommissionValue;
                gymCommissionInput.value = gymCommissionValue;
            }
        });

        // Handle Designation Change
        designationSelect.addEventListener('change', function () {
            // Reset the inputs
            feesInput.value = '';
            staffCommissionInput.value = '';
            gymCommissionInput.value = '';
            errorMessage.style.display = 'none'; // Hide error message
        });
    });
    
    document.addEventListener('DOMContentLoaded', function () {
        const designationSelect = document.getElementById('designation');
        const feesField = document.getElementById('fees-field');
        const staffCommissionField = document.getElementById('staff-commission-field');
        const gymCommissionField = document.getElementById('gym-commission-field');

        // Function to toggle fields based on commission-based value
        function toggleFields() {
            const selectedOption = designationSelect.options[designationSelect.selectedIndex];
            const isCommissionBased = selectedOption ? selectedOption.getAttribute('data-is-commission-based') === '1' : false;

            if (isCommissionBased) {
                feesField.style.display = 'block';
                staffCommissionField.style.display = 'block';
                gymCommissionField.style.display = 'block';
            } else {
                feesField.style.display = 'none';
                staffCommissionField.style.display = 'none';
                gymCommissionField.style.display = 'none';
            }
        }

        // Initialize visibility based on the initially selected option
        toggleFields();

        // Add event listener to handle changes
        designationSelect.addEventListener('change', toggleFields);
    });

    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("myForm");

        const nameInput = document.getElementById("full_name");
        const emailInput = document.getElementById("email");
        const phoneInput = document.getElementById("phone_number");
        const whatsPhoneInput = document.getElementById("whatsapp_no");
        const dobInput = document.getElementById("dob");
        const feesInput = document.getElementById("fees");
        const staffCommissionInput = document.getElementById("staff_commission");
        const experienceInput = document.getElementById("experience");
        const salaryInput = document.getElementById("salary");
		const employeeInput =document.getElementById("staff_id");

        const joiningDateInput = document.getElementById("joining_date");
        const joiningDateError = document.getElementById("joiningDateError");
        const salaryError = document.getElementById("salaryError");
        const experienceError = document.getElementById("experienceError");
        const nameError = document.getElementById("nameError");
        const emailError = document.getElementById("emailError");
        const phoneError = document.getElementById("phoneError");
        const phoneError1 = document.getElementById("whatsphoneError");
        const dobError = document.getElementById("dobError");
        const staffCommissionError = document.getElementById("staff-commission-error");
        const feesError = document.getElementById("fees-error");
		const employeeError =document.getElementById("employee-error");


        //Function to get today's date in 'YYYY - MM - DD' format
        function getTodayDate() {
            const today = new Date();
            const year = today.getFullYear();
            const month = (today.getMonth() + 1).toString().padStart(2, '0'); // Months are 0-indexed
            const day = today.getDate().toString().padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        // Set minimum date to today (prevents selecting past dates)
        const today = getTodayDate();
        joiningDateInput.setAttribute('min', today);

        employeeInput.addEventListener("input", function () {
			const employeeValue = parseFloat(employeeInput.value);
			if (employeeValue <= 0 || isNaN(employeeValue)) {
				employeeError.style.display = "block";
			} else {
				employeeError.style.display = "none";
			}
		});

        // Real-time validation for fees
        feesInput.addEventListener("input", function () {
            const feesValue = parseFloat(feesInput.value);
            if (feesValue <= 0 || isNaN(feesValue)) {
                feesError.style.display = "block";
            } else {
                feesError.style.display = "none";
            }
        });


        // Real-time validation for staff commission
        staffCommissionInput.addEventListener("input", function () {
            const staffCommissionValue = parseFloat(staffCommissionInput.value);
            if (staffCommissionValue <= 0 || staffCommissionValue > 100 || isNaN(staffCommissionValue)) {
                staffCommissionError.style.display = "block";
            } else {
                staffCommissionError.style.display = "none";
            }
        });

        salaryInput.addEventListener("input", function () {
            const salaryValue = parseFloat(salaryInput.value);
            if (salaryValue <= 0 || isNaN(salaryInput.value)) {
                salaryError.style.display = "block";
            } else {
                salaryError.style.display = "none";
            }
        });

        experienceInput.addEventListener("input", function () {
            const experienceValue = parseFloat(experienceInput.value);
            if (experienceValue < 0 || isNaN(salaryInput.value)) {
                experienceError.style.display = "block";
            } else {
                experienceError.style.display = "none";
            }
        });

        function isValidName(fullname) {
            const namePattern = /^[A-Za-z\s]+$/;
            return namePattern.test(fullname);
        }

        // Helper function to validate email format
        function isValidEmail(email) {
            const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            return emailPattern.test(email);
        }

        // Helper function to validate phone format
        function isValidPhone(phone) {
            const phonePattern = /^\d{10}$/; // for 10-digit phone numbers
            return phonePattern.test(phone);
        }

        // Helper function to validate DOB (age >= 18)
        function isValidDOB(dob) {
            const selectedDate = new Date(dob);
            const today = new Date();
            let age = today.getFullYear() - selectedDate.getFullYear();
            const monthDiff = today.getMonth() - selectedDate.getMonth();

            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < selectedDate.getDate())) {
                age--;
            }
            return age >= 18;
        }

        // Real-time validation for email
        nameInput.addEventListener("input", function () {
            if (!isValidName(nameInput.value)) {
                nameError.style.display = 'block';
            } else {
                nameError.style.display = 'none';
            }
        });

        emailInput.addEventListener("input", function () {
            if (!isValidEmail(emailInput.value)) {
                emailError.style.display = "block";
            } else {
                emailError.style.display = "none";
            }
        });

        // Real-time validation for phone
        phoneInput.addEventListener("input", function () {
            if (!isValidPhone(phoneInput.value)) {
                phoneError.style.display = "block";
            } else {
                phoneError.style.display = "none";
            }
        });

        whatsPhoneInput.addEventListener("input", function () {
            if (!isValidPhone(whatsPhoneInput.value)) {
                phoneError1.style.display = "block";
            } else {
                phoneError1.style.display = "none";
            }
        });


        // Real-time validation for DOB
        dobInput.addEventListener("input", function () {
            if (!isValidDOB(dobInput.value)) {
                dobError.style.display = "block";
            } else {
                dobError.style.display = "none";
            }
        });


        // Form validation on submit
        form.addEventListener("submit", function (event) {
            let isFormValid = true;

            const experienceValue = parseFloat(experienceInput.value);
            if (experienceValue < 0 || isNaN(experienceValue)) {
                experienceError.style.display = "block";
                experienceInput.classList.add("is-invalid");
                isFormValid = false;
            } else {
                experienceError.style.display = "none";
                experienceInput.classList.remove("is-invalid");
            }

            const salaryValue = parseFloat(salaryInput.value);
            if (salaryValue <= 0 || isNaN(salaryValue)) {
                salaryError.style.display = "block";
                salaryInput.classList.add("is-invalid");
                isFormValid = false;
            } else {
                salaryError.style.display = "none";
                salaryInput.classList.remove("is-invalid");
            }

            // // Validate fees
            // const feesValue = parseFloat(feesInput.value);
            // if (feesValue <= 0 || isNaN(feesValue)) {
            //     feesError.style.display = "block";
            //     feesInput.classList.add("is-invalid");
            //     isFormValid = false;
            // } else {
            //     feesError.style.display = "none";
            //     feesInput.classList.remove("is-invalid");
            // }

            // // Validate staff commission
            // const staffCommissionValue = parseFloat(staffCommissionInput.value);
            // if (staffCommissionValue <= 0 || staffCommissionValue > 100 || isNaN(staffCommissionValue)) {
            //     staffCommissionError.style.display = "block";
            //     staffCommissionInput.classList.add("is-invalid");
            //     isFormValid = false;
            // } else {
            //     staffCommissionError.style.display = "none";
            //     staffCommissionInput.classList.remove("is-invalid");
            // }

            const employeeValue = parseFloat(employeeInput.value);
			if (employeeValue <= 0 || isNaN(employeeValue)) {
				employeeError.style.display = "block";
				employeeInput.classList.add("is-invalid");
				isFormValid = false;
			} else {
				employeeError.style.display = "none";
				employeeInput.classList.remove("is-invalid");
			}

            if (!isValidName(nameInput.value)) {
                nameError.style.display = "block";
                nameInput.classList.add("is-invalid");
                isFormValid = false;
            } else {
                nameError.style.display = "none";
                nameInput.classList.remove("is-invalid");
            }

            // Email validation on submit
            if (!isValidEmail(emailInput.value)) {
                emailError.style.display = "block";
                emailInput.classList.add("is-invalid");
                isFormValid = false;
            } else {
                emailError.style.display = "none";
                emailInput.classList.remove("is-invalid");
            }

            // Phone validation on submit
            if (!isValidPhone(phoneInput.value)) {
                phoneError.style.display = "block";
                phoneInput.classList.add("is-invalid");
                isFormValid = false;
            } else {
                phoneError.style.display = "none";
                phoneInput.classList.remove("is-invalid");
            }

            // WhatsApp Phone validation on submit
            if (!isValidPhone(whatsPhoneInput.value)) {
                phoneError1.style.display = "block";
                whatsPhoneInput.classList.add("is-invalid");
                isFormValid = false;
            } else {
                phoneError1.style.display = "none";
                whatsPhoneInput.classList.remove("is-invalid");
            }

            // DOB validation on submit
            if (!isValidDOB(dobInput.value)) {
                dobError.style.display = "block";
                dobInput.classList.add("is-invalid");
                isFormValid = false;
            } else {
                dobError.style.display = "none";
                dobInput.classList.remove("is-invalid");
            }

            // Prevent form submission if any field is invalid
            if (!isFormValid) {
                event.preventDefault(); // Stop form from submitting
            }
        });

    });
</script>
@include('CustomSweetAlert');
@endsection