<?php

use App\Http\Controllers\AdvertisementControllerApi;
use App\Http\Controllers\Api\UserBmiControllerApi;
use App\Http\Controllers\DietAnalyticControllerApi;
use App\Http\Controllers\EquipmentControllerApi;
use App\Http\Controllers\FcmTokenControllerApi;
use App\Http\Controllers\GoalControllerApi;
use App\Http\Controllers\GymDetailControllerApi;
use App\Http\Controllers\GymGalleryControllerApi;
use App\Http\Controllers\GymUserAttendenceControllerApi;
use App\Http\Controllers\GymUserControllerApi;
use App\Http\Controllers\GymUserLoginControllerApi;
use App\Http\Controllers\GymUserTrainerControllerApi;
use App\Http\Controllers\HomeControllerApi;
use App\Http\Controllers\HomeUserLoginControllerApi;
use App\Http\Controllers\LocationControllerApi;
use App\Http\Controllers\ReelControllerApi;
use App\Http\Controllers\SiteSettingControllerApi;
use App\Http\Controllers\SupplimentControllerApi;
use App\Http\Controllers\UserDietControllerApi;
use App\Http\Controllers\UserInjuryControllerApi;
use App\Http\Controllers\UserInquiryControllerApi;
use App\Http\Controllers\UserLevelControllerApi;
use App\Http\Controllers\UserSubscriptionControllerApi;
use App\Http\Controllers\UserWorkoutAnalyticApi;
use App\Http\Controllers\UserWorkoutControllerApi;
use App\Models\UserSubscriptionPayment;
use Illuminate\Support\Facades\Route;

Route::get('/fetch-goal', [GoalControllerApi::class, 'fetchGoal'])->name('fetchGoal');

Route::get('/fetch-level', [UserLevelControllerApi::class, 'fetchLevel'])->name('fetchLevel');

Route::get('/fetch-user-injury', [UserInjuryControllerApi::class, 'fetchUserInjury'])->name('fetchUserInjury');

Route::get('/fetch-country-list', [LocationControllerApi::class, 'fetchCountryList']);

Route::post('/fetch-state-list', [LocationControllerApi::class, 'fetchStateList']);

Route::post('/fetch-city-list', [LocationControllerApi::class, 'fetchCityList']);

Route::post('/gyms-by-city', [LocationControllerApi::class, 'fetchGymsByCity']);

Route::post('/send-mobile-otp', [GymUserControllerApi::class, 'sendMobileOtp']);

Route::post('/send-email-otp', [GymUserControllerApi::class, 'sendEmailOtp']);

Route::post('/verify-mobile-otp', [GymUserControllerApi::class, 'verifyMobileOtp']);

Route::post('/verify-email-otp', [GymUserControllerApi::class, 'verifyEmailOtp']);

Route::post('/gym-user-login', [GymUserLoginControllerApi::class, 'userLogin']);

Route::get('/fetch-measurement', [SiteSettingControllerApi::class, 'fetchMeasurement']);

Route::post('/register-gym-user', [GymUserControllerApi::class, 'registerGymUser']);

Route::post('/verify-otp', [GymUserControllerApi::class, 'verifyOtp']);

Route::post('/profile-part-four-updated', [GymUserControllerApi::class, 'profilePartFour']);

Route::post('/add-user-injuries', [GymUserControllerApi::class, 'addUserInjuries']);


Route::post('/email-login', [GymUserLoginControllerApi::class, 'loginWithEmail']);

Route::middleware('auth:api')->group(function () {

    Route::post('/send-inquiry', [UserInquiryControllerApi::class, 'sendInquiry']);

    Route::post('/fetch-inquiry', [UserInquiryControllerApi::class, 'fetchInquiry']);  
    
    Route::get('/fetch-inquiry-reason', [UserInquiryControllerApi::class, 'fetchInquiryReason']);
   
    
    Route::get('/logout', [GymUserControllerApi::class, 'userLogout']);
    
    Route::post('/diet-anlytics', [DietAnalyticControllerApi::class, 'fetchUserDietAnalytic']);

    Route::get('/fetch-advertisement', [AdvertisementControllerApi::class, 'fetchAdvertisement']);

    Route::post('/response', [UserSubscriptionControllerApi::class, 'response']);
    
    Route::post('/workout-anlytics', [UserWorkoutAnalyticApi::class, 'fetchUserWorkoutAnalytic']);

    Route::post('/get-home-page-data', [HomeControllerApi::class, 'fetchAdvertisementAndAttendance']);

    Route::post('/get-user-attendence', [GymUserAttendenceControllerApi::class, 'getUserAttendance']);

    Route::post('/mark-user-attendence', [GymUserAttendenceControllerApi::class, 'markAttendance']);

    Route::post('/update-daily-diet-status', [UserDietControllerApi::class, 'updateUserDietStatus']);

    Route::post('/update-daily-workout-status', [UserWorkoutControllerApi::class, 'updateCurrentWorkout']);

    Route::post('/update-gym-user-profile', [GymUserControllerApi::class, 'updateGymUserProfile']);

    Route::post('/fetch-users-current-workout-details', [UserWorkoutControllerApi::class, 'fetchCurrentDayWorkout']);

    Route::post('/fetch-subscription', [UserSubscriptionControllerApi::class, 'fetchSubscription']);

    Route::post('/fetch-subscription-histry', [UserSubscriptionControllerApi::class, 'fetchSubscriptionHistry']);

    Route::post('/fetch-user-diets', [UserDietControllerApi::class, 'fetchUserDiet']);

    Route::post('/fetch-user-workout', [UserWorkoutControllerApi::class, 'fetchUserWorkout']);

    Route::get('/fetch-user-gym', [GymUserControllerApi::class, 'fetchUserGym']);

    Route::get('/fetch-equipments', [EquipmentControllerApi::class, 'fetchEquipments']);

    Route::get('/fetch-suppliments', [SupplimentControllerApi::class, 'fetchSuppliments']);

    Route::get('/fetch-reels', [ReelControllerApi::class, 'fetchReels']);

    Route::post('/fetch-trainer', [GymUserTrainerControllerApi::class, 'fetchUserTrainer']);

    Route::post('/fetch-gym-details', [GymDetailControllerApi::class, 'fetchGymDetails']);

    Route::post('/fetch-gym-gallery', [GymGalleryControllerApi::class, 'fetchGallery']);

    Route::post('/fetch-workout-count', [UserWorkoutControllerApi::class, 'fetchTotalCompletedCounts']);

    Route::get('/fetch-user-detail', [GymUserControllerApi::class, 'fetchUserDetails']);

    Route::post('/change-email-or-phone', [GymUserControllerApi::class, 'updateEmailOrPhoneNo']);

    Route::post('/fetch-user-bmis', [UserBmiControllerApi::class, 'getUserBmis']);

    Route::post('/fetch-user-bmi-detail', [UserBmiControllerApi::class, 'getUserBmiDetails']);

    Route::post('/fetch-workout-analytic', [UserWorkoutAnalyticApi::class, 'fetchUserAnalytic']);

    Route::post('/add-fcm-token', [FcmTokenControllerApi::class, 'addUserFcmToken']);
});


Route::post('/phonepe-callback', [UserSubscriptionControllerApi::class, 'phonePeCallback']);

Route::post('/check-email', [HomeUserLoginControllerApi::class, 'checkEmail'])->name('checkEmail');
