@extends('admin.master')
@section('title', 'Dashboard')
@section('content')

<!--**********************************
                Content body start
            ***********************************-->
<div class="content-body ">
    <div class="container-fluid">
        <!-- row -->
        <div class="row">
            <div class="col-xl-12 col-xxl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Book Information</h4>
                    </div>
                    <div class="card-body">
                        <div id="smartwizard" class="form-wizard order-create">
                            <ul class="nav nav-wizard">
                                <li>
                                    <a class="nav-link" href="#wizard_Service"><span>1</span></a>
                                </li>
                                <li>
                                    <a class="nav-link" href="#wizard_association_details"> <span>2</span></a>
                                </li>
                                <li>
                                    <a class="nav-link" href="#wizard_publication_details"> <span>3</span></a>
                                </li>
                            </ul>
                            <form action="" name="myForm" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="tab-content">
                                    <div id="wizard_Service" class="tab-pane" role="tabpanel" style="display: block;text-align: center;">
                                        <div class="row emial-setup">
                                            <div class="col-lg-12 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <div class="mailclinet" id="mailclinet">
                                                        <img id="selected_image" src="https://p7.hiclipart.com/preview/831/479/764/ibooks-computer-icons-ios-apple-app-store-sparito-lo-scaffale-sono-rimaste-le-pagine-aperte-i-colori-cambiano.jpg" style="width: 200px;height:200px">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="skip-email text-center">
                                                    <div class="mb-3">
                                                        <label for="staff_photo" class="form-label">Book Image</label>
                                                        <input class="form-control form-control-sm" id="staff_photo" name="image" onchange="loadFile(event)" accept="image/*" type="file">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mb-2">
                                                <div class="form-group">
                                                    <input type="text" name="book_name" class="form-control" placeholder="Book Name">
                                                </div>
                                            </div>

                                            <div class="col-lg-6 mb-2">
                                                <div class="form-group">
                                                    <input type="number" name="book_price" class="form-control" placeholder="Book Price">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="wizard_association_details" class="tab-pane" role="tabpanel">
                                        <div class="row">
                                            <div class="card-footer mt-0">
                                                <button class="btn btn-primary btn-lg btn-block">Association Details</button>
                                            </div>
                                            <div class="col-lg-6 mb-2">
                                                <div class="form-group">
                                                    <label class="text-label">Association Name<span class="required">*</span></label>
                                                    <input type="text" name="association_name" class="form-control" placeholder="Montana">
                                                </div>
                                            </div>

                                            <div class="col-lg-6 mb-2">
                                                <div class="form-group">
                                                    <label class="text-label">Website Link<span class="required">*</span></label>
                                                    <input type="text" name="association_web_link" class="form-control" placeholder="https://wingersitservices.co.in/">
                                                </div>
                                            </div>

                                            <div class="col-lg-6 mb-2">
                                                <div class="form-group">
                                                    <label class="text-label">Email Address<span class="required">*</span></label>
                                                    <input type="email" class="form-control" id="email" name="association_email" placeholder="example@example.com.com">
                                                </div>
                                            </div>

                                            <div class="col-lg-6 mb-2">
                                                <div class="form-group">
                                                    <label class="text-label">Phone Number<span class="required">*</span></label>
                                                    <input type="text" name="association_ph_no" id="phone_number" class="form-control" placeholder="(+1)408-657-9007">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mb-3">
                                                <div class="form-group">
                                                    <label class="text-label">Address<span class="required">*</span></label>
                                                    <textarea type="text" name="association_address" rows="4" class="form-control"></textarea>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="wizard_publication_details" class="tab-pane" role="tabpanel">
                                        <div class="row">
                                            <div class="card-footer mt-0">
                                                <button class="btn btn-primary btn-lg btn-block">Publication Details</button>
                                            </div>
                                            <div class="col-lg-6 mb-2">
                                                <div class="form-group">
                                                    <label class="text-label">Publication Name<span class="required">*</span></label>
                                                    <input type="text" name="publication_name" class="form-control" placeholder="Montana">
                                                </div>
                                            </div>

                                            <div class="col-lg-6 mb-2">
                                                <div class="form-group">
                                                    <label class="text-label">Website Link<span class="required">*</span></label>
                                                    <input type="text" name="publication_web_link" class="form-control" placeholder="https://wingersitservices.co.in/">
                                                </div>
                                            </div>

                                            <div class="col-lg-6 mb-2">
                                                <div class="form-group">
                                                    <label class="text-label">Email Address<span class="required">*</span></label>
                                                    <input type="email" class="form-control" id="email" name="publication_email" placeholder="example@example.com.com">
                                                </div>
                                            </div>

                                            <div class="col-lg-6 mb-2">
                                                <div class="form-group">
                                                    <label class="text-label">Phone Number<span class="required">*</span></label>
                                                    <input type="text" name="publication_ph_no" id="phone_number" class="form-control" placeholder="(+1)408-657-9007">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mb-3">
                                                <div class="form-group">
                                                    <label class="text-label">Address<span class="required">*</span></label>
                                                    <textarea type="text" name="publication_address" rows="4" class="form-control"></textarea>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
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



<!--**********************************
            Scripts
        ***********************************-->



<script>
    var loadFile = function(event) {
        // var selected_image = document.getElementById('selected_image');

        var input = event.target;
        var image = document.getElementById('selected_image');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                image.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }

        function validateForm() {
            let x = document.forms["myForm"]["staff_id"].value;
            if (x == "") {
                alert("Name must be filled out");
                return false;
            }
        }

    };
</script>

@endsection
