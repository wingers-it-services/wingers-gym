@extends('GymOwner.master')
@section('title', 'Dashboard')
@section('content')

<div class="content-body ">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Customers Subscriptions List</a></li>
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
                                        <th>Subscription</th>
                                        <th>Start Datae</th>
                                        <th>End Datae</th>
                                        <th>Days Remain</th>
                                    </tr>
                                </thead>
                                <tbody id="customers">
                                    @foreach ($users as $user)
                                    <tr class="btn-reveal-trigger">
                                        <td class="py-2">{{ $user->id }}</td>
                                        <td>
                                            <div class="media d-flex align-items-center">
                                                <div class="avatar avatar-xl me-2">
                                                    <div class=""><img class="rounded-circle img-fluid" src="{{ $user->image }}" width="50" alt="image">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-2">{{ $user->firstname . ' ' . $user->lastname }}</td>
                                        <td class="py-2">{{ $user->email }}</td>
                                        <td class="py-2">{{ $user->phone_no }}</td>
                                        <td class="py-2">{{ $user->subscription->subscription_name }}</td>
                                        <td class="py-2">{{ $user->subscription_start_date }}</td>
                                        <td class="py-2">{{ $user->subscription_end_date }}</td>
                                        <td class="py-2">{{ $user->remaining_days }} Days</td>


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