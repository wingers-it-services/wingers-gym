@extends('admin.master')
@section('title','Dashboard')
@section('content')
<div class="content-body ">
    <div class="container-fluid">
<div class="page-titles">
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="javascript:void(0)">Email</a></li>
    <li class="breadcrumb-item active"><a href="javascript:void(0)">Inbox</a></li>
</ol>
</div>
<!-- row -->
<div class="row">
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="email-left-box px-0 mb-3">
                <div class="p-0">
                    <a href="/admin/admin-notification" class="btn btn-primary btn-block">Compose</a>
                </div>
                <div class="mail-list rounded mt-4">
                    <a href="/admin/admin-notification-inbox" class="list-group-item active"><i
                            class="fa fa-inbox font-18 align-middle me-2"></i> Inbox <span
                            class="badge badge-secondary badge-sm float-end">198</span> </a>


                </div>

            </div>
            <div class="email-right-box ms-0 ms-sm-4 ms-sm-0">
                <div role="toolbar" class="toolbar ms-1 ms-sm-0">
                    <div class="btn-group mb-1">
                        <div class="form-check custom-checkbox ps-4">
                            <input type="checkbox" class="form-check-input" id="checkAll">
                            <label class="form-check-label" for="checkAll"></label>
                        </div>
                    </div>
                    <div class="btn-group mb-1">
                        <button class="btn btn-primary light px-3" type="button"><i class="ti-reload"></i>
                        </button>
                    </div>
                    <div class="btn-group mb-1">
                        <button aria-expanded="false" data-bs-toggle="dropdown" class="btn btn-primary px-3 light dropdown-toggle" type="button">More <span
                                class="caret"></span>
                        </button>
                        <div class="dropdown-menu"> <a href="javascript: void(0);" class="dropdown-item">Mark as Unread</a> <a href="javascript: void(0);" class="dropdown-item">Add to Tasks</a>
                            <a href="javascript: void(0);" class="dropdown-item">Add Star</a> <a href="javascript: void(0);" class="dropdown-item">Mute</a>
                        </div>
                    </div>
                </div>
                <div class="email-list mt-3">
                    <div class="message">
                        <div>
                            <div class="d-flex message-single">
                                <div class="ps-1 align-self-center">
                                    <div class="form-check custom-checkbox">
                                        <input type="checkbox" class="form-check-input" id="checkbox2">
                                        <label class="form-check-label" for="checkbox2"></label>
                                    </div>
                                </div>
                                <div class="ms-2">
                                    <button class="border-0 bg-transparent align-middle p-0"><i
                                            class="fa fa-star" aria-hidden="true"></i></button>
                                </div>
                            </div>
                            <a href="/admin/admin-notification-read" class="col-mail col-mail-2">
                                <div class="subject">Ingredia Nutrisha, A collection of textile samples lay spread out on the table - Samsa was a travelling salesman - and above it there hung a picture</div>
                                <div class="date">11:49 am</div>
                            </a>
                        </div>
                    </div>

                </div>
                <!-- panel -->
                <div class="row mt-4">
                    <div class="col-12 ps-3">
                        <nav>
                            <ul class="pagination pagination-gutter pagination-primary pagination-sm no-bg">
                                <li class="page-item page-indicator"><a class="page-link" href="javascript:void()"><i class="la la-angle-left"></i></a></li>
                                <li class="page-item "><a class="page-link" href="javascript:void()">1</a></li>
                                <li class="page-item active"><a class="page-link" href="javascript:void()">2</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void()">3</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void()">4</a></li>
                                <li class="page-item page-indicator"><a class="page-link" href="javascript:void()"><i class="la la-angle-right"></i></a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

</div>
</div>





@endsection
