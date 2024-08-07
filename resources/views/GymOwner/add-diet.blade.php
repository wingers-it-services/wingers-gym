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
                                <h4 class="mb-3">Add Diet</h4>
                                <form name="myForm" method="POST" enctype="multipart/form-data" action="/add-gym-diet">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="image">Diet Image</label>
                                            <input type="file" class="form-control" id="image" name="image" required="">
                                            <div class="invalid-feedback">
                                                Product image is required.
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="name">Diet Name</label>
                                            <input type="text" class="form-control" id="name" name="name" required="">
                                            <div class="invalid-feedback">
                                                Product name is required.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
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
                                            <label for="diet">Diet </label>
                                            <input type="text" class="form-control" id="diet" name="diet" placeholder="">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="alternative_diet">Alternative Diet </label>
                                            <input type="text" class="form-control" id="alternative_diet" name="alternative_diet" placeholder="">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="min_age">Min Age </label>
                                            <input type="number" class="form-control" id="min_age" name="min_age" placeholder="">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="max_age">Max Age </label>
                                            <input type="number" class="form-control" id="max_age" name="max_age" placeholder="">
                                        </div>


                                        <div class="col-md-6 mb-3">
                                            <label for="goal">Goal </label>
                                            <input type="text" class="form-control" id="goal" name="goal" placeholder="">
                                        </div>
                                        <hr class="mb-4">
                                        <button class="btn btn-primary btn-lg btn-block" type="submit">Add Diet</button>
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
                                <th scope="col">Max-Min Age</th>
                                <th scope="col" class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($diets as $subscription)
                            <tr>
                                <td>
                                    <img width="80" src="{{ $subscription->image ? asset($subscription->image) : asset('images/profile/17.jpg') }}" loading="lazy" alt="Profile Image">
                                </td>
                                <td>{{$subscription->name }}</td>
                                <td>{{$subscription->gender }}</td>
                                <td>{{$subscription->min_age }} - {{ $subscription->max_age }}</td>
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