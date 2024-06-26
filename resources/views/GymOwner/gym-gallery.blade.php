@extends('GymOwner.master')
@section('title','GYM Gallery')
@section('content')

<!--**********************************
            Content body start
        ***********************************-->
<div class="content-body ">
	<div class="container-fluid">
		<div class="page-titles">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="javascript:void(0)"> Plugins</a></li>
				<li class="breadcrumb-item active"><a href="javascript:void(0)">Light Gallery</a></li>
			</ol>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header">
						<h4 class="card-title">Light Gallery</h4>
					</div>
					<div class="card-body pb-1">
						<div id="lightgallery" class="row">
							<a href="{{asset('images/big/img1.jpg" data-exthumbimage="https://fito.dexignzone.com/laravel/demo/images/big/img1.jpg')}}" data-src="https://fito.dexignzone.com/laravel/demo/images/big/img1.jpg" class="col-lg-3 col-md-6 mb-4">
								<img src="{{asset('images/big/img1.jpg')}}" class="rounded" alt="" style="width:100%;">
							</a>
							<a href="{{asset('images/big/img2.jpg')}}" data-exthumbimage="https://fito.dexignzone.com/laravel/demo/images/big/img2.jpg" data-src="https://fito.dexignzone.com/laravel/demo/images/big/img2.jpg" class="col-lg-3 col-md-6 mb-4">
								<img src="public/images/big/img2.jpg" class="rounded" alt="" style="width:100%;">
							</a>
							<a href="{{asset('images/big/img3.jpg')}}" data-exthumbimage="https://fito.dexignzone.com/laravel/demo/images/big/img3.jpg" data-src="https://fito.dexignzone.com/laravel/demo/images/big/img3.jpg" class="col-lg-3 col-md-6 mb-4">
								<img src="public/images/big/img3.jpg" class="rounded" alt="" style="width:100%;">
							</a>
							<a href="public/images/big/img4.jpg" data-exthumbimage="https://fito.dexignzone.com/laravel/demo/images/big/img4.jpg" data-src="https://fito.dexignzone.com/laravel/demo/images/big/img4.jpg" class="col-lg-3 col-md-6 mb-4">
								<img src="{{asset('images/big/img4.jpg')}}" class="rounded" alt="" style="width:100%;">
							</a>
							<a href="public/images/big/img5.jpg" data-exthumbimage="https://fito.dexignzone.com/laravel/demo/images/big/img5.jpg" data-src="https://fito.dexignzone.com/laravel/demo/images/big/img5.jpg" class="col-lg-3 col-md-6 mb-4">
								<img src="{{asset('images/big/img5.jpg')}}" class="rounded" alt="" style="width:100%;">
							</a>
							<a href="public/images/big/img6.jpg" data-exthumbimage="https://fito.dexignzone.com/laravel/demo/images/big/img6.jpg" data-src="https://fito.dexignzone.com/laravel/demo/images/big/img6.jpg" class="col-lg-3 col-md-6 mb-4">
								<img src="public/images/big/img6.jpg" class="rounded" alt="" style="width:100%;">
							</a>
							<a href="public/images/big/img7.jpg" data-exthumbimage="https://fito.dexignzone.com/laravel/demo/images/big/img7.jpg" data-src="https://fito.dexignzone.com/laravel/demo/images/big/img7.jpg" class="col-lg-3 col-md-6 mb-4">
								<img src="public/images/big/img7.jpg" class="rounded" alt="" style="width:100%;">
							</a>
							<a href="public/images/big/img8.jpg" data-exthumbimage="https://fito.dexignzone.com/laravel/demo/images/big/img8.jpg" data-src="https://fito.dexignzone.com/laravel/demo/images/big/img8.jpg" class="col-lg-3 col-md-6 mb-4">
								<img src="public/images/big/img8.jpg" class="rounded" alt="" style="width:100%;">
							</a>
						</div>
					</div>
				</div>
				<!-- /# card -->
			</div>
		</div>
	</div>
</div>
<!--**********************************
            Content body end
        ***********************************-->
@endsection