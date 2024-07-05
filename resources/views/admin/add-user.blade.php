@extends('admin.master')
@section('title', 'Dashboard')
@section('content')



    <style>
        .existing-image,
        #imagePreview img {
            max-width: 200px;
            /* Adjust this value as needed */
            max-height: 200px;
            /* Adjust this value as needed */
            width: auto;
            height: auto;
        }
    </style>
    <div class="content-body ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <form class="needs-validation" action="" method="POST"
                        enctype="multipart/form-data" novalidate>
                        @csrf

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">User Account Details</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-validation">
                                    <div class="row">
                                        <div class="col-xl-9">
                                            <div class="mb-3 row">
                                                <label class="col-lg-4 col-form-label" for="validationCustom01">Profile
                                                    Image
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-lg-8">
                                                    <input type="file" class="form-control" id="validationCustom01"
                                                        placeholder="Enter a username.." accept="image/*" name="image"
                                                        onchange="previewImage(event)">
                                                    <div class="invalid-feedback">
                                                        Please enter a username.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-lg-4 col-form-label" for="validationCustom02">Email
                                                    (unique)<span class="text-danger">*</span>
                                                </label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="validationCustom02"
                                                        name="email" placeholder="Your valid email.." required>
                                                    <div class="invalid-feedback">
                                                        Please enter a Email.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-lg-4 col-form-label" for="validationCustom03">Password
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-lg-8">
                                                    <input type="password" class="form-control" id="validationCustom03"
                                                        name="password" placeholder="Choose a safe one.." required>
                                                    <div class="invalid-feedback">
                                                        Please enter a password.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3" id="imagePreview">
                                            <img width="80"
                                                src="https://cdn.prod.website-files.com/62d84e447b4f9e7263d31e94/6557420216a456cfaef685c0_6399a4d27711a5ad2c9bf5cd_ben-sweet-2LowviVHZ-E-unsplash-1-p-1080.jpg"
                                                style="border-radius: 45px;width: -webkit-fill-available;" loading="lazy"
                                                alt="image">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">User Info</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-validation">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="mb-3 row">
                                                <label class="col-lg-4 col-form-label" for="validationCustom01">Name
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form-control" id="validationCustom01"
                                                        name="name" placeholder="Enter a name.." required>
                                                    <div class="invalid-feedback">
                                                        Please enter a name.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-lg-4 col-form-label" for="validationCustom03">Gender
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-lg-6">
                                                    <select class="default-select wide form-control" id="validationCustom05"
                                                        name="gender">
                                                        <option data-display="Select">Please select</option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Please enter a password.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-lg-4 col-form-label" for="validationCustom08">Phone
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form-control" id="validationCustom08"
                                                        name="phone" placeholder="212-999-0000" required>
                                                    <div class="invalid-feedback">
                                                        Please enter a phone no.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-lg-4 col-form-label" for="validationCustom07">Website
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form-control" id="validationCustom07"
                                                        name="website" placeholder="http://example.com" required>
                                                    <div class="invalid-feedback">
                                                        Please enter a url.
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="mb-3 row">
                                                <label class="col-lg-4 col-form-label" for="validationCustom04">Suggestions
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-lg-6">
                                                    <textarea class="form-control" id="validationCustom04" rows="5" placeholder="What would you like to see?"
                                                        required></textarea>
                                                    <div class="invalid-feedback">
                                                        Please enter a Suggestions.
                                                    </div>
                                                </div>
                                            </div> --}}
                                        </div>
                                        <div class="col-xl-6">
                                            {{-- <div class="mb-3 row">
                                                <label class="col-lg-4 col-form-label" for="validationCustom05">Payment Status</label>
                                                <div class="col-lg-6">
                                                    <select class="default-select wide form-control"
                                                        id="validationCustom05">
                                                        <option data-display="Select">Please select</option>
                                                        <option value="pending">Pending</option>
                                                        <option value="paid">Paid</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Please select a one.
                                                    </div>
                                                </div>
                                            </div> --}}
                                            <div class="mb-3 row">

                                                <div class="mb-3 row">
                                                    <label class="col-lg-4 col-form-label"
                                                        for="validationCustom01">Company Name
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-6">
                                                        <input type="text" class="form-control"
                                                            id="validationCustom01" name="company_name"
                                                            placeholder="Enter a Company Name.." required>
                                                        <div class="invalid-feedback">
                                                            Please enter a username.
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-lg-4 col-form-label"
                                                        for="validationCustom01">Company Address
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-6">
                                                        <input type="text" class="form-control"
                                                            id="validationCustom01" name="company_address"
                                                            placeholder="Enter a Company Address.." required>
                                                        <div class="invalid-feedback">
                                                            Please enter a username.
                                                        </div>
                                                    </div>

                                                </div>
                                                <label class="col-lg-4 col-form-label" for="validationCustom05">No of
                                                    Device
                                                    Allowed </label>
                                                <div class="col-lg-6">
                                                    <select class="default-select wide form-control"
                                                        id="validationCustom05" name="no_of_device">
                                                        <option data-display="Select">Please select</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                        <option value="10">10</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Please select a one.
                                                    </div>
                                                </div>
                                            </div>




                                            <div class="mb-3 row">
                                                <label class="col-lg-4 col-form-label"><a href="javascript:void(0);">Terms
                                                        &amp; Conditions</a> <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-lg-8">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            id="validationCustom12" required>
                                                        <label class="form-check-label" for="validationCustom12">
                                                            Agree to terms and conditions
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-xl-12">
                                            <div class="col-lg-12 ms-auto">
                                                <button type="submit" style=" width: -webkit-fill-available; "
                                                    class=" btn btn-primary">Submit</button>
                                            </div>
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
    <script>
        function previewImage(event) {
            const imagePreview = document.getElementById('imagePreview');
            const file = event.target.files[0];

            // Check if a file is selected
            if (file) {
                const reader = new FileReader();

                // FileReader onload event
                reader.onload = function() {
                    // Create an image element
                    const imgElement = document.createElement('img');
                    imgElement.src = reader.result;
                    imgElement.classList.add('max-w-full', 'h-auto');

                    // Clear previous image preview, if any
                    imagePreview.innerHTML = '';

                    // Append the image preview to the imagePreview div
                    imagePreview.appendChild(imgElement);

                    // Show the image preview div
                    imagePreview.classList.remove('hidden');
                }

                // Read the image file as a data URL
                reader.readAsDataURL(file);
            } else {
                // Hide the image preview if no file is selected
                imagePreview.innerHTML = '';
                imagePreview.classList.add('hidden');
            }
        }
    </script>
    <!--****
                                                Content body end
                                            *****-->

    {{-- <script>
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
    </script> --}}

@endsection
