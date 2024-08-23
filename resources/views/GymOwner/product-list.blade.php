@extends('GymOwner.master')
@section('title','Dashboard')
@section('content')

<div class="content-body ">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Product List</a></li>
            </ol>
        </div>
        <nav class="navbar navbar-expand-lg navbar-light bg-primary">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <b>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link category-link" href="#" data-category="all">All</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link category-link" href="#" data-category="equipment">Equipments</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link category-link" href="#" data-category="clothing">Clothing</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link category-link" href="#" data-category="supplements">Supplements</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link category-link" href="#" data-category="accessories">Accessories</a>
                        </li>
                    </ul>
                </b>
            </div>
        </nav>
        <br>
        <div class="row product-list">
            <!-- Products will be dynamically loaded here -->
        </div>

        <!-- review -->
        <div class="modal fade" id="reviewModal">
            <!-- Modal content -->
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const categoryLinks = document.querySelectorAll('.category-link');
        const productList = document.querySelector('.product-list');

        // Static product data for demonstration
        const products = {
            equipment: [{
                    image: "https://fito.dexignzone.com/laravel/demo/images/product/2.jpg",
                    name: "Back Dumbbells",
                    price: "$320.00",
                    availability: "In stock",
                    code: "0405689",
                    brand: "Lee",
                    description: "There are many variations of passages of Lorem Ipsum available..."
                }
                // Add more products as needed
            ],
            clothing: [{
                    image: "https://5.imimg.com/data5/FF/EO/MY-57338483/gym-sports-t-shirt-1000x1000.jpg",
                    name: "Sports T-Shirt",
                    price: "$25.00",
                    availability: "In stock",
                    code: "0101234",
                    brand: "Nike",
                    description: "Comfortable and stylish sports t-shirt for workouts..."
                }
                // Add more products as needed
            ],
            supplements: [{
                image: "https://www.musclenutrition.co.in/assets/gallery/product/001Multivitamin%20(1).jpg",
                name: "Protien Shake",
                price: "$50.00",
                availability: "In stock",
                code: "0101234",
                brand: "Om",
                description: "Comfortable and stylish sports t-shirt for workouts..."
            }],
            accessories: [
                // Product data
            ]
        };

        function renderProducts(category) {
            productList.innerHTML = '';
            const categoryProducts = category === 'all' ? [].concat(...Object.values(products)) : products[category] || [];
            categoryProducts.forEach(product => {
                const productHTML = `
                    <div class="col-lg-12 col-xxl-4 col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row m-b-30">
                                    <div class="col-md-5 col-xxl-12">
                                        <div class="new-arrival-product mb-4 mb-xxl-4 mb-md-0">
                                            <div class="new-arrivals-img-contnent">
                                                <a href="https://fito.dexignzone.com/laravel/demo/ecom-product-detail"><img class="img-fluid rounded" src="${product.image}" alt=""></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7 col-xxl-12">
                                        <div class="new-arrival-content position-relative">
                                            <h4><a href="https://fito.dexignzone.com/laravel/demo/ecom-product-detail">${product.name}</a></h4>
                                            <div class="comment-review star-rating">
                                                <p class="price">${product.price}</p>
                                                <p>Availability: <span class="item">${product.availability} <i class="fa fa-check-circle text-success"></i></span></p>
                                                <p>Product code: <span class="item">${product.code}</span></p>
                                                <p>Brand: <span class="item">${product.brand}</span></p>
                                                <p class="text-content">${product.description}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                productList.insertAdjacentHTML('beforeend', productHTML);
            });
        }

        categoryLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                const category = this.getAttribute('data-category');
                renderProducts(category);
            });
        });

        // Initially render all products
        renderProducts('all');
    });
</script>



@endsection