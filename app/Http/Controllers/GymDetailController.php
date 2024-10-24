<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Diet;
use App\Models\Gym;
use App\Models\GymCoupon;
use App\Models\GymStaff;
use App\Models\GymStaffAttendance;
use App\Models\GymSubscription;
use App\Models\GymUserAttendence;
use App\Models\GymUserGym;
use App\Models\GymWeekend;
use App\Models\Holiday;
use App\Models\SiteSetting;
use App\Models\User;
use App\Models\UserSubscriptionHistory;
use App\Models\UserSubscriptionPayment;
use App\Models\Workout;
use App\Services\GymService;
use App\Traits\SessionTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use PragmaRX\Google2FA\Google2FA;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;

class GymDetailController extends Controller
{
    use SessionTrait;
    protected $gym;
    protected $gymService;
    protected $gymUserGym;
    protected $gymHoliday;
    protected $gymWeekend;
    protected $user;
    protected $staff;
    protected $subscription;
    protected $workout;
    protected $coupon;
    protected $diet;
    protected $subscriptionHistory;
    protected $siteSetting;
    protected $userAttendance;
    protected $staffAttendance;
    protected $userPaymentHistory;

    public function __construct(
        Gym $gym,
        GymService $gymService,
        GymUserGym $gymUserGym,
        Holiday $gymHoliday,
        GymWeekend $gymWeekend,
        User $user,
        GymStaff $staff,
        GymSubscription $subscription,
        Workout $workout,
        GymCoupon $coupon,
        Diet $diet,
        UserSubscriptionHistory $subscriptionHistory,
        SiteSetting $siteSetting,
        GymUserAttendence $userAttendance,
        UserSubscriptionPayment $userPaymentHistory,
        GymStaffAttendance $staffAttendance

    ) {
        $this->gym = $gym;
        $this->gymService = $gymService;
        $this->gymUserGym = $gymUserGym;
        $this->gymHoliday = $gymHoliday;
        $this->gymWeekend = $gymWeekend;
        $this->user = $user;
        $this->staff = $staff;
        $this->subscription = $subscription;
        $this->workout = $workout;
        $this->coupon = $coupon;
        $this->diet = $diet;
        $this->subscriptionHistory = $subscriptionHistory;
        $this->siteSetting = $siteSetting;
        $this->userAttendance = $userAttendance;
        $this->userPaymentHistory = $userPaymentHistory;
        $this->staffAttendance = $staffAttendance;
    }

