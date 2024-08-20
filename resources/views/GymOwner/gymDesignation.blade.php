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
												<input class="form-check-input" type="radio" id="commission_yes" name="is_commission_based" value="1" required>
												<label class="form-check-label" for="commission_yes">Yes</label>
											</div>
											<div class="form-check form-check-inline">
												<input class="form-check-input" type="radio" id="commission_no" name="is_commission_based" value="0" required>
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
												<input class="form-check-input" type="radio" id="assigned_yes" name="is_assigned_to_member" value="1" required>
												<label class="form-check-label" for="assigned_yes">Yes</label>
											</div>
											<div class="form-check form-check-inline">
												<input class="form-check-input" type="radio" id="assigned_no" name="is_assigned_to_member" value="0" required>
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

			<!-- Edit Designation Modal -->
			<div class="modal fade" id="editDesignation">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Edit Designation</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
						</div>
						<div class="modal-body">
							<form method="POST" id="editDesignationForm" action="/update-designation">
								@csrf
								<input type="hidden" id="edit_designation_id" name="designation_id">
								<div class="form-group">
									<label>Designation Name</label>
									<input type="text" id="edit_designation_name" name="designation_name" class="form-control" required>
								</div>

								<div class="form-group">
									<div class="row align-items-center">
										<div class="col-auto">
											<label>Commission Based:</label>
										</div>
										<div class="col-auto">
											<div class="form-check form-check-inline">
												<input class="form-check-input" type="radio" id="edit_commission_yes" name="is_commission_based" value="1" required>
												<label class="form-check-label" for="edit_commission_yes">Yes</label>
											</div>
											<div class="form-check form-check-inline">
												<input class="form-check-input" type="radio" id="edit_commission_no" name="is_commission_based" value="0" required>
												<label class="form-check-label" for="edit_commission_no">No</label>
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
												<input class="form-check-input" type="radio" id="edit_assigned_yes" name="is_assigned_to_member" value="1" required>
												<label class="form-check-label" for="edit_assigned_yes">Yes</label>
											</div>
											<div class="form-check form-check-inline">
												<input class="form-check-input" type="radio" id="edit_assigned_no" name="is_assigned_to_member" value="0" required>
												<label class="form-check-label" for="edit_assigned_no">No</label>
											</div>
										</div>
									</div>
								</div>

								<div class="text-end">
									<button class="btn btn-primary">Update</button>
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
										<span class="badge badge-rounded badge-success">
											Commission Based: {{ $designation->is_commission_based == 1 ? 'Yes' : 'No' }}
										</span>
										<span class="badge badge-rounded badge-danger">
											Assignable to user: {{ $designation->is_assigned_to_member == 1 ? 'Yes' : 'No' }}
										</span>



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
												<a class="dropdown-item" href="javascript:void(0);" onclick="deactivateDesignation('{{ $designation->id }}')">Deactivate</a>
												@else
												<a class="dropdown-item" href="javascript:void(0);" onclick="activateDesignation('{{ $designation->id }}')">Activate</a> @endif
												<a class="dropdown-item" href="javascript:void(0);"
													onclick="editDesignation('{{ $designation->id }}', '{{ $designation->designation_name }}', '{{ $designation->is_commission_based }}', '{{ $designation->is_assigned_to_member }}')">
													Edit
												</a>
												<a class="dropdown-item" onclick="confirmDelete('{{ $designation->uuid }}')">Delete</a>
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
<script>
	function confirmDelete(uuid) {
		Swal.fire({
			title: 'Are you sure?',
			text: 'Are you sure you want to delete this designation?.',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
			if (result.isConfirmed) {
				window.location.href = '/deleteGymDesignation/' + uuid;
			}
		});
	}

	function editDesignation(id, name, commissionBased, assignedToMember) {
		// Set the hidden field with the designation ID
		document.getElementById('edit_designation_id').value = id;

		// Set the designation name
		document.getElementById('edit_designation_name').value = name;

		// Set the radio buttons for commission based using IDs
		if (commissionBased == 1) {
			document.getElementById('edit_commission_yes').checked = true;
		} else {
			document.getElementById('edit_commission_no').checked = true;
		}

		// Set the radio buttons for assigned to member using IDs
		if (assignedToMember == 1) {
			document.getElementById('edit_assigned_yes').checked = true;
		} else {
			document.getElementById('edit_assigned_no').checked = true;
		}

		// Show the edit modal
		var myModal = new bootstrap.Modal(document.getElementById('editDesignation'));
		myModal.show();
	}

	function deactivateDesignation(id) {
		Swal.fire({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, deactivate it!'
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: `/update-designation-status/` + id,
					type: 'GET',
					data: {
						_token: $('meta[name="csrf-token"]').attr('content')
					},
					success: function(data) {
						if (data.status === 'success') {
							Swal.fire(
								'Deactivated!',
								'Designation has been deactivated.',
								'success'
							).then(() => {
								location.reload(); // Reload the page to see the updated status
							});
						} else {
							Swal.fire(
								'Failed!',
								'Failed to deactivate designation: ' + data.message,
								'error'
							);
						}
					},
					error: function(xhr, status, error) {
						console.error('Error:', error);
						Swal.fire(
							'Error!',
							'Failed to deactivate designation.',
							'error'
						);
					}
				});
			}
		});
	}

	function activateDesignation(id) {
		Swal.fire({
			title: 'Are you sure?',
			text: "You want to activate this designation!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, activate it!'
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: `/activate-designation-status/` + id,
					type: 'GET',
					data: {
						_token: $('meta[name="csrf-token"]').attr('content')
					},
					success: function(data) {
						if (data.status === 'success') {
							Swal.fire(
								'Activated!',
								'Designation has been activated.',
								'success'
							).then(() => {
								location.reload(); // Reload the page to see the updated status
							});
						} else {
							Swal.fire(
								'Failed!',
								'Failed to activate designation: ' + data.message,
								'error'
							);
						}
					},
					error: function(xhr, status, error) {
						console.error('Error:', error);
						Swal.fire(
							'Error!',
							'Failed to activate designation.',
							'error'
						);
					}
				});
			}
		});
	}
</script>
@include('CustomSweetAlert');
@endsection