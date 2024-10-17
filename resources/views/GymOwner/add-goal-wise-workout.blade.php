@extends('GymOwner.master')
@section('title', 'Goal Wise Workout')
@section('content')

<!--**********************************
            Content body start
***********************************-->

<style>
    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
        padding: 10px;
        text-align: center;
    }

    input[type="number"] {
        width: 50px;
    }
</style>

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
                            <h5 class="modal-title">Add New Goal Wise Workout</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('addGoalWiseWorkouts') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <!-- <div class="col-lg-12 col-sm-12 col-12"> -->
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
                                        <label>Level</label>
                                        <select id="user_lebel_id" name="user_lebel_id" class="form-control" required>
                                            <option value="" disabled selected>Select Level</option>
                                            @foreach($levels as $level)
                                            <option value="{{$level->id}}">{{$level->lebel}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Workout</label>
                                        <select id="workout_id" name="workout_id" class="form-control" required>
                                            <option value="" disabled selected>Select Workout</option>
                                            @foreach($workouts as $workout)
                                            <option value="{{$workout->id}}">{{$workout->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>No of Sets</label>
                                        <input type="text" name="sets" class="form-control" id="sets" placeholder="Enter No of sets">
                                    </div>

                                    <div class="form-group">
                                        <label>No of Reps</label>
                                        <input type="text" name="reps" id="reps" class="form-control" placeholder="Enter No of reps">
                                    </div>

                                    <div class="form-group">
                                        <label>Weight</label>
                                        <input type="text" name="weight" id="weight" class="form-control" placeholder="Enter weight">
                                    </div>

                                    <div class="form-group">
                                        <label>Day</label>
                                        <input type="text" name="day" id="day" class="form-control" placeholder="Enter day">
                                    </div>
                                    <!-- </div> -->
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
                                    <h4 class="text-black fs-20">Goal Wise Workout List</h4>
                                </div>

                                <div class="dropdown mt-sm-0 mt-3">
                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addNewPlan" class="btn btn-outline-primary rounded">Add New Goal Wise Workout</a>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <!-- <table id="example3" class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                        <thead>
                                            <tr>
                                                <th scope="col">Goal</th>
                                                <th scope="col">Workout</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($goalWiseWorkouts as $goalWiseWorkout)
                                            <tr>
                                                <td>{{ $goalWiseWorkout->goal->goal}}</td>
                                                <td>{{ $goalWiseWorkout->workout->name}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table> -->

                                    <!-- <table id="goalTable">
                                        <tr>
                                            <th>Goal</th>
                                            <th>Label</th>
                                            <th>Workout</th>
                                            <th>Set</th>
                                            <th>Rep</th>
                                            <th>Weight</th>
                                        </tr>
                                        <tr>
                                            <td>
                                                <select id="goalDropdown">
                                                    <option value="">Select Goal</option>
                                                    <option value="Goal1">Goal 1</option>
                                                    <option value="Goal2">Goal 2</option>
                                                    <option value="Goal3">Goal 3</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select id="labelDropdown">
                                                    <option value="">Select Label</option>
                                                    <option value="Label1">Label 1</option>
                                                    <option value="Label2">Label 2</option>
                                                    <option value="Label3">Label 3</option>
                                                </select>
                                            </td>
                                            <td colspan="4"></td> 
                                        </tr>
                                    </table> -->
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <!-- <h4 class="card-title">Goal Wise Workouts</h4> -->
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="card-content">
                                                                <div class="nestable">
                                                                    <div class="dd" id="nestable">
                                                                        <ol class="dd-list">
                                                                            <!-- Loop through goals -->
                                                                            @foreach($goals as $goal)
                                                                            <li class="dd-item dd-collapsed" data-id="{{ $goal->id }}">
                                                                                <div class="dd-handle">{{ $goal->goal }}</div> <!-- Goal -->
                                                                                <ol class="dd-list">
                                                                                    <!-- Loop through levels related to this goal -->
                                                                                    @foreach($goal->goalWiseWorkouts->groupBy('user_lebel_id') as $levelId => $workouts)
                                                                                    <li class="dd-item dd-collapsed" data-id="{{ $levelId }}">
                                                                                        <div class="dd-handle">{{ $workouts->first()->level->lebel }}</div> <!-- Level -->
                                                                                        <ol class="dd-list">
                                                                                            <!-- Loop through days of the week -->
                                                                                            @foreach($days as $day)
                                                                                            <li class="dd-item dd-collapsed">
                                                                                                <div class="dd-handle">{{ $day }}</div> <!-- Day -->
                                                                                                <ol class="dd-list">
                                                                                                    <!-- Loop through workouts for this day -->
                                                                                                    @foreach($workouts as $workout)
                                                                                                    @if($workout->day == $day)
                                                                                                    <div class="row">
                                                                                                        <div class="col-3">
                                                                                                            <li class="dd-item">
                                                                                                                <div class="dd-handle">
                                                                                                                    {{ $workout->workout->name }}
                                                                                                                </div>
                                                                                                            </li>
                                                                                                        </div>
                                                                                                        <div class="col-3">
                                                                                                            <li class="dd-item">
                                                                                                                <div class="dd-handle">
                                                                                                                    Sets: {{ $workout->sets }} <br>
                                                                                                                </div>
                                                                                                            </li>
                                                                                                        </div>
                                                                                                        <div class="col-3">
                                                                                                            <li class="dd-item">
                                                                                                                <div class="dd-handle">
                                                                                                                    Reps: {{ $workout->reps }}
                                                                                                                </div>
                                                                                                            </li>
                                                                                                        </div>
                                                                                                        <div class="col-3">
                                                                                                            <li class="dd-item">
                                                                                                                <div class="dd-handle">
                                                                                                                    Weight: {{ $workout->weight }} kg
                                                                                                                </div>
                                                                                                            </li>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    @endif
                                                                                                    @endforeach
                                                                                                </ol>
                                                                                            </li>
                                                                                            @endforeach
                                                                                        </ol>
                                                                                    </li>
                                                                                    @endforeach
                                                                                </ol>
                                                                            </li>
                                                                            @endforeach
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

<script>
    document.getElementById('labelDropdown').addEventListener('change', function() {
        const selectedLabel = this.value;
        const table = document.getElementById('goalTable');

        // Clear previous rows if they exist
        const existingRows = document.querySelectorAll('.dayRow');
        existingRows.forEach(row => row.remove());

        if (selectedLabel) {
            const days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

            // Add a row for each day of the week
            days.forEach(day => {
                const newRow = table.insertRow();
                newRow.classList.add('dayRow');

                // Create and populate cells
                const goalCell = newRow.insertCell(0); // Empty Goal cell
                const dayCell = newRow.insertCell(1); // Day in Label column

                goalCell.textContent = ""; // Leave goal column empty
                dayCell.textContent = day; // Set day in label column

                // Workout dropdown
                const workoutCell = newRow.insertCell(2);
                const workoutSelect = document.createElement('select');
                workoutSelect.innerHTML = `
                    <option value="">Select Workout</option>
                    <option value="Workout1">Workout 1</option>
                    <option value="Workout2">Workout 2</option>
                    <option value="Workout3">Workout 3</option>
                `;
                workoutCell.appendChild(workoutSelect);

                // Set input
                const setCell = newRow.insertCell(3);
                const setInput = document.createElement('input');
                setInput.type = 'number';
                setInput.placeholder = 'Set';
                setCell.appendChild(setInput);

                // Rep input
                const repCell = newRow.insertCell(4);
                const repInput = document.createElement('input');
                repInput.type = 'number';
                repInput.placeholder = 'Rep';
                repCell.appendChild(repInput);

                // Weight input
                const weightCell = newRow.insertCell(5);
                const weightInput = document.createElement('input');
                weightInput.type = 'number';
                weightInput.placeholder = 'Weight';
                weightCell.appendChild(weightInput);
            });
        }
    });
</script>

<script src="{{asset('vendor/global/global.min.js')}}" type="text/javascript"></script>
<script src="{{asset('vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}" type="text/javascript"></script>
<script src="{{asset('vendor/nestable2/js/jquery.nestable.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/plugins-init/nestable-init.js')}}" type="text/javascript"></script>
<script src="{{asset('js/custom.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/deznav-init.js')}}" type="text/javascript"></script>

@include('CustomSweetAlert');
@endsection