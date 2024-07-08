@extends('admin.master')
@section('title', 'Dashboard')
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
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Device</th>
                                            <th>Browser</th>
                                            <th>IP Address</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Gender</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td><img class="rounded-circle" width="35"
                                                        src="https://wingersitservices.co.in/assets/images/logo.png"
                                                        alt=""></td>
                                                <td>{{ $user->first_name . ' ' . $user->last_name }}</td>
                                                <td>HP</td><td>Google</td>
                                                <td>111111</td>

                                                <td><span class="badge light badge-warning">Logout</span></td>
                                                    <td>2011/04/25</td>
                                                <td> {{ $user->gender }} </td>

                                                <td>
                                                    <div class="d-flex">
                                                        <a href="#"
                                                            class="btn btn-primary shadow btn-xs sharp me-1"><i
                                                                class="fa fa-pencil"></i></a>
                                                        <a href="#" class="btn btn-danger shadow btn-xs sharp"><i
                                                                class="fa fa-trash"></i></a>
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
