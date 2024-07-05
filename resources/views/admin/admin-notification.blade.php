@extends('admin.master')
@section('title','Dashboard')
@section('content')

<div class="content-body ">
    <div class="container-fluid">
<div class="page-titles">
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="javascript:void(0)">Email</a></li>
    <li class="breadcrumb-item active"><a href="javascript:void(0)">Compose</a></li>
</ol>
</div>
<!-- row -->
<div class="row">
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="email-left-box px-0 mb-3">
                <div class="p-0">
                    <a href="#" class="btn btn-primary btn-block">Compose</a>
                </div>
                <div class="mail-list mt-4 rounded">
                    <a href="/admin/admin-notification-inbox" class="list-group-item active"><i
                            class="fa fa-inbox font-18 align-middle me-2"></i> Inbox <span
                            class="badge badge-secondary badge-sm float-end">198</span> </a>
                    {{-- <a href="javascript:void()" class="list-group-item"><i
                            class="fa fa-paper-plane font-18 align-middle me-2"></i>Sent</a> <a href="javascript:void(0);" class="list-group-item"><i
                            class="fa fa-star font-18 align-middle me-2"></i>Important <span
                            class="badge badge-danger text-white badge-sm float-end">47</span>
                    </a>
                    <a href="javascript:void()" class="list-group-item"><i
                            class="mdi mdi-file-document-box font-18 align-middle me-2"></i>Draft</a><a href="javascript:void()" class="list-group-item"><i
                            class="fa fa-trash font-18 align-middle me-2"></i>Trash</a> --}}
                </div>
                {{-- <div class="intro-title d-flex rounded justify-content-between">
                    <h5>Categories</h5>
                    <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                </div>
                <div class="mail-list rounded mt-4">
                    <a href="https://fito.dexignzone.com/laravel/demo/email-inbox" class="list-group-item"><span class="icon-warning"><i
                                class="fa fa-circle" aria-hidden="true"></i></span>
                        Work </a>
                    <a href="https://fito.dexignzone.com/laravel/demo/email-inbox" class="list-group-item"><span class="icon-primary"><i
                                class="fa fa-circle" aria-hidden="true"></i></span>
                        Private </a>
                    <a href="https://fito.dexignzone.com/laravel/demo/email-inbox" class="list-group-item"><span class="icon-success"><i
                                class="fa fa-circle" aria-hidden="true"></i></span>
                        Support </a>
                    <a href="https://fito.dexignzone.com/laravel/demo/email-inbox" class="list-group-item"><span class="icon-dpink"><i
                                class="fa fa-circle" aria-hidden="true"></i></span>
                        Social </a>
                </div> --}}
            </div>
            <div class="email-right-box rounded ms-0 ms-sm-4 ms-sm-0">
                <div class="compose-content">
                    <form action="#">
                        <div class="form-group">
                            <input type="text" class="form-control bg-transparent" placeholder=" To:">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control bg-transparent" placeholder=" Subject:">
                        </div>
                        <div class="form-group">
                            <textarea id="email-compose-editor" class="textarea_editor form-control bg-transparent" rows="15" placeholder="Enter text ..."></textarea>
                        </div>
                    </form>
                    <h5 class="mb-4"><i class="fa fa-paperclip"></i> Attatchment</h5>
                    <form action="#" class="dropzone">
                        <div class="fallback">
                            <input name="file" type="file" multiple>
                        </div>
                    </form>
                </div>
                <div class="text-left mt-4 mb-5">
                    <button class="btn btn-primary btn-sl-sm me-2" type="button"><span class="me-2"><i class="fa fa-paper-plane"></i></span>Send</button>
                    <button class="btn btn-danger light btn-sl-sm" type="button"><span class="me-2"><i class="fa fa-times" aria-hidden="true"></i></span>Discard</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

</div>
</div>





@endsection
