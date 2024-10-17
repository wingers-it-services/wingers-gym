@extends('GymOwner.master')
@section('title', 'Goal Wise Diet')
@section('content')

<!--**********************************
            Content body start
***********************************-->
<div class="modal fade" id="editGoal">
    <!-- <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Goal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('updateGoal')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="uuid" id="editGoalId">
                    <div class="form-group">
                        <label>Goal</label>
                        <input type="text" id="editGoalName" name="goal" class="form-control" required>
                    </div>
                    <button class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div> -->

</div>
<div class="content-body ">
    <!-- row -->
    <div class="container-fluid">
        <div class="row">
            <!-- Modal -->
            <div class="modal fade" id="addNewPlan">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add New Goal Wise Diet</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('addGoalWiseDiet') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Goal</label>
                                    <select id="goal_id" name="goal_id" class="form-control" required>
                                        <option value="" disabled selected>Select Goal</option>
                                        @foreach($goals as $goal)
                                        <option value="{{$goal->id}}">{{$goal->goal}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Diet</label>
                                    <select id="diet_id" name="diet_id" class="form-control" required>
                                        <option value="" disabled selected>Select Diet</option>
                                        @foreach($diets as $diet)
                                        <option value="{{$diet->id}}">{{$diet->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Level</label>
                                    <select id="user_lebel_id" name="user_lebel_id" class="form-control" required>
                                        <option value="" disabled selected>Select Level</option>
                                        @foreach($levels as $level)
                                        <option value="{{$level->id}}">{{$level->lebel}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Calories</label>
                                    <input type="text" name="calories" id="calories" class="form-control" placeholder="Enter calories">
                                </div>

                                <div class="form-group">
                                    <label>Protein</label>
                                    <input type="text" name="protein" id="protein" class="form-control" placeholder="Enter protein">
                                </div>

                                <div class="form-group">
                                    <label>Carbs</label>
                                    <input type="text" name="carbs" id="carbs" class="form-control" placeholder="Enter carbs">
                                </div>

                                <div class="form-group">
                                    <label>Fats</label>
                                    <input type="text" name="fats" id="fats" class="form-control" placeholder="Enter fats">
                                </div>

                                <div class="form-group">
                                    <label>Day</label>
                                    <input type="text" name="day" id="day" class="form-control" placeholder="Enter day">
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
                                    <h4 class="text-black fs-20">Goal Wise Diet List</h4>
                                </div>

                                <div class="dropdown mt-sm-0 mt-3">
                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addNewPlan" class="btn btn-outline-primary rounded">Add New Goal Wise Diet</a>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example3" class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                        <thead>
                                            <tr>
                                                <th scope="col">Goal</th>
                                                <th scope="col">Diet</th>
                                                <!-- <th scope="col" class="text-end">Action</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($goalWiseDiets as $goalWiseDiet)
                                            <tr>
                                                <td>{{ $goalWiseDiet->goal->goal}}</td>
                                                <td>{{ $goalWiseDiet->diet->name}}</td>
                                                <!-- <td class="text-end">
                                                    <span>
                                                        <a href="javascript:void(0);" class="me-4 edit-goal-button" data-bs-toggle="modal" data-bs-target="#editGoal" data-goal='@json($goalWiseDiet)'>
                                                            <i class="fa fa-pencil color-muted"></i>
                                                        </a>
                                                        <a onclick="confirmDelete('{{ $goalWiseDiet->uuid }}')" data-bs-toggle="tooltip" data-placement="top" title="Close">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </span>
                                                </td> -->
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var editButtons = document.querySelectorAll('.edit-goal-button');

        editButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var goal = JSON.parse(this.dataset.goal);

                document.getElementById('editGoalId').value = goal.uuid;
                document.getElementById('editGoalName').value = goal.goal;
            });
        });

        const deleteButtons = document.querySelectorAll('.btn-delete');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const uuid = this.getAttribute('data-uuid');
                if (confirm('Are you sure you want to delete this goal?')) {
                    document.getElementById('delete-form-' + uuid).submit();
                }
            });
        });
    });

    function confirmDelete(uuid) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Are you sure you want to delete this goal?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/delete-goal/' + uuid;
            }
        });
    }
</script>
@include('CustomSweetAlert');
@endsection