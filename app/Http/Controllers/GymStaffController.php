<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use App\Models\GymStaff;
use App\Models\Designation;
use App\Models\GymStaffAseet;
use App\Models\GymStaffAttendance;
use App\Models\GymStaffLeave;
use App\Models\GymWeekend;
use App\Models\Holiday;
use App\Models\StaffDocument;
use App\Traits\SessionTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GymStaffController extends Controller
{
    use SessionTrait;
    protected $gymStaff;
    protected $gym;
    protected $designation;
    protected $gymStaffAttendance;
    protected $staffAsset;
    protected $staffLeave;
    protected $staffDocument;


    public function __construct(
        GymStaff $gymStaff,
        Gym $gym,
        Designation $designation,
        GymStaffAttendance $gymStaffAttendance,
        GymStaffAseet $staffAsset,
        GymStaffLeave $staffLeave,
        StaffDocument $staffDocument
    ) {
        $this->gymStaff = $gymStaff;
        $this->gymStaffAttendance = $gymStaffAttendance;
        $this->gym = $gym;
        $this->designation = $designation;
        $this->staffAsset = $staffAsset;
        $this->staffLeave = $staffLeave;
        $this->staffDocument = $staffDocument;
    }

    public function addStaffAttendence()
    {

        return view('GymOwner.GymStaff.gymStaffAttendenceAdd');
    }

    public function listGymStaff()
    {
        $gymStaffs = $this->gymStaff->all();
        $gym = Auth::guard('gym')->user();
        $gymId = $this->gym->where('uuid', $gym->uuid)->first()->id;
        $gymStaffMembers = $this->gymStaff->where('gym_id', $gymId)->with('designation')->get();
        $designations = $this->designation->get();
        return view('GymOwner.gym-staf-list', compact('gymStaffMembers', 'designations'));
    }

    public function showAddGymStaff(Request $request)
    {
        $gym = Auth::guard('gym')->user();
        $gymId = $this->gym->where('uuid', $gym->uuid)->first()->id;

        $designations = $this->designation->where('gym_id', $gymId)->where('status', 1)->get();
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

            $gym = Auth::guard('gym')->user();
            $gymId = $this->gym->where('uuid', $gym->uuid)->first()->id;

            $imagePath = null;
            if ($request->hasFile('staff_photo')) {
                $staffPhoto = $request->file('staff_photo');
                $filename = time() . '_' . $staffPhoto->getClientOriginalName();
                $imagePath = 'gymStaff_images/' . $filename;
                $staffPhoto->move(public_path('gymStaff_images/'), $filename);
            }

            $this->gymStaff->addGymStaff($request->all(), $gymId, $imagePath);

            return redirect()->route('listGymStaff')->with('status', 'success')->with('message', 'Gym Staff saved successfully.');
        } catch (\Throwable $th) {
            Log::error("[GymStaffController][addGymStaff] error " . $th->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', $th->getMessage());
        }
    }

    public function markGymStaffAttendance(Request $request)
    {
        try {
            $request->validate([
                "gymId" => 'required',
                "staffId" => 'required',
                "attendanceStatus" => 'nullable', // Allow null to unmark attendance
                "day" => 'required' // Ensure the day is valid
            ]);

            $now = Carbon::now();
            $year = $now->year;
            $month = $now->month;

            // Prepare the data for the specific day
            $attendanceData = [];
            $attendanceField = 'day' . $request->day;

            // If attendanceStatus is null, unmark the day (set it to null)
            if (is_null($request->attendanceStatus)) {
                $attendanceData[$attendanceField] = null;
            } else {
                $attendanceData[$attendanceField] = $request->attendanceStatus;
            }

            // Check if the user already exists in the attendance table for the month
            $existingUser = GymStaffAttendance::where([
                'gym_staff_id' => $request->staffId,
                'gym_id' => $request->gymId,
                'month' => $month,
                'year' => $year
            ])->first();

            // If the user doesn't exist, store holidays and weekends
            if (!$existingUser) {
                // Store weekends and holidays in the attendance table
                $this->storeHolidaysAndWeekends($request->staffId, $request->staffId, $month, $year);
            }

            // Save attendance for the specific day
            $gymAttendance = GymStaffAttendance::updateOrCreate(
                [
                    'gym_staff_id' => $request->staffId,
                    'gym_id' => $request->gymId,
                    'month' => $month,
                    'year' => $year
                ],
                $attendanceData
            );

            return response()->json(['status' => 200, 'data' => $gymAttendance], 200);
        } catch (\Throwable $th) {
            Log::error("[GymStaffController][markGymStaffAttendance] error " . $th->getMessage());
            return response()->json(['status' => 500], 500);
        }
    }

    public function storeHolidaysAndWeekends($gymId, $staffId, $month, $year)
    {
        try {

            $holidays = Holiday::where('gym_id', $gymId)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->pluck('date')
            ->toArray();

            // Fetch weekends dynamically from the gym_weekends table
            $weekendDays = GymWeekend::where('gym_id', $gymId)
                ->pluck('weekend_day')  // Assuming 'weekend_day' stores day names like 'Sunday', 'Saturday'
                ->map(function ($day) {
                    return Carbon::parse($day)->dayOfWeek; // Convert day names to Carbon's dayOfWeek integer
                })
                ->toArray();

            // Fetch weekends for the given month based on gym-specific weekend days
            $weekends = [];
            for ($i = 1; $i <= Carbon::create($year, $month)->daysInMonth; $i++) {
                $day = Carbon::create($year, $month, $i);
                if (in_array($day->dayOfWeek, $weekendDays)) {
                    $weekends[] = $day->toDateString();
                }
            }

            // Find or create a new attendance record for the user for the given month
            $attendanceRecord = GymStaffAttendance::firstOrCreate(
                [
                    'gym_id' => $gymId,
                    'gym_staff_id' => $staffId,
                    'month' => $month,
                    'year' => $year
                ]
            );

            // Prepare the weekend fields to update (e.g., 'day1', 'day2', ..., 'dayX')
            $weekendAttendanceData = [];
            foreach ($weekends as $weekendDate) {
                $day = Carbon::parse($weekendDate)->day;
                $attendanceField = 'day' . $day;
                $weekendAttendanceData[$attendanceField] = \App\Enums\StaffAttendanceStatusEnum::WEEKEND; // 3 is for WEEKEND status, adjust this as necessary
            }

            $holidaysAttendanceData = [];
            foreach ($holidays as $holidayDate) {
                $day = Carbon::parse($holidayDate)->day;
                $attendanceField = 'day' . $day;
                $holidaysAttendanceData[$attendanceField] = \App\Enums\StaffAttendanceStatusEnum::HOLIDAY; 
            }


            // Update the attendance record with weekend days marked as '3'
            $attendanceRecord->update($weekendAttendanceData);
            $attendanceRecord->update($holidaysAttendanceData);

            return response()->json(['message' => 'Weekends stored successfully in attendance table.'], 200);
        } catch (\Exception $e) {
            Log::error("[GymStaffController][storeHolidaysAndWeekends] error " . $e->getMessage());
            return response()->json(['error' => 'Failed to store weekends in attendance table.'], 500);
        }
    }

    public function getGymHolidaysAndWeekends($gymId)
    {
        try {
            // Fetch holidays (date-wise)
            $holidays = Holiday::where('gym_id', $gymId)->pluck('date')->toArray();

            // Fetch weekends (day-wise)
            $weekends = GymWeekend::where('gym_id', $gymId)->pluck('weekend_day')->toArray();

            return response()->json([
                'status' => 200,
                'holidays' => $holidays, // Holidays array in 'YYYY-MM-DD' format
                'weekends' => $weekends, // Weekends array (days of the week, e.g., 0 for Sunday, 6 for Saturday)
            ], 200);
        } catch (\Throwable $th) {
            Log::error("[GymStaffController][getGymHolidaysAndWeekends] error " . $th->getMessage());
            return response()->json(['status' => 500], 500);
        }
    }



    public function fetchAttendanceChart(Request $request)
    {
        try {
            $request->validate([
                "gymId" => 'required',
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

            // Fetch holidays
            $holidays = Holiday::where('gym_id', $request->gymId)
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->pluck('date')
                ->toArray();

            // Fetch weekends dynamically from the gym_weekends table
            $weekendDays = GymWeekend::where('gym_id', $request->gymId)
                ->pluck('weekend_day')  // Assuming 'weekend_day' stores day names like 'Sunday', 'Saturday'
                ->map(function ($day) {
                    return Carbon::parse($day)->dayOfWeek; // Convert day names to Carbon's dayOfWeek integer
                })
                ->toArray();

            // Fetch weekends for the given month based on gym-specific weekend days
            $weekends = [];
            for ($i = 1; $i <= Carbon::create($year, $month)->daysInMonth; $i++) {
                $day = Carbon::create($year, $month, $i);
                if (in_array($day->dayOfWeek, $weekendDays)) {
                    $weekends[] = $day->toDateString();
                }
            }

             // Prepare the default data in case no attendance is marked
             if (!$gym) {
                return response()->json([
                    'status' => 200,
                    'data' => [
                        "Absent" => 0,
                        "Holiday" => count($holidays),
                        "Weekend" => count($weekends),
                        "WeekOff" => 0,
                        "Present" => 0,
                        "Unmarked" => Carbon::create($year, $month)->daysInMonth - count($holidays) - count($weekends)
                    ],
                    'holidays' => $holidays,
                    'weekends' => $weekends
                ], 200);
            }


            $gym = $gym->toArray();

            $data = [
                "Absent" => 0,
                "Halfday" => 0,
                "Holiday" => count($holidays),
                "Weekend" => count($weekends),
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
                    case null:
                        $data["Unmarked"] += 1;
                        break;
                    case 0:
                        $data["Absent"] += 1;
                }
            }
            return response()->json([
                'status' => 200,
                'data' => $data,
                'gym' => $gym,
                'holidays' => $holidays,
                'weekends' => $weekends
            ], 200);
        } catch (\Throwable $th) {
            Log::error("[GymStaffController][addGymStaff] error " . $th->getMessage());
            return response()->json(['status' => 500, 'data' => $gym], 500);
        }
    }

    public function showUpdateStaff(Request $request, $uuid)
    {
        $gym = Auth::guard('gym')->user();
        $gymId = $this->gym->where('uuid', $gym->uuid)->first()->id;

        $staffDetail = $this->gymStaff->where('uuid', $uuid)->first();
        $designations = $this->designation->where('gym_id', $gymId)->get();
        return view('GymOwner.edit-gym-staff', compact('staffDetail', 'designations'));
    }

    public function updateStaff(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'uuid' => 'required',
                "employee_id" => 'required',
                "full_name" => 'required',
                "email" => 'required',
                "phone_number" => 'required',
                "joining_date" => 'required',
                "salary" => 'required',
                "designation" => 'required',
                "address" => 'required',
                "blood_group" => 'nullable',
                "image" => 'nullable'
            ]);

            $staff = $this->gymStaff->where('uuid', $request->uuid)->first();
            $imagePath = $staff->image; // Default to existing image path

            if ($request->hasFile('image')) {
                if ($staff->image) {
                    $existingImagePath = public_path($staff->image);
                    if (file_exists($existingImagePath)) {
                        unlink($existingImagePath);
                    }
                }
                $imagefile = $request->file('image');
                $filename = time() . '_' . $imagefile->getClientOriginalName();
                $imagePath = 'gymStaff_images/' . $filename;
                $imagefile->move(public_path('gymStaff_images/'), $filename);
            }

            $data = $request->all();

            $isStaffUpdated = $this->gymStaff->updateStaff($data, $imagePath);

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
        return redirect()->back()->with('status', 'success')->with('message', 'Staff deleted successfully!');
    }

    public function staffDetails()
    {
        $gym = Auth::guard('gym')->user();
        $gymStaffs = $this->gymStaff->where('gym_id', $gym->id)->get();
        $staffDocs = $this->staffDocument->all();
        return view('GymOwner.staff-details', compact('gymStaffs', 'staffDocs'));
    }

    public function addStaffAsset(Request $request)
    {
        try {
            $request->validate([
                "staff_id" => 'required',
                "name" => 'required',
                "category" => 'required',
                "asset_tag" => 'required',
                "allocation_date" => 'required',
                "price" => 'required',
                "status" => 'required',
                "image" => 'required',
            ]);

            $gym = Auth::guard('gym')->user();
            $gymId = $this->gym->where('uuid', $gym->uuid)->first()->id;

            $imagePath = null;
            if ($request->hasFile('image')) {
                $assetPhoto = $request->file('image');
                $filename = time() . '_' . $assetPhoto->getClientOriginalName();
                $imagePath = 'gymStaff_asset_images/' . $filename;
                $assetPhoto->move(public_path('gymStaff_asset_images/'), $filename);
            }

            $this->staffAsset->addGymStaffAsset($request->all(), $gymId, $imagePath);

            return redirect()->back()->with('status', 'success')->with('message', 'Staff Asset added successfully.');
        } catch (\Throwable $th) {
            Log::error("[GymStaffController][addGymStaff] error " . $th->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', $th->getMessage());
        }
    }

    public function getStaffAssets($staffId)
    {
        $gym = Auth::guard('gym')->user();
        $assets = $this->staffAsset->where('gym_id', $gym->id)->where('staff_id', $staffId)->get();
        return response()->json($assets);
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $asset = $this->staffAsset->findOrFail($id);
            $asset->status = $request->input('status');
            $asset->save();

            return redirect()->back()->with('status', 'success')->with('message', 'Asset status updated successfully!');
        } catch (\Throwable $th) {
            Log::error("[GymStaffController][updateStatus] error " . $th->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', $th->getMessage());
        }
    }

    public function addStaffLeave(Request $request)
    {
        try {
            $request->validate([
                "staff_id" => 'required',
                "leave_type" => 'required',
                "start_date" => 'required',
                "end_date" => 'required',
                "reason" => 'nullable',
                "status" => 'required'
            ]);

            $gym = Auth::guard('gym')->user();
            $gymId = $this->gym->where('uuid', $gym->uuid)->first()->id;

            $this->staffLeave->addGymStaffLeave($request->all(), $gymId);

            return redirect()->back()->with('status', 'success')->with('message', 'Staff Leave added successfully.');
        } catch (\Throwable $th) {
            Log::error("[GymStaffController][addStaffLeave] error " . $th->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', $th->getMessage());
        }
    }

    public function getStaffLeaves($staffId)
    {
        $gym = Auth::guard('gym')->user();
        $leaves = $this->staffLeave->where('gym_id', $gym->id)->where('staff_id', $staffId)->get();
        return response()->json($leaves);
    }

    public function updateLeaveStatus(Request $request, $id)
    {
        try {
            $leave = $this->staffLeave->findOrFail($id);
            $leave->status = $request->input('status');
            $leave->save();

            return redirect()->back()->with('status', 'success')->with('message', 'Leave status updated successfully!');
        } catch (\Throwable $th) {
            Log::error("[GymStaffController][updateLeaveStatus] error " . $th->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', $th->getMessage());
        }
    }

    public function updateDocumentStatus(Request $request, $id)
    {
        try {
            $doc = $this->staffDocument->findOrFail($id);
            $doc->status = $request->input('status');
            $doc->save();

            return redirect()->back()->with('status', 'success')->with('message', 'Document status updated successfully!');
        } catch (\Throwable $th) {
            Log::error("[GymStaffController][updateDocumentStatus] error " . $th->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', $th->getMessage());
        }
    }

    public function addStaffDocuments(Request $request)
    {
        try {
            $request->validate([
                'document_name' => 'required',
                'file' => 'required|mimes:jpeg,png,jpg,pdf',
                'staff_id' => 'required'
            ]);

            $imagePath = null;
            if ($request->hasFile('file')) {
                $assetPhoto = $request->file('file');
                $filename = time() . '_' . $assetPhoto->getClientOriginalName();
                $imagePath = 'staff_documents/' . $filename;
                $assetPhoto->move(public_path('staff_documents/'), $filename);
            }


            $this->staffDocument->addDocuments($request->all(), $imagePath);
            return redirect()->back()->with('status', 'success')->with('message', 'Staff document added successfully.');
        } catch (Exception $e) {
            Log::error('[GymStaffController][addStaffDocuments] Error adding document ' . $e->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'error while adding document.');
        }
    }

    public function getStaffDocuments($staffId)
    {
        $gym = Auth::guard('gym')->user();
        $documents = $this->staffDocument->where('gym_id', $gym->id)->where('staff_id', $staffId)->get();
        return response()->json($documents);
    }
}