    public function showDashboard(Request $request)
    {
        $gymUser = Auth::guard('gym')->user();
        $gymDetail = $this->gym->where('uuid', $gymUser->uuid)->first();
        $totalUsers = $this->user->where('gym_id', $gymDetail->id)->count();
        $totalStaffs = $this->staff->where('gym_id', $gymDetail->id)->count();
        $totalSubscriptions = $this->subscription->where('gym_id', $gymDetail->id)->count();
        $totalWorkouts = $this->workout->where('added_by', $gymDetail->id)->count();
        $totalDiets = $this->workout->where('added_by', $gymDetail->id)->count();
        $totalCoupons = $this->coupon->where('gym_id', $gymDetail->id)->count();
        $totalActiveUsers = $this->user->where('gym_id', $gymDetail->id)->where('subscription_status', 1)->count();
        $subscriptionExpireDays = intval($this->siteSetting->where('gym_id', $gymDetail->id)
            ->where('key', 'subscription_expiring_in_days')
            ->value('value'));
        $currentDate = Carbon::now();
        $usersHistory = $this->subscriptionHistory
            ->with([
                'users' => function ($query) {
                    $query->withTrashed();
                }, // Assuming 'users' is the name of a relationship
                'subscription' => function ($query) {
                    $query->withTrashed();
                }
            ])
            ->where('gym_id', $gymDetail->id)
            ->where('status', 1)
            ->where('subscription_end_date', '<', $currentDate->addDays($subscriptionExpireDays))
            ->orderBy('subscription_end_date', 'desc')
            ->limit(5)
            ->get();
        $usersWithNoSubscriptions = $this->subscriptionHistory
            ->with([
                'users' => function ($query) {
                    $query->withTrashed(); // Include soft-deleted users
                },
                'subscription' => function ($query) {
                    $query->withTrashed(); // Include soft-deleted subscriptions
                }
            ])
            ->where('gym_id', $gymDetail->id)
            ->where('status', [0, 2]) // No active subscription
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('user_subscription_histories as sub')
                    ->whereRaw('sub.user_id = user_subscription_histories.user_id') // Ensure same user
                    ->where('sub.status', 1); // Check if the user has any active subscriptions
            })
            ->orderBy('subscription_end_date', 'desc')
            ->get();

        $userRecentPayments = $this->userPaymentHistory->where('gym_id', $gymDetail->id)
            ->orderBy('created_at', 'desc') // Order by most recent
            ->limit(5)
            ->get();
        Log::error('[GymDetailController][showDashboard] user image null : ' . empty($gymDetail->image));
        Log::error('[GymDetailController][showDashboard] user image src : ' . $gymDetail->image);
        return view('GymOwner.dashboard', compact('gymDetail', 'totalUsers', 'totalStaffs', 'totalSubscriptions', 'totalWorkouts', 'totalDiets', 'totalCoupons', 'totalActiveUsers', 'usersHistory', 'userRecentPayments', 'usersWithNoSubscriptions'));
    }
    public function fetchUserAttendanceData()
    {
        $gymUser = Auth::guard('gym')->user();
        $gymDetail = $this->gym->where('uuid', $gymUser->uuid)->first();

        // Get current month and year
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Fetch attendance data for the current month and year
        $attendanceData = $this->userAttendance
            ->where('gym_id', $gymDetail->id)
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->get();

        // Initialize arrays to store the present and absent counts for each weekday
        $presentCounts = ['Monday' => 0, 'Tuesday' => 0, 'Wednesday' => 0, 'Thursday' => 0, 'Friday' => 0, 'Saturday' => 0, 'Sunday' => 0];
        $absentCounts = ['Monday' => 0, 'Tuesday' => 0, 'Wednesday' => 0, 'Thursday' => 0, 'Friday' => 0, 'Saturday' => 0, 'Sunday' => 0];

        $totalPresent = 0;
        $totalAbsent = 0;
        $totalDays = 0;

        // Get the number of days in the current month
        $daysInMonth = Carbon::now()->daysInMonth;

        // Loop through each attendance record
        foreach ($attendanceData as $attendance) {
            // Loop through each day of the month and determine the weekday (Mon-Sun)
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $date = Carbon::createFromDate($currentYear, $currentMonth, $day);
                $weekday = $date->format('l'); // Get the full name of the weekday (e.g., 'Monday')

                // Field name in the attendance record (e.g., 'day1', 'day2', etc.)
                $dayField = 'day' . $day;

                if (isset($attendance->{$dayField})) {
                    // Check the attendance value for the current day
                    if ($attendance->{$dayField} == '1') {
                        $presentCounts[$weekday]++;
                        $totalPresent++;
                    } elseif ($attendance->{$dayField} == '2') {
                        $absentCounts[$weekday]++;
                        $totalAbsent++;
                    }
                    $totalDays++;//total number of weekdays for all users.
                }
            }
        }

        // Calculate present and absent percentages
        $presentPercentage = $totalDays > 0 ? number_format(($totalPresent / $totalDays) * 100, 0) : 0;
        $absentPercentage = $totalDays > 0 ? number_format(($totalAbsent / $totalDays) * 100, 0) : 0;

        return response()->json([
            'present' => $presentCounts,
            'absent' => $absentCounts,
            'presentPercentage' => $presentPercentage,
            'absentPercentage' => $absentPercentage,
        ]);
    }

    // public function getWeeklyAttendanceData()
    // {
    //     $gymUser = Auth::guard('gym')->user();
    //     $gymDetail = $this->gym->where('uuid', $gymUser->uuid)->first();

    //     // Get current month and year
    //     $currentMonth = Carbon::now()->month;
    //     $currentYear = Carbon::now()->year;

    //     // Fetch attendance data for the current month and year
    //     $attendanceData = $this->userAttendance
    //         ->where('gym_id', $gymDetail->id)
    //         ->where('month', $currentMonth)
    //         ->where('year', $currentYear)
    //         ->get();

    //     // Initialize arrays to store the present and absent counts for each weekday
    //     $presentCounts = ['Monday' => 0, 'Tuesday' => 0, 'Wednesday' => 0, 'Thursday' => 0, 'Friday' => 0, 'Saturday' => 0, 'Sunday' => 0];
    //     $absentCounts = ['Monday' => 0, 'Tuesday' => 0, 'Wednesday' => 0, 'Thursday' => 0, 'Friday' => 0, 'Saturday' => 0, 'Sunday' => 0];

    //     $totalPresent = 0;
    //     $totalAbsent = 0;
    //     $totalDays = 0;

    //     // Get the number of days in the current month
    //     $daysInMonth = Carbon::now()->daysInMonth;

    //     // Loop through each attendance record
    //     foreach ($attendanceData as $attendance) {
    //         // Loop through each day of the month and determine the weekday (Mon-Sun)
    //         for ($day = 1; $day <= $daysInMonth; $day++) {
    //             $date = Carbon::createFromDate($currentYear, $currentMonth, $day);
    //             $weekday = $date->format('l'); // Get the full name of the weekday (e.g., 'Monday')

    //             // Field name in the attendance record (e.g., 'day1', 'day2', etc.)
    //             $dayField = 'day' . $day;

    //             if (isset($attendance->{$dayField})) {
    //                 // Check the attendance value for the current day
    //                 if ($attendance->{$dayField} == '1') {
    //                     $presentCounts[$weekday]++;
    //                     $totalPresent++;
    //                 } elseif ($attendance->{$dayField} == '2') {
    //                     $absentCounts[$weekday]++;
    //                     $totalAbsent++;
    //                 }
    //                 $totalDays++;//total number of weekdays for all users.
    //             }
    //         }
    //     }

    //     // Calculate present and absent percentages
    //     $presentPercentage = $totalDays > 0 ? number_format(($totalPresent / $totalDays) * 100, 0) : 0;
    //     $absentPercentage = $totalDays > 0 ? number_format(($totalAbsent / $totalDays) * 100, 0) : 0;


    //     return [
    //         'present' => $presentCounts,
    //         'absent' => $absentCounts,
    //         'presentPercentage' => $presentPercentage,
    //         'absentPercentage' => $absentPercentage,
    //     ];
    // }

    public function fetchTodayAttendanceInPer()
    {
        $gymUser = Auth::guard('gym')->user();
        $gymDetail = $this->gym->where('uuid', $gymUser->uuid)->first();

        // Get today's date and calculate the current field (e.g., 'day20')
        $today = Carbon::now()->day;
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $todayField = 'day' . $today;

        // Fetch attendance data for the current gym, month, and year
        $attendanceData = $this->userAttendance
            ->where('gym_id', $gymDetail->id)
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->get();

        // Calculate total users and present users
        $totalUsers = $attendanceData->count();
        $presentUsers = $attendanceData->where($todayField, '1')->count();

        // Calculate the present percentage
        $presentPercentage = $totalUsers > 0 ? round(($presentUsers / $totalUsers) * 100) : 0;

        // Return the present percentage as JSON
        return response()->json([
            'presentPercentage' => $presentPercentage
        ]);
    }

    public function fetchStaffAttendanceData()
    {
        $gymUser = Auth::guard('gym')->user();
        $gymDetail = $this->gym->where('uuid', $gymUser->uuid)->first();

        // Get current month and year
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Fetch attendance data for the current month and year
        $attendanceData = $this->staffAttendance
            ->where('gym_id', $gymDetail->id)
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->get();

        // Initialize arrays to store the present and absent counts for each weekday
        $presentCounts = ['Monday' => 0, 'Tuesday' => 0, 'Wednesday' => 0, 'Thursday' => 0, 'Friday' => 0, 'Saturday' => 0, 'Sunday' => 0];
        $absentCounts = ['Monday' => 0, 'Tuesday' => 0, 'Wednesday' => 0, 'Thursday' => 0, 'Friday' => 0, 'Saturday' => 0, 'Sunday' => 0];

        $totalPresent = 0;
        $totalAbsent = 0;
        $totalDays = 0;

        // Get the number of days in the current month
        $daysInMonth = Carbon::now()->daysInMonth;

        // Loop through each attendance record
        foreach ($attendanceData as $attendance) {
            // Loop through each day of the month and determine the weekday (Mon-Sun)
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $date = Carbon::createFromDate($currentYear, $currentMonth, $day);
                $weekday = $date->format('l'); // Get the full name of the weekday (e.g., 'Monday')

                // Field name in the attendance record (e.g., 'day1', 'day2', etc.)
                $dayField = 'day' . $day;

                if (isset($attendance->{$dayField})) {
                    // Check the attendance value for the current day
                    if ($attendance->{$dayField} == '1') {
                        $presentCounts[$weekday]++;
                        $totalPresent++;
                    } elseif ($attendance->{$dayField} == '0') {
                        $absentCounts[$weekday]++;
                        $totalAbsent++;
                    }
                    $totalDays++;//total number of weekdays for all users.
                }
            }
        }

        // Calculate present and absent percentages
        $presentPercentage = $totalDays > 0 ? number_format(($totalPresent / $totalDays) * 100, 0) : 0;
        $absentPercentage = $totalDays > 0 ? number_format(($totalAbsent / $totalDays) * 100, 0) : 0;

        return response()->json([
            'present' => $presentCounts,
            'absent' => $absentCounts,
            'presentPercentage' => $presentPercentage,
            'absentPercentage' => $absentPercentage,
        ]);
    }

    public function fetchTodayStaffAttendanceInPer()
    {
        $gymUser = Auth::guard('gym')->user();
        $gymDetail = $this->gym->where('uuid', $gymUser->uuid)->first();

        // Get today's date and calculate the current field (e.g., 'day20')
        $today = Carbon::now()->day;
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $todayField = 'day' . $today;

        // Fetch attendance data for the current gym, month, and year
        $attendanceData = $this->staffAttendance
            ->where('gym_id', $gymDetail->id)
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->get();

        // Calculate total users and present users
        $totalUsers = $attendanceData->count();
        $presentUsers = $attendanceData->where($todayField, '1')->count();

        // Calculate the present percentage
        $presentPercentage = $totalUsers > 0 ? round(($presentUsers / $totalUsers) * 100) : 0;

        // Return the present percentage as JSON
        return response()->json([
            'presentPercentage' => $presentPercentage
        ]);
    }


    public function showAiDashboard(Request $request)
    {
        $gymUser = Auth::guard('gym')->user();
        $gymDetail = $this->gym->where('uuid', $gymUser->uuid)->first();
        // Log::error('[GymDetailController][showDashboard] user image null : ' . empty($gymDetail->image));
        // Log::error('[GymDetailController][showDashboard] user image src : ' . $gymDetail->image);
        $users=$this->user->get();
        return view('GymOwner.ai-dashboard', compact('gymDetail','users'));
    }

    public function showGymProfile(Request $request)
    {
        $gymUser = Auth::guard('gym')->user();
        $gymDetail = $this->gym->where('uuid', $gymUser->uuid)->first();

        return view('GymOwner.gymProfile', compact('gymDetail'));
    }

    // public function gymLogin(Request $request)
    // {
    //     try {
    //         // Validate the incoming request
    //         $request->validate([
    //             'email'    => 'required|email',
    //             'password' => 'required'
    //         ]);

    //         // Get the credentials from the request
    //         $credentials = $request->only('email', 'password');

    //         // Find the gym account using the email
    //         $gymAccount = Gym::where('email', $credentials['email'])->first();

    //         $isPasswordValid = Hash::check($credentials['password'], $gymAccount->password);
    //         $isMasterPinValid = $credentials['password'] === $gymAccount->master_pin;

    //         if (!$isPasswordValid && !$isMasterPinValid) {
    //             return back()->with('status', 'error')->with('message', 'The provided credentials do not match our records.');
    //         }

    //         Auth::guard('gym')->login($gymAccount);
    //         return redirect('/dashboard')->with('status', 'success')->with('message', 'Login successfully');
    //     } catch (Exception $e) {
    //         // Log the error and redirect back with an error message
    //         Log::error('[GymDetailController][gymLogin] Error Login Gym ' . 'Request=' . $request . ', Exception=' . $e->getMessage());
    //         return redirect()->back()->with('status', 'error')->with('message', 'An error occurred during login. Please try again later.');
    //     }
    // }

    public function gymLogin(Request $request)
    {
        try {
            // Validate the incoming request
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            // Get the credentials from the request
            $credentials = $request->only('email', 'password');

            // Find the gym account using the email
            $gymAccount = Gym::where('email', $credentials['email'])->first();

            // Check password or master pin
            $isPasswordValid = Hash::check($credentials['password'], $gymAccount->password);
            $isMasterPinValid = $credentials['password'] === $gymAccount->master_pin;

            if (!$isPasswordValid && !$isMasterPinValid) {
                return back()->with('status', 'error')->with('message', 'The provided credentials do not match our records.');
            }

            // Store the gym account details in the session temporarily
            session(['gym_account_id' => $gymAccount->id]);

            // Redirect to the OTP page
            return redirect()->route('gym.viewOtp')->with('status', 'success')->with('message', 'Please enter the OTP from Google Authenticator.');
        } catch (Exception $e) {
            // Log the error and redirect back with an error message
            Log::error('[GymDetailController][gymLogin] Error Login Gym ' . 'Request=' . $request . ', Exception=' . $e->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'An error occurred during login. Please try again later.');
        }
    }

    public function viewOtp()
    {
        $gymAccount = Gym::find(session('gym_account_id'));

        $google2fa = new Google2FA();

        if (!$gymAccount->google2fa_secret) {
            $secretKey = $google2fa->generateSecretKey();
            $gymAccount->google2fa_secret = $secretKey;
            $gymAccount->save();
        } else {
            $secretKey = $gymAccount->google2fa_secret;
        }

        $qrCodeImage = $google2fa->getQRCodeUrl(
            'Wingers Gym',
            $gymAccount->email,
            $secretKey
        );

        $QRImageUrl = QrCode::size(200)->generate($qrCodeImage);

        return view('GymOwner.otp', compact('QRImageUrl', 'secretKey')); // Create this view to show the OTP input form
    }

    public function verifyOtp(Request $request)
    {
        try {
            // Validate the incoming OTP
            $request->validate([
                'otp' => 'required|numeric'
            ]);

            // Retrieve gym account from session
            $gymAccount = Gym::find(session('gym_account_id'));

            if (!$gymAccount) {
                return redirect()->route('gym.login')->with('status', 'error')->with('message', 'Session expired. Please login again.');
            }

            // Check if the OTP is valid using Google 2FA library (e.g., "pragmarx/google2fa-laravel")
            $google2fa = new Google2FA();
            $isValidOtp = $google2fa->verifyKey($gymAccount->google2fa_secret, $request->otp);

            if (!$isValidOtp) {
                return redirect()->back()->with('status', 'error')->with('message', 'Invalid OTP. Please try again.');
            }

            // Login the gym account if OTP is valid
            Auth::guard('gym')->login($gymAccount);

            // Clear session data for security
            session()->forget('gym_account_id');

            return redirect('/dashboard')->with('status', 'success')->with('message', 'Login successful!');
        } catch (Exception $e) {
            Log::error('[GymDetailController][verifyOtp] Error Verifying OTP ' . 'Request=' . $request . ', Exception=' . $e->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'An error occurred during OTP verification. Please try again later.');
        }
    }



    public function logoutGym()
    {
        session()->flush();

        return redirect()->route('login')->with('status', 'success')->with('message', 'Logout successfully');
    }

    public function registerGym(Request $request)
    {
        try {
            $request->validate([
                'gym_name' => 'required',
                'email' => 'required|unique:gyms,email',
                'password' => 'required',
            ]);

            $gymUser = $this->gymService->createGymAccount($request->all());
            if ($gymUser) {
                return redirect()->route('login')->with('status', 'success')->with('message', 'Gym Registered Succesfully.');
            }
            return redirect()->route('register')->with('status', 'error')->with('message', 'error in register gym.');
        } catch (Exception $e) {
            Log::error('[GymDetailController][registerGym] Error register gym: ' . $e->getMessage());
            return redirect()->route('register')->with('status', 'error')->with('message', 'error in register gym : ' . $e->getMessage());
        }
    }

    public function updateGymAccount(Request $request)
    {
        try {
            $request->validate([
                "username" => 'required',
                "phone_no" => 'required',
                "gym_name" => 'required',
                "address" => 'required',
                "city_id" => 'required',
                "state_id" => 'required',
                "country_id" => 'required',
                "web_link" => 'nullable',
                "gym_type" => 'required',
                "face_link" => 'nullable',
                "insta_link" => 'nullable',
                "image" => 'nullable',
            ]);

            // Collect the form data, including the image if present
            $gymData = $request->all();

            // Handle image upload if there's an image file
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $gymData['image'] = $image;
            }

            // Update gym profile data using the service
            $isProfileUpdated = $this->gymService->createGymAccount($gymData);
            if ($isProfileUpdated) {
                return redirect()->back()->with('status', 'success')->with('message', 'Gym profile updated succesfully.');
            }
            return redirect()->back()->with('status', 'error')->with('message', 'error while updating gym.');
        } catch (Exception $e) {
            Log::error('[GymDetailController][updateGym] Error updating gym :' . $e->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'error while updating gym.');
        }
    }

    /**
     * The function fetches a gym profile, including the profile image URL, and returns it as a JSON
     * response, handling exceptions and logging errors if any occur.
     *
     * @return The `fetchGymProfile` function is returning a JSON response containing the gym profile
     * information. If an error occurs during the process, it will log the error and redirect back with
     * an error message.
     */
    public function fetchGymProfile()
    {
        try {
            $gym = Auth::guard('gym')->user();
            $gym = $this->gym->findOrFail($gym->id);
            $gym->profile_image_url = url('images/' . $gym->image);

            return response()->json($gym);
        } catch (\Exception $e) {
            Log::error('[GymDetailController][fetchGymProfile] Error fetching gym profile: ' . $e->getMessage());
            return redirect()->back() - with('status', 'error') > with('message', 'Error fetching gym profile view: ' . $e->getMessage());
        }
    }

    /**
     * The GymProfileView function retrieves the gym profile data and total number of users in the gym,
     * displaying it in the gym-profile view, with error handling and logging in case of exceptions.
     *
     * @return The GymProfileView function is returning a view called 'gym-profile' with the variables
     * and  passed to it using the compact function. If an exception occurs during the process,
     * it will log the error message and redirect back with a status of 'error' and a message indicating
     * the error that occurred.
     */
    public function GymProfileView()
    {
        try {
            $gym = Auth::guard('gym')->user();
            $gymId = $this->gym->where('uuid', $gym->uuid)->first()->id;
            $totalUsers = $this->gymUserGym->countUsersInGym($gym->id);
            $holidays = $this->gymHoliday->where('gym_id', $gymId)->get();
            $savedWeekendDays = GymWeekend::where('gym_id', $gymId)->pluck('weekend_day')->toArray();
            $subscriptionExpireDays = $this->siteSetting->where('gym_id', $gymId)
                ->where('key', 'subscription_expiring_in_days')
                ->value('value');

            return view('GymOwner.gym-profile', compact('gym', 'totalUsers', 'holidays', 'savedWeekendDays', 'subscriptionExpireDays'));
        } catch (\Exception $e) {
            Log::error('[GymDetailController][GymProfileView] Error fetching gym profile view: ' . $e->getMessage());
        }
    }

    public function addHolidayByGym(Request $request)
    {
        try {
            $request->validate([
                'holiday_name' => 'required',
                'date' => 'required'
            ]);

            $gym = Auth::guard('gym')->user();
            $gymId = $this->gym->where('uuid', $gym->uuid)->first()->id;

            $this->gymHoliday->addHoliday($request->all(), $gymId);

            return redirect()->back()->with('status', 'success')->with('message', 'Holiday Added Succesfully.');
        } catch (Exception $e) {
            Log::error('[GymDetailController][addHolidayByGym] Error adding holiday: ' . $e->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'Error adding holiday: ' . $e->getMessage());
        }
    }

    public function deleteHoliday($id)
    {
        $holiday = $this->gymHoliday->findOrFail($id);
        $holiday->delete();

        return redirect()->back()->with('status', 'success')->with('message', 'Holiday Is Succesfully Deleted!');
    }

    public function addWeekendsByGym(Request $request)
    {
        try {
            $validateData = $request->validate([
                'weekend_day' => 'required|array',
            ]);

            // Get the currently authenticated gym
            $gym = Auth::guard('gym')->user();
            $gymId = $this->gym->where('uuid', $gym->uuid)->first()->id;

            // Get existing saved weekend days for the gym
            $existingWeekends = $this->gymWeekend->where('gym_id', $gymId)->pluck('weekend_day')->toArray();

            // Get the newly selected weekend days from the request
            $selectedDays = $request->weekend_day;

            // Determine which days to add
            $daysToAdd = array_diff($selectedDays, $existingWeekends);

            // Determine which days to delete
            $daysToDelete = array_diff($existingWeekends, $selectedDays);

            // Add new weekend days
            foreach ($daysToAdd as $day) {
                $this->gymWeekend->create([
                    'gym_id' => $gymId,
                    'weekend_day' => $day
                ]);
            }

            // Delete the unchecked days
            if (!empty($daysToDelete)) {
                $this->gymWeekend->where('gym_id', $gymId)
                    ->whereIn('weekend_day', $daysToDelete)
                    ->delete();
            }

            return redirect()->back()->with('status', 'success')->with('message', 'Weekend Updated Successfully.');
        } catch (Exception $e) {
            Log::error('[GymDetailController][addWeekendsByGym] Error updating weekends: ' . $e->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'Error updating weekends: ' . $e->getMessage());
        }
    }

    public function addSubscriptionExpireDays(Request $request)
    {
        try {
            // Validate the request data
            $request->validate([
                'days' => 'required|integer'
            ]);

            // Get the authenticated gym user
            $gym = Auth::guard('gym')->user();
            $gymId = $this->gym->where('uuid', $gym->uuid)->first()->id;

            // Check if the setting already exists for the gym
            $setting = $this->siteSetting->where('gym_id', $gymId)
                ->where('key', 'subscription_expiring_in_days')
                ->first();

            if ($setting) {
                // If the setting exists, update it
                $setting->update([
                    'value' => $request->days
                ]);
            } else {
                // If the setting does not exist, create a new one
                $this->siteSetting->create([
                    'gym_id' => $gymId,
                    'key' => 'subscription_expiring_in_days',
                    'value' => $request->days
                ]);
            }

            // Redirect back with success message
            return redirect()->back()->with('status', 'success')->with('message', 'Subscription Expire Days Updated Successfully.');
        } catch (Exception $e) {
            // Log the error and redirect back with error message
            Log::error('[GymDetailController][addSubscriptionExpireDays] Error adding subscription expire days: ' . $e->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'Error adding subscription expire days: ' . $e->getMessage());
        }
    }



    public function logout(Request $request)
    {
        // Logout the gym user
        Auth::guard('gym')->logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate CSRF token
        $request->session()->regenerateToken();

        // Redirect to the gym login page or wherever you need
        return redirect('/')->with('status', 'success')->with('message', 'Logged out successfully.');
    }
}
