@extends('GymOwner.master')
@section('title','Designation')

@section('content')

<!--**********************************
            Content body start
***********************************-->
<div class="content-body ">
	<!-- row -->
	<div class="container-fluid">
		<div class="row">



			<!-- Modal -->
			<div class="modal fade" id="addNewDesignation">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Add New Designation</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal">
							</button>
						</div>
						<div class="modal-body">
							<form method="POST" action="/addGymDesignation">
								@csrf
								<div class="form-group">
									<label>Designation Name</label>
									<input type="text" id="designation_name" name="designation_name" class="form-control" required>
								</div>

								<div class="form-group">
									<div class="row align-items-center">
										<div class="col-auto">
											<label>Commission Based:</label>
										</div>
										<div class="col-auto">
											<div class="form-check form-check-inline">
												<input class="form-check-input" type="radio" id="commission_yes" name="is_commission_based" value="yes" required>
												<label class="form-check-label" for="commission_yes">Yes</label>
											</div>
											<div class="form-check form-check-inline">
												<input class="form-check-input" type="radio" id="commission_no" name="is_commission_based" value="no" required>
												<label class="form-check-label" for="commission_no">No</label>
											</div>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="row align-items-center">
										<div class="col-auto">
											<label>Assigned to Member:</label>
										</div>
										<div class="col-auto">
											<div class="form-check form-check-inline">
												<input class="form-check-input" type="radio" id="assigned_yes" name="is_assigned_to_member" value="yes" required>
												<label class="form-check-label" for="assigned_yes">Yes</label>
											</div>
											<div class="form-check form-check-inline">
												<input class="form-check-input" type="radio" id="assigned_no" name="is_assigned_to_member" value="no" required>
												<label class="form-check-label" for="assigned_no">No</label>
											</div>
										</div>
									</div>
								</div>

								<div class="text-end">
									<button class="btn btn-primary">Submit</button>
								</div>
							</form>
						</div>
					</div>
				</div>

			</div>

			<div class="col-xl-12 col-xxl-12">
				<div class="row">
					<div class="col-xl-12">
						<div class="card plan-list">
							<div class="card-header d-sm-flex d-block pb-0 border-0">
								<div class="me-auto pe-3">
									<h4 class="text-black fs-20">Designation List</h4>
									<p class="fs-13 mb-0 text-black">Lorem ipsum dolor sit amet, consectetur</p>
								</div>

								<div class="dropdown mt-sm-0 mt-3">
									<a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addNewDesignation" class="btn btn-outline-primary rounded">Add New Designation</a>
								</div>
							</div>
							<div class="card-body">
								@foreach ($designations as $key => $designation)
								<div class="d-flex px-3 pt-3 list-row flex-wrap align-items-center mb-2">
									<div class="info mb-3">
										<h4 class="fs-20 "> {{ $designation->designation_name }} </h4>
									</div>
									<div class="d-flex mb-3 me-auto ps-3 pe-3 align-items-center">
										@if ($designation->status == 1 )
										<span class="text-primary font-w600"> Active</span>
										@else
										<span class="text-danger font-w600"> Inactive</span>
										@endif

									</div>
									<div class="d-flex mb-3 me-auto ps-3 pe-3 align-items-center">
										<span class="badge badge-rounded badge-success">Commision Based: Yes </span>
										<span class="badge badge-rounded badge-danger">Assignable to user: Yes</span>

										<div class="dropdown mb-3">
											<button type="button" class="btn rounded border-light" data-bs-toggle="dropdown" aria-expanded="false">
												<svg width="6" height="26" viewBox="0 0 6 26" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M6 3C6 4.65685 4.65685 6 3 6C1.34315 6 0 4.65685 0 3C0 1.34315 1.34315 0 3 0C4.65685 0 6 1.34315 6 3Z" fill="#585858" />
													<path d="M6 13C6 14.6569 4.65685 16 3 16C1.34315 16 0 14.6569 0 13C0 11.3431 1.34315 10 3 10C4.65685 10 6 11.3431 6 13Z" fill="#585858" />
													<path d="M6 23C6 24.6569 4.65685 26 3 26C1.34315 26 0 24.6569 0 23C0 21.3431 1.34315 20 3 20C4.65685 20 6 21.3431 6 23Z" fill="#585858" />
												</svg>
											</button>
											<div class="dropdown-menu dropdown-menu-end">
												@if ($designation->status)
												<a class="dropdown-item" href="javascript:void(0);">Deactivate</a>
												@else
												<a class="dropdown-item" href="javascript:void(0);">Activate</a>
												@endif
												<a class="dropdown-item" href="javascript:void(0);">Edit</a>
												<a class="dropdown-item" href="/deleteGymDesignation/{{ $designation->uuid }}">Delete</a>
											</div>
										</div>
									</div>
								</div>
								@endforeach

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