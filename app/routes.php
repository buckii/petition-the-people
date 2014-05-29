<?php

Route::get( '/', 'FrontController@index' );
Route::get( 'about', array( 'as' => 'about', function () {
  return View::make( 'front.default' )->with('page', 'about');
}));

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

Route::get( 'petition/search', 'PetitionController@search' );

Route::get( 'campaigns/{username}/{slug}', 'CampaignController@showPublic' );

// Actions reserved for logged-in users
Route::group( [ 'before' => 'auth' ], function () {

  Route::get( 'campaign/slug-check', 'CampaignController@slugUniquenessCheck' );

  Route::resource( 'campaign', 'CampaignController' );
  Route::resource( 'signature', 'SignatureController' );

});

// Error pages
if ( ! Config::get( 'app.debug' ) ) {
  App::error( function ( $exception, $code ) {
    return Response::view( 'front.default', array( 'page' => ( Lang::has( 'front.' . $code ) ? $code : 'error' ) ) );
  });
}