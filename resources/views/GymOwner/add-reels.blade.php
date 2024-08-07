@extends('GymOwner.master')
@section('title','Dashboard')
@section('content')

<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Add Reels</a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <h4 class="mb-3">Add Reels</h4>
                                <form class="needs-validation" novalidate="">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="brand">url</label>
                                            <input type="text" class="form-control" id="brand" placeholder="">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="productCode">Type</label>
                                            <div class="input-group">
                                                <select class="me-sm-2 form-control default-select" id="blood_group" name="blood_group">
                                                    <option>Choose...</option>
                                                    <option value="male">Image</option>
                                                    <option value="female">Video</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="brand">Age</label>
                                            <input type="number" class="form-control" id="brand" placeholder="">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="productCode">Gender</label>
                                            <div class="input-group">
                                                <select class="me-sm-2 form-control default-select" id="blood_group" name="blood_group">
                                                    <option>Choose...</option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>





                                    <!-- <div class="mb-3">
                                            <label for="designation">Descrtiption</label>
                                            <input type="text" class="form-control" id="designation" placeholder="Designation">
                                        </div> -->

                                    <hr class="mb-4">
                                    <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection