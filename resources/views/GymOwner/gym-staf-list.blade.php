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
                     <div class="card-body">
                         <div class="table-responsive">
                             <table id="example3" class="display min-w850">
                                 <thead>
                                     <tr>
                                         <th>Employee Id</th>
                                         <th>Image</th>
                                         <th>Name</th>
                                         <th>Designation</th>
                                         <th>Salary</th>
                                         <th>Phone</th>
                                         <th>Blood Group</th>
                                         <th>Joined</th>
                                         <th>Action</th>
                                     </tr>
                                 </thead>
                                 <tbody id="customers">
                                     @foreach ($gymStaffMembers as $gymStaffMember)
                                     <tr class="btn-reveal-trigger">
                                         <td class="py-2">
                                             <div class="form-check custom-checkbox mx-2">
                                                 {{ $gymStaffMember->employee_id }}
                                             </div>
                                         </td>
                                         <td class="py-3">
                                             <a href="#">
                                                 <div class="media d-flex align-items-center">
                                                     <div class="avatar avatar-xl me-2">
                                                         <div class=""><img class="rounded-circle img-fluid" src="{{ $gymStaffMember->image }}" width="30" alt="image">
                                                         </div>
                                                     </div>
                                                 </div>
                                             </a>
                                         </td>
                                         <td>
                                             <div class="media-body">
                                                 <h5 class="mb-0 fs--1">{{ $gymStaffMember->name }}</h5>
                                             </div>
                                         </td>
                                         <td class="py-2">
                                             {{ isset($gymStaffMember->designation->designation_name) ? $gymStaffMember->designation->designation_name : '--' }}
                                         </td>
                                         <td class="py-2">&#8377; {{ $gymStaffMember->salary }}</td>
                                         <td class="py-2"> <a href="tel:{{ $gymStaffMember->number }}">{{ $gymStaffMember->number }}</a>
                                         </td>
                                         <td class="py-2 text-center">{{ $gymStaffMember->blood_group }}</td>
                                         <td class="py-2">{{ $gymStaffMember->joining_date }}</td>
                                         <td>
                                             <!-- Edit Button -->
                                             <a href="/editStaff/{{ $gymStaffMember->uuid }}" data-bs-toggle="tooltip" data-placement="top" title="Edit">
                                                 <i class="fa fa-pencil color-muted"></i>
                                             </a>
                                             &nbsp; &nbsp;
                                             <!-- Delete Button -->
                                             <a href="javascript:void(0);" onclick="confirmDelete('{{ $gymStaffMember->uuid }}')" data-bs-toggle="tooltip" data-placement="top" title="Close">
                                                 <i class="fas fa-trash"> </i>
                                             </a>
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
 <script>
     function confirmDelete(uuid) {
         Swal.fire({
             title: 'Are you sure?',
             text: 'Are you sure you want to delete this subscription? It will delete the related industries.',
             icon: 'warning',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Yes, delete it!'
         }).then((result) => {
             if (result.isConfirmed) {
                 window.location.href = '/deleteGymStaff/' + uuid;
             }
         });
     }
 </script>
 @include('CustomSweetAlert');
 @endsection