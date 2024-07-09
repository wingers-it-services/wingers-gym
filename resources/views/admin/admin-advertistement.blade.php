@extends('admin.master')
@section('title', 'Dashboard')
@section('content')

<!--**********************************
    Content body start
***********************************-->
<!-- Bootstrap CSS -->
{{-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> --}}
<!-- jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="row">
            <div class="card-header d-sm-flex d-block pb-0 border-0">
                <div class="me-auto pe-3">
                    <h4 class="text-black fs-20">Advertisement</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <!-- Tab panes -->
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                                            <img class="img-fluid rounded" src="" alt="">
                                        </div>
                                    </div>
                                </div>
                                <!-- Tab slider End -->
                                <div class="col-12">
                                    <div class="product-detail-content">
                                        <img class="img-fluid rounded " src="https://www.jigarpublicity.com/assets/img/jigar-publicity-logo.png" alt="">
                                        {{-- <div class="new-arrival-content mt-md-0 mt-3 pr">
                                            <img class="img-fluid rounded " src="https://www.jigarpublicity.com/assets/img/jigar-publicity-logo.png" alt="">

                                        </div> --}}
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><i class="fas fa-ad"></i>    Advertisement</h4>
                    </div>
                    <div class="card-body">
                        <!-- Nav tabs -->
                        <div class="default-tab">


                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="profile" role="tabpanel">
                                    <div class="pt-4">
                                        <div class="col-xl-12 col-lg-12 col-xxl-12 col-sm-12">
                                            <div class="card">
                                                <div class="col-md-12 text-end">
                                                    <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addIndustryModal">Add  Advertistment</button>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive recentOrderTable">
                                                        <table id="example3" class="table verticle-middle table-responsive-md">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col"> Image</th>
                                                                    <th scope="col">Book Name</th>
                                                                    <th scope="col"> Industry  Name</th>
                                                                    <th scope="col">Category</th>
                                                                    <th scope="col">Status</th>
                                                                    <th scope="col" class="text-end">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td> <img class="img-fluid rounded " src="https://www.jigarpublicity.com/assets/img/jigar-publicity-logo.png" style="width:50px;"alt=""></td>
                                                                    <td>Zydus Book</td>
                                                                    <td>Zydus</td>
                                                                    <td>Pharma</td>
                                                                    <td>Pending</td>
                                                                    <td class="text-end">
                                                                        <span>
                                                                            <a href="javascript:void()" class="me-4" data-bs-toggle="tooltip" data-placement="top" title="Edit">
                                                                                <i class="fa fa-pencil color-muted"></i>
                                                                            </a>
                                                                            <a href="" data-bs-toggle="tooltip" data-placement="top" title="Close">
                                                                                <i class="fas fa-times color-danger"></i>
                                                                            </a>
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="addIndustryModal" tabindex="-1" aria-labelledby="addIndustryModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addIndustryModalLabel">Add Advertisement</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="industryName">Book  Name</label>
                                                <input type="text" class="form-control" id="bookName" name="name" required>
                                            </div>
                                                <div class="form-group">
                                                    <label for="industryName">Industry Name</label>
                                                    <input type="text" class="form-control" id="industryName" name="name" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="industryCategory">Category</label>
                                                    <input type="text" class="form-control" id="industryCategory" name="category" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="industryImage">Image</label>
                                                    <input type="file" class="form-control" id="industryImage" name="image" required>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Save</button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End of Modal -->
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

@section('scripts')
<!-- Data Table JS -->
<script src="{{ asset('path/to/datatables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#example3').DataTable();
    });
</script>
@endsection
