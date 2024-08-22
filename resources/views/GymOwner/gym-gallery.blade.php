@extends('GymOwner.master')
@section('title', 'Dashboard')
@section('content')
<div class="content-body ">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                {{-- <li class="breadcrumb-item"><a href="javascript:void(0)"> Plugins</a></li> --}}
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Gallery</a></li>
            </ol>
        </div>
        <div class="row">
            <div class="modal fade" id="addimage">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add New Plan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{route('addGymGallery')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Upload Image/Video</label>
                                    <input type="file" class="form-control" id="upload_file" name="upload_file" required="">
                                    <div class="invalid-feedback">Gym Image is required.</div>
                                </div>
                                <button class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Gallery</h4>
                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addimage" class="btn btn-outline-primary rounded">Add New Image/Video</a>
                    </div>

                    <div class="card-body pb-1">
                        <div id="lightgallery" class="row">

                            @foreach($gymGalleryFiles as $file)

                            @if($file->file_type == 'image')
                            <a href="{{$file->file_path}}" data-exthumbimage="{{$file->upload_file}}" data-src="{{$file->upload_file}}" class="col-lg-3 col-md-6 mb-4">
                                <img src="{{ asset($file->upload_file) }}" class="rounded" alt="" style="width:100%;">
                            </a>
                            @elseif($file->file_type == 'video')
                            <a href="{{$file->upload_file}}" data-exthumbimage="https://fito.dexignzone.com/laravel/demo/images/big/img1.jpg" data-src="https://fito.dexignzone.com/laravel/demo/images/big/img1.jpg" class="col-lg-3 col-md-6 mb-4">
                                <iframe src="{{ asset($file->upload_file) }}" style="width: 100%; height: auto;" frameborder="0" allowfullscreen></iframe>
                            </a>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- /# card -->
            </div>
        </div>
    </div>
</div>
@include('CustomSweetAlert');
@endsection