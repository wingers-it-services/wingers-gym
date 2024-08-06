@extends('GymOwner.master')
@section('title', 'Dashboard')
@section('content')

<div class="content-body ">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                {{-- <li class="breadcrumb-item"><a href="javascript:void(0)">Shop</a></li> --}}
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
                                        <th>Member id</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th class="ps-5 width200">Address</th>
                                        <th>Joined</th> 
                                        <th>View</th> 
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="customers">
                                    @foreach ($users as $user)
                                    <tr class="btn-reveal-trigger">
                                        <td class="py-2">{{ $user->id }}</td>
                                        <td class="py-2">{{ $user->firstname . ' ' . $user->lastname }}</td>
                                        <td class="py-2">{{ $user->email }}</td>
                                        <td class="py-2">{{ $user->member_number }}</td>
                                        <td class="py-2">{{ $user->address }}</td>
                                        <td class="py-2">{{ $user->joining_date }}</td>
                                        <!-- <td class="py-2 text-end"> -->
                                        <!-- <div class="dropdown"><button class="btn btn-primary tp-btn-light sharp" type="button" data-bs-toggle="dropdown"><span class="fs--1"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24">
                                                                </rect>
                                                                <circle fill="#000000" cx="5" cy="12" r="2"></circle>
                                                                <circle fill="#000000" cx="12" cy="12" r="2"></circle>
                                                                <circle fill="#000000" cx="19" cy="12" r="2"></circle>
                                                            </g>
                                                        </svg></span></button>
                                                <div class="dropdown-menu dropdown-menu-end border py-0">
                                                    <div class="py-2"><a class="dropdown-item" id="editUser">Edit</a><a class="dropdown-item" id="deleteUser">Delete</a>
                                                        <a class="dropdown-item" href={{ route('showUserProfile', ['uuid' => $user->uuid]) }}>View</a>
                                                    </div>
                                                </div>
                                            </div> -->
                                        <td>
                                            <a class="dropdown-item" href="{{ route('showUserProfile', ['uuid' => $user->uuid]) }}">
                                                <i class="fa fa-eye color-muted"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="javascript:void(0);" class="me-4 edit-book-button" data-bs-toggle="modal" data-bs-target="#editSuscription" data-book=''>
                                                <i class="fa fa-pencil color-muted"></i>
                                            </a>
                                        <!-- </td>
                                        <td class="text-end"> -->
                                            <a onclick="confirmDelete('{{ $user->uuid }}')" data-bs-toggle="tooltip" data-placement="top" title="Close">
                                                <i class="fas fa-trash"> </i>
                                            </a>
                                        </td>
                                        <!-- </td> -->
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