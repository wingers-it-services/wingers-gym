<?php

use App\Http\Controllers\GoalControllerApi;
use App\Http\Controllers\GymUserControllerApi;
use App\Http\Controllers\GymUserLoginControllerApi;
use App\Http\Controllers\LocationControllerApi;
use App\Http\Controllers\SiteSettingControllerApi;
use App\Http\Controllers\UserDietControllerApi;
use App\Http\Controllers\UserInjuryControllerApi;
use App\Http\Controllers\UserLevelControllerApi;
use App\Http\Controllers\UserSubscriptionControllerApi;
use App\Http\Controllers\UserWorkoutControllerApi;
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

Route::middleware('auth:api')->group(function () {

    Route::post('/fetch-subscription', [UserSubscriptionControllerApi::class, 'fetchSubscription']);

    Route::post('/fetch-user-diets', [UserDietControllerApi::class, 'fetchUserDiet']);
    
    Route::post('/fetch-user-workout', [UserWorkoutControllerApi::class, 'fetchUserWorkout']);

    Route::get('/fetch-user-gym', [GymUserControllerApi::class, 'fetchUserGym']);


});
