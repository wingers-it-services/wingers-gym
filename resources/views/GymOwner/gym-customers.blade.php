@extends('GymOwner.master')
@section('title', 'Member List')
@section('content')

<div class="content-body ">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Customers List</a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="table table-sm mb-0 table-striped">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Joined</th>
                                        <th>View</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="customers">
                                    @foreach ($users as $user)
                                    <tr class="btn-reveal-trigger">
                                        <td class="py-2">{{ $user->id }}</td>
                                        <td>
                                            <div class="media d-flex align-items-center">
                                                <div class="avatar avatar-xl me-2">
                                                    <div class=""><img class="rounded-circle img-fluid" src="{{ $user->image }}" style="height: 50px; width: 50px;" alt="image">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-2">{{ $user->firstname . ' ' . $user->lastname }}</td>
                                        <td class="py-2">{{ $user->email }}</td>
                                        <td class="py-2">{{ $user->phone_no }}</td>
                                        <td class="py-2">{{ \Carbon\Carbon::parse($user->joining_date)->format('jS M Y') }}</td>
                                        <td>
                                            <a class="dropdown-item" href="{{ route('showUserProfile', ['uuid' => $user->uuid]) }}">
                                                <i class="fa fa-pencil color-muted"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="/update-gym-user/{{ $user->uuid }}" data-bs-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="fa fa-eye color-muted"></i>
                                            </a>
                                            &nbsp; &nbsp;
                                            <a onclick="confirmDelete('{{ $user->uuid }}')" data-bs-toggle="tooltip" data-placement="top" title="Close">
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


<script>
    function confirmDelete(uuid) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Are you sure you want to delete this user?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/delete-user/' + uuid;
            }
        });
    }
</script>
@include('CustomSweetAlert');
@endsection
