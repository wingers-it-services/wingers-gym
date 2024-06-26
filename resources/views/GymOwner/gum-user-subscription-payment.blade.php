@extends('GymOwner.master')
@section('title','Dashboard')
@section('content')

<!--**********************************
            Content body start
        ***********************************-->
<div class="content-body ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display min-w850">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Mobile</th>
                                        <th>Payment</th>
                                        <th>Department</th>
                                        <th>Education</th>
                                        <th>Joining Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subscriptionHistorys as $user )
                                    <tr>
                                        <td><img class="rounded-circle" width="35" src="{{ $user->image}}" alt=""></td>
                                        <td>{{ $user->first_name.' '.  $user->last_name}}</td>
                                        <td> {{ $user->gender}} </td>
                                        <td><a href="javascript:void(0);"><strong> {{ $user->phone_no}}</strong></a></td>
                                        <td><span class="badge light badge-warning">Panding</span></td>
                                        <td>{{ $user->trainerName}}</td>
                                        <td>2011/04/25</td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="#" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fa fa-pencil"></i></a>
                                                <a href="#" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                            </div>
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
<!--**********************************
            Content body end
        ***********************************-->
@endsection