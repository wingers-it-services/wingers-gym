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
            <div class="card-body"> <h4 class="mb-3">Workout List</h4>
            <hr>
                <div class="table-responsive">
                    <table id="example3" class="table table-bordered table-striped verticle-middle table-responsive-sm">
                        <thead>
                            <tr>
                                <th scope="col">Image</th>
                                <th scope="col">Name</th>
                                <th scope="col">Gender</th>
                                <th scope="col">Category</th>
                                <th scope="col" class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($workouts as $subscription)
                            <tr>
                                <td>
                                    <img width="80" src="{{ $subscription->image ? asset($subscription->image) : asset('images/profile/17.jpg') }}" loading="lazy" alt="Profile Image">
                                </td>
                                <td>{{$subscription->name }}</td>
                                <td>{{$subscription->gender }}</td>
                                <td>{{$subscription->category }}</td>
                                <td class="text-end">
                                    <span><a href="javascript:void(0);" class="me-4 edit-book-button" data-bs-toggle="modal" data-bs-target="#editSuscription" data-book='@json($subscription)'><i class="fa fa-pencil color-muted"></i> </a>
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

@endsection