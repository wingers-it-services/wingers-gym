@extends('GymOwner.master')
@section('title','Designation')

@section('content')

<!--**********************************
            Content body start
***********************************-->
<div class="content-body ">
    <!-- row -->
    <div class="container-fluid">
        <div class="row">
            <!-- Modal -->
            <div class="modal fade" id="addNewDesignation">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add New Designation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="">
                                @csrf
                                <div class="form-group">
                                    <label>Coupon Code</label>
                                    <input type="text" id="designation_name" name="designation_name" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Start Date</label>
                                    <input type="text" id="start_date" name="start_date" class="form-control datepicker" required>
                                </div>
                                <div class="form-group">
                                    <label>End Date</label>
                                    <input type="text" id="end_date" name="end_date" class="form-control datepicker" required>
                                </div>
                                <button class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-12 col-xxl-12">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card plan-list">
                            <div class="card-header d-sm-flex d-block pb-0 border-0">
                                <div class="me-auto pe-3">
                                    <h4 class="text-black fs-20">Coupon List</h4>
                                    <p class="fs-13 mb-0 text-black">Lorem ipsum dolor sit amet, consectetur</p>
                                </div>

                                <div class="dropdown mt-sm-0 mt-3">
                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addNewDesignation" class="btn btn-outline-primary rounded">Add New Designation</a>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="d-flex px-3 pt-3 list-row flex-wrap align-items-center mb-2">
                                    <div class="info mb-3">
                                        <h4 class="fs-20 ">Muskan</h4>
                                    </div>
                                    <div class="d-flex mb-3 me-auto ps-3 pe-3 align-items-center">
                                        <span class="text-primary font-w600"> Active</span>
                                    </div>
                                    <div class="dropdown mb-3">
                                        <button type="button" class="btn rounded border-light" data-bs-toggle="dropdown" aria-expanded="false">
                                            <svg width="6" height="26" viewBox="0 0 6 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6 3C6 4.65685 4.65685 6 3 6C1.34315 6 0 4.65685 0 3C0 1.34315 1.34315 0 3 0C4.65685 0 6 1.34315 6 3Z" fill="#585858" />
                                                <path d="M6 13C6 14.6569 4.65685 16 3 16C1.34315 16 0 14.6569 0 13C0 11.3431 1.34315 10 3 10C4.65685 10 6 11.3431 6 13Z" fill="#585858" />
                                                <path d="M6 23C6 24.6569 4.65685 26 3 26C1.34315 26 0 24.6569 0 23C0 21.3431 1.34315 20 3 20C4.65685 20 6 21.3431 6 23Z" fill="#585858" />
                                            </svg>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="javascript:void(0);">Deactivate</a>
                                            <a class="dropdown-item" href="javascript:void(0);">Activate</a>
                                            <a class="dropdown-item" href="javascript:void(0);">Edit</a>
                                            <a class="dropdown-item" href="">Delete</a>
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
</div>

<!-- Include jQuery and jQuery UI -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<script>
    $(document).ready(function() {
        $(".datepicker").datepicker({
            dateFormat: "yy-mm-dd"
        });
    });
</script>

@endsection
