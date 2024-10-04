@extends('GymOwner.master')
@section('title', 'Maintenance Vendor')
@section('content')

<!--**********************************
            Content body start
***********************************-->
<div class="modal fade" id="editVendor">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Vendor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <form id="editVendorForm" class="needs-validation" method="POST" action="{{route('updateMaintenanceVendor')}}"
                    enctype="multipart/form-data" novalidate>
                    @csrf
                    <input type="hidden" name="uuid" id="editVendId">
                    <div class="form-group">
                        <label>Vendor Image</label>
                        <input type="file" id="editImage" name="image" class="form-control">
                        <div class="invalid-feedback">
                            Vendor Image is required.
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Vendor Full Name</label>
                        <input type="text" id="editName" name="name" class="form-control" required>
                        <small id="editNameError" class="text-danger" style="display: none;">Only
                            Letters are allowed.</small>
                        <div class="invalid-feedback">
                            Full Name is required.
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Phone No</label>
                        <input type="text" name="phone_no" id="editPhone" class="form-control" required>
                        <small id="editPhoneError" class="text-danger" style="display: none;">Please
                            enter a valid phone
                            number.</small>
                        <div class="invalid-feedback">
                            Phone No is required.
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Occupation</label>
                        <input type="text" name="occupation" id="editOccupation" class="form-control" required />
                        <small id="editOccupationError" class="text-danger" style="display: none;">Only
                            Letters are allowed.</small>
                        <div class="invalid-feedback">
                            Occupation is required.
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <textarea type="text" rows="10" name="address" id="editAddress" class="form-control"
                            required></textarea>
                        <div class="invalid-feedback">
                            Address is required.
                        </div>
                    </div>
                    <button class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>

</div>
<div class="content-body ">
    <!-- row -->
    <div class="container-fluid">
        <div class="row">
            <!-- Modal -->
            <div class="modal fade" id="addNewPlan">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add New Vendor</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="vendorForm" class="needs-validation" method="POST"
                                action="{{ route('addMaintenanceVendor') }}" enctype="multipart/form-data" novalidate>
                                @csrf
                                <div class="form-group">
                                    <label>Vendor Image</label>
                                    <input type="file" id="image" name="image" class="form-control" accept="image/*">
                                    <div class="invalid-feedback">
                                        Vendor Image is required.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Vendor Full Name</label>
                                    <input type="text" id="name" name="name" class="form-control" required>
                                    <small id="nameError" class="text-danger" style="display: none;">Only
                                        Letters are allowed.</small>
                                    <div class="invalid-feedback">
                                        Full Name is required.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Phone No</label>
                                    <input type="number" id="phone_no" name="phone_no" class="form-control" required>
                                    <small id="phoneError" class="text-danger" style="display: none;">Please
                                        enter a valid phone
                                        number.</small>
                                    <div class="invalid-feedback">
                                        Phone No is required.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Occupation</label>
                                    <input type="text" id="occupation" name="occupation" class="form-control"
                                        required />
                                    <small id="occupationError" class="text-danger" style="display: none;">Only
                                        Letters are allowed.</small>
                                    <div class="invalid-feedback">
                                        Occupation is required.
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Address</label>
                                    <textarea type="text" rows="10" name="address" class="form-control"
                                        required></textarea>
                                    <div class="invalid-feedback">
                                        Address is required.
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
                                    <h4 class="text-black fs-20">Maintenance Vendor List</h4>
                                </div>

                                <div class="dropdown mt-sm-0 mt-3">
                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addNewPlan"
                                        class="btn btn-outline-primary rounded">Add New Vendor</a>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example3"
                                        class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                        <thead>
                                            <tr>
                                                <th scope="col">Image</th>
                                                <th scope="col">Full Name</th>
                                                <th scope="col">Phone No</th>
                                                <th scope="col">Occupation</th>
                                                <th scope="col" class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($vendors as $vendor)
                                                <tr>
                                                    <td>
                                                        <a href="#">
                                                            <div class="media d-flex align-items-center">
                                                                <div class="avatar avatar-xl me-2">
                                                                    <div class=""><img class="rounded-circle img-fluid"
                                                                            src="{{ $vendor->image }}"
                                                                            style="height: 50px;width: 50px;" alt="image">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td>{{ $vendor->name}}</td>
                                                    <td>{{ $vendor->phone_no }}</td>
                                                    <td>{{ $vendor->occupation}}</td>
                                                    <td class="text-end">
                                                        <span>
                                                            <a href="javascript:void(0);" class="me-4 edit-vendor-button"
                                                                data-bs-toggle="modal" data-bs-target="#editVendor"
                                                                data-vendor='@json($vendor)'>
                                                                <i class="fa fa-pencil color-muted"></i>
                                                            </a>
                                                            <a onclick="confirmDelete('{{ $vendor->uuid }}')"
                                                                data-bs-toggle="tooltip" data-placement="top" title="Close">
                                                                <i class="fas fa-trash"></i>
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
    </div>
