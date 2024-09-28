@extends('GymOwner.master')
@section('title', 'Maintenance Vendor')
@section('content')

<!--**********************************
            Content body start
***********************************-->
<div class="modal fade" id="editVendor">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Vendor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('updateMaintenanceVendor')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="uuid" id="editVendId">
                    <div class="form-group">
                        <label>Vendor Image</label>
                        <input type="file" id="editImage" name="image" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Vendor Full Name</label>
                        <input type="text" id="editName" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Phone No</label>
                        <input type="text" name="phone_no" id="editPhone" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Occupation</label>
                        <input type="text" name="occupation" id="editOccupation" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <textarea type="text" rows="10" name="address" id="editAddress" class="form-control" required></textarea>
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
                            <form method="POST" action="{{ route('addMaintenanceVendor') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Vendor Image</label>
                                    <input type="file" id="image" name="image" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Vendor Full Name</label>
                                    <input type="text" id="name" name="name" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Phone No</label>
                                    <input type="text" name="phone_no" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Occupation</label>
                                    <input type="text" name="occupation" class="form-control" required />
                                </div>

                                <div class="form-group">
                                    <label>Address</label>
                                    <textarea type="text" rows="10" name="address" class="form-control" required></textarea>
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
                                    <h4 class="text-black fs-20">Maintenance Vendor List</h4>
                                </div>

                                <div class="dropdown mt-sm-0 mt-3">
                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addNewPlan" class="btn btn-outline-primary rounded">Add New Vendor</a>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example3" class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                        <thead>
                                            <tr>
                                                <th scope="col">Image</th>
                                                <th scope="col">Full Name</th>
                                                <th scope="col">Phone No</th>
                                                <th scope="col">Occupation</th>
                                                <th scope="col" class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($vendors as $vendor)
                                            <tr>
                                                <td>
                                                    <a href="#">
                                                        <div class="media d-flex align-items-center">
                                                            <div class="avatar avatar-xl me-2">
                                                                <div class=""><img class="rounded-circle img-fluid" src="{{ $vendor->image }}" style="height: 50px;width: 50px;" alt="image">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>{{ $vendor->name}}</td>
                                                <td>{{ $vendor->phone_no }}</td>
                                                <td>{{ $vendor->occupation}}</td>
                                                <td class="text-end">
                                                    <span>
                                                        <a href="javascript:void(0);" class="me-4 edit-vendor-button" data-bs-toggle="modal" data-bs-target="#editVendor" data-vendor='@json($vendor)'>
                                                            <i class="fa fa-pencil color-muted"></i>
                                                        </a>
                                                        <a onclick="confirmDelete('{{ $vendor->uuid }}')" data-bs-toggle="tooltip" data-placement="top" title="Close">
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
    document.addEventListener('DOMContentLoaded', function() {
        var editButtons = document.querySelectorAll('.edit-vendor-button');

        editButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var vendor = JSON.parse(this.dataset.vendor);

                document.getElementById('editVendId').value = vendor.uuid;
                document.getElementById('editName').value = vendor.name;
                document.getElementById('editOccupation').value = vendor.occupation;
                document.getElementById('editPhone').value = vendor.phone_no;
                document.getElementById('editAddress').value = vendor.address;
            });
        });

        const deleteButtons = document.querySelectorAll('.btn-delete');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const uuid = this.getAttribute('data-uuid');
                if (confirm('Are you sure you want to delete this vendor?')) {
                    document.getElementById('delete-form-' + uuid).submit();
                }
            });
        });
    });

    function confirmDelete(uuid) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Are you sure you want to delete this vendor?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/list-vendor';
            }
        });
    }
</script>
@include('CustomSweetAlert');
@endsection