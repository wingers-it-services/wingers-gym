<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminCouponController;
use App\Http\Controllers\AdminEnquiryController;
use App\Http\Controllers\AdminGymController;
use App\Http\Controllers\AdminNotificationController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminSubscriptionController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdvertismentController;

use App\Http\Controllers\DesignationController;
use App\Http\Controllers\GymNotificationController;
use App\Http\Controllers\UserNotificationController;
use Illuminate\Support\Facades\Route;



Route::get('/admin-login', function () {
    return view('admin.admin-login');
});

Route::get('/admin-dashboard', function () {
    return view('admin.admin-dashboard');
});

Route::get('/admin-enquiry', function () {
    return view('admin.admin-enquiry');
});

Route::get('/add-advertisment', function () {
    return view('admin.add-advertisment');
});

// Route::get('/add-gym', function () {
//     return view('admin.add-gym');
// });

Route::get('/admin-gym-list', function () {
    return view('admin.admin-gym-list');
});

Route::get('/admin-user', function () {
    return view('admin.admin-user');
});

Route::get('/admin-user-list', function () {
    return view('admin.admin-user-list');
});


Route::get('/admin-coupon', function () {
    return view('admin.admin-coupon');
});

Route::get('/admin-advertistement', function () {
    return view('admin.admin-advertistement');
});

Route::get('/admin-user-compose-notification', function () {
    return view('admin.admin-user-compose-notification');
});


Route::get('/admin-gym-compose-notification', function () {
    return view('admin.admin-gym-compose-notification');
});
Route::get('/admin-user-inbox', function () {
    return view('admin.admin-user-inbox');
});

Route::get('/admin-gym-inbox', function () {
    return view('admin.admin-gym-inbox');
});

Route::get('/admin-user-read', function () {
    return view('admin.admin-user-read');
});

Route::get('/admin-gym-read', function () {
    return view('admin.admin-gym-read');
});

Route::get('/admin-faq', function () {
    return view('admin.admin-faq');
});

Route::get('/admin-payment', function () {
    return view('admin.admin-payment');
});

Route::get('/admin-enquiry', function () {
    return view('admin.admin-enquiry');
});
Route::get('/admin-read', function () {
    return view('admin.admin-read');
});

Route::get('/add-vendor', function () {
    return view('admin.add-vendor');
});
Route::get('/add-doctor', function () {
    return view('admin.add-doctor');
});

Route::get('/vendor-list', function () {
    return view('admin.vendor-list');
});

Route::get('/doctor-list', function () {
    return view('admin.doctor-list');
});

Route::get('/admin-order-list', function () {
    return view('admin.admin-order-list');
});

Route::get('/admin-invoice', function () {
    return view('admin.admin-invoice');
});

Route::get('/system-inbox', function () {
    return view('admin.system-inbox');
});

Route::get('/system-read', function () {
    return view('admin.system-read');
});
Route::get('/admin-profile', function () {
    return view('admin.admin-profile');
});

Route::get('/admin-add-product', [AdminProductController::class, 'viewAddProduct']);
Route::post('/add-product', [AdminProductController::class, 'addProductByAdmin'])->name('add-product');
Route::get('/admin-product-list', [AdminProductController::class, 'listProduct']);

Route::get('/add-gym', [AdminGymController::class, 'viewGymInfo']);

Route::get('/adminDashboard', [AdminController::class, 'adminDashboard']);

Route::get('/viewGymList', [AdminGymController::class, 'viewGymList'])->name('viewGymList');


Route::post('/addGymByAdmin', [AdminGymController::class, 'addGymDetailsByAdmin'])->name('addGymByAdmin');
Route::get('/viewEditGym/{uuid}', [AdminGymController::class, 'viewEditGym'])->name('viewEditGym');
Route::post('/updateAdminGym', [AdminGymController::class,'updateAdminGym'])->name('updateAdminGym');
Route::delete('/deleteGym/{uuid}', [AdminGymController::class, 'deleteGym'])->name('deleteGym');
// Route::post('/addTermsAndConditions', [AdminGymController::class, 'addTermsAndConditions'])->name('addTAndC');
// Route::post('/addGymSocialLink', [AdminGymController::class, 'addGymSocialLink'])->name('addGymSocialLink');

Route::get('/admin-subscription', [AdminSubscriptionController::class, 'viewAddAdminSubscription'])->name('admin-subscription');
Route::post('/add-admin-subscription', [AdminSubscriptionController::class, 'addAdminSubscription'])->name('add-admin-subscription');
Route::post('/update-subscription', [AdminSubscriptionController::class, 'updateAdminSubscription'])->name('update-subscription');
Route::get('/delete-plan/{uuid}', [AdminSubscriptionController::class, 'deleteSubscription'])->name('delete-plan');

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