</div>

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
        var editButtons = document.querySelectorAll('.edit-vendor-button');

        editButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var vendor = JSON.parse(this.dataset.vendor);

                document.getElementById('editVendId').value = vendor.uuid;
                document.getElementById('editName').value = vendor.name;
                document.getElementById('editOccupation').value = vendor.occupation;
                document.getElementById('editPhone').value = vendor.phone_no;
                document.getElementById('editAddress').value = vendor.address;
            });
        });

        const deleteButtons = document.querySelectorAll('.btn-delete');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const uuid = this.getAttribute('data-uuid');
                if (confirm('Are you sure you want to delete this vendor?')) {
                    document.getElementById('delete-form-' + uuid).submit();
                }
            });
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("vendorForm");

        const phoneInput = document.getElementById("phone_no");
        const nameInput = document.getElementById("name");
        const occupationInput = document.getElementById("occupation");



        const phoneError = document.getElementById("phoneError");
        const nameError = document.getElementById("nameError");
        const occupationError = document.getElementById("occupationError");



        // Helper function to validate phone format
        function isValidPhone(phone) {
            const phonePattern = /^\d{10}$/; // for 10-digit phone numbers
            return phonePattern.test(phone);
        }

        function isValidName(fullname) {
            const namePattern = /^[A-Za-z\s]+$/;
            return namePattern.test(fullname);
        }

        // Real-time validation for phone
        phoneInput.addEventListener("input", function () {
            if (!isValidPhone(phoneInput.value)) {
                phoneError.style.display = "block";
            } else {
                phoneError.style.display = "none";
            }
        });

        nameInput.addEventListener("input", function () {
            if (!isValidName(nameInput.value)) {
                nameError.style.display = 'block';
            } else {
                nameError.style.display = 'none';
            }
        });

        occupationInput.addEventListener("input", function () {
            if (!isValidName(occupationInput.value)) {
                occupationError.style.display = 'block';
            } else {
                occupationError.style.display = 'none';
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

            if (!isValidName(nameInput.value)) {
                nameError.style.display = "block";
                nameInput.classList.add("is-invalid");
                isFormValid = false;
            } else {
                nameError.style.display = "none";
                nameInput.classList.remove("is-invalid");
            }

            if (!isValidName(occupationInput.value)) {
                occupationError.style.display = "block";
                occupationInput.classList.add("is-invalid");
                isFormValid = false;
            } else {
                occupationError.style.display = "none";
                occupationInput.classList.remove("is-invalid");
            }

            // Prevent form submission if any field is invalid
			if (!isFormValid) {
				event.preventDefault(); // Stop form from submitting
			}
        });

    });

    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("editVendorForm");

        const editPhoneInput = document.getElementById("editPhone");
        const editNameInput = document.getElementById("editName");
        const editOccupationInput = document.getElementById("editOccupation");

        const editPhoneError = document.getElementById("editPhoneError");
        const editNameError = document.getElementById("editNameError");
        const editOccupationError = document.getElementById("editOccupationError");

        // Helper function to validate phone format
        function isValidPhone(phone) {
            const phonePattern = /^\d{10}$/; // for 10-digit phone numbers
            return phonePattern.test(phone);
        }

        function isValidName(fullname) {
            const namePattern = /^[A-Za-z\s]+$/;
            return namePattern.test(fullname);
        }


        editPhoneInput.addEventListener("input", function () {
            if (!isValidPhone(editPhoneInput.value)) {
                editPhoneError.style.display = "block";
            } else {
                editPhoneError.style.display = "none";
            }
        });

        editNameInput.addEventListener("input", function () {
            if (!isValidName(editNameInput.value)) {
                editNameError.style.display = 'block';
            } else {
                editNameError.style.display = 'none';
            }
        });

        editOccupationInput.addEventListener("input", function () {
            if (!isValidName(editOccupationInput.value)) {
                editOccupationError.style.display = 'block';
            } else {
                editOccupationError.style.display = 'none';
            }
        });

        // Form validation on submit
        form.addEventListener("submit", function (event) {
            let isFormValid = true;

            // Phone validation on submit
            if (!isValidPhone(editPhoneInput.value)) {
                editPhoneError.style.display = "block";
                editPhoneInput.classList.add("is-invalid");
                isFormValid = false;
            } else {
                editPhoneError.style.display = "none";
                editPhoneInput.classList.remove("is-invalid");
            }

            if (!isValidName(editNameInput.value)) {
                editNameError.style.display = "block";
                editNameInput.classList.add("is-invalid");
                isFormValid = false;
            } else {
                editNameError.style.display = "none";
                editNameInput.classList.remove("is-invalid");
            }

            if (!isValidName(editOccupationInput.value)) {
                editOccupationError.style.display = "block";
                editOccupationInput.classList.add("is-invalid");
                isFormValid = false;
            } else {
                editOccupationError.style.display = "none";
                editOccupationInput.classList.remove("is-invalid");
            }

            // Prevent form submission if any field is invalid
			if (!isFormValid) {
				event.preventDefault(); // Stop form from submitting
			}

        });

    });


    function confirmDelete(uuid) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Are you sure you want to delete this vendor?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/delete-vendor/' + uuid;
            }
        });
    }
</script>
@include('CustomSweetAlert');
@endsection