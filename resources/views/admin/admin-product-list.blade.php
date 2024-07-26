@extends('admin.master')
@section('title','Dashboard')
@section('content')

<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Product List</a></li>
            </ol>
        </div>
        <div class="row">
            @foreach ($products as $product)
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="new-arrival-product mb-4">
                                    <div class="new-arrivals-img-contnent">
                                        <img class="img-fluid rounded" src="{{ asset($product->image) }}" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="new-arrival-content position-relative">
                                    <h4><a href="https://fito.dexignzone.com/laravel/demo/ecom-product-detail">{{ $product->product_name }}</a></h4>
                                    <div class="comment-review star-rating">
                                        <ul>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star-half-stroke"></i></li>
                                            <li><i class="fa fa-star-half-stroke"></i></li>
                                        </ul>
                                        <span class="review-text">(34 reviews) / </span><a class="product-review" href="" data-bs-toggle="modal" data-bs-target="#reviewModal">Write a review?</a>
                                        <p class="price">$320.00</p>
                                    </div>
                                    <p>Availability: <span class="item"> In stock <i class="fa fa-check-circle text-success"></i></span></p>
                                    <p>Product code: <span class="item">{{ $product->product_code }}</span> </p>
                                    <p>Brand: <span class="item">{{ $product->product_brand }}</span></p>
                                    <p class="text-content">{{ $product->description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- review -->
        <div class="modal fade" id="reviewModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Review</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="text-center mb-4">
                                <img class="img-fluid rounded" width="78" src="./https://fito.dexignzone.com/laravel/demo/images/avatar/1.jpg" alt="DexignZone">
                            </div>
                            <div class="mb-3">
                                <div class="rating-widget mb-4 text-center">
                                    <!-- Rating Stars Box -->
                                    <div class="rating-stars">
                                        <ul id="stars">
                                            <li class="star" title="Poor" data-value="1">
                                                <i class="fa fa-star fa-fw"></i>
                                            </li>
                                            <li class="star" title="Fair" data-value="2">
                                                <i class="fa fa-star fa-fw"></i>
                                            </li>
                                            <li class="star" title="Good" data-value="3">
                                                <i class="fa fa-star fa-fw"></i>
                                            </li>
                                            <li class="star" title="Excellent" data-value="4">
                                                <i class="fa fa-star fa-fw"></i>
                                            </li>
                                            <li class="star" title="WOW!!!" data-value="5">
                                                <i class="fa fa-star fa-fw"></i>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" placeholder="Comment" rows="5"></textarea>
                            </div>
                            <button class="btn btn-success btn-block">RATE</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
