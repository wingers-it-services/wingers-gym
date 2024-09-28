@extends('GymOwner.master')
@section('title','Dashboard')
@section('content')

<div class="content-body ">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Enquiry</a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="email-left-box px-0 mb-3">
                            @foreach($inquiries as $inquiry)
                            <div class="mail-list mt-4 rounded">
                                <a href="/inbox" class="list-group-item active"><i class="fa fa-inbox font-18 align-middle me-2"></i> {{$inquiry->reason}}
                                    <span class="badge badge-secondary badge-sm float-end">198</span> </a>
                            </div>
                            @endforeach
                        </div>
                        <div class="email-right-box rounded ms-0 ms-sm-4 ms-sm-0">

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