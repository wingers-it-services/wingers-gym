@extends('GymOwner.master')
@section('title','Dashboard')
@section('content')
<style>
    .image-container {
        position: relative;
        display: inline-block;
        margin-right: 10px;
    }

    .image-container img {
        width: 100px;
        height: 100px;
        object-fit: cover;
    }

    .remove-btn {
        position: absolute;
        top: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        text-align: center;
        line-height: 24px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
    }

    .remove-btn:hover {
        background: rgba(0, 0, 0, 0.8);
    }
</style>
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
                                <form method="post" action="{{route('addProduct')}}" enctype="multipart/form-data" class="needs-validation" novalidate="">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="productImage">Product Images</label>
                                            <input type="file" class="form-control" id="productImage" name="images[]" multiple required onchange="handleFiles(this.files)">
                                            <div class="invalid-feedback">
                                                At least one product image is required.
                                            </div>
                                            <div id="imagePreview" class="mt-3"></div>
                                        </div>


                                        <div class="col-md-6 mb-3">
                                            <label for="productName">Product Name</label>
                                            <input type="text" name="name" class="form-control" id="productName" required="">
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
                                            <input type="text" class="form-control" name="brand_name" id="brand" placeholder="Brand">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="quantity">Quantity</label>
                                            <input type="number" class="form-control" id="quantity" name="quantity" required="">
                                            <div class="invalid-feedback">
                                                Please enter your quantity.
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="price">Price <span class="text-muted"></span></label>
                                            <input type="number" class="form-control" id="price" name="price" step="0.01" required="">
                                            <div class="invalid-feedback">
                                                Price is required.http://127.0.0.1:8000/dashboard
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="designation">Descrtiption</label>
                                            <textarea type="text" class="form-control" rows="5" name="description" id="description" placeholder="Descrtiption"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="category">Select Category</label>
                                        <select name="category" class="form-control" id="category" required>
                                            <option value="">Choose...</option>
                                            <option value="{{ \App\Enums\ProductCategoryEnum::EQUIPMENTS }}">Equipment</option>
                                            <option value="{{ \App\Enums\ProductCategoryEnum::SUPPLIMENTS }}">Supplement</option>
                                            <option value="{{ \App\Enums\ProductCategoryEnum::ACCESSORIES }}">Accessory</option>
                                            <option value="{{ \App\Enums\ProductCategoryEnum::CLOTHS }}">Clothing</option>
                                        </select>
                                    </div>
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
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="modelNumber">Model Number</label>
                                <input type="text" class="form-control" id="modelNumber" name="model_number" placeholder="Optional">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="condition">Condition</label>
                                <input type="text" class="form-control" id="condition" name="condition" placeholder="Optional">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-12">
                <div class="card" id="equiment-card" style="display:none;">
                    <div class="card-header">
                        <h4 class="card-title">Add Gym Equiments</h4>
                    </div>
                    <div class="card-body">
                        <!-- Equipment form fields here -->
                        <div class="row">
                            <!-- Brand Name -->

                            <div class="col-md-6 mb-3">
                                <label for="equipment_comission">Commision (In %)</label>
                                <input type="number" class="form-control" id="equipment_comission" name="equipment_comission" step="0.01" required="">
                                <div class="invalid-feedback">
                                    Commision is required.
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="equipment_discount">Discount (In %)</label>
                                <input type="number" class="form-control" id="equipment_discount" name="equipment_discount" step="0.01" required="">
                                <div class="invalid-feedback">
                                    Discount is required.
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="equipment_gst">GST</label>
                                <input type="number" class="form-control" id="equipment_gst" name="equipment_gst" step="0.01" required="">
                                <div class="invalid-feedback">
                                    GST is required.
                                </div>
                            </div>


                            <!-- Model Number -->
                            <div class="col-md-6 mb-3">
                                <label for="equipment_company_name">Compant Name</label>
                                <input type="text" class="form-control" id="equipment_company_name" name="equipment_company_name">
                                <div class="invalid-feedback">
                                    Compant Name is required.
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="equipment_company_contact">Company Contact</label>
                                <input type="text" class="form-control" id="equipment_company_contact" name="equipment_company_contact" required="">
                                <div class="invalid-feedback">
                                    Company Contact is required.
                                </div>
                            </div>




                            <div class="col-md-6 mb-3">
                                <label for="equipment_company_website">Company Website</label>
                                <input type="text" class="form-control" id="equipment_company_website" name="equipment_company_website" required="">
                                <div class="invalid-feedback">
                                    Company Website is required.
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="equipment_company_address">Company Address</label>
                                <textarea class="form-control" id="equipment_company_address" rows="5" name="equipment_company_address" required=""></textarea>
                                <div class="invalid-feedback">
                                    Company Address is required.
                                </div>
                            </div>

                            <!-- Quantity -->
                            <div class="col-md-6 mb-3">
                                <label for="equipment_warrenty">Warrenty</label>
                                <input type="number" class="form-control" id="equipment_warrenty" name="equipment_warrenty" placeholder="In Years" required="">
                                <div class="invalid-feedback">
                                    Warrenty is required.
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="equipment_warrenty_details">Warrenty Details</label>
                                <textarea type="text" class="form-control" id="equipment_warrenty_details" name="equipment_warrenty_details"></textarea>
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
                                <label for="equipment_size">Size</label>
                                <input type="text" class="form-control" id="equipment_size" name="equipment_size" required="">
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
                                <label for="equipment_material">Material</label>
                                <input type="text" class="form-control" id="equipment_material" name="equipment_material" required="">
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

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-12">
                <div class="card" id="supliment-card" style="display:none;">
                    <div class="card-header">
                        <h4 class="card-title">Add Gym Suppliments</h4>
                    </div>
                    <div class="card-body">
                        <!-- Equipment form fields here -->
                        <div class="row">

                            <!-- Brand Name -->




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
                                <label for="suppliment_company_website">Company Website</label>
                                <input type="text" class="form-control" id="suppliment_company_website" name="suppliment_company_website" required="">
                                <div class="invalid-feedback">
                                    Company Website is required.
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="company_address">Company Address</label>
                                <textarea class="form-control" id="company_address" rows="5" name="company_address" required=""></textarea>
                                <div class="invalid-feedback">
                                    Company Address is required.
                                </div>
                            </div>

                            <!-- Quantity -->
                            <div class="col-md-6 mb-3">
                                <label for="supliment_warrenty">Warrenty</label>
                                <input type="number" class="form-control" id="supliment_warrenty" name="supliment_warrenty" placeholder="In Years" required="">
                                <div class="invalid-feedback">
                                    Warrenty is required.
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="warrenty_details">Warrenty Details</label>
                                <textarea type="text" class="form-control" id="supliment_warrenty_details" name="supliment_warrenty_details"></textarea>
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
                                <input type="text" class="form-control" id="supliment_size" name="supliment_size" required="">
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


                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-12">
                <div class="card" id="cloth-card" style="display:none;">
                    <div class="card-header">
                        <h4 class="card-title">Add Gym Cloths</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="size">Size</label>
                                <input type="text" class="form-control" id="size" name="size" required="">
                                <div class="invalid-feedback">
                                    Size is required.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="material">Material</label>
                                <textarea type="text" class="form-control" id="material" name="material" row="3"></textarea>
                                <div class="invalid-feedback">
                                    Material is required.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary btn-lg btn-block" type="submit">Add Product</button>

            </form>
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
            http: //127.0.0.1:8000/gym-customers

                // Show the selected category form
                if (categorySelect.value === '{{ \App\Enums\ProductCategoryEnum::ACCESSORIES }}') {
                    accessoryCard.style.display = 'block';
                    // Focus on the first input field of the accessory form
                    document.getElementById('modelNumber').focus();
                } else {
                    accessoryCard.style.display = 'none';
                }

            if (categorySelect.value === '{{ \App\Enums\ProductCategoryEnum::EQUIPMENTS }}') {
                equimentCard.style.display = 'block';
                // Focus on the first input field of the accessory form
                document.getElementById('equipment_comission').focus();
            } else {
                equimentCard.style.display = 'none';
            }

            if (categorySelect.value === '{{ \App\Enums\ProductCategoryEnum::SUPPLIMENTS }}') {
                supplimentCard.style.display = 'block';
                // Focus on the first input field of the accessory form
                document.getElementById('comission').focus();
            } else {
                supplimentCard.style.display = 'none';
            }

            if (categorySelect.value === '{{ \App\Enums\ProductCategoryEnum::CLOTHS }}') {
                clothCard.style.display = 'block';
                // Focus on the first input field of the accessory form
                document.getElementById('size').focus();
            } else {
                clothCard.style.display = 'none';
            }
        });
    });

    let selectedFiles = [];

    function handleFiles(files) {
        // Convert FileList to array and add to the selectedFiles array
        selectedFiles = selectedFiles.concat(Array.from(files));
        previewImages();
    }

    function previewImages() {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = ''; // Clear the preview area

        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(event) {
                // Create a container for the image and remove button
                const container = document.createElement('div');
                container.classList.add('image-container');

                // Create the image element
                const img = document.createElement('img');
                img.src = event.target.result;
                img.classList.add('img-thumbnail');

                // Create the remove button
                const removeBtn = document.createElement('span');
                removeBtn.innerHTML = '&times;';
                removeBtn.classList.add('remove-btn');
                removeBtn.onclick = function() {
                    removeImage(index);
                };

                // Append image and remove button to the container
                container.appendChild(img);
                container.appendChild(removeBtn);

                // Append the container to the preview area
                preview.appendChild(container);
            };
            reader.readAsDataURL(file);
        });

        updateInputField();
    }

    function removeImage(index) {
        // Remove the selected image from the array
        selectedFiles.splice(index, 1);
        previewImages();
    }

    function updateInputField() {
        // Create a new DataTransfer object
        const dataTransfer = new DataTransfer();

        // Append all remaining files in selectedFiles to the DataTransfer object
        selectedFiles.forEach(file => {
            dataTransfer.items.add(file);
        });

        // Update the input field's files with the new FileList
        document.getElementById('productImage').files = dataTransfer.files;
    }
</script>



@include('CustomSweetAlert');
@endsection