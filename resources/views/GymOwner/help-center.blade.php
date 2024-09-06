@extends('GymOwner.master')
@section('title','Dashboard')
@section('content')

<div class="content-body">
    <!-- container starts -->
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                {{-- <li class="breadcrumb-item"><a href="javascript:void(0)">Bootstrap</a></li> --}}
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Help Center</a></li>
            </ol>
        </div>
        <!-- row -->
        <!-- Row starts -->
        <div class="row">
            <!-- Column starts -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-block">
                        <h4 class="card-title">Help Center</h4>
                        {{-- <p class="m-0 subtitle">Default accordion. Add <code>accordion</code> class in root</p> --}}
                    </div>
                    <div class="card-body">
                        <div class="accordion accordion-primary" id="accordion-one">
                              <div class="accordion-item">
                                <h2 class="accordion-header">
                                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#default-collapseOne" aria-expanded="true" aria-controls="default-collapseOne">
                                  Our Gmail
                                  </button>
                                </h2>
                                <div id="default-collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordion-one">
                                  <div class="accordion-body">
                                   wingersitservices@gmail.com
                                  </div>
                                </div>
                              </div>
                              <div class="accordion-item">
                                <h2 class="accordion-header">
                                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#default-collapseTwo" aria-expanded="false" aria-controls="default-collapseTwo">
                                    Toll Free Number
                                  </button>
                                </h2>
                                <div id="default-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordion-one">
                                  <div class="accordion-body">
                                   1234567890
                                  </div>
                                </div>
                              </div>
                              <div class="accordion-item">
                                <h2 class="accordion-header">
                                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#default-collapseThree" aria-expanded="false">
                                    Our Website
                                  </button>
                                </h2>
                                <div id="default-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordion-one">
                                  <div class="accordion-body">
                                    wingersitservices.co.in
                                </div>
                                </div>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column ends -->

        </div>
        <!-- Row ends -->
    </div>
    <!-- container ends -->
</div>





@endsection
