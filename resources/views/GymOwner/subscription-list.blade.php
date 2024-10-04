@extends('GymOwner.master')
@section('title', 'Subscription Plans')
@section('content')

<!--**********************************
            Content body start
***********************************-->
<div class="modal fade" id="editSuscription">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Plan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <form id="updatePlan" class="needs-validation" method="POST" action="/update-gym-subscription" novalidate>
                    @csrf
                    <input type="hidden" name="uuid" id="editSubId">
                    <div class="form-group">
                        <label>Subscription Name</label>
                        <input type="text" id="editName" name="subscription_name" class="form-control" required>
                        <div class="invalid-feedback">
                            Subscription Name is required.
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Validity (in months)</label>
                        <input type="number" name="validity" id="editValidity" min="0" max="1000" class="form-control"
                            required>
                        <div class="invalid-feedback">
                            Validity (Min 1 month) is required and must be between 1 and 12.
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Subscription Price</label>
                        <input type="number" name="amount" id="editPrice" class="form-control" name="" min="0"
                            required />
                        <div class="invalid-feedback">
                            Subscription Price is required.
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Plan Start Date</label>
                        <input type="date" name="start_date" id="editStartDate" class="form-control" required>
                        <div class="invalid-feedback">
                            Subscription Start Date is required.
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Plan Description</label>
                        <textarea type="text" rows="10" name="description" id="editDescription" class="form-control"
                            required></textarea>
                        <div class="invalid-feedback">
                            Subscription Description is required.
                        </div>
                    </div>
                    <button class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>

</div>
<div class="content-body ">
    <!-- row -->
    <div class="container-fluid">
        <div class="row">
            <!-- Modal -->
            <div class="modal fade" id="addNewPlan">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add New Plan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="/gym-subscription" class="needs-validation" novalidate>
                                @csrf
                                <div class="form-group">
                                    <label>Subscription Name</label>
                                    <input type="text" id="subscription_name" name="subscription_name"
                                        class="form-control" required>
                                    <div class="invalid-feedback">
                                        Subscription Name is required.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Validity (in months)</label>
                                    <input type="number" name="validity" min="1" max="12" class="form-control" required>
                                    <div class="invalid-feedback">
                                        Validity (Min 1 month) is required and must be between 1 and 12.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Subscription Price</label>
                                    <input type="number" name="amount" class="form-control" min="0" required />
                                    <div class="invalid-feedback">
                                        Subscription Price is required.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Plan Start Date</label>
                                    <input type="date" name="start_date" class="form-control" required>
                                    <div class="invalid-feedback">
                                        Subscription Start Date is required.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Subscription Description</label>
                                    <textarea type="text" rows="10" name="description" class="form-control"
                                        required></textarea>
                                    <div class="invalid-feedback">
                                        Subscription Description is required.
                                    </div>
                                </div>

                                <button class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-xl-12 col-xxl-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-sm-flex d-block pb-0 border-0">
                                <div class="me-auto pe-3">
                                    <h4 class="text-black fs-20">Subscriptions Plan List</h4>
                                </div>

                                <div class="dropdown mt-sm-0 mt-3">
                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addNewPlan"
                                        class="btn btn-outline-primary rounded">Add New Subscription</a>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example3"
                                        class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                        <thead>
                                            <tr>
                                                <th scope="col">Plan</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Validity</th>
                                                <th scope="col">Start Date</th>
                                                <th scope="col">Purchased</th>
                                                <th scope="col" class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($subscriptionDetails as $data)
                                                <tr>
                                                    <td>{{ $data['subscription']->subscription_name }}</td>
                                                    <td>{{ $data['subscription']->amount }}</td>
                                                    <td>{{ $data['subscription']->validity }} Months</td>
                                                    <td>{{ \Carbon\Carbon::parse($data['subscription']->start_date)->format('M d, Y') }}
                                                    </td>
                                                    <td><span class="badge badge-warning">{{ $data['percentage'] }}%</span>
                                                    </td>
                                                    <td class="text-end">
                                                        <span>
                                                            <a href="javascript:void(0);" class="me-4 edit-book-button"
                                                                data-bs-toggle="modal" data-bs-target="#editSuscription"
                                                                data-book='@json($data['subscription'])'>
                                                                <i class="fa fa-pencil color-muted"></i>
                                                            </a>
                                                            <a onclick="confirmDelete('{{ $data['subscription']->uuid }}')"
                                                                data-bs-toggle="tooltip" data-placement="top" title="Close">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        </span>
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




<script>
    (function () {
        'use strict';
        var forms = document.querySelectorAll('.needs-validation');

        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                // Check form validity
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.classList.add('was-validated');
            }, false);
        });
    })();

    document.addEventListener('DOMContentLoaded', function () {
        var editButtons = document.querySelectorAll('.edit-book-button');

        editButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var user = JSON.parse(this.dataset.book);

                document.getElementById('editSubId').value = user.uuid;
                document.getElementById('editName').value = user.subscription_name;
                document.getElementById('editPrice').value = user.amount;
                document.getElementById('editValidity').value = user.validity;
                document.getElementById('editDescription').value = user.description;
                document.getElementById('editStartDate').value = user.start_date;
            });
        });

        const deleteButtons = document.querySelectorAll('.btn-delete');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const uuid = this.getAttribute('data-uuid');
                if (confirm('Are you sure you want to delete this subscription?')) {
                    document.getElementById('delete-form-' + uuid).submit();
                }
            });
        });
    });

    document.getElementById('addNewPlan').addEventListener('submit', function (e) {
        const validity = document.getElementById('validity');
        const amount = document.getElementById('amount');
        const startDate = document.getElementById('start_date');
        let isValid = true;

        // Check if validity is at least 1
        if (validity.value < 1 || validity.value > 12) {
            validity.classList.add('is-invalid');
            isValid = false;
        } else {
            validity.classList.remove('is-invalid');
        }

        // Check if subscription price is positive
        if (amount.value < 1) {
            amount.classList.add('is-invalid');
            isValid = false;
        } else {
            amount.classList.remove('is-invalid');
        }

        // Check if start date is selected
        if (!startDate.value) {
            startDate.classList.add('is-invalid');
            isValid = false;
        } else {
            startDate.classList.remove('is-invalid');
        }

        // Prevent form submission if validation fails
        if (!isValid) {
            e.preventDefault();
        }
    });

    document.getElementById('updatePlan').addEventListener('submit', function (e) {
        const validity = document.getElementById('editValidity');
        const amount = document.getElementById('editPrice');
        const startDate = document.getElementById('editStartDate');
        let isValid = true;

        // Check if validity is at least 1
        if (validity.value < 1 || validity.value > 12) {
            validity.classList.add('is-invalid');
            isValid = false;
        } else {
            validity.classList.remove('is-invalid');
        }

        // Check if subscription price is positive
        if (amount.value < 1) {
            amount.classList.add('is-invalid');
            isValid = false;
        } else {
            amount.classList.remove('is-invalid');
        }

        // Check if start date is selected
        if (!startDate.value) {
            startDate.classList.add('is-invalid');
            isValid = false;
        } else {
            startDate.classList.remove('is-invalid');
        }

        // Prevent form submission if validation fails
        if (!isValid) {
            e.preventDefault();
        }
    });


    function confirmDelete(uuid) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Are you sure you want to delete this subscription? It will delete the related industries.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/delete-subscription/' + uuid;
            }
        });
    }
</script>
@include('CustomSweetAlert');
@endsection