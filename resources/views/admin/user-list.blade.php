@extends('admin.master')
@section('title', 'Dashboard')
@section('content')

    <!--************
                        Content body start
                    *************-->
    <!-- Content body start -->

    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editUserForm" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="row">
                            <input type="hidden" name="uuid" id="editUserId">
                            {{-- <div class="col-lg-6 mb-2">
                                <div class="form-group">
                                    <label class="text-label">Username<span class="required">*</span></label>
                                    <input type="text" class="form-control" id="editUsername" name="username"
                                        placeholder="Enter a Username.." required>
                                </div>
                            </div> --}}

                            <div class="col-lg-6 mb-2">
                                <div class="form-group">
                                    <label class="text-label">Email<span class="required">*</span></label>
                                    <input type="text" class="form-control" id="editEmail" name="email"
                                        placeholder="Enter an email.." required>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <div class="form-group">
                                    <label class="text-label">Password<span class="required">*</span></label>
                                    <input type="text" class="form-control" id="editPassword" name="password"
                                        placeholder="Enter a password.." required>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <div class="form-group">
                                    <label class="text-label">Name<span class="required">*</span></label>
                                    <input type="text" class="form-control" id="editName" name="name"
                                        placeholder="Enter a name.." required>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-2">
                                <div class="form-group">
                                    <label class="text-label">Phone Number<span class="required">*</span></label>
                                    <input type="text" class="form-control" id="editPhone" name="phone"
                                        placeholder="Enter a phone.." required>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <div class="form-group">
                                    <label class="text-label">Gender<span class="required">*</span></label>
                                    <div class="gender-dropdown-container"></div>
                                </div>


                            </div>
                            <div class="col-lg-6 mb-2">
                                <div class="form-group">
                                    <label class="text-label">Website<span class="required">*</span></label>
                                    <input type="text" class="form-control" id="editWebsite" name="website"
                                        placeholder="http://example.com" required>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <div class="form-group">
                                    <label class="text-label">Company Name<span class="required">*</span></label>
                                    <input type="text" class="form-control" id="editCompanyName" name="company_name"
                                        placeholder="Enter a Company Name.." required>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <div class="form-group">
                                    <label class="text-label">Company Address<span class="required">*</span></label>
                                    <input type="text" class="form-control" id="editCompanyAddress"
                                        name="company_address" placeholder="Enter a Company Address.." required>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <div class="form-group">
                                    <label class="text-label">No Of Device<span class="required">*</span></label>
                                    <select class="default-select wide form-control" id="editNoOfDevice"
                                        name="no_of_device">
                                        <option data-display="Select">Please select</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>
                            </div>
                        </div>





                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example3" class="display min-w850">
                                    <thead>
                                        <tr>
                                            <th colspan="2">Name</th>
                                            <th>Company Name</th>
                                            <th>Contact Number</th>
                                            <th>Company Address</th>
                                            <th>No Of Device</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                            <tr>
                                                <td>
                                                    <img width="80" src=""
                                                        style="border-radius: 45px;width: 60px;height: 60px;"
                                                        loading="lazy" alt="image">
                                                </td>
                                                <td>Muskan</td>
                                                <td>wits</td>
                                                <td><a href="javascript:void(0);"><strong>958664564</strong></a>
                                                </td>
                                                <td>yogeshwar </td>
                                                <td>2</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href=""
                                                            class="btn btn-primary shadow btn-xs sharp me-1">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a href=""
                                                            class="btn btn-primary shadow btn-xs sharp me-1 edit-book-button"
                                                            data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg"
                                                            data-book=''>
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                        <a href=""
                                                            class="btn btn-danger shadow btn-xs sharp">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </div>
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

    <!--************
                        Content body end
                    *************-->

@endsection
