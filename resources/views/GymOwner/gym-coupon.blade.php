@extends('GymOwner.master')
@section('title', 'Add Coupons')

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
                            <h5 class="modal-title">Add New Coupon</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="needs-validation" method="POST" action="/add-gym-coupon" novalidate>
                                @csrf
                                <input type="text" value="{{ Auth::guard('gym')->user()->id }}" name="gym_id" hidden>
                                <div class="form-group">
                                    <label>Coupon Code</label>
                                    <input type="text" id="coupon_code" name="coupon_code" class="form-control"
                                        required>
                                    <div class="invalid-feedback">Coupon Code is required.</div>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" id="description" name="description"
                                        required></textarea>
                                    <div class="invalid-feedback">Description is required.</div>
                                </div>
                                <div class="form-group">
                                    <label>Discount Type</label>
                                    <select class="form-control" id="discount_type" name="discount_type" required>
                                        <option value="">Select Discount Type</option>
                                        <option value="{{ \App\Enums\GymCouponTypeEnum::PERCENTAGE }}">In Percentage
                                        </option>
                                        <option value="{{ \App\Enums\GymCouponTypeEnum::AMOUNT }}">In Amount</option>

                                    </select>
                                    <div class="invalid-feedback">Discount Type is required.</div>
                                </div>
                                <div class="form-group">
                                    <label>Amount</label>
                                    <input type="number" class="form-control" id="amount" name="amount" required>
                                    <div class="invalid-feedback">Amount (If In Percentage must be between 1 to 100) is
                                        required.</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Start Date</label>
                                            <input type="date" id="start_date" name="start_date"
                                                class="form-control datepicker" required>
                                            <div class="invalid-feedback">Start Date is required.</div>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>End Date</label>
                                            <input type="date" id="end_date" name="end_date"
                                                class="form-control datepicker" required>
                                            <div class="invalid-feedback">End Date is required.</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="status">Select Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="{{ \App\Enums\GymCouponStatusEnum::ACTIVE }}">Active</option>
                                        <option value="{{ \App\Enums\GymCouponStatusEnum::INACTIVE }}">In Active
                                        </option>

                                    </select>
                                    <div class="invalid-feedback">Choose a Status.</div>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Coupon Modal -->
            <div class="modal fade" id="editCouponModal" tabindex="-1" role="dialog"
                aria-labelledby="editCouponModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editCouponModalLabel">Edit Coupon</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                        </div>
                        <div class="modal-body">
                            <form id="editCouponForm" method="POST" action="/update-gym-coupon" novalidate>
                                @csrf
                                <input type="hidden" id="edit_coupon_id" name="coupon_id">

                                <div class="form-group">
                                    <label>Coupon Code</label>
                                    <input type="text" id="edit_coupon_code" name="coupon_code" class="form-control"
                                        required>
                                    <div class="invalid-feedback">Coupon Code is required.</div>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" id="edit_description" name="description"
                                        required></textarea>
                                    <div class="invalid-feedback">Description is required.</div>
                                </div>
                                <div class="form-group">
                                    <label>Discount Type</label>
                                    <select class="form-control" id="edit_discount_type" name="discount_type" required>
                                        <option value="">Select Discount Type</option>
                                        <option value="{{ \App\Enums\GymCouponTypeEnum::PERCENTAGE }}">In Percentage
                                        </option>
                                        <option value="{{ \App\Enums\GymCouponTypeEnum::AMOUNT }}">In Amount</option>

                                    </select>
                                    <div class="invalid-feedback">Discount Type is required.</div>
                                </div>
                                <div class="form-group">
                                    <label>Amount</label>
                                    <input type="number" class="form-control" id="edit_amount" name="amount" required>
                                    <div class="invalid-feedback">Amount (If In Percentage must be between 1 to 100) is
                                        required.</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Start Date</label>
                                            <input type="date" id="edit_start_date" name="start_date"
                                                class="form-control" required>
                                            <div class="invalid-feedback">Start Date is required.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>End Date</label>
                                            <input type="date" id="edit_end_date" name="end_date" class="form-control"
                                                required>
                                            <div class="invalid-feedback">End Date is required.</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="edit_status">Select Status</label>
                                    <select class="form-control" id="edit_status" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="{{ \App\Enums\GymCouponStatusEnum::ACTIVE }}">Active</option>
                                        <option value="{{ \App\Enums\GymCouponStatusEnum::INACTIVE }}">Inactive</option>
                                    </select>
                                    <div class="invalid-feedback">Choose a Status.</div>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
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
                                </div>

                                <div class="dropdown mt-sm-0 mt-3">
                                    <a href="javascript:void(0);" data-bs-toggle="modal"
                                        data-bs-target="#addNewDesignation" class="btn btn-outline-primary rounded">Add
                                        New Coupon</a>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table id="example3"
                                        class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                        <thead>
                                            <tr>
                                                <th scope="col">Coupon Code</th>
                                                <th scope="col">Discount Type</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Start Date</th>
                                                <th scope="col">End Date</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($coupons as $coupon)
                                                <tr>
                                                    <td>{{ $coupon->coupon_code }}</td>
                                                    <td>{{ $coupon->discount_type == \App\Enums\GymCouponTypeEnum::PERCENTAGE ? 'In Percentage' : 'In Amount' }}</td>
                                                    <td>{{ $coupon->amount }}</td>
                                                    <td>{{ $coupon->start_date }}</td>
                                                    <td>{{ $coupon->end_date }}</td>
                                                    <td>{{ $coupon->status == \App\Enums\GymCouponStatusEnum::ACTIVE ? 'Active' : 'Inactive' }}
                                                    </td>
                                                    <td>
                                                        <a href="javascript:void(0);" class="edit-coupon"
                                                            data-coupon='@json($coupon)' data-bs-toggle="tooltip"
                                                            title="Edit">
                                                            <i class="fa fa-pencil color-muted"></i>
                                                        </a>
                                                        &nbsp;&nbsp;
                                                        <a onclick="confirmDelete('{{ $coupon->uuid }}')"
                                                            data-bs-toggle="tooltip" data-placement="top" title="Close">
                                                            <i class="fas fa-trash"> </i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
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

    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')

        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    })()

    $(document).ready(function () {
        $(".datepicker").datepicker({
            dateFormat: "yy-mm-dd"
        });
    });

    $(document).ready(function () {
        // When the edit button is clicked
        $('.edit-coupon').on('click', function () {
            var coupon = $(this).data('coupon'); // Get coupon details from the clicked button's data attributes

            // Populate the modal fields
            $('#edit_coupon_id').val(coupon.id);
            $('#edit_coupon_code').val(coupon.coupon_code);
            $('#edit_description').val(coupon.description);
            $('#edit_discount_type').val(coupon.discount_type);
            $('#edit_start_date').val(coupon.start_date);
            $('#edit_end_date').val(coupon.end_date);
            $('#edit_status').val(coupon.status);
            $('#edit_amount').val(coupon.amount);

            // Show the modal
            $('#editCouponModal').modal('show');
        });
    });

    document.getElementById('discount_type').addEventListener('change', function () {
        const amountField = document.getElementById('amount');
        if (this.value === '{{ \App\Enums\GymCouponTypeEnum::PERCENTAGE }}') {
            // When "Percentage" is selected, restrict the amount between 1 and 100
            amountField.setAttribute('min', 1);
            amountField.setAttribute('max', 100);
            amountField.setAttribute('placeholder', 'Enter a value between 1 and 100');
        } else if (this.value === '{{ \App\Enums\GymCouponTypeEnum::AMOUNT }}') {
            // When "Amount" is selected, remove restrictions on the amount
            amountField.removeAttribute('min');
            amountField.removeAttribute('max');
            amountField.setAttribute('placeholder', 'Enter any amount');
        }
    });

    function confirmDelete(uuid) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Are you sure you want to delete this coupon?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/delete-gym-coupon/' + uuid;
            }
        });
    }
</script>
@include('CustomSweetAlert');
@endsection