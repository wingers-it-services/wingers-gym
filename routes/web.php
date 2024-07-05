<?php

use App\Http\Controllers\AdminController;
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
    return view('gymowner.add-product');
});
Route::get('/product-list', function () {
    return view('gymowner.product-list');
});
Route::get('/order-list', function () {
    return view('gymowner.order-list');
});
Route::get('/invoice', function () {
    return view('gymowner.invoice');
});
Route::get('/gym-customers', function () {
    return view('gymowner.gym-customers');
});
Route::get('/gym-gallery', function () {
    return view('gymowner.gym-gallery');
});
Route::get('/customers-payment', function () {
    return view('gymowner.customers-payment');
});
Route::get('/coupon', function () {
    return view('gymowner.coupon');
});
Route::get('/vendor-list', function () {
    return view('gymowner.vendor-list');
});
Route::get('/enquiry', function () {
    return view('gymowner.enquiry');
});
Route::get('/inbox', function () {
    return view('gymowner.inbox');
});
Route::get('/gym-profile', function () {
    return view('gymowner.gym-profile');
});
Route::get('/enquiry-read', function () {
    return view('gymowner.enquiry-read');
});
Route::get('/faq', function () {
    return view('gymowner.faq');
});
/* GymOwner register */
Route::get('/register', function () {
    return view('GymOwner.register');
})->name('register');

/* registerGym */
Route::post('/register', [GymDetailController::class, 'registerGym'])->name('registerGym');

Route::middleware([EnsureGymTokenIsValid::class])->group(function () {

    /* dashboard */
    Route::get('/dashboard', [GymDetailController::class, 'showDashboard'])->name('dashboard');
    Route::get('/logout', [GymDetailController::class, 'logouGymUser'])->name('logout');

    // Route::get('/viewGymInfo', [AdminGymController::class, 'viewGymInfo']);



    Route::get('/gymProfile', [GymDetailController::class, 'showGymProfile'])->name('showGymProfile');
    Route::get('/userProfile', [GymUserController::class, 'showUserProfile'])->name('showUserProfile');

    /* listSubscriptionPlan */
    Route::get('/subscription-list', [GymSubscriptionController::class, 'listSubscriptionPlan'])->name('listSubscriptionPlan');

    /* createGymSubscriptionPlan */
    Route::post('/gym-subscription', [GymSubscriptionController::class, 'createGymSubscriptionPlan']);

    Route::get('/updateSubscriptionView', [GymSubscriptionController::class, 'viewGymSubscription'])->name('updateSubscriiptionView');
    Route::post('/updateSubscriiption', [GymSubscriptionController::class, 'updateGymSubscriptionPlan'])->name('updateSubscriiption');
    Route::delete('/deleteGymSubscription/{uuid}', [GymSubscriptionController::class, 'deleteGymSubscription'])->name('deleteGymSubscription');




    Route::get('/add-staff-attendence', [GymStaffController::class, 'addStaffAttendence']);

    Route::get('/gym-staff', [GymStaffController::class, 'listGymStaff'])->name('listGymStaff');
    Route::get('/add-gym-staff', [GymStaffController::class, 'showAddGymStaff']);
    Route::post('/gym-staff', [GymStaffController::class, 'addGymStaff']);
    Route::get('/staff-details', [GymStaffController::class, 'staffDetails']);

    /* markGymStaffAttendance */
    Route::post('/mark-gym-staff-attendance', [GymStaffController::class, 'markGymStaffAttendance'])->name('markGymStaffAttendance');

    /* fetchAttendanceChart */
    Route::post('/fetch-attendance-chart', [GymStaffController::class, 'fetchAttendanceChart'])->name('fetchAttendanceChart');

    Route::get('/editStaff/{uuid}', [GymStaffController::class, 'showUpdateStaff'])->name('showUpdateStaff');
    Route::post('/updateStaff', [GymStaffController::class, 'updateStaff'])->name('updateStaff');
    Route::delete('/deleteGymStaff/{uuid}', [GymStaffController::class, 'deleteGymStaff'])->name('deleteGymStaff');

    /* addUserByGym */
    Route::get('/add-gym-user', [GymUserController::class, 'addGymUser'])->name('addGymUser');

    /* addUserByGym */
    Route::post('/add-user-by-gym', [GymUserController::class, 'addUserByGym'])->name('addUserByGym');

    /* listGymUser */
    // Route::get('/gym-user-list', [GymUserController::class, 'listGymUser'])->name('listGymUser');
    Route::post('/updateUser', [GymUserController::class, 'updateUser'])->name('updateUser');
    Route::post('/addUserWorkout', [GymUserController::class, 'addUserWorkout'])->name('addUserWorkout');
    Route::post('/updateUserWorkout', [GymUserController::class, 'updateUserWorkout'])->name('updateUserWorkout');
    Route::post('/addUserDiet', [GymUserController::class, 'addUserDiet'])->name('addUserDiet');
    Route::post('/updateUserDiet', [GymUserController::class, 'updateUserDiet'])->name('updateUserDiet');


    Route::get('/gym-coupon', [GymCouponController::class, 'listGymCoupons'])->name('listGymCoupons');
    Route::post('/gym-coupon', [GymCouponController::class, 'addGymCoupon']);
    Route::get('/gymCouponView', [GymCouponController::class, 'viewGymCoupon'])->name('viewGymCoupon');
    Route::post('/updateGymCoupon', [GymCouponController::class, 'updateGymCoupon'])->name('updateGymCoupon');

    Route::post('/gym-login', [GymDetailController::class, 'gymLogin'])->name('gymLogin');
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

    Route::get('/viewAddEnquiry', [GymEnquiryController::class, 'viewAddEnquiry'])->name('viewAddEnquiry');
    Route::post('/addGymEnquiry', [GymEnquiryController::class, 'addGymEnquiry'])->name('addGymEnquiry');
    Route::get('/viewEnquiry/{uuid}', [GymEnquiryController::class, 'viewEnquiry'])->name('viewEnquiry');
    Route::delete('/deleteEnquiry/{uuid}', [GymEnquiryController::class, 'deleteEnquiry'])->name('deleteEnquiry');

    Route::post('/addBmi', [UserBmiController::class, 'createUserBodyMeasurement'])->name('addUserBodyMeasurement');
    Route::post('/allocateTrainer', [GymUserController::class, 'allocateTrainerToUser'])->name('allotTrainer');

    // gymCustomersSubscriptionPayment
    Route::get('/gym-customers-subscription-payment', [GymCustomerPaymentController::class, 'listGymCustomersSubscriptionPayment'])->name('listGymCustomersSubscriptionPayment');

    // viewGymDesignation
    Route::get('/viewGymDesignation', [GymDesignationController::class, 'viewGymDesignation'])->name('viewGymDesignation');

    //addGymDesignation
    Route::post('/addGymDesignation', [GymDesignationController::class, 'addGymDesignation'])->name('addGymDesignation');

    // deleteGymDesignation
    Route::get('/deleteGymDesignation/{uuid}', [GymDesignationController::class, 'deleteGymDesignation'])->name('deleteGymDesignation');
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


Route::get('/dashboard', function () {
    return view('admin.dashboard');
});

Route::get('/admin-enquiry', function () {
    return view('admin.admin-enquiry');
});

Route::get('/add-advertisment', function () {
    return view('admin.add-advertisment');
});

Route::get('/admin-notification', function () {
    return view('admin.admin-notification');
});


Route::get('/admin-login', function () {
    return view('admin.admin-login');
});

Route::get('/add-user', function () {
    return view('admin.add-user');
});

Route::get('/books-list', function () {
    return view('admin.books-list');
});
Route::get('/add-book', function () {
    return view('admin.add-book');
});


Route::get('/user-list', function () {
    return view('admin.user-list');
});
