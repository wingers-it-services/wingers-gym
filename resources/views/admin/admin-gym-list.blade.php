@extends('admin.master')
@section('title','Dashboard')
@section('content')

<div class="content-body ">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Gym List</a></li>
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
                                        <th>GYM Name</th>
                                        <th>Gym Type</th>
                                        <th>Email</th>
                                        <th class="ps-5 width200">Gym Address
                                        </th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                @foreach ($gymLists as $gym)
                                <tbody id="customers">
                                    <tr class="btn-reveal-trigger">
                                        <td class="py-3">
                                            <a href="#">
                                                <div class="media d-flex align-items-center">
                                                    <div class="avatar avatar-xl me-2">
                                                        <div class=""><img class="rounded-circle img-fluid" src="images/1.jpg" width="30" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="media-body">    
                                                        <h5 class="mb-0 fs--1">{{$gym->gym_name}}</h5>
                                                    </div>
                                                </div>
                                            </a>
                                        </td>
                                        <td class="py-2"><a href="mailto:ricky@example.com">{{$gym->gym_type}}</a></td>
                                        <td class="py-2"> <a href="tel:2012001851">{{$gym->email}}</a></td>
                                        <td class="py-2 ps-5 wspace-no">{{$gym->address}}</td>
                                        <td class="py-2 text-end">
                                            <div class="dropdown"><button class="btn btn-primary tp-btn-light sharp" type="button" data-bs-toggle="dropdown"><span class="fs--1"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                                <circle fill="#000000" cx="5" cy="12" r="2"></circle>
                                                                <circle fill="#000000" cx="12" cy="12" r="2"></circle>
                                                                <circle fill="#000000" cx="19" cy="12" r="2"></circle>
                                                            </g>
                                                        </svg></span></button>
                                                <div class="dropdown-menu dropdown-menu-end border py-0">
                                                    <div class="py-2"><a class="dropdown-item" href="/admin/update-gym/{{$gym->uuid}}">Edit</a><a class="dropdown-item text-danger" href="/admin/deleteGym/{{$gym->uuid}}">Delete</a></div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>


                                </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




@endsection