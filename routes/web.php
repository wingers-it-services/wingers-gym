<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DietController;
use App\Http\Controllers\GymCouponController;
use App\Http\Controllers\GymCustomerPaymentController;
use App\Http\Controllers\GymStaffController;
use App\Http\Controllers\GymSubscriptionController;
use App\Http\Controllers\GymDetailController;
use App\Http\Controllers\GymEnquiryController;
use App\Http\Controllers\GymUserController;
use App\Http\Controllers\UserBmiController;
use App\Traits\SessionTrait;
use App\Http\Controllers\GymDesignationController;
use App\Http\Controllers\GymGalleryController;
use App\Http\Controllers\GymSheduleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WorkoutController;
use App\Http\Middleware\EnsureGymTokenIsValid;
use Illuminate\Support\Facades\Route;




/* This code snippet defines a GET route in Laravel that maps to the root URL ("/"). When a user
accesses the root URL of the application, it will return a view named 'GymOwner.login'.
Additionally, the route is given the name 'login', which can be used to reference this route in
other parts of the application. */

Route::get('/', function () {
    return view('GymOwner.login');
})->name('login');

Route::get('/add-product', function () {
    return view('GymOwner.add-product');
});
Route::get('/product-list', function () {
    return view('GymOwner.product-list');
});
Route::get('/order-list', function () {
    return view('GymOwner.order-list');
});
Route::get('/invoice', function () {
    return view('GymOwner.invoice');
});

Route::get('/gym-customers', [GymUserController::class, 'listGymUser'])->name('gymCustomerList');
Route::get('/gym-customers-subscriptions', [GymUserController::class, 'listGymUserSubscriptions'])->name('gym-customers-subscriptions');
Route::get('/customers-attendance', [GymUserController::class, 'customersAttendance']);
Route::get('/mark-gym-user-attendance', [GymUserController::class, 'markGymUserAttendance'])->name('mark-gym-user-attendance');
Route::post('/fetch-user-attendance-chart', [GymUserController::class, 'fetchUserAttendanceChart'])->name('fetch-user-attendance-chart');


Route::get('/customers-payment', function () {
    return view('GymOwner.customers-payment');
});
Route::get('/coupon', function () {
    return view('GymOwner.coupon');
});
Route::get('/vendor-list', function () {
    return view('GymOwner.vendor-list');
});
Route::get('/enquiry', function () {
    return view('GymOwner.enquiry');
});
Route::get('/inbox', function () {
    return view('GymOwner.inbox');
});
Route::get('/enquiry-read', function () {
    return view('GymOwner.enquiry-read');
});
Route::get('/gym-faq', function () {
    return view('GymOwner.gym-faq');
});
/* GymOwner register */
Route::get('/register', function () {
    return view('GymOwner.register');
})->name('register');

Route::get('/privacy-policy', function () {
    return view('GymOwner.privacy-policy');
});

Route::get('/help-center', function () {
    return view('GymOwner.help-center');
});

Route::get('/terms-condition', function () {
    return view('GymOwner.terms-condition');
});

/* registerGym */
Route::post('/register', [GymDetailController::class, 'registerGym'])->name('registerGym');



Route::post('/gym-login', [GymDetailController::class, 'gymLogin'])->name('gymLogin');

Route::middleware([EnsureGymTokenIsValid::class])->group(function () {

    Route::post('/add-gym-schedule',[GymSheduleController::class,'addGymShedule'])->name('addGymShedule');

    Route::get('/fetch-gym-schedules', [GymSheduleController::class, 'fetchSchedule'])->name('fetchSchedule');

    /* dashboard */
    Route::get('/dashboard', [GymDetailController::class, 'showDashboard'])->name('dashboard');
    Route::get('/logout', [GymDetailController::class, 'logoutGym'])->name('logout');

    // Route::get('/viewGymInfo', [AdminGymController::class, 'viewGymInfo']);



    Route::get('/gymProfile', [GymDetailController::class, 'showGymProfile'])->name('showGymProfile');
    Route::get('/userProfile/{uuid}', [GymUserController::class, 'showUserProfile'])->name('showUserProfile');

    /* listSubscriptionPlan */
    Route::get('/subscription-list', [GymSubscriptionController::class, 'listSubscriptionPlan'])->name('listSubscriptionPlan');

    /* createGymSubscriptionPlan */
    Route::post('/gym-subscription', [GymSubscriptionController::class, 'createGymSubscriptionPlan']);
    Route::post('/update-gym-subscription', [GymSubscriptionController::class, 'updateGymSubscription'])->name('update-gym-subscription');
    Route::get('/delete-subscription/{uuid}', [GymSubscriptionController::class, 'deleteSubscription'])->name('deleteSubscription');




    Route::get('/add-staff-attendence', [GymStaffController::class, 'addStaffAttendence']);

    Route::get('/gym-staff', [GymStaffController::class, 'listGymStaff'])->name('listGymStaff');
    Route::get('/add-gym-staff', [GymStaffController::class, 'showAddGymStaff']);
    Route::post('/gym-staff', [GymStaffController::class, 'addGymStaff']);
    Route::get('/staff-details', [GymStaffController::class, 'staffDetails']);
    Route::post('/add-staff-asset', [GymStaffController::class, 'addStaffAsset']);
    Route::get('/gym-staff-assets/{staffId}', [GymStaffController::class, 'getStaffAssets']);
    Route::get('/update-asset-status/{id}', [GymStaffController::class, 'updateStatus']);
    Route::post('/add-staff-leave', [GymStaffController::class, 'addStaffLeave']);
    Route::get('/gym-staff-leaves/{staffId}', [GymStaffController::class, 'getStaffLeaves']);
    Route::get('/update-leave-status/{id}', [GymStaffController::class, 'updateLeaveStatus']);
    Route::get('/update-document-status/{id}', [GymStaffController::class, 'updateDocumentStatus']);
    Route::get('/gym-staff-documents/{staffId}', [GymStaffController::class, 'getStaffDocuments']);


    /* markGymStaffAttendance */
    Route::post('/mark-gym-staff-attendance', [GymStaffController::class, 'markGymStaffAttendance'])->name('markGymStaffAttendance');

    /* fetchAttendanceChart */
    Route::post('/fetch-attendance-chart', [GymStaffController::class, 'fetchAttendanceChart'])->name('fetchAttendanceChart');

    Route::get('/editStaff/{uuid}', [GymStaffController::class, 'showUpdateStaff'])->name('showUpdateStaff');
    Route::post('/updateStaff', [GymStaffController::class, 'updateStaff'])->name('updateStaff');
    Route::get('/deleteGymStaff/{uuid}', [GymStaffController::class, 'deleteGymStaff'])->name('deleteGymStaff');

    /* addUserByGym */
    Route::get('/add-gym-user', [GymUserController::class, 'addGymUser'])->name('addGymUser');

    /* addUserByGym */
    Route::post('/add-user-by-gym', [GymUserController::class, 'addUserByGym'])->name('add-user-by-gym');

    Route::get('/fetch-user-details', [GymUserController::class, 'fetchUserDetails']);


    /* listGymUser */
    Route::get('/update-gym-user/{uuid}', [GymUserController::class, 'viewUpdateUser'])->name('update-gym-user');
    Route::post('/update-user/{uuid}', [GymUserController::class, 'updateUser'])->name('update-user');
    Route::post('/add-user-workout', [GymUserController::class, 'addUserWorkout'])->name('add-user-workout');
    Route::get('/delete-user/{uuid}', [GymUserController::class, 'deleteGymUser'])->name('delete-user');
    Route::post('/update-user-workout', [GymUserController::class, 'updateUserWorkout'])->name('update-user-workout');
    Route::post('/add-user-diet', [GymUserController::class, 'addUserDiet'])->name('add-user-diet');
    Route::post('/update-user-diet', [GymUserController::class, 'updateUserDiet'])->name('update-user-diet');
    Route::get('/delete-user-workout/{uuid}', [GymUserController::class, 'deleteUserWorkout'])->name('delete-user-workout');
    Route::get('/delete-user-diet/{uuid}', [GymUserController::class, 'deleteUserDiet'])->name('delete-user-diet');
    Route::post('/check-subscription/{userId}', [GymUserController::class, 'checkSubscription'])->name('check-subscription');
    Route::post('/update-user-subscription/{userId}', [GymUserController::class, 'updateSubscription'])->name('update-user-subscription');

    Route::get('/gym-coupon', [GymCouponController::class, 'listGymCoupons'])->name('listGymCoupons');
    Route::post('/gym-coupon', [GymCouponController::class, 'addGymCoupon']);
    Route::get('/gymCouponView', [GymCouponController::class, 'viewGymCoupon'])->name('viewGymCoupon');
    Route::post('/updateGymCoupon', [GymCouponController::class, 'updateGymCoupon'])->name('updateGymCoupon');

    Route::post('/updateGym', [GymDetailController::class, 'updateGym'])->name('updateGym');



    Route::get('/viewAddEnquiry', [GymEnquiryController::class, 'viewAddEnquiry'])->name('viewAddEnquiry');
    Route::post('/addGymEnquiry', [GymEnquiryController::class, 'addGymEnquiry'])->name('addGymEnquiry');
    Route::get('/viewEnquiry/{uuid}', [GymEnquiryController::class, 'viewEnquiry'])->name('viewEnquiry');

    Route::get('/addGallery', function () {
        return view('GymOwner.addGallery');
    });

    Route::get('/gallery', function () {
        return view('GymOwner.gym-gallery');
    });
    Route::get('/calendar', function () {
        return view('GymOwner.gym-calender');
    });
    Route::get('/faq', function () {
        return view('GymOwner.faq');
    });
    Route::get('/addFaq', function () {
        return view('GymOwner.addFaq');
    });
    Route::get('/courses', function () {
        return view('GymOwner.courses');
    });


    Route::get('/add-reels', function () {
        return view('GymOwner.add-reels');
    });

    Route::get('/add-diet', [DietController::class, 'viewDiet'])->name('add-diet');
    Route::post('/add-gym-diet', [DietController::class, 'addDiet'])->name('add-gym-diet');
    Route::post('/update-gym-diet', [DietController::class, 'updateDiet'])->name('update-gym-diet');
    Route::get('/delete-diet/{uuid}', [DietController::class, 'deleteDiet'])->name('delete-diet');

    Route::get('/add-workout', [WorkoutController::class, 'viewWorkout'])->name('add-workout');
    Route::post('/add-gym-workout', [WorkoutController::class, 'addWorkout'])->name('add-gym-workout');
    Route::post('/update-workout', [WorkoutController::class, 'updateWorkout'])->name('update-workout');
    Route::get('/delete-workout/{uuid}', [WorkoutController::class, 'deleteWorkout'])->name('delete-workout');



    Route::get('/viewAddEnquiry', [GymEnquiryController::class, 'viewAddEnquiry'])->name('viewAddEnquiry');
    Route::post('/addGymEnquiry', [GymEnquiryController::class, 'addGymEnquiry'])->name('addGymEnquiry');
    Route::get('/viewEnquiry/{uuid}', [GymEnquiryController::class, 'viewEnquiry'])->name('viewEnquiry');
    Route::delete('/deleteEnquiry/{uuid}', [GymEnquiryController::class, 'deleteEnquiry'])->name('deleteEnquiry');

    Route::post('/addBmi', [UserBmiController::class, 'createUserBodyMeasurement'])->name('addUserBodyMeasurement');
    Route::post('/allocateTrainer', [GymUserController::class, 'allocateTrainerToUser'])->name('allotTrainer');
    Route::post('/update-trainer-status/{user_id}', [GymUserController::class, 'updateTrainerStatus'])->name('update-trainer-status');
    Route::get('/deleteTrainer/{uuid}', [GymUserController::class, 'deleteTrainer'])->name('deleteTrainer');
    Route::get('/get-user-bmi/{bmiId}', [GymUserController::class, 'getUserBmi']);
    Route::post('/update-user-bmi', [UserBmiController::class, 'updateUserBmi'])->name('updateUserBmi');
    Route::get('/deleteBmi/{uuid}', [UserBmiController::class, 'deleteBmi'])->name('deleteBmi');




    // gymCustomersSubscriptionPayment
    Route::get('/gym-customers-subscription-payment', [GymCustomerPaymentController::class, 'listGymCustomersSubscriptionPayment'])->name('listGymCustomersSubscriptionPayment');

    // viewGymDesignation
    Route::get('/viewGymDesignation', [GymDesignationController::class, 'viewGymDesignation'])->name('viewGymDesignation');

    //addGymDesignation
    Route::post('/addGymDesignation', [GymDesignationController::class, 'addGymDesignation'])->name('addGymDesignation');
    Route::post('/update-designation', [GymDesignationController::class, 'updateGymDesignation'])->name('update-designation');
    Route::get('/update-designation-status/{id}', [GymDesignationController::class, 'deactivateDesignation'])->name('update-designation-status');
    Route::get('/activate-designation-status/{id}', [GymDesignationController::class, 'activateDesignation'])->name('activate-designation-status');




    // deleteGymDesignation
    Route::get('/deleteGymDesignation/{uuid}', [GymDesignationController::class, 'deleteGymDesignation'])->name('deleteGymDesignation');

    Route::post('/addUserSubscriptionByGym', [GymUserController::class, 'addUserSubscriptionByGym'])->name('addUserSubscriptionByGym');
    Route::post('/update-subscription-status/{user_id}', [GymUserController::class, 'updateSubscriptionStatus'])->name('update-subscription-status');
    Route::get('/deleteSubcriptionHistory/{uuid}', [GymUserController::class, 'deleteSubcriptionHistory'])->name('deleteSubcriptionHistory');


    Route::get('/autocomplete-workout', [GymUserController::class, 'autocompleteWorkout'])->name('autocomplete-workout');
    Route::get('/fetch-workout-details', [GymUserController::class, 'fetchWorkoutDetails'])->name('fetch-workout-details');

    Route::get('/autocomplete-diet', [GymUserController::class, 'autocompleteDiet'])->name('autocomplete-diet');
    Route::get('/fetch-diet-details', [GymUserController::class, 'fetchDietDetails'])->name('fetch-diet-details');

    Route::get('/fetch-gym-profile', [GymDetailController::class, 'fetchGymProfile'])->name('fetchGymProfile');

    Route::get('/gym-profile', [GymDetailController::class, 'GymProfileView']);

    Route::post('/add-gym-gallery', [GymGalleryController::class, 'addGymGallery'])->name('addGymGallery');
    Route::get('/delete-gallery/{id}', [GymGalleryController::class, 'deleteGallery'])->name('delete-gallery');
    Route::get('/gym-gallery', [GymGalleryController::class, 'gymGalleryView']);


    Route::post('/add-products', [ProductController::class, 'addProduct'])->name('addProduct');

    Route::post('/add-staff-documents', [GymStaffController::class, 'addStaffDocuments'])->name('addStaffDocuments');
});

Route::get('/packages', [AdminController::class, 'showPackages']);
Route::get('/personalTraining', [AdminController::class, 'showPersonalTraining']);
Route::get('/news', [AdminController::class, 'showNews']);

Route::get('/addNews', [AdminController::class, 'showAddNews']);


Route::get('/trainers', [AdminController::class, 'showTrainers']);

Route::get('/eventItems', [AdminController::class, 'showEventItems']);

Route::get('/eventLists', [AdminController::class, 'showEventLists']);

Route::get('/courseSchedule', [AdminController::class, 'showCourseSchedule']);

Route::get('/trainers', [AdminController::class, 'showTrainers']);

Route::get('/rooms', [AdminController::class, 'showRooms']);

Route::get('/addUsers', [AdminController::class, 'showAddUsers']);

Route::get('/userPayment', [AdminController::class, 'showUserPayment']);

Route::post('/add-holiday', [GymDetailController::class, 'addHolidayByGym']);
Route::get('/delete-holiday/{id}', [GymDetailController::class, 'deleteHoliday']);

Route::post('/add-weekend', [GymDetailController::class, 'addWeekendsByGym']);

Route::post('/update-gym-account', [GymDetailController::class, 'updateGymAccount']);


