@extends('GymOwner.master')
@section('title', 'Dashboard')
@section('content')
<style>
    .gallery-item {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
        /* Rounded corners for a modern look */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        /* Smooth transitions */
    }

    .gallery-item img,
    .gallery-item iframe {
        display: block;
        width: 100%;
        height: auto;
        transition: opacity 0.3s ease;
        border-radius: 8px;
        /* Rounded corners for images and videos */
    }

    .gallery-item:hover {
        transform: scale(1.05);
        /* Slight zoom effect on hover */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        /* Subtle shadow for depth */
    }

    .gallery-item:hover img,
    .gallery-item:hover iframe {
        opacity: 0.7;
        /* Fade effect on hover */
    }

    .delete-btn {
        display: none;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: rgba(255, 0, 0, 0.8);
        /* Slightly darker background for visibility */
        border: none;
        border-radius: 50%;
        cursor: pointer;
        font-size: 2rem;
        color: white;
        padding: 0.5rem;
        text-align: center;
        z-index: 10;
        transition: background 0.3s ease;
        /* Smooth background transition */
    }

    .gallery-item:hover .delete-btn {
        display: block;
        /* Show delete button on hover */
    }

    .delete-btn:hover {
        background: rgba(255, 0, 0, 1);
        /* Darker red on hover */
    }

    .position-relative {
        position: relative;
    }

    .remove-btn {
        position: absolute;
        top: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.5);
        /* Optional: dark background for better visibility */
        color: white;
        border: none;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 18px;
        z-index: 10;
        /* Ensure the button is above other elements */
    }

    .remove-btn:hover {
        background: rgba(0, 0, 0, 0.7);
        /* Optional: slightly darker on hover */
    }
</style>

<div class="content-body ">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                {{-- <li class="breadcrumb-item"><a href="javascript:void(0)"> Plugins</a></li> --}}
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Gallery</a></li>
            </ol>
        </div>
        <div class="row">
            <div class="modal fade" id="addimage" tabindex="-1" aria-labelledby="addimageLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addimageLabel">Add New Images/Videos</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('addGymGallery') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="upload_file">Upload Images/Videos</label>
                                    <input type="file" class="form-control" id="upload_file" name="upload_file[]"
                                        multiple required>
                                    <div class="invalid-feedback">At least one file is required.</div>
                                </div>
                                <div id="preview-container" class="mt-3 row">
                                    <!-- Previews will be inserted here -->
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Gallery</h4>
                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addimage"
                            class="btn btn-outline-primary rounded">Add New Image/Video</a>
                    </div>

                    <div class="card-body pb-1">
                        <div id="lightgallery" class="row">
                            @foreach($gymGalleryFiles as $file)
                                <div class="col-lg-3 col-md-6 mb-4 gallery-item" data-id="{{ $file->id }}">
                                    @if($file->file_type == 'image')
                                        <a href="{{$file->file_path}}" data-exthumbimage="{{$file->upload_file}}"
                                            data-src="{{$file->upload_file}}">
                                            <img src="{{ asset($file->upload_file) }}" class="rounded img-fluid" alt="">
                                        </a>
                                    @elseif($file->file_type == 'video')
                                        <a href="{{$file->upload_file}}"
                                            data-exthumbimage="https://fito.dexignzone.com/laravel/demo/images/big/img1.jpg"
                                            data-src="https://fito.dexignzone.com/laravel/demo/images/big/img1.jpg">
                                            <iframe src="{{ asset($file->upload_file) }}" style="width: 100%; height: auto;"
                                                frameborder="0" allowfullscreen></iframe>
                                        </a>
                                    @endif
                                    <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $file->id }}"
                                        aria-label="Delete">
                                        <i class="fas fa-trash-alt"></i> <!-- Font Awesome trash icon -->
                                    </button>
                                </div>
                            @endforeach
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
        const uploadFileInput = document.getElementById('upload_file');
        const previewContainer = document.getElementById('preview-container');
        let selectedFiles = []; // Array to store file objects

        function updateFileInput() {
            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => dataTransfer.items.add(file));
            uploadFileInput.files = dataTransfer.files;
        }

        function previewImages() {
            previewContainer.innerHTML = '';
            selectedFiles.forEach((file, index) => {
                const fileURL = URL.createObjectURL(file);
                const fileType = file.type.split('/')[0];

                let previewElement;
                let colDiv = document.createElement('div');
                colDiv.className = 'col-lg-3 col-md-4 col-sm-6 mb-3 position-relative'; // Adjust column sizes

                if (fileType === 'image') {
                    previewElement = document.createElement('img');
                    previewElement.src = fileURL;
                    previewElement.className = 'img-fluid';
                } else if (fileType === 'video') {
                    previewElement = document.createElement('video');
                    previewElement.src = fileURL;
                    previewElement.controls = true;
                    previewElement.className = 'img-fluid';
                }

                if (previewElement) {
                    colDiv.appendChild(previewElement);

                    // Create and add a close button
                    const closeButton = document.createElement('span');
                    closeButton.innerHTML = '&times;';
                    closeButton.classList.add('remove-btn');
                    closeButton.onclick = function () {
                        removeImage(index);
                    };

                    colDiv.appendChild(closeButton);
                    previewContainer.appendChild(colDiv);
                }
            });

            updateFileInput();
        }

        function removeImage(index) {
            // Remove the selected file from the array
            selectedFiles.splice(index, 1);
            previewImages(); // Update the preview and file input
        }

        uploadFileInput.addEventListener('change', function (event) {
            const newFiles = Array.from(event.target.files);
            selectedFiles = [...selectedFiles, ...newFiles]; // Add new files to the selected files array
            previewImages(); // Update the preview
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function () {
                const itemId = this.getAttribute('data-id');

                // Use SweetAlert2 for confirmation
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You will not be able to recover this item!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (result.isConfirmed) {
                            window.location.href = '/delete-gallery/' + itemId;
                        }
                    }
                });
            });
        });
    });

</script>


@include('CustomSweetAlert');
@endsection