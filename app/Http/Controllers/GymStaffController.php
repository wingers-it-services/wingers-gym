<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use App\Models\GymStaff;
use App\Models\Designation;
use App\Models\GymStaffAttendance;
use App\Traits\SessionTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GymStaffController extends Controller
{
    use SessionTrait;
    protected $gymStaff;
    protected $gym;
    protected $designation;
    protected $gymStaffAttendance;


    public function __construct(
        GymStaff $gymStaff,
        Gym $gym,
        Designation $designation,
        GymStaffAttendance $gymStaffAttendance
    ) {
        $this->gymStaff = $gymStaff;
        $this->gymStaffAttendance = $gymStaffAttendance;
        $this->gym = $gym;
        $this->designation = $designation;
    }

    public function addStaffAttendence()
    {

        return view('GymOwner.GymStaff.gymStaffAttendenceAdd');
    }

    public function listGymStaff()
    {
        $gymStaffs = $this->gymStaff->all();
        $gym_uuid = $this->getGymSession()['uuid'];
        $gymId = $this->gym->where('uuid', $gym_uuid)->first()->id;
        $gymStaffMembers = $this->gymStaff->where('gym_id', $gymId)->with('designation')->get();
        $designations = $this->designation->get();
        return view('GymOwner.gym-staf-list', compact('gymStaffMembers', 'designations'));
    }

    public function showAddGymStaff(Request $request)
    {
        $designations = $this->designation->get();
        return view('GymOwner.add-gym-staff', compact('designations'));
    }


    public function addGymStaff(Request $request)
    {
        try {
            $request->validate([
                "staff_id" => 'required',
                "full_name" => 'required',
                "email" => 'required',
                "phone_number" => 'required',
                "joining_date" => 'required',
                "salary" => 'required',
                "designation" => 'required',
                "blood_group" => 'required'
            ]);

            $gym_uuid = $this->getGymSession()['uuid'];
            $gymId = $this->gym->where('uuid', $gym_uuid)->first()->id;

            $imagePath = null;
            if ($request->hasFile('staff_photo')) {
                $staffPhoto = $request->file('staff_photo');
                $filename = time() . '_' . $staffPhoto->getClientOriginalName();
                $imagePath = 'gymStaff_images/' . $filename;
                $staffPhoto->move(public_path('gymStaff_images/'), $filename);
            }

            $this->gymStaff->addGymStaff($request->all(), $gymId, $imagePath);

            return redirect()->route('listGymStaff')->with('success', 'Data saved successfully.');
        } catch (\Throwable $th) {
            Log::error("[GymStaffController][addGymStaff] error " . $th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function markGymStaffAttendance(Request $request)
    {
        try {
            $request->validate([
                "gymId"            => 'required',
                "staffId"          => 'required',
                "attendanceStatus" => 'required'
            ]);

            $now = Carbon::now();
            $year = $now->year;
            $month = $now->month;
            $day = $now->day;

            $gym = $this->gymStaffAttendance->updateOrCreate([
                'gym_staff_id' => $request->staffId,
                'gym_id' => $request->gymId,
                'month' => $month,
                'year' => $year
            ], [
                'day' . $day => $request->attendanceStatus
            ]);

            return response()->json(['status' => 200, 'data' => $gym], 200);
        } catch (\Throwable $th) {
            Log::error("[GymStaffController][addGymStaff] error " . $th->getMessage());
            return response()->json(['status' => 200, 'data' => $gym], 500);
        }
    }


    public function fetchAttendanceChart(Request $request)
    {
        try {
            $request->validate([
                "gymId"   => 'required',
                "staffId" => 'required'
            ]);

            $now = Carbon::now();
            $year = $now->year;
            $month = $now->month;

            $gym = $this->gymStaffAttendance->where([
                'gym_staff_id' => $request->staffId,
                'gym_id' => $request->gymId,
                'month' => $month,
                'year' => $year
            ])->first();

            if (!$gym) {
                return response()->json([
                    'status' => 200,
                    'data' => [
                        "Absent"   => 0,
                        "Halfday"  => 0,
                        "WeekOff" => 0,
                        "Present"  => 0,
                        "Unmarked" => 30
                    ]
                ], 200);
            }

            $gym = $gym->toArray();
            $data = [
                "Absent"  => 0,
                "Halfday" => 0,
                "WeekOff" => 0,
                "Present" => 0,
                "Unmarked" => 0
            ];

            for ($i = 1; $i <= 31; $i++) {
                switch ($gym['day' . $i]) {
                    case 0.5:
                        $data["Halfday"] += 1;
                        break;
                    case 1:
                        $data["Present"] += 1;
                        break;
                    case 2:
                        $data["WeekOff"] += 1;
                        break;
                    case null:
                        $data["Unmarked"] += 1;
                        break;
                    default:
                        $data["Absent"] += 1;
                }
            }
            return response()->json([
                'status' => 200,
                'data'   => $data,
                'gym'    => $gym
            ], 200);
        } catch (\Throwable $th) {
            Log::error("[GymStaffController][addGymStaff] error " . $th->getMessage());
            return response()->json(['status' => 500, 'data' => $gym], 500);
        }
    }

    public function showUpdateStaff(Request $request, $uuid)
    {
        $gym_uuid = $this->getGymSession()['uuid'];
        $gymId = $this->gym->where('uuid', $gym_uuid)->first()->id;

        $staffDetail = $this->gymStaff->where('uuid', $uuid)->first();
        $designations = $this->designation->where('gym_id', $gymId)->get();
        return view('GymOwner.edit-gym-staff', compact('staffDetail', 'designations'));
    }

    public function updateStaff(Request $request)
    {
        try {

            $validatedData = $request->validate([
                'uuid' => 'required',
                'member_name' => 'required',
                'member_designation' => 'required',
                'salary' => 'required',
                'image' => 'nullable'
            ]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $gymImage = $request->file('image');
                $filename = time() . '_' . $gymImage->getClientOriginalName();
                $imagePath = 'gymStaff_images/' . $filename;
                $gymImage->move(public_path('gymStaff_images/'), $filename);
            }

            $isStaffUpdated = $this->gymStaff->updateStaff($validatedData, $imagePath);

            if (!$isStaffUpdated) {
                return redirect()->back()->with('status', 'error')->with('message', 'error while updating user.');
            }
            return redirect()->route('listGymStaff')->with('status', 'success')->with('message', 'Staff Updated successfully.');
        } catch (Exception $e) {
            Log::error('[GymStaffController][updateStaff] Error updating user ' . $e->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'error while updating user.');
        }
    }
    public function deleteGymStaff($uuid)
    {
        $gymStaff = $this->gymStaff->where('uuid', $uuid)->firstOrFail();
        $gymStaff->delete();
        return redirect()->back()->with('success', 'Staff deleted successfully!');
    }

    public function staffDetails()
    {
        $gymStaffs = $this->gymStaff->get();
        return view('GymOwner.staff-details', compact('gymStaffs'));
    }
}
