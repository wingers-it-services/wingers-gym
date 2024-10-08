@extends('GymOwner.master')
@section('title','Enquiry')
@section('content')

<!-- Bootstrap CSS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Enquiry</a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="email-left-box generic-width px-0 mb-5" style="width: max-content;">
                            <div class="mail-list rounded mt-4">
                                @foreach($inquiries as $inquiry)
                                <a href="javascript:void(0)" class="list-group-item inquiry-item" data-id="{{$inquiry->id}}">
                                    <div class="row">
                                        <div class="col-3">
                                            <img class="me-2 rounded" width="50" alt="image" src="{{$inquiry->user->image}}">
                                        </div>
                                        <div class="col-9">
                                            <span class="font-18 align-middle me-2">Name:{{$inquiry->user->firstname}} </span></br>
                                            <span class="font-18 align-middle me-2">Date:{{$inquiry->created_at->format('d M Y')}} </span></br>
                                            <span class="font-18 align-middle me-2">Status:{{$inquiry->reason}} </span>
                                           <!-- <span class="badge badge-secondary badge-sm float-end">198</span> -->
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        </div>
                        <div class="email-right-box ms-0 ms-sm-4 ms-sm-0">
                            <div class="row">
                                <div class="col-12">
                                    <div class="right-box-padding" id="inquiry-details">
                                        <!-- Inquiry details will be dynamically loaded here -->
                                        <p>Select an inquiry to see details.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Handle inquiry click
        $('.inquiry-item').on('click', function() {
            var inquiryId = $(this).data('id');

            // Make an AJAX call to fetch inquiry details
            $.ajax({
                url: '{{ route("inquiry.details") }}', // Adjust the route as per your routing setup
                method: 'GET',
                data: {
                    id: inquiryId
                },
                success: function(response) {
                    // Populate the inquiry details in the right box
                    $('#inquiry-details').html(`
                    <div class="read-content">
                        <div class="media pt-3">
                            <img class="me-2 rounded" width="50" alt="image" src="${response.image}">
                            <div class="media-body me-2">
                                <h5 class="text-primary mb-0 mt-1">${response.name}</h5>
                                <p class="mb-0">${response.date}</p>
                            </div>
                            <a href="javascript:void(0)" class="btn btn-primary px-3 light" data-toggle="modal" data-target="#replyModal">
                                <i class="fa fa-reply"></i>
                            </a>
                            <a href="javascript:void(0)" class="btn btn-primary px-3 light ms-2"><i class="fa fa-trash"></i></a>
                        </div>
                        <hr>
                        <h5 class="mb-4">Hi, ${response.name},</h5>
                        <p class="mb-2">${response.message}</p>
                        <hr>
                    </div>
                `);
                }
            });
        });
    });
</script>

@endsection