@extends('GymOwner.master')
@section('title', 'Workout')
@section('content')

<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <h4 class="mb-3">Add Workout</h4>
                                <hr>
                                <form id="addWorkoutForm" method="POST" enctype="multipart/form-data"
                                    class="needs-validation" action="/add-gym-workout" novalidate>
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="image">Workout Image</label>
                                            <input type="file" class="form-control" id="image" name="image"
                                                accept="image/*" required>
                                            <div class="invalid-feedback">
                                                Workout image is required.
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="vedio_link">Video Link</label>
                                            <input type="text" class="form-control" id="vedio_link" name="vedio_link"
                                                placeholder="Enter a valid video link" required>
                                            <small id="videoLinkError" class="form-text text-danger"
                                                style="display: none;">Please enter a valid video link (eg.
                                                https://youtu.be/abcdefghijk)</small>
                                            <div class="invalid-feedback">
                                                video link is required.
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="category">Category</label>
                                            <input type="text" class="form-control" name="category" id="category"
                                                required>
                                            <small id="categoryError" class="text-danger" style="display: none;">Only
                                                letters, spaces, and commas are allowed.</small>

                                            <div class="invalid-feedback">
                                                Category is required.
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="name">Workout Name</label>
                                            <input type="text" class="form-control" id="name" name="name" required>
                                            <small id="workoutError" class="text-danger" style="display: none;">Only
                                                letters, spaces are allowed.</small>
                                            <div class="invalid-feedback">
                                                Workout Name name is required.
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="gender">Gender</label>
                                            <div class="input-group">
                                                <select class="me-sm-2 form-control default-select" id="gender"
                                                    name="gender" required>
                                                    <option value="">Choose...</option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                </select>
                                            </div>
                                            <div class="invalid-feedback">
                                                Please select a gender.
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="gender">User Type</label>
                                            <div class="input-group">
                                                <select class="me-sm-2 form-control default-select" id="user_type"
                                                    name="user_type" required>
                                                    <option value="">Choose...</option>
                                                    <option value="gym">Gym</option>
                                                    <option value="home">Home</option>
                                                </select>

                                            </div>
                                            <div class="invalid-feedback">
                                                Please select a user type.
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="gender">Targetted Boady Part</label>
                                            <div class="input-group">
                                                <select class="me-sm-2 form-control default-select"
                                                    id="targeted_body_part" name="targeted_body_part">
                                                    <option value="">Choose....</option>
                                                    <option value="biceps">Biceps</option>
                                                    <option value="leg">Leg</option>
                                                    <option value="forearm">Forearm</option>
                                                    <option value="tricep">Tricep</option>
                                                    <option value="shoulder">Shoulder</option>
                                                    <option value="chest">Chest</option>
                                                    <option value="abs">Abs</option>
                                                    <option value="back">Back</option>
                                                    <option value="other">Other</option>
                                                </select>
                                            </div>
                                            <div class="invalid-feedback">
                                                Please select a Targetted Body part.
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="description">Description</label>
                                            <textarea type="text" rows="25" class="form-control" id="description"
                                                name="description" required=""></textarea>
                                            <div class="invalid-feedback">
                                                Description is required.
                                            </div>
                                        </div>
                                        <hr class="mb-4">
                                        <button class="btn btn-primary btn-lg btn-block" type="submit">Add
                                            Workout</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3">Workout List</h4>
                <hr>
                <div class="table-responsive">
                    <table id="example3" class="table table-bordered table-striped verticle-middle table-responsive-sm">
                        <thead>
                            <tr>
                                <th scope="col">Image</th>
                                <th scope="col">Category</th>
                                <th scope="col">Workout Name</th>
                                <th scope="col">Gender</th>
                                <th scope="col" class="text-end">View</th>
                                <th scope="col" class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($workouts as $workout)
                            <tr>
                                <td>
                                    <img width="80"
                                        src="{{ $workout->image ? asset($workout->image) : asset('images/profile/17.jpg') }}"
                                        loading="lazy" alt="Profile Image">
                                </td>
                                <td>{{$workout->category }}</td>
                                <td>{{$workout->name }}</td>
                                <td>{{$workout->gender }}</td>
                                <td>
                                    <a class="dropdown-item view-workout" href="javascript:void(0);"
                                        data-bs-toggle="modal" data-bs-target="#viewModal"
                                        data-workout="{{ json_encode($workout) }}">
                                        <i class="fa fa-eye color-muted"></i>
                                    </a>
                                </td>

                                <td class="text-end">
                                    @if($workout->is_editable)
                                    <span> <a href="javascript:void(0);" class="me-4 edit-workout"
                                            data-bs-toggle="tooltip" data-placement="top" title="Edit"
                                            data-workout="{{ json_encode($workout) }}">
                                            <i class="fa fa-pencil color-muted"></i></a>
                                        <a onclick="confirmDelete('{{ $workout->uuid }}')" data-bs-toggle="tooltip"
                                            data-placement="top" title="Close"><i class="fas fa-trash"></i></a></span>
                                    @else
                                    <span class="text-muted">Not Editable</span>
                                    @endif
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
<div class="modal fade" id="editDietModal" tabindex="-1" role="dialog" aria-labelledby="editDietModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Workout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editDietForm" class="needs-validation" method="POST" action="update-workout"
                    enctype="multipart/form-data" novalidate>
                    @csrf
                    <input type="hidden" id="edit_workout_id" name="workout_id">
                    <div class="form-group text-center">
                        <label for="current_image">Current Workout Image</label>
                        <img id="current_image" src="" alt="Workout Image" class="img-fluid mb-3" style="width: 70%;">
                    </div>

                    <div class="form-group">
                        <label for="edit_image">Upload New Workout Image</label>
                        <input type="file" class="form-control" id="edit_image" name="image" accept="image/*">
                    </div>

                    <div class="form-group">
                        <label for="vedio_link">Video Link</label>
                        <input type="text" class="form-control" id="edit_vedio_link" name="vedio_link" placeholder="">
                        <small id="editVideoLinkError" class="form-text text-danger" style="display: none;">Please enter a
                            valid video link (eg.
                            https://youtu.be/abcdefghijk)</small>
                        <div class="invalid-feedback">
                            video link is required.
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="category">Category</label>
                        <input type="text" class="form-control" name="category" id="edit_category" required>
                        <small id="editCategoryError" class="text-danger" style="display: none;">Only
                            letters, spaces, and commas are allowed.</small>

                        <div class="invalid-feedback">
                            Category is required.
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="name">Workout Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required="">
                        <small id="editWorkoutError" class="text-danger" style="display: none;">Only
                            letters, spaces are allowed.</small>
                        <div class="invalid-feedback">
                            Workout Name name is required.
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <div class="input-group">
                            <select class="me-sm-2 form-control" id="edit_gender" name="gender">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a gender.
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="gender">Targetted Boady Part</label>
                        <div class="input-group">
                            <select class="me-sm-2 form-control" id="edit_targeted_body_part" name="targeted_body_part">
                                <option value="">Choose....</option>
                                <option value="biceps">Biceps</option>
                                <option value="leg">Leg</option>
                                <option value="forearm">Forearm</option>
                                <option value="tricep">Tricep</option>
                                <option value="shoulder">Shoulder</option>
                                <option value="chest">Chest</option>
                                <option value="abs">Abs</option>
                                <option value="back">Back</option>
                                <option value="other">Other</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a Targetted Body part.
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea type="text" class="form-control" rows="4" id="edit_description" name="description"
                            required=""></textarea>
                        <div class="invalid-feedback">
                            Description is required.
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal Structure -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Workout Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex">
                <div class="w-50 pe-2">
                    <!-- Image -->
                    <img id="modalImage" src="" alt="Workout Image" class="img-fluid">
                </div>
                <div class="w-50 ps-2">
                    <!-- Video or Iframe -->
                    <div id="videoContainer">
                        <!-- Video -->
                        <video id="modalVideo" controls class="w-100" style="display: none;">
                            <source id="modalVideoSource" src="" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        <!-- Iframe -->
                        <iframe id="modalIframe" class="w-100" height="315" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <p id="modalDetails" class="w-100 mt-3"></p>
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

    document.addEventListener('DOMContentLoaded', function() {
        function initializeEventListeners() {
            const editButtons = document.querySelectorAll('.edit-workout');
            const editImageInput = document.getElementById('edit_image');
            const currentImage = document.getElementById('current_image');
            const editGenderSelect = document.getElementById('edit_gender');
            const editTargettedBoadySelect = document.getElementById('edit_targeted_body_part');

            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const workout = JSON.parse(this.getAttribute('data-workout'));

                    document.getElementById('edit_workout_id').value = workout.id;
                    document.getElementById('edit_vedio_link').value = workout.vedio_link;
                    currentImage.src = workout.image; // Set the src of the image element
                    document.getElementById('edit_name').value = workout.name;
                    document.getElementById('edit_category').value = workout.category;
                    document.getElementById('edit_description').value = workout.description;

                    // Set the selected option for the gender dropdown
                    editGenderSelect.value = workout.gender;
                    editTargettedBoadySelect.value = workout.targeted_body_part;

                    // Force re-render of the select element
                    const parent = editGenderSelect.parentElement;
                    const placeholder = document.createElement('div');
                    parent.replaceChild(placeholder, editGenderSelect);
                    parent.replaceChild(editGenderSelect, placeholder);

                    new bootstrap.Modal(document.getElementById('editDietModal')).show();
                });
            });

            // Show a preview of the new image when selected
            if (editImageInput) {
                editImageInput.addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            currentImage.src = e.target.result;
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }

            // Handling view workout modal
            document.querySelectorAll('.view-workout').forEach(button => {
                button.addEventListener('click', function() {
                    const workout = JSON.parse(this.getAttribute('data-workout'));

                    // Set the image src
                    document.getElementById('modalImage').src = workout.image ? workout.image : 'images/profile/17.jpg';

                    // Handle video or iframe
                    const videoContainer = document.getElementById('videoContainer');
                    const modalVideo = document.getElementById('modalVideo');
                    const modalIframe = document.getElementById('modalIframe');
                    const videoSource = document.getElementById('modalVideoSource');

                    // Clear previous video sources
                    modalVideo.style.display = 'none';
                    modalIframe.style.display = 'none';

                    // Check if it's an embedded video or a direct video file
                    if (workout.vedio_link.includes('youtube.com') || workout.vedio_link.includes('vimeo.com')) {
                        // Embed video (e.g., YouTube or Vimeo)
                        modalIframe.src = workout.vedio_link;
                        modalIframe.style.display = 'block';
                    } else {
                        // Direct video file
                        videoSource.src = workout.vedio_link;
                        modalVideo.style.display = 'block';
                        modalVideo.load();
                    }

                    // Set workout details
                    const details = `
                    <strong>Category:</strong> ${workout.category}<br>
                    <strong>Workout Name:</strong> ${workout.name}<br>
                    <strong>Gender:</strong> ${workout.gender}<br>
                    <strong>Description:</strong> ${workout.description}
                `;
                    document.getElementById('modalDetails').innerHTML = details;

                    // Show modal
                    new bootstrap.Modal(document.getElementById('viewModal')).show();
                });
            });
        }

        // Initial call to set up event listeners
        initializeEventListeners();

        // Reinitialize event listeners after DataTable redraw
        $('#example3').on('draw.dt', function() {
            initializeEventListeners(); // Reattach event listeners
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

    document.addEventListener('DOMContentLoaded', function() {
        const viewModal = document.getElementById('viewModal');
        const modal = new bootstrap.Modal(viewModal);

        // Handle the close event to ensure the fade backdrop is removed
        viewModal.addEventListener('hidden.bs.modal', function() {
            document.body.classList.remove('modal-open'); // Ensure body class is removed
            document.body.style.overflow = ''; // Reset body overflow style

            // Remove modal backdrops
            const modalBackdrops = document.querySelectorAll('.modal-backdrop');
            modalBackdrops.forEach(function(backdrop) {
                backdrop.remove(); // Remove the backdrop element
            });
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("addWorkoutForm");

        const vedioInput = document.getElementById("vedio_link");

        const vedioError = document.getElementById("videoLinkError");

        const categoryInput = document.getElementById("category");
        const categoryError = document.getElementById("categoryError");

        const workoutInput = document.getElementById("name");
        const workoutError = document.getElementById("workoutError");

        // Helper function to validate phone format
        function isVedioLink(video) {
            const urlPattern = /^(https?:\/\/)?(www\.)?(youtube\.com\/(embed\/|watch\?v=)|youtu\.be\/|vimeo\.com\/).+$/;
            return urlPattern.test(video);
        }

        // Helper function to validate phone format
        function isCategoryValid(category) {
            const lettersAndCommasPattern = /^[A-Za-z\s,]+$/;
            return lettersAndCommasPattern.test(category);
        }

        // Helper function to validate phone format
        function isWorkoutValid(workout) {
            const lettersAndCommasPattern = /^[A-Za-z\s]+$/;
            return lettersAndCommasPattern.test(workout);
        }


        // Real-time validation for phone
        vedioInput.addEventListener("input", function () {
            if (!isVedioLink(vedioInput.value)) {
                vedioError.style.display = "block";
            } else {
                vedioError.style.display = "none";
            }
        });

        // Real-time validation for category
        categoryInput.addEventListener("input", function () {
            if (!isCategoryValid(categoryInput.value)) {
                categoryError.style.display = "block";
            } else {
                categoryError.style.display = "none";
            }
        });

        workoutInput.addEventListener("input", function () {
            if (!isWorkoutValid(workoutInput.value)) {
                workoutError.style.display = "block";
            } else {
                workoutError.style.display = "none";
            }
        });

        // Form validation on submit
        form.addEventListener("submit", function (event) {
            let isFormValid = true;

            // Video link validation on submit
            if (!isVedioLink(vedioInput.value)) {
                vedioError.style.display = "block";
                vedioInput.classList.add("is-invalid");
                isFormValid = false;
            } else {
                vedioError.style.display = "none";
                vedioInput.classList.remove("is-invalid");
            }

            if (!isCategoryValid(categoryInput.value)) {
                categoryError.style.display = "block";
                categoryInput.classList.add("is-invalid");
                isFormValid = false;
            } else {
                categoryError.style.display = "none";
                categoryInput.classList.remove("is-invalid");
            }

            if (!isWorkoutValid(workoutInput.value)) {
                workoutError.style.display = "block";
                workoutInput.classList.add("is-invalid");
                isFormValid = false;
            } else {
                workoutError.style.display = "none";
                workoutInput.classList.remove("is-invalid");
            }

            // Prevent form submission if any field is invalid
            if (!isFormValid) {
                event.preventDefault(); // Stop form from submitting
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("editDietForm");

        const editVedioInput = document.getElementById("edit_vedio_link");

        const editVideoLinkError = document.getElementById("editVideoLinkError");

        const editCategoryInput = document.getElementById("edit_category");
        const editCategoryError = document.getElementById("editCategoryError");

        const editWorkoutInput = document.getElementById("edit_name");
        const editWorkoutError = document.getElementById("editWorkoutError");

        // Helper function to validate phone format
        function isVedioLink(video) {
            const urlPattern = /^(https?:\/\/)?(www\.)?(youtube\.com\/(embed\/|watch\?v=)|youtu\.be\/|vimeo\.com\/).+$/;
            return urlPattern.test(video);
        }

        // Helper function to validate phone format
        function isCategoryValid(category) {
            const lettersAndCommasPattern = /^[A-Za-z\s,]+$/;
            return lettersAndCommasPattern.test(category);
        }

        // Helper function to validate phone format
        function isWorkoutValid(workout) {
            const lettersAndCommasPattern = /^[A-Za-z\s]+$/;
            return lettersAndCommasPattern.test(workout);
        }


        // Real-time validation for phone
        editVedioInput.addEventListener("input", function () {
            if (!isVedioLink(editVedioInput.value)) {
                editVideoLinkError.style.display = "block";
            } else {
                editVideoLinkError.style.display = "none";
            }
        });

        // Real-time validation for category
        editCategoryInput.addEventListener("input", function () {
            if (!isCategoryValid(editCategoryInput.value)) {
                editCategoryError.style.display = "block";
            } else {
                editCategoryError.style.display = "none";
            }
        });

        editWorkoutInput.addEventListener("input", function () {
            if (!isWorkoutValid(editWorkoutInput.value)) {
                editWorkoutError.style.display = "block";
            } else {
                editWorkoutError.style.display = "none";
            }
        });

        // Form validation on submit
        form.addEventListener("submit", function (event) {
            let isFormValid = true;

            // Video link validation on submit
            if (!isVedioLink(editVedioInput.value)) {
                editVideoLinkError.style.display = "block";
                editVedioInput.classList.add("is-invalid");
                isFormValid = false;
            } else {
                editVideoLinkError.style.display = "none";
                editVedioInput.classList.remove("is-invalid");
            }

            if (!isCategoryValid(editCategoryInput.value)) {
                editCategoryError.style.display = "block";
                editCategoryInput.classList.add("is-invalid");
                isFormValid = false;
            } else {
                editCategoryError.style.display = "none";
                editCategoryInput.classList.remove("is-invalid");
            }

            if (!isWorkoutValid(editWorkoutInput.value)) {
                editWorkoutError.style.display = "block";
                editWorkoutInput.classList.add("is-invalid");
                isFormValid = false;
            } else {
                editWorkoutError.style.display = "none";
                editWorkoutInput.classList.remove("is-invalid");
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