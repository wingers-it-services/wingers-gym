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
                                                        <div class=""><img class="rounded-circle img-fluid"
                                                                src="{{ $user->users->image ?? asset('images/profile/no_profile.png') }}" width="50" alt="image">
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-2">{{ $user->users->firstname . ' ' . $user->users->lastname }}</td>
                                            <td class="py-2">{{ $user->users->email }}</td>
                                            <td class="py-2">{{ $user->users->phone_no }}</td>
                                            <td class="py-2">{{ $user->subscription->subscription_name ?? '--' }}
                                            </td>
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
@include('CustomSweetAlert');
@endsection