 @extends('GymOwner.master')
 @section('title', 'Dashboard')
 @section('content')

     <!--**********************************
                        Content body start
                    ***********************************-->
     <div class="content-body ">
         <div class="container-fluid">
             <div class="row">
                 <div class="col-lg-12">
                     <div class="card">
                         {{-- <div class="card-body">
                             <div class="table-responsive">
                                 <table class="table table-sm mb-0 table-striped">
                                     <thead>
                                         <tr>
                                             <th>Staff Id</th>
                                             <th>Name</th>
                                             <th>Designation</th>
                                             <th>Salary</th>
                                             <th>Phone</th>
                                             <th>Blood Group</th>
                                             <th>Joined</th>
                                             <th class="text-end">Action</th>
                                         </tr>
                                     </thead>
                                     <tbody id="customers">
                                         @foreach ($gymStaffMembers as $gymStaffMember)
                                             <tr class="btn-reveal-trigger">
                                                 <td class="py-2">
                                                     <div class="form-check custom-checkbox mx-2">
                                                         {{ $gymStaffMember->id }}
                                                     </div>
                                                 </td>
                                                 <td class="py-3">
                                                     <a href="#">
                                                         <div class="media d-flex align-items-center">
                                                             <div class="avatar avatar-xl me-2">
                                                                 <div class=""><img class="rounded-circle img-fluid"
                                                                         src="{{ $gymStaffMember->image }}" width="30"
                                                                         alt="image">
                                                                 </div>
                                                             </div>
                                                             <div class="media-body">
                                                                 <h5 class="mb-0 fs--1">{{ $gymStaffMember->name }}</h5>
                                                             </div>
                                                         </div>
                                                     </a>
                                                 </td>
                                                 <td class="py-2">
                                                     {{ isset($gymStaffMember->designation->designation_name) ? $gymStaffMember->designation->designation_name : '--' }}
                                                 </td>
                                                 <td class="py-2">&#8377; {{ $gymStaffMember->salary }}</td>
                                                 <td class="py-2"> <a
                                                         href="tel:{{ $gymStaffMember->number }}">{{ $gymStaffMember->number }}</a>
                                                 </td>
                                                 <td class="py-2">{{ $gymStaffMember->blood_group }}</td>
                                                 <td class="py-2">{{ $gymStaffMember->joining_date }}</td>
                                                 <td class="py-2 text-end">
                                                     <div class="dropdown"><button
                                                             class="btn btn-primary tp-btn-light sharp" type="button"
                                                             data-bs-toggle="dropdown"><span class="fs--1"><svg
                                                                     xmlns="http://www.w3.org/2000/svg"
                                                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                     width="18px" height="18px" viewBox="0 0 24 24"
                                                                     version="1.1">
                                                                     <g stroke="none" stroke-width="1" fill="none"
                                                                         fill-rule="evenodd">
                                                                         <rect x="0" y="0" width="24" height="24">
                                                                         </rect>
                                                                         <circle fill="#000000" cx="5"
                                                                             cy="12" r="2"></circle>
                                                                         <circle fill="#000000" cx="12"
                                                                             cy="12" r="2"></circle>
                                                                         <circle fill="#000000" cx="19"
                                                                             cy="12" r="2"></circle>
                                                                     </g>
                                                                 </svg></span></button>
                                                         <div class="dropdown-menu dropdown-menu-end border py-0">
                                                             <div class="py-2">
                                                                 <a class="dropdown-item"
                                                                     href="/editStaff/{{ $gymStaffMember->uuid }}">Edit</a>
                                                                 <form method="POST"
                                                                     action="{{ route('deleteGymStaff', $gymStaffMember->uuid) }}">
                                                                     @csrf
                                                                     @method('DELETE')
                                                                     <button type="submit"
                                                                         class="dropdown-item text-danger">Delete</button>
                                                                 </form>

                                                             </div>
                                                         </div>
                                                     </div>
                                                 </td>
                                             </tr>
                                         @endforeach

                                     </tbody>
                                 </table>
                             </div>
                         </div> --}}

                     <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display min-w850">
                                <thead>
                                    <tr>
                                        <th>Staff Id</th>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Salary</th>
                                        <th>Phone</th>
                                        <th>Blood Group</th>
                                        <th>Joined</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="customers">
                                    @foreach ($gymStaffMembers as $gymStaffMember)
                                        <tr class="btn-reveal-trigger">
                                            <td class="py-2">
                                                <div class="form-check custom-checkbox mx-2">
                                                    {{ $gymStaffMember->id }}
                                                </div>
                                            </td>
                                            <td class="py-3">
                                                <a href="#">
                                                    <div class="media d-flex align-items-center">
                                                        <div class="avatar avatar-xl me-2">
                                                            <div class=""><img class="rounded-circle img-fluid"
                                                                    src="{{ $gymStaffMember->image }}" width="30"
                                                                    alt="image">
                                                            </div>
                                                        </div>
                                                        <div class="media-body">
                                                            <h5 class="mb-0 fs--1">{{ $gymStaffMember->name }}</h5>
                                                        </div>
                                                    </div>
                                                </a>
                                            </td>
                                            <td class="py-2">
                                                {{ isset($gymStaffMember->designation->designation_name) ? $gymStaffMember->designation->designation_name : '--' }}
                                            </td>
                                            <td class="py-2">&#8377; {{ $gymStaffMember->salary }}</td>
                                            <td class="py-2"> <a
                                                    href="tel:{{ $gymStaffMember->number }}">{{ $gymStaffMember->number }}</a>
                                            </td>
                                            <td class="py-2">{{ $gymStaffMember->blood_group }}</td>
                                            <td class="py-2">{{ $gymStaffMember->joining_date }}</td>
                                            <td class="py-2 text-end">
                                                <div class="dropdown"><button
                                                        class="btn btn-primary tp-btn-light sharp" type="button"
                                                        data-bs-toggle="dropdown"><span class="fs--1"><svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                width="18px" height="18px" viewBox="0 0 24 24"
                                                                version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none"
                                                                    fill-rule="evenodd">
                                                                    <rect x="0" y="0" width="24" height="24">
                                                                    </rect>
                                                                    <circle fill="#000000" cx="5"
                                                                        cy="12" r="2"></circle>
                                                                    <circle fill="#000000" cx="12"
                                                                        cy="12" r="2"></circle>
                                                                    <circle fill="#000000" cx="19"
                                                                        cy="12" r="2"></circle>
                                                                </g>
                                                            </svg></span></button>
                                                    <div class="dropdown-menu dropdown-menu-end border py-0">
                                                        <div class="py-2">
                                                            <a class="dropdown-item"
                                                                href="/editStaff/{{ $gymStaffMember->uuid }}">Edit</a>
                                                            <form method="POST"
                                                                action="{{ route('deleteGymStaff', $gymStaffMember->uuid) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="dropdown-item text-danger">Delete</button>
                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>
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
     <!--**********************************
                        Content body end
                    ***********************************-->
 @endsection
