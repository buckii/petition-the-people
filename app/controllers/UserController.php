<?php

class UserController extends BaseController {

  public function dashboard() {
    return View::make( 'user.dashboard' );
  }

  public function create() {
    return View::make( Config::get( 'confide::signup_form' ) );
  }

  public function store() {
    $user = new User;
    $password = Input::get( 'password' );

    $user->username = Input::get( 'username' );
    $user->email = Input::get( 'email' );
    $user->password = $password;

    // The password confirmation will be removed from model
    // before saving. This field will be used in Ardent's
    // auto validation.
    $user->password_confirmation = Input::get( 'password_confirmation' );

    // Save if valid. Password field will be hashed before save
    $user->save();

    if ( $user->id ) {

      if ( Auth::attempt( [ 'email' => $user->email, 'password' => $password ], true ) ) {
        return Redirect::action( 'CampaignController@index' )->with( 'success', trans( 'user.msg_create_success' ) );
      } else {
        return Redirect::action( 'UserController@login' )->with( 'error', trans( 'user.msg_unable_to_auto_login' ) );
      }

    } else {
      return Redirect::back()->withInput( Input::except( 'password' ) )->withErrors( $user->errors() );
    }
  }

  public function login() {
    if ( Confide::user() ) {
      return Redirect::action( 'UserController@dashboard' );
    } else {
      return View::make( Config::get( 'confide::login_form' ) );
    }
  }

  public function doLogin() {
    $input = array(
      'email' => Input::get( 'username' ),
      'username' => Input::get( 'username' ),
      'password' => Input::get( 'password' ),
      'remember' => Input::get( 'remember' )
    );

    if ( Confide::logAttempt( $input, Config::get('confide::signup_confirm' ) ) ) {
      return Redirect::intended( '/campaign' );

    } else {
      $user = new User;

      return Redirect::action( 'UserController@login' )
        ->withInput( Input::except( 'password' ) )
        ->withErrors( [ trans( ( Confide::isThrottled( $input ) ? 'user.msg_login_throttled' : 'user.msg_invalid_credentials' ) ) ] );
    }
  }

  public function forgotPassword() {
    return View::make( Config::get( 'confide::forgot_password_form' ) )->with( 'email_sent', false );
  }

  public function doForgotPassword() {
    $email = Input::get( 'email' );

    if ( Confide::forgotPassword( $email ) ) {
      return View::make( Config::get( 'confide::forgot_password_form' ) )
        ->with( [ 'email_sent' => true, 'email' => $email ] );

    } else {
      return View::make( Config::get( 'confide::forgot_password_form' ) )
        ->withInput()
        ->with( 'email_sent', false )
        ->withErrors( [ trans( 'user.msg_forgot_password_account_not_found', [ 'email' => $email ] ) ] );
    }
  }

  public function resetPassword( $token ) {
    return View::make( Config::get( 'confide::reset_password_form' ) )->with( 'token', $token );
  }

  public function doResetPassword() {
    $input = array(
      'token' => Input::get( 'token' ),
      'password' => Input::get( 'password' ),
      'password_confirmation' => Input::get( 'password_confirmation' )
    );

    if ( Confide::resetPassword( $input ) ) {
      return Redirect::action( 'UserController@login' )
        ->with( 'success', trans( 'user.msg_reset_password_successful' ) );

    } else {
      return Redirect::back()
        ->withErrors( [ trans( 'user.msg_reset_password_error' ) ] )
        ->with( 'token', $input['token'] );
    }
  }

  public function logout() {
    Confide::logout();
    return Redirect::to('/');
  }

}
