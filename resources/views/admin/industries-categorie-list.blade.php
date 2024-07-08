@extends('admin.master')
@section('title', 'Dashboard')
@section('content')

    <!--**********************************
                                Content body start
                    ***********************************-->
    <div class="content-body ">
        <!-- row -->
        <div class="container-fluid">
            <div class="row">



                <!-- Modal -->
                <div class="modal fade" id="addNewPlan">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add New Industries Categories</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal">
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="/admin/industries-categories">
                                    @csrf
                                    <div class="form-group">
                                        <label>Category Name</label>
                                        <input type="text" id="category_name" name="category_name" class="form-control"
                                            required>
                                    </div>

                                    <button class="btn btn-primary" style=" width: -webkit-fill-available; ">Submit</button>
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
                                        <h4 class="text-black fs-20">Industries Categories List</h4>
                                        <p class="fs-13 mb-0 text-black">Lorem ipsum dolor sit amet, consectetur</p>
                                    </div>

                                    <div class="dropdown mt-sm-0 mt-3">
                                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addNewPlan"
                                            class="btn btn-outline-primary rounded">Add New Categories</a>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table
                                            class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Categories</th>
                                                    <th scope="col">No of Books</th>
                                                    <th scope="col">No of Industries</th>
                                                    <th scope="col">Progress</th>
                                                    <th scope="col">Label</th>
                                                    <th scope="col" class="text-end">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($industriesCategorie as $subscription)
                                                    <tr>
                                                        <td>{{ $subscription->category_name }}</td>
                                                        <td>0</td>
                                                        <td>0</td>
                                                        <td>
                                                            <div class="progress" style="background: rgba(255, 193, 7, .1)">
                                                                <div class="progress-bar bg-warning" style="width: 0%;"
                                                                    role="progressbar"><span class="sr-only">0%
                                                                        Complete</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><span class="badge badge-warning">0%</span>
                                                        </td>
                                                        <td class="text-end">
                                                            <span>
                                                                <a href="javascript:void()" class="me-4"
                                                                    data-bs-toggle="tooltip" data-placement="top"
                                                                    title="Edit">
                                                                    <i class="fa fa-pencil color-muted"></i>
                                                                </a>

                                                                <a href="/admin/delete-category/{{ $subscription->uuid }}" data-bs-toggle="tooltip"
                                                                    data-placement="top" title="Close"><i
                                                                        class="fas fa-times color-danger"></i>
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
    <!--**********************************
                                Content body end
                            ***********************************-->

@endsection
