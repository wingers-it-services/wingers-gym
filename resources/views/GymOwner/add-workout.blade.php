@extends('GymOwner.master')
@section('title','Dashboard')
@section('content')

<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Add Product</a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <h4 class="mb-3">Add Workout</h4>
                                <hr>
                                <form name="myForm" method="POST" enctype="multipart/form-data" action="/add-gym-workout">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="image">Workout Image</label>
                                            <input type="file" class="form-control" id="image" name="image" required="">
                                            <div class="invalid-feedback">
                                                Product image is required.
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="vedio_link">vedio Link </label>
                                            <input type="text" class="form-control" id="vedio_link" name="vedio_link" placeholder="">
                                        </div>


                                        <div class="col-md-6 mb-3">
                                            <label for="category">Category</label>
                                            <input type="text" class="form-control" name="category" id="category" required="">
                                            <div class="invalid-feedback">
                                                Product name is required.
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="name">Workout Name</label>
                                            <input type="text" class="form-control" id="name" name="name" required="">
                                            <div class="invalid-feedback">
                                                Product name is required.
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="gender">Gender</label>
                                            <div class="input-group">
                                                <select class="me-sm-2 form-control default-select" id="gender" name="gender">
                                                    <option>Choose...</option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="description">Description</label>
                                            <textarea type="text" class="form-control" id="description" name="description" required=""></textarea>
                                            <div class="invalid-feedback">
                                                Product name is required.
                                            </div>
                                        </div>
                                        <hr class="mb-4">
                                        <button class="btn btn-primary btn-lg btn-block" type="submit">Add Workout</button>
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
                                <th scope="col">Video Link</th>
                                <th scope="col">Category</th>
                                <th scope="col">Workout Name</th>
                                <th scope="col">Gender</th>
                                <th scope="col" class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($workouts as $subscription)
                            <tr>
                                <td>
                                    <img width="80" src="{{ $subscription->image ? asset($subscription->image) : asset('images/profile/17.jpg') }}" loading="lazy" alt="Profile Image">
                                </td>
                                <td>{{$subscription->vedio_link }}</td>
                                <td>{{$subscription->category }}</td>
                                <td>{{$subscription->name }}</td>
                                <td>{{$subscription->gender }}</td>
                                <td class="text-end">
                                    <span> <a href="javascript:void(0);" class="me-4 edit-workout" data-bs-toggle="tooltip" data-placement="top" title="Edit" data-workout="{{ json_encode($subscription) }}">
                                            <i class="fa fa-pencil color-muted"></i></a>
                                        <a onclick="confirmDelete('{{ $subscription->uuid }}')" data-bs-toggle="tooltip" data-placement="top" title="Close"><i class="fas fa-trash"></i></a></span>
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
<div class="modal fade" id="editDietModal" tabindex="-1" role="dialog" aria-labelledby="editDietModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Diet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editDietForm" method="POST" action="update-workout" enctype="multipart/form-data">
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
                    </div>
                    
                    <div class="form-group">
                        <label for="category">Category</label>
                        <input type="text" class="form-control" name="category" id="edit_category" required="">
                    </div>
                    
                    <div class="form-group">
                        <label for="name">Workout Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required="">
                    </div>
                    
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <div class="input-group">
                            <select class="me-sm-2 form-control default-select" id="edit_gender" name="gender">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea type="text" class="form-control" id="edit_description" name="description" required=""></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.edit-workout');
    const editImageInput = document.getElementById('edit_image');
    const currentImage = document.getElementById('current_image');
    const editGenderSelect = document.getElementById('edit_gender');

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
            console.log(`Gender set to: ${workout.gender}`); // Debugging line to check the gender value
            
            // Force re-render of the select element
            const parent = editGenderSelect.parentElement;
            const placeholder = document.createElement('div');
            parent.replaceChild(placeholder, editGenderSelect);
            parent.replaceChild(editGenderSelect, placeholder);

            new bootstrap.Modal(document.getElementById('editDietModal')).show();
        });
    });

    // Show a preview of the new image when selected
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
});



</script>
@endsection