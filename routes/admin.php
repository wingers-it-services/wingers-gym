<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminCouponController;
use App\Http\Controllers\AdminEnquiryController;
use App\Http\Controllers\AdminGymController;
use App\Http\Controllers\AdminNotificationController;
use App\Http\Controllers\AdminSubscriptionController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdvertismentController;

use App\Http\Controllers\DesignationController;
use App\Http\Controllers\GymNotificationController;
use App\Http\Controllers\UserNotificationController;
use Illuminate\Support\Facades\Route;

Route::get('/viewGymInfo', [AdminGymController::class, 'viewGymInfo']);

Route::get('/adminDashboard', [AdminController::class, 'adminDashboard']);

Route::get('/viewGymList', [AdminGymController::class, 'viewGymList'])->name('viewGymList');


Route::post('/addGymByAdmin', [AdminGymController::class, 'addGymDetailsByAdmin'])->name('addGymByAdmin');
Route::get('/viewEditGym/{uuid}', [AdminGymController::class, 'viewEditGym'])->name('viewEditGym');
Route::post('/updateAdminGym', [AdminGymController::class,'updateAdminGym'])->name('updateAdminGym');
Route::delete('/deleteGym/{uuid}', [AdminGymController::class, 'deleteGym'])->name('deleteGym');
// Route::post('/addTermsAndConditions', [AdminGymController::class, 'addTermsAndConditions'])->name('addTAndC');
// Route::post('/addGymSocialLink', [AdminGymController::class, 'addGymSocialLink'])->name('addGymSocialLink');

Route::get('/viewAddAdminSubscription', [AdminSubscriptionController::class, 'viewAddAdminSubscription'])->name('viewAddAdminSubscription');
Route::post('/addAdminSubscription', [AdminSubscriptionController::class, 'addAdminSubscription'])->name('addAdminSubscription');
Route::get('/viewEditSubscription/{uuid}', [AdminSubscriptionController::class, 'viewEditAdminSubscription'])->name('viewEditSubscription');
Route::post('/updateSubscription', [AdminSubscriptionController::class, 'updateAdminSubscription'])->name('updateSubscription');

Route::get('/addAdminUsers', [AdminUserController::class, 'showAddUsers']);
Route::post('/add-user-by-admin', [AdminUserController::class, 'addUserByadmin'])->name('addUserByadmin');
Route::get('/gymUserList', [AdminUserController::class, 'gymUserList'])->name('gymUserList');
Route::get('/homeUserList', [AdminUserController::class, 'homeUserList'])->name('homeUserList');
Route::get('/viewEditUser/{uuid}', [AdminUserController::class, 'viewEditUser'])->name('viewEditUser');
Route::post('/updateAdminUser', [AdminUserController::class,'updateAdminUser'])->name('updateAdminUser');

Route::post('/addAdminWorkout', [AdminUserController::class, 'addAdminWorkout'])->name('addAdminWorkout');
Route::post('/updateAdminWorkout', [AdminUserController::class, 'updateAdminWorkout'])->name('updateAdminWorkout');
Route::post('/addAdminDiet', [AdminUserController::class, 'addAdminDiet'])->name('addAdminDiet');
Route::post('/updateAdminDiet', [AdminUserController::class, 'updateAdminDiet'])->name('updateAdminDiet');
Route::post('/addUserBmi', [AdminUserController::class, 'UserBodyMeasurement'])->name('UserBodyMeasurement');
Route::post('/allocateTrainertoUser', [AdminUserController::class, 'allocateTrainertoUser'])->name('allocateTrainertoUser');


Route::get('/listEnquiry', [AdminEnquiryController::class, 'listEnquiry'])->name('listEnquiry');
Route::get('/viewAdminEnquiry/{uuid}', [AdminEnquiryController::class, 'viewAdminEnquiry'])->name('viewAdminEnquiry');
Route::post('/updateStatus', [AdminEnquiryController::class,'updateStatus'])->name('updateStatus');
Route::get('/payment', function () {
    return view('admin.payment');
});
// Route::get('/coupon', function () {
//     return view('admin.coupon');
// });
// Route::get('/advertisement', function () {
//     return view('admin.advertisment');
// });
// Route::get('/userNotification', function () {
//     return view('admin.userNotification');
// });
// Route::get('/gymNotification', function () {
//     return view('admin.gymNotification');
// });
Route::get('/adminUserprofile', function () {
    return view('admin.adminUser.adminUserprofile');
});

Route::get('/viewAdminCoupons', [AdminCouponController::class, 'viewAdminCoupons'])->name('viewAdminCoupons');
Route::post('/addAdminCoupon', [AdminCouponController::class, 'addAdminCoupon'])->name('addAdminCoupon');
Route::get('/editViewCoupon', [AdminCouponController::class, 'editViewCoupon'])->name('editViewCoupon');
Route::post('/updateAdminCoupon', [AdminCouponController::class, 'updateAdminCoupon'])->name('updateAdminCoupon');
Route::delete('/deleteCoupon/{uuid}', [AdminCouponController::class, 'deleteCoupon'])->name('deleteCoupon');

Route::get('/viewAdvertisment', [AdvertismentController::class, 'viewAdvertisment'])->name('viewAdvertisment');
Route::post('/addAdvertisment', [AdvertismentController::class, 'addAdvertisment'])->name('addAdvertisment');
Route::get('/viewAdminAdvertisment/{uuid}', [AdvertismentController::class, 'viewAdminAdvertisment'])->name('viewAdminAdvertisment');
Route::delete('/deleteAdvertisment/{uuid}', [AdvertismentController::class, 'deleteAdvertisment'])->name('deleteAdvertisment');

Route::get('/viewDesignation', [DesignationController::class, 'viewDesignation'])->name('viewDesignation');
Route::post('/addDesignation', [DesignationController::class, 'addDesignation'])->name('addDesignation');
Route::delete('/deleteDesignation/{uuid}', [DesignationController::class, 'deleteDesignation'])->name('deleteDesignation');

Route::get('/viewNotification', [UserNotificationController::class, 'viewNotification'])->name('viewNotification');
Route::post('/addNotification', [UserNotificationController::class, 'addNotification'])->name('addNotification');
Route::delete('/deleteNotification/{uuid}', [UserNotificationController::class, 'deleteNotification'])->name('deleteNotification');

Route::get('/viewGymNotification', [GymNotificationController::class, 'viewGymNotification'])->name('viewGymNotification');
Route::post('/addGymNotification', [GymNotificationController::class, 'addGymNotification'])->name('addGymNotification');
Route::delete('/deleteGymNotification/{uuid}', [GymNotificationController::class, 'deleteGymNotification'])->name('deleteGymNotification');