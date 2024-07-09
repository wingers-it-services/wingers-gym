@extends('admin.master')
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
                                <h4 class="mb-3">Add Product</h4>
                                <form class="needs-validation" novalidate="">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="productImage">Product Image</label>
                                            <input type="file" class="form-control" id="productImage" required="">
                                            <div class="invalid-feedback">
                                                Product image is required.
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="productName">Product Name</label>
                                            <input type="text" class="form-control" id="productName" required="">
                                            <div class="invalid-feedback">
                                                Product name is required.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                        <label for="productCode">Product Code</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="productName" required="">
                                            <div class="invalid-feedback" style="width: 100%;">
                                                Product code is required.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="brand">Brand <span class="text-muted">(Optional)</span></label>
                                        <input type="text" class="form-control" id="brand" placeholder="Brand">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                        <label for="address">Address</label>
                                        <input type="text" class="form-control" id="address" required="">
                                        <div class="invalid-feedback">
                                            Please enter your address.
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="availability">Availability <span class="text-muted">(Optional)</span></label>
                                        <input type="text" class="form-control" id="availability" placeholder="Availability">
                                    </div>

                                    <div class="mb-3">
                                        <label for="designation">Descrtiption</label>
                                        <input type="text" class="form-control" id="designation" placeholder="Designation">
                                    </div>

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
