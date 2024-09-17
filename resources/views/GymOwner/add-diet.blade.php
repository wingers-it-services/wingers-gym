@extends('GymOwner.master')
@section('title', 'Dashboard')
@section('content')
<style>
    .data-grid {
        display: grid;
        grid-template-columns: repeat(2, 5fr);
        gap: 10px;
        /* Adjust the gap between items */
    }

    .item {
        /* Additional styling for each item if needed */
    }
</style>
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Add Diet</a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <h4 class="mb-3">Add Diet</h4>
                                <form name="myForm" method="POST" enctype="multipart/form-data" action="/add-gym-diet" class="needs-validation" novalidate>
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="image">Diet Image</label>
                                            <input type="file" class="form-control" id="image" name="image" required>
                                            <div class="invalid-feedback">
                                                Diet image is required.
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="name">Diet Name</label>
                                            <input type="text" class="form-control" id="name" name="name" required>
                                            <div class="invalid-feedback">
                                                Diet name is required.
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="calories">Calories (in kcals)</label>
                                            <input type="number" class="form-control" id="calories" name="calories"
                                                required>
                                            <div class="invalid-feedback">
                                                Calories quantity is required.
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="protein">Protein (in grams)</label>
                                            <input type="number" class="form-control" id="protein" name="protein"
                                                required>
                                            <div class="invalid-feedback">
                                                Protein name is required.
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="carbs">Carbs (in grams) </label>
                                            <input type="number" class="form-control" id="carbs" name="carbs" required>
                                            <div class="invalid-feedback">
                                                Carbs quantity is required.
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="fats">Fats (in grams)</label>
                                            <input type="number" class="form-control" id="fats" name="fats" required>
                                            <div class="invalid-feedback">
                                                Fats quantity is required.
                                            </div>
                                        </div>

                                        <div class="col-md-3 mb-3">
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
                                                Choose a gender.
                                            </div>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label for="goal">Goal </label>
                                            <div class="input-group">
                                                <select class="me-sm-2 form-control default-select" id="goal"
                                                    name="goal" required>
                                                    <option value="">Choose...</option>
                                                    <option value="Weight Gain">Weight Gain</option>
                                                    <option value="Fit">Fit</option>
                                                    <option value="Weight Loss">Weight Loss</option>
                                                </select>
                                            </div>
                                            <div class="invalid-feedback">
                                                Choose a Goal.
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="meal_type">Meal Type </label>
                                            <div class="input-group">
                                                <select class="me-sm-2 form-control default-select" id="meal_type"
                                                    name="meal_type" required>
                                                    <option value="">Choose...</option>
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
                                            <div class="invalid-feedback">
                                                Choose a Meal Type.
                                            </div>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label for="min_age">Min Age </label>
                                            <input type="number" class="form-control" id="min_age" name="min_age"
                                                placeholder="" required>
                                            <div class="invalid-feedback">
                                                Min Age is required.
                                            </div>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label for="max_age">Max Age </label>
                                            <input type="number" class="form-control" id="max_age" name="max_age"
                                                placeholder="" required>
                                            <div class="invalid-feedback">
                                                Max Age is required.
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="diet">Diet Description</label>
                                            <textarea type="text" class="form-control" id="diet" name="diet" rows="5"
                                                placeholder="" required></textarea>
                                            <div class="invalid-feedback">
                                                Diet Description is required.
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="alternative_diet">Alternative Diet </label>
                                            <textarea type="text" class="form-control" id="alternative_diet"
                                                name="alternative_diet" rows="5" placeholder=""></textarea>
                                        </div>
                                        <hr class="mb-4">
                                        <button class="btn btn-primary btn-lg btn-block" type="submit">Add Diet</button>
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
                <h4 class="mb-3">Diet List</h4>
                <hr>
                <div class="table-responsive">
                    <table id="example3" class="table table-bordered table-striped verticle-middle table-responsive-sm">
                        <thead>
                            <tr>
                                <th scope="col">Image</th>
                                <th scope="col">Name</th>
                                <th scope="col">Gender</th>
                                <th scope="col">Goal</th>
                                <th scope="col">Max-Min Age</th>
                                <th scope="col" class="text-end">View</th>
                                <th scope="col" class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($diets as $subscription)
                                <tr>
                                    <td>
                                        <img width="80"
                                            src="{{ $subscription->image ? asset($subscription->image) : asset('images/profile/17.jpg') }}"
                                            loading="lazy" alt="Profile Image">
                                    </td>
                                    <td>{{$subscription->name }}</td>
                                    <td>{{$subscription->gender }}</td>
                                    <td>{{$subscription->goal }}</td>
                                    <td>{{$subscription->min_age }} - {{ $subscription->max_age }}</td>
                                    <td class="text-end">
                                        <a class="dropdown-item view-workout" href="javascript:void(0);"
                                            data-bs-toggle="modal" data-bs-target="#d"
                                            data-workout="{{ json_encode($subscription) }}">
                                            <i class="fa fa-eye color-muted"></i>
                                        </a>
                                    </td>
                                    <td class="text-end">
                                        <span><a href="javascript:void(0);" class="me-4 edit-book-button"
                                                data-bs-toggle="modal" data-bs-target="#editSuscription"
                                                data-book='@json($subscription)'><i class="fa fa-pencil color-muted"></i>
                                            </a>
                                            <a onclick="confirmDelete('{{ $subscription->uuid }}')" data-bs-toggle="tooltip"
                                                data-placement="top" title="Close"><i class="fas fa-trash"></i></a></span>
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
                <h5 class="modal-title" id="editDietModalLabel">Edit Diet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editDietForm" method="POST" enctype="multipart/form-data" action="/update-gym-diet">
                    @csrf
                    <input type="hidden" id="edit_diet_id" name="diet_id">

                    <div class="form-group text-center">
                        <label for="current_image">Current Diet Image</label>
                        <img id="current_image" src="" alt="Diet Image" class="img-fluid mb-3" style="width: 70%;">
                    </div>

                    <div class="form-group">
                        <label for="edit_image">Upload New Diet Image</label>
                        <input type="file" class="form-control" id="edit_image" name="image" accept="image/*">
                    </div>

                    <div class="form-group">
                        <label for="edit_name">Diet Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="edit_calories">Calories</label>
                                <input type="number" class="form-control" id="edit_calories" name="calories" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="edit_protein">Protein</label>
                                <input type="number" class="form-control" id="edit_protein" name="protein" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="edit_carbs">Carbs</label>
                                <input type="number" class="form-control" id="edit_carbs" name="carbs" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="edit_fats">Fats</label>
                                <input type="number" class="form-control" id="edit_fats" name="fats" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="edit_gender">Gender</label>
                                <select class="form-control" id="edit_gender" name="gender" required>
                                    <option value="">Choose...</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_meal">Meal Type</label>
                                <select class="form-control" id="edit_meal" name="meal_type" required>
                                    <option value="">Choose...</option>
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
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="edit_min_age">Min Age</label>
                                <input type="number" class="form-control" id="edit_min_age" name="min_age" required>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_max_age">Max Age</label>
                                <input type="number" class="form-control" id="edit_max_age" name="max_age" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="edit_goal">Goal</label>
                        <select class="form-control" id="edit_goal" name="goal" required>
                            <option value="">Choose Goal</option>
                            <option value="Weight Gain">Weight Gain</option>
                            <option value="Fit">Fit</option>
                            <option value="Weight Loss">Weight Loss</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="edit_diet">Diet Description</label>
                        <textarea type="text" class="form-control" id="edit_diet" rows="4" name="diet"
                            required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="edit_alternative_diet">Alternative Diet</label>
                        <textarea type="text" class="form-control" rows="4" id="edit_alternative_diet"
                            name="alternative_diet"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Diet</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal HTML -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Diet Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Image -->
                <!-- <img id="modalImage" src="" alt="Workout Image" class="img-fluid" style="width: 20%;"> -->
                <div class="form-data text-center">
                    <img id="modalImage" src="" class="img-fluid" style="width: 40%;">
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

    document.addEventListener('DOMContentLoaded', function () {
        // Function to initialize event listeners for edit and view buttons
        function initializeEventListeners() {
            // Edit Diet Modal
            const editButtons = document.querySelectorAll('.edit-book-button');
            const editImageInput = document.getElementById('edit_image');
            const currentImage = document.getElementById('current_image');
            const editGenderSelect = document.getElementById('edit_gender');
            const editMealTypeSelect = document.getElementById('edit_meal');


            editButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const diet = JSON.parse(this.getAttribute('data-book'));

                    document.getElementById('edit_diet_id').value = diet.id;
                    document.getElementById('edit_name').value = diet.name;
                    currentImage.src = diet.image; // Set the src of the image element
                    editGenderSelect.value = diet.gender;
                    editMealTypeSelect.value = diet.meal_type;
                    document.getElementById('edit_diet').value = diet.diet;
                    document.getElementById('edit_alternative_diet').value = diet.alternative_diet;
                    document.getElementById('edit_min_age').value = diet.min_age;
                    document.getElementById('edit_max_age').value = diet.max_age;
                    document.getElementById('edit_goal').value = diet.goal;
                    document.getElementById('edit_calories').value = diet.calories;
                    document.getElementById('edit_protein').value = diet.protein;
                    document.getElementById('edit_carbs').value = diet.carbs;
                    document.getElementById('edit_fats').value = diet.fats;
                    new bootstrap.Modal(document.getElementById('editDietModal')).show();
                });
            });

            // Show a preview of the new image when selected
            if (editImageInput) {
                editImageInput.addEventListener('change', function (event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            currentImage.src = e.target.result;
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }

            // View Workout Modal
            document.querySelectorAll('.view-workout').forEach(button => {
                button.addEventListener('click', function () {
                    const workout = JSON.parse(this.getAttribute('data-workout'));

                    // Set the image src
                    document.getElementById('modalImage').src = workout.image ? workout.image : 'images/profile/17.jpg';

                    // Set workout details
                    const details = `
                   <div class="data-grid">
                    <div class="item"><strong>Diet Name:</strong> ${workout.name}</div>
                    <div class="item"><strong>Goal:</strong> ${workout.goal}</div>
                    <div class="item"><strong>Calories:</strong> ${workout.calories}</div>
                    <div class="item"><strong>Protein:</strong> ${workout.protein}</div>
                    <div class="item"><strong>Carbs:</strong> ${workout.carbs}</div>
                    <div class="item"><strong>Fats:</strong> ${workout.fats}</div>
                    <div class="item"><strong>Gender:</strong> ${workout.gender}</div>
                    <div class="item"><strong>Min-Max Age:</strong> ${workout.min_age}-${workout.max_age}</div>
                    </div>
                    <br>
                    <strong>Meal Type:</strong> ${workout.meal_type}<br>
                    <strong>Diet Description:</strong> ${workout.diet}<br>
                    <strong>Alternative Description:</strong> ${workout.alternative_diet}<br>

                `;
                    document.getElementById('modalDetails').innerHTML = details;

                    // Show modal
                    new bootstrap.Modal(document.getElementById('viewModal')).show();
                });
            });
        }

        // Initial call to set up event listeners
        initializeEventListeners();

        // Reinitialize event listeners after DataTable redraw (or similar events)
        $('#example3').on('draw.dt', function () {
            initializeEventListeners(); // Reattach event listeners
        });
    });


    function confirmDelete(uuid) {
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
                window.location.href = '/delete-diet/' + uuid;
            }
        });
    }
</script>

@include('CustomSweetAlert');
@endsection