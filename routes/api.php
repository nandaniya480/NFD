<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\api\v1'], function ($api) {
    $api->post('register', 'HomeController@signUp');
    $api->post('login', 'HomeController@signIn');
    $api->post('forgot-password', 'HomeController@forgotPassword');
    $api->post('resend-otp', 'HomeController@resendOtp');
    $api->post('verify-otp', 'HomeController@verifyOtp');
    $api->post('reset-password', 'HomeController@resetPassword');

    Route::group(['middleware' => ['auth:sanctum', 'verified']], function ($auth) {
        $auth->post('logout', 'HomeController@logOut');
        $auth->get('get-user', 'HomeController@getUser');
    });
});
