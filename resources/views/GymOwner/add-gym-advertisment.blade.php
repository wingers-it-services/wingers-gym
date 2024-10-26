@extends('GymOwner.master')
@section('title', 'Gym Advertisments')
@section('content')

<!--**********************************
    Content body start
***********************************-->
<!-- Bootstrap CSS -->
{{--
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> --}}
<!-- jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><i class="fas fa-ad"></i> Advertisement</h4>
                    <div class="col-md- text-end">
                        <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal"
                            data-bs-target="#addIndustryModal">Add
                            Advertistment</button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Nav tabs -->
                    <div class="default-tab">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="profile" role="tabpanel">
                                <div class="pt-4">
                                    <div class="card">

                                        <div class="card-body">
                                            <div class="table-responsive recentOrderTable">
                                                <table id="example3" class="table verticle-middle table-responsive-md">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col"> Image</th>
                                                            <th scope="col">Ad. Title</th>
                                                            <th scope="col"> Ad. Link</th>
                                                            <th scope="col">Ad. Type</th>
                                                            <th scope="col">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($advertisments as $advertisment)

                                                            <tr>
                                                                <td> <img class="img-fluid rounded "
                                                                        src="{{$advertisment->banner}}" style="width:50px;"
                                                                        alt=""></td>
                                                                <td>{{$advertisment->ad_title}}</td>
                                                                <td>
                                                                    <a href="{{$advertisment->ad_link}}" target="_blank"
                                                                        rel="noopener noreferrer" data-bs-toggle="tooltip"
                                                                        title="{{$advertisment->ad_link}}">
                                                                        {{ Str::limit($advertisment->ad_link, 30) }}
                                                                    </a>
                                                                </td>
                                                                <td>{{$advertisment->type}}</td>
                                                                <td>
                                                                    <span>
                                                                        <a href="#"
                                                                            onclick="confirmDelete('{{$advertisment->uuid}}')"
                                                                            data-bs-toggle="tooltip" data-placement="top"
                                                                            title="Delete">
                                                                            <i class="fas fa-trash color-danger"></i>
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
                    <!-- Modal -->
                    <div class="modal fade" id="addIndustryModal" tabindex="-1" aria-labelledby="addIndustryModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addIndustryModalLabel">Add Advertisement</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="AdForm" class="needs-validation" method="POST" action="/add-gym-advertisment"
                                        enctype="multipart/form-data" novalidate>
                                        @csrf
                                        <div class="form-group">
                                            <label for="industryName">Advertisement Image</label>
                                            <input type="file" class="form-control" id="banner" name="banner"
                                                accept="image/*" required>
                                            <div class="invalid-feedback">
                                                Advertisement Image is required.
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="industryImage">Advertisement Type</label>
                                            <select class="form-control" id="advertisementType" name="type" required>
                                                <option value="">Select Advertisement Type</option>
                                                <option value="ads">Advertisement</option>
                                                <option value="link_ads">Ad. with Link</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Advertisement Type is required.
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="industryName">Advertisement Title</label>
                                            <input type="text" class="form-control" id="ad_title" name="ad_title"
                                                required>
                                            <div class="invalid-feedback">
                                                Advertisement Title is required.
                                            </div>
                                        </div>
                                        <div class="form-group" id="adLinkField" style="display: none;">
                                            <label for="industryCategory">Advertisement Link</label>
                                            <input type="text" class="form-control" id="ad_link" name="ad_link">
                                            <small id="linkError" style="color:red;display:none;">Please enter a valid
                                                link (https://example.com)</small>
                                            <div class="invalid-feedback">
                                                Advertisement Link is required.
                                            </div>
                                        </div>

                                        <button type="submit" id="saveButton" class="btn btn-primary">Save</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- End of Modal -->
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

<script src="{{ asset('path/to/datatables.min.js') }}"></script>
<script>
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

    document.getElementById('advertisementType').addEventListener('change', function () {
        var adType = this.value;
        var adLinkField = document.getElementById('adLinkField');

        // Show the "Advertisement Link" field only when "Ad. with Link" is selected
        if (adType == 'link_ads') {
            adLinkField.style.display = 'block';
            document.getElementById('ad_link').setAttribute('required', true); // Make the ad link required
        } else {
            adLinkField.style.display = 'none';
            document.getElementById('ad_link').removeAttribute('required'); // Remove required attribute
        }
    });

    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("AdForm");
        var adLink = document.getElementById('ad_link');
        var linkError = document.getElementById('linkError');


        adLink.addEventListener("input", function () {
            if (!isValidLink(adLink.value)) {
                linkError.style.display = "block";
            } else {
                linkError.style.display = "none";
            }
        });

        function isValidLink(link) {
            const urlPattern = /^(https?:\/\/)?([\w-]+(\.[\w-]+)+)([\w.,@?^=%&:\/~+#-]*[\w@?^=%&\/~+#-])?$/;
            return urlPattern.test(link);
        }

        // form.addEventListener("submit", function (event) {
        //     let isFormValid = true;

        //     if (!isValidLink(adLink.value)) {
		// 		linkError.style.display = "block";
		// 		adLink.classList.add("is-invalid");
		// 		isFormValid = false;
		// 	} else {
		// 		linkError.style.display = "none";
		// 		adLink.classList.remove("is-invalid");
		// 	}

        //     // Prevent form submission if any field is invalid
        //     if (!isFormValid) {
        //         event.preventDefault(); // Stop form from submitting
        //     }
        // });

    });

    function confirmDelete(uuid) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Are you sure you want to delete this advertisment?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/delete-advertisment/' + uuid;
            }
        });
    }
</script>
@include('CustomSweetAlert');
@endsection