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
                                            <label for="brand">Brand</label>
                                            <input type="text" class="form-control" id="brand" placeholder="Brand">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="quantity">Quantity</label>
                                            <input type="number" class="form-control" id="quantity" required="">
                                            <div class="invalid-feedback">
                                                Please enter your address.
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="price">Price <span class="text-muted"></span></label>
                                            <input type="number" class="form-control" id="price" placeholder="Price">
                                        </div>

                                        <div class="mb-3">
                                            <label for="designation">Descrtiption</label>
                                            <textarea type="text" class="form-control" id="designation" placeholder="Descrtiption"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="category">Select Category</label>
                                        <select class="form-control" id="category" required>
                                            <option value="">Choose...</option>
                                            <option value="equipment">Equipment</option>
                                            <option value="supplement">Supplement</option>
                                            <option value="accessory">Accessory</option>
                                            <option value="clothing">Clothing</option>
                                        </select>
                                    </div>
                                    <!-- Equipment Form -->
                                    <div id="equipment-form" class="category-form" style="display:none;">
                                        <form class="needs-validation" novalidate="">
                                            <!-- Equipment form fields here -->
                                            <div class="row">
                                                <!-- Equipment specific fields -->
                                            </div>
                                            <button class="btn btn-primary btn-lg btn-block" type="submit">Add Equipment</button>
                                        </form>
                                    </div>

                                    <!-- Supplement Form -->
                                    <div id="supplement-form" class="category-form" style="display:none;">
                                        <form class="needs-validation" novalidate="">
                                            <!-- Supplement form fields here -->
                                            <div class="row">
                                                <!-- Supplement specific fields -->
                                            </div>
                                            <button class="btn btn-primary btn-lg btn-block" type="submit">Add Supplement</button>
                                        </form>
                                    </div>

                                    <!-- Accessory Form -->
                                    <div id="accessory-form" class="category-form" style="display:none;">
                                        <form class="needs-validation" novalidate="">
                                            <!-- Accessory form fields here -->
                                            <div class="row">
                                                <!-- Accessory specific fields -->
                                            </div>
                                            <button class="btn btn-primary btn-lg btn-block" type="submit">Add Accessory</button>
                                        </form>
                                    </div>

                                    <!-- Clothing Form -->
                                    <div id="clothing-form" class="category-form" style="display:none;">
                                        <form class="needs-validation" novalidate="">
                                            <!-- Clothing form fields here -->
                                            <div class="row">
                                                <!-- Clothing specific fields -->
                                            </div>
                                            <button class="btn btn-primary btn-lg btn-block" type="submit">Add Clothing</button>
                                        </form>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var categorySelect = document.getElementById('category');
        var forms = document.querySelectorAll('.category-form');

        categorySelect.addEventListener('change', function () {
            forms.forEach(function(form) {
                form.style.display = 'none';
            });

            var selectedCategory = categorySelect.value;
            if (selectedCategory) {
                document.getElementById(selectedCategory + '-form').style.display = 'block';
            }
        });
    });
</script>

@endsection