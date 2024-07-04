@extends('GymOwner.master')
@section('title','Dashboard')
@section('content')

<div class="content-body ">
    <div class="container-fluid">
<div class="page-titles">
<ol class="breadcrumb">
    {{-- <li class="breadcrumb-item"><a href="javascript:void(0)">Layout</a></li> --}}
    <li class="breadcrumb-item active"><a href="javascript:void(0)">Vendor-List</a></li>
</ol>
</div>
<div class="row">
<div class="col-xl-2 col-xxl-3 col-md-4 col-sm-6">
    <div class="card">
        <div class="card-body product-grid-card">
            <div class="new-arrival-product">
                <div class="new-arrivals-img-contnent">
                    <img class="img-fluid rounded" src="https://fito.dexignzone.com/laravel/demo/images/product/1.jpg" alt="">
                </div>
                <div class="new-arrival-content text-center mt-3">
                    <h4>Bowflex</h4>
                    <ul class="star-rating">
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa-solid fa-star-half-stroke"></i></li>
                        <li><i class="fa-solid fa-star-half-stroke"></i></li>
                    </ul>
                    <del class="discount">$159</del>
                    <span class="price">$761.00</span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-xl-2 col-xxl-3 col-md-4 col-sm-6">
    <div class="card">
        <div class="card-body product-grid-card">
            <div class="new-arrival-product">
                <div class="new-arrivals-img-contnent">
                    <img class="img-fluid rounded" src="https://fito.dexignzone.com/laravel/demo/images/product/2.jpg" alt="">
                </div>
                <div class="new-arrival-content text-center mt-3">
                    <h4>Rogue</h4>
                    <ul class="star-rating">
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                    </ul>
                    <del class="discount">$159</del>
                    <span class="price">$159.00</span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-xl-2 col-xxl-3 col-md-4 col-sm-6">
    <div class="card">
        <div class="card-body product-grid-card">
            <div class="new-arrival-product">
                <div class="new-arrivals-img-contnent">
                    <img class="img-fluid rounded" src="https://fito.dexignzone.com/laravel/demo/images/product/3.jpg" alt="">
                </div>
                <div class="new-arrival-content text-center mt-3">
                    <h4>Amazon Neoprene</h4>
                    <ul class="star-rating">
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                    </ul>
                    <del class="discount">$159</del>
                    <span class="price">$357.00</span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-xl-2 col-xxl-3 col-md-4 col-sm-6">
    <div class="card">
        <div class="card-body product-grid-card">
            <div class="new-arrival-product">
                <div class="new-arrivals-img-contnent">
                    <img class="img-fluid rounded" src="https://fito.dexignzone.com/laravel/demo/images/product/3.jpg" alt="">
                </div>
                <div class="new-arrival-content text-center mt-3">
                    <h4>Amazon Neoprene</h4>
                    <ul class="star-rating">
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                    </ul>
                    <del class="discount">$159</del>
                    <span class="price">$357.00</span>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
</div>
</div>





@endsection
