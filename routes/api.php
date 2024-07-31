<?php

use App\Http\Controllers\GoalControllerApi;
use App\Http\Controllers\LocationControllerApi;
use App\Http\Controllers\UserInjuryControllerApi;
use App\Http\Controllers\UserLevelControllerApi;
use Illuminate\Support\Facades\Route;

Route::get('/fetch-goal', [GoalControllerApi::class, 'fetchGoal'])->name('fetchGoal');

Route::get('/fetch-level', [UserLevelControllerApi::class, 'fetchLevel'])->name('fetchLevel');

Route::get('/fetch-user-injury', [UserInjuryControllerApi::class, 'fetchUserInjury'])->name('fetchUserInjury');

Route::get('/fetch-country-list', [LocationControllerApi::class, 'fetchCountryList']);

Route::post('/fetch-state-list', [LocationControllerApi::class, 'fetchStateList']);

Route::post('/fetch-city-list', [LocationControllerApi::class, 'fetchCityList']);