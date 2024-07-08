@extends('GymOwner.master')
@section('title', 'Subscription Plans')
@section('content')

<!--**********************************
            Content body start
***********************************-->
<div class="content-body ">
	<!-- row -->
	<div class="container-fluid">
		<div class="row">



			<!-- Modal -->
			<div class="modal fade" id="addNewPlan">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Add New Plan</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal">
							</button>
						</div>
						<div class="modal-body">
							<form method="POST" action="/gym-subscription">
								@csrf
								<div class="form-group">
									<label>Subscription Name</label>
									<input type="text" id="subscription_name" name="subscription_name" class="form-control" required>
								</div>
								<div class="form-group">
									<label>Validaty (in months)</label>
									<input type="number" name="validity" min="0" max="1000" class="form-control" required>
								</div>
								<div class="form-group">
									<label>Subscription Price</label>
									<input type="number" name="amount" class="form-control" name="" min="0" required />
								</div>
								<div class="form-group">
									<label>Plan Start Date</label>
									<input type="date" name="start_date" class="form-control" required>
								</div>
								<div class="form-group">
									<label>Plan Description</label>
									<textarea type="text" rows="10" name="description" class="form-control" required></textarea>
								</div>

								<button class="btn btn-primary">Submit</button>
							</form>
						</div>
					</div>
				</div>

			</div>

			<div class="col-xl-12 col-xxl-12">
				<div class="row">
					<div class="col-12">
						<div class="card">
							<div class="card-header d-sm-flex d-block pb-0 border-0">
								<div class="me-auto pe-3">
									<h4 class="text-black fs-20">Subscriptions Plan List</h4>
									<p class="fs-13 mb-0 text-black">Lorem ipsum dolor sit amet, consectetur</p>
								</div>

								<div class="dropdown mt-sm-0 mt-3">
									<a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addNewPlan" class="btn btn-outline-primary rounded">Add New Subscription</a>
								</div>
							</div>

							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-bordered table-striped verticle-middle table-responsive-sm">
										<thead>
											<tr>
												<th scope="col">Plan</th>
												<th scope="col">Amount</th>
												<th scope="col">Validity</th>
												<th scope="col">Progress</th>
												<th scope="col">Deadline</th>
												<th scope="col">Label</th>
												<th scope="col" class="text-end">Action</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($subscriptions as $subscription)
											<tr>
												<td>{{$subscription->subscription_name }}</td>
												<td>{{$subscription->amount }}</td>
												<td>{{$subscription->validity }} Months</td>
												<td>
													<div class="progress" style="background: rgba(255, 193, 7, .1)">
														<div class="progress-bar bg-warning" style="width: 70%;" role="progressbar"><span class="sr-only">70% Complete</span>
														</div>
													</div>
												</td>
												<td>Jun 28,2018</td>
												<td><span class="badge badge-warning">70%</span>
												</td>
												<td class="text-end"><span><a href="javascript:void()" class="me-4" data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i> </a><a href="javascript:void()" data-bs-toggle="tooltip" data-placement="top" title="Close"><i class="fas fa-times color-danger"></i></a></span>
												</td>
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal for Adding New Plan -->
<div class="modal fade" id="addNewPlan" tabindex="-1" aria-labelledby="addNewPlanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewPlanLabel">Add New Plan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ url('/gym-subscription') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Subscription Name</label>
                        <input type="text" name="subscription_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Validity (in months)</label>
                        <input type="number" name="validity" min="0" max="1000" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Subscription Price</label>
                        <input type="number" name="amount" class="form-control" min="0" required>
                    </div>
                    <div class="form-group">
                        <label>Plan Start Date</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Plan Description</label>
                        <textarea name="description" rows="10" class="form-control" required></textarea>
                    </div>
                    <button class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Editing Plan -->
<div class="modal fade" id="editPlan" tabindex="-1" aria-labelledby="editPlanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPlanLabel">Edit Subscription Plan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ url('/updateSubscriiption') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="uuid" id="edit_uuid">
                    <div class="form-group">
                        <label>Subscription Name</label>
                        <input type="text" name="subscription_name" id="edit_subscription_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Validity (in months)</label>
                        <input type="number" name="validity" id="edit_validity" min="0" max="1000" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Subscription Price</label>
                        <input type="number" name="amount" id="edit_amount" class="form-control" min="0" required>
                    </div>
                    <div class="form-group">
                        <label>Plan Start Date</label>
                        <input type="date" name="start_date" id="edit_start_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Plan Description</label>
                        <textarea name="description" id="edit_description" rows="10" class="form-control" required></textarea>
                    </div>
                    <button class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editButtons = document.querySelectorAll('.btn-edit');

        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                const uuid = this.getAttribute('data-uuid');
                const name = this.getAttribute('data-name');
                const validity = this.getAttribute('data-validity');
                const amount = this.getAttribute('data-amount');
                const startDate = this.getAttribute('data-start-date');
                const description = this.getAttribute('data-description');

                document.getElementById('edit_uuid').value = uuid;
                document.getElementById('edit_subscription_name').value = name;
                document.getElementById('edit_validity').value = validity;
                document.getElementById('edit_amount').value = amount;
                document.getElementById('edit_start_date').value = startDate;
                document.getElementById('edit_description').value = description;

                const editPlanModal = new bootstrap.Modal(document.getElementById('editPlan'));
                editPlanModal.show();
            });
        });

        const deleteButtons = document.querySelectorAll('.btn-delete');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const uuid = this.getAttribute('data-uuid');
                if (confirm('Are you sure you want to delete this subscription?')) {
                    document.getElementById('delete-form-' + uuid).submit();
                }
            });
        });
    });
</script>

@endsection
