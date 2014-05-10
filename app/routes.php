<?php

Route::get( '/', 'FrontController@index' );

Route::get( 'signup', 'UserController@create' );
Route::post( 'signup', 'UserController@store' );
Route::get( 'login', 'UserController@login' );
Route::post( 'login', 'UserController@doLogin' );
Route::get( 'logout', 'UserController@logout' );
Route::get( 'forgot-password', 'UserController@forgotPassword' );
Route::post( 'forgot-password', 'UserController@doForgotPassword' );
Route::get( 'reset-password/{token}', 'UserController@resetPassword' );
Route::get( 'reset-password', function () {
  return Redirect::action( 'UserController@forgotPassword' );
});
Route::post( 'reset-password', 'UserController@doResetPassword' );

// Actions reserved for logged-in users
Route::group( [ 'before' => 'auth' ], function () {

  Route::resource( 'campaign', 'CampaignController' );

});