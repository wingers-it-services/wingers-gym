@extends('GymOwner.master')
@section('title', 'Goal Wise Workout')
@section('content')
    
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Chat box start
        ***********************************-->
      
        <!--**********************************
    Chat box End
***********************************-->

        <!--**********************************
    Header start
***********************************-->
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
         <!--**********************************
            Sidebar end
        ***********************************-->
        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body ">
            <div class="container-fluid">
                <div class="page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Advanced</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Nestable</a></li>
                    </ol>
                </div>
                <!-- row -->

                <!-- Nestable -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Nestable</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card-content">
                                            <div class="nestable">
                                                <div class="dd" id="nestable">
                                                    <ol class="dd-list">
                                                        <li class="dd-item" data-id="1">
                                                            <div class="dd-handle">Item 1</div>
                                                        </li>
                                                        <li class="dd-item" data-id="2">
                                                            <div class="dd-handle">Item 2</div>
                                                            <ol class="dd-list">
                                                                <li class="dd-item" data-id="3">
                                                                    <div class="dd-handle">Item 3</div>
                                                                </li>
                                                                <li class="dd-item" data-id="4">
                                                                    <div class="dd-handle">Item 4</div>
                                                                </li>
                                                                <li class="dd-item" data-id="5">
                                                                    <div class="dd-handle">Item 5</div>
                                                                    <ol class="dd-list">
                                                                        <li class="dd-item" data-id="6">
                                                                            <div class="dd-handle">Item 6</div>
                                                                        </li>
                                                                        <li class="dd-item" data-id="7">
                                                                            <div class="dd-handle">Item 7</div>
                                                                        </li>
                                                                        <li class="dd-item" data-id="8">
                                                                            <div class="dd-handle">Item 8</div>
                                                                        </li>
                                                                    </ol>
                                                                </li>
                                                                <li class="dd-item" data-id="9">
                                                                    <div class="dd-handle">Item 9</div>
                                                                </li>
                                                                <li class="dd-item" data-id="10">
                                                                    <div class="dd-handle">Item 10</div>
                                                                </li>
                                                            </ol>
                                                        </li>
                                                    </ol>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
    <script src="{{asset('vendor/global/global.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('vendor/nestable2/js/jquery.nestable.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/plugins-init/nestable-init.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/custom.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/deznav-init.js')}}" type="text/javascript"></script>


@endsection