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
                                            <label for="productImage">Product Images</label>
                                            <input type="file" class="form-control" id="productImage" name="productImages[]" multiple required onchange="previewImages()">
                                            <div class="invalid-feedback">
                                                At least one product image is required.
                                            </div>
                                            <div id="imagePreview" class="mt-3"></div>
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
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card" id="accessory-card" style="display:none;">
                    <div class="card-header">
                        <h4 class="card-title">Add Gym Accessory</h4>
                    </div>
                    <div class="card-body">
                        <form class="needs-validation" novalidate="">
                            <div class="row">
                                <!-- Accessory Name -->
                                <div class="col-md-6 mb-3">
                                    <label for="accessoryName">Accessory Name</label>
                                    <input type="text" class="form-control" id="accessoryName" name="name" required="">
                                    <div class="invalid-feedback">
                                        Accessory name is required.
                                    </div>
                                </div>

                                <!-- Category -->
                                <div class="col-md-6 mb-3">
                                    <label for="accessoryCategory">Category</label>
                                    <input type="text" class="form-control" id="accessoryCategory" name="category" required="">
                                    <div class="invalid-feedback">
                                        Category is required.
                                    </div>
                                </div>

                                <!-- Brand Name -->
                                <div class="col-md-6 mb-3">
                                    <label for="brandName">Brand Name</label>
                                    <input type="text" class="form-control" id="brandName" name="brand_name" required="">
                                    <div class="invalid-feedback">
                                        Brand name is required.
                                    </div>
                                </div>

                                <!-- Model Number -->
                                <div class="col-md-6 mb-3">
                                    <label for="modelNumber">Model Number</label>
                                    <input type="text" class="form-control" id="modelNumber" name="model_number" placeholder="Optional">
                                </div>

                                <!-- Quantity -->
                                <div class="col-md-6 mb-3">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" required="">
                                    <div class="invalid-feedback">
                                        Quantity is required.
                                    </div>
                                </div>

                                <!-- Price -->
                                <div class="col-md-6 mb-3">
                                    <label for="price">Price</label>
                                    <input type="number" class="form-control" id="price" name="price" required="">
                                    <div class="invalid-feedback">
                                        Price is required.
                                    </div>
                                </div>

                                <!-- Condition -->
                                <div class="col-md-6 mb-3">
                                    <label for="condition">Condition</label>
                                    <input type="text" class="form-control" id="condition" name="condition" placeholder="Optional">
                                </div>

                                <!-- Description -->
                                <div class="col-md-12 mb-3">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" required=""></textarea>
                                    <div class="invalid-feedback">
                                        Description is required.
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-xl-12">
                <div class="card" id="equiment-card" style="display:none;">
                    <div class="card-header">
                        <h4 class="card-title">Add Gym Equiments</h4>
                    </div>
                    <div class="card-body">
                        <form class="needs-validation" novalidate="">
                            <!-- Equipment form fields here -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="accessoryName">Equiment Name</label>
                                    <input type="text" class="form-control" id="equimentName" name="equipment_name" required="">
                                    <div class="invalid-feedback">
                                        Equiment name is required.
                                    </div>
                                </div>

                                <!-- Brand Name -->
                                <div class="col-md-6 mb-3">
                                    <label for="brandName">Brand Name</label>
                                    <input type="text" class="form-control" id="brandName" name="brand_name" required="">
                                    <div class="invalid-feedback">
                                        Brand name is required.
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="rate">Rate</label>
                                    <input type="number" class="form-control" id="rate" name="rate" step="0.01" required="">
                                    <div class="invalid-feedback">
                                        Price is required.
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="comission">Commision (In %)</label>
                                    <input type="number" class="form-control" id="comission" name="comission" step="0.01" required="">
                                    <div class="invalid-feedback">
                                        Commision is required.
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="discount">Discount (In %)</label>
                                    <input type="number" class="form-control" id="discount" name="discount" step="0.01" required="">
                                    <div class="invalid-feedback">
                                        Discount is required.
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="gst">GST</label>
                                    <input type="number" class="form-control" id="gst" name="gst" step="0.01" required="">
                                    <div class="invalid-feedback">
                                        GST is required.
                                    </div>
                                </div>


                                <div class="col-md-6 mb-3">
                                    <label for="amount">Amount</label>
                                    <input type="number" class="form-control" id="amount" name="amount" step="0.01" required="">
                                    <div class="invalid-feedback">
                                        Price is required.
                                    </div>
                                </div>


                                <!-- Model Number -->
                                <div class="col-md-6 mb-3">
                                    <label for="company_name">Compant Name</label>
                                    <input type="text" class="form-control" id="company_name" name="company_name">
                                    <div class="invalid-feedback">
                                        Compant Name is required.
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="company_contact">Company Contact</label>
                                    <input type="text" class="form-control" id="company_contact" name="company_contact" required="">
                                    <div class="invalid-feedback">
                                        Company Contact is required.
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="company_contact">Company Address</label>
                                    <textarea class="form-control" id="company_contact" rows="5" name="company_contact" required=""></textarea>
                                    <div class="invalid-feedback">
                                        Company Address is required.
                                    </div>
                                </div>


                                <div class="col-md-6 mb-3">
                                    <label for="company_website">Company Website</label>
                                    <input type="text" class="form-control" id="company_website" name="company_website" required="">
                                    <div class="invalid-feedback">
                                        Company Website is required.
                                    </div>
                                </div>

                                <!-- Quantity -->
                                <div class="col-md-6 mb-3">
                                    <label for="warrenty">Warrenty</label>
                                    <input type="number" class="form-control" id="warrenty" name="warrenty" placeholder="In Years" required="">
                                    <div class="invalid-feedback">
                                        Warrenty is required.
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="warrenty_details">Warrenty Details</label>
                                    <textarea type="text" class="form-control" id="warrenty_details" name="warrenty_details"></textarea>
                                    <div class="invalid-feedback">
                                        Warrenty Details is required.
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="item_weight">Item Weight</label>
                                    <input type="number" class="form-control" id="item_weight" name="item_weight" placeholder="In Kg" step="0.01" required="">
                                    <div class="invalid-feedback">
                                        Item Weight is required.
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="size">Size</label>
                                    <input type="text" class="form-control" id="size" name="size" required="">
                                    <div class="invalid-feedback">
                                        Item Weight is required.
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="colour">Colour</label>
                                    <input type="text" class="form-control" id="colour" name="colour" required="">
                                    <div class="invalid-feedback">
                                        Company Website is required.
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="tension_level">Tension Level</label>
                                    <input type="text" class="form-control" id="tension_level" name="tension_level" required="">
                                    <div class="invalid-feedback">
                                        Tension Level is required.
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="material">Material</label>
                                    <input type="text" class="form-control" id="material" name="material" required="">
                                    <div class="invalid-feedback">
                                        Material is required.
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="special_feautre">Special Feature</label>
                                    <textarea type="text" class="form-control" id="special_feautre" name="special_feautre"></textarea>
                                    <div class="invalid-feedback">
                                        Special Feature is required.
                                    </div>
                                </div>


                                <!-- Description -->
                                <div class="col-md-12 mb-3">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" required=""></textarea>
                                    <div class="invalid-feedback">
                                        Description is required.
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-xl-12">
                <div class="card" id="supliment-card" style="display:none;">
                    <div class="card-header">
                        <h4 class="card-title">Add Gym Suppliments</h4>
                    </div>
                    <div class="card-body">
                        <form class="needs-validation" novalidate="">
                            <!-- Equipment form fields here -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="supplimentName">Suppliment Name</label>
                                    <input type="text" class="form-control" id="supplimentName" name="suppliments_name" required="">
                                    <div class="invalid-feedback">
                                        Equiment name is required.
                                    </div>
                                </div>

                                <!-- Brand Name -->
                                <div class="col-md-6 mb-3">
                                    <label for="brandName">Brand Name</label>
                                    <input type="text" class="form-control" id="brandName" name="brand_name" required="">
                                    <div class="invalid-feedback">
                                        Brand name is required.
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="rate">Rate</label>
                                    <input type="number" class="form-control" id="rate" name="rate" step="0.01" required="">
                                    <div class="invalid-feedback">
                                        Price is required.
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="comission">Commision (In %)</label>
                                    <input type="number" class="form-control" id="comission" name="comission" step="0.01" required="">
                                    <div class="invalid-feedback">
                                        Commision is required.
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="discount">Discount (In %)</label>
                                    <input type="number" class="form-control" id="discount" name="discount" step="0.01" required="">
                                    <div class="invalid-feedback">
                                        Discount is required.
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="gst">GST</label>
                                    <input type="number" class="form-control" id="gst" name="gst" step="0.01" required="">
                                    <div class="invalid-feedback">
                                        GST is required.
                                    </div>
                                </div>


                                <div class="col-md-6 mb-3">
                                    <label for="amount">Amount</label>
                                    <input type="number" class="form-control" id="amount" name="amount" step="0.01" required="">
                                    <div class="invalid-feedback">
                                        Price is required.
                                    </div>
                                </div>


                                <!-- Model Number -->
                                <div class="col-md-6 mb-3">
                                    <label for="company_name">Compant Name</label>
                                    <input type="text" class="form-control" id="company_name" name="company_name">
                                    <div class="invalid-feedback">
                                        Compant Name is required.
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="company_contact">Company Contact</label>
                                    <input type="text" class="form-control" id="company_contact" name="company_contact" required="">
                                    <div class="invalid-feedback">
                                        Company Contact is required.
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="company_contact">Company Address</label>
                                    <textarea class="form-control" id="company_contact" rows="5" name="company_contact" required=""></textarea>
                                    <div class="invalid-feedback">
                                        Company Address is required.
                                    </div>
                                </div>


                                <div class="col-md-6 mb-3">
                                    <label for="company_website">Company Website</label>
                                    <input type="text" class="form-control" id="company_website" name="company_website" required="">
                                    <div class="invalid-feedback">
                                        Company Website is required.
                                    </div>
                                </div>

                                <!-- Quantity -->
                                <div class="col-md-6 mb-3">
                                    <label for="warrenty">Warrenty</label>
                                    <input type="number" class="form-control" id="warrenty" name="warrenty" placeholder="In Years" required="">
                                    <div class="invalid-feedback">
                                        Warrenty is required.
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="warrenty_details">Warrenty Details</label>
                                    <textarea type="text" class="form-control" id="warrenty_details" name="warrenty_details"></textarea>
                                    <div class="invalid-feedback">
                                        Warrenty Details is required.
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="item_form">Item Form</label>
                                    <input type="number" class="form-control" id="item_form" name="item_form" step="0.01" required="">
                                    <div class="invalid-feedback">
                                        Item Weight is required.
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="size">Manufacturer</label>
                                    <input type="text" class="form-control" id="manufacturer" name="manufacturer" required="">
                                    <div class="invalid-feedback">
                                        Manufacturer is required.
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="size">Size</label>
                                    <input type="text" class="form-control" id="size" name="size" required="">
                                    <div class="invalid-feedback">
                                        Item Weight is required.
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="flavour">Flavour</label>
                                    <input type="text" class="form-control" id="flavour" name="flavour" required="">
                                    <div class="invalid-feedback">
                                        Flavour is required.
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="age_range">Age Range</label>
                                    <input type="text" class="form-control" id="age_range" name="age_range" required="">
                                    <div class="invalid-feedback">
                                        Tension Level is required.
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="net_quantity">Net Quantity</label>
                                    <input type="number" class="form-control" id="net_quantity" name="net_quantity" required="">
                                    <div class="invalid-feedback">
                                        Material is required.
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="diet_type">Diet Type</label>
                                    <input type="text" class="form-control" id="diet_type" name="diet_type">
                                    <div class="invalid-feedback">
                                        Diet Type is required.
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="product_benefits">Product Benefits</label>
                                    <textarea class="form-control" id="product_benefits" rows="5" name="product_benefits" required=""></textarea>
                                    <div class="invalid-feedback">
                                        Product Benefits is required.
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="diet_type">Item Dimensions</label>
                                    <input type="text" class="form-control" id="item_dimensions" name="item_dimensions">
                                    <div class="invalid-feedback">
                                        Item Dimensions is required.
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="diet_type">Special Ingredients</label>
                                    <input type="text" class="form-control" id="special_ingredients" name="special_ingredients">
                                    <div class="invalid-feedback">
                                        Special Ingredients is required.
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" required=""></textarea>
                                    <div class="invalid-feedback">
                                        Description is required.
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-xl-12">
                <div class="card" id="cloth-card" style="display:none;">
                    <div class="card-header">
                        <h4 class="card-title">Add Gym Cloths</h4>
                    </div>
                    <div class="card-body">
                        <form class="needs-validation" novalidate="">
                            <div class="row">
                                <!-- Accessory Name -->
                                <div class="col-md-6 mb-3">
                                    <label for="clothName">Cloth Name</label>
                                    <input type="text" class="form-control" id="clothName" name="name" required="">
                                    <div class="invalid-feedback">
                                        Cloth name is required.
                                    </div>
                                </div>

                                <!-- Category -->
                                <div class="col-md-6 mb-3">
                                    <label for="accessoryCategory">Category</label>
                                    <input type="text" class="form-control" id="accessoryCategory" name="category" required="">
                                    <div class="invalid-feedback">
                                        Category is required.
                                    </div>
                                </div>

                                <!-- Brand Name -->
                                <div class="col-md-6 mb-3">
                                    <label for="brandName">Brand Name</label>
                                    <input type="text" class="form-control" id="brandName" name="brand_name" required="">
                                    <div class="invalid-feedback">
                                        Brand name is required.
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="size">Size</label>
                                    <input type="text" class="form-control" id="size" name="size" required="">
                                    <div class="invalid-feedback">
                                        Size is required.
                                    </div>
                                </div>


                                <!-- Quantity -->
                                <div class="col-md-6 mb-3">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" required="">
                                    <div class="invalid-feedback">
                                        Quantity is required.
                                    </div>
                                </div>

                                <!-- Price -->
                                <div class="col-md-6 mb-3">
                                    <label for="price">Price</label>
                                    <input type="number" class="form-control" id="price" name="price" required="">
                                    <div class="invalid-feedback">
                                        Price is required.
                                    </div>
                                </div>

                                <!-- Condition -->
                                <div class="col-md-6 mb-3">
                                    <label for="material">Material</label>
                                    <textarea type="text" class="form-control" id="material" name="material" row="3"></textarea>
                                    <div class="invalid-feedback">
                                        Material is required.
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="col-md-12 mb-3">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" required=""></textarea>
                                    <div class="invalid-feedback">
                                        Description is required.
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary btn-lg btn-block" type="submit">Add Product</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var categorySelect = document.getElementById('category');
        var accessoryCard = document.getElementById('accessory-card');
        var equimentCard = document.getElementById('equiment-card');
        var supplimentCard = document.getElementById('supliment-card');
        var clothCard = document.getElementById('cloth-card');

        categorySelect.addEventListener('change', function() {
            // Hide all forms
            var forms = document.querySelectorAll('.category-form');
            forms.forEach(function(form) {
                form.style.display = 'none';
            });

            // Show the selected category form
            if (categorySelect.value === 'accessory') {
                accessoryCard.style.display = 'block';
                // Focus on the first input field of the accessory form
                document.getElementById('accessoryName').focus();
            } else {
                accessoryCard.style.display = 'none';
            }

            if (categorySelect.value === 'equipment') {
                equimentCard.style.display = 'block';
                // Focus on the first input field of the accessory form
                document.getElementById('equimentName').focus();
            } else {
                equimentCard.style.display = 'none';
            }

            if (categorySelect.value === 'supplement') {
                supplimentCard.style.display = 'block';
                // Focus on the first input field of the accessory form
                document.getElementById('supplimentName').focus();
            } else {
                supplimentCard.style.display = 'none';
            }

            if (categorySelect.value === 'clothing') {
                clothCard.style.display = 'block';
                // Focus on the first input field of the accessory form
                document.getElementById('clothName').focus();
            } else {
                clothCard.style.display = 'none';
            }
        });
    });

    function previewImages() {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = ''; // Clear any existing previews

        const files = document.getElementById('productImage').files;
        for (const file of files) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const img = document.createElement('img');
                img.src = event.target.result;
                img.classList.add('img-thumbnail', 'mr-2');
                img.style.width = '100px';
                img.style.height = '100px';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    }
</script>


@endsection